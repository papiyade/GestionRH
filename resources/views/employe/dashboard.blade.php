@extends('layout.employe')

@section('title', 'Tableau de Bord')
@section('page-title', 'Répertoire statistique')

@section('content')
    <style>
        .dashboard-modern {
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Header Section */
        .header-gradient {
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            border-radius: 16px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 8px 24px rgba(174, 61, 125, 0.25);
        }

        .breadcrumb-modern {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            margin: 0;
        }

        .breadcrumb-modern .breadcrumb-item {
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }

        .breadcrumb-modern .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(174, 61, 125, 0.15);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Task Card */
        .task-card {
            background: white;
            border-radius: 12px;
            border: 2px solid #f0f0f0;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .task-card:hover {
            border-color: #E46E2F;
            box-shadow: 0 4px 12px rgba(228, 110, 47, 0.15);
        }

        .task-priority-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .priority-high {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .priority-medium {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #000;
        }

        .priority-low {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .task-progress {
            height: 6px;
            background: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .task-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .task-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .task-meta i {
            color: #E46E2F;
        }

        /* Project Card */
        .project-card {
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            border: 2px solid #f0f0f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .project-card:hover {
            transform: translateY(-4px);
            border-color: #AE3D7D;
            box-shadow: 0 8px 20px rgba(174, 61, 125, 0.15);
        }

        .project-status {
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            color: white;
            padding: 0.25rem 0.7rem;
            /* au lieu de 0.4rem 1rem */
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            width: fit-content;
            white-space: nowrap;
            max-width: 110px;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;

        }

        .btn-gradient {
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(174, 61, 125, 0.3);
            color: white;
        }

        .section-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: #E46E2F;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        /* Status Badges */
        .status-completed {
            color: #28a745;
            font-weight: 600;
        }

        .status-progress {
            color: #ffc107;
            font-weight: 600;
        }

        .status-pending {
            color: #6c757d;
            font-weight: 600;
        }
    </style>

    <div class="dashboard-modern bodyInterface">
        <!-- Header -->
        <div class="header-gradient">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-2 text-white" style="color: #fff !important;">Tableau de Bord</h2>
                    <nav>
                        <ol class="breadcrumb breadcrumb-modern">
                            <li class="breadcrumb-item">
                                <a href="#" class="text-white icon-plus"><i class="ti ti-smart-home me-1 icon-plus"></i>Accueil</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard Employé</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">
                            <i class="ti ti-list-check icon-plus"></i>
                        </div>
                        <div>
                            <div class="stat-label">Mes Tâches</div>
                            <div class="stat-value">{{ $totalTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">
                            <i class="ti ti-clock icon-plus"></i>
                        </div>
                        <div>
                            <div class="stat-label">Tâches en Cours</div>
                            <div class="stat-value">{{ $inProgressTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">
                            <i class="ti ti-circle-check icon-plus"></i>
                        </div>
                        <div>
                            <div class="stat-label">Tâches Terminées</div>
                            <div class="stat-value">{{ $completedTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon">
                            <i class="ti ti-folder icon-plus"></i>
                        </div>
                        <div>
                            <div class="stat-label">Total Projets</div>
                            <div class="stat-value">{{ $projects->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="section-card card">
            <div class="section-header">
                <h5 class="section-title mb-0">
                    <i class="ti ti-clock-hour-4"></i>
                    Tâches Récentes
                </h5>
                <a href="{{ route('employe.projects') }}" class="btn btn-gradient btn-sm text-white"
                    style="margin-left: 2px;">Voir tout</a>
            </div>

            @forelse($recentTasks as $task)
                <div class="task-card card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ $task->title }}</h6>
                            <div class="task-meta">
                                <span><i class="ti ti-folder me-1"></i>{{ $task->project->title ?? 'N/A' }}</span>
                                <span>
                                    @if ($task->status === 'completed')
                                        <span class="status-completed">✓ Terminée</span>
                                    @elseif($task->status === 'in progress')
                                        <span class="status-progress">⏳ En cours</span>
                                    @else
                                        <span class="status-pending">○ En attente</span>
                                    @endif
                                </span>
                                <span><i
                                        class="ti ti-calendar me-1"></i>{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <span
                            class="task-priority-badge
                                @if ($task->priority === \App\Models\Task::PRIORITY_HIGH) priority-high
                                @elseif($task->priority === \App\Models\Task::PRIORITY_MEDIUM) priority-medium
                                @else priority-low @endif">
                            {{ \App\Models\Task::priorities()[$task->priority] ?? '—' }}
                        </span>
                    </div>
                    <div class="task-progress mb-2">
                        <div class="task-progress-bar" style="width: {{ $task->progress ?? 0 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="task-meta">
                            <span><i class="ti ti-message-circle me-1"></i>{{ $task->comments->count() }}</span>
                            <span><i class="ti ti-paperclip me-1"></i>{{ $task->files->count() }}</span>
                        </div>
                        <small class="text-muted">{{ $task->progress ?? 0 }}%</small>
                    </div>
                </div>
            @empty
                <div class="empty-state card">
                    <i class="ti ti-clipboard-off"></i>
                    <p class="mb-0 info-label">Aucune tâche récente</p>
                </div>
            @endforelse
        </div>

        <!-- Projects -->
        <div class="section-card card">
            <div class="section-header">
                <h5 class="section-title mb-0">
                    <i class="ti ti-briefcase"></i>
                    Mes Projets
                </h5>
            </div>

            @if ($projects->isEmpty())
                <div class="empty-state card">
                    <i class="ti ti-folder-off"></i>
                    <p class="mb-0 info-label" style="color:#5f5f5f !important;"
                    >Aucun projet pour le moment</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach ($projects as $project)
                        <div class="col-md-4">
                            <div class="project-card card">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="btn btn-sm btn-gradient">
                                        @if ($project->status === 'not_started')
                                            Non débuté
                                        @elseif ($project->status === 'in_progress')
                                            En cours
                                        @elseif ($project->status === 'completed')
                                            Terminée
                                        @else
                                            —
                                        @endif
                                    </span>

                                    <small class="text-muted">{{ $project->created_at->format('d/m/Y') }}</small>
                                </div>
                                <h6 class="fw-bold mb-2">{{ $project->title }}</h6>
                                <p class="text-muted small mb-3">{{ Str::limit($project->description ?? '', 80) }}</p>
                                <a href="{{ route('projects.show', $project) }}"
                                {{ $project->title }}
                                    class="btn btn-gradient text-white btn-sm w-100">
                                    <i class="ti ti-eye me-1"></i>Voir le projet
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
