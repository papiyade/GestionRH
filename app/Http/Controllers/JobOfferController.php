<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;


class JobOfferController extends Controller
{
    //
    public function index()
{
    // On récupère les offres de l'entreprise connectée (ou toutes si besoin)
    $offres = JobOffer::where('entreprise_id', auth()->user()->entreprise_id)
                      ->orderBy('created_at', 'desc')
                      ->get();

    return view('rh.candidature.offre.index', compact('offres'));
}


    public function store(Request $request)
{
    // Validation des données du formulaire
    $validated = $request->validate([
        'jobTitle' => 'required|string|max:255',
        'jobTeam' => 'required|string|max:255',
        'jobSector' => 'nullable|string|max:255',
        'jobDescription' => 'required|string',
        'contractType' => 'required|string|in:CDI,CDD,Stage,Alternance,Freelance',
        'applicationDeadline' => 'required|date',
        'salaryAmount' => 'nullable|numeric',
        'salaryCurrency' => 'nullable|string|max:10',
        'salaryPeriod' => 'nullable|string|max:20',
        'experienceRequired' => 'required|string|max:50',
        'jobStatus' => 'required|string|in:En cours,Clôturé,Annulé',
        'remoteOption' => 'nullable',


    ]);

    // Création de l'offre d'emploi
    JobOffer::create([
        'entreprise_id' => auth()->user()->entreprise_id, // Liaison à l'entreprise du user connecté
        'titre' => $validated['jobTitle'],
        'equipe' => $validated['jobTeam'],
        'secteur' => $validated['jobSector'],
        'description' => $validated['jobDescription'],
        'type_contrat' => $validated['contractType'],
        'date_limite' => $validated['applicationDeadline'],
        'salaire' => $validated['salaryAmount'],
        'devise' => $validated['salaryCurrency'],
        'periode_salaire' => $validated['salaryPeriod'],
        'experience_requise' => $validated['experienceRequired'],
        'statut' => $validated['jobStatus'],
        'teletravail' => $request->has('remoteOption'),
    ]);

    return redirect()->back()->with('success', 'Offre créée avec succès.');
}
 /**
     * Affiche le formulaire d'édition d'une offre spécifique (pour AJAX).
     * @param JobOffer $offre
     * @return \Illuminate\Http\JsonResponse
     */

 public function edit(JobOffer $offre)
    {
        // Retourne les données de l'offre en JSON pour être utilisées par JavaScript
        return response()->json($offre);
    }

     /**
     * Met à jour une offre d'emploi spécifique.
     * @param Request $request
     * @param JobOffer $offre
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

public function update(Request $request, JobOffer $offre)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'equipe' => 'required|string|max:255',
            'description' => 'required|string',
            'type_contrat' => 'required|string|in:CDI,CDD,Stage,Alternance,Freelance',
            'date_limite' => 'required|date',
            'salaire' => 'nullable|numeric',
            'devise' => 'nullable|string|max:10',
            'periode_salaire' => 'nullable|string|in:monthly,annual',
            'experience_requise' => 'required|string|max:255',
            'statut' => 'required|string|in:En cours,Clôturé,Annulé',
            'secteur' => 'nullable|string|max:255',
            'teletravail' => 'boolean',
        ]);

        $offre->update($request->all());

        // Répondre en JSON pour les requêtes AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Offre mise à jour avec succès !']);
        }

        return redirect()->route('offres.index')->with('success', 'Offre d\'emploi mise à jour avec succès !');
    }

    /**
     * Met à jour le statut d'une offre d'emploi spécifique.
     * @param Request $request
     * @param JobOffer $offre
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, JobOffer $offre)
    {
        $request->validate([
            'status' => 'required|string|in:En cours,Clôturé,Annulé',
        ]);

        $offre->statut = $request->input('status');
        $offre->save();

        return response()->json(['success' => true, 'message' => 'Statut de l\'offre mis à jour.']);
    }

    /**
     * Supprime une offre d'emploi spécifique.
     * @param JobOffer $offre
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(JobOffer $offre)
    {
        $offre->delete();

        return response()->json(['success' => true, 'message' => 'Offre d\'emploi supprimée avec succès !']);
    }


   /**
     * Affiche la liste des offres d'emploi pour l'entreprise connectée.
     * Inclut un filtre de domaine basé sur le `secteur`.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function list_offer(Request $request): View|RedirectResponse
{
    $query = JobOffer::query();

    if (auth()->check() && auth()->user()->entreprise_id) {
        $query->where('entreprise_id', auth()->user()->entreprise_id);
    } else {
        return redirect('/login')->with('error', 'Vous devez être connecté et associé à une entreprise.');
    }

    if ($request->has('domaine') && $request->input('domaine') !== 'all') {
        $domaine = $request->input('domaine');
        $mappedSecteur = match ($domaine) {
            'web' => 'Informatique',
            'rh' => 'Ressources Humaines',
            'communication' => 'Communication',
            default => $domaine,
        };
        $query->where('secteur', $mappedSecteur);
    }

    $offres = $query->orderBy('created_at', 'desc')->get();

    foreach ($offres as $offre) {
        $dateLimite = \Carbon\Carbon::parse($offre->date_limite)->startOfDay();
        $aujourdHui = \Carbon\Carbon::now()->startOfDay();
        $diff = $aujourdHui->diffInDays($dateLimite, false);
        $joursRestants = max(0, $diff);

        $offre->joursRestants = $joursRestants;

        $offre->urgenceClass = match (true) {
            $joursRestants > 0 && $joursRestants <= 7 => 'text-danger',
            $joursRestants > 0 && $joursRestants <= 14 => 'text-warning',
            default => 'text-success',
        };

        $offre->badgeClass = match ($offre->type_contrat) {
            'CDI' => 'bg-success',
            'CDD' => 'bg-warning text-dark',
            'Stage' => 'bg-info',
            'Alternance' => 'bg-primary',
            'Freelance' => 'bg-secondary',
            default => 'bg-secondary',
        };

        $offre->domaineIcon = match ($offre->secteur) {
            'Informatique', 'Développement Web' => 'bi-code-slash',
            'Ressources Humaines', 'RH' => 'bi-people',
            'Communication' => 'bi-megaphone',
            default => 'bi-briefcase',
        };

        $offre->salaireDisplay = 'Non spécifié';
        if ($offre->salaire) {
            $offre->salaireDisplay = $offre->salaire . ' ' . ($offre->devise ?? '');
            if ($offre->periode_salaire) {
                $offre->salaireDisplay .= ' / ' . $offre->periode_salaire;
            }
        }

        $offre->formattedDateLimite = \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y');
    }

    $currentDomaineFilter = $request->input('domaine', 'all');

    return view('rh.candidature.candidat.list', compact('offres', 'currentDomaineFilter'));
}
public function showDetails($id)
{
    $jobOffer = JobOffer::findOrFail($id);

    $salaireDisplay = 'Non spécifié';
    if ($jobOffer->salaire) {
        $salaireDisplay = $jobOffer->salaire . ' ' . ($jobOffer->devise ?? '');
        if ($jobOffer->periode_salaire) {
            $salaireDisplay .= ' / ' . $jobOffer->periode_salaire;
        }
    }

    $dateLimite = \Carbon\Carbon::parse($jobOffer->date_limite)->startOfDay();
    $aujourdHui = \Carbon\Carbon::now()->startOfDay();
    $diff = $aujourdHui->diffInDays($dateLimite, false);
    $joursRestants = max(0, $diff);

    return response()->json([
        'id' => $jobOffer->id,
        'titre' => $jobOffer->titre,
        'domaine' => $jobOffer->secteur,
        'description' => $jobOffer->description,
        'date_limite' => $jobOffer->date_limite->format('Y-m-d'),
        'finDepot' => $jobOffer->date_limite->format('d/m/Y'),
        'typeContrat' => $jobOffer->type_contrat,
        'salaire' => $salaireDisplay,
        'experience' => $jobOffer->experience_requise,
        'teletravail' => $jobOffer->teletravail,
        'joursRestants' => $joursRestants
    ]);
}

public function depotform($id)
{
    $offre = JobOffer::findOrFail($id);
    return view('rh.candidature.candidat.depot-candidature', compact('offre'));
}

}
