@extends('layout.employe')

@section('title', 'Mes Tâches')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        --primary-color: #AE3D7D;
        --primary-dark: #861254FF;
    }

    .page-header {
        background: var(--primary-gradient);
        padding: 2.5rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 0 0 24px 24px;
        box-shadow: 0 6px 24px rgba(174, 61, 125, 0.25);
    }

    .page-header h1 {
        color: white;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-header .subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--stat-color, var(--primary-gradient));
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-card.todo::before {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .stat-card.in-progress::before {
        background: linear-gradient(135deg, #0dcaf0 0%, #0891b2 100%);
    }

    .stat-card.completed::before {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .stat-card.overdue::before {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-card.todo .stat-icon {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    .stat-card.in-progress .stat-icon {
        background: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }

    .stat-card.completed .stat-icon {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .stat-card.overdue .stat-icon {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%) !important;
        line-height: 1;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .filters-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .form-select, .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.625rem 1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(174, 61, 125, 0.15);
    }

    .task-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        position: relative;
    }

    .task-card:hover {
        transform: translateX(4px);
        box-shadow: 0 6px 20px rgba(174, 61, 125, 0.15);
        border-left-color: var(--primary-color);
    }

    .task-card.priority-high {
        border-left-color: #dc3545;
    }

    .task-card.priority-medium {
        border-left-color: #ffc107;
    }

    .task-card.priority-low {
        border-left-color: #28a745;
    }

    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .task-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
        margin: 0;
        flex: 1;
    }

    .task-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }

    .badge-status {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-status.todo {
        background: #e9ecef;
        color: #495057;
    }

    .badge-status.in-progress {
        background: rgba(13, 202, 240, 0.15);
        color: #0891b2;
    }

    .badge-status.completed {
        background: rgba(40, 167, 69, 0.15);
        color: #157347;
    }

    .badge-priority {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-priority.high {
        background: rgba(220, 53, 69, 0.15);
        color: #c82333;
    }

    .badge-priority.medium {
        background: rgba(255, 193, 7, 0.15);
        color: #e0a800;
    }

    .badge-priority.low {
        background: rgba(40, 167, 69, 0.15);
        color: #157347;
    }

    .task-description {
        color: #6c757d;
        font-size: 0.938rem;
        line-height: 1.6;
        margin-bottom: 1.25rem;
    }

    .task-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #f1f3f5;
        font-size: 0.875rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
    }

    .meta-item i {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .meta-item strong {
        color: #495057;
    }

    .project-badge {
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.1) 0%, rgba(134, 18, 84, 0.1) 100%);
        color: var(--primary-dark);
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.813rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .deadline-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.813rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .deadline-badge.overdue {
        background: rgba(220, 53, 69, 0.15);
        color: #c82333;
    }

    .deadline-badge.soon {
        background: rgba(255, 193, 7, 0.15);
        color: #e0a800;
    }

    .deadline-badge.normal {
        background: rgba(108, 117, 125, 0.1);
        color: #495057;
    }

    .task-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .btn-view {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(174, 61, 125, 0.3);
        color: white;
    }

    .btn-secondary-custom {
        background: #f8f9fa;
        color: #495057;
        border: 2px solid #e9ecef;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-secondary-custom:hover {
        background: white;
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .empty-state i {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: #495057;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.05rem;
    }

    .pagination {
        margin-top: 2rem;
        justify-content: center;
    }

    .pagination .page-link {
        border: 2px solid #e9ecef;
        color: var(--primary-color);
        border-radius: 10px;
        margin: 0 0.25rem;
        padding: 0.625rem 1rem;
        font-weight: 600;
    }

    .pagination .page-link:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-gradient);
        border-color: transparent;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .task-header {
            flex-direction: column;
            align-items: start;
        }

        .task-meta {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <div class="container">
        <h2 style="display: flex; align-items: center; gap: 1rem; color:linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%) !important">
            <i class="ti ti-checkbox icon-plus"></i>
            Mes Tâches
        </h2>
        <p class="subtitle">Gérez vos tâches et suivez votre progression</p>
    </div>
</div>

<div class="container">
    <!-- Statistiques -->
    <div class="stats-container">
        <div class="stat-card todo">
            <div class="stat-icon">
                <i class="ti ti-circle-dot"></i>
            </div>
            <div class="stat-number">{{ $tasks->where('status', 'todo')->count() }}</div>
            <div class="stat-label">À faire</div>
        </div>

        <div class="stat-card in-progress">
            <div class="stat-icon">
                <i class="ti ti-progress"></i>
            </div>
            <div class="stat-number">{{ $tasks->where('status', 'in_progress')->count() }}</div>
            <div class="stat-label">En cours</div>
        </div>

        <div class="stat-card completed">
            <div class="stat-icon">
                <i class="ti ti-circle-check"></i>
            </div>
            <div class="stat-number">{{ $tasks->where('status', 'completed')->count() }}</div>
            <div class="stat-label">Terminées</div>
        </div>

        <div class="stat-card overdue">
            <div class="stat-icon">
                <i class="ti ti-alert-circle"></i>
            </div>
            <div class="stat-number">
                {{ $tasks->filter(function($task) {
                    return $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'completed';
                })->count() }}
            </div>
            <div class="stat-label">En retard</div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-card card">
<form method="GET" action="{{ route('tasks.my-tasks') }}" id="filterForm">
    <div class="filters-row">

        <div class="filter-group">
            <label>
                <i class="ti ti-filter"></i>
                Statut
            </label>
            <select name="status" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>À faire</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminées</option>
            </select>
        </div>

        <div class="filter-group">
            <label>
                <i class="ti ti-flag"></i>
                Priorité
            </label>
            <select name="priority" class="form-select">
                <option value="">Toutes les priorités</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Haute</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Basse</option>
            </select>
        </div>

        <div class="filter-group">
            <label>
                <i class="ti ti-folder"></i>
                Projet
            </label>
            <select name="project" class="form-select">
                <option value="">Tous les projets</option>
                @foreach($tasks->pluck('project')->unique('id') as $project)
                    @if($project)
                        <option value="{{ $project->id }}"
                            {{ request('project') == $project->id ? 'selected' : '' }}>
                            {{ $project->title }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>
                <i class="ti ti-search"></i>
                Recherche
            </label>
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Rechercher..."
                   value="{{ request('search') }}">
        </div>

        {{-- ✅ Bouton de soumission --}}
        <div class="filter-group d-flex align-items-end">
            <button type="submit" class="btn btn-primary">
                Appliquer
            </button>
        </div>

    </div>
</form>

    </div>

    <!-- Liste des tâches -->
    @forelse($tasks as $task)
        @php
            $deadline = $task->deadline ? \Carbon\Carbon::parse($task->deadline) : null;
            $isOverdue = $deadline && $deadline->isPast() && $task->status !== 'completed';
            $isSoon = $deadline && $deadline->diffInDays(now()) <= 3 && !$isOverdue;
        @endphp

        <div class="task-card priority-{{ $task->priority ?? 'low' }} card">
            <div class="task-header">
                <h3 class="task-title">{{ $task->title }}</h3>
                <div class="task-badges">
                    <span class="badge-status {{ $task->status ?? 'todo' }}">
                        @if($task->status == 'completed')
                            <i class="ti ti-circle-check"></i> Terminée
                        @elseif($task->status == 'in_progress')
                            <i class="ti ti-progress"></i> En cours
                        @else
                            <i class="ti ti-circle-dot"></i> À faire
                        @endif
                    </span>
                    <span class="badge-priority {{ $task->priority ?? 'low' }}">
                        <i class="ti ti-flag-filled"></i>
                        @if($task->priority == 'high')
                            Haute
                        @elseif($task->priority == 'medium')
                            Moyenne
                        @else
                            Basse
                        @endif
                    </span>
                </div>
            </div>

            @if($task->description)
                <p class="task-description">{{ Str::limit($task->description, 150) }}</p>
            @endif

            <div class="task-meta">
                @if($task->project)
                    <div class="meta-item">
                        <span class="project-badge">
                            <i class="ti ti-folder"></i>
                            {{ $task->project->name }}
                        </span>
                    </div>
                @endif

                @if($deadline)
                    <div class="meta-item">
                        <span class="deadline-badge {{ $isOverdue ? 'overdue' : ($isSoon ? 'soon' : 'normal') }}">
                            <i class="ti ti-calendar-event"></i>
                            {{ $deadline->format('d/m/Y') }}
                            @if($isOverdue)
                                (En retard)
                            @elseif($isSoon)
                                ({{ (int) $deadline->diffInDays(now()) }}j restants)
                            @endif
                        </span>
                    </div>
                @endif

                @if($task->users && $task->users->count() > 0)
                    <div class="meta-item">
                        <i class="ti ti-users"></i>
                        <strong>{{ $task->users->count() }}</strong> collaborateur{{ $task->users->count() > 1 ? 's' : '' }}
                    </div>
                @endif

                @if($task->comments)
                    <div class="meta-item">
                        <i class="ti ti-message-circle"></i>
                        <strong>{{ $task->comments->count() }}</strong> commentaire{{ $task->comments->count() > 1 ? 's' : '' }}
                    </div>
                @endif
            </div>

            <div class="task-actions">
                <a href="{{ route('tasks.show', $task->id) }}" class="btn-view icon-plus">
                    <i class="ti ti-eye icon-plus"></i>
                    Voir les détails
                </a>
                @if($task->status !== 'completed')
                    <a href="#" class="btn-secondary-custom btn-light">
                        <i class="ti ti-edit"></i>
                        Modifier
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state card">
            <i class="ti ti-clipboard-off"></i>
            <h3>Aucune tâche trouvée</h3>
            <p>Vous n'avez pas encore de tâches assignées ou aucune tâche ne correspond à vos critères de recherche.</p>
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $tasks->links() }}
    </div>
</div>

@endsection