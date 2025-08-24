@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Détail projet')
@section('content')
@php
    $priorites = [
        'high' => ['label' => 'Haute', 'color' => 'danger', 'icon' => 'bi-arrow-up-circle-fill'],
        'medium' => ['label' => 'Moyenne', 'color' => 'warning', 'icon' => 'bi-dash-circle-fill'],
        'low' => ['label' => 'Basse', 'color' => 'success', 'icon' => 'bi-arrow-down-circle-fill'],
    ];

    $tasksByStatus = $tasks->groupBy('status');

    $statuts = [
        'not_started' => ['label' => 'Non débuté', 'icon' => '⏳', 'tasks' => $tasksByStatus->get('not_started', collect())],
        'in_progress' => ['label' => 'En cours', 'icon' => '⚡', 'tasks' => $tasksByStatus->get('in_progress', collect())],
        'completed' => ['label' => 'Terminée', 'icon' => '✅', 'tasks' => $tasksByStatus->get('completed', collect())],
    ];
@endphp

<div class="container mx-auto max-w-7xl px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-kanban text-primary"></i> {{ $project->title }}
            </h1>
            <p class="text-muted">Gestion des tâches du projet</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-black" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-circle me-1"></i> Nouvelle tâche
            </button>
           <a href="{{ route('employe.projects') }}" class="btn btn-outline-black">
             <i class="bi bi-arrow-left me-1"></i> Retour aux projets
            </a>

        </div>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" id="taskSearch" class="form-control" placeholder="🔍 Rechercher une tâche par titre...">
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        @foreach([
            ['text'=>'Total tâches','count'=>$tasks->count(),'icon'=>'bi-list-task','color'=>'primary'],
            ['text'=>'Non débuté','count'=>$statuts['not_started']['tasks']->count(),'icon'=>'bi-clock','color'=>'secondary'],
            ['text'=>'En cours','count'=>$statuts['in_progress']['tasks']->count(),'icon'=>'bi-play-circle','color'=>'info'],
            ['text'=>'Terminées','count'=>$statuts['completed']['tasks']->count(),'icon'=>'bi-check-circle','color'=>'success'],
        ] as $stat)
            <div class="col-md-3 mb-3">
                <div class="p-4 border rounded-xl bg-white shadow-sm text-center">
                    <i class="{{ $stat['icon'] }} fs-4 text-{{ $stat['color'] }} mb-2"></i>
                    <p class="text-2xl font-semibold">{{ $stat['count'] }}</p>
                    <small class="text-muted">{{ $stat['text'] }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Kanban -->
    <div class="row g-3">
        @foreach($statuts as $keyStatut => $statut)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" style="min-height:500px;">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 d-flex align-items-center gap-2">
                            {{ $statut['icon'] }} {{ $statut['label'] }}
                        </h5>
                        <span class="badge bg-dark rounded-pill">{{ $statut['tasks']->count() }}</span>
                    </div>
                    <div class="card-body overflow-auto" style="max-height:70vh;">
                        @forelse($statut['tasks']->sortByDesc('priority') as $task)
                            @php
                                $prio = $priorites[$task->priority] ?? ['label'=>'Inconnue','color'=>'secondary','icon'=>'bi-circle'];
                            @endphp
                            <div class="card mb-3 border-0 shadow-sm task-card" data-titre="{{ strtolower($task->title) }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title fw-semibold mb-0" style="flex:1;">{{ $task->title }}</h6>
                                        <span class="badge bg-{{ $prio['color'] }} d-flex align-items-center">
                                            <i class="{{ $prio['icon'] }} me-1"></i> {{ $prio['label'] }}
                                        </span>
                                    </div>

                                    @if($task->description)
                                        <p class="text-muted small mb-2">{{ Str::limit($task->description, 80) }}</p>
                                    @endif

                                    @if($task->deadline)
                                        <small class="text-muted d-block mb-2">
                                            📅 {{ $task->deadline->format('d/m/Y') }}
                                            @if($task->deadline->isPast() && $task->status!=='completed')
                                                <span class="badge bg-danger ms-1">En retard</span>
                                            @endif
                                        </small>
                                    @endif

                                    <!-- Assignés -->
                                    <div class="mb-3 d-flex flex-wrap gap-2">
                                        @forelse($task->users as $user)
                                            <span class="badge bg-light text-dark fw-semibold">{{ $user->name }}</span>
                                        @empty
                                            <span class="text-muted">Non assigné</span>
                                        @endforelse
                                    </div>

                                    <!-- Statut & Priorité -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <form action="{{ route('projets.taches.changerPriorite', ['project'=>$project,'tache'=>$task]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    @foreach(App\Models\Task::priorities() as $pKey=>$pLabel)
                                                        <option value="{{ $pKey }}" {{ $task->priority===$pKey?'selected':'' }}>{{ ucfirst($pLabel) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                        <div class="col-6">
                                            <form action="{{ route('employe.tasks.changerStatut', $task) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    @foreach(App\Models\Task::statuses() as $sKey=>$sLabel)
                                                        <option value="{{ $sKey }}" {{ $task->status===$sKey?'selected':'' }}>{{ $sLabel }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Commentaires -->
                                    <details class="mb-2">
                                        <summary class="small text-muted cursor-pointer">
                                            💬 Commentaires ({{ $task->comments->count() }})
                                        </summary>
                                        <div class="mt-2" style="max-height:120px; overflow-y:auto;">
                                            @forelse($task->comments as $comment)
                                                <div class="small bg-light rounded p-2 mb-1">
                                                    <strong>{{ $comment->user->name??'Anonyme' }}:</strong>
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
                                            <button class="btn btn-black" type="submit"><i class="bi bi-send"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2">Aucune tâche dans cette colonne</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal création tâche -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-black text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Créer une nouvelle tâche</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasks.store', $project) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priorité *</label>
                            <select name="priority" class="form-select" required>
                                @foreach(App\Models\Task::priorities() as $pKey=>$pLabel)
                                    <option value="{{ $pKey }}" {{ $pKey==='medium'?'selected':'' }}>{{ ucfirst($pLabel) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date limite</label>
                            <input type="date" name="deadline" class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Assigner à</label>
                            <select name="user_id" class="form-select">
                                <option value="">Sélectionner un membre</option>
                                @foreach($projectMembers as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-black" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-black">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.btn-black {
    background-color: #000;
    color: #fff;
    border: none;
    transition: background-color 0.2s ease;
}
.btn-black:hover {
    background-color: #222;
    color: #fff;
}
.task-card:hover { transform: translateY(-2px); box-shadow:0 4px 15px rgba(0,0,0,0.15)!important; }
.card-header { border-bottom:1px solid rgba(0,0,0,0.08); }
details summary { transition: color 0.2s ease; }
details summary:hover { color:#0d6efd!important; cursor:pointer; }
.input-group .form-control:focus { box-shadow:none; border-color:#86b7fe; }
.modal-content { border-radius:0.5rem; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Recherche tâche
    const searchInput = document.getElementById('taskSearch');
    const taskCards = document.querySelectorAll('.task-card');
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        taskCards.forEach(card => {
            card.style.display = card.getAttribute('data-titre').includes(query) ? '' : 'none';
        });
    });
});
</script>
@endpush
@endsection
