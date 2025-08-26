@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', ' projet')@section('content')
@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4 rounded-3 shadow-sm">
                    <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                    <div>
                        <strong>Succès !</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- En-tête projet -->
            <div class="card mb-4 rounded-4 shadow">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <span class="bg-primary d-flex align-items-center justify-content-center rounded-3" style="width:60px;height:60px;">
                                    <i class="fas fa-project-diagram text-white"></i>
                                </span>
                                <div>
                                    <h1 class="h3 fw-bold text-dark mb-1">{{ $project->title }}</h1>
                                    <nav>
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="#" class="text-muted">Projets</a></li>
                                            <li class="breadcrumb-item active text-primary">{{ $project->title }}</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="row g-3">
                                @php
                                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                                @endphp
                                <div class="col-6 col-sm-3">
                                    <div class="d-flex align-items-center p-2 bg-white rounded-3 shadow-sm">
                                        <span class="bg-info d-flex align-items-center justify-content-center rounded-2" style="width:40px;height:40px;">
                                            <i class="fas fa-tasks text-white"></i>
                                        </span>
                                        <div class="ms-2">
                                            <h5 class="fw-bold mb-0">{{ $project->tasks->count() }}</h5>
                                            <small class="text-muted">Tâches</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <div class="d-flex align-items-center p-2 bg-white rounded-3 shadow-sm">
                                        <span class="bg-success d-flex align-items-center justify-content-center rounded-2" style="width:40px;height:40px;">
                                            <i class="fas fa-check-circle text-white"></i>
                                        </span>
                                        <div class="ms-2">
                                            <h5 class="fw-bold mb-0">{{ $completedTasks }}</h5>
                                            <small class="text-muted">Terminées</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <div class="d-flex align-items-center p-2 bg-white rounded-3 shadow-sm">
                                        <span class="bg-warning d-flex align-items-center justify-content-center rounded-2" style="width:40px;height:40px;">
                                            <i class="fas fa-users text-white"></i>
                                        </span>
                                        <div class="ms-2">
                                            <h5 class="fw-bold mb-0">{{ $project->members->count() }}</h5>
                                            <small class="text-muted">Membres</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <div class="d-flex align-items-center p-2 bg-white rounded-3 shadow-sm">
                                        <span class="bg-danger d-flex align-items-center justify-content-center rounded-2" style="width:40px;height:40px;">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </span>
                                        <div class="ms-2">
                                            <h5 class="fw-bold mb-0">{{ $project->files->count() }}</h5>
                                            <small class="text-muted">Fichiers</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                            <a href="{{ route('projets.taches', ['projet' => $project->id]) }}" class="btn btn-dark btn-lg rounded-pill mb-3">
                                <i class="fas fa-list-alt me-2"></i>Voir les tâches
                            </a>
                            @php
                                $totalTasks = $project->tasks->count();
                                $progress = $totalTasks ? ($completedTasks / $totalTasks) * 100 : 0;
                            @endphp
                            <span class="badge bg-{{ $project->status == 'not_started' ? 'danger' : ($project->status == 'in_progress' ? 'warning' : 'success') }} px-4 py-2 rounded-pill fs-6 mb-2 d-block">
                                <i class="fas fa-{{ $project->status == 'not_started' ? 'pause' : ($project->status == 'in_progress' ? 'play' : 'check-circle') }} me-1"></i>
                                {{ $project->status == 'not_started' ? 'Non débuté' : ($project->status == 'in_progress' ? 'En cours' : 'Terminé') }}
                            </span>
                            <div class="mb-2">
                                <small class="text-muted">Progression</small>
                                <small class="fw-bold text-dark float-end">{{ round($progress) }}%</small>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-{{ $progress >= 75 ? 'success' : ($progress >= 50 ? 'warning' : 'danger') }}" style="width:{{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Sidebar -->
                <div class="col-xl-4">
                    <!-- Infos projet -->
                    <div class="card mb-4 rounded-3 shadow">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-info-circle text-primary me-2"></i>Détails du projet
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="mb-3 bg-light rounded-3 p-3">
                                <div class="small fw-semibold text-dark mb-1">ID du projet</div>
                                <div class="text-dark">#{{ $project->id }}</div>
                            </div>
                            <div class="bg-light rounded-3 p-3">
                                <div class="small fw-semibold text-dark mb-1">Date de création</div>
                                <i class="fas fa-calendar-alt text-info me-2"></i>
                                <span class="text-dark">{{ $project->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Membres -->
                    <div class="card mb-4 rounded-3 shadow">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-users text-success me-2"></i>Équipe ({{ $project->members->count() }})
                            </h5>
                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                <i class="fas fa-plus me-1"></i>Gérer
                            </button>
                        </div>
                        <div class="card-body px-4 pb-4">
                            @if($project->members->isEmpty())
                                <div class="text-center py-4">
                                    <i class="fas fa-users text-muted fs-1 opacity-25"></i>
                                    <p class="text-muted mt-2">Aucun membre assigné</p>
                                </div>
                            @else
                                @foreach ($project->members as $member)
                                    <div class="d-flex align-items-center p-2 bg-light rounded-3 mb-2">
                                        <span class="bg-primary text-white fw-bold rounded-2 d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </span>
                                        <div class="ms-2 flex-grow-1">
                                            <span class="fw-semibold">{{ $member->name }}</span>
                                            @if ($member->pivot->is_lead)
                                                <i class="fas fa-star text-warning ms-1" title="Lead Tech"></i>
                                            @endif
                                            <div class="small text-muted">Membre</div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <form action="{{ route('projects.toggleLead', [$project->id, $member->id]) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-star me-2"></i>
                                                            {{ $member->pivot->is_lead ? 'Retirer Lead' : 'Désigner Lead' }}
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('projects.removeMember', [$project->id, $member->id]) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Retirer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- Fichiers -->
                    <div class="card rounded-3 shadow">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-paperclip text-warning me-2"></i>Fichiers ({{ $project->files->count() }})
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            @if ($project->files->isEmpty())
                                <div class="text-center py-4">
                                    <i class="fas fa-file text-muted fs-1 opacity-25"></i>
                                    <p class="text-muted mt-2">Aucun fichier ajouté</p>
                                </div>
                            @else
                                @foreach ($project->files->take(3) as $file)
                                    @php
                                        $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                        $icons = [
                                            'pdf' => 'fas fa-file-pdf text-danger',
                                            'doc' => 'fas fa-file-word text-primary',
                                            'docx' => 'fas fa-file-word text-primary',
                                            'xls' => 'fas fa-file-excel text-success',
                                            'xlsx' => 'fas fa-file-excel text-success',
                                            'default' => 'fas fa-file text-secondary',
                                        ];
                                        $icon = $icons[$extension] ?? $icons['default'];
                                    @endphp
                                    <div class="d-flex align-items-center p-2 bg-light rounded-3 mb-2">
                                        <i class="{{ $icon }} fs-4 me-2"></i>
                                        <div class="flex-grow-1">
                                            <span class="fw-semibold text-truncate">{{ $file->file_name }}</span>
                                            <small class="text-muted">{{ $file->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-sm btn-outline-dark rounded-circle" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach
                                @if($project->files->count() > 3)
                                    <button class="btn btn-outline-primary btn-sm">Voir {{ $project->files->count() - 3 }} autres fichiers</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main -->
                <div class="col-xl-8">
                    <div class="card rounded-3 shadow">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <ul class="nav nav-pills nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link active rounded-pill" data-bs-toggle="tab" href="#comments-tab">
                                        <i class="fas fa-comments me-2"></i>Commentaires ({{ $project->comments->count() }})
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded-pill" data-bs-toggle="tab" href="#tasks-tab">
                                        <i class="fas fa-tasks me-2"></i>Tâches ({{ $project->tasks->count() }})
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded-pill" data-bs-toggle="tab" href="#files-tab">
                                        <i class="fas fa-file me-2"></i>Fichiers
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="tab-content">
                                <!-- Commentaires -->
                                <div class="tab-pane fade show active" id="comments-tab">
                                    <div style="max-height:500px;overflow-y:auto;">
                                        @forelse ($comments as $comment)
                                            <div class="d-flex align-items-start p-3 mb-3 bg-light rounded-3">
                                                <span class="bg-info text-white fw-bold rounded-2 d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </span>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="fw-semibold">{{ $comment->user->name }}</span>
                                                        <small class="text-muted">{{ $comment->created_at->format('d/m/Y à H:i') }}</small>
                                                    </div>
                                                    <p class="mb-0 text-dark">{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-5">
                                                <i class="fas fa-comments text-muted fs-1 opacity-25"></i>
                                                <h5 class="text-muted mt-3">Aucun commentaire</h5>
                                                <p class="text-muted">Soyez le premier à commenter ce projet</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    <form action="{{ route('comments.store', $project) }}" method="POST" class="border-top pt-4 mt-4">
                                        @csrf
                                        <div class="d-flex gap-3">
                                            <span class="bg-dark text-white fw-bold rounded-2 d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                            </span>
                                            <div class="flex-grow-1">
                                                <textarea class="form-control border-0 bg-light" name="content" rows="3" placeholder="Écrivez votre commentaire..." required></textarea>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="document.getElementById('file-upload').click()">
                                                        <i class="fas fa-paperclip me-1"></i> Fichier
                                                    </button>
                                                    <input type="file" id="file-upload" class="d-none">
                                                    <button type="submit" class="btn btn-dark rounded-pill">
                                                        <i class="fas fa-paper-plane me-2"></i>Publier
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Tâches -->
                                <div class="tab-pane fade" id="tasks-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0">Gestion des tâches</h5>
                                        <button class="btn btn-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#showModal">
                                            <i class="fas fa-plus me-2"></i>Créer une tâche
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tâche</th>
                                                    <th>Assigné à</th>
                                                    <th>Statut</th>
                                                    <th>Échéance</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($project->tasks as $task)
                                                    <tr>
                                                        <td>
                                                            <span class="fw-semibold">{{ $task->title }}</span>
                                                            <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                        </td>
                                                        <td>
                                                            @if ($task->users->isNotEmpty())
                                                                <span class="bg-primary text-white rounded-2 d-inline-flex align-items-center justify-content-center me-2" style="width:30px;height:30px;">
                                                                    {{ strtoupper(substr($task->users->first()->name, 0, 1)) }}
                                                                </span>
                                                                <span>{{ $task->users->first()->name }}</span>
                                                            @else
                                                                <span class="text-muted">Non assignée</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge rounded-pill bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'danger') }}">
                                                                {{ $task->status == 'completed' ? 'Terminée' : ($task->status == 'in_progress' ? 'En cours' : 'Non commencée') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y H:i') }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#taskDetailsModal{{ $task->id }}">
                                                                            <i class="fas fa-eye me-2"></i>Détails
                                                                        </a>
                                                                    </li>
                                                                    @if ($task->users->isEmpty())
                                                                        <li>
                                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignTaskModal{{ $task->id }}">
                                                                                <i class="fas fa-user-plus me-2"></i>Assigner
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li>
                                                                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?');">
                                                                            @csrf @method('DELETE')
                                                                            <button type="submit" class="dropdown-item text-danger">
                                                                                <i class="fas fa-trash me-2"></i>Supprimer
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <i class="fas fa-tasks text-muted fs-1 opacity-25"></i>
                                                            <p class="text-muted mt-2">Aucune tâche créée</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Fichiers -->
                                <div class="tab-pane fade" id="files-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0">Tous les fichiers</h5>
                                        <form action="{{ route('files.store', $project) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                            @csrf
                                            <input type="file" id="file-input" name="file" class="d-none" onchange="this.form.submit()">
                                            <button type="button" class="btn btn-dark rounded-pill" onclick="document.getElementById('file-input').click()">
                                                <i class="fas fa-upload me-2"></i>Ajouter un fichier
                                            </button>
                                        </form>
                                    </div>
                                    @if ($project->files->isEmpty())
                                        <div class="text-center py-5">
                                            <i class="fas fa-file text-muted fs-1 opacity-25"></i>
                                            <h5 class="text-muted mt-3">Aucun fichier</h5>
                                            <p class="text-muted">Ajoutez des fichiers à votre projet</p>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Fichier</th>
                                                        <th>Type</th>
                                                        <th>Taille</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($project->files as $file)
                                                        @php
                                                            $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                                            $size = \Illuminate\Support\Facades\Storage::disk('public')->exists($file->file_path)
                                                                ? \Illuminate\Support\Facades\Storage::disk('public')->size($file->file_path)
                                                                : 0;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <span class="fw-semibold">{{ $file->file_name }}</span>
                                                            </td>
                                                            <td><span class="badge bg-light text-dark">{{ strtoupper($extension) }}</span></td>
                                                            <td>{{ number_format($size / 1024 / 1024, 2) }} MB</td>
                                                            <td>{{ $file->created_at->format('d/m/Y') }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-sm btn-outline-primary rounded-pill" download>
                                                                    <i class="fas fa-download me-1"></i>Télécharger
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Créer Tâche -->
            <div class="modal fade" id="showModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-3 shadow">
                        <div class="modal-header bg-primary text-white rounded-top-3">
                            <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Créer une nouvelle tâche</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('tasks.store', $project) }}" method="POST">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Titre</label>
                                        <input type="text" name="title" class="form-control bg-light" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Description</label>
                                        <textarea name="description" class="form-control bg-light" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Échéance</label>
                                        <input type="datetime-local" name="deadline" class="form-control bg-light">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Priorité</label>
                                        <select name="priority" class="form-select bg-light">
                                            <option value="low">Basse</option>
                                            <option value="medium">Moyenne</option>
                                            <option value="high">Haute</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Assigner à</label>
                                        <div class="border rounded-3 p-3 bg-light" style="max-height:200px;overflow-y:auto;">
                                            @forelse ($project->members as $member)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="assigned_to" value="{{ $member->id }}" id="member-{{ $member->id }}">
                                                    <label class="form-check-label d-flex align-items-center" for="member-{{ $member->id }}">
                                                        <span class="bg-primary text-white rounded-2 d-inline-flex align-items-center justify-content-center me-2" style="width:30px;height:30px;">
                                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                                        </span>
                                                        {{ $member->name }}
                                                    </label>
                                                </div>
                                            @empty
                                                <p class="text-muted mb-0">Aucun membre dans l'équipe</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4">
                                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary rounded-pill"><i class="fas fa-check me-2"></i>Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Gérer Membres -->
            <div class="modal fade" id="inviteMembersModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content rounded-3 shadow">
                        <div class="modal-header bg-success text-white rounded-top-3">
                            <h5 class="modal-title"><i class="fas fa-users me-2"></i>Gérer les membres</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="text" class="form-control bg-light mb-3" placeholder="Rechercher un membre...">
                            <div style="max-height:350px;overflow-y:auto;">
                                @foreach ($members as $member)
                                    <div class="d-flex align-items-center p-2 bg-light rounded-3 mb-2">
                                        <span class="bg-info text-white fw-bold rounded-2 d-flex align-items-center justify-content-center me-2" style="width:40px;height:40px;">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </span>
                                        <div class="flex-grow-1">
                                            <span class="fw-semibold">{{ $member->name }}</span>
                                            <small class="text-muted">{{ $member->email }}</small>
                                        </div>
                                        <div>
                                            @if ($Teammembers->contains('id', $member->id))
                                                <form action="{{ route('projects.removeMember', [$project->id, $member->id]) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                                        <i class="fas fa-minus me-1"></i>Retirer
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('projects.addMember', [$project->id, $member->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm rounded-pill">
                                                        <i class="fas fa-plus me-1"></i>Ajouter
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modals tâches -->
            @foreach ($project->tasks as $task)
                <div class="modal fade" id="taskDetailsModal{{ $task->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-3 shadow">
                            <div class="modal-header bg-info text-white rounded-top-3">
                                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Détails de la tâche</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div>
                                    <label class="form-label fw-semibold text-muted small">Titre</label>
                                    <p class="mb-0 fw-semibold">{{ $task->title }}</p>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-muted small">Description</label>
                                    <p class="mb-0">{{ $task->description ?: 'Aucune description fournie' }}</p>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-muted small">Statut</label>
                                    <span class="badge rounded-pill bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'danger') }}">
                                        {{ $task->status == 'completed' ? 'Terminée' : ($task->status == 'in_progress' ? 'En cours' : 'Non commencée') }}
                                    </span>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold text-muted small">Échéance</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y à H:i') }}</p>
                                </div>
                                @if($task->users->isNotEmpty())
                                    <div>
                                        <label class="form-label fw-semibold text-muted small">Assignée à</label>
                                        <span class="bg-primary text-white rounded-2 d-inline-flex align-items-center justify-content-center me-2" style="width:30px;height:30px;">
                                            {{ strtoupper(substr($task->users->first()->name, 0, 1)) }}
                                        </span>
                                        <span class="fw-semibold">{{ $task->users->first()->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if ($task->users->isEmpty())
                    <div class="modal fade" id="assignTaskModal{{ $task->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content rounded-3 shadow">
                                <div class="modal-header bg-warning text-dark rounded-top-3">
                                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Assigner la tâche</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('tasks.assign', $task->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Sélectionner un membre</label>
                                            <select name="user_id" class="form-select bg-light" required>
                                                <option value="">-- Choisir un membre --</option>
                                                @foreach ($project->members as $member)
                                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary rounded-pill"><i class="fas fa-check me-2"></i>Assigner</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</div>
@endsection