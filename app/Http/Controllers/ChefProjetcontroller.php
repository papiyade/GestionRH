<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class ChefProjetcontroller extends Controller
{
    //
    public function index(){
        $entrepriseId = Auth::user()->entreprise_id;

        $projectCount = Project::where('entreprise_id', $entrepriseId)->count();

        $teamCount = Team::where('entreprise_id', $entrepriseId)->count();   
        $userCount = User::where('entreprise_id' , $entrepriseId)->count();
    
        
        // Charger toutes les relations nécessaires en une seule requête
$projects = Project::with(['users', 'tasks'])
    ->where('entreprise_id', $entrepriseId)
    ->get();
    
        $projects->each(function ($project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('status', 'completed')->count();
            $project->progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        
            // Récupère le premier lead du projet
            $project->lead = $project->lead()->first();
        });
        return view('dashboardchef_projet', compact('projectCount', 'teamCount', 'userCount', 'projects'));
        }
}
