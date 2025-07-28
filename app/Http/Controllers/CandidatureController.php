<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\CandidatureAccuse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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

    // Enregistrement de la candidature
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

    // Récupère le titre de l'offre
    $jobOffer = JobOffer::find($jobOfferId);

    // Envoi de l’accusé de réception
    Mail::to($request->email)->send(new CandidatureAccuse(
        $request->prenom,
        $request->nom,
        $jobOffer?->titre ?? 'Offre d\'emploi'
    ));

    return redirect()->back()->with('success', 'Votre candidature a bien été envoyée.');
}
   public function index(Request $request)
    {
       
        $entrepriseId = Auth::user()->entreprise_id;

        // Get filter values from the request
        $searchNom = $request->input('searchNom');
        $filtrePoste = $request->input('filtrePoste');
        $filtreStatut = $request->input('filtreStatut');

        // Start building the query, eager load jobOffer and filter by company ID
        $query = Candidature::with('jobOffer')
            ->whereHas('jobOffer', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            });

        // Apply search by candidate name (prenom or nom)
        if ($searchNom) {
            $query->where(function($q) use ($searchNom) {
                $q->where('prenom', 'like', '%' . $searchNom . '%')
                  ->orWhere('nom', 'like', '%' . $searchNom . '%');
            });
        }

        // Apply filter by job offer (poste)
        if ($filtrePoste && $filtrePoste !== 'all') {
            // Since we're already filtering by 'entreprise_id' in the main query,
            // we just need to add the specific job offer ID here.
            $query->where('job_offer_id', $filtrePoste);
        }

        // Apply filter by application status
        if ($filtreStatut && $filtreStatut !== 'all') {
            $query->where('status_demande', $filtreStatut);
        }

        // Order results, e.g., by latest application
        $candidatures = $query->latest()->get();

        // Get all distinct job offers for the *current user's company* to populate the filter dropdown
        $jobOffers = JobOffer::where('entreprise_id', $entrepriseId)
                             ->select('id', 'titre')
                             ->distinct()
                             ->get();

        return view('rh.candidature.offre.list-candidature', [
            'candidatures' => $candidatures,
            'jobOffers' => $jobOffers,
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

