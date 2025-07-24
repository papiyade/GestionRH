<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;    // Assurez-vous d'importer le modèle 
use App\Models\File;
use App\Models\Task;
use App\Models\Comment;



class ProjectController extends Controller
{
    //

     public function index()
{
    $entrepriseId = Auth::user()->entreprise_id;

    $teams = Team::where('entreprise_id', $entrepriseId)->get();

    $projects = Project::with('team')
                ->where('entreprise_id', $entrepriseId)
                ->paginate(10);

    return view('projects.index', compact('projects', 'teams'));
}

public function store(Request $request)
    {
       
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'required|exists:teams,id',
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        $entrepriseId = Auth::user()->entreprise_id;

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'team_id' => $request->team_id,
            'status' => $request->status,
            'entreprise_id' => $entrepriseId, 
        ]);

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

 public function show(Project $project)
{
    $entrepriseId = Auth::user()->entreprise_id;
    $members = User::where('entreprise_id', $entrepriseId)->get();
    $Teammembers = $project->members;
    $comments = $project->comments;
    $files = $project->files;
    $tasks = $project->tasks;

    $totalTasks = $tasks->count();

   
 $completedTasks = $tasks->where('status', 'completed')->count();

$progress = $totalTasks > 0 
    ? ($completedTasks / $totalTasks) * 100 
    : 0;


    return view('projects.show', compact('project', 'Teammembers', 'comments', 'files', 'members', 'tasks', 'progress', 'totalTasks'));
}



public function storeComment(Request $request, Project $project)
{
    // Validation du champ content
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    // Création du commentaire via la relation avec le projet
    $project->comments()->create([
        'content' => $request->content,
        'user_id' => Auth::id(),
        'task_id' => $request->input('task_id'), // Peut être null
    ]);

    return redirect()
        ->route('projects.show', $project)
        ->with('success', 'Commentaire ajouté avec succès!');
}

 public function storeTask(Request $request, Project $project)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,medium,high',
        'status' => 'nullable|in:not_started,in_progress,completed',
        'deadline' => 'nullable|date',
        'user_id' => 'nullable|exists:users,id',
    ]);

    // Si status non défini (null ou vide), on met 'not_started'
    if (empty($validated['status'])) {
        $validated['status'] = 'not_started';
    }

    // Vérifier si un utilisateur est assigné et s'assurer qu'il est membre du projet
    if ($request->filled('user_id')) {
        $user = User::find($request->user_id);
        if (!$project->members->contains($user)) {
            return redirect()->back()->withErrors('L\'utilisateur sélectionné n\'est pas membre du projet.');
        }
    }

    $task = $project->tasks()->create($validated);

    // Assigner l'utilisateur si présent
    if ($request->filled('user_id')) {
        $task->users()->attach($request->user_id);
    }

    return redirect()->back()->with('success', 'Tâche ajoutée avec succès.');
}


public function updateTask(Request $request, Task $task)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,medium,high',
        'status' => 'required|in:not_started,in_progress,completed',
        'deadline' => 'nullable|date',
    ]);

    $task->update($validated);

    return back()->with('success', 'Tâche mise à jour avec succès.');
}

public function assignTask(Request $request, Task $task)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $project = $task->project;

    // Vérifier si l'utilisateur est bien membre du projet avant de l'assigner
    if (!$project->members->contains($validated['user_id'])) {
        return redirect()->back()->withErrors('L\'utilisateur sélectionné n\'est pas membre du projet.');
    }

    // Assigner la tâche à l'utilisateur
    $task->users()->syncWithoutDetaching([$validated['user_id']]);

    return redirect()->back()->with('success', 'Tâche assignée avec succès.');
}


public function myTasks()
{
    $tasks = Auth::user()->tasks()->with('project')->paginate(10);


    return view('tasks.my_tasks', compact('tasks'));
}

public function showTask(Task $task)
{
    $project = $task->project;
    $comments = $task->comments()->with('user')->latest()->get(); // avec auteur
    $users = $task->users;

    return view('tasks.show', compact('task', 'project', 'comments', 'users'));
}



public function deleteTask(Task $task)
{
    $task->delete();

    return back()->with('success', 'Tâche supprimée avec succès.');
}

public function removeTaskUser(Request $request, Task $task)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $task->users()->detach($validated['user_id']);

    return back()->with('success', 'Utilisateur retiré de la tâche avec succès.');
}
public function updateMembers(Request $request, Project $project)
{
    if ($request->has('add_member')) {
        $project->members()->attach($request->add_member);
    }

    if ($request->has('remove_member')) {
        $project->members()->detach($request->remove_member);
    }

    return back()->with('success', 'Membres mis à jour avec succès.');
}

public function removeMember(Project $project, User $user)
{
    $project->members()->detach($user->id);
    return back()->with('success', 'Membre retiré du projet avec succès.');
}

public function addMember(Project $project, User $user)
{
    // Vérifie s'il est déjà membre pour éviter les doublons
    if (!$project->members->contains($user->id)) {
        $project->members()->attach($user->id);
        return back()->with('success', 'Membre ajouté au projet avec succès.');
    }

    return back()->with('info', 'Ce membre fait déjà partie du projet.');
}



    // Suppression d'un projet
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }

    public function toggleLead(Project $project, User $user)
{
    $pivotData = $project->members()->where('user_id', $user->id)->first();

    if (!$pivotData) {
        return back()->with('error', 'Ce membre ne fait pas partie du projet.');
    }

    // Vérifie la valeur actuelle
    $currentIsLead = $pivotData->pivot->is_lead;

    // Met à jour
    $project->members()->updateExistingPivot($user->id, [
        'is_lead' => !$currentIsLead
    ]);

    return back()->with('success', $currentIsLead ? 'Lead retiré.' : 'Membre désigné comme Lead.');
}

public function storeFile(Request $request, Project $project)
{
    // Validation du fichier
    $request->validate([
        'file' => 'required|file|mimes:pdf,docx,png,jpg,jpeg,zip,ppt|max:2048',
    ]);

    // Gérer le fichier téléchargé
    $path = $request->file('file')->store('project_files', 'public');

    // Créer et associer le fichier au projet
    $file = new File();
    $file->file_name = $request->file('file')->getClientOriginalName();
    $file->file_path = $path;
    $file->project_id = $project->id; // Associer au projet
    $file->save();

    return redirect()->route('projects.show', $project)->with('success', 'Fichier ajouté avec succès!');
}

}
