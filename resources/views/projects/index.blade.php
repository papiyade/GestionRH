@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Projet')
@section('content')

<style>
    .projects-kanban-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(174, 61, 125, 0.3);
    }

    .search-input-kanban {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.7rem 1rem 0.7rem 3rem;
        transition: all 0.3s ease;
    }

    .search-input-kanban:focus {
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
        font-size: 1.1rem;
    }

    .kanban-container {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        padding-bottom: 1rem;
    }

    .kanban-container::-webkit-scrollbar {
        height: 8px;
    }

    .kanban-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .kanban-container::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .kanban-column-project {
        min-width: 350px;
        max-width: 350px;
        background: white;
        border-radius: 16px;
        border: 2px solid #f0f0f0;
        padding: 1.25rem;
    }

    .kanban-column-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid;
    }

    .kanban-column-header.not-started {
        border-bottom-color: #6c757d;
    }

    .kanban-column-header.in-progress {
        border-bottom-color: #E46E2F;
    }

    .kanban-column-header.completed {
        border-bottom-color: #28a745;
    }

    .column-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .column-count {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .kanban-cards-container {
        max-height: calc(100vh - 400px);
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .kanban-cards-container::-webkit-scrollbar {
        width: 6px;
    }

    .kanban-cards-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .kanban-cards-container::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .project-card-kanban {
        background: white;
        border: 2px solid #7849652b;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .project-card-kanban:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(174, 61, 125, 0.15);
        border-color: #E46E2F;
    }

    .project-card-title {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-card-title:hover {
        color: #E46E2F;
    }

    .project-card-desc {
        color: #6c757d;
        font-size: 0.875rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .team-avatar {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-left: -8px;
    }

    .team-avatar:first-child {
        margin-left: 0;
    }

    .dropdown-toggle-kanban {
        background: none;
        border: none;
        color: #6c757d;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .dropdown-toggle-kanban:hover {
        background: #f8f9fa;
        color: #E46E2F;
    }

    .btn-add-column {
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.1), rgba(228, 110, 47, 0.1));
        border: 2px dashed #E46E2F;
        color: #E46E2F;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 0.75rem;
    }

    .btn-add-column:hover {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        border-color: transparent;
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

    .modal-gradient .modal-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        border-radius: 16px 16px 0 0;
    }

    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #E46E2F;
        box-shadow: 0 0 0 0.2rem rgba(228, 110, 47, 0.15);
        outline: none;
    }

    .empty-state-kanban {
        padding: 2rem 1rem;
        text-align: center;
        color: #adb5bd;
    }

    .empty-state-kanban i {
        font-size: 2.5rem;
        color: #dee2e6;
        margin-bottom: 0.75rem;
    }

    .project-date {
        color: #adb5bd;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="projects-kanban-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 fw-bold mb-2">
                    <i class="ti ti-layout-kanban me-2 icon-plus"></i>Gestion des Projets
                </h1>
                <p class="mb-0 opacity-90">Vue Kanban de vos projets</p>
            </div>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createProjectModal">
                <i class="ti ti-plus me-1"></i>Nouveau Projet
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-4 position-relative" style="max-width: 400px;">
        <span class="search-icon-wrapper">
            <i class="ti ti-search"></i>
        </span>
        <input type="text" class="form-control search-input-kanban" id="searchProjectInput" 
               placeholder="Rechercher un projet...">
    </div>

    <!-- Kanban Board -->
    <div class="kanban-container">
        @foreach([
            'not_started' => ['label' => 'Non Débuté', 'class' => 'not-started'],
            'in_progress' => ['label' => 'En Cours', 'class' => 'in-progress'],
            'completed' => ['label' => 'Terminé', 'class' => 'completed']
        ] as $status => $config)
            @php
                $statusProjects = $projects->where('status', $status);
            @endphp
            
            <div class="kanban-column-project card">
                <div class="kanban-column-header {{ $config['class'] }}">
                    <h6 class="column-title mb-0">{{ $config['label'] }}</h6>
                    <span class="column-count">{{ $statusProjects->count() }}</span>
                </div>

                <div class="kanban-cards-container">
                    @forelse($statusProjects as $project)
                        <div class="project-card-kanban back" data-project-title="{{ strtolower($project->title) }}">
                            <!-- Header with title and menu -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <a href="{{ route('projects.show', $project) }}" 
                                   class="project-card-title text-decoration-none flex-grow-1">
                                    {{ $project->title }}
                                </a>
                                <div class="dropdown">
                                    <button class="dropdown-toggle-kanban" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a href="{{ route('projects.show', $project->id) }}" class="dropdown-item">
                                                <i class="ti ti-eye me-2"></i>Voir
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item" data-bs-toggle="modal" 
                                               data-bs-target="#editProjectModal" 
                                               data-id="{{ $project->id }}" 
                                               data-title="{{ $project->title }}" 
                                               data-description="{{ $project->description }}" 
                                               data-team="{{ $project->team_id }}" 
                                               data-status="{{ $project->status }}">
                                                <i class="ti ti-edit me-2"></i>Modifier
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" 
                                                  onsubmit="return confirm('Supprimer ce projet ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="ti ti-trash me-2"></i>Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($project->description)
                                <p class="project-card-desc">{{ $project->description }}</p>
                            @endif

                            <!-- Team Members -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex" style="padding-left: 8px;">
                                    @foreach($project->team->members->take(3) as $user)
                                        @php
                                            $initials = collect(explode(' ', $user->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('');
                                        @endphp
                                        <div class="team-avatar" title="{{ $user->name }}">
                                            {{ $initials }}
                                        </div>
                                    @endforeach
                                    @if($project->team->members->count() > 3)
                                        <div class="team-avatar">
                                            +{{ $project->team->members->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="project-date">
                                <i class="ti ti-calendar"></i>
                                {{ $project->created_at->format('d M Y') }}
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-kanban">
                            <i class="ti ti-folder-off"></i>
                            <p class="mb-0 small">Aucun projet</p>
                        </div>
                    @endforelse
                </div>

                <!-- Add Button -->
                <button class="btn-add-column" data-bs-toggle="modal" data-bs-target="#createProjectModal" 
                        data-status="{{ $status }}">
                    <i class="ti ti-plus me-1"></i>Ajouter
                </button>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal: Créer Projet -->
<div class="modal fade modal-gradient" id="createProjectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-plus me-2"></i>Créer un Projet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <input type="hidden" name="status" id="projectStatus" value="not_started">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom du projet *</label>
                        <input type="text" class="form-control form-control-modern" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control form-control-modern" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Équipe *</label>
                        <select class="form-select form-select-modern" name="team_id" required>
                            <option value="">Sélectionner une équipe</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer back">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Modifier Projet -->
<div class="modal fade modal-gradient" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-edit me-2"></i>Modifier le Projet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProjectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom du projet *</label>
                        <input type="text" class="form-control form-control-modern" name="title" id="editProjectTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control form-control-modern" name="description" id="editProjectDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Équipe *</label>
                        <select class="form-select form-select-modern" name="team_id" id="editProjectTeam" required>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Statut *</label>
                        <select class="form-select form-select-modern" name="status" id="editProjectStatus" required>
                            <option value="not_started">Non Débuté</option>
                            <option value="in_progress">En Cours</option>
                            <option value="completed">Terminé</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Recherche instantanée
    const searchInput = document.getElementById('searchProjectInput');
    const projectCards = document.querySelectorAll('.project-card-kanban');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        
        projectCards.forEach(card => {
            const title = card.getAttribute('data-project-title');
            const shouldShow = title.includes(query);
            card.style.display = shouldShow ? '' : 'none';
        });
        
        // Update column counts
        document.querySelectorAll('.kanban-column-project').forEach(column => {
            const visibleCards = column.querySelectorAll('.project-card-kanban:not([style*="display: none"])').length;
            const countBadge = column.querySelector('.column-count');
            if (countBadge) {
                countBadge.textContent = visibleCards;
            }
        });
    });

    // Set status pour modal création
    document.querySelectorAll('[data-status]').forEach(btn => {
        btn.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            if (status) {
                document.getElementById('projectStatus').value = status;
            }
        });
    });

    // Remplissage modal édition
    const editModal = document.getElementById('editProjectModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const description = button.getAttribute('data-description');
        const team = button.getAttribute('data-team');
        const status = button.getAttribute('data-status');

        const form = document.getElementById('editProjectForm');
        form.action = `/projects/${id}`;
        document.getElementById('editProjectTitle').value = title;
        document.getElementById('editProjectDescription').value = description || '';
        document.getElementById('editProjectTeam').value = team;
        document.getElementById('editProjectStatus').value = status;
    });
});
</script>
@endpush

@endsection