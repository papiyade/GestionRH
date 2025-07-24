<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // N'oubliez pas d'importer User si vous l'utilisez pour les listes déroulantes
// App\Http\Controllers\TaskController.php

// ... (autres use statements) ...

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()
            ->with(['users', 'comments.user'])
            ->get()
            ->groupBy('status');

        return view('taches.kanban', compact('project', 'tasks'));
    }

    // Renommée et utilisée pour la route de commentaires de tâche
    public function addComment(Request $request, Task $task) // Note: $task est injecté ici par Route Model Binding
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'task_id' => $task->id, // Utilisez $task->id ici
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.')
                           ->with('openCommentsModal', true)
                           ->with('comment_task_id', $task->id);
    }

    // Ceci est votre méthode `storeComment` originale.
    // Si elle est destinée à d'autres usages (hors du formulaire de modal de tâche), vous pouvez la conserver.
    // Sinon, elle est redondante avec `addComment` pour le contexte du Kanban.
    // Je la laisse ici comme vous l'avez, mais la route associée dans le routes/web.php est supprimée pour éviter les conflits.
    // Si vous voulez l'utiliser, assurez-vous de lui donner une URL et un nom de route uniques.
    /*
    public function storeComment(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string|min:2'
        ]);

        Comment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back(); // Ou redirection avec message
    }
    */

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:high,medium,low,urgent',
            'status' => 'required|in:not_started,in_progress,completed',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = $project->tasks()->create($request->only([
            'title', 'description', 'priority', 'status', 'deadline'
        ]));

        if ($request->assigned_to) {
            $task->users()->attach($request->assigned_to);
        }

        return redirect()->back()->with('success', 'Tâche créée avec succès !')
                           ->with('openCreateTaskModal', false);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:high,medium,low,urgent',
            'status' => 'sometimes|in:not_started,in_progress,completed',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($request->only(['title', 'description', 'priority', 'status', 'deadline']));

        if ($request->has('assigned_to')) {
            if (empty($request->assigned_to)) {
                $task->users()->detach();
            } else {
                $task->users()->sync([$request->assigned_to]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Tâche mise à jour avec succès.', 'task' => $task]);
        }

        return redirect()->back()->with('success', 'Tâche mise à jour avec succès.')
                           ->with('openEditTaskModal', true)
                           ->with('edit_task_id', $task->id);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Tâche supprimée avec succès.');
    }

    public function comments(Task $task)
    {
        $comments = $task->comments()->with('user')->latest()->get();
        return view('tasks.partials.comments', compact('comments'));
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.partials.edit_task_modal_content', compact('task', 'users'));
    }
}