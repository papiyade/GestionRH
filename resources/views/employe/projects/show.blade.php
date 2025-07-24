@extends('layouts.chef_projet')

@section('content')
@php
    // Définition des priorités pour un affichage dynamique
    $priorites = [
        'high' => ['label' => 'Haute', 'color' => 'danger', 'icon' => 'bi-arrow-up-circle-fill'],
        'medium' => ['label' => 'Moyenne', 'color' => 'warning', 'icon' => 'bi-dash-circle-fill'],
        'low' => ['label' => 'Basse', 'color' => 'success', 'icon' => 'bi-arrow-down-circle-fill'],
    ];

    // Groupement des tâches par statut pour les colonnes Kanban
    $tasksByStatus = $tasks->groupBy('status');

    $statuts = [
        'not_started' => ['label' => 'Non débuté', 'bg' => 'bg-light', 'icon' => 'bi-circle', 'tasks' => $tasksByStatus->get('not_started', collect())],
        'in_progress' => ['label' => 'En cours', 'bg' => 'bg-primary bg-opacity-10', 'icon' => 'bi-play-circle', 'tasks' => $tasksByStatus->get('in_progress', collect())],
        'completed' => ['label' => 'Terminée', 'bg' => 'bg-success bg-opacity-10', 'icon' => 'bi-check-circle', 'tasks' => $tasksByStatus->get('completed', collect())],
    ];
@endphp

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">
                <i class="bi bi-kanban me-2 text-primary"></i>
                {{ $project->title }}
            </h1>
            <p class="text-muted mb-0">Mes tâches pour ce projet</p>
        </div>
        <a href="{{ route('employe.projects') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour aux projets
        </a>
    </div>

    <div class="mb-4">
        <input type="text" id="taskSearch" class="form-control" placeholder="Rechercher une tâche par titre...">
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-list-task fs-4 text-primary me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $tasks->count() }}</div>
                                    <small class="text-muted">Total tâches</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-clock fs-4 text-secondary me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $statuts['not_started']['tasks']->count() }}</div>
                                    <small class="text-muted">Non débuté</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-play-circle fs-4 text-info me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $statuts['in_progress']['tasks']->count() }}</div>
                                    <small class="text-muted">En cours</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-check-circle fs-4 text-success me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $statuts['completed']['tasks']->count() }}</div>
                                    <small class="text-muted">Terminées</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($statuts as $keyStatut => $statut)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm {{ $statut['bg'] }}" style="min-height: 500px;">
                    <div class="card-header border-0 {{ $statut['bg'] }} py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="{{ $statut['icon'] }} me-2"></i>
                                {{ $statut['label'] }}
                            </h5>
                            <span class="badge bg-dark rounded-pill">{{ $statut['tasks']->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body overflow-auto" style="max-height: 70vh;">
                        @forelse($statut['tasks']->sortByDesc('priority') as $task)
                            @php
                                $prioColor = $priorites[$task->priority]['color'] ?? 'secondary';
                                $prioIcon = $priorites[$task->priority]['icon'] ?? 'bi-circle';
                            @endphp
                            <div class="card mb-3 border-0 shadow-sm task-card"
                                 style="transition: all 0.3s ease;"
                                 data-titre="{{ strtolower($task->title) }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0 fw-semibold" style="flex:1; line-height: 1.3;">
                                            {{ $task->title }}
                                        </h6>
                                        <span class="badge bg-{{ $prioColor }} ms-2 d-flex align-items-center" title="Priorité {{ $priorites[$task->priority]['label'] }}">
                                            <i class="{{ $prioIcon }} me-1" style="font-size: 0.8em;"></i>
                                            {{ $priorites[$task->priority]['label'] }}
                                        </span>
                                    </div>

                                    @if($task->description)
                                        <p class="text-muted small mb-2" style="line-height: 1.3;">
                                            {{ Str::limit($task->description, 80) }}
                                        </p>
                                    @endif

                                    @if($task->deadline)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar-event me-1"></i>
                                                {{ $task->deadline->format('d/m/Y') }}
                                                @if($task->deadline->isPast() && $task->status !== 'completed')
                                                    <span class="badge bg-danger ms-1">En retard</span>
                                                @endif
                                            </small>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="bi bi-person-fill me-1"></i>
                                            @if($task->users->isNotEmpty())
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($task->users as $user)
                                                        <span class="badge bg-light text-dark border fw-bold fs-6 px-3 py-1">
                                                            {{ $user->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <em class="text-muted">Non assigné</em>
                                            @endif
                                        </small>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-12">
                                            <form action="{{ route('employe.tasks.changerStatut', $task) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" title="Modifier statut">
                                                    @foreach(App\Models\Task::statuses() as $sKey => $sLabel)
                                                        <option value="{{ $sKey }}" {{ $task->status === $sKey ? 'selected' : '' }}>
                                                            {{ $sLabel }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="border-top pt-2">
                                        <details class="mb-2">
                                            <summary class="small text-muted" style="cursor: pointer;">
                                                <i class="bi bi-chat-dots me-1"></i>
                                                Commentaires ({{ $task->comments->count() }})
                                            </summary>
                                            <div class="mt-2" style="max-height: 120px; overflow-y: auto;">
                                                @forelse($task->comments as $comment)
                                                    <div class="small bg-light rounded p-2 mb-1">
                                                        <strong class="text-primary">{{ $comment->user->name ?? 'Anonyme' }}:</strong>
                                                        <div>{{ $comment->content }}</div>
                                                    </div>
                                                @empty
                                                    <p class="text-muted small">Aucun commentaire pour cette tâche.</p>
                                                @endforelse
                                            </div>
                                        </details>

                                        <form action="{{ route('employe.tasks.commenter', $task) }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="content" class="form-control border-0 bg-light" placeholder="Ajouter un commentaire..." required>
                                                <button class="btn btn-primary" type="submit" title="Envoyer">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">Aucune tâche dans cette colonne</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.08);
}

.badge {
    font-size: 0.75em;
}

details summary {
    transition: color 0.2s ease;
}

details summary:hover {
    color: var(--bs-primary) !important;
}

.form-select:focus,
.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    border-color: #86b7fe;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 0 15px;
    }

    .col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<script>
document.addEventListener('DOMContentLoaded', function() {
    const taskCards = document.querySelectorAll('.task-card');
    taskCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    const selects = document.querySelectorAll('select[name="status"]');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            const taskTitle = this.closest('.task-card').querySelector('.card-title').textContent.trim();
            const newValue = this.options[this.selectedIndex].text;

            if (confirm(`Voulez-vous vraiment changer le statut de "${taskTitle}" vers "${newValue}" ?`)) {
                this.form.submit();
            } else {
                this.selectedIndex = Array.from(this.options).findIndex(option => option.hasAttribute('selected'));
            }
        });
    });

    const searchInput = document.getElementById('taskSearch');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const allTaskCards = document.querySelectorAll('.task-card');

        allTaskCards.forEach(card => {
            const title = card.getAttribute('data-titre');
            if (title.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection