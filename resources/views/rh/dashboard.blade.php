@extends('layout.admin_rh')
@section('title', 'Tableau de Bord RH')
@section('page-title', 'admin')



@section('content')

    <h1>Tableau de Bord RH </h1>
    <!-- Welcome Wrap -->
    <div class="card border-0" style="background: linear-gradient(90deg, #ff6600 0%, #FF8C00 100%);">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
            <div class="d-flex align-items-center mb-3">
                <span class="avatar avatar-xl flex-shrink-0">
                    <span class="rounded-circle bg-light text-primary d-flex align-items-center justify-content-center"
                        style="width:48px; height:48px; font-size:1.5rem;" alt="img">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </span>
                <div class="ms-3">
                    <h3 class="mb-2">Bienvenue, {{ Auth::user()->name }} <a href="javascript:void(0);" class="edit-icon"><i
                                class="ti ti-edit fs-14"></i></a></h3>
                    {{-- <p>You have <span class="text-primary text-decoration-underline">21</span> Pending Approvals & <span class="text-primary text-decoration-underline">14</span> Leave Requests</p> --}}
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap mb-1">
                <a href="{{ route('rh.users.create') }}" class="btn btn-secondary btn-md me-2 mb-2"
                    ><i class="ti ti-square-rounded-plus me-1"></i>Ajouter un employé</a>
            </div>
        </div>
    </div>
    <!-- /Welcome Wrap -->

    <div class="row">

        <!-- Widget Info -->
        <div class="col-xxl-8 d-flex">
            <div class="row flex-fill">
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-primary mb-2">
                                <i class="ti ti-calendar-share fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Total des équipes</h6>
                            <h3 class="mb-3"> {{ $totalEquipes }}</h3>
                            <a href="attendance-employee.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-secondary mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Offres dispo</h6>
                            <h3 class="mb-3"> {{ $offresEmploiActives }} </h3>
                            <a href="projects.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-info mb-2">
                                <i class="ti ti-users-group fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Total employés</h6>
                            <h3 class="mb-3"> {{ $totalEmployes }} </h3>
                            <a href="clients.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-pink mb-2">
                                <i class="ti ti-checklist fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Total des taches</h6>
                            <h3 class="mb-3">0 <span class="fs-12 fw-medium text-success"><i
                                        class="fa-solid fa-caret-down me-1"></i>+11.2%</span></h3>
                            <a href="tasks.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-secondary mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Candidatures ce mois</h6>
                            <h3 class="mb-3"> {{ $candidaturesCeMois }} </h3>
                            <a href="projects.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-secondary mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Candidatures en Attente</h6>
                            <h3 class="mb-3"> {{ $candidaturesEnAttente }} </h3>
                            <a href="projects.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-secondary mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Candidatures approuvées</h6>
                            <h3 class="mb-3"> {{ $candidaturesApprouvees }} </h3>
                            <a href="projects.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-secondary mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Candidatures rejetées</h6>
                            <h3 class="mb-3"> {{ $candidaturesRejetees }} </h3>
                            <a href="projects.html" class="link-default">Voir tout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widget Info -->

<!-- Employees By Department -->
<div class="col-xxl-4 d-flex">
    <div class="card flex-fill">
        <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
            <h5 class="mb-2">Répartition des employés par équipe</h5>
            <div class="dropdown mb-2">
                <a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center"
                    data-bs-toggle="dropdown">
                    <i class="ti ti-calendar me-1"></i> Cette semaine
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1">Ce mois</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1">Cette semaine</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1">La semaine dernière</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div id="emp-departmente" style="min-height: 300px;"></div>
            <p class="fs-13 mt-3 text-center">
                <i class="ti ti-circle-filled me-2 fs-8 text-primary"></i>
                Répartition actuelle des employés par équipe
            </p>
        </div>
    </div>
</div>
<!-- /Employees By Department -->

    </div>

    <div class="row">

        <!-- Total Employee -->
        {{-- <div class="col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Statut des employés</h5>
                    <div class="dropdown mb-2">
                        <a href="javascript:void(0);" class="btn btn-white border btn-sm d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-calendar me-1"></i>Cette semaine
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Ce mois</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Cette semaine</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Aujourd'hui</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <p class="fs-13 mb-3">Total des Employés</p>
                        <h3 class="mb-3">154</h3>
                    </div>
                    <div class="progress-stacked emp-stack mb-3">
                        <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15"
                            aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <div class="progress-bar bg-warning"></div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30"
                            aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                            <div class="progress-bar bg-secondary"></div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Segment three" aria-valuenow="20"
                            aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                            <div class="progress-bar bg-danger"></div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Segment four" aria-valuenow="20"
                            aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                            <div class="progress-bar bg-pink"></div>
                        </div>
                    </div>
                    <div class="border mb-3">
                        <div class="row gx-0">
                            <div class="col-6">
                                <div class="p-2 flex-fill border-end border-bottom">
                                    <p class="fs-13 mb-2"><i
                                            class="ti ti-square-filled text-primary fs-12 me-2"></i>Fulltime <span
                                            class="text-gray-9">(48%)</span></p>
                                    <h2 class="display-1">112</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 flex-fill border-bottom text-end">
                                    <p class="fs-13 mb-2"><i
                                            class="ti ti-square-filled me-2 text-secondary fs-12"></i>Contract <span
                                            class="text-gray-9">(20%)</span></p>
                                    <h2 class="display-1">112</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 flex-fill border-end">
                                    <p class="fs-13 mb-2"><i
                                            class="ti ti-square-filled me-2 text-danger fs-12"></i>Probation <span
                                            class="text-gray-9">(22%)</span></p>
                                    <h2 class="display-1">12</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 flex-fill text-end">
                                    <p class="fs-13 mb-2"><i class="ti ti-square-filled text-pink me-2 fs-12"></i>WFH
                                        <span class="text-gray-9">(20%)</span></p>
                                    <h2 class="display-1">04</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="mb-2">Top Performer</h6>
                    <div
                        class="p-2 d-flex align-items-center justify-content-between border border-primary bg-primary-100 br-5 mb-4">
                        <div class="d-flex align-items-center overflow-hidden">
                            <span class="me-2">
                                <i class="ti ti-award-filled text-primary fs-24"></i>
                            </span>
                            <a href="employee-details.html" class="avatar avatar-md me-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </a>
                            <div>
                                <h6 class="text-truncate mb-1 fs-14 fw-medium"><a href="employee-details.html">Daniel
                                        Esbella</a></h6>
                                <p class="fs-13">IOS Developer</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="fs-13 mb-1">Performance</p>
                            <h5 class="text-primary">99%</h5>
                        </div>
                    </div>
                    <a href="employees.html" class="btn btn-light btn-md w-100">Afficher tous les employés</a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <!-- Jobs Applicants -->
        {{-- <div class="col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Postulants de travail</h5>
                    <a href="job-list.html" class="btn btn-light btn-md mb-2">Voir tout</a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs tab-style-1 nav-justified d-sm-flex d-block p-0 mb-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fw-medium" data-bs-toggle="tab" data-bs-target="#openings"
                                aria-current="page" href="#openings" aria-selected="true" role="tab">Postes
                                ouverts</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fw-medium active" data-bs-toggle="tab" data-bs-target="#applicants"
                                href="#applicants" aria-selected="false" tabindex="-1" role="tab">Postulants</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="openings">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <a href="#" class="avatar overflow-hidden flex-shrink-0 bg-gray-100">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </a>
                                    <div class="ms-2 overflow-hidden">
                                        <p class="text-dark fw-medium text-truncate mb-0"><a
                                                href="javascript:void(0);">Senior IOS Developer</a></p>
                                        <span class="fs-12">No of Openings : 25 </span>
                                    </div>
                                </div>
                                <a href="javascript:void(0);"
                                    class="btn btn-light btn-sm p-0 btn-icon d-flex align-items-center justify-content-center"><i
                                        class="ti ti-edit"></i></a>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="applicants">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <a href="#" class="avatar overflow-hidden flex-shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </a>
                                    <div class="ms-2 overflow-hidden">
                                        <p class="text-dark fw-medium text-truncate mb-0"><a href="#">Brian
                                                Villalobos</a></p>
                                        <span class="fs-13 d-inline-flex align-items-center">Exp : 5+ Years<i
                                                class="ti ti-circle-filled fs-4 mx-2 text-primary"></i>USA</span>
                                    </div>
                                </div>
                                <span class="badge badge-secondary badge-xs">UI/UX Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Jobs Applicants -->

        <!-- Employees -->
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Employés</h5>
                    <a href="employees.html" class="btn btn-light btn-md mb-2">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Departement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employesRecents as $employe)
                                                                    <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar">
                                                {{ strtoupper(substr($employe->name, 0, 1)) }}
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="fw-medium"><a href="javascript:void(0);">{{$employe->name}}</a></h6>
                                                <span class="fs-12">{{$employe->email}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($employe->teams->isNotEmpty())
                                            <span class="badge badge-success-transparent badge-xs">
                                                {{ $employe->teams->first()->name }}
                                            </span>
                                            @elseif($employe->role=='rh' || $employe->role=='admin')
                                        <span class="badge badge-secondary-transparent badge-xs">
                                            Non applicable
                                        </span>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Employees -->

        <!-- Todo -->
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">A faire</h5>
                    <div class="d-flex align-items-center">
                        <div class="dropdown mb-2 me-2">
                            <a href="javascript:void(0);"
                                class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-calendar me-1"></i>Aujourd'hui
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                                </li>
                            </ul>
                        </div>
                        <a href="#"
                            class="btn btn-primary btn-icon btn-xs rounded-circle d-flex align-items-center justify-content-center p-0 mb-2"
                            data-bs-toggle="modal" data-bs-target="#add_todo"><i class="ti ti-plus fs-16"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
                        <i class="ti ti-grid-dots me-2"></i>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="todo1">
                            <label class="form-check-label fw-medium" for="todo1">Add Holidays</label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center todo-item border p-2 br-5 mb-2">
                        <i class="ti ti-grid-dots me-2"></i>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="todo2">
                            <label class="form-check-label fw-medium" for="todo2">Add Meeting to Client</label>
                        </div>
                    </div> --}}
                    <div class="d-flex justify-content-center align-items-center" style="height: 100px;">
                        <span class="fw-bold fs-20 text-muted">En cours de développement</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Todo -->

    </div>

    <div class="row">

        <!-- Projects -->
        {{-- <div class="col-xxl-8 col-xl-7 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Projects</h5>
                    <div class="d-flex align-items-center">
                        <div class="dropdown mb-2">
                            <a href="javascript:void(0);"
                                class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-calendar me-1"></i>This Week
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Team</th>
                                    <th>Hours</th>
                                    <th>Deadline</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="project-details.html" class="link-default">PRO-001</a></td>
                                    <td>
                                        <h6 class="fw-medium"><a href="project-details.html">Office Management App</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <div class="avatar-list-stacked avatar-group-sm">
                                            <span class="avatar avatar-rounded">
                                                <img class="border border-white" src="assets/img/profiles/avatar-02.jpg"
                                                    alt="img">
                                            </span>
                                            <span class="avatar avatar-rounded">
                                                <img class="border border-white" src="assets/img/profiles/avatar-03.jpg"
                                                    alt="img">
                                            </span>
                                            <span class="avatar avatar-rounded">
                                                <img class="border border-white" src="assets/img/profiles/avatar-05.jpg"
                                                    alt="img">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-1">15/255 Hrs</p>
                                        <div class="progress progress-xs w-100" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 40%"></div>
                                        </div>
                                    </td>
                                    <td>12 Sep 2024</td>
                                    <td>
                                        <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                            <i class="ti ti-point-filled me-1"></i>High
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="project-details.html" class="link-default">PRO-002</a></td>
                                    <td>
                                        <h6 class="fw-medium"><a href="project-details.html">Clinic Management </a></h6>
                                    </td>
                                    <td>
                                        <div class="avatar-list-stacked avatar-group-sm">
                                            <span class="avatar avatar-rounded">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                            <span class="avatar avatar-rounded">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                            <span class="avatar avatar-rounded">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                            <a class="avatar bg-primary avatar-rounded text-fixed-white fs-10 fw-medium"
                                                href="javascript:void(0);">
                                                +1
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-1">15/255 Hrs</p>
                                        <div class="progress progress-xs w-100" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 40%"></div>
                                        </div>
                                    </td>
                                    <td>24 Oct 2024</td>
                                    <td>
                                        <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                            <i class="ti ti-point-filled me-1"></i>Low
                                        </span>
                                    </td>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Projects -->

        <!-- Tasks Statistics -->
        {{-- <div class="col-xxl-4 col-xl-5 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Tasks Statistics</h5>
                    <div class="d-flex align-items-center">
                        <div class="dropdown mb-2">
                            <a href="javascript:void(0);"
                                class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-calendar me-1"></i>This Week
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">This Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chartjs-wrapper-demo position-relative mb-4">
                        <canvas id="mySemiDonutChart" height="190"></canvas>
                        <div class="position-absolute text-center attendance-canvas">
                            <p class="fs-13 mb-1">Total des Taches</p>
                            <h3>0</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="border-end text-center me-2 pe-2 mb-3">
                            <p class="fs-13 d-inline-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled fs-10 me-1 text-warning"></i>Ongoing</p>
                            <h5>24%</h5>
                        </div>
                        <div class="border-end text-center me-2 pe-2 mb-3">
                            <p class="fs-13 d-inline-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled fs-10 me-1 text-info"></i>On Hold </p>
                            <h5>10%</h5>
                        </div>
                        <div class="border-end text-center me-2 pe-2 mb-3">
                            <p class="fs-13 d-inline-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled fs-10 me-1 text-danger"></i>Overdue</p>
                            <h5>16%</h5>
                        </div>
                        <div class="text-center me-2 pe-2 mb-3">
                            <p class="fs-13 d-inline-flex align-items-center mb-1"><i
                                    class="ti ti-circle-filled fs-10 me-1 text-success"></i>Ongoing</p>
                            <h5>40%</h5>
                        </div>
                    </div>
                    <div class="bg-dark br-5 p-3 pb-0 d-flex align-items-center justify-content-between">
                        <div class="mb-2">
                            <h4 class="text-success">389/689 hrs</h4>
                            <p class="fs-13 mb-0">Spent on Overall Tasks This Week</p>
                        </div>
                        <a href="tasks.html" class="btn btn-sm btn-light mb-2 text-nowrap">View All</a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Tasks Statistics -->

    </div>

    <div class="row">

        <!-- Schedules -->
        {{-- <div class="col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <h5 class="mb-2">Schedules</h5>
                    <a href="candidates.html" class="btn btn-light btn-md mb-2">View All</a>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 br-5 mb-4">
                        <span class="badge badge-secondary badge-xs mb-1">UI/ UX Designer</span>
                        <h6 class="mb-2 text-truncate">Interview Candidates - UI/UX Designer</h6>
                        <div class="d-flex align-items-center flex-wrap">
                            <p class="fs-13 mb-1 me-2"><i class="ti ti-calendar-event me-2"></i>Thu, 15 Feb 2025</p>
                            <p class="fs-13 mb-1"><i class="ti ti-clock-hour-11 me-2"></i>01:00 PM - 02:20 PM</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-top mt-2 pt-3">
                            <div class="avatar-list-stacked avatar-group-sm">
                                <span class="avatar avatar-rounded">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="avatar avatar-rounded">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="avatar avatar-rounded">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="avatar avatar-rounded">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="avatar avatar-rounded">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <a class="avatar bg-primary avatar-rounded text-fixed-white fs-10 fw-medium"
                                    href="javascript:void(0);">
                                    +3
                                </a>
                            </div>
                            <a href="#" class="btn btn-primary btn-xs">Join Meeting</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Schedules -->

    </div>

    <!-- Add Todo -->
    <div class="modal fade" id="add_todoo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Todo</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="https://smarthr.co.in/demo/html/template/index.html">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Todo Title</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tag</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Internal</option>
                                        <option>Projects</option>
                                        <option>Meetings</option>
                                        <option>Reminder</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Medium</option>
                                        <option>High</option>
                                        <option>Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Descriptions</label>
                                    <div class="summernote"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Add Assignee</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Sophie</option>
                                        <option>Cameron</option>
                                        <option>Doris</option>
                                        <option>Rufana</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-0">
                                    <label class="form-label">Status</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Completed</option>
                                        <option>Pending</option>
                                        <option>Onhold</option>
                                        <option>Inprogress</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add New Todo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Todo -->

    <!-- Add Project -->
    <div class="modal fade" id="add_project" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header header-border align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h5 class="modal-title me-2">Add Project </h5>
                        <p class="text-dark">Project ID : PRO-0004</p>
                    </div>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="add-info-fieldset">
                    <div class="add-details-wizard p-3 pb-0">
                        <ul class="progress-bar-wizard d-flex align-items-center border-bottom">
                            <li class="active p-2 pt-0">
                                <h6 class="fw-medium">Basic Information</h6>
                            </li>
                            <li class="p-2 pt-0">
                                <h6 class="fw-medium">Members</h6>
                            </li>
                        </ul>
                    </div>
                    <fieldset id="first-field-file">
                        <form action="https://smarthr.co.in/demo/html/template/projects.html">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div
                                            class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                            <div
                                                class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                <i class="ti ti-photo text-gray-2 fs-16"></i>
                                            </div>
                                            <div class="profile-upload">
                                                <div class="mb-2">
                                                    <h6 class="mb-1">Upload Project Logo</h6>
                                                    <p class="fs-12">Image should be below 4 mb</p>
                                                </div>
                                                <div class="profile-uploader d-flex align-items-center">
                                                    <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                                        Upload
                                                        <input type="file" class="form-control image-sign"
                                                            multiple="">
                                                    </div>
                                                    <a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Project Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Client</label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>Anthony Lewis</option>
                                                <option>Brian Villalobos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <div class="input-icon-end position-relative">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="dd/mm/yyyy" value="02-05-2024">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-calendar text-gray-7"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <div class="input-icon-end position-relative">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="dd/mm/yyyy" value="02-05-2024">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-calendar text-gray-7"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Priority</label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>High</option>
                                                        <option>Medium</option>
                                                        <option>Low</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Project Value</label>
                                                    <input type="text" class="form-control" value="$">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Total Working Hours</label>
                                                    <div class="input-icon-end position-relative">
                                                        <input type="text" class="form-control timepicker"
                                                            placeholder="-- : -- : --" value="02-05-2024">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-clock-hour-3 text-gray-7"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Extra Time</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-0">
                                            <label class="form-label">Description</label>
                                            <div class="summernote"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn btn-outline-light border me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary wizard-next-btn" type="button">Add Team
                                        Member</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <fieldset>
                        <form action="https://smarthr.co.in/demo/html/template/projects.html">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label me-2">Team Members</label>
                                            <input class="input-tags form-control" placeholder="Add new" type="text"
                                                data-role="tagsinput" name="Label" value="Jerald,Andrew,Philip,Davis">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label me-2">Team Leader</label>
                                            <input class="input-tags form-control" placeholder="Add new" type="text"
                                                data-role="tagsinput" name="Label" value="Hendry,James">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label me-2">Project Manager</label>
                                            <input class="input-tags form-control" placeholder="Add new" type="text"
                                                data-role="tagsinput" name="Label" value="Dwight">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label class="form-label">Tags</label>
                                            <select class="select">
                                                <option>Select</option>
                                                <option>High</option>
                                                <option>Low</option>
                                                <option>Medium</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn btn-outline-light border me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#success_modal">Save</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Project -->

    <!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($employesParEquipe);

        // Si aucune équipe, éviter les erreurs
        if (!chartData.length) {
            document.querySelector("#emp-departmente").innerHTML =
                '<div class="text-center text-muted mt-4">Aucune équipe enregistrée pour le moment.</div>';
            return;
        }

        const options = {
            chart: {
                type: 'donut',
                height: 300,
            },
            series: chartData.map(equipe => equipe.users_count),
            labels: chartData.map(equipe => equipe.name),
            colors: ['#df5408', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#8e44ad', '#2ecc71', '#3498db'],
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    const total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                    const count = opts.w.config.series[opts.seriesIndex];
                    return `${count} (${val.toFixed(1)}%)`;
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: { height: 250 },
                    legend: { position: 'bottom' }
                }
            }],
            tooltip: {
                y: {
                    formatter: val => `${val} employé${val > 1 ? 's' : ''}`
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#emp-departmente"), options);
        chart.render();
    });
</script>

@endsection
