<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Models\Prestation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PrestationsMensuellesExport;
use Maatwebsite\Excel\Facades\Excel;

class PrestataireController extends Controller
{
    //
    // Liste des prestataires de l'entreprise
public function index()
{
    $entrepriseId = Auth::user()->entreprise_id;

    // Liste des prestataires de l'entreprise
    $prestataires = Prestataire::where('entreprise_id', $entrepriseId)->get();

    // Total des prestataires de l'entreprise
    $totalPrestataires = $prestataires->count();

    $mois = now()->month;
    $annee = now()->year;

    // Total des prestations pour le mois courant
    $totalPrestationsMois = Prestation::whereHas('prestataire', function ($query) use ($entrepriseId) {
        $query->where('entreprise_id', $entrepriseId);
    })
    ->whereMonth('date', $mois)
    ->whereYear('date', $annee)
    ->count();

    // Montant total des prestations pour le mois courant
    $montantTotalMois = Prestation::whereHas('prestataire', function ($query) use ($entrepriseId) {
        $query->where('entreprise_id', $entrepriseId);
    })
    ->whereMonth('date', $mois)
    ->whereYear('date', $annee)
    ->sum('montant');

    $stats = [
        'total_prestataires' => $totalPrestataires,
        'total_prestations_mois' => $totalPrestationsMois,
        'montant_total_mois' => $montantTotalMois,
    ];

    return view('rh.prestataires.index', compact('prestataires', 'stats'));
}

    // Formulaire création prestataire
    public function create()
    {
        return view('rh.prestataires.create');
    }

    // Enregistrement prestataire
    public function store(Request $request)
    {
        $entrepriseId = Auth::user()->entreprise_id;

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:prestataires',
            'type_contrat' => 'nullable|string|max:255',
        ]);

        $validated['entreprise_id'] = $entrepriseId;

        Prestataire::create($validated);

        return redirect()->route('rh.prestataires.index')
            ->with('success', 'Prestataire ajouté avec succès');
    }

    // Affichage prestations mensuelles
    public function prestationsMensuelles(Request $request)
    {
        $mois = $request->input('mois', date('m'));
        $annee = $request->input('annee', date('Y'));
        $entrepriseId = Auth::user()->entreprise_id;

        // Récupérer les prestations du mois pour les prestataires de l'entreprise
        $prestations = \App\Models\Prestation::whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->whereHas('prestataire', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->with('prestataire')
            ->get();

        return view('rh.prestataires.prestations_mensuelles', compact('prestations', 'mois', 'annee'));
    }

    // Affichage formulaire pour saisir les prestations
    public function createPrestations(Request $request)
    {
        $entrepriseId = Auth::user()->entreprise_id;
        $mois = $request->input('mois', date('m'));
        $annee = $request->input('annee', date('Y'));

        $prestataires = Prestataire::where('entreprise_id', $entrepriseId)->get();

        return view('rh.prestataires.create_prestations', compact('prestataires', 'mois', 'annee'));
    }

    // Enregistrement prestations
public function storePrestations(Request $request)
{
    $validated = $request->validate([
        'prestataires' => 'required|array',
        'prestataires.*.id' => 'required|exists:prestataires,id',
        'prestataires.*.montant' => 'required|numeric|min:0',
        'mois' => 'required|numeric|min:1|max:12',
        'annee' => 'required|numeric|min:2000',
    ]);

    foreach ($validated['prestataires'] as $p) {
        $moisInt = (int) $validated['mois'];
        $anneeInt = (int) $validated['annee'];

        // Crée une date au 1er jour du mois
        $date = \Carbon\Carbon::create($anneeInt, $moisInt, 1);

        // Calcul du BRS (5 % du montant)
        $brs = round($p['montant'] * 0.05, 2); // arrondi à 2 décimales

        // Si la prestation existe déjà, on met à jour, sinon on crée
        \App\Models\Prestation::updateOrCreate(
            ['prestataire_id' => $p['id'], 'date' => $date],
            [
                'montant' => $p['montant'],
                // On ne stocke pas le BRS, mais tu peux le logguer ou le transmettre à la vue si besoin
            ]
        );
    }

    // ✅ On peut ajouter un message d'information avec le total des BRS calculés
    $totalBrs = collect($validated['prestataires'])->sum(function ($p) {
        return $p['montant'] * 0.05;
    });

    return redirect()
        ->route('rh.prestataires.prestations', [
            'mois' => $validated['mois'],
            'annee' => $validated['annee']
        ])
        ->with('success', 'Prestations du mois enregistrées avec succès. Total BRS estimé : ' . number_format($totalBrs, 0, ',', ' ') . ' XOF');
}

// Export prestations mensuelles
public function exportPrestations($mois, $annee)
{
    $fileName = "prestations_{$mois}_{$annee}.xlsx";
    return Excel::download(new PrestationsMensuellesExport($mois, $annee), $fileName);
}

}
