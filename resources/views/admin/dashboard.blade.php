@extends('layout.admin')
@section('title', 'Tableau de Bord Admin')
@section('page-title', 'admin')



@section('content')
    @if (session('first_time_login'))
        <div class="alert alert-info alert-border-left alert-dismissible fade show material-shadow" role="alert">
            <i class="ri-notification-off-line me-3 align-middle"></i>
            <strong>Bienvenue !</strong> C’est votre première connexion.<br>
            <ul class="mt-2 mb-0">
                <li>
                    🔐 <strong><a href="#" class="text-decoration-underline text-info">Changez votre mot de
                            passe</a></strong> — c’est important pour votre sécurité.
                </li>
                <li>
                    🏢 <strong><a href="{{ route('company') }}" class="text-decoration-underline text-info">Configurez votre
                            entreprise</a></strong> — pour commencer à l’utiliser pleinement.
                </li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-info alert-border-left alert-dismissible fade show material-shadow" role="alert">
            <i class="ri-notification-off-line me-3 align-middle"></i>
            {{ session('success') }}
            <ul class="mt-2 mb-0">
                <li>
                    🏢 <strong><a href="#" class="text-decoration-underline text-info">Ajoutez votre
                            équipe</a></strong>
                </li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif


    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Dashboard Admin</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        Admin
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tableau de Bord</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            <div class="mb-2">

            </div>
            <div class="head-icons ms-2">
                <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Collapse" id="collapse-header">
                    <i class="ti ti-chevrons-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    <div class="row">
        <div class="col-xl-12 d-flex">
            <div class="row flex-fill">

                <!-- Total Companies -->
                <div class="col-lg-6 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="overflow-hidden d-flex mb-2 align-items-center">
                                <span class="me-2"><img
                                        src="https://smarthr.co.in/demo/html/template/assets/img/reports-img/employee-report-icon.svg"
                                        alt="Img" class="img-fluid"></span>
                                <div>
                                    <p class="fs-14 fw-normal mb-1 text-truncate">Total Employés</p>
                                    <h5>{{ $usersCount }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Total Companies -->

                <!-- Total Companies -->
                <div class="col-lg-6 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="overflow-hidden d-flex mb-2 align-items-center">
                                <span class="me-2"><img
                                        src="https://smarthr.co.in/demo/html/template/assets/img/reports-img/employee-report-success.svg"
                                        alt="Img" class="img-fluid"></span>
                                <div>
                                    <p class="fs-14 fw-normal mb-1 text-truncate">Nombre de RH de l'entreprise</p>
                                    <h5>{{ $rhCount }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Total Companies -->

                <!-- Inactive Companies -->
                <div class="col-lg-6 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="overflow-hidden d-flex mb-2 align-items-center">
                                <span class="me-2"><img
                                        src="https://smarthr.co.in/demo/html/template/assets/img/reports-img/employee-report-info.svg"
                                        alt="Img" class="img-fluid"></span>
                                <div>
                                    <p class="fs-14 fw-normal mb-1 text-truncate">Total Admins</p>
                                    <h5>{{ $adminCount }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Inactive Companies -->

                <!-- Company Location -->
                <div class="col-lg-6 col-md-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="overflow-hidden d-flex mb-2 align-items-center">
                                <span class="me-2"><img
                                        src="https://smarthr.co.in/demo/html/template/assets/img/reports-img/employee-report-danger.svg"
                                        alt="Img" class="img-fluid"></span>
                                <div>
                                    <p class="fs-14 fw-normal mb-1 text-truncate">Total Chefs de projets</p>
                                    <h5>{{$chefProjetCount}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Company Location -->
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <h5>Liste des employés </h5>
        </div>
        <div class="card-body p-0">
            <div class="custom-datatable-filter table-responsive">
                <table class="table datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>Emp ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Département/Team</th>
                            <th>Télephone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><a href="https://smarthr.co.in/demo/html/template/employee-details.html"
                                        class="link-default">Emp-00{{ $user->id }}</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <p class="text-dark mb-0"><a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#view_details">{{ $user->name }}</a></p>
                                            <span class="fs-12">
                                                @if ($user->teams->isNotEmpty())
                                                    {{ optional($user->teams->first())->name ?? 'Non assigné' }}
                                                @else
                                                    Non assigné
                                                @endif

                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</a></td>
                                <td>
                                    @if ($user->teams->isNotEmpty())
                                        {{ optional($user->teams->first())->name ?? 'Non assigné' }}
                                    @else
                                        Non assigné
                                    @endif

                                </td>
                                <td>{{ $user->telephone ?? 'Non renseigné' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
