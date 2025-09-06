@extends('layout.admin_rh')

@section('title', 'Tableau de Bord RH')
@section('page-title', 'Liste Employés')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-border-left alert-dismissible fade show material-shadow" role="alert">
    <i class="ti ti-check me-3 align-middle"></i>
    <strong>Succès</strong> - {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
@endif

<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3 mb-4">
            <div class="flex-grow-1">
                <h4 class="fw-bold text-dark mb-1">Liste des employés</h4>
                <p class="text-muted mb-0">Gérez et suivez vos employés en temps réel</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('rh.export.personnel.registry') }}" class="btn btn-outline-info">
                    <i class="ti ti-download me-1"></i>Télécharger
                </a>
                <a href="{{ route('rh.users.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #9370db, #8a2be2); border: none;">
                    <i class="ti ti-circle-plus me-1"></i>Nouvel employé
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="card-title mb-0"><i class="ti ti-table me-2"></i>Liste complète</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="px-3 py-3"><input class="form-check-input" type="checkbox" id="selectAll"></th>
                                <th class="px-3 py-3">Employé</th>
                                <th class="px-3 py-3">Contact</th>
                                <th class="px-3 py-3">Rôle</th>
                                <th class="px-3 py-3">Équipe</th>
                                <th class="px-3 py-3">Statut</th>
                                <th class="px-3 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="px-3"><input class="form-check-input row-checkbox" type="checkbox" value="{{ $user->id }}"></td>
                                <td class="px-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-medium">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: #{{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3">
                                    <div class="text-dark mb-1">{{ $user->email }}</div>
                                    <small class="text-muted"><i class="ti ti-phone me-1"></i>{{ $user->telephone ?? 'Non renseigné' }}</small>
                                </td>
                                <td class="px-3">
                                    @if($user->role === 'Admin')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2"><i class="ti ti-shield me-1"></i>{{ $user->role }}</span>
                                    @elseif($user->role === 'RH')
                                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2"><i class="ti ti-user-cog me-1"></i>{{ $user->role }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2"><i class="ti ti-user me-1"></i>{{ $user->role ?? 'Employé' }}</span>
                                    @endif
                                </td>
                                <td class="px-3">
                                    @if ($user->teams->isNotEmpty())
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2"><i class="ti ti-users me-1"></i>{{ $user->teams->first()->name }}</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2"><i class="ti ti-user-x me-1"></i>Non assigné</span>
                                    @endif
                                </td>
                                <td class="px-3">
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2"><i class="ti ti-circle-check me-1"></i>Actif</span>
                                </td>
                                <td class="px-3 text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('employe.show', $user->id) }}" class="btn btn-sm btn-outline-info"><i class="ti ti-eye"></i></a>
                                        <a href="{{ route('rh.editUsers', $user->id) }}" class="btn btn-sm btn-outline-warning"><i class="ti ti-edit"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-id="{{ $user->id }}" 
                                            data-name="{{ $user->name }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($users->isEmpty())
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:100px;height:100px"></lord-icon>
                            <h5 class="mt-3 mb-2">Aucun employé trouvé</h5>
                            <p class="text-muted mb-4">Il semble qu'aucun employé ne corresponde à vos critères de recherche.</p>
                            <a href="{{ route('rh.users.create') }}" class="btn btn-primary"><i class="ti ti-circle-plus me-1"></i>Ajouter le premier employé</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal suppression Bootstrap -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            Voulez-vous vraiment supprimer <strong id="employeeName"></strong> ?
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
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var name = button.getAttribute('data-name');
    
    var modalTitle = deleteModal.querySelector('#employeeName');
    modalTitle.textContent = name;
    
    var form = deleteModal.querySelector('#deleteForm');
    form.action = '/employes/' + id;
});
</script>
@endpush
@endsection
