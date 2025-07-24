@extends('layouts.chef_projet')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Mes projets</h2>

    {{-- Filter and Search Section --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('employe.projects') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="search" class="visually-hidden">Rechercher par titre ou description</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher par titre ou description" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="status_filter" class="visually-hidden">Filtrer par statut</label>
                    <select name="status_filter" id="status_filter" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="not_started" {{ request('status_filter') == 'not_started' ? 'selected' : '' }}>Non débuté</option>
                        <option value="in_progress" {{ request('status_filter') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ request('status_filter') == 'completed' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i> Appliquer les filtres
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Dynamic Task Completion Message --}}
    @php
        $userTotalTasks = 0;
        $userCompletedTasks = 0;
        foreach ($projets as $projet) {
            foreach ($projet->tasks as $task) {
                // Check if the current user is assigned to this task
                if ($task->users->contains(Auth::id())) {
                    $userTotalTasks++;
                    if ($task->status === 'completed') {
                        $userCompletedTasks++;
                    }
                }
            }
        }
        $userIncompleteTasks = $userTotalTasks - $userCompletedTasks;
    @endphp

    @if ($userIncompleteTasks > 0)
        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" style="font-size: 1.2rem;"></i>
            <div>
                Vous avez **{{ $userIncompleteTasks }} tâche{{ $userIncompleteTasks > 1 ? 's' : '' }}** non terminée{{ $userIncompleteTasks > 1 ? 's' : '' }} parmi vos projets. Gardez le cap !
            </div>
        </div>
    @else
        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0 me-2" style="font-size: 1.2rem;"></i>
            <div>
                Félicitations ! Toutes vos tâches sont terminées.
            </div>
        </div>
    @endif

    <div class="row">
        @forelse ($projets as $projet)
            @php
                // Check if the authenticated user is the lead for this specific project
                $isLead = $projet->users()->where('user_id', Auth::id())->wherePivot('is_lead', true)->exists();

                // Calculate project-level task completion percentage
                $totalProjectTasks = $projet->tasks->count();
                $completedProjectTasks = $projet->tasks->where('status', 'completed')->count();
                $progressPercentage = $totalProjectTasks > 0 ? round(($completedProjectTasks / $totalProjectTasks) * 100) : 0;

                $statusClass = match($projet->status) {
                    'not_started' => 'secondary',
                    'in_progress' => 'warning',
                    'completed' => 'success',
                    default => 'light',
                };
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            {{ $projet->title }}
                            @if ($isLead)
                                <span class="badge bg-primary ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Vous êtes le chef de projet">
                                    <i class="bi bi-star-fill"></i> Lead
                                </span>
                            @endif
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted small">
                            <i class="bi bi-building me-1"></i> {{ $projet->entreprise->name ?? 'N/A' }}
                        </h6>

                        <p class="card-text text-truncate-3" style="font-size: 0.9rem;">
                            {{ $projet->description ?? 'Aucune description disponible.' }}
                        </p>

                        <div class="mb-2">
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $projet->status)) }}
                            </span>
                            @if ($projet->team)
                                <span class="badge bg-info text-dark ms-2">
                                    <i class="bi bi-people-fill me-1"></i> Équipe: {{ $projet->team->name }}
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <p class="text-muted small mb-1">
                                <i class="bi bi-list-task me-1"></i> Tâches du projet: {{ $completedProjectTasks }} / {{ $totalProjectTasks }}
                            </p>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-muted small text-end mt-1">{{ $progressPercentage }}% du projet terminé</p>
                        </div>

                        <div class="row text-muted small mb-3">
                            <div class="col-6">
                                <p class="mb-0"><i class="bi bi-chat-dots me-1"></i> Commentaires: {{ $projet->comments->count() }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0"><i class="bi bi-file-earmark me-1"></i> Fichiers: {{ $projet->files->count() }}</p>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('employe.projects.show', $projet) }}" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-eye me-1"></i> Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle-fill me-2"></i> Aucun projet trouvé correspondant à votre recherche ou filtre.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Add Bootstrap Icons and Tooltip initialization if not already included in your layout --}}
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection