<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    // Afficher les taches pour un projet spécifique (kanban)
    public function showTachesParProjet(Project $projet)
    {
        // Charger les tâches avec utilisateurs et commentaires
        $projet->load(['tasks.users', 'tasks.comments.user']);

        return view('taches.kanban', compact('projet'));
    }

    public function changerStatut(Request $request, Project $projet, Task $tache)
    {
        // Vérifier que la tâche appartient bien au projet
        if ($tache->project_id !== $projet->id) {
            abort(404);
        }

        $request->validate([
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        $tache->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Statut modifié avec succès.');
    }

    public function ajouterCommentaire(Request $request, Project $projet, Task $tache)
    {
        if ($tache->project_id !== $projet->id) {
            abort(404);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $commentaire = new Comment();
        $commentaire->content = $request->content;
        $commentaire->user_id = auth()->id();
        $commentaire->task_id = $tache->id;
        $commentaire->project_id = $projet->id;
        $commentaire->save();

        return back()->with('success', 'Commentaire ajouté avec succès.');
    }

    public function changerPriorite(Request $request, Project $projet, Task $tache)
{
    if ($tache->project_id !== $projet->id) {
        abort(404);
    }

    $request->validate([
        'priority' => 'required|in:high,medium,low',
    ]);

    $tache->update([
        'priority' => $request->priority,
    ]);

    return back()->with('success', 'Priorité modifiée avec succès.');
}

}
