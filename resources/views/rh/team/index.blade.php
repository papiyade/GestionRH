@extends('layout.admin_rh')

@section('title', 'RH - Gestion des équipes')
@section('page-title', 'Liste des équipes')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-border-left alert-dismissible fade show material-shadow" role="alert">
    <i class="ti ti-check me-3 align-middle"></i>
    <strong>Succès</strong> - {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
@endif

<!-- Page Header -->
<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 mb-4">
    <div class="flex-grow-1">
        <h4 class="fw-bold text-dark mb-1">Équipes</h4>
        <p class="text-muted mb-0">Gérez et suivez vos équipes en temps réel</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeamModal" style="background: linear-gradient(135deg, #9370db, #8a2be2); border: none;">
            <i class="ti ti-circle-plus me-1"></i>Nouvelle équipe
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h6 class="card-title mb-0"><i class="ti ti-table me-2"></i>Liste complète</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="teamsTable" class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="px-3 py-3">Nom</th>
                        <th class="px-3 py-3">Description</th>
                        <th class="px-3 py-3">Membres</th>
                        <th class="px-3 py-3">Créée le</th>
                        <th class="px-3 py-3">Dernière modification</th>
                        <th class="px-3 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teams as $team)
                    <tr>
                        <td class="px-3">{{ $team->name }}</td>
                        <td class="px-3">{{ $team->description ?? '-' }}</td>
                        <td class="px-3">
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class="ti ti-users me-1"></i>{{ $team->members->count() }} membres
                            </span>
                        </td>
                        <td class="px-3">{{ $team->created_at->format('d M Y') }}</td>
                        <td class="px-3">{{ $team->updated_at->diffForHumans() }}</td>
                        <td class="px-3 text-center">
                            <div class="btn-group">
                                <a href="{{ route('teams.show',$team->id) }}" class="btn btn-sm btn-outline-info"><i class="ti ti-eye"></i></a>
                                <a href="" class="btn btn-sm btn-outline-warning"><i class="ti ti-edit"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteTeamModal" 
                                        data-id="{{ $team->id }}" 
                                        data-name="{{ $team->name }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($teams->isEmpty())
            <div class="text-center py-5">
                <div class="empty-state">
                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:100px;height:100px"></lord-icon>
                    <h5 class="mt-3 mb-2">Aucune équipe trouvée</h5>
                    <p class="text-muted mb-4">Il semble qu'aucune équipe ne corresponde à vos critères.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeamModal"><i class="ti ti-circle-plus me-1"></i>Créer la première équipe</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

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
                        <input type="text" class="form-control" name="name" id="name" placeholder="Entrez le nom de l'équipe" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Décrivez le rôle de l'équipe"></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
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
deleteTeamModal.addEventListener('show.bs.modal', function (event) {
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
        columnDefs: [{ orderable: false, targets: [5] }],
        language: { search: "_INPUT_", searchPlaceholder: "Rechercher..." }
    });
});
</script>
@endpush

@endsection
