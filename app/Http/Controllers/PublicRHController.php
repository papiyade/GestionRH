<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salaire;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicRHController extends Controller
{
    public function index()
    {
        $employees = Employee::with('salaire')
            ->where('entreprise_id', Auth::user()->entreprise_id)
            ->latest()
            ->paginate(15);

        return view('rh.index', compact('employees'));

    }

    // Voir détails d'un employé
    public function show(Employee $employee)
    {
        $employee->load('salaire');

        return view('rh.show', compact('employee'));
    }

    // Éditer un employé
    public function edit(Employee $employee)
    {
        return view('rh.edit', compact('employee'));
    }

    // Mettre à jour un employé
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'residence_actuelle' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'fiche_poste' => 'required|string|max:255',
            'statut' => 'required|in:en_attente,validé,rejeté',
        ]);

        $employee->update($validated);

        return redirect()->route('rh.show', $employee)
            ->with('success', 'Fiche employé mise à jour avec succès.');
    }

    // Supprimer un employé
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('rh.index')
            ->with('success', 'Fiche employé supprimée avec succès.');
    }

    // Formulaire de saisie du salaire
public function editSalaire(Employee $employee)
{
    // On récupère l'entreprise pour l'indemnité de transport
    $entreprise = $employee->entreprise;

    // Récupération du détail RH de l'employé
    $detail = $employee->user->employeeDetail ?? null;

    return view('rh.salaire', compact('employee', 'detail', 'entreprise'));
}


    // Enregistrer le salaire
public function storeSalaire(Request $request, Employee $employee)
{
    $validated = $request->validate([
        'salaire_base' => 'required|numeric|min:0',
        'prime' => 'nullable|numeric|min:0',
        'sursalaire' => 'nullable|numeric|min:0',
        'deductions' => 'nullable|numeric|min:0',
        'caisse_css' => 'nullable|numeric|min:0',
        'ipm' => 'nullable|numeric|min:0',
        'ir' => 'nullable|numeric|min:0',
        'trimf' => 'nullable|numeric|min:0',
        'date_effet' => 'required|date',
        'indemnite_transport' => 'nullable|numeric|min:0', // global pour l'entreprise
    ]);

    // Enregistrer le nouveau salaire
    $salaire = $employee->salaires()->create([
        'salaire_base' => $validated['salaire_base'],
        'prime' => $validated['prime'] ?? 0,
        'deductions' => $validated['deductions'] ?? 0,
        'date_effet' => $validated['date_effet'],
    ]);

    // Mise à jour des infos RH (employee_details)
    $detail = $employee->user->employeeDetail;
    if ($detail) {
        $detail->update([
            'salaire' => $validated['salaire_base'],
            'sursalaire' => $validated['sursalaire'] ?? 0,
            'caisse_css' => $validated['caisse_css'] ?? 0,
            'ipm_assurance' => $validated['ipm'] ?? 0,
            'ir' => $validated['ir'] ?? 0,
            'trimf' => $validated['trimf'] ?? 0,
        ]);
    }

    // Mise à jour de l'indemnité de transport globale (si fourni)
    if (!empty($validated['indemnite_transport']) && $employee->entreprise) {
        $employee->entreprise->update([
            'indemnite_transport' => $validated['indemnite_transport'],
        ]);
    }

    return redirect()->route('rh.show', $employee)
        ->with('success', 'Salaire et informations RH enregistrés avec succès.');
}



    // Générer le bulletin de salaire en PDF
    public function generateBulletin(Employee $employee)
    {
        if (! $employee->salaire) {
            return redirect()->back()
                ->with('error', 'Aucun salaire défini pour cet employé.');
        }

        $data = [
            'employee' => $employee,
            'salaire' => $employee->salaire,
            'date' => now(),
        ];

        $pdf = Pdf::loadView('rh.bulletin-pdf', $data);

        return $pdf->download('bulletin_'.$employee->nom.'_'.$employee->prenom.'.pdf');
    }

    // Générer la fiche employé en PDF
public function generateFiche(Employee $employee)
{
    // Charger toutes les relations comme pour la prévisualisation
    $employee->load(['entreprise', 'user.employeeDetail', 'salaires']);
    $detail = $employee->user->employeeDetail;
    $dernierSalaire = $employee->salaires()->latest('date_effet')->first();

    $salaireBase = $detail->salaire ?? 0;
    $sursalaire  = $detail->sursalaire ?? 0;
    $prime       = $dernierSalaire->prime ?? 0;
    $indemnite   = $detail->indemnite ?? 0;
    $deductions  = $dernierSalaire->deductions ?? 0;

    $indemniteTransport = $detail->indemnite_transport 
        ?? $employee->entreprise->indemnite_transport 
        ?? 0;

    $brut = $salaireBase + $sursalaire + $prime + $indemnite;

    $taux = [
        'ipres_regime_general' => ['salarial' => $detail->ipres_salariale ?? 5.6, 'patronal' => $detail->ipres_patronale ?? 8.4],
        'ipres_regime_complementaire' => ['salarial' => $detail->ipresc_salariale ?? 2.4, 'patronal' => $detail->ipresc_patronale ?? 3.6],
        'css' => ['salarial' => $detail->caisse_css ?? 6, 'patronal' => 0],
        'accident_travail' => ['salarial' => 0, 'patronal' => $detail->accident_travail ?? 3],
        'prestation_famille' => ['salarial' => 0, 'patronal' => $detail->prestation_famille ?? 7],
        'ipm' => ['salarial' => $detail->ipm ?? 1, 'patronal' => $detail->ipm ?? 1],
        'cfce' => ['salarial' => 0, 'patronal' => $detail->cfce ?? 3],
    ];

    $plafond_css = 63000;
    $base_css = min($brut, $plafond_css);

    $cotisations = [
        'ipres_regime_general' => ['salariale' => $brut * $taux['ipres_regime_general']['salarial']/100, 'patronale' => $brut * $taux['ipres_regime_general']['patronal']/100],
        'ipres_regime_complementaire' => ['salariale' => $brut * $taux['ipres_regime_complementaire']['salarial']/100, 'patronale' => $brut * $taux['ipres_regime_complementaire']['patronal']/100],
        'css' => ['salariale' => $base_css * $taux['css']['salarial']/100, 'patronale' => $base_css * $taux['css']['patronal']/100],
        'accident_travail' => ['salariale' => 0, 'patronale' => $brut * $taux['accident_travail']['patronal']/100],
        'prestation_famille' => ['salariale' => 0, 'patronale' => $brut * $taux['prestation_famille']['patronal']/100],
        'ipm' => ['salariale' => $brut * $taux['ipm']['salarial']/100, 'patronale' => $brut * $taux['ipm']['patronal']/100],
        'cfce' => ['salariale' => 0, 'patronale' => $brut * $taux['cfce']['patronal']/100],
    ];

    $totalSalariale = collect($cotisations)->sum('salariale') + ($detail->ir ?? 0) + ($detail->trimf ?? 0);
    $totalPatronale = collect($cotisations)->sum('patronale');
    $net = $brut - $totalSalariale + $indemniteTransport;

    return \PDF::loadView('rh.fiche-pdf', compact(
        'employee', 'detail', 'dernierSalaire', 'salaireBase', 'sursalaire', 'prime', 'indemnite',
        'indemniteTransport', 'deductions', 'brut', 'net', 'taux', 'cotisations', 'totalSalariale', 'totalPatronale'
    ))->setPaper('A4')->stream("FichePaie-{$employee->nom_complet}.pdf");
}



public function previewFiche(Employee $employee)
{
    // Charger relations nécessaires
    $employee->load(['entreprise', 'user.employeeDetail', 'salaires']);
    $detail = $employee->user->employeeDetail;
    $dernierSalaire = $employee->salaires()->latest('date_effet')->first();

    // Montants de base
    $salaireBase = $detail->salaire ?? 0;
    $sursalaire  = $detail->sursalaire ?? 0;
    $prime       = $dernierSalaire->prime ?? 0;
    $indemnite   = $detail->indemnite ?? 0;
    $deductions  = $dernierSalaire->deductions ?? 0;

    // Indemnité de transport (depuis employé ou entreprise)
    $indemniteTransport = $detail->indemnite_transport 
        ?? $employee->entreprise->indemnite_transport 
        ?? 0;

    // Salaire brut
    $brut = $salaireBase + $sursalaire + $prime + $indemnite;

    // Taux cotisations
    $taux = [
        'ipres_regime_general'        => ['salarial' => $detail->ipres_salariale ?? 5.6, 'patronal' => $detail->ipres_patronale ?? 8.4],
        'ipres_regime_complementaire' => ['salarial' => $detail->ipresc_salariale ?? 2.4, 'patronal' => $detail->ipresc_patronale ?? 3.6],
        'css'                         => ['salarial' => $detail->caisse_css ?? 6, 'patronal' => 0],
        'accident_travail'            => ['salarial' => 0, 'patronal' => $detail->accident_travail ?? 3],
        'prestation_famille'          => ['salarial' => 0, 'patronal' => $detail->prestation_famille ?? 7],
        'ipm'                         => ['salarial' => $detail->ipm ?? 1, 'patronal' => $detail->ipm ?? 1],
        'cfce'                        => ['salarial' => 0, 'patronal' => $detail->cfce ?? 3],
    ];

    // Plafond CSS
    $plafond_css = 63000;
    $base_css = min($brut, $plafond_css);

    // Calcul des cotisations
    $cotisations = [
        'ipres_regime_general' => ['salariale' => $brut * $taux['ipres_regime_general']['salarial']/100, 'patronale' => $brut * $taux['ipres_regime_general']['patronal']/100],
        'ipres_regime_complementaire' => ['salariale' => $brut * $taux['ipres_regime_complementaire']['salarial']/100, 'patronale' => $brut * $taux['ipres_regime_complementaire']['patronal']/100],
        'css' => ['salariale' => $base_css * $taux['css']['salarial']/100, 'patronale' => $base_css * $taux['css']['patronal']/100],
        'accident_travail' => ['salariale' => 0, 'patronale' => $brut * $taux['accident_travail']['patronal']/100],
        'prestation_famille' => ['salariale' => 0, 'patronale' => $brut * $taux['prestation_famille']['patronal']/100],
        'ipm' => ['salariale' => $brut * $taux['ipm']['salarial']/100, 'patronale' => $brut * $taux['ipm']['patronal']/100],
        'cfce' => ['salariale' => 0, 'patronale' => $brut * $taux['cfce']['patronal']/100],
    ];

    // Totaux cotisations
    $totalSalariale = collect($cotisations)->sum('salariale') + ($detail->ir ?? 0) + ($detail->trimf ?? 0);
    $totalPatronale = collect($cotisations)->sum('patronale');

    // Net à payer
    $net = $brut - $totalSalariale + $indemniteTransport;

    // Rubriques personnalisées
    $rubriquesSoumises = array_filter(explode(',', $detail->rubrique_soumise ?? ''));
    $rubriquesNonSoumises = array_filter(explode(',', $detail->rubrique_non_soumise ?? ''));

    return view('rh.fiche-preview', compact(
        'employee', 'detail', 'dernierSalaire', 'salaireBase', 'sursalaire', 'prime', 'indemnite', 'indemniteTransport', 'deductions',
        'brut', 'net', 'taux', 'cotisations', 'totalSalariale', 'totalPatronale', 'rubriquesSoumises', 'rubriquesNonSoumises', 'plafond_css'
    ));
}






}
