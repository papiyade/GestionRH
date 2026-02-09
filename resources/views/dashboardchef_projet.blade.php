@extends('layouts.chef_projet')

@section('content')

<style>
    .dashboard-gradient-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(174, 61, 125, 0.3);
    }

    .stat-card-dashboard {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card-dashboard:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .stat-icon-dashboard {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .table-card-modern {
        background: white;
        border-radius: 16px;
        border: 1px solid #727272;
        overflow: hidden;
        shadow: 0 4px 12px rgba(98, 98, 98, 0.1);
    }

    .table-card-header {
        background: linear-gradient(90deg, rgba(174, 61, 125, 0.05) 0%, rgba(228, 110, 47, 0.05) 100%);
        border-bottom: 2px solid #E46E2F;
        padding: 1.25rem 1.5rem;
    }

    .table-modern {
        margin: 0;
    }

    .table-modern thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }

    .table-modern thead th {
        padding: 1rem 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
        border: none;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-modern tbody tr:hover {
        background: linear-gradient(90deg, rgba(174, 61, 125, 0.02) 0%, rgba(228, 110, 47, 0.02) 100%);
    }

    .avatar-modern {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        /* border: 0px solid white; */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .avatar-group-modern {
        display: flex;
        align-items: center;
    }

    .avatar-group-modern .avatar-modern {
        margin-left: -8px;
    }

    .avatar-group-modern .avatar-modern:first-child {
        margin-left: 0;
    }

    .progress-modern {
        height: 8px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-gradient {
        background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .badge-status {
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge-not-started {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1), rgba(108, 117, 125, 0.05));
        color: #6c757d;
    }

    .badge-in-progress {
        background: linear-gradient(135deg, rgba(228, 110, 47, 0.1), rgba(228, 110, 47, 0.05));
        color: #E46E2F;
    }

    .badge-completed {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
        color: #28a745;
    }

    .pagination-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-radius: 0 0 14px 14px;
    }

    .pagination-modern .page-link {
        background: white;
        border: 2px solid #e9ecef;
        color: #AE3D7D;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .pagination-modern .page-link:hover:not(.disabled) {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        border-color: transparent;
    }

    .pagination-modern .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #adb5bd;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border: none;
        color: white !important;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(174, 61, 125, 0.4);
        color: white !important;
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="dashboard-gradient-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 fw-bold mb-2">Bienvenue, {{ Auth::user()->name }} !</h1>
                <p class="mb-0 opacity-90">Suivez l'évolution de vos projets et tâches en temps réel</p>
            </div>
            <div class="text-end">
                <div class="small opacity-75 mb-1">Aujourd'hui</div>
                <div class="h5 mb-0">{{ now()->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card-dashboard card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon-dashboard">
                        <i class="ti ti-folders icon-plus"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-muted text-uppercase mb-1">Projets</div>
                        <div class="stat-value">{{ $projectCount }}</div>
                    </div>
                </div>
                <p class="text-muted mb-0 small">Nombre total de projets</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card-dashboard card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon-dashboard">
                        <i class="ti ti-users icon-plus"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-muted text-uppercase mb-1">Équipes</div>
                        <div class="stat-value">{{ $teamCount }}</div>
                    </div>
                </div>
                <p class="text-muted mb-0 small">Nombre total d'équipes</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card-dashboard card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon-dashboard">
                        <i class="ti ti-user-check icon-plus"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-muted text-uppercase mb-1">Utilisateurs</div>
                        <div class="stat-value">{{ $userCount }}</div>
                    </div>
                </div>
                <p class="text-muted mb-0 small">Nombre total d'utilisateurs</p>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row g-4">
        <!-- Projects Table -->
        <div class="col-lg-7">
            <div class="table-card-modern">
                <div class="table-card-header card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="ti ti-layout-board-split me-2 text-primary"></i>
                            Aperçu des Projets
                        </h5>
                        <button class="btn btn-gradient-primary btn-sm">
                            <i class="ti ti-download me-1 icon-plus"></i>Exporter
                        </button>
                    </div>
                </div>

                <div class="table-responsive table-light">
                    <table class="table table-modern table-light">
                        <thead>
                            <tr>
                                <th>Projet</th>
                                <th>Lead</th>
                                <th>Progression</th>
                                <th>Équipe</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody id="projectTableBody">
                            @forelse($projects as $project)
                                <tr class="project-row">
                                    <td class="fw-semibold">{{ $project->title }}</td>
                                    <td>
                                        @php
                                            $lead = $project->members->where('pivot.is_lead', true)->first() ?? $project->members->first();
                                            $leadInitials = $lead ? collect(explode(' ', $lead->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('') : 'NA';
                                        @endphp
                                        @if($lead)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-modern">{{ $leadInitials }}</div>
                                                <span class="small">{{ Str::limit($lead->name, 15) }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted small">Aucun</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $total = $project->tasks->count();
                                            $completed = $project->tasks->where('status', 'completed')->count();
                                            $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                                        @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="flex-grow-1">
                                                <div class="progress-modern">
                                                    <div class="progress-bar-gradient" style="width: {{ $progress }}%"></div>
                                                </div>
                                            </div>
                                            <span class="small text-muted">{{ $progress }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group-modern">
                                            @foreach($project->members->take(3) as $member)
                                                @php
                                                    $initials = collect(explode(' ', $member->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('');
                                                @endphp
                                                <div class="avatar-modern" title="{{ $member->name }}">{{ $initials }}</div>
                                            @endforeach
                                            @if($project->members->count() > 3)
                                                <div class="avatar-modern">+{{ $project->members->count() - 3 }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'not_started' => 'badge-not-started',
                                                'in_progress' => 'badge-in-progress',
                                                'completed' => 'badge-completed'
                                            ];
                                            $statusLabels = [
                                                'not_started' => 'Non débuté',
                                                'in_progress' => 'En cours',
                                                'completed' => 'Terminé'
                                            ];
                                        @endphp
                                        <span class="badge-status {{ $statusClasses[$project->status] ?? 'badge-not-started' }}">
                                            {{ $statusLabels[$project->status] ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state card">
                                            <i class="ti ti-folder-off"></i>
                                            <h5>Aucun projet</h5>
                                            <p class="text-muted">Commencez par créer votre premier projet</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($projects->count() > 0)
                    <div class="pagination-modern table-light">
                        <div class="text-muted small">
                            Affichage de <span id="currentRange">1-{{ min(4, $projects->count()) }}</span>
                            sur <span id="totalResults">{{ $projects->count() }}</span> résultats
                        </div>
                        <div class="d-flex gap-2">
                            <a href="javascript:void(0);" class="page-link disabled btn-light" id="prevPage" onclick="changePage(-1)">
                                <i class="ti ti-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="page-link btn btn-sm btn-light" id="nextPage" onclick="changePage(1)">
                                <i class="ti ti-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="col-lg-5">
            <div class="table-card-modern table-light">
                <div class="table-card-header">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-list-check me-2 text-primary"></i>
                        Tâches Récentes
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Deadline</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $allTasks = $projects->flatMap->tasks->sortByDesc('created_at')->take(8);
                            @endphp
                            @forelse($allTasks as $task)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ Str::limit($task->title, 25) }}</div>
                                        <small class="text-muted">{{ $task->project->title ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($task->deadline)
                                            <div class="small">{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</div>
                                            @if(\Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'completed')
                                                <span class="badge bg-danger small">Retard</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $taskStatusClasses = [
                                                'not_started' => 'badge-not-started',
                                                'in_progress' => 'badge-in-progress',
                                                'completed' => 'badge-completed'
                                            ];
                                            $taskStatusLabels = [
                                                'not_started' => 'À faire',
                                                'in_progress' => 'En cours',
                                                'completed' => 'Terminée'
                                            ];
                                        @endphp
                                        <span class="badge-status {{ $taskStatusClasses[$task->status] ?? 'badge-not-started' }}">
                                            {{ $taskStatusLabels[$task->status] ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state py-5">
                                            <i class="ti ti-clipboard-off"></i>
                                            <h6>Aucune tâche</h6>
                                            <p class="text-muted small mb-0">Les tâches apparaîtront ici</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const rowsPerPage = 4;
    let currentPage = 1;
    const tableBody = document.getElementById("projectTableBody");
    const rows = Array.from(tableBody?.getElementsByClassName("project-row") || []);

    if (rows.length === 0) return;

    function displayRows() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? "" : "none";
        });

        document.getElementById("currentRange").textContent = `${start + 1}-${Math.min(end, rows.length)}`;
        updatePaginationButtons();
    }

    window.changePage = function(direction) {
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        if ((direction === -1 && currentPage > 1) || (direction === 1 && currentPage < totalPages)) {
            currentPage += direction;
            displayRows();
        }
    };

    function updatePaginationButtons() {
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        const prevBtn = document.getElementById("prevPage");
        const nextBtn = document.getElementById("nextPage");

        prevBtn.classList.toggle("disabled", currentPage === 1);
        nextBtn.classList.toggle("disabled", currentPage === totalPages);
    }

    displayRows();
});
</script>
@endpush

@endsection
