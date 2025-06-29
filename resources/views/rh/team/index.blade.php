@extends('layouts.admin_rh-dashboard')

@section('content')
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">ÉQUIPES</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Équipes</a></li>
                                        <li class="breadcrumb-item active">Liste des équipes</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button  class="btn btn-success" data-bs-target="#createProjectModal" data-bs-toggle="modal"><i class="ri-add-line align-bottom me-1"></i> Nouvelle équipe</button>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end gap-2">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control" placeholder="Rechercher...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>

                                    <select class="form-control w-md" data-choices data-choices-search-false>
                                        <option value="All" selected>Toutes les équipes</option>
                                        <option value="Today">Today</option>
                                        <option value="Yesterday">Yesterday</option>
                                        <option value="Last 7 Days">Last 7 Days</option>
                                        <option value="Last 30 Days">Last 30 Days</option>
                                        <option value="This Month">This Month</option>
                                        <option value="Last Year">Last Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($teams as $team)
                            <div class="col-xxl-3 col-sm-6 project-card">
                                <div class="card card-height-100">
                                    <div class="card-body">
                                        <div class="d-flex flex-column h-100">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-4">
                                                        Modifiée il y a {{ str_replace([' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week', ' months', ' month', ' years', ' year'], [' secondes', ' seconde', ' minutes', ' minute', ' heures', ' heure', ' jours', ' jour', ' semaines', ' semaine', ' mois', ' mois', ' années', ' année'], str_replace(' ago', '', $team->updated_at->diffForHumans())) }}
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex gap-1 align-items-center">
                                                        <button type="button" class="btn avatar-xs mt-n1 p-0 favourite-btn material-shadow-none">
                                                            <span class="avatar-title bg-transparent fs-15">
                                                                <i class="ri-star-fill"></i>
                                                            </span>
                                                        </button>
                                                        <div class="dropdown">
                                                            <button class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15 material-shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                <i data-feather="more-horizontal" class="icon-sm"></i>
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="{{ route('teams.show',$team->id) }}"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Voir</a>
                                                                <a class="dropdown-item" href="apps-projects-create.html"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Editer</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#removeProjectModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Supprimer</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mb-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-warning-subtle rounded p-2">
                                                            <img src="assets/images/brands/slack.png" alt="" class="img-fluid p-1">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-1 fs-15"><a href="#" class="text-body">{{$team->name}}</a></h5>
                                                    <p class="text-muted text-truncate-two-lines mb-3">@if($team->description)
                                                        {{$team->description}}
                                                    @else
                                                    Ajouter une description pour <strong>{{ $team->name }}</strong>
                                                    @endif
                                                </p>
                                                </div>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <div>Effectif</div>
                                                    </div>
                                                    <div class="flex-shrink-0" style=" display: flex;align-items: center;">
                                                        <div><i class="las la-users h2 align-bottom me-2  text-muted" ></i> <span>{{ $team->members->count() }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer bg-transparent border-top-dashed py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="avatar-group">
                                                    @foreach ($team->members as $member)
                                                    <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $member->name }}">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title rounded bg-info-subtle text-info material-shadow">
                                                                {{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                    @endforeach

                                                    <a href="javascript: void(0);" class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ajouter des membres">
                                                        <div class="avatar-xxs">
                                                            <div class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                                +
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-muted">
                                                    <i class="ri-calendar-event-fill me-1 align-bottom"></i> {{ $team->created_at->format('d M Y') }}
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- end card footer -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            @endforeach
                        </div>
                                                            <!-- end card body -->
                                    <div class="modal fade zoomIn" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header p-3 bg-success-subtle">
                                                    <h5 class="modal-title" id="createProjectModalLabel">Ajouter une équipe</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="addProjectBtn-close" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form autocomplete="on" action="{{ route('teams.store') }}" method="POST" class="needs-validation createProject-form" novalidate>
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="projectname-input" class="form-label">Nom de l'équipe</label>
                                                            <input type="text" class="form-control" name="name" id="projectname-input" autocomplete="off" placeholder="Entrez le nom de l'équipe" required>
                                                            <div class="invalid-feedback">Entrez le nom de l'équipe</div>
                                                            <input type="hidden" class="form-control" id="projectid-input" value="" placeholder="Enter project name">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="projectname-input" class="form-label">Description de l'équipe</label>
                                                            <input type="text" name="description" class="form-control" id="projectname-input" autocomplete="off" placeholder="Enter project name" required>
                                                            <div class="invalid-feedback">Entrez la description (facultatif)</div>
                                                            <input type="hidden" class="form-control" id="projectid-input" value="" placeholder="Enter project name">
                                                        </div>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-ghost-danger material-shadow-none" data-bs-dismiss="modal"><i class="ri-close-line align-bottom"></i> Annuler</button>
                                                            <button type="submit" class="btn btn-primary" id="addNewProject">Ajouter l'équipe</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end modal-dialog -->
                                    </div>
                        <!-- end row -->

                        <div class="row g-0 text-center text-sm-start align-items-center mb-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0 text-muted">Affichage de <span class="fw-semibold">1</span> à <span class="fw-semibold">2</span> sur <span class="fw-semibold text-decoration-underline">12</span> entrées</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link">Précedent</a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item ">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">Suivant</a>
                                    </li>
                                </ul>
                            </div><!-- end col -->
                        </div><!-- end row -->
@endsection
