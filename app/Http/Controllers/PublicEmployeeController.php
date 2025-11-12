<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\EmployeeDetail;
use App\Models\EmployeeDocument;


class PublicEmployeeController extends Controller
{
    // Afficher le formulaire public
    public function create($id)
    {
        $entreprise = Entreprise::findOrFail($id); // OK si URL = /employees/renseignement-infos/{id}

        return view('employees.create', compact('entreprise'));
    }

public function store(Request $request, $id)
{
    $entreprise = Entreprise::findOrFail($id);

    // Validation
    $validated = $request->validate([
        'prenom' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'adresse' => 'required|string',
        'date_naissance' => 'required|date',
        'lieu_naissance' => 'required|string|max:255',
        'residence_actuelle' => 'required|string',
        'certificat_residence' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'photocopie_identite' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'extrait_naissance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'fiche_dotation_materiels' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'telephone' => 'required|string|max:20',
        'email' => 'required|email|unique:employees,email|unique:users,email',
        'certificat_mariage' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'extraits_naissance_enfants.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'fiche_poste' => 'required|string|max:255',
    ]);

    $fileFields = [
        'certificat_residence',
        'photocopie_identite',
        'extrait_naissance',
        'fiche_dotation_materiels',
        'certificat_mariage',
    ];

    // Gestion des fichiers simples
    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $destinationPath = public_path('documents');
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0777, true);
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $validated[$field] = 'documents/' . $filename;
        }
    }

    // Gestion des fichiers multiples pour enfants
    if ($request->hasFile('extraits_naissance_enfants')) {
        $enfantsDocs = [];
        $destinationPath = public_path('documents/enfants');
        if (!file_exists($destinationPath)) mkdir($destinationPath, 0777, true);

        foreach ($request->file('extraits_naissance_enfants') as $file) {
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $enfantsDocs[] = 'documents/enfants/' . $filename;
        }
        $validated['extraits_naissance_enfants'] = json_encode($enfantsDocs);
    }

    $validated['entreprise_id'] = $entreprise->id;

    // Étape 1 : créer l'employé
    $employee = Employee::create($validated);

    // Étape 2 : créer le user
    $user = User::create([
        'name' => ucfirst($validated['prenom']) . ' ' . strtoupper($validated['nom']),
        'email' => $validated['email'],
        'telephone' => $validated['telephone'],
        'adresse' => $validated['adresse'],
        'entreprise_id' => $entreprise->id,
        'role' => 'employe',
        'password' => Hash::make('temporaire123'),
    ]);

    // Étape 3 : lier employee → user
    $employee->update(['user_id' => $user->id]);

    // Étape 4 : créer le detail RH automatiquement
    EmployeeDetail::create([
        'user_id' => $user->id,
        'matricule' => 'EMP-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
        'date_naissance' => $employee->date_naissance,
        'adresse' => $employee->adresse,
        'telephone' => $employee->telephone,
        'description_poste' => $employee->fiche_poste,
        'type_contrat' => 'Non défini',
        'genre' => $request->input('genre', null),
    ]);

    // Étape 5 : créer les documents associés
    $allFileFields = array_merge($fileFields, ['extraits_naissance_enfants']);
    foreach ($allFileFields as $field) {
        if (!empty($validated[$field])) {
            if ($field === 'extraits_naissance_enfants') {
                foreach (json_decode($validated[$field], true) as $filePath) {
                    EmployeeDocument::create([
                        'user_id' => $user->id,
                        'type_document' => $field,
                        'file_path' => $filePath,
                    ]);
                }
            } else {
                EmployeeDocument::create([
                    'user_id' => $user->id,
                    'type_document' => $field,
                    'file_path' => $validated[$field],
                ]);
            }
        }
    }

    return redirect()->route('rh.employees.create', ['id' => $entreprise->id])
        ->with('success', 'Votre fiche a été soumise avec succès. Le service RH vous contactera bientôt.');
}


}
