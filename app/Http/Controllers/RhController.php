<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;



use Illuminate\Http\Request;

class RhController extends Controller
{
    //
 public function index()
    {
        $userId = Auth::id();

       
        $entreprise = Entreprise::where('id_user', $userId)->first();

        if ($entreprise && !$entreprise->is_actif) {

            return redirect()->route('status');
        }

        return view('rh.dashboard');
    }

    public function employeView(){
    // Récupérer les utilisateurs de la même entreprise que l'utilisateur connecté
    $users = User::with('teams') // pour charger les équipes de chaque user
                ->where('entreprise_id', Auth::user()->entreprise_id)
                ->get();

    return view('rh.employe.listUsers', compact('users'));
}
public function createUsers(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'telephone' => 'nullable|string|max:20',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'adresse' => 'nullable|string|max:255',
        'team_id' => 'required|exists:teams,id',
    ]);

    // Création de l'utilisateur
    $user = User::create([
        'name' => $request->name,
        'telephone' => $request->telephone,
        'email' => $request->email,
        'adresse' => $request->adresse,
        'entreprise_id' => Auth::user()->entreprise_id,
        'password' => Hash::make($request->password),
        'role' => 'employe',
    ]);

    // Associer à une équipe
    $user->teams()->attach($request->team_id, ['role' => 'employe']);

    Mail::to($user->email)->send(new AccountCreated(
        $user->name,
        $user->email,
        $request->password 
    ));

    return redirect()->route('employeList')->with('success', 'Employé ajouté avec succès.');
}
public function createUserForm()
{
   
    $teams = Team::where('entreprise_id', Auth::user()->entreprise_id)->get();

    return view('rh.employe.addUsers', compact('teams'));
}


public function show($id)
{
    $user = User::with(['teams', 'employeeDetail'])->findOrFail($id);

    return view('rh.employe.showUser', compact('user'));
}


}
