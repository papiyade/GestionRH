<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



use Illuminate\Http\Request;

class TeamController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
    ]);

    $user = auth()->user();

    // Vérification que l'utilisateur a bien une entreprise
    if (!$user->entreprise_id) {
        return redirect()->back()->with('error', 'Vous n’êtes associé à aucune entreprise.');
    }

    // Création de l'équipe
    Team::create([
        'name' => $request->name,
        'description' => $request->description,
        'owner_id' => $user->id,
        'entreprise_id' => $user->entreprise_id,
    ]);

    return redirect()->back()->with('success', 'Équipe créée avec succès.');
}

public function show(Team $team, Request $request)
{
    $user = Auth::user();

    // Vérifie que l'utilisateur connecté appartient bien à l'entreprise liée à l'équipe
    if ($user->entreprise_id !== $team->entreprise_id) {
        abort(403, 'Vous n\'êtes pas autorisé à accéder à cette équipe.');
    }

    // 1. Récupérer les utilisateurs de la même entreprise qui ne sont PAS membres de l’équipe
    $users = User::where('entreprise_id', $user->entreprise_id)
                 ->whereNotIn('id', $team->members->pluck('id'))
                 ->get();

    // 2. Mise à jour optionnelle de la description
    if ($request->has('description')) {
        $team->description = $request->input('description');
        $team->save();
    }

    // 3. Retourner la vue
    return view('rh.team.show', compact('team', 'users'));
}


  public function updateDescription(Team $team, Request $request)
{
    // Met à jour la description de l'équipe
    $request->validate([
        'description' => 'required|string|max:255',
    ]);

    $team->description = $request->description;
    $team->save();

    return redirect()->route('teams.show', $team)->with('success', 'Description mise à jour avec succès.');
}



public function index()
{
    $user = Auth::user();

    // Vérifier que l'utilisateur a une entreprise
    if (!$user->entreprise_id) {
        return redirect()->back()->with('error', 'Aucune entreprise associée à votre compte.');
    }

    // Récupérer les équipes de l'entreprise de l'utilisateur connecté
    $teams = Team::where('entreprise_id', $user->entreprise_id)
                ->with('members') // charge les membres pour éviter N+1
                ->latest()
                ->get();

    return view('rh.team.index', compact('teams'));
}

public function addMember($teamId, $userId)
{
    $team = Team::findOrFail($teamId);
    $user = User::findOrFail($userId);

    // Ajouter le membre à l'équipe
$team->members()->attach($user->id, ['role' => 'employe']);

    return redirect()->back()->with('success', 'Membre ajouté avec succès.');
}


public function removeMember(Team $team, User $user)
{
    // Vérifie si l'utilisateur connecté est le propriétaire de l'équipe
    if ($team->owner_id !== Auth::id()) {
        abort(403, 'Seul le propriétaire de l\'équipe peut retirer un membre.');
    }

    // Vérifie si l'utilisateur à retirer est bien membre
    if (!$team->members->contains($user->id)) {
        abort(404, 'Cet utilisateur ne fait pas partie de l\'équipe.');
    }

    // On empêche de retirer le propriétaire lui-même
    if ($team->owner_id === $user->id) {
        abort(403, 'Le propriétaire de l\'équipe ne peut pas se retirer lui-même.');
    }

    // Détache l'utilisateur de l'équipe
    $team->members()->detach($user->id);

    return redirect()->back()->with('success', 'Membre retiré de l\'équipe avec succès.');
}

public function assignPilot(Team $team, User $user)
{
   
    if (!$team->members->contains($user->id)) {
        return redirect()->back()->with('error', 'Cet utilisateur ne fait pas partie de l\'équipe.');
    }

    $team->pilot_id = $user->id;
    $team->save();

    return redirect()->back()->with('success', $user->name . ' est maintenant le pilote de l\'équipe.');
}

public function viewCras(Team $team, Request $request)
{
    if ($team->pilot_id !== Auth::id()) {
        abort(403, 'Accès interdit : vous n\'êtes pas le pilote de cette équipe.');
    }

    $weekOffset = $request->input('week', 0); 
    $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
    $endOfWeek   = Carbon::now()->endOfWeek()->addWeeks($weekOffset);

    $memberIds = $team->members()->pluck('users.id');

    $cras = Cra::whereIn('user_id', $memberIds)
                ->whereBetween('date_debut', [$startOfWeek, $endOfWeek])
                ->with('user') 
                ->get();

    return view('teams.cras', compact('team', 'cras', 'startOfWeek', 'endOfWeek', 'weekOffset'));
}
}
