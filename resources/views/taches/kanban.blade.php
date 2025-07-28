@extends('layouts.chef_projet')

@section('content')
@php
    // Tableau des priorités avec couleurs bootstrap (couleur pour badge et bordure)
    $priorites = [
        'high' => ['label' => 'Haute', 'color' => 'danger', 'icon' => 'bi-arrow-up-circle-fill'],
        'medium' => ['label' => 'Moyenne', 'color' => 'warning', 'icon' => 'bi-dash-circle-fill'],
        'low' => ['label' => 'Basse', 'color' => 'success', 'icon' => 'bi-arrow-down-circle-fill'],
    ];

    // Statuts avec couleur de fond de la colonne
    $statuts = [
        'not_started' => ['label' => 'Non débuté', 'bg' => 'bg-light', 'icon' => 'bi-circle', 'count' => $projet->tasks->where('status', 'not_started')->count()],
        'in_progress' => ['label' => 'En cours', 'bg' => 'bg-primary bg-opacity-10', 'icon' => 'bi-play-circle', 'count' => $projet->tasks->where('status', 'in_progress')->count()],
        'completed' => ['label' => 'Terminée', 'bg' => 'bg-success bg-opacity-10', 'icon' => 'bi-check-circle', 'count' => $projet->tasks->where('status', 'completed')->count()],
    ];
@endphp

<div class="container-fluid px-4">
    <!-- En-tête avec actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">
                <i class="bi bi-kanban me-2 text-primary"></i>
                {{ $projet->title }}
            </h1>
            <p class="text-muted mb-0">Gestion des tâches du projet</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-circle me-1"></i>
                Nouvelle tâche
            </button>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Retour aux projets
            </a>
        </div>
    </div>

    <!-- Champ Recherche -->
    <div class="mb-4">
        <input type="text" id="taskSearch" class="form-control" placeholder="Rechercher une tâche par titre...">
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-list-task fs-4 text-primary me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $projet->tasks->count() }}</div>
                                    <small class="text-muted">Total tâches</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-clock fs-4 text-warning me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $statuts['not_started']['count'] }}</div>
                                    <small class="text-muted">À faire</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-play-circle fs-4 text-info me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $statuts['in_progress']['count'] }}</div>
                                    <small class="text-muted">En cours</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-check-circle fs-4 text-success me-2"></i>
                                <div>
                                    <div class="fs-5 fw-bold">{{ $statuts['completed']['count'] }}</div>
                                    <small class="text-muted">Terminées</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau Kanban -->
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
                            <span class="badge bg-dark rounded-pill">{{ $statut['count'] }}</span>
                        </div>
                    </div>
                    <div class="card-body overflow-auto" style="max-height: 70vh;">
                        @forelse($projet->tasks->where('status', $keyStatut)->sortByDesc('priority') as $tache)
                            @php
                                $prioColor = $priorites[$tache->priority]['color'] ?? 'secondary';
                                $prioIcon = $priorites[$tache->priority]['icon'] ?? 'bi-circle';
                            @endphp
                            <div class="card mb-3 border-0 shadow-sm task-card" 
                                 style="transition: all 0.3s ease;" 
                                 data-titre="{{ strtolower($tache->title) }}">
                                <div class="card-body p-3">
                                    <!-- En-tête de la tâche -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0 fw-semibold" style="flex:1; line-height: 1.3;">
                                            {{ $tache->title }}
                                        </h6>
                                        <span class="badge bg-{{ $prioColor }} ms-2 d-flex align-items-center" title="Priorité {{ $priorites[$tache->priority]['label'] }}">
                                            <i class="{{ $prioIcon }} me-1" style="font-size: 0.8em;"></i>
                                            {{ $priorites[$tache->priority]['label'] }}
                                        </span>
                                    </div>

                                    <!-- Description si présente -->
                                    @if($tache->description)
                                        <p class="text-muted small mb-2" style="line-height: 1.3;">
                                            {{ Str::limit($tache->description, 80) }}
                                        </p>
                                    @endif

                                    <!-- Deadline si présente -->
                                    @if($tache->deadline)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar-event me-1"></i>
                                                {{ \Carbon\Carbon::parse($tache->deadline)->format('d/m/Y') }}
                                                @if(\Carbon\Carbon::parse($tache->deadline)->isPast() && $tache->status !== 'completed')
                                                    <span class="badge bg-danger ms-1">En retard</span>
                                                @endif
                                            </small>
                                        </div>
                                    @endif

                                    <!-- Utilisateurs assignés -->
                                    <div class="mb-3">
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="bi bi-person-fill me-1"></i>
                                            @if($tache->users->isNotEmpty())
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($tache->users as $user)
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

                                    <!-- Actions de modification -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <form action="{{ route('projets.taches.changerPriorite', ['project' => $projet, 'tache' => $tache]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()" title="Modifier priorité">
                                                    @foreach($priorites as $pKey => $p)
                                                        <option value="{{ $pKey }}" {{ $tache->priority === $pKey ? 'selected' : '' }}>
                                                            {{ $p['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                        <div class="col-6">
                                            <form action="{{ route('projets.taches.changerStatut', ['projet' => $projet, 'tache' => $tache]) }}" method="POST">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" title="Modifier statut">
                                                    @foreach($statuts as $sKey => $s)
                                                        <option value="{{ $sKey }}" {{ $tache->status === $sKey ? 'selected' : '' }}>
                                                            {{ $s['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Section commentaires -->
                                    <div class="border-top pt-2">
                                        <details class="mb-2">
                                            <summary class="small text-muted" style="cursor: pointer;">
                                                <i class="bi bi-chat-dots me-1"></i>
                                                Commentaires ({{ $tache->comments->count() }})
                                            </summary>
                                            <div class="mt-2" style="max-height: 120px; overflow-y: auto;">
                                                @foreach($tache->comments as $comment)
                                                    <div class="small bg-light rounded p-2 mb-1">
                                                        <strong class="text-primary">{{ $comment->user->name ?? 'Anonyme' }}:</strong>
                                                        <div>{{ $comment->content }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>

                                        <!-- Ajouter commentaire -->
                                        <form action="{{ route('projets.taches.ajouterCommentaire', ['projet' => $projet, 'tache' => $tache]) }}" method="POST">
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

<!-- Modal d'ajout de tâche -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTaskModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>
                    Créer une nouvelle tâche
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tasks.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label fw-semibold">Titre de la tâche *</label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="Entrez le titre de la tâche">
                        </div>
                        
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description détaillée de la tâche (optionnel)"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="priority" class="form-label fw-semibold">Priorité *</label>
                            <select class="form-select" id="priority" name="priority" required>
                                @foreach($priorites as $pKey => $p)
                                    <option value="{{ $pKey }}" {{ $pKey === 'medium' ? 'selected' : '' }}>
                                        {{ $p['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>            

                        <div class="col-md-6">
                            <label for="deadline" class="form-label fw-semibold">Date limite</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-12">
                            <label for="user_id" class="form-label fw-semibold">Assigner à</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">Sélectionner un membre (optionnel)</option>
                                @foreach($projet->members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Seuls les membres du projet peuvent être assignés à une tâche.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Créer la tâche
                    </button>
                </div>
            </form>
        </div>
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

.modal-content {
    border-radius: 0.5rem;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour les cartes de tâches
    const taskCards = document.querySelectorAll('.task-card');
    taskCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto-submit des formulaires de changement de statut/priorité avec confirmation
    const selects = document.querySelectorAll('select[name="status"], select[name="priority"]');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            const taskTitle = this.closest('.task-card').querySelector('.card-title').textContent.trim();
            const actionType = this.name === 'status' ? 'statut' : 'priorité';
            const newValue = this.options[this.selectedIndex].text;
            
            if (confirm(`Voulez-vous vraiment changer le ${actionType} de "${taskTitle}" vers "${newValue}" ?`)) {
                this.form.submit();
            } else {
                // Restaurer la valeur précédente si annulé
                this.selectedIndex = Array.from(this.options).findIndex(option => option.hasAttribute('selected'));
            }
        });
    });

    // Recherche par titre de tâche
    const searchInput = document.getElementById('taskSearch');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();

        taskCards.forEach(card => {
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

@endsection
