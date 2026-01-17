@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Détail projet')
@section('content')

@php
    $priorityConfig = [
        'high' => ['label' => 'Haute', 'gradient' => 'linear-gradient(135deg, #dc3545, #c82333)', 'icon' => 'ic ti-arrow-up'],
        'medium' => ['label' => 'Moyenne', 'gradient' => 'linear-gradient(135deg, #ffc107, #e0a800)', 'icon' => 'ti-minus'],
        'low' => ['label' => 'Basse', 'gradient' => 'linear-gradient(135deg, #28a745, #218838)', 'icon' => 'ti-arrow-down'],
    ];

    $tasksByStatus = $projet->tasks->groupBy('status');

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
    .kanban-header-gradient {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(174, 61, 125, 0.3);
    }

    .search-box-modern {
        background: white;
        border-radius: 16px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
    }

    .search-box-modern:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    .stat-card-modern {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .stat-icon-modern {
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

    .kanban-column {
        background: white;
        border-radius: 16px;
        border: 2px solid #f0f0f0;
        min-height: 500px;
        transition: all 0.3s ease;
    }

    .kanban-column-header {
        padding: 1.25rem;
        border-bottom: 3px solid;
        border-radius: 14px 14px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kanban-column-body {
        padding: 1rem;
        max-height: 70vh;
        overflow-y: auto;
    }

    .kanban-column-body::-webkit-scrollbar {
        width: 6px;
    }

    .kanban-column-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .kanban-column-body::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .task-card-modern {
        background: white;
        border: 2px solid #f0f0f0;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .task-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .priority-badge-modern {
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .user-badge-modern {
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.1), rgba(228, 110, 47, 0.1));
        color: #AE3D7D;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .comment-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.75rem;
        margin-top: 0.75rem;
    }

    .comment-item {
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

    .btn-gradient-primary i,
    .btn-gradient-primary span,
    .btn-gradient-primary * {
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

    .modal-gradient .modal-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        border-radius: 16px 16px 0 0;
    }

    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    .empty-state-kanban {
        padding: 3rem 1rem;
        text-align: center;
        color: #adb5bd;
    }

    .empty-state-kanban i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .late-badge {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    details summary {
        cursor: pointer;
        user-select: none;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    details summary:hover {
        color: #E46E2F;
    }

    details[open] summary {
        color: #AE3D7D;
        font-weight: 600;
    }

    .ic {
        font-size: 1.2rem;
        color: #fff;
    }
</style>

<div class="container-fluid px-4 py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="kanban-header-gradient">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="display-6 fw-bold mb-2" style="color: #fff !important;">
                    <i class="ti ti-layout-kanban me-2 icon-plus"></i>{{ $projet->title }}
                </h1>
                <p class="mb-0 opacity-90 " style="color: #fff !important;">Gestion des tâches en mode Kanban</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="ti ti-plus me-1"></i>Nouvelle tâche
                </button>
                <a href="{{ route('projects.index') }}" class="btn btn-light">
                    <i class="ti ti-arrow-left me-1"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" id="taskSearch" class="form-control search-box-modern" placeholder="🔍 Rechercher une tâche par titre...">
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        @foreach([
            ['text' => 'Total', 'count' => $projet->tasks->count(), 'icon' => 'ic ti ti-border-all'],
            ['text' => 'Non débuté', 'count' => $statusConfig['not_started']['tasks']->count(), 'icon' => 'ic ti ti-progress-x'],
            ['text' => 'En cours', 'count' => $statusConfig['in_progress']['tasks']->count(), 'icon' => 'ic ti ti-progress'],
            ['text' => 'Terminées', 'count' => $statusConfig['completed']['tasks']->count(), 'icon' => 'ic ti ti-progress-check'],
        ] as $stat)
            <div class="col-md-3">
                <div class="stat-card-modern">
                    <div class="stat-icon-modern"><i class="{{ $stat['icon'] }}"></i></div>
                    <h3 class="text-center fw-bold mb-1">{{ $stat['count'] }}</h3>
                    <p class="text-center text-muted mb-0 small">{{ $stat['text'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Kanban Columns -->
    <div class="row g-3">
        @foreach($statusConfig as $statusKey => $status)
            <div class="col-lg-4">
                <div class="kanban-column">
                    <div class="kanban-column-header" style="border-color: {{ $status['color'] }};">
                        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="ti {{ $status['icon'] }}" style="color: {{ $status['color'] }};"></i>
                            {{ $status['label'] }}
                        </h5>
                        <span class="badge" style="background: {{ $status['color'] }};">{{ $status['tasks']->count() }}</span>
                    </div>

                    <div class="kanban-column-body">
                        @forelse($status['tasks']->sortByDesc('priority') as $task)
                            @php
                                $priority = $priorityConfig[$task->priority] ?? ['label' => 'Inconnue', 'gradient' => '#6c757d', 'icon' => 'ti-circle'];
                            @endphp

                            <div class="task-card-modern" data-titre="{{ strtolower($task->title) }}">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 flex-grow-1">{{ $task->title }}</h6>
                                    <span class="priority-badge-modern" style="background: {{ $priority['gradient'] }};">
                                        <i class="ti {{ $priority['icon'] }}"></i>
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
                                            <span class="late-badge ms-1">En retard</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Assigned Users -->
                                <div class="mb-3">
                                    @forelse($task->users as $user)
                                        <span class="user-badge-modern me-1">{{ $user->name }}</span>
                                    @empty
                                        <span class="text-muted small">Non assigné</span>
                                    @endforelse
                                </div>

                                <!-- Action Selects - COMMENTÉ POUR ÉVITER AUTO-REFRESH -->
                                <div class="row g-2 mb-3">
                                    {{-- <div class="col-6"> --}}
                                        <!--
                                        ⚠️ AUTO-SUBMIT DÉSACTIVÉ - Décommentez si besoin
                                        <form action="{{ route('projets.taches.changerPriorite', ['project'=>$projet,'tache'=>$task]) }}" method="POST">
                                            {{-- @csrf @method('PATCH') --}}
                                            <select name="priority" class="form-select-modern form-select-sm" onchange="this.form.submit()">
                                        -->
                                        {{-- <select class="form-select-modern form-select-sm" disabled>
                                            <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Basse</option>
                                            <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Moyenne</option>
                                            <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>Haute</option>
                                        </select> --}}
                                        <!-- </form> -->
                                    {{-- </div> --}}
                                    {{-- <div class="col-6"> --}}
                                        <!--
                                        ⚠️ AUTO-SUBMIT DÉSACTIVÉ - Décommentez si besoin
                                        <form action="{{ route('projets.taches.changerStatut', ['projet'=>$projet,'tache'=>$task]) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <select name="status" class="form-select-modern form-select-sm" onchange="this.form.submit()">
                                        -->
                                        {{-- <select class="form-select-modern form-select-sm" disabled>
                                            @foreach($statusConfig as $sKey => $sInfo)
                                                <option value="{{ $sKey }}" {{ $task->status === $sKey ? 'selected' : '' }}>
                                                    {{ $sInfo['label'] }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <!-- </form> -->
                                    {{-- </div> --}}
                                </div>

                                <!-- Comments Section -->
                                <details class="mb-2">
                                    <summary class="small">
                                        <i class="ti ti-message-circle me-1"></i>
                                        Commentaires ({{ $task->comments->count() }})
                                    </summary>
                                    <div class="comment-section mt-2">
                                        <div style="max-height: 120px; overflow-y: auto;">
                                            @forelse($task->comments as $comment)
                                                <div class="comment-item">
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
                                <form action="{{ route('projets.taches.ajouterCommentaire', ['projet' => $projet, 'tache' => $task]) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="content" class="form-control form-control-modern border-end-0" placeholder="Ajouter un commentaire..." required>
                                        <button class="btn btn-gradient-primary" type="submit">
                                            <i class="ti ti-send"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div class="empty-state-kanban">
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

<!-- Modal: Nouvelle Tâche -->
<div class="modal fade modal-gradient" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-plus me-2"></i>Créer une nouvelle tâche</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasks.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre *</label>
                            <input type="text" name="title" class="form-control form-control-modern" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control form-control-modern" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priorité *</label>
                            <select name="priority" class="form-select form-select-modern" required>
                                <option value="low">Basse</option>
                                <option value="medium" selected>Moyenne</option>
                                <option value="high">Haute</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date limite</label>
                            <input type="date" name="deadline" class="form-control form-control-modern" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Assigner à</label>
                            <select name="user_id" class="form-select form-select-modern">
                                <option value="">Sélectionner un membre</option>
                                @foreach($projet->members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-gradient" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Créer la tâche</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('taskSearch');
    const taskCards = document.querySelectorAll('.task-card-modern');

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
