<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Models\Project;



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

        if ($entreprise && !$entreprise->is_actif) {
            return redirect()->route('status');
        }

        return view('admin.entreprises.index');
    }

    public function formView()
    {
        $userId = Auth::id();
        $entreprise = Entreprise::where('id_user', $userId)->first();

       
        if ($entreprise && !$entreprise->is_actif) {
            return redirect()->route('status');
        }

        return view('admin.users.create');
    }

    public function list_users()
{$user = auth()->user();

    $premiereEntreprise = Entreprise::where('id_user', $user->id)->first();

    if (!$premiereEntreprise) {
        return redirect()->back()->with('error', 'Vous n’avez pas encore créé d’entreprise.');
    }

    $employes = User::where('entreprise_id', $premiereEntreprise->id)->get();

    return view('admin.users.list', compact('employes'));
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

    $currentUser = Auth::user();

    $entreprise = Entreprise::where('id_user', $currentUser->id)->first();

    if (!$entreprise) {
        return back()->with('error', 'Aucune entreprise trouvée pour cet utilisateur.');
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telephone' => $request->telephone,
        'role' => $request->role,
        'entreprise_id' => $entreprise->id,
    ]);

    Mail::to($user->email)->send(new AccountCreated($user->name, $user->email, $request->password));

    return redirect()->route('entreprise.employes')->with('success', 'Employé ajouté avec succès.');
}




public function showTeams(Request $request)
{
    $user = $request->user();

    $teams = $user->getTeamsInSameEntreprise();

    return view('admin.teams.index', compact('teams'));
}




public function showProjects()
{
    $entrepriseId = Auth::user()->entreprise_id;

    $projectCount = Project::where('entreprise_id', $entrepriseId)->count();
    $teamCount = Team::where('entreprise_id', $entrepriseId)->count();
    $userCount = User::where('entreprise_id', $entrepriseId)->count();

    // Charger les projets en incluant la relation 'lead' et 'tasks'
    // La relation `lead` est celle que vous avez définie dans le modèle Project
    $projects = Project::with(['lead', 'tasks'])->where('entreprise_id', $entrepriseId)->get();

    // Calculer la progression pour chaque projet
    $projects->each(function ($project) {
        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'completed')->count();
        $project->progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $project->leadUser = $project->lead->first();
    });

    return view('admin.project.index', compact('projectCount', 'teamCount', 'userCount', 'projects'));
}

    
}
