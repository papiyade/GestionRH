@extends('layout.admin')

@section('content')
<style>

    /* Header */
    .projects-header {
        background: white;
        border-radius: 12px;
        padding: 10px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .projects-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .breadcrumb-custom {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-custom .breadcrumb-item {
        color: #999;
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: #AE3D7D;
    }

    /* Stats Bar */
    .stats-bar {
        display: flex;
        gap: 32px;
        align-items: center;
        padding: 16px 0;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding-right: 32px;
        border-right: 2px solid #e0e0e0;
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .stat-value {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.1rem;
    }

    /* Search & Filters */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 16px;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .search-box input:focus {
        border-color: #AE3D7D;
        outline: none;
        box-shadow: 0 0 0 3px rgba(174, 61, 125, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .btn-new-project {
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-new-project:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
        color: white;
    }

    /* Avatar Group */
    .avatar-group {
        display: flex;
        align-items: center;
    }

    .avatar-item {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        margin-left: -8px;
        border: 2px solid white;
        transition: all 0.2s;
    }

    .avatar-item:first-child {
        margin-left: 0;
    }

    .avatar-item:hover {
        transform: translateY(-2px);
        z-index: 10;
    }

    .avatar-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .avatar-more {
        background: #f0f0f0;
        color: #666;
    }

    /* Kanban Board */
    .kanban-board {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding: 24px 0;
        min-height: 600px;
    }

    .kanban-board::-webkit-scrollbar {
        height: 8px;
    }

    .kanban-board::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .kanban-board::-webkit-scrollbar-thumb {
        background: #AE3D7D;
        border-radius: 10px;
    }

    /* Column */
    .kanban-column {
        flex: 0 0 350px;
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        max-height: calc(100vh - 300px);
    }

    .column-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f0f0f0;
    }

    .column-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .status-dot.not-started {
        background: #dc3545;
    }

    .status-dot.in-progress {
        background: #ffc107;
    }

    .status-dot.completed {
        background: #28a745;
    }

    .column-title h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .column-count {
        background: #f0f0f0;
        color: #666;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .column-menu {
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .column-menu:hover {
        background: #f0f0f0;
    }

    /* Cards Container */
    .cards-container {
        flex: 1;
        overflow-y: auto;
        padding-right: 4px;
    }

    .cards-container::-webkit-scrollbar {
        width: 6px;
    }

    .cards-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .cards-container::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

    /* Project Card */
    .project-card {
        background: white;
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
        cursor: grab;
        transition: all 0.2s;
    }

    .project-card:hover {
        border-color: #AE3D7D;
        box-shadow: 0 4px 12px rgba(174, 61, 125, 0.15);
        transform: translateY(-2px);
    }

    .project-card.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }

    .card-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .project-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .project-badge.not-started {
        background: #ffebee;
        color: #c62828;
    }

    .project-badge.in-progress {
        background: #fff3e0;
        color: #f57c00;
    }

    .project-badge.completed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .project-badge i {
        font-size: 6px;
    }

    .card-menu {
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .card-menu:hover {
        background: #f0f0f0;
    }

    .project-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .project-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .project-title h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        flex: 1;
    }

    .project-id {
        color: #999;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .project-meta {
        display: flex;
        gap: 16px;
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 12px;
    }

    .meta-item {
        flex: 1;
    }

    .meta-label {
        color: #999;
        font-size: 0.75rem;
        margin-bottom: 4px;
    }

    .meta-value {
        color: #2c3e50;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-avatars {
        display: flex;
        align-items: center;
    }

    .card-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid white;
        margin-left: -8px;
    }

    .card-avatar:first-child {
        margin-left: 0;
    }

    .card-stats {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .stat-icon {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #999;
        font-size: 0.85rem;
    }

    .stat-icon:hover {
        color: #AE3D7D;
    }

    /* Add Card Button */
    .add-card-btn {
        width: 100%;
        padding: 12px;
        border: 2px dashed #e0e0e0;
        background: transparent;
        border-radius: 8px;
        color: #999;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        margin-top: 12px;
    }

    .add-card-btn:hover {
        border-color: #AE3D7D;
        color: #AE3D7D;
        background: rgba(174, 61, 125, 0.05);
    }

    /* Dropdown */
    .dropdown-menu-custom {
        border: none;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        border-radius: 8px;
        padding: 8px;
    }

    .dropdown-item-custom {
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dropdown-item-custom:hover {
        background: #f8f9fa;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 12px;
        opacity: 0.3;
    }

    @media (max-width: 768px) {
        .kanban-column {
            flex: 0 0 300px;
        }

        .stats-bar {
            flex-wrap: wrap;
            gap: 16px;
        }

        .toolbar {
            flex-direction: column;
        }

        .search-box {
            max-width: 100%;
        }
    }
</style>
    <!-- Header -->
    <div class="projects-header">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h1><i class="ti ti-briefcase me-2"></i>Projets</h1>
                <nav>
                    <ol class="breadcrumb-custom breadcrumb">
                        <li class="breadcrumb-item"><i class="ti ti-home"></i></li>
                        <li class="breadcrumb-item">Admin</li>
                        <li class="breadcrumb-item active">Liste des projets</li>
                    </ol>
                </nav>
            </div>
            <div class="avatar-group">
                @foreach ($userTeams->take(5) as $user)
                    <div class="avatar-item" title="{{ $user->name }}">
                        @if($user->profile_photo_url)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        @endif
                    </div>
                @endforeach
                @if($userTeams->count() > 5)
                    <div class="avatar-item avatar-more">
                        +{{ $userTeams->count() - 5 }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-label">Total projets :</span>
                <span class="stat-value">{{ $projectCount }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Non débuté :</span>
                <span class="stat-value">{{ $projectNotStartedCount }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">En cours :</span>
                <span class="stat-value">{{ $projectEnCoursCount }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Complétées :</span>
                <span class="stat-value">{{ $projectCompleteCount }}</span>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" id="searchProjects" placeholder="Rechercher un projet...">
            </div>
            <button class="btn-new-project" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                <i class="ti ti-plus"></i>
                Nouveau projet
            </button>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board" id="kanbanBoard">
        <!-- Column: Non débuté -->
        <div class="kanban-column" data-status="not-started">
            <div class="column-header">
                <div class="column-title">
                    <span class="status-dot not-started"></span>
                    <h3>Non débuté</h3>
                    <span class="column-count">{{ $projectNotStartedCount }}</span>
                </div>
                <div class="column-menu">
                    <i class="ti ti-dots"></i>
                </div>
            </div>

            <div class="cards-container" id="notStartedCards">
                @forelse($projectNotStarted as $project)
                <div class="project-card" draggable="true" data-project-id="{{ $project->id }}">
                    <div class="card-header-row">
                        <span class="project-badge not-started">
                            <i class="ti ti-circle-filled"></i>
                            Non débuté
                        </span>
                        <div class="card-menu dropdown">
                            <i class="ti ti-dots" data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end">
                                <li><a class="dropdown-item-custom" href="#"><i class="ti ti-eye"></i>Voir</a></li>
                                <li><a class="dropdown-item-custom" href="#"><i class="ti ti-edit"></i>Modifier</a></li>
                                <li><a class="dropdown-item-custom text-danger" href="#"><i class="ti ti-trash"></i>Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="project-title">
                        <div class="project-icon">
                            <i class="ti ti-briefcase"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4>{{ $project->title }}</h4>
                            <span class="project-id">PRJ-{{ $project->id }}</span>
                        </div>
                    </div>

                    <div class="project-meta">
                        <div class="meta-item">
                            <div class="meta-label">Tâches</div>
                            <div class="meta-value">
                                {{ $project->tasks->count() > 0 ? $project->tasks->where('status', 'completed')->count() . '/' . $project->tasks->count() : '0/0' }}
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Créé le</div>
                            <div class="meta-value">{{ $project->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="card-avatars">
                            @foreach($project->team->members->take(3) ?? [] as $member)
                            <img src="{{ $member->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" 
                                 class="card-avatar" 
                                 title="{{ $member->name }}">
                            @endforeach
                        </div>
                        <div class="card-stats">
                            <span class="stat-icon"><i class="ti ti-message-circle"></i>0</span>
                            <span class="stat-icon"><i class="ti ti-paperclip"></i>0</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="ti ti-inbox"></i>
                    <p>Aucun projet</p>
                </div>
                @endforelse
            </div>

            <button class="add-card-btn">
                <i class="ti ti-plus"></i>
                Nouveau projet
            </button>
        </div>

        <!-- Column: En cours -->
        <div class="kanban-column" data-status="in-progress">
            <div class="column-header">
                <div class="column-title">
                    <span class="status-dot in-progress"></span>
                    <h3>En cours</h3>
                    <span class="column-count">{{ $projectEnCoursCount }}</span>
                </div>
                <div class="column-menu">
                    <i class="ti ti-dots"></i>
                </div>
            </div>

            <div class="cards-container" id="inProgressCards">
                @forelse($projectEnCours as $project)
                <div class="project-card" draggable="true" data-project-id="{{ $project->id }}">
                    <div class="card-header-row">
                        <span class="project-badge in-progress">
                            <i class="ti ti-circle-filled"></i>
                            En cours
                        </span>
                        <div class="card-menu dropdown">
                            <i class="ti ti-dots" data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end">
                                <li><a class="dropdown-item-custom" href="#"><i class="ti ti-eye"></i>Voir</a></li>
                                <li><a class="dropdown-item-custom" href="#"><i class="ti ti-edit"></i>Modifier</a></li>
                                <li><a class="dropdown-item-custom text-danger" href="#"><i class="ti ti-trash"></i>Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="project-title">
                        <div class="project-icon">
                            <i class="ti ti-briefcase"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4>{{ $project->title }}</h4>
                            <span class="project-id">PRJ-{{ $project->id }}</span>
                        </div>
                    </div>

                    <div class="project-meta">
                        <div class="meta-item">
                            <div class="meta-label">Tâches</div>
                            <div class="meta-value">
                                {{ $project->tasks->count() > 0 ? $project->tasks->where('status', 'completed')->count() . '/' . $project->tasks->count() : '0/0' }}
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Créé le</div>
                            <div class="meta-value">{{ $project->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="card-avatars">
                            @foreach($project->team->members->take(3) ?? [] as $member)
                            <img src="{{ $member->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" 
                                 class="card-avatar" 
                                 title="{{ $member->name }}">
                            @endforeach
                        </div>
                        <div class="card-stats">
                            <span class="stat-icon"><i class="ti ti-message-circle"></i>0</span>
                            <span class="stat-icon"><i class="ti ti-paperclip"></i>0</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="ti ti-inbox"></i>
                    <p>Aucun projet</p>
                </div>
                @endforelse
            </div>

            <button class="add-card-btn">
                <i class="ti ti-plus"></i>
                Nouveau projet
            </button>
        </div>

        <!-- Column: Complétées -->
        <div class="kanban-column" data-status="completed">
            <div class="column-header">
                <div class="column-title">
                    <span class="status-dot completed"></span>
                    <h3>Complétées</h3>
                    <span class="column-count">{{ $projectCompleteCount }}</span>
                </div>
                <div class="column-menu">
                    <i class="ti ti-dots"></i>
                </div>
            </div>

            <div class="cards-container" id="completedCards">
                @forelse($projectComplete as $project)
                <div class="project-card" draggable="true" data-project-id="{{ $project->id }}">
                    <div class="card-header-row">
                        <span class="project-badge completed">
                            <i class="ti ti-circle-filled"></i>
                            Complété
                        </span>
                        <div class="card-menu dropdown">
                            <i class="ti ti-dots" data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end">
                                <li><a class="dropdown-item-custom" href="#"><i class="ti ti-eye"></i>Voir</a></li>
                                <li><a class="dropdown-item-custom" href="#"><i class="ti ti-edit"></i>Modifier</a></li>
                                <li><a class="dropdown-item-custom text-danger" href="#"><i class="ti ti-trash"></i>Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="project-title">
                        <div class="project-icon">
                            <i class="ti ti-briefcase"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4>{{ $project->title }}</h4>
                            <span class="project-id">PRJ-{{ $project->id }}</span>
                        </div>
                    </div>

                    <div class="project-meta">
                        <div class="meta-item">
                            <div class="meta-label">Tâches</div>
                            <div class="meta-value">
                                {{ $project->tasks->count() > 0 ? $project->tasks->where('status', 'completed')->count() . '/' . $project->tasks->count() : '0/0' }}
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Créé le</div>
                            <div class="meta-value">{{ $project->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="card-avatars">
                            @foreach($project->team->members->take(3) ?? [] as $member)
                            <img src="{{ $member->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" 
                                 class="card-avatar" 
                                 title="{{ $member->name }}">
                            @endforeach
                        </div>
                        <div class="card-stats">
                            <span class="stat-icon"><i class="ti ti-message-circle"></i>0</span>
                            <span class="stat-icon"><i class="ti ti-paperclip"></i>0</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="ti ti-inbox"></i>
                    <p>Aucun projet</p>
                </div>
                @endforelse
            </div>

            <button class="add-card-btn">
                <i class="ti ti-plus"></i>
                Nouveau projet
            </button>
        </div>
    </div>



<script>
// Search functionality
document.getElementById('searchProjects').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.project-card');
    
    cards.forEach(card => {
        const title = card.querySelector('.project-title h4').textContent.toLowerCase();
        const projectId = card.querySelector('.project-id').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || projectId.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Drag and Drop
let draggedElement = null;

document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('dragstart', function(e) {
        draggedElement = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    });

    card.addEventListener('dragend', function() {
        this.classList.remove('dragging');
    });
});

document.querySelectorAll('.cards-container').forEach(container => {
    container.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });

    container.addEventListener('drop', function(e) {
        e.preventDefault();
        if (draggedElement) {
            this.appendChild(draggedElement);
            
            // Get new status from column
            const column = this.closest('.kanban-column');
            const newStatus = column.getAttribute('data-status');
            const projectId = draggedElement.getAttribute('data-project-id');
            
            // Update status badge
            updateProjectStatus(draggedElement, newStatus);

            // Here you can add an AJAX request to update the status in the backend
            console.log(`Project ID ${projectId} moved to ${newStatus}`);
        }
    });
});
function updateProjectStatus(card, status) {
    const badge = card.querySelector('.project-badge');
    badge.className = 'project-badge ' + status;
    if (status === 'not-started') {
        badge.innerHTML = '<i class="ti ti-circle-filled"></i> Non débuté';
    } else if (status === 'in-progress') {
        badge.innerHTML = '<i class="ti ti-circle-filled"></i> En cours';
    } else if (status === 'completed') {
        badge.innerHTML = '<i class="ti ti-circle-filled"></i> Complété';
    }
}
</script>