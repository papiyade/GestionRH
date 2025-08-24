@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', ' projet')@section('content')

<div class="container-fluid py-4">

    <!-- Header: Création et recherche -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <i class="ri-add-line me-1"></i> Créer un projet
        </button>
        <div class="position-relative" style="max-width: 250px;">
            <input type="text" class="form-control form-control-sm" id="search-task-options" placeholder="Rechercher...">
            <i class="ri-search-line position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);"></i>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="d-flex gap-3" style="overflow-x:auto;">
        @foreach(['not_started' => 'Non Débuté', 'in_progress' => 'En Cours', 'completed' => 'Terminé'] as $status => $label)
        <div class="flex-shrink-0" style="width: 320px;">
            <h6 class="text-uppercase fw-bold mb-3">
                {{ $label }}
                <span class="badge bg-secondary align-bottom">{{ $projects->where('status', $status)->count() }}</span>
            </h6>

            <div class="d-flex flex-column gap-2" id="{{ $status }}-tasks">
                @forelse($projects->where('status', $status) as $project)
                <div class="card border-1 shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <a href="{{ route('projects.show', $project->id) }}" class="fw-medium text-dark text-truncate" title="{{ $project->title }}">
                                {{ $project->title }}
                            </a>
                            <div class="dropdown">
                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('projects.show', $project->id) }}"><i class="ri-eye-fill me-1"></i> Voir</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line me-1"></i> Modifier</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line me-1"></i> Supprimer</a></li>
                                </ul>
                            </div>
                        </div>

                        <p class="text-muted small mb-2 text-truncate-2">{{ $project->description }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @foreach($project->tags ?? [] as $tag)
                                    <span class="badge bg-light text-dark small">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex align-items-center">
                                @foreach($project->team->members->take(3) as $user)
                                    <div class="avatar-sm rounded-circle bg-dark text-white text-center me-1" style="width:30px; height:30px; font-size:0.75rem;" title="{{ $user->name }}">
                                        {{ strtoupper(substr($user->name,0,1)) }}
                                    </div>
                                @endforeach
                                @if($project->team->members->count() > 3)
                                    <div class="avatar-sm rounded-circle bg-secondary text-white text-center" style="width:30px; height:30px; font-size:0.75rem;">
                                        +{{ $project->team->members->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="ri-time-line me-1"></i> {{ $project->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>
                @empty
                    <div class="text-muted small">Aucun projet</div>
                @endforelse
            </div>

            <button class="btn btn-outline-dark btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#createProjectModal" data-status="{{ $status }}">
                Ajouter
            </button>
        </div>
        @endforeach
    </div>

</div>

<!-- Modal Unique pour création de projet -->
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Créer un projet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" id="projectStatus" value="not_started">
                    <div class="mb-3">
                        <label class="form-label">Nom du projet</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Équipe</label>
                        <select class="form-select" name="team_id" required>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-dark">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('search-task-options');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.card').forEach(card => {
                const text = card.querySelector('.task-title')?.textContent.toLowerCase() ?? '';
                card.style.display = text.includes(term) ? 'block' : 'none';
            });
        });
    }

    // Set status for modal dynamically
    document.querySelectorAll('[data-status]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('projectStatus').value = this.getAttribute('data-status');
        });
    });
});
</script>

@endsection
