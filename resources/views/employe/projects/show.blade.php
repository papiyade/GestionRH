@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Détail projet')

@section('content')

@php
    $priorityConfig = [
        'high' => ['label' => 'Haute', 'gradient' => 'linear-gradient(135deg, #dc3545, #c82333)', 'icon' => 'ti-arrow-up'],
        'medium' => ['label' => 'Moyenne', 'gradient' => 'linear-gradient(135deg, #ffc107, #e0a800)', 'icon' => 'ti-minus'],
        'low' => ['label' => 'Basse', 'gradient' => 'linear-gradient(135deg, #28a745, #218838)', 'icon' => 'ti-arrow-down'],
    ];

    $tasksByStatus = $tasks->groupBy('status');
    
    $statusConfig = [
        'not_started' => [
            'label' => 'Non débuté', 
            'icon' => 'ti-clock',
            'color' => '#6c757d',
            'tasks' => $tasksByStatus->get('not_started', collect())
        ],
        'in_progress' => [
            'label' => 'En cours', 
            'icon' => 'ti-bolt',
            'color' => '#E46E2F',
            'tasks' => $tasksByStatus->get('in_progress', collect())
        ],
        'completed' => [
            'label' => 'Terminée', 
            'icon' => 'ti-circle-check',
            'color' => '#28a745',
            'tasks' => $tasksByStatus->get('completed', collect())
        ],
    ];
@endphp

<style>
    .tasks-gradient-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(174, 61, 125, 0.3);
    }

    .search-box-tasks {
        background: white;
        border-radius: 16px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1.25rem 0.75rem 3rem;
        transition: all 0.3s ease;
    }

    .search-box-tasks:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    .search-icon-tasks {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #E46E2F;
        font-size: 1.2rem;
    }

    .stat-card-tasks {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        border: 2px solid #f0f0f0;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card-tasks:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .stat-icon-tasks {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 0.75rem;
    }

    .kanban-column-tasks {
        background: white;
        border-radius: 18px;
        border: 2px solid #f0f0f0;
        min-height: 500px;
    }

    .kanban-header-tasks {
        padding: 1.25rem;
        border-bottom: 3px solid;
        border-radius: 16px 16px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kanban-body-tasks {
        padding: 1rem;
        max-height: 70vh;
        overflow-y: auto;
    }

    .kanban-body-tasks::-webkit-scrollbar {
        width: 6px;
    }

    .kanban-body-tasks::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .kanban-body-tasks::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .task-card-employee {
        background: white;
        border: 2px solid #f0f0f0;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .task-card-employee:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .priority-badge-tasks {
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .user-badge-tasks {
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.1), rgba(228, 110, 47, 0.1));
        color: #AE3D7D;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .comment-section-tasks {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.75rem;
        margin-top: 0.75rem;
    }

    .comment-item-tasks {
        background: white;
        border-radius: 8px;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
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

    .btn-outline-gradient {
        background: white;
        border: 2px solid #AE3D7D;
        color: #AE3D7D;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-outline-gradient:hover {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        border-color: transparent;
    }

    .status-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.5rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: white;
    }

    .status-select-modern:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    /* DÉSACTIVÉ: Auto-submit */
    .status-select-modern:disabled {
        background: #f8f9fa;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .late-badge-tasks {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .empty-state-tasks {
        padding: 3rem 1rem;
        text-align: center;
        color: #adb5bd;
    }

    .empty-state-tasks i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    details summary {
        cursor: pointer;
        user-select: none;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.2s ease;
        list-style: none;
    }

    details summary::-webkit-details-marker {
        display: none;
    }

    details summary:hover {
        color: #E46E2F;
    }

    details[open] summary {
        color: #AE3D7D;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .status-badge-count-tasks {
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="tasks-gradient-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="display-6 fw-bold mb-2">
                    <i class="ti ti-clipboard-list me-2 icon-plus "></i>{{ $project->title }}
                </h1>
                <p class="mb-0 opacity-90">Mes tâches pour ce projet</p>
            </div>
            <a href="{{ route('employe.projects') }}" class="btn btn-light">
                <i class="ti ti-arrow-left me-1"></i>Retour aux projets
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-4 position-relative">
        <span class="search-icon-tasks">
            <i class="ti ti-search"></i>
        </span>
        <input type="text" id="taskSearch" class="form-control search-box-tasks" 
               placeholder=" Rechercher une tâche par titre...">
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        @foreach([
            ['text' => 'Total', 'count' => $tasks->count(), 'icon' => 'ti ti-list-check icon-plus'],
            ['text' => 'Non débuté', 'count' => $statusConfig['not_started']['tasks']->count(), 'icon' => 'ti ti-clock icon-plus'],
            ['text' => 'En cours', 'count' => $statusConfig['in_progress']['tasks']->count(), 'icon' => 'ti ti-bolt icon-plus'],
            ['text' => 'Terminées', 'count' => $statusConfig['completed']['tasks']->count(), 'icon' => 'ti ti-circle-check icon-plus'],
        ] as $stat)
            <div class="col-md-3">
                <div class="stat-card-tasks card">
                    <div class="stat-icon-tasks"><i class="{{ $stat['icon'] }}"></i></div>
                    <h3 class="fw-bold mb-1">{{ $stat['count'] }}</h3>
                    <p class="text-muted mb-0 small">{{ $stat['text'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Kanban Columns -->
    <div class="row g-3">
        @foreach($statusConfig as $statusKey => $status)
            <div class="col-lg-4">
                <div class="kanban-column-tasks card">
                    <div class="kanban-header-tasks" style="border-color: {{ $status['color'] }};">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="ti {{ $status['icon'] }}" style="color: {{ $status['color'] }};"></i>
                            {{ $status['label'] }}
                        </h5>
                        <span class="status-badge-count-tasks" style="background: {{ $status['color'] }};">
                            {{ $status['tasks']->count() }}
                        </span>
                    </div>
                    
                    <div class="kanban-body-tasks">
                        @forelse($status['tasks']->sortByDesc('priority') as $task)
                            @php
                                $priority = $priorityConfig[$task->priority] ?? ['label' => 'Inconnue', 'gradient' => '#6c757d', 'icon' => 'ti-circle'];
                            @endphp
                            
                            <div class="task-card-employee card" data-titre="{{ strtolower($task->title) }}">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 flex-grow-1">{{ $task->title }}</h6>
                                    <span class="priority-badge-tasks" style="background: {{ $priority['gradient'] }};">
                                        <i class="ti {{ $priority['icon'] }} icon-plus"></i>
                                        {{ $priority['label'] }}
                                    </span>
                                </div>

                                <!-- Description -->
                                @if($task->description)
                                    <p class="text-muted small mb-2">{{ Str::limit($task->description, 80) }}</p>
                                @endif

                                <!-- Deadline -->
                                @if($task->deadline)
                                    <div class="small text-muted mb-2">
                                        <i class="ti ti-calendar me-1"></i>{{ $task->deadline->format('d/m/Y') }}
                                        @if($task->deadline->isPast() && $task->status !== 'completed')
                                            <span class="late-badge-tasks ms-1">En retard</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Assigned Users -->
                                <div class="mb-3">
                                    @forelse($task->users as $user)
                                        <span class="user-badge-tasks me-1">{{ $user->name }}</span>
                                    @empty
                                        <span class="text-muted small">Non assigné</span>
                                    @endforelse
                                </div>

                                <!-- Change Status - AVEC CONFIRMATION -->
                                <div class="mb-3">
                                    <label class="small text-muted mb-1">Changer le statut</label>
                                    <form action="{{ route('employe.tasks.changerStatut', $task) }}" method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir changer le statut de cette tâche ?')">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex gap-2">
                                            <select name="status" class="form-select status-select-modern flex-grow-1">
                                                @foreach(App\Models\Task::statuses() as $sKey => $sLabel)
                                                    <option value="{{ $sKey }}" {{ $task->status === $sKey ? 'selected' : '' }}>
                                                        {{ $sLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-gradient-primary btn-sm">
                                                <i class="ti ti-check icon-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Comments Section -->
                                <details class="mb-2">
                                    <summary class="small d-flex align-items-center gap-1">
                                        <i class="ti ti-message-circle"></i>
                                        Commentaires ({{ $task->comments->count() }})
                                    </summary>
                                    <div class="comment-section-tasks mt-2 card">
                                        <div style="max-height: 120px; overflow-y: auto;">
                                            @forelse($task->comments as $comment)
                                                <div class="comment-item-tasks card">
                                                    <strong class="text-dark">{{ $comment->user->name ?? 'Anonyme' }}</strong>
                                                    <p class="mb-0 small">{{ $comment->content }}</p>
                                                </div>
                                            @empty
                                                <p class="text-muted small mb-0">Aucun commentaire</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </details>

                                <!-- Add Comment Form -->
                                <form action="{{ route('employe.tasks.commenter', $task) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="content" class="form-control status-select-modern border-end-0" 
                                               placeholder="Ajouter un commentaire..." required>
                                        <button class="btn btn-gradient-primary" type="submit">
                                            <i class="ti ti-send icon-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div class="empty-state-tasks">
                                <i class="ti ti-inbox"></i>
                                <p class="mb-0">Aucune tâche</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('taskSearch');
    const taskCards = document.querySelectorAll('.task-card-employee');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        taskCards.forEach(card => {
            const title = card.getAttribute('data-titre');
            card.style.display = title.includes(query) ? '' : 'none';
        });
    });
});
</script>
@endpush

@endsection