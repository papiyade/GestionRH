@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Mes projets')

@section('content')

<style>
    .projects-gradient-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(174, 61, 125, 0.3);
    }

    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 2px solid #f0f0f0;
        margin-bottom: 2rem;
    }

    .search-input-modern {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.75rem 1rem 0.75rem 3rem;
        transition: all 0.3s ease;
    }

    .search-input-modern:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    .search-icon-wrapper {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #E46E2F;
    }

    .filter-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    .kanban-column-modern {
        background: white;
        border-radius: 18px;
        border: 2px solid #f0f0f0;
        min-height: 500px;
        transition: all 0.3s ease;
    }

    .kanban-header-modern {
        padding: 1.25rem;
        border-bottom: 3px solid;
        border-radius: 16px 16px 0 0;
    }

    .kanban-header-modern.not-started {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1), rgba(108, 117, 125, 0.05));
        border-bottom-color: #6c757d;
    }

    .kanban-header-modern.in-progress {
        background: linear-gradient(135deg, rgba(228, 110, 47, 0.1), rgba(228, 110, 47, 0.05));
        border-bottom-color: #E46E2F;
    }

    .kanban-header-modern.completed {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
        border-bottom-color: #28a745;
    }

    .kanban-body {
        padding: 1rem;
        max-height: 75vh;
        overflow-y: auto;
    }

    .kanban-body::-webkit-scrollbar {
        width: 6px;
    }

    .kanban-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .kanban-body::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .project-card-modern {
        background: white;
        border: 2px solid #f0f0f0;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .project-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .project-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-title:hover {
        color: #E46E2F;
    }

    .project-description {
        color: #6c757d;
        font-size: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .leader-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(174, 61, 125, 0.3);
    }

    .member-avatar-mini {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.75rem;
        margin-left: -8px;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .member-avatar-mini:first-child {
        margin-left: 0;
    }

    .badge-role {
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.1), rgba(228, 110, 47, 0.1));
        color: #AE3D7D;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .progress-modern {
        height: 6px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-gradient {
        background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
        transition: width 0.4s ease;
    }

    .stat-badge {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.5rem 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        border: 1px solid #e9ecef;
    }

    .stat-badge i {
        color: #E46E2F;
    }

    .empty-state-kanban {
        padding: 3rem 1rem;
        text-align: center;
        color: #adb5bd;
    }

    .empty-state-kanban i {
        font-size: 3.5rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .dropdown-toggle-modern {
        background: none;
        border: none;
        color: #6c757d;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .dropdown-toggle-modern:hover {
        background: #f8f9fa;
        color: #E46E2F;
    }

    .deadline-badge {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        padding: 0.35rem 0.75rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
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

    .status-badge-count {
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .status-badge-count.not-started {
        background: #6c757d;
        color: white;
    }

    .status-badge-count.in-progress {
        background: #E46E2F;
        color: white;
    }

    .status-badge-count.completed {
        background: #28a745;
        color: white;
    }
</style>

<!-- Header -->
<div class="projects-gradient-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="display-6 fw-bold mb-2 icon-plus">
                <i class="ti ti-folders icon-plus me-2"></i>Mes Projets
            </h2>
            <p class="mb-0 opacity-90">Gérez et suivez vos projets en cours</p>
        </div>
        <a href="{{ route('employe.dashboard') }}" class="btn btn-light">
            <i class="ti ti-arrow-left me-1"></i>Retour au dashboard
        </a>
    </div>
</div>

<!-- Filters -->
<div class="filter-card card">
    <form method="GET" action="{{ route('employe.projects') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="position-relative">
                    <span class="search-icon-wrapper">
                        <i class="ti ti-search fs-15"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control search-input-modern" 
                        placeholder="Rechercher un projet par titre ou description..."
                        value="{{ request('search') }}"
                    >
                </div>
            </div>
            <div class="col-md-4">
                <select name="status_filter" class="form-select filter-select">
                    <option value="">Tous les statuts</option>
                    <option value="not_started" {{ request('status_filter') == 'not_started' ? 'selected' : '' }}>
                        Non débutés
                    </option>
                    <option value="in_progress" {{ request('status_filter') == 'in_progress' ? 'selected' : '' }}>
                        En cours
                    </option>
                    <option value="completed" {{ request('status_filter') == 'completed' ? 'selected' : '' }}>
                        Terminés
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-gradient-primary w-100">
                    <i class="ti ti-filter me-1 icon-plus"></i>Filtrer
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Kanban Columns -->
<div class="row g-3">
    @php
        $statuses = [
            'not_started' => ['label' => 'Non débutés', 'icon' => 'ti-clock', 'class' => 'not-started'],
            'in_progress' => ['label' => 'En cours', 'icon' => 'ti-bolt', 'class' => 'in-progress'],
            'completed' => ['label' => 'Terminés', 'icon' => 'ti-circle-check', 'class' => 'completed'],
        ];
    @endphp

    @foreach($statuses as $statusKey => $statusConfig)
        @php
            $statusProjects = $projets->where('status', $statusKey);
        @endphp
        
        <div class="col-lg-4">
            <div class="kanban-column-modern card">
                <div class="kanban-header-modern {{ $statusConfig['class'] }} card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="ti {{ $statusConfig['icon'] }}"></i>
                            {{ $statusConfig['label'] }}
                        </h5>
                        <span class="status-badge-count {{ $statusConfig['class'] }}">
                            {{ $statusProjects->count() }}
                        </span>
                    </div>
                </div>

                <div class="kanban-body card">
                    @forelse($statusProjects as $projet)
                        @php
                            $isLead = $projet->users()->where('user_id', Auth::id())->wherePivot('is_lead', true)->exists();
                            $totalTasks = $projet->tasks->count();
                            $completedTasks = $projet->tasks->where('status', 'completed')->count();
                            $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                            $leader = $projet->users->where('pivot.is_lead', true)->first() ?? $projet->users->first();
                            $leaderInitials = $leader ? collect(explode(' ', $leader->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('') : 'NA';
                        @endphp

                        <div class="project-card-modern card" onclick="window.location.href='{{ route('employe.projects.show', $projet) }}'">
                            {{ $projet->title }}
                            <!-- Header with Title and Menu -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <a href="{{ route('employe.projects.show', $projet) }}" class="project-title text-decoration-none flex-grow-1">
                                    {{ $projet->title }}
                                </a>
                                <div class="dropdown" onclick="event.stopPropagation()">
                                    <button class="dropdown-toggle-modern" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a href="{{ route('employe.projects.show', $projet) }}" class="dropdown-item">
                                                {{ $projet->title }}
                                                <i class="ti ti-eye me-2"></i>Voir détails
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('projets.taches', $projet) }}" class="dropdown-item">
                                                <i class="ti ti-list-check me-2"></i>Voir tâches
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($projet->description)
                                <p class="project-description mb-3">{{ $projet->description }}</p>
                            @endif

                            <!-- Leader & Deadline -->
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #f0f0f0;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="leader-avatar">{{ $leaderInitials }}</div>
                                    <div>
                                        <div class="fw-semibold small text-dark">{{ $leader->name ?? 'N/A' }}</div>
                                        <span class="badge-role">{{ $isLead ? 'Leader' : 'Membre' }}</span>
                                    </div>
                                </div>
                                @if($projet->deadline)
                                    <div class="text-end">
                                        <div class="deadline-badge">
                                            <i class="ti ti-calendar"></i>
                                            {{ \Carbon\Carbon::parse($projet->deadline)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Progress -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small text-muted">Progression</span>
                                    <span class="small fw-bold">{{ $progressPercentage }}%</span>
                                </div>
                                <div class="progress-modern">
                                    <div class="progress-bar-gradient" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>

                            <!-- Stats & Members -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2">
                                    <div class="stat-badge card">
                                        <i class="ti ti-list-check"></i>
                                        <span>{{ $completedTasks }}/{{ $totalTasks }}</span>
                                    </div>
                                    @if($projet->comments->count() > 0)
                                        <div class="stat-badge card">
                                            <i class="ti ti-message-circle"></i>
                                            <span>{{ $projet->comments->count() }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Members Avatars -->
                                <div class="d-flex" style="padding-left: 8px;">
                                    @foreach($projet->users->take(3) as $user)
                                        @php
                                            $userInitials = collect(explode(' ', $user->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('');
                                        @endphp
                                        <div class="member-avatar-mini" title="{{ $user->name }}">
                                            {{ $userInitials }}
                                        </div>
                                    @endforeach
                                    @if($projet->users->count() > 3)
                                        <div class="member-avatar-mini" title="{{ $projet->users->count() - 3 }} autres membres">
                                            +{{ $projet->users->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-kanban">
                            <i class="ti ti-folder-off"></i>
                            <p class="mb-0">Aucun projet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection