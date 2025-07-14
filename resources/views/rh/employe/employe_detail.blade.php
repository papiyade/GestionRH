@extends('layouts.admin_rh-dashboard')

@section('content')
<div class="row">
    <!-- SECTION 1: Employee Details -->
    <div class="col-lg-12">
        {{-- Message succès Détail RH --}}
        @if(session('success_detail'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_detail') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Détails RH - {{ $user->name }}</h4>
                @if(!$user->employeeDetail)
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#employeeDetailModal">
                        <i class="ri-add-line align-bottom me-1"></i> Ajouter
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered align-middle" id="employeeDetailsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Matricule</th>
                                <th>Date de naissance</th>
                                <th>Date début contrat</th>
                                <th>Date fin contrat</th>
                              {{-- <th>Téléphone</th> --}}
                                <th>Adresse</th>
                                <th>Type de contrat</th>
                                <th>Salaire</th>
                                <th>Description poste</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($user->employeeDetail)
                                <tr>
                                    <td>{{ $user->employeeDetail->matricule }}</td>
                                    <td>{{ $user->employeeDetail->date_naissance }}</td>
                                    <td>{{ $user->employeeDetail->date_debut }}</td>
                                    <td>{{ $user->employeeDetail->date_fin ?? '-' }}</td>
                                    <td>{{ $user->employeeDetail->adresse ?? '-' }}</td>
                                    <td>{{ $user->employeeDetail->type_contrat ?? '-' }}</td>
                                    <td>{{ $user->employeeDetail->salaire ? number_format($user->employeeDetail->salaire, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                                    <td>{{ $user->employeeDetail->description_poste ?? '-' }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="9" class="text-center text-danger">Aucun détail trouvé.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Employee Documents -->
    <div class="col-lg-12">
        {{-- Message succès Document RH --}}
        @if(session('success_document'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_document') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Documents RH</h4>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDocumentModal" 
                        @if(!$user->employeeDetail) disabled title="Ajouter un détail RH d'abord" @endif>
                    <i class="ri-add-line align-bottom me-1"></i> Ajouter
                </button>
            </div>
            <div class="card-body">
                <div class="search-box mb-3 d-flex justify-content-end">
                    <input type="text" class="form-control w-25" id="searchDocuments" placeholder="Rechercher...">
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-nowrap align-middle" id="employeeDocumentsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Nom du document</th>
                                <th>Fichier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->employeeDocuments ?? [] as $doc)
                                <tr>
                                    <td>{{ $doc->type_document }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">Voir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-danger">Aucun document trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center text-muted mt-3">
                            Aucun résultat trouvé.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal ajout détail employé --}}
<div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('employee-details.store') }}" method="POST" class="modal-content" id="employeeDetailForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeDetailModalLabel">Ajouter un Détail RH</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div id="employeeDetailAlert" class="alert d-none" role="alert"></div>

                <div class="form-row row">
                    <div class="mb-3 col-md-6">
                        <label>Matricule</label>
                        <input type="text" name="matricule" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Salaire</label>
                        <input type="number" step="0.01" name="salaire" class="form-control" required>
                    </div>
                </div>

                <div class="form-row row">
                    <div class="mb-3 col-md-6">
                        <label>Type de contrat</label>
                        <select name="type_contrat" class="form-control" required>
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Stage">Stage</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Adresse</label>
                        <input type="text" name="adresse" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description du poste</label>
                    <textarea name="description_poste" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-row row">
                    <div class="mb-3 col-md-6">
                        <label>Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Genre</label>
                        <input type="text" name="genre" class="form-control">
                        <select name="sexe" class="form-control" required>
                            <option value="masculin">masculin</option>
                            <option value="feminin">feminin</option>
                        </select>
                    </div>
                </div>

                <div class="form-row row">
                    <div class="mb-3 col-md-6">
                        <label>Date début contrat</label>
                        <input type="date" name="date_debut" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Date fin contrat</label>
                        <input type="date" name="date_fin" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
        </form>
    </div>
</div>


{{-- Modal ajout document --}}
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('employee.document.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="addDocumentForm">
      @csrf
     <input type="hidden" name="user_id" value="{{ $user->id }}">
      <div class="modal-header">
        <h5 class="modal-title" id="addDocumentModalLabel">Ajouter un Document {{ $user->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div id="documentAlert" class="alert d-none" role="alert"></div>

        <div class="mb-3">
            <label>Nom du document</label>
            <input type="text" name="type_document" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fichier</label>
            <input type="file" name="document" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Enregistrer</button>
      </div>
    </form>
  </div>
</div> 


@push('scripts')
<script>
    // Recherche instantanée dans la table documents RH
    document.getElementById('searchDocuments')?.addEventListener('input', function () {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#employeeDocumentsTable tbody tr');
        let visibleCount = 0;
        rows.forEach(row => {
            if(row.textContent.toLowerCase().includes(value)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        document.querySelector('.noresult').style.display = visibleCount === 0 ? 'block' : 'none';
    });

    // Reset alerts dans les modals à la fermeture
    ['employeeDetailModal', 'addDocumentModal'].forEach(id => {
        const el = document.getElementById(id);
        if(el){
            el.addEventListener('hidden.bs.modal', function () {
                const alert = this.querySelector('.alert');
                if(alert){
                    alert.classList.add('d-none');
                    alert.textContent = '';
                }
                const form = this.querySelector('form');
                if(form) form.reset();
            });
        }
    });
</script>
@endpush

@endsection
