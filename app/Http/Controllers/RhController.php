<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use Carbon\Carbon;
use App\Models\JobOffer;
use App\Models\Candidature;


use Illuminate\Http\Request;

class RhController extends Controller
{
    //
    public function index()
{
    $userId = Auth::id();
    $entrepriseId = Auth::user()->entreprise_id;
    $entreprise = Entreprise::find($entrepriseId);

    if ($entreprise && !$entreprise->is_actif) {
        return redirect()->route('status');
    }

    $totalEmployes = User::where('entreprise_id', $entrepriseId)->count();

    $offresEmploiActives = JobOffer::where('statut', 'En cours')
        ->where('entreprise_id', $entrepriseId)
        ->count();

    $candidaturesEnAttente = Candidature::where('status_demande', 'pending')
        ->whereHas('jobOffer', fn($q) => $q->where('entreprise_id', $entrepriseId))
        ->count();

    $candidaturesCeMois = Candidature::whereHas('jobOffer', fn($q) => $q->where('entreprise_id', $entrepriseId))
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    $totalEquipes = Team::where('entreprise_id', $entrepriseId)->count();

    $employesRecents = User::where('entreprise_id', $entrepriseId)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $candidaturesRecentes = Candidature::whereHas('jobOffer', fn($q) => $q->where('entreprise_id', $entrepriseId))
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->with(['jobOffer', 'user'])
        ->get();

    $candidaturesApprouvees = Candidature::where('status_demande', 'approved')
        ->whereHas('jobOffer', fn($q) => $q->where('entreprise_id', $entrepriseId))
        ->count();

    $candidaturesRejetees = Candidature::where('status_demande', 'rejected')
        ->whereHas('jobOffer', fn($q) => $q->where('entreprise_id', $entrepriseId))
        ->count();

        $employesParEquipe = Team::where('entreprise_id', $entrepriseId)
            ->withCount('users') // Compte les utilisateurs via la table pivot team_user
            ->get(['id', 'name']);



    return view('rh.dashboard', compact(
        'totalEmployes',
        'offresEmploiActives',
        'candidaturesEnAttente',
        'totalEquipes',
        'employesRecents',
        'candidaturesRecentes',
        'candidaturesApprouvees',
        'candidaturesRejetees',
        'entreprise',
        'candidaturesCeMois',
        'employesParEquipe'
    ));
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

public function updateUsers(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'telephone' => 'nullable|string|max:20',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:6',
        'team_id' => 'required|exists:teams,id',
    ]);

    // Mise à jour des informations
    $user->name = $request->name;
    $user->telephone = $request->telephone;
    $user->email = $request->email;

    // Mettre à jour le mot de passe uniquement si renseigné
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Mettre à jour l'équipe
    $user->teams()->sync([$request->team_id => ['role' => 'employe']]);

    return redirect()->route('employeList')->with('success', 'Employé mis à jour avec succès.');
}


public function deleteUser($id)
{
    try {
        $user = User::findOrFail($id);

        if ($user->entreprise_id !== Auth::user()->entreprise_id) {
            return response()->json(['success' => false, 'message' => 'Action non autorisée.'], 403);
        }

        if ($user->role === 'Admin') {
            return response()->json(['success' => false, 'message' => 'Impossible de supprimer un administrateur.'], 403);
        }

        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Vous ne pouvez pas supprimer votre propre compte.'], 403);
        }

        $user->teams()->detach();
        $user->delete();

return redirect()->route('employeList')->with('success', 'Employé supprimé avec succès.');
    } catch (\Exception $e) {
        \Log::error('Erreur suppression employé : ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression.'], 500);
    }
}


public function editUsers($id)
{
    $user = User::findOrFail($id);
    $teams = Team::all(); 

    return view('rh.employe.editUser', compact('user', 'teams'));
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
