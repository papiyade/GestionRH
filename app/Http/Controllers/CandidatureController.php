<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CandidatureController extends Controller
{
    public function store(Request $request, $jobOfferId)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'lettre' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'linkedin' => 'nullable',
            'message' => 'nullable|string',
            'disponibilite' => 'nullable|string|max:50',
            'pretention' => 'nullable|string|max:100',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');
        $lettrePath = $request->hasFile('lettre') ? $request->file('lettre')->store('lettres', 'public') : null;

        Candidature::create([
            'job_offer_id' => $jobOfferId,
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'linkedin' => $request->linkedin,
            'cv_path' => $cvPath,
            'lettre_path' => $lettrePath,
            'message' => $request->message,
            'disponibilite' => $request->disponibilite,
            'pretention' => $request->pretention,
            'status_demande' => 'En attente',
        ]);

        return redirect()->back()->with('success', 'Votre candidature a bien été envoyée.');
    }

    public function index(Request $request)
    {
        // Get filter values from the request
        $searchNom = $request->input('searchNom');
        $filtrePoste = $request->input('filtrePoste'); // This will be job_offer_id or title
        $filtreStatut = $request->input('filtreStatut');

        // Start building the query
        $query = Candidature::with('jobOffer'); // Eager load the related jobOffer

        // Apply search by candidate name (prenom or nom)
        if ($searchNom) {
            $query->where(function($q) use ($searchNom) {
                $q->where('prenom', 'like', '%' . $searchNom . '%')
                  ->orWhere('nom', 'like', '%' . $searchNom . '%');
            });
        }

        // Apply filter by job offer (poste)
        if ($filtrePoste && $filtrePoste !== 'all') {
            // Assuming filtrePoste will contain the actual job offer ID or title.
            // If it's the title, you'll need to join or use whereHas.
            // Let's assume the select option will pass the JobOffer ID for simplicity and efficiency.
            $query->whereHas('jobOffer', function ($q) use ($filtrePoste) {
                $q->where('id', $filtrePoste); // Filter by job_offer_id
            });
        }

        // Apply filter by application status
        if ($filtreStatut && $filtreStatut !== 'all') {
            $query->where('status_demande', $filtreStatut); // Assuming your column is 'status_demande'
        }

        // Order results, e.g., by latest application
        $candidatures = $query->latest()->get();

        // Get all distinct job offers to populate the filter dropdown
        $jobOffers = JobOffer::select('id', 'titre')->distinct()->get();


        return view('rh.candidature.offre.list-candidature', [
            'candidatures' => $candidatures,
            'jobOffers' => $jobOffers, // Pass job offers for the filter dropdown
            'currentSearchNom' => $searchNom,
            'currentFiltrePoste' => $filtrePoste,
            'currentFiltreStatut' => $filtreStatut,
        ]);
    }

    // This method will be used for the modal details
    public function show(Candidature $candidature)
    {
        // Eager load jobOffer to get its details
        $candidature->load('jobOffer');

        // Format dates and paths for front-end
        $formattedDate = $candidature->created_at->format('d/m/Y H:i');

        // Define status badge class based on your needs
        $badgeClass = '';
        switch ($candidature->status_demande) {
            case 'En attente':
                $badgeClass = 'badge-en_attente'; // Define these CSS classes
                break;
            case 'accepte':
                $badgeClass = 'badge-accepte';
                break;
            case 'rejete':
                $badgeClass = 'badge-rejete';
                break;
            default:
                $badgeClass = 'bg-secondary';
                break;
        }

        return response()->json([
            'id' => $candidature->id,
            'nom' => $candidature->nom,
            'prenom' => $candidature->prenom,
            'email' => $candidature->email,
            'telephone' => $candidature->telephone,
            'linkedin' => $candidature->linkedin,
            'cv_url' => asset('storage/' . $candidature->cv_path), // Use asset() helper for public storage
            'lettre_url' => $candidature->lettre_path ? asset('storage/' . $candidature->lettre_path) : null,
            'motivation' => $candidature->message,
            'disponibilite' => $candidature->disponibilite,
            'pretentions_salariales' => $candidature->pretention,
            'statut' => $candidature->status_demande,
            'statut_class' => $badgeClass,
            'date_candidature' => $formattedDate,

            // Job Offer details from the relationship
            'poste_titre' => $candidature->jobOffer->titre ?? 'N/A',
            'poste_contrat' => $candidature->jobOffer->type_contrat ?? 'N/A',
            'poste_equipe' => $candidature->jobOffer->equipe ?? 'N/A',
            'poste_description' => $candidature->jobOffer->description ?? 'N/A',
        ]);
    }


     public function accept(Candidature $candidature)
    {
        $candidature->update(['status_demande' => 'accepte']);


        return redirect()->back()->with('success', 'La candidature a été acceptée avec succès.');
    }

    public function reject(Candidature $candidature)
    {
        $candidature->update(['status_demande' => 'rejete']);


        return redirect()->back()->with('success', 'La candidature a été rejetée.');
    }


}

