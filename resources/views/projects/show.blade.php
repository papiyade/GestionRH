@extends('layouts.chef_projet')

@section('content')<!-- Offset Position -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- <div class="container mx-auto px-4 py-6">


                <!-- Formulaire pour ajouter un fichier -->

                <!-- Liste des tâches -->
                <h3 class="text-lg font-semibold text-gray-700 mt-4">Tâches</h3>
                <ul class="list-disc pl-5 text-gray-600 " style="list-style-type: none">
                    @foreach (['high' => 'Haute', 'medium' => 'Moyenne', 'low' => 'Basse'] as $priority => $label)
                        <li class="mt-4">
                            <h4 class="text-md font-semibold text-gray-700">{{ $label }}</h4>
                            <ul class="list-disc pl-5 text-gray-600" style="list-style-type: none">
                                @foreach ($tasks->where('priority', $priority) as $task)
                                    <li>
                                        <div class="flex justify-between items-center">
                                            <span class="flex items-center">
                                                <img src="https://icon-library.com/images/to-do-icon/to-do-icon-18.jpg" class="w-6 h-6 mr-2" alt="Icon">
                                                <span class="font-medium">{{ $task->title }}</span>
                                                <span class="ml-8 border border-orange-200 px-4 py-2 rounded-full text-white text-sm {{ $task->status == 'completed' ? 'bg-green-600' : 'bg-orange-600' }}">
                                                    {{ $task->status == 'completed' ? 'Terminée' : ($task->status == 'not_started' ? 'Non débuté' : ucfirst($task->status)) }}
                                                </span>
                                            </span>
                                            <div class="flex gap-2 items-center">
                                                @if ($task->status == 'completed')
                                                    <span class="text-green font-medium text-sm"></span>
                                                @else
                                                    <span class="text-red-600 font-medium text-sm">A faire avant le {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y à H:i') }}</span>
                                                    <!-- Marquer comme terminé -->
                                                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="text-green-600 font-medium text-sm hover:underline">Terminer</button>
                                                    </form>
                                                @endif

                                                <!-- Vérifie si un utilisateur est assigné -->
                                                @if ($task->users->isNotEmpty())
                                                    <span class="text-white px-4 py-2 bg-green-600 rounded text-sm font-medium">
                                                        Assigné à {{ $task->users->pluck('name')->join(', ') }}
                                                    </span>
                                                @else
                                                    <!-- Assigner un membre -->
                                                    <form action="{{ route('tasks.assign', $task) }}" method="POST" class="mb-2">
                                                        @csrf
                                                        <select name="user_id" onchange="this.form.submit()" class="bg-cyan-800 col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pl-3 pr-7 text-base text-white placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm">
                                                            <option value="" disabled selected>Assigner à</option>
                                                            @foreach ($project->team->members as $member)
                                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                @endif

                                                <!-- Supprimer une tâche -->
                                                <form action="{{ route('tasks.delete', $task) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9L14.394 18m-4.788 0L9.26 9m9.968-3.21a49.146 49.146 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a49.015 49.015 0 013.478-.397m7.5 0v-.916a2.25 2.25 0 00-2.09-2.201 51.964 51.964 0 00-3.32 0A2.25 2.25 0 007.5 4.428v.916m7.5 0a48.112 48.112 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <hr class="my-4">
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>

                <!-- Ajouter une tâche -->
                <h3 class="text-lg font-semibold text-gray-700 mt-4">Ajouter une tâche</h3>
                <form action="{{ route('tasks.store', $project) }}" method="POST" class="mt-2">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <input type="text" name="title" placeholder="Titre de la tâche" required
                            class="w-full border p-2 rounded border-cyan-500">
                        <textarea name="description" placeholder="Ajouter une description" class=" border-cyan-500 w-full border p-2 rounded"></textarea>
                        <select name="priority" class="border-cyan-500 w-full font-medium border p-2 rounded">
                            <option value="low" class="font-medium">Basse</option>
                            <option value="medium" class="font-medium">Moyenne</option>
                            <option value="high" class="font-medium">Haute</option>
                        </select>
                        <input type="datetime-local" name="deadline" class=" border-cyan-500 w-full border p-2 rounded">
                        <button type="submit" class="mt-2 bg-cyan-800 text-white py-2 px-4 rounded">Ajouter une
                            Tâche</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Retour à la liste -->
        <div class="flex justify-end mt-4">
            <a href="{{ route('projects.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded flex align-items">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                  </svg>

                Retour à la liste
            </a>
        </div>
    </div> --}}


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">{{ $project->title }}</h4>

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
                        $textColor = 'text-danger'; // Texte en rouge
                        $timeLeft = '25s';
                    } elseif ($progress >= 50) {
                        $progressColor = 'success';
                        $bgColor = 'bg-success-subtle';
                        $textColor = 'text-warning'; // Texte en jaune
                        $timeLeft = '45s';
                    } else {
                        $progressColor = 'secondary';
                        $bgColor = 'bg-secondary-subtle';
                        $textColor = 'text-danger'; // Texte en gris
                        $latestUpdate = collect([$project->tasks->max('updated_at'), $project->comments->max('created_at'), $project->files->max('created_at')])->filter()->max();
                        $timeLeft = $latestUpdate ? \Carbon\Carbon::parse($latestUpdate)->diffForHumans() : 'Aucune mise à jour récente';
                    }
                @endphp

                <div class="card bg-light overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">
                                    <b class="{{ $textColor }}">{{ round($progress) }}%</b>
                                    @if ($project->status == 'not_started')
                                        Commencez à accomplir les tâches pour voir la progression du projet.
                                    @elseif ($project->status == 'in_progress')
                                        En cours de progression...
                                    @else
                                        Aucune nouvelle tâche dans le projet.
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
        </div>
        <!--end card-->
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
                    <!--end table-->
                </div>
            </div>
        </div>
        <!--end card-->
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
        <!--end card-->
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
            <!--end card-->
        </div>
        <!---end col-->
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
                        <!--end nav-->
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
                                            <!-- Avatar -->
                                            <div class="avatar-sm flex-shrink-0">
                                                <div class="avatar-title rounded bg-info-subtle text-info material-shadow">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1) . (strpos($comment->user->name, ' ') !== false ? substr($comment->user->name, strpos($comment->user->name, ' ') + 1, 1) : '')) }}
                                                </div>
                                            </div>
                                            <!-- Contenu du commentaire -->
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
                            <!--end simplebar-->

                            <div class="row g-3">
                                <!-- Formulaire de commentaire -->
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
                            
                                <!-- Formulaire de fichier -->
                                <div class="col-lg-12">
                                    <form action="{{ route('files.store', $project) }}" method="POST" enctype="multipart/form-data" class="d-flex justify-content-end align-items-center">
                                        @csrf
                                        <!-- Champ fichier caché -->
                                        <input type="file" id="file-upload" name="file" class="d-none">
                            
                                        <!-- Bouton pour ouvrir le sélecteur -->
                                        <button type="button" id="upload-btn" class="btn btn-ghost-secondary btn-icon waves-effect me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Joindre un fichier">
                                            <i class="ri-attachment-line fs-16"></i>
                                        </button>
                            
                                        <!-- Bouton Téléverser -->
                                        <button type="submit" id="submit-file-btn" class="btn btn-primary d-none">
                                            <i class="ri-upload-cloud-2-line me-1"></i> Téléverser
                                        </button>
                                    </form>
                                </div>
                            </div>
                            

                            <!--end row-->

                        </div>
                        <!--end tab-pane-->
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
                                <!--end table-->
                            </div>
                        </div>
                        <!--end tab-pane-->
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

                                                <!-- Dropdown actions -->
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <!-- Ouvrir le modal des détails -->
                                                            <li>
                                                                <a href="#" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#taskDetailsModal{{ $task->id }}">
                                                                    Voir les détails
                                                                </a>
                                                            </li>

                                                            <!-- Assigner un membre si non assignée -->
                                                            @if ($task->users->isEmpty())
                                                                <li>
                                                                    <a href="#" class="dropdown-item"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#assignTaskModal{{ $task->id }}">
                                                                        Assigner un membre
                                                                    </a>
                                                                </li>
                                                            @endif

                                                            <!-- Supprimer la tâche -->
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

                                            <!-- Modal pour les détails de la tâche -->
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

                                            <!-- Modal pour assigner un membre -->
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
                                <!--end table-->
                            </div>
                        </div>
                        <!--edn tab-pane-->

                    </div>
                    <!--end tab-content-->
                </div>
            </div>
            <!--end card-->
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
                                    <!--end col-->
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
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="exampleInputdate" class="form-label">Deadline</label>
                                        <input type="datetime-local" class="form-control" id="exampleInputdate"
                                            name="deadline">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="ticket-status" class="form-label">Statut</label>
                                        <select class="form-control" id="ticket-status" name="priority">
                                            <option value="low">Basse</option>
                                            <option value="medium">Moyenne</option>
                                            <option value="high">Haute</option>
                                        </select>
                                    </div>
                                    <!--end col-->
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <label for="description-field" class="form-label">Description</label>
                                        <textarea name="description" id="description-field" class="form-control" placeholder="Ajouter une description"></textarea>
                                    </div>
                                </div>
                                <!--end row-->
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
