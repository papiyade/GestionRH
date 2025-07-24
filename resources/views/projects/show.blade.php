@extends('layouts.chef_projet')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
    <h4 class="mb-sm-0">{{ $project->title }}</h4>

    <a href="{{ route('projets.taches', ['projet' => $project->id]) }}" class="btn btn-primary">
        Voir les tâches
    </a>

    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Projet</a></li>
            <li class="breadcrumb-item active">{{ $project->title }}</li>
        </ol>
    </div>
</div>

        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                @php
                    $totalTasks = $project->tasks->count();
                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                    $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

                    // Définition des couleurs en fonction du progrès
                    if ($progress >= 75) {
                        $progressColor = 'danger';
                        $bgColor = 'bg-danger-subtle';
                        $textColor = 'text-danger';
                        $timeLeft = '25s';
                    } elseif ($progress >= 50) {
                        $progressColor = 'success';
                        $bgColor = 'bg-success-subtle';
                        $textColor = 'text-warning';
                        $timeLeft = '45s';
                    } else {
                        $progressColor = 'secondary';
                        $bgColor = 'bg-secondary-subtle';
                        $textColor = 'text-danger';
                        $latestUpdate = collect([$project->tasks->max('updated_at'), $project->comments->max('created_at'), $project->files->max('created_at')])->filter()->max();
                        $timeLeft = $latestUpdate ? \Carbon\Carbon::parse($latestUpdate)->diffForHumans() : 'Aucune mise à jour récente';
                    }
                @endphp

                <div class="card bg-light overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                               @php
    $textColor = $progress == 100 ? 'text-success' : 'text-primary';
@endphp

<h6 class="mb-0">
    <b class="{{ $textColor }}">{{ round($progress) }}%</b>
    @if ($progress == 0)
        Commencez à accomplir les tâches pour voir la progression du projet.
    @elseif ($progress > 0 && $progress < 100)
        En cours de progression...
    @elseif ($progress == 100)
        Projet terminé !
    @else
        Aucune tâche dans le projet.
    @endif
</h6>

                            </div>
                            <div class="flex-shrink-0">
                                <h6 class="mb-0">{{ $timeLeft }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="progress {{ $bgColor }} rounded-0">
                        <div class="progress-bar bg-{{ $progressColor }}" role="progressbar"
                            style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>

                <div class="mt-2 ms-2">
                    @if ($progress == 100)
                        <p class="ms-2 text-success fw-medium"> Félicitations ! Toutes les tâches ont été complétées.</p>
                    @elseif ($progress >= 75)
                        <p class="ms-2 text-primary fw-medium"> Bon travail ! Le projet est presque terminé.</p>
                    @elseif ($progress >= 50)
                        <p class="ms-2 text-warning fw-medium"> Vous êtes à mi-chemin. Continuez comme ça !</p>
                    @elseif ($progress >= 25)
                        <p class="ms-2 text-orange fw-medium"> Le projet est en bonne voie. Continuez vos efforts.</p>
                    @else
                        <p class="ms-2 text-danger fw-medium">Le projet vient de commencer. Beaucoup de travail reste à
                            faire.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-card">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-medium">N° du projet</td>
                                    <td>{{ $project->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Nom du projet</td>
                                    <td>{{ $project->title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Status</td>
                                    <td>
                                        @if ($project->status == 'not_started')
                                            <span class="badge bg-danger-subtle text-danger">Non débuté</span>
                                        @elseif ($project->status == 'in_progress')
                                            <span class="badge bg-warning-subtle text-warning">En Cours</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success">Terminé</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Date de création</td>
                                    <td>{{ $project->created_at->format('d, M Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <h6 class="card-title mb-0 flex-grow-1">Membres du projet</h6>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-soft-danger btn-sm material-shadow-none"
                                data-bs-toggle="modal" data-bs-target="#inviteMembersModal">Membres assignés</button>
                        </div>
                    </div>
                    <ul class="list-unstyled vstack gap-3 mb-0">
                        @foreach ($project->members as $member)
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md">
                                            <div class="avatar-title rounded bg-info-subtle text-info material-shadow">
{{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-1">
                                            <a href="pages-profile.html">
                                                {{ $member->name }}
                                                @if ($member->pivot->is_lead)
                                                    <i class="ri-star-fill text-warning me-1" title="Lead Tech"></i>
                                                @endif
                                            </a>
                                        </h6>
                                        <p class="text-muted mb-0">Membre</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-sm fs-16 text-muted dropdown material-shadow-none"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-eye-fill text-muted me-2 align-bottom"></i>Voir</a></li>
                                                <li>
                                                    <form action="{{ route('projects.toggleLead', [$project->id, $member->id]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="ri-star-fill text-muted me-2 align-bottom"></i>
                                                            @if ($member->pivot->is_lead)
                                                                Retirer le rôle de Lead
                                                            @else
                                                                Désigner comme Lead Tech
                                                            @endif
                                                        </button>
                                                    </form>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Retirer</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pièces jointes</h5>
                    <div class="vstack gap-2">
                        @if ($project->files->isEmpty())
                            <div class="text-center">
                                <img src="{{ asset('assets/images/illustrator/empty.svg') }}" alt="Illustration"
                                    class="img-fluid" style="max-width: 200px">
                                <h5 class="mt-3">Aucun fichier n'a été téléversé.</h5>
                            </div>
                        @else
                            @foreach ($project->files as $file)
                                @php
                                    $size = \Illuminate\Support\Facades\Storage::disk('public')->exists($file->file_path)
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->size($file->file_path)
                                        : 0;
                                    $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                    $icons = [
                                        'pdf' => 'ri-file-pdf-line',
                                        'ppt' => 'ri-file-ppt-2-line',
                                        'pptx' => 'ri-file-ppt-2-line',
                                        'zip' => 'ri-folder-zip-line',
                                        'rar' => 'ri-folder-zip-line',
                                        'doc' => 'ri-file-word-2-line',
                                        'docx' => 'ri-file-word-2-line',
                                        'xls' => 'ri-file-excel-2-line',
                                        'xlsx' => 'ri-file-excel-2-line',
                                        'txt' => 'ri-file-text-line',
                                        'jpg' => 'ri-image-line',
                                        'jpeg' => 'ri-image-line',
                                        'png' => 'ri-image-line',
                                        'gif' => 'ri-image-line',
                                        'default' => 'ri-file-line',
                                    ];
                                    $icon = $icons[$extension] ?? $icons['default'];
                                @endphp
                                <div class="border rounded border-dashed p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                    <i class="{{ $icon }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="fs-13 mb-1">
                                                <a href="{{ asset('storage/' . $file->path) }}"
                                                    class="text-body text-truncate d-block" download>
                                                    {{ $file->file_name }}
                                                </a>
                                            </h5>
                                            <div>{{ number_format($size / 1024 / 1024, 2) }} MB</div>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="d-flex gap-1">
                                                <button type="button"
                                                    class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none">
                                                    <i class="ri-download-2-line"></i>
                                                </button>
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-icon text-muted btn-sm fs-18 dropdown material-shadow-none"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                Ouvrir</a></li>
                                                        <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-danger"></i>
                                                                Supprimer</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-2 text-center">
                                <button type="button" class="btn btn-success">Voir plus</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card">
                <div class="card-header">
                    <div>
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                    Commentaires ({{ $project->comments->count() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                                    Pièces jointes ({{ $project->files->count() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab">
                                    Taches assignées
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-1" role="tabpanel">
                            <h5 class="card-title mb-4">Commentaires</h5>
                            <div data-simplebar class="px-3 mx-n3 mb-2">
                                @if ($project->comments->isEmpty())
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/illustrator/empty.svg') }}" alt="Illustration"
                                            class="img-fluid" style="max-width: 200px">
                                        <h5 class="mt-3">Aucun commentaire n'a été ajouté.</h5>
                                    </div>
                                @else
                                    @foreach ($comments as $comment)
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="avatar-sm flex-shrink-0">
                                                <div class="avatar-title rounded bg-info-subtle text-info material-shadow">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1) . (strpos($comment->user->name, ' ') !== false ? substr($comment->user->name, strpos($comment->user->name, ' ') + 1, 1) : '')) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-13 mb-1">
                                                    <a href="pages-profile.html">{{ $comment->user->name }}</a>
                                                    <small
                                                        class="text-muted">{{ $comment->created_at->format('d, M Y - H:i') }}</small>
                                                </h5>
                                                <p class="text-muted mb-0">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <br>
                                @endif
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <form action="{{ route('comments.store', $project) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <label for="comment-content" class="form-label">Écrire un commentaire</label>
                                        <textarea class="form-control bg-light border-light" name="content" id="comment-content" rows="3" placeholder="Écrire un commentaire"></textarea>
                            
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-success">Commenter</button>
                                        </div>
                                    </form>
                                </div>
                            
                                <div class="col-lg-12">
                                    <form action="{{ route('files.store', $project) }}" method="POST" enctype="multipart/form-data" class="d-flex justify-content-end align-items-center">
                                        @csrf
                                        <input type="file" id="file-upload" name="file" class="d-none">
                            
                                        <button type="button" id="upload-btn" class="btn btn-ghost-secondary btn-icon waves-effect me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Joindre un fichier">
                                            <i class="ri-attachment-line fs-16"></i>
                                        </button>
                            
                                        <button type="submit" id="submit-file-btn" class="btn btn-primary d-none">
                                            <i class="ri-upload-cloud-2-line me-1"></i> Téléverser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="messages-1" role="tabpanel">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Nom du fichier</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Taille</th>
                                            <th scope="col">Date d'ajout</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->files as $file)
                                            @php
                                                $size = \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                                    $file->file_path,
                                                )
                                                    ? \Illuminate\Support\Facades\Storage::disk('public')->size(
                                                        $file->file_path,
                                                    )
                                                    : 0;
                                                $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                                $icons = [
                                                    'pdf' => 'ri-file-pdf-fill',
                                                    'ppt' => 'ri-file-ppt-2-fill',
                                                    'pptx' => 'ri-file-ppt-2-fill',
                                                    'zip' => 'ri-folder-zip-fill',
                                                    'rar' => 'ri-folder-zip-fill',
                                                    'doc' => 'ri-file-word-2-fill',
                                                    'docx' => 'ri-file-word-2-fill',
                                                    'xls' => 'ri-file-excel-2-fill',
                                                    'xlsx' => 'ri-file-excel-2-fill',
                                                    'txt' => 'ri-file-text-fill',
                                                    'jpg' => 'ri-image-2-fill',
                                                    'jpeg' => 'ri-image-2-fill',
                                                    'png' => 'ri-image-2-fill',
                                                    'gif' => 'ri-image-2-fill',
                                                    'default' => 'ri-file-fill',
                                                ];
                                                $icon = $icons[$extension] ?? $icons['default'];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm">
                                                            <div
                                                                class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                <i class="{{ $icon }}"></i>
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a
                                                                    href="{{ asset('storage/' . $file->path) }}"
                                                                    download>{{ $file->file_name }}</a></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ strtoupper($extension) }}</td>
                                                <td>{{ number_format($size / 1024 / 1024, 2) }} MB</td>
                                                <td>{{ $file->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" class="btn btn-light btn-icon"
                                                            id="dropdownMenuLink2" data-bs-toggle="dropdown"
                                                            aria-expanded="false" data-bs-placement="right-end">
                                                            <i class="ri-equalizer-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="dropdownMenuLink2"
                                                            style="top: auto !important; bottom: 100% !important; right: 0;">
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                        class="ri-eye-fill me-2 align-middle text-muted"></i>Ouvrir</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                        class="ri-download-2-fill me-2 align-middle text-muted"></i>Télecharger</a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                                        class="ri-delete-bin-5-line me-2 align-middle text-danger"></i>Supprimer</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="profile-1" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="card-title mb-0">Taches assignées</h6>
                                <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Créer une
                                    tache</button>
                            </div>

                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Assignée à</th>
                                            <th scope="col">Date d'assignation</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Nom de la tache</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->tasks as $task)
                                            <tr>
                                                <td>
                                                    @if ($task->users->isNotEmpty())
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $task->users->first()->profile_photo_url }}"
                                                                alt="" class="rounded-circle avatar-xxs">
                                                            <div class="flex-grow-1 ms-2">
                                                                <a href=""
                                                                    class="fw-medium">{{ $task->users->first()->name }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        Non assignée
                                                    @endif
                                                </td>
                                                <td>{{ $task->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $task->status == 'completed' ? 'bg-success-subtle text-success' : ($task->status == 'in_progress' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                                                        {{ $task->status == 'completed' ? 'Terminée' : ($task->status == 'in_progress' ? 'En cours' : 'Non finie') }}
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y - H:i') }}
                                                </td>
                                                <td>{{ $task->title }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#taskDetailsModal{{ $task->id }}">
                                                                    Voir les détails
                                                                </a>
                                                            </li>

                                                            @if ($task->users->isEmpty())
                                                                <li>
                                                                    <a href="#" class="dropdown-item"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#assignTaskModal{{ $task->id }}">
                                                                        Assigner un membre
                                                                    </a>
                                                                </li>
                                                            @endif

                                                            <li>
                                                                <form action="{{ route('tasks.delete', $task->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        Supprimer
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="taskDetailsModal{{ $task->id }}"
                                                tabindex="-1" aria-labelledby="taskDetailsLabel{{ $task->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="taskDetailsLabel{{ $task->id }}">Détails de la
                                                                tâche</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Titre :</strong> {{ $task->title }}</p>
                                                            <p><strong>Description :</strong> {{ $task->description }}</p>
                                                            <p><strong>Statut :</strong>
                                                                @if ($task->status == 'completed')
                                                                    <span
                                                                        class="badge bg-success-subtle text-success">Terminée</span>
                                                                @elseif ($task->status == 'in_progress')
                                                                    <span class="badge bg-warning-subtle text-warning">En
                                                                        cours</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">Non
                                                                        finie</span>
                                                                @endif
                                                            </p>
                                                            <p><strong>Deadline :</strong> Le
                                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y à H:i') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($task->users->isEmpty())
                                                <div class="modal fade" id="assignTaskModal{{ $task->id }}"
                                                    tabindex="-1" aria-labelledby="assignTaskLabel{{ $task->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="assignTaskLabel{{ $task->id }}">Assigner un
                                                                    membre</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('tasks.assign', $task->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="user_id"
                                                                            class="form-label">Sélectionner un membre
                                                                            :</label>
                                                                        <select name="user_id" class="form-select">
                                                                            <option value="">-- Sélectionner un
                                                                                membre --</option>
                                                                            @foreach ($project->members as $member)
                                                                                <option value="{{ $member->id }}">
                                                                                    {{ $member->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Assigner</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="exampleModalLabel">Créer une tache</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form action="{{ route('tasks.store', $project) }}" method="POST" class="tablelist-form mt-2"
                            autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="tasksId" />
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div>
                                            <label for="tasksTitle-field" class="form-label">Titre</label>
                                            <input type="text" id="tasksTitle-field" name="title"
                                                class="form-control" placeholder="Titre de la tâche" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Assigner à</label>
                                        <div data-simplebar style="height: 95px;">
                                            <ul class="list-unstyled vstack gap-2 mb-0">
                                                @foreach ($project->members as $member)
                                                    <li>
                                                        <div class="form-check d-flex align-items-center">
                                                            <input class="form-check-input me-3" type="radio"
                                                                name="assigned_to" value="{{ $member->id }}"
                                                                id="member-{{ $member->id }}">
                                                            <label class="form-check-label d-flex align-items-center"
                                                                for="member-{{ $member->id }}">
                                                                <span class="flex-shrink-0">
                                                                    <img src="{{ $member->profile_photo_url }}"
                                                                        alt="" class="avatar-xxs rounded-circle">
                                                                </span>
                                                                <span class="flex-grow-1 ms-2">{{ $member->name }}</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="exampleInputdate" class="form-label">Deadline</label>
                                        <input type="datetime-local" class="form-control" id="exampleInputdate"
                                            name="deadline">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="ticket-status" class="form-label">Statut</label>
                                        <select class="form-control" id="ticket-status" name="priority">
                                            <option value="low">Basse</option>
                                            <option value="medium">Moyenne</option>
                                            <option value="high">Haute</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="description-field" class="form-label">Description</label>
                                        <textarea name="description" id="description-field" class="form-control" placeholder="Ajouter une description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" id="close-modal"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Ajouter la
                                        tâche</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 ps-4 bg-success-subtle">
                            <h5 class="modal-title" id="inviteMembersModalLabel">Ajouter des membres au projet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="search-box mb-3">
                                <input type="text" class="form-control bg-light border-light"
                                    placeholder="Rechercher un membre...">
                                <i class="ri-search-line search-icon"></i>
                            </div>

                            <div class="mx-n4 px-4" style="max-height: 225px; overflow-y: auto;">
                                <div class="vstack gap-3">
                                    @foreach ($members as $member)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0 me-3">
                                                <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-13 mb-0">{{ $member->name }}</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                @if ($Teammembers->contains('id', $member->id))
                                                    <form action="{{ route('projects.removeMember', [$project->id, $member->id]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('projects.addMember', [$project->id, $member->id]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">Ajouter</button>
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
            </div>
        </div>
    </div>
    <!--end row-->


    <!-- end modal -->

    <script>
        const fileInput = document.getElementById('file-upload');
        const uploadBtn = document.getElementById('upload-btn');
        const submitBtn = document.getElementById('submit-file-btn');

        uploadBtn.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                uploadBtn.innerHTML = `<i class="ri-attachment-2 fs-16 me-1"></i> ${fileName}`;
                uploadBtn.classList.remove('btn-icon');
                uploadBtn.classList.add('btn-outline-secondary');

                // Affiche le bouton "Téléverser"
                submitBtn.classList.remove('d-none');
            }
        });
    </script>


@endsection
