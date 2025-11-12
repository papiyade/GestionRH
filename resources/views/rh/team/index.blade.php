@extends('layout.admin_rh')

@section('title', 'RH - Gestion des équipes')
@section('page-title', 'Liste des équipes')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-border-left alert-dismissible fade show material-shadow" role="alert">
            <i class="ti ti-check me-3 align-middle"></i>
            <strong>Succès</strong> - {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Equipes</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        RH
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des équipes</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            <div class="me-2 mb-2">
                <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                    <a href="https://smarthr.co.in/demo/html/template/companies-crm.html"
                        class="btn btn-icon btn-sm me-1"><i class="ti ti-list-tree"></i></a>
                    <a href="https://smarthr.co.in/demo/html/template/companies-grid.html"
                        class="btn btn-icon btn-sm active bg-primary text-white"><i class="ti ti-layout-grid"></i></a>
                </div>
            </div>
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
            <div class="mb-2">
                <button href="#" data-bs-toggle="modal" data-bs-target="#createTeamModal"
                    class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter une
                    équipe</button>
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

    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5>Equipes </h5>
                <div class="dropdown">
                    <a href="javascript:void(0);"
                        class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        Trier par
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end p-3">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Recently Added</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Desending</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Last Month</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Last 7 Days</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if ($teams->isEmpty())
            <div class="text-center py-5">
                <div class="empty-state">
                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                        colors="primary:#121331,secondary:#08a88a" style="width:100px;height:100px"></lord-icon>
                    <h5 class="mt-3 mb-2">Aucune équipe trouvée</h5>
                    <p class="text-muted mb-4">Créez des équipes pour pouvoir les manipuler</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeamModal"><i
                            class="ti ti-circle-plus me-1"></i>Créer la première équipe</button>
                </div>
            </div>
        @endif
        @foreach ($teams as $team)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox">
                            </div>
                            <div>
                                <a href="{{ route('teams.show', $team->id) }}"
                                    class="avatar avatar-xl avatar-rounded online border rounded-circle">
                                    <img src="{{ asset('assets/img/company/company-12.svg') }}"
                                        class="img-fluid h-auto w-auto" alt="img">
                                </a>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li>
                                        <a class="dropdown-item rounded-1" href="{{ route('teams.show', $team->id) }}"><i
                                                class="ti ti-edit me-1"></i>Voir</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-1" href="javascript:void(0);"
                                            data-bs-toggle="modal" data-bs-target="#deleteTeamModal"
                                            data-id="{{ $team->id }}" data-name="{{ $team->name }}"><i
                                                class="ti ti-trash me-1"></i>Supprimer</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <h6 class="mb-1"><a href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a></h6>
                            <div class="avatar-list-stacked avatar-group-sm mb-2">
                                @php
                                    $members = $team->members->take(5);
                                    $remaining = $team->members->count() - 5;
                                @endphp
                                @foreach ($members as $member)
                                    <span class="avatar avatar-md rounded-circle bg-primary" title="{{ $member->name }}">
                                        @php
                                            $initials = collect(explode(' ', $member->name))
                                                ->map(fn($word) => mb_substr($word, 0, 1))
                                                ->join('');
                                        @endphp
                                        <span class="avatar-initials">{{ strtoupper($initials) }}</span>
                                    </span>
                                @endforeach
                                @if ($remaining > 0)
                                    <span class="avatar avatar-xs rounded-circle"
                                        style="background: orange; color: #fff; display: inline-flex; align-items: center; justify-content: center;"
                                        title="+{{ $remaining }}">
                                        +{{ $remaining }}
                                    </span>
                                @endif
                            </div>
                            <div class="avatar-list-stacked avatar-group-sm">
                                Créé par {{ $team->owner->name }}
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-column align-items-center">
                                <p class="text-dark d-inline-flex align-items-center mb-2">
                                    <i class="ti ti-users text-gray-5 me-2"></i>
                                    <a class="text-center">{{ $team->members->count() }} membre(s)</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if ($teamCount > 6)
        <div class="text-center mb-4">
            <a href="#" class="btn btn-white border"><i class="ti ti-loader-3 text-primary me-2"></i>Afficher
                plus</a>
        </div>
    @endif


    <!-- Modal Create Team -->
    <div class="modal fade" id="createTeamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title">Nouvelle équipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('teams.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'équipe</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Entrez le nom de l'équipe" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"
                                placeholder="Décrivez le rôle de l'équipe"></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Team -->
    <div class="modal fade" id="deleteTeamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="deleteTeamForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation de suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer l'équipe <strong id="teamName"></strong> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            var deleteTeamModal = document.getElementById('deleteTeamModal');
            deleteTeamModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');

                var modalTitle = deleteTeamModal.querySelector('#teamName');
                modalTitle.textContent = name;

                var form = deleteTeamModal.querySelector('#deleteTeamForm');
                form.action = '/teams/' + id;
            });

            // Datatable init
            $(document).ready(function() {
                $('#teamsTable').DataTable({
                    responsive: true,
                    columnDefs: [{
                        orderable: false,
                        targets: [5]
                    }],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Rechercher..."
                    }
                });
            });
        </script>
    @endpush

@endsection
