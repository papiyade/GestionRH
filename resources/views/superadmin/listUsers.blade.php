@extends('layout.superadmin')

@section('title', 'Tableau de Bord SuperAdmin')
@section('page-title', 'Liste des Admins Entreprise')

@section('content')
@if(session('success'))
<!-- Success Alert -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Succès</strong> - {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
@endif

<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark">Liste des Admins Entreprise</h4>
                <a href="{{ route('add_admin_view') }}" class="btn btn-dark">
                    <i class="ri-add-line align-bottom me-1"></i> Nouvel Admin
                </a>
            </div>

            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Rechercher..." id="searchAdmin">
            </div>

            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                </div>
                            </th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Nom Entreprise</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr class="border-bottom">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->telephone ?? 'N/A' }}</td>
                            <td>{{ $admin->adresse ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($admin->entreprise_id)
                                    <a class="btn btn-sm btn-dark" href="{{ route('entreprise.show', $admin->entreprise_id) }}">Voir</a>
                                    @else
                                    <span class="text-muted">Aucune entreprise</span>
                                    @endif
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($admins->isEmpty())
                <div class="text-center text-muted py-5">
                    Aucun admin trouvé.
                </div>
                @endif
            </div>

            <div class="d-flex justify-content-end mt-4">
                <div class="pagination-wrap hstack gap-2">
                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Précédent</a>
                    <ul class="pagination listjs-pagination mb-0"></ul>
                    <a class="page-item pagination-next" href="javascript:void(0);">Suivant</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
<script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/listjs.init.js') }}"></script>
@endsection
