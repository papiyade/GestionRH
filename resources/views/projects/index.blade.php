{{-- @extends('layouts.mydashboard')

@section('content')
    {{-- {{-- <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Liste des Projets</h1>
            <a href="{{ route('projects.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                + Créer un Projet
            </a>
        </div>

        <!-- Projects Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-4 border-b border-gray-200 font-semibold text-gray-700">Nom</th>
                        <th class="text-left px-6 py-4 border-b border-gray-200 font-semibold text-gray-700">Équipe</th>
                        <th class="text-left px-6 py-4 border-b border-gray-200 font-semibold text-gray-700">Statut</th>
                        <th class="text-left px-6 py-4 border-b border-gray-200 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800">
                                {{ $project->title }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-600">
                                {{ $project->team->name }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                <span
                                    class="px-3 py-1 rounded-full text-white
                                {{ $project->status == 'in_progress' ? 'bg-yellow-600' : ($project->status == 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                                    {{ $project->status == 'in_progress' ? 'En cours' : ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 flex space-x-3">
                                <!-- Bouton "Voir" -->
                                <a href="{{ route('projects.show', $project->id) }}"
                                    class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-1 px-3 rounded">
                                    Voir
                                 </a>



                                <a href="" {{-- {{ route('projects.edit', $project) }} --}}
                                    {{-- class="bg-yellow-400 hover:bg-yellow-500 text-white font-medium py-1 px-3 rounded">
                                    Modifier --}}
                                {{-- </a> --}}
                                {{-- <form action="" {{ route('projects.destroy', $project) }} method="POST" style="display:inline;"> --}}
                                    {{-- @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        </div>

        <div class="mt-6">

        </div>
    </div>  --}}

@extends('layouts.chef_projet')
@section('content')

                  

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-lg-auto">
                                    <div class="hstack gap-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createboardModal"><i class="ri-add-line align-bottom me-1"></i> Créer un Tableau</button>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-auto">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" id="search-task-options" placeholder="Rechercher un projet...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                {{-- <div class="col-auto ms-sm-auto">
                                    <div class="avatar-group" id="newMembar">
                                        @foreach ($projects->teams->members as $member)
                                            <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $member->name }}">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title rounded-circle bg-primary text-light">
                                                        {{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                        <a href="#addmemberModal" data-bs-toggle="modal" class="avatar-group-item material-shadow">
                                            <div class="avatar-xs">
                                                <div class="avatar-title rounded-circle">
                                                    +
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div> --}}
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>

                    <!--end card-->
                    <div class="tasks-board mb-3" id="kanbanboard">
                        <div class="tasks-list">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">Non Débuté <small class="badge bg-danger align-bottom ms-1 totaltask-badge">{{ $projects->where('status', 'not_started')->count() }}</small></h6>
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

                                    <div class="card tasks-box">
                                        <div class="card-body">
                                            <div class="d-flex mb-2">
 												<h6 class="fs-15 mb-0 flex-grow-1 text-danger task-title"><a href="{{ route('projects.show', $projet_zero->id) }}" class="d-block">{{$projet_zero->title}}</a></h6>
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                        <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p class="text-muted">{{$projet_zero->description}}</p>
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
                                                    Aucun membre
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer border-top-dashed">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> {{ $projet_zero->created_at->format('d, M Y') }}</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <ul class="link-inline mb-0">
                                                        <li class="list-inline-item">
                                                   {{--         <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ $projet_zero->comments->count() }}</a>  --}} 
                                                        </li>
                                                        <li class="list-inline-item">
                                                   {{--         <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ $projet_zero->files->count() }}</a> --}}  
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                    @endforeach

                                    <!--end card-->
                                </div>
                                <!--end tasks-->
                                @endif
                            </div>
                            <div class="my-3">
                                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#createNotStartedModal" data-status="not_started">
                                Ajouter
                            </button>
                            </div>
                        </div>
                        <!--end tasks-list-->
                        <div class="tasks-list">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">En Cours <small class="badge bg-warning align-bottom ms-1 totaltask-badge">{{ $projects->where('status', 'in_progress')->count() }}</small></h6>
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

                                @foreach ($projects->where('status', 'in_progress') as $project_en_cours)
                                <div id="inprogress-task" class="tasks">
                                    <div class="card tasks-box">
                                        <div class="card-body">
                                            <div class="d-flex mb-2">
                                                <a href="{{ route('projects.show', $project_en_cours->id) }}" class="text-truncate fw-medium fs-14 flex-grow-1">{{ $project_en_cours->title }}</a>
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5">
                                                        <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
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
                                                            Aucun membre
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer border-top-dashed">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> {{ $project_en_cours->created_at->format('d, M Y') }}</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <ul class="link-inline mb-0">
                                                        <li class="list-inline-item">
                                                      {{--       <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ $project_en_cours->comments->count() }}</a> --}}
                                                        </li>
                                                        <li class="list-inline-item">
                                                       {{--       <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ $project_en_cours->files->count() }}</a> --}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <br class="mb-4">
                                    </div>
                                    <!--end card-->
                                </div>
                                @endforeach

                                @endif

                            </div>
                            <div class="my-3">
                                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#createInProgressModal" data-status="in_progress">Ajouter</button>
                            </div>
                        </div>
                        <!--end tasks-list-->
                        <div class="tasks-list">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 text-uppercase fw-semibold mb-0">Terminé <small class="badge bg-success align-bottom ms-1 totaltask-badge">{{ $projects->where('status', 'completed')->count() }}</small></h6>
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
                                @foreach ($projects->where('status', 'completed') as $project_termine)
                                <div id="completed-task" class="tasks">
                                    <div class="card tasks-box">
                                        <div class="card-body">
                                            <div class="d-flex mb-2">
                                                <h6 class="fs-15 mb-0 flex-grow-1 text-success task-title"><a href="{{ route('projects.show', $project_termine->id) }}">
                                                {{$project_termine->title}}</a></h6>
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink10" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink10">
                                                        <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p class="text-muted">{{$project_termine->description}}</p>
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
                                                            Aucun membre
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer border-top-dashed">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <span class="text-muted"><i class="ri-time-line align-bottom"></i> {{ $project_termine->created_at->format('d, M Y') }}</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <ul class="link-inline mb-0">
                                                        <li class="list-inline-item">
                                                   {{--          <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ $project_termine->comments->count() }}</a>  --}}
                                                        </li>
                                                        <li class="list-inline-item">
                                                 {{--              <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ $project_termine->files->count() }}</a>  --}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                    <!--end card-->
                                </div>

                                @endforeach

                                @endif

                            </div>
                            <div class="my-3">
                                <button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-status="completed" data-bs-target="#createCompletedModal">Ajouter</button>
                            </div>
                        </div>
                        <!--end tasks-list-->
                    </div>

                </div>

            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <!-- end main content-->

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
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <label for="profileimgInput" class="form-label">Profile Images</label>
                                        <input class="form-control" type="file" id="profileimgInput">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="firstnameInput" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstnameInput" placeholder="Enter firstname">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="lastnameInput" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastnameInput" placeholder="Enter lastname">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <label for="designationInput" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designationInput" placeholder="Designation">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <label for="titleInput" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="titleInput" placeholder="Title">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="numberInput" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="numberInput" placeholder="Phone number">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="joiningdateInput" class="form-label">Joining Date</label>
                                        <input type="text" class="form-control" id="joiningdateInput" data-provider="flatpickr" placeholder="Select date">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <label for="emailInput" class="form-label">Email ID</label>
                                        <input type="email" class="form-control" id="emailInput" placeholder="Email">
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line align-bottom me-1"></i> Close</button>
                            <button type="button" class="btn btn-success" id="addMember">Add Member</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end add member modal-->

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
            <!--end add board modal-->

            {{-- <div class="modal fade" id="creatertaskModal" tabindex="-1" aria-labelledby="creatertaskModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="creatertaskModalLabel">Créer un nouveau projet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="{{ route('projects.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <label for="projectName" class="form-label">Nom du projet</label>
                                        <input type="text" class="form-control" id="projectName" name="title" required placeholder="Nom du projet">
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="task-description" class="form-label">Description du projet</label>
                                        <textarea class="form-control" id="task-description" name="description" rows="3" placeholder="Description"></textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="team" class="form-label">Équipe</label>
                                        <select class="form-select" id="team" name="team_id" required>
                                            @foreach(Auth::user()->teams as $team)
                                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" id="project_status" name="status">
                                    <p id="status-debug"></p>


                                    <div class="mt-4">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-success">Ajouter le projet</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div> --}}
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

            <!--end add board modal-->
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
            <!--end modal -->

            <script>
                document.getElementById("project_status").addEventListener("change", function () {
    document.getElementById("status-debug").innerText = "Valeur actuelle : " + this.value;
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".add-project-btn").forEach(button => {
        button.addEventListener("click", function () {
            let status = this.getAttribute("data-status");
            document.getElementById("project_status").value = status;
            console.log("Statut défini :", status); // Vérifier si le statut est bien pris en compte
            new bootstrap.Modal(document.getElementById("creatertaskModal")).show();
        });
    });

    document.querySelector("form").addEventListener("submit", function (event) {
        let statusValue = document.getElementById("project_status").value;
        if (!statusValue) {
            event.preventDefault(); // Empêche l'envoi du formulaire si le champ est vide
            alert("Le champ status est vide !");
        }
    });
});



            </script>



@endsection
