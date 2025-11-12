@extends('layout.superadmin')

@section('title', 'Tableau de Bord SuperAdmin')
@section('page-title', 'Liste des Admins Entreprise')

@section('content')
    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">entreprises</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        Superadmin
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des entreprises</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            <div class="me-2 mb-2">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="ti ti-file-export me-1"></i>Exporter
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end p-3">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                    class="ti ti-file-type-pdf me-1"></i>Exporter vers PDF</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                    class="ti ti-file-type-xls me-1"></i>Exporter vers Excel </a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <div class="mb-2">
							<a href="#" data-bs-toggle="modal" data-bs-target="#add_company" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Company</a>
						</div> --}}
            <div class="ms-2 head-icons">
                <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Collapse" id="collapse-header">
                    <i class="ti ti-chevrons-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="row">

        <!-- Total Companies -->
        <div class="col-lg-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center overflow-hidden">
                        <span class="avatar avatar-lg bg-primary flex-shrink-0">
                            <i class="ti ti-building fs-16"></i>
                        </span>
                        <div class="ms-2 overflow-hidden">
                            <p class="fs-12 fw-medium mb-1 text-truncate">Total Entreprises</p>
                            <h4>{{ \App\Models\Entreprise::count() }}</h4>
                        </div>
                    </div>
                    <div id="total-chart"></div>
                </div>
            </div>
        </div>
        <!-- /Total Companies -->

        <!-- Total Companies -->
        <div class="col-lg-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center overflow-hidden">
                        <span class="avatar avatar-lg bg-success flex-shrink-0">
                            <i class="ti ti-building fs-16"></i>
                        </span>
                        <div class="ms-2 overflow-hidden">
                            <p class="fs-12 fw-medium mb-1 text-truncate">Entreprises actives</p>
                            <h4>{{ \App\Models\Entreprise::where('is_actif', 1)->count() }}</h4>
                        </div>
                    </div>
                    <div id="active-chart"></div>
                </div>
            </div>
        </div>
        <!-- /Total Companies -->

        <!-- Inactive Companies -->
        <div class="col-lg-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center overflow-hidden">
                        <span class="avatar avatar-lg bg-danger flex-shrink-0">
                            <i class="ti ti-building fs-16"></i>
                        </span>
                        <div class="ms-2 overflow-hidden">
                            <p class="fs-12 fw-medium mb-1 text-truncate">Entreprises inactives</p>
                            <h4>{{ \App\Models\Entreprise::where('is_actif', 0)->count() }}</h4>
                        </div>
                    </div>
                    <div id="inactive-chart"></div>
                </div>
            </div>
        </div>
        <!-- /Inactive Companies -->


    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <h5>Liste des entreprises</h5>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                <div class="me-3">
                    <div class="input-icon-end position-relative">
                        <input type="text" class="form-control date-range bookingrange"
                            placeholder="dd/mm/yyyy - dd/mm/yyyy">
                        <span class="input-icon-addon">
                            <i class="ti ti-chevron-down"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="custom-datatable-filter table-responsive">
                <table class="table datatable">
                    <thead class="thead-light">
                        <tr>
                            <th class="no-sort">
                                <div class="form-check form-check-md">
                                    <input class="form-check-input" type="checkbox" id="select-all">
                                </div>
                            </th>
                            <th>Nom de l'entreprise</th>
                            <th>Email</th>
                            <th>Créée le</th>
                            <th>Statut</th>
                            <th class="no-sort">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entreprises as $entreprise)
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md border rounded-circle">
                                            <img src="{{asset('assets/img/company/company-01.svg')}}"
                                                class="img-fluid" alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">{{ $entreprise->entreprise_name }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $entreprise->email }}</td>
                                <td>{{ $entreprise->created_at->format('d M Y') }}</td>
                                <td>
                                    @if ($entreprise->is_actif)
                                        <span class="badge badge-success"><i class="ti ti-point-filled me-1"></i>
                                            Active</span>
                                    @else
                                        <span class="badge badge-primary"><i class="ti ti-point-filled me-1"></i>
                                            Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <!-- Bouton Voir -->
                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                            data-bs-target="#company_detail_{{ $entreprise->id }}">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal spécifique à cette entreprise -->
                            <div class="modal fade" id="company_detail_{{ $entreprise->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Détails de {{ $entreprise->entreprise_name }}</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-3">
                                            <div
                                                class="d-flex justify-content-between align-items-center rounded bg-light p-3">
                                                <div class="file-name-icon d-flex align-items-center">
                                                    <a href="#" class="avatar avatar-md border rounded-circle me-2">
                                                        <img src="{{asset('assets/img/company/company-01.svg')}}"
                                                            class="img-fluid" alt="img">
                                                    </a>
                                                    <div>
                                                        <p class="fw-medium mb-0">{{ $entreprise->entreprise_name }}</p>
                                                        <p><a
                                                                href="mailto:{{ $entreprise->email }}">{{ $entreprise->email }}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                                @if ($entreprise->is_actif)
                                                    <span class="badge badge-success"><i class="ti ti-point-filled"></i>
                                                        Active</span>
                                                @else
                                                    <span class="badge badge-primary"><i class="ti ti-point-filled"></i>
                                                        Inactive</span>
                                                @endif
                                            </div>

                                            <div class="mt-4">
                                                <p class="fw-medium">Information Basique</p>
                                                <div class="row">
                                                    <div class="col-md-4"><strong>Créée le :</strong>
                                                        {{ $entreprise->created_at->format('d M Y') }}</div>
                                                    <div class="col-md-4"><strong>Téléphone :</strong>
                                                        {{ $entreprise->phone ?? 'N/A' }}</div>
                                                    <div class="col-md-4"><strong>Adresse :</strong>
                                                        {{ $entreprise->adresse ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
