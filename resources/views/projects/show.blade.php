@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Projet')

@section('content')
<style>

    .h4 {
        color: #fff !important;
    }
    .project-gradient-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 20px;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(174, 61, 125, 0.3);
    }

    .stat-mini-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .stat-mini-card:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .stat-mini-icon {
        width: 46px;
        height: 46px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .project-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .project-card:hover {
        box-shadow: 0 8px 24px rgba(174, 61, 125, 0.15);
    }

    .card-header-gradient {
        background: linear-gradient(90deg, rgba(174, 61, 125, 0.05) 0%, rgba(228, 110, 47, 0.05) 100%);
        border-bottom: 2px solid #E46E2F;
        padding: 1.25rem;
        border-radius: 14px 14px 0 0;
    }

    .member-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #AE3D7D, #E46E2F);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(174, 61, 125, 0.3);
    }

    .member-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 0.85rem;
        margin-bottom: 0.75rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .member-item:hover {
        background: white;
        border-color: #E46E2F;
        box-shadow: 0 2px 8px rgba(228, 110, 47, 0.1);
    }

    .file-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }

    .file-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .comment-bubble {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 3px solid #E46E2F;
    }

    .nav-pills-gradient .nav-link {
        border-radius: 12px;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .nav-pills-gradient .nav-link:hover {
        background: rgba(174, 61, 125, 0.1);
        color: #AE3D7D;
    }

    .nav-pills-gradient .nav-link.active {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(174, 61, 125, 0.4);
        color: white;
    }

    .badge-gradient {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .progress-modern {
        height: 8px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-gradient {
        background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 10px;
    }

    .empty-state-modern {
        padding: 3rem;
        text-align: center;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 16px;
    }

    .empty-state-modern i {
        font-size: 3.5rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .modal-gradient .modal-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        border-radius: 16px 16px 0 0;
    }

    @php
        $priorityStyles = [
            'High' => 'background: linear-gradient(135deg, #dc3545, #c82333); color: white;',
            'Medium' => 'background: linear-gradient(135deg, #ffc107, #e0a800); color: #000;',
            'Low' => 'background: linear-gradient(135deg, #28a745, #218838); color: white;'
        ];

        $statusBadges = [
            'completed' => ['color' => 'success', 'icon' => 'check-circle', 'text' => 'Terminée'],
            'in_progress' => ['color' => 'warning', 'icon' => 'clock', 'text' => 'En cours'],
            'not_started' => ['color' => 'secondary', 'icon' => 'pause', 'text' => 'Non débutée']
        ];
    @endphp
</style>

<div class="container-fluid px-4 py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Projet avec Gradient -->
    <div class="project-gradient-header">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-6 fw-bold mb-3" style="color: #fff !important">{{ $project->title }}</h1>
                <p class="mb-4 opacity-90" style="color: #fff !important">{{ $project->description ?? 'Aucune description disponible' }}</p>

                <!-- Mini Stats -->
                <div class="row g-2">
                    <div class="col-6 col-md-3">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center gap-2">
                                <div class="stat-mini-icon"><i class="ti ti-list-check icon-plus"></i></div>
                                <div>
                                    <div class="h4 mb-0 fw-bold icon-plus" >{{ $project->tasks->count() }}</div>
                                    <small class="opacity-75">Tâches</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center gap-2">
                                <div class="stat-mini-icon"><i class="ti ti-circle-check icon-plus"></i></div>
                                <div>
                                    <div class="h4 mb-0 fw-bold icon-plus">{{ $project->tasks->where('status', 'completed')->count() }}</div>
                                    <small class="opacity-75">Terminées</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center gap-2">
                                <div class="stat-mini-icon"><i class="ti ti-users icon-plus"></i></div>
                                <div>
                                    <div class="h4 mb-0 fw-bold icon-plus">{{ $project->members->count() }}</div>
                                    <small class="opacity-75">Membres</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center gap-2">
                                <div class="stat-mini-icon"><i class="ti ti-paperclip icon-plus"></i></div>
                                <div>
                                    <div class="h4 mb-0 fw-bold icon-plus">{{ $project->files->count() }}</div>
                                    <small class="opacity-75">Fichiers</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
                @php
                    $totalTasks = $project->tasks->count();
                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                    $progress = $totalTasks ? round(($completedTasks / $totalTasks) * 100) : 0;
                    $statusInfo = $statusBadges[$project->status] ?? $statusBadges['not_started'];
                @endphp

                <div class="text-center">
                    <div class="badge-gradient mb-3 d-inline-block">
                        <i class="ti ti-{{ $statusInfo['icon'] }} me-2"></i>{{ $statusInfo['text'] }}
                    </div>

                    <div class="mb-2">
                        <h2 class="display-4 fw-bold">{{ $progress }}%</h2>
                        <small class="opacity-75">Progression Globale</small>
                    </div>

                    <div class="progress-modern">
                        <div class="progress-bar progress-bar-gradient" style="width: {{ $progress }}%"></div>
                    </div>

                    <a href="{{ route('projets.taches', $project->id) }}" class="btn btn-light btn-lg mt-3 rounded-pill">
                        <i class="ti ti-list me-2"></i>Voir les tâches
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-xl-4">
            <!-- Équipe -->
            <div class="project-card mb-4">
                <div class="card-header-gradient d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-users text-warning me-2"></i>Équipe ({{ $project->members->count() }})</h5>
                    <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                        <i class="ti ti-plus icon-plus"></i>
                    </button>
                </div>
                <div class="p-3">
                    @forelse($project->members as $member)
                        <div class="member-item">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="member-avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-semibold">{{ $member->name }}</div>
                                        <small class="text-muted">{{ $member->email }}</small>
                                    </div>
                                </div>
                                @if($member->pivot->is_lead)
                                    <i class="ti ti-star-filled text-warning"></i>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-modern">
                            <i class="ti ti-users-off"></i>
                            <p class="text-muted mb-0">Aucun membre</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Fichiers Récents -->
            <div class="project-card">
                <div class="card-header-gradient">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-paperclip text-info me-2"></i>Fichiers ({{ $project->files->count() }})</h5>
                </div>
                <div class="p-3">
                    @forelse($project->files->take(5) as $file)
                        @php
                            $ext = pathinfo($file->file_name, PATHINFO_EXTENSION);
                            $icons = ['pdf' => 'ti-file-type-pdf text-danger', 'doc' => 'ti-file-word text-primary',
                                     'docx' => 'ti-file-word text-primary', 'xls' => 'ti-file-spreadsheet text-success',
                                     'xlsx' => 'ti-file-spreadsheet text-success'];
                            $icon = $icons[$ext] ?? 'ti-file text-secondary';
                        @endphp
                        <div class="file-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ti {{ $icon }} fs-4"></i>
                                <div>
                                    <div class="small fw-semibold">{{ Str::limit($file->file_name, 25) }}</div>
                                    <small class="text-muted">{{ $file->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-sm btn-light" download>
                                <i class="ti ti-download"></i>
                            </a>
                        </div>
                    @empty
                        <div class="empty-state-modern">
                            <i class="ti ti-folder-off"></i>
                            <p class="text-muted mb-0">Aucun fichier</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-xl-8">
            <div class="project-card">
                <div class="p-4">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills nav-pills-gradient mb-4" role="tablist">
                        <li class="nav-item flex-fill">
                            <a class="nav-link active text-center" data-bs-toggle="tab" href="#tab-comments">
                                <i class="ti ti-message-circle me-2 icon-plus"></i>Commentaires ({{ $project->comments->count() }})
                            </a>
                        </li>
                        <li class="nav-item flex-fill">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab-tasks">
                                <i class="ti ti-list-check me-2"></i>Tâches ({{ $project->tasks->count() }})
                            </a>
                        </li>
                        <li class="nav-item flex-fill">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab-files">
                                <i class="ti ti-folder me-2"></i>Fichiers
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Commentaires -->
                        <div class="tab-pane fade show active" id="tab-comments">
                            <div style="max-height: 500px; overflow-y: auto;" class="mb-3">
                                @forelse($comments as $comment)
                                    <div class="comment-bubble">
                                        <div class="d-flex gap-3">
                                            <div class="member-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="fw-bold">{{ $comment->user->name }}</span>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-0">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state-modern">
                                        <i class="ti ti-message-off"></i>
                                        <p class="text-muted mb-0">Aucun commentaire</p>
                                    </div>
                                @endforelse
                            </div>

                            <form action="{{ route('comments.store', $project) }}" method="POST" class="border-top pt-3">
                                @csrf
                                <textarea class="form-control mb-2" name="content" rows="3" placeholder="Votre commentaire..." required></textarea>
                                <button type="submit" class="btn btn-gradient-primary">
                                    <i class="ti ti-send me-2 icon-plus"></i>Publier
                                </button>
                            </form>
                        </div>

                        <!-- Tâches -->
                        <div class="tab-pane fade" id="tab-tasks">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Liste des tâches</h5>
                                <button class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                    <i class="ti ti-plus me-1 icon-plus"></i>Nouvelle tâche
                                </button>
                            </div>

                            @forelse($project->tasks as $task)
                                <div class="member-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $task->title }}</h6>
                                            <div class="small text-muted mb-2">{{ Str::limit($task->description, 60) }}</div>
                                            <span class="badge rounded-pill" style="{{ $priorityStyles[$task->priority] ?? '' }}">
                                                {{ $task->priority }}
                                            </span>
                                        </div>
                                        <span class="badge bg-{{ $statusBadges[$task->status]['color'] ?? 'secondary' }}">
                                            {{ $statusBadges[$task->status]['text'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state-modern">
                                    <i class="ti ti-clipboard-off"></i>
                                    <p class="text-muted mb-0">Aucune tâche</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Fichiers -->
                        <div class="tab-pane fade" id="tab-files">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Tous les fichiers</h5>
                                <form action="{{ route('files.store', $project) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" id="file-upload" name="file" class="d-none" onchange="this.form.submit()">
                                    <button type="button" class="btn btn-gradient-primary" onclick="document.getElementById('file-upload').click()">
                                        <i class="ti ti-upload me-1 icon-plus"></i>Ajouter
                                    </button>
                                </form>
                            </div>

                            @forelse($project->files as $file)
                                <div class="file-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $file->file_name }}</div>
                                        <small class="text-muted">{{ $file->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-sm btn-gradient-primary" download>
                                        <i class="ti ti-download "></i>
                                    </a>
                                </div>
                            @empty
                                <div class="empty-state-modern">
                                    <i class="ti ti-folder-off"></i>
                                    <p class="text-muted mb-0">Aucun fichier</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Gérer Membres -->
<div class="modal fade modal-gradient" id="inviteMembersModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-users me-2"></i>Gérer les membres</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                @foreach($members as $member)
                    <div class="member-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="member-avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                            <div>
                                <div class="fw-semibold">{{ $member->name }}</div>
                                <small class="text-muted">{{ $member->email }}</small>
                            </div>
                        </div>
                        @if($Teammembers->contains('id', $member->id))
                            <form action="{{ route('projects.removeMember', [$project->id, $member->id]) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Retirer</button>
                            </form>
                        @else
                            <form action="{{ route('projects.addMember', [$project->id, $member->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-gradient-primary">Ajouter</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal: Créer Tâche -->
<div class="modal fade modal-gradient" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-plus me-2"></i>Créer une tâche</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasks.store', $project) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Titre</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Échéance</label>
                            <input type="datetime-local" name="deadline" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priorité</label>
                            <select name="priority" class="form-select">
                                <option value="Low">Basse</option>
                                <option value="Medium">Moyenne</option>
                                <option value="High">Haute</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
