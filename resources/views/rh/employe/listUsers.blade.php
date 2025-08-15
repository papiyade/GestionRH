@extends('layout.admin_rh')

@section('title', 'Tableau de Bord RH')
@section('page-title', 'Liste employe')

@section('content')
@if(session('success'))
<!-- Success Alert -->
<div class="alert alert-success alert-border-left alert-dismissible fade show material-shadow" role="alert">
    <i class="ri-notification-off-line me-3 align-middle"></i> <strong>Succès</strong> - {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Liste des employes</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('rh.users.create') }}"  class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Nouveau Employe</a>
                                {{-- <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button> --}}
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Rechercher...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="customer_name">Nom</th>
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="phone">Télephone</th>
                                    <th class="sort" data-sort="address">Role</th>
                                    <th class="sort" data-sort="status">Team</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
                                    <td class="customer_name">{{ $user->name }}</td>
                                    <td class="email">{{ $user->email }}</td>
                                    <td class="phone">{{ $user->telephone ?? 'N/A' }}</td>
                                    <td class="address">{{ $user->role ?? 'N/A' }}</td>
                                    <td class="status">
                                        @if ($user->teams->isNotEmpty())
                                            <span class="badge bg-success-subtle text-success text-uppercase">
                                                {{ $user->teams->first()->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Non assigné</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="edit">
                                                <a class="btn btn-sm btn-success edit-item-btn" href="{{ route('employe.show', $user->id) }}">Voir</a>
                                            </div>
                                            <div class="remove">
                                                <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Supprimer</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Désolé! Aucun résultat trouvé</h5>
                                <p class="text-muted mb-0">Nous avons recherché plus de{{ $users->count() }}+ utilisateurs et Nous n’avons trouvé aucun utilisateur pour votre recherche.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                Précedent
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="javascript:void(0);">
                                Suivant
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->

    </div>
    <!-- end col -->

</div>



<script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
<script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<!-- listjs init -->
<script src="{{ asset('assets/js/pages/listjs.init.js') }}"></script>

@endsection
