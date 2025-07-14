<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;


class AdminController extends Controller
{
    //
  public function index()
    {
        $userId = Auth::id();

       
        $entreprise = Entreprise::where('id_user', $userId)->first();

        if ($entreprise && !$entreprise->is_actif) {
            return redirect()->route('status');
        }

      
        return view('admin.dashboard');
    }
   public function companyView()
    {
        $userId = Auth::id();
        $entreprise = Entreprise::where('id_user', $userId)->first();

        // If a company exists for the user AND it's inactive, redirect
        if ($entreprise && !$entreprise->is_actif) {
            return redirect()->route('status');
        }

        // Otherwise, show the company index view
        return view('admin.entreprises.index');
    }

    public function formView()
    {
        $userId = Auth::id();
        $entreprise = Entreprise::where('id_user', $userId)->first();

        // If a company exists for the user AND it's inactive, redirect
        if ($entreprise && !$entreprise->is_actif) {
            return redirect()->route('status');
        }

        // Otherwise, show the user creation form view
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

    // Utilisateur connecté
    $currentUser = Auth::user();

    // Récupère l'entreprise liée
    $entreprise = Entreprise::where('id_user', $currentUser->id)->first();

    if (!$entreprise) {
        return back()->with('error', 'Aucune entreprise trouvée pour cet utilisateur.');
    }

    // Création de l'employé
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telephone' => $request->telephone,
        'role' => $request->role,
        'entreprise_id' => $entreprise->id,
    ]);

    // Envoi de mail avec le mot de passe en clair
    Mail::to($user->email)->send(new AccountCreated($user->name, $user->email, $request->password));

    return redirect()->route('entreprise.employes')->with('success', 'Employé ajouté avec succès.');
}


    
}
