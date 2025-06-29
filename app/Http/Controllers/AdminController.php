<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Entreprise;


class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard'); 
    }

    public function companyView(){
        return view('admin.entreprises.index');
    }

    public function formView(){
        return view('admin.users.create');
    }



public function createEmploye(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'telephone' => 'nullable|string',
        'role' => 'required|string|in:rh,chef_projet',
    ]);

    // Récupère l'utilisateur connecté
    $currentUser = Auth::user();

    // Récupère la première entreprise créée par l'utilisateur connecté
    $entreprise = Entreprise::where('id_user', $currentUser->id)->first();

    if (!$entreprise) {
        return back()->with('error', 'Aucune entreprise trouvée pour cet utilisateur.');
    }

    // Création de l'employé
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telephone' => $request->telephone,
        'role' => $request->role,
        'entreprise_id' => $entreprise->id,

    ]);

    return redirect()->route('entreprise.employes')->with('success', 'Employé ajouté avec succès.');
}



    
}
