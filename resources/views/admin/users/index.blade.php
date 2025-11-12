@extends('layout.admin')
@section('title', 'Liste employe')
@section('page-title', 'admin')

@section('content')
@if(session('success'))
<!-- Success Alert -->
<div class="alert alert-success alert-border-left alert-dismissible fade show material-shadow" role="alert">
    <i class="ri-notification-off-line me-3 align-middle"></i> <strong>Succès</strong> - {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
@endif

    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Liste des employés</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        RH
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des employés</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            <div class="mb-2">
                <a href="{{ route('employe.create') }}"
                    class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Nouvel
                    employé</a>
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
    <!-- Performance Indicator list -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <h5>Liste des employés</h5>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">

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
                            <th>Employé</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Equipe</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employes as $employe)
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md avatar-rounded">
                                            <span
                                                class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($employe->name, 0, 1)) }}
                                            </span>
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">{{ $employe->name }}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark mb-1">{{ $employe->email }}</div>
                                    <small class="text-muted"><i
                                            class="ti ti-phone me-1"></i>{{ $employe->telephone ?? 'Non renseigné' }}</small>
                                </td>
                                <td>
                                    @if ($employe->role === 'Admin')
                                        <span class="badge bg-danger-transparent text-danger rounded-pill px-3 py-2"><i
                                                class="ti ti-shield me-1"></i>{{ $employe->role }}</span>
                                    @elseif($employe->role === 'RH')
                                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2"><i
                                                class="ti ti-user-cog me-1"></i>{{ $employe->role }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2"><i
                                                class="ti ti-user me-1"></i>{{ $employe->role ?? 'Employé' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($employe->teams->isNotEmpty())
                                        <span
                                            class=" badge badge-md p-2 fs-10 badge-pink-transparent">{{ $employe->teams->first()->name }}</span>
                                    @else
                                        <span class=" badge badge-md p-2 fs-10 badge-secondary-transparent">Non
                                            applicable</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <a href="{{ route('employe.show', $employe->id) }}" class="me-2"><i
                                                class="ti ti-eye"></i></a>
                                        <a href="#" class="me-2 edit-user-btn" data-bs-toggle="modal"
                                            data-bs-target="#edit_user" data-id="{{ $employe->id }}"
                                            data-name="{{ $employe->name }}" data-email="{{ $employe->email }}"
                                            data-telephone="{{ $employe->telephone }}" data-role="{{ $employe->role }}">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <a href="javascript:void(0);" class="delete-user-btn" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $employe->id }}"
                                            data-name="{{ $employe->name }}">
                                            <i class="ti ti-trash"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @if ($employes->isEmpty())
            <div class="text-center p-4">
                <h5 class="mb-1">Aucun employé trouvé</h5>
                <p class="mb-0">Il n'y a actuellement aucun employé dans la liste.</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#add_users">
                    <i class="ti ti-user-plus me-1"></i> Ajouter un employé
                </button>
            </div>
        @endif
    </div>
    <!-- /Performance Indicator list -->

    <div class="modal fade" id="edit_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Éditer l'employé</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <!-- Formulaire -->
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" class="form-control" name="name" id="edit_name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="edit_email" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" class="form-control" name="telephone" id="edit_telephone">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rôle</label>
                                <select class="form-control" name="role" id="edit_role" required>
                                    <option value="admin">Admin</option>
                                    <option value="employe">Employé</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
