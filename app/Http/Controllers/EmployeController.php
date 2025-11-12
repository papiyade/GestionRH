<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $allTasks = $user->tasks()->get();

            $totalTasks = $allTasks->count();
            $completedTasks = $allTasks->where('status', 'completed')->count();
            $inProgressTasks = $allTasks->where('status', 'in progress')->count();

$recentTasks = $user->tasks()->with(['project', 'files', 'comments'])->latest()->take(3)->get();
            
$tasks = $user->tasks()->with(['project', 'files', 'comments'])->get();
// Récupérer les projets uniques liés aux tâches
$projects = $tasks->pluck('project')->unique('id')->filter();

            return view('employe.dashboard', [
                'tasks' => $tasks,
                'recentTasks' => $recentTasks,
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'inProgressTasks' => $inProgressTasks,
                            'projects' => $projects,
            ]);
        }

        return redirect()->route('login');
    }

    public function mesProjets(Request $request)
    {
        $user = Auth::user();

        // Start with all projects the user is associated with
        $projets = $user->projects();

        // Apply search filter if 'search' parameter is present
        if ($request->filled('search')) {
            $search = $request->input('search');
            $projets->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter if 'status_filter' parameter is present
        if ($request->filled('status_filter')) {
            $projets->where('status', $request->input('status_filter'));
        }

        // Get the filtered projects
        // Eager load tasks, comments, files, entreprise, and team to avoid N+1 query issues
        $projets = $projets->with(['tasks.users', 'comments', 'files', 'entreprise', 'team', 'users'])->get();

        return view('employe.projects.index', compact('projets'));
    }

    public function voirProjet(Project $project)
    {
        $user = Auth::user();

        if (!$project->members->contains($user->id)) {
            return redirect()->route('employe.projects')->with('error', 'Vous n\'êtes pas autorisé à voir ce projet.');
        }

        $isLead = $project->isLead($user);

        if ($isLead) {
            $tasks = $project->tasks()->with('users', 'comments.user')->get();
            $projectMembers = $project->members()->get();
            return view('employe.projects.show_lead_kanban', compact('project', 'tasks', 'isLead', 'projectMembers'));
        } else {
            $tasks = $project->tasks()
                             ->whereHas('users', fn ($q) => $q->where('user_id', $user->id))
                             ->with('users', 'comments.user')
                             ->get();
            return view('employe.projects.show', compact('project', 'tasks', 'isLead'));
        }
    }
     public function changerStatutTache(Request $request, Task $task)
    {
        $user = Auth::user();
        $project = $task->project;

        $isAssigned = $task->users->contains($user->id);
        $isLead = $project->isLead($user);

        if (!$isAssigned && !$isLead) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modifier le statut de cette tâche.');
        }

        $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in(array_keys(Task::statuses()))],
        ]);

        $task->update(['status' => $request->input('status')]);

        return back()->with('success', 'Statut de la tâche mis à jour !');
    }

public function changerPrioriteTache(Request $request, Project $project, Task $tache)
{
    $user = Auth::user();



    // Validation
    $request->validate([
        'priority' => ['required', 'string', \Illuminate\Validation\Rule::in(['low', 'medium', 'high'])],
    ]);

    try {
        $tache->priority = $request->input('priority');
        $tache->save();
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
    }

    return back()->with('success', 'Priorité de la tâche mise à jour !');
}





    public function commenterTache(Request $request, Task $task)
    {
        $user = Auth::user();
        $project = $task->project;

        $isAssigned = $task->users->contains($user->id);
        $isLead = $project->isLead($user);

        if (!$isAssigned && !$isLead) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à commenter cette tâche.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'content' => $request->input('content'),
            'user_id' => $user->id,
        ]);

        $task->comments()->save($comment);

        return back()->with('success', 'Commentaire ajouté !');
    }

    public function storeTask(Request $request, Project $project)
    {
        $user = Auth::user();

        if (!$project->isLead($user)) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à créer des tâches pour ce projet.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => ['required', 'string', \Illuminate\Validation\Rule::in(array_keys(Task::priorities()))],
            'deadline' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $task = $project->tasks()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'status' => 'not_started',
            'deadline' => $request->input('deadline'),
        ]);

        if ($request->filled('user_id')) {
            $task->users()->attach($request->input('user_id'));
        }

        return back()->with('success', 'Tâche créée avec succès !');
    }

     public function ajouterCommentaire(Request $request, Task $task)
    {
        $user = Auth::user();

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Vérifie que la tâche est bien assignée à l'utilisateur
        if (!$task->users->contains($user)) {
            abort(403);
        }

        Comment::create([
            'content' => $request->content,
            'user_id' => $user->id,
            'task_id' => $task->id,
            'project_id' => $task->project_id,
        ]);

        return back()->with('success', 'Commentaire ajouté.');
    }

    
    public function changerStatut(Request $request, Task $task)
    {
        $user = Auth::user();

        $request->validate([
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        // Vérifie que la tâche lui appartient
        if (!$task->users->contains($user)) {
            abort(403);
        }

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour.');
    }
}


