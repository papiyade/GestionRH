<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;




class EntrepriseController extends Controller
{
    //

    public function index(Entreprise $entreprise) {
        $entreprises = Entreprise::all();
        $adminUser = User::find($entreprise->id_user);
        return view('superadmin.entreprise.index', compact('entreprises','entreprise','adminUser'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'logo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'entreprise_name' => 'required|string|max:255',
        'adresse' => 'nullable|string|max:255',
        'email' => 'required|email|max:255',
        'description' => 'nullable|string',
    ]);

    // Upload du logo (DOSSIER À LA RACINE DU PROJET)
    if ($request->hasFile('logo_path')) {

        $destinationPath = base_path('logos');

        // Créer le dossier si inexistant
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file = $request->file('logo_path');
        $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();

        // Déplacement physique
        $file->move($destinationPath, $filename);

        // Chemin enregistré en DB
        $validated['logo_path'] = 'logos/' . $filename;
    }

    DB::transaction(function () use ($validated) {
        $validated['id_user'] = auth()->id();

        $entreprise = Entreprise::create($validated);

        auth()->user()->update([
            'entreprise_id' => $entreprise->id
        ]);
    });

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
        'logo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'remove_logo' => 'nullable|boolean',
    ]);

    $entreprise = Entreprise::where('id_user', Auth::id())->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | Suppression du logo existant (si demandé)
    |--------------------------------------------------------------------------
    */
    if ($request->remove_logo == 1 && $entreprise->logo_path) {
        $oldLogoPath = base_path($entreprise->logo_path);

        if (file_exists($oldLogoPath)) {
            unlink($oldLogoPath);
        }

        $validated['logo_path'] = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Upload d’un nouveau logo
    |--------------------------------------------------------------------------
    */
    if ($request->hasFile('logo_path')) {

        // Supprimer l'ancien logo
        if ($entreprise->logo_path) {
            $oldLogoPath = base_path($entreprise->logo_path);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }

        $destinationPath = base_path('logos');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file = $request->file('logo_path');
        $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $filename);

        // Chemin relatif stocké en DB
        $validated['logo_path'] = 'logos/' . $filename;
    }

    /*
    |--------------------------------------------------------------------------
    | Mise à jour entreprise
    |--------------------------------------------------------------------------
    */
    $entreprise->update($validated);

    return redirect()
        ->back()
        ->with('success', '✅ Entreprise mise à jour avec succès');
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

    $premiereEntreprise = Entreprise::where('id_user', $user->id)->first();

    if (!$premiereEntreprise) {
        return redirect()->back()->with('error', 'Vous n’avez pas encore créé d’entreprise.');
    }

    $employes = User::where('entreprise_id', $premiereEntreprise->id)->get();

    return view('admin.users.index', compact('employes'));
}



    public function toggleStatus(Entreprise $entreprise)
    {

        $entreprise->is_actif = !$entreprise->is_actif;
        $entreprise->save();

        $statusMessage = $entreprise->is_actif ? 'dérestreinte (active)' : 'restreinte (inactive)';

        return redirect()->back()->with('success', "L'entreprise '{$entreprise->entreprise_name}' a été {$statusMessage} avec succès.");
    }

    public function show(Entreprise $entreprise)
    {
       
        $adminUser = User::find($entreprise->id_user);

        return view('superadmin.entreprise.show', compact('entreprise', 'adminUser'));
    }

}
