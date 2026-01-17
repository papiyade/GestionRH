<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use App\Models\EmployeeDocument;
use App\Models\Candidature;
use App\Models\JobOffer;
use App\Models\Prestataire;
use App\Models\Cra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntrepriseStatisticsController extends Controller
{
    public function index()
    {
        $entrepriseId = Auth::user()->entreprise_id;

        // === EMPLOYÉS ===
        $totalEmployees = User::where('entreprise_id', $entrepriseId)->count();
        
        // Répartition par poste
        $employeesByPosition = Employee::where('entreprise_id', $entrepriseId)
            ->select('fiche_poste', DB::raw('count(*) as total'))
            ->groupBy('fiche_poste')
            ->orderByDesc('total')
            ->get();

        // Répartition par type de contrat
        $employeesByContract = EmployeeDetail::whereHas('user', function($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->select('type_contrat', DB::raw('count(*) as total'))
            ->groupBy('type_contrat')
            ->get();

        // === MASSE SALARIALE ===
        $totalSalaries = EmployeeDetail::whereHas('user', function($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->sum('salaire');

        // === ÉQUIPES ===
        $totalTeams = Team::where('entreprise_id', $entrepriseId)->count();
        
        $totalMembers = DB::table('team_user')
            ->join('teams', 'team_user.team_id', '=', 'teams.id')
            ->where('teams.entreprise_id', $entrepriseId)
            ->count();

        // === PROJETS ===
        $totalProjects = Project::where('entreprise_id', $entrepriseId)->count();
        
        $projectsByTeam = Team::where('entreprise_id', $entrepriseId)
            ->withCount(['projects', 'members'])
            ->having('projects_count', '>', 0)
            ->get();

        // === TÂCHES ===
        $userIds = User::where('entreprise_id', $entrepriseId)->pluck('id');
        
        // $totalTasks = Task::whereIn('user_id', $userIds)->count();
        // $completedTasks = Task::whereIn('user_id', $userIds)->where('status', 'completed')->count();
        // $inProgressTasks = Task::whereIn('user_id', $userIds)->where('status', 'in progress')->count();
        // $pendingTasks = Task::whereIn('user_id', $userIds)->where('status', 'pending')->count();

        // === CANDIDATURES ===
        $totalCandidatures = Candidature::whereHas('jobOffer', function($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })->count();
        
        $pendingCandidatures = Candidature::where('status_demande', 'En attente')
        ->whereHas('jobOffer', fn($q) => $q->where('entreprise_id', $entrepriseId))
        ->count();
        
        $acceptedCandidatures = Candidature::whereHas('jobOffer', function($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })->where('status_demande', 'accepte')->count();
        
        $rejectedCandidatures = Candidature::whereHas('jobOffer', function($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })->where('status_demande', 'rejete')->count();

        // === OFFRES D'EMPLOI ===
        // $jobOffers = JobOffer::where('entreprise_id', $entrepriseId)
        //     ->withCount('candidatures')
        //     ->latest()
        //     ->get();

        // === PRESTATAIRES ===
        $totalPrestataires = Prestataire::where('entreprise_id', $entrepriseId)->count();

        // === CRA ===
        $usersEntreprise = User::where('entreprise_id', $entrepriseId)->pluck('id');
        
        $crasThisMonth = Cra::whereIn('user_id', $usersEntreprise)
            ->whereMonth('date_debut', now()->month)
            ->whereYear('date_debut', now()->year)
            ->count();
        
        $employeesWithCRA = Cra::whereIn('user_id', $usersEntreprise)
            ->whereMonth('date_debut', now()->month)
            ->whereYear('date_debut', now()->year)
            ->distinct('user_id')
            ->count('user_id');
        
        $tauxCompletionCRA = $totalEmployees > 0 
            ? round(($employeesWithCRA / $totalEmployees) * 100, 1) 
            : 0;

        // === DOCUMENTS ===
        $totalDocuments = EmployeeDocument::whereIn('user_id', $userIds)->count();

        return view('rh.statistics.index', compact(
            'totalEmployees',
            'employeesByPosition',
            'employeesByContract',
            'totalSalaries',
            'totalTeams',
            'totalMembers',
            'totalProjects',
            'projectsByTeam',
            // 'totalTasks',
            // 'completedTasks',
            // 'inProgressTasks',
            // 'pendingTasks',
            'totalCandidatures',
            'pendingCandidatures',
            'acceptedCandidatures',
            'rejectedCandidatures',
            // 'jobOffers',
            'totalPrestataires',
            'crasThisMonth',
            'tauxCompletionCRA',
            'totalDocuments'
        ));
    }
}