<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeDetail;

class EmployeeDetailController extends Controller
{
    //

  public function show($id)
{
  $user = User::with(['employeeDetail', 'employeeDocuments'])->findOrFail($id);


    return view('rh.employe.employe_detail', compact('user'));
}


    public function store(Request $request)
{
    // Validation des données reçues
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'matricule' => 'required|string|max:255|unique:employee_details,matricule',
        'salaire' => 'nullable|numeric|min:0',
        'type_contrat' => 'required|string|max:255',
        'description_poste' => 'nullable|string',
        'date_naissance' => 'required|date',
        'date_debut' => 'required|date',
        'date_fin' => 'nullable|date|after_or_equal:date_debut',
        'adresse' => 'nullable|string|max:255',
        'genre' => 'nullable|string|max:50',
    ]);

    // Vérifier si un détail existe déjà pour cet utilisateur
    if (EmployeeDetail::where('user_id', $validated['user_id'])->exists()) {
        return redirect()->back()->withErrors(['error' => 'Détail RH déjà existant pour cet utilisateur.']);
    }

    // Création du détail employé
    EmployeeDetail::create([
        'user_id' => $validated['user_id'],
        'matricule' => $validated['matricule'],
        'salaire' => $validated['salaire'],
        'type_contrat' => $validated['type_contrat'],
        'description_poste' => $validated['description_poste'],
        'date_naissance' => $validated['date_naissance'],
        'date_debut' => $validated['date_debut'],
        'date_fin' => $validated['date_fin'],
        'adresse' => $validated['adresse'],
    ]);

    // Retour avec message de succès
    return redirect()->back()->with('success_detail', 'Détail RH ajouté avec succès.');
}
}
