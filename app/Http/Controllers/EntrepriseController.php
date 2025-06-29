<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class EntrepriseController extends Controller
{
    //
    public function store(Request $request)
{
    $validated = $request->validate([
        'logo_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'entreprise_name' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'description' => 'required|string',
    ]);

    $validated['id_user'] = auth()->id(); // <-- user connecté

    if ($request->hasFile('logo_path')) {
        $path = $request->file('logo_path')->store('logos', 'public');
        $validated['logo_path'] = $path;
    }

    Entreprise::create($validated);

     return redirect()
        ->route('admin_simple')
        ->with('success', '✅ Entreprise créée avec succès !');
}

public function edit()
{
    $userId = Auth::id();
    $entreprise = Entreprise::where('id_user', $userId)->firstOrFail();

    return view('admin.entreprises.edit', compact('entreprise'));
}

public function update(Request $request)
{
    $validated = $request->validate([
        'entreprise_name' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'description' => 'required|string',
        'logo_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $userId = Auth::id();
    $entreprise = Entreprise::where('id_user', $userId)->firstOrFail();

    // Si un logo est uploadé
    if ($request->hasFile('logo_path')) {
        $file = $request->file('logo_path');
        $path = $file->store('logos', 'public');
        $validated['logo_path'] = $path;
    }

    $entreprise->update($validated);

    return redirect()->back()->with('success', 'Entreprise mise à jour avec succès');
}

public function redirectionEntreprise()
{
    $userId = Auth::id();

    $entreprise = Entreprise::where('id_user', $userId)->first();

    if ($entreprise) {
       
        return redirect()->route('entreprise.edit');
    } else {
      
        return redirect()->route('company');
    }
}

public function getEmployesPremiereEntreprise()
{
    $user = auth()->user();

    // Récupérer la première entreprise créée par l'utilisateur connecté (ordre par défaut)
    $premiereEntreprise = Entreprise::where('id_user', $user->id)->first();

    if (!$premiereEntreprise) {
        return redirect()->back()->with('error', 'Vous n’avez pas encore créé d’entreprise.');
    }

    // Récupérer les employés liés à cette entreprise
    $employes = User::where('entreprise_id', $premiereEntreprise->id)->get();

    return view('admin.users.index', compact('employes'));
}


}
