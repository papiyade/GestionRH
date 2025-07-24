@extends('layouts.chef_projet')
@section('content')

<div class="container-fluid">
    <!-- Header Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-lg-auto">
                    <div class="hstack gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createboardModal">
                            <i class="ri-add-line align-bottom me-1"></i> Créer un Tableau
                        </button>
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-3 col-auto">
                    <div class="search-box">
                        <input type="text" class="form-control search" id="search-task-options" placeholder="Rechercher un projet...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end card-body-->
    </div>
    <!--end header card-->

    <!-- Kanban Board -->
    <div class="tasks-board mb-3" id="kanbanboard">
        
        <!-- Column 1: Non Débuté -->
        <div class="tasks-list">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        Non Débuté 
                        <small class="badge bg-danger align-bottom ms-1 totaltask-badge">
                            {{ $projects->where('status', 'not_started')->count() }}
                        </small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priorité<i class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Niveau de priorité</a>
                            <a class="dropdown-item" href="#">Date d'ajout</a>
                        </div>
                    </div>
                </div>
            </div>

            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                @if ($projects->where('status', 'not_started')->count() == 0)
                    <div class="alert alert-info" role="alert">
                        Aucun projet non démarré
                    </div>
                @else
                    <div id="unassigned-task" class="tasks">
                        @foreach ($projects->where('status', 'not_started') as $projet_zero)
                            <div class="card tasks-box mb-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <h6 class="fs-15 mb-0 flex-grow-1 text-danger task-title">
                                            <a href="{{ route('projects.show', $projet_zero->id) }}" class="d-block">
                                                {{ $projet_zero->title }}
                                            </a>
                                        </h6>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                <li><a class="dropdown-item" href="{{ route('projects.show', $projet_zero->id) }}"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Voir</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Modifier</a></li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted">{{ $projet_zero->description }}</p>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="badge bg-primary-subtle text-primary">Immo</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-group">
                                                @if ($projet_zero->team->members->count() > 0)
                                                    @foreach ($projet_zero->team->members->take(3) as $user)
                                                        <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $user->name }}">
                                                            <div class="avatar-sm" style="width: 30px; height: 30px;">
                                                                <div class="avatar-title rounded-circle bg-primary text-light">
                                                                    {{ strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') !== false ? substr($user->name, strpos($user->name, ' ') + 1, 1) : '')) }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Aucun membre</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-dashed">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted">
                                                <i class="ri-time-line align-bottom"></i> 
                                                {{ $projet_zero->created_at->format('d, M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <ul class="link-inline mb-0">
                                                <li class="list-inline-item">
                                                    {{-- <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ $projet_zero->comments->count() }}</a> --}}
                                                </li>
                                                <li class="list-inline-item">
                                                    {{-- <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ $projet_zero->files->count() }}</a> --}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="my-3">
                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#createNotStartedModal" data-status="not_started">
                    Ajouter
                </button>
            </div>
        </div>
        <!--end tasks-list Non Débuté-->

        <!-- Column 2: En Cours -->
        <div class="tasks-list">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        En Cours 
                        <small class="badge bg-warning align-bottom ms-1 totaltask-badge">
                            {{ $projects->where('status', 'in_progress')->count() }}
                        </small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priorité<i class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Par niveau de priorité</a>
                            <a class="dropdown-item" href="#">Date d'ajout</a>
                        </div>
                    </div>
                </div>
            </div>

            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                @if ($projects->where('status', 'in_progress')->count() == 0)
                    <div class="alert alert-info" role="alert">
                        Aucun projet en cours
                    </div>
                @else
                    <div id="inprogress-task" class="tasks">
                        @foreach ($projects->where('status', 'in_progress') as $project_en_cours)
                            <div class="card tasks-box mb-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <h6 class="fs-15 mb-0 flex-grow-1 task-title">
                                            <a href="{{ route('projects.show', $project_en_cours->id) }}" class="text-truncate fw-medium fs-14">
                                                {{ $project_en_cours->title }}
                                            </a>
                                        </h6>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                                <li><a class="dropdown-item" href="{{ route('projects.show', $project_en_cours->id) }}"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Voir</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Modifier</a></li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted">{{ $project_en_cours->description }}</p>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="badge bg-primary-subtle text-primary">IT</span>
                                            <span class="badge bg-primary-subtle text-primary">Design</span>
                                            <span class="badge bg-primary-subtle text-primary">UI/UX</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-group">
                                                @if ($project_en_cours->team->members->count() > 0)
                                                    @foreach ($project_en_cours->team->members->take(3) as $user)
                                                        <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $user->name }}">
                                                            <div class="avatar-sm" style="width: 30px; height: 30px;">
                                                                <div class="avatar-title rounded-circle bg-primary text-light">
                                                                    {{ strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') !== false ? substr($user->name, strpos($user->name, ' ') + 1, 1) : '')) }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                    @if ($project_en_cours->team->members->count() > 3)
                                                        <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $project_en_cours->team->members->count() - 3 }} more">
                                                            <div class="avatar-sm" style="width: 30px; height: 30px;">
                                                                <div class="avatar-title rounded-circle bg-primary text-light">
                                                                    +{{ $project_en_cours->team->members->count() - 3 }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Aucun membre</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-dashed">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted">
                                                <i class="ri-time-line align-bottom"></i> 
                                                {{ $project_en_cours->created_at->format('d, M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <ul class="link-inline mb-0">
                                                <li class="list-inline-item">
                                                    {{-- <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ $project_en_cours->comments->count() }}</a> --}}
                                                </li>
                                                <li class="list-inline-item">
                                                    {{-- <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ $project_en_cours->files->count() }}</a> --}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="my-3">
                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#createInProgressModal" data-status="in_progress">
                    Ajouter
                </button>
            </div>
        </div>
        <!--end tasks-list En Cours-->

        <!-- Column 3: Terminé -->
        <div class="tasks-list">
            <div class="d-flex mb-3">
                <div class="flex-grow-1">
                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">
                        Terminé 
                        <small class="badge bg-success align-bottom ms-1 totaltask-badge">
                            {{ $projects->where('status', 'completed')->count() }}
                        </small>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fw-medium text-muted fs-12">Priorité<i class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Niveau de priorité</a>
                            <a class="dropdown-item" href="#">Date d'ajout</a>
                        </div>
                    </div>
                </div>
            </div>

            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                @if ($projects->where('status', 'completed')->count() == 0)
                    <div class="alert alert-info" role="alert">
                        Aucun projet terminé
                    </div>
                @else
                    <div id="completed-task" class="tasks">
                        @foreach ($projects->where('status', 'completed') as $project_termine)
                            <div class="card tasks-box mb-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <h6 class="fs-15 mb-0 flex-grow-1 text-success task-title">
                                            <a href="{{ route('projects.show', $project_termine->id) }}">
                                                {{ $project_termine->title }}
                                            </a>
                                        </h6>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink10" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink10">
                                                <li><a class="dropdown-item" href="{{ route('projects.show', $project_termine->id) }}"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Voir</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Modifier</a></li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted">{{ $project_termine->description }}</p>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="badge bg-primary-subtle text-primary">Design</span>
                                            <span class="badge bg-primary-subtle text-primary">Landing</span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="avatar-group">
                                                @if ($project_termine->team->members->count() > 0)
                                                    @foreach ($project_termine->team->members->take(3) as $user)
                                                        <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $user->name }}">
                                                            <div class="avatar-sm" style="width: 30px; height: 30px;">
                                                                <div class="avatar-title rounded-circle bg-primary text-light">
                                                                    {{ strtoupper(substr($user->name, 0, 1) . (strpos($user->name, ' ') !== false ? substr($user->name, strpos($user->name, ' ') + 1, 1) : '')) }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                    @if ($project_termine->team->members->count() > 3)
                                                        <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $project_termine->team->members->count() - 3 }} more">
                                                            <div class="avatar-sm" style="width: 30px; height: 30px;">
                                                                <div class="avatar-title rounded-circle bg-primary text-light">
                                                                    +{{ $project_termine->team->members->count() - 3 }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Aucun membre</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-dashed">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted">
                                                <i class="ri-time-line align-bottom"></i> 
                                                {{ $project_termine->created_at->format('d, M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <ul class="link-inline mb-0">
                                                <li class="list-inline-item">
                                                    {{-- <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ $project_termine->comments->count() }}</a> --}}
                                                </li>
                                                <li class="list-inline-item">
                                                    {{-- <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ $project_termine->files->count() }}</a> --}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="my-3">
                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-status="completed" data-bs-target="#createCompletedModal">
                    Ajouter
                </button>
            </div>
        </div>
        <!--end tasks-list Terminé-->
        
    </div>
    <!--end kanban board-->

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
<!--end container-fluid-->

<!-- Add Member Modal -->
<div class="modal fade" id="addmemberModal" tabindex="-1" aria-labelledby="addmemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-warning-subtle">
                <h5 class="modal-title" id="addmemberModalLabel">Add Member</h5>
                <button type="button" class="btn-close" id="btn-close-member" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="submissionidInput" class="form-label">Submission ID</label>
                            <input type="number" class="form-control" id="submissionidInput" placeholder="Submission ID">
                        </div>
                        <div class="col-lg-12">
                            <label for="profileimgInput" class="form-label">Profile Images</label>
                            <input class="form-control" type="file" id="profileimgInput">
                        </div>
                        <div class="col-lg-6">
                            <label for="firstnameInput" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstnameInput" placeholder="Enter firstname">
                        </div>
                        <div class="col-lg-6">
                            <label for="lastnameInput" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastnameInput" placeholder="Enter lastname">
                        </div>
                        <div class="col-lg-12">
                            <label for="designationInput" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designationInput" placeholder="Designation">
                        </div>
                        <div class="col-lg-12">
                            <label for="titleInput" class="form-label">Title</label>
                            <input type="text" class="form-control" id="titleInput" placeholder="Title">
                        </div>
                        <div class="col-lg-6">
                            <label for="numberInput" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="numberInput" placeholder="Phone number">
                        </div>
                        <div class="col-lg-6">
                            <label for="joiningdateInput" class="form-label">Joining Date</label>
                            <input type="text" class="form-control" id="joiningdateInput" data-provider="flatpickr" placeholder="Select date">
                        </div>
                        <div class="col-lg-12">
                            <label for="emailInput" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="emailInput" placeholder="Email">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="ri-close-line align-bottom me-1"></i> Close
                </button>
                <button type="button" class="btn btn-success" id="addMember">Add Member</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Board Modal -->
<div class="modal fade" id="createboardModal" tabindex="-1" aria-labelledby="createboardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="createboardModalLabel">Add Board</h5>
                <button type="button" class="btn-close" id="addBoardBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="boardName" class="form-label">Board Name</label>
                            <input type="text" class="form-control" id="boardName" placeholder="Enter board name">
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" id="addNewBoard">Add Board</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Not Started -->
<div class="modal fade" id="createNotStartedModal" tabindex="-1" aria-labelledby="createNotStartedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="createNotStartedLabel">Ajouter un projet (Non débuté)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="not_started">
                    
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label class="form-label">Nom du projet</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Équipe</label>
                            <select class="form-select" name="team_id" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour In Progress -->
<div class="modal fade" id="createInProgressModal" tabindex="-1" aria-labelledby="createInProgressLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="createInProgressLabel">Ajouter un projet (En cours)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="in_progress">

                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label class="form-label">Nom du projet</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Équipe</label>
                            <select class="form-select" name="team_id" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Completed -->
<div class="modal fade" id="createCompletedModal" tabindex="-1" aria-labelledby="createCompletedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="createCompletedLabel">Créer un projet (Terminé)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="completed">

                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label class="form-label">Nom du projet</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Équipe</label>
                            <select class="form-select" name="team_id" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="delete-btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this tasks ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-record">Yes, Delete It!</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Gestion des boutons d'ajout de projet
    document.querySelectorAll(".add-project-btn").forEach(button => {
        button.addEventListener("click", function () {
            let status = this.getAttribute("data-status");
            console.log("Statut défini :", status);
        });
    });

    // Gestion de la recherche
    const searchInput = document.getElementById('search-task-options');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const projectCards = document.querySelectorAll('.tasks-box');
            
            projectCards.forEach(card => {
                const title = card.querySelector('.task-title a').textContent.toLowerCase();
                const description = card.querySelector('.text-muted').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Initialisation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection