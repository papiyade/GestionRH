@extends('layout.admin_rh')

@section('title', 'RH - Détail Employé')
@section('page-title', 'Détails de l\'employé')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if (session('success_detail'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_detail') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0 fs-5 text-dark fw-bold">
                            <i class="ri-user-line me-2 text-primary"></i>Détails RH de **{{ $user->name }}**
                        </h4>
                        <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#employeeDetailModal">
                            <i class="ri-{{ $user->employeeDetail ? 'edit' : 'add' }}-line me-1"></i>
                            {{ $user->employeeDetail ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>

                    @if ($user->employeeDetail)
                        <div class="row g-3">
                            <div class="col-md-4">
                                <p class="mb-0 text-muted small">Matricule</p>
                                <h6 class="fw-bold text-dark">{{ $user->employeeDetail->matricule }}</h6>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-muted small">Date de naissance</p>
                                <h6 class="fw-bold text-dark">{{ \Carbon\Carbon::parse($user->employeeDetail->date_naissance)->format('d/m/Y') }}</h6>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-muted small">Genre</p>
                                <h6 class="fw-bold text-dark">{{ ucfirst($user->employeeDetail->genre ?? 'Non spécifié') }}</h6>
                            </div>

                            <hr class="my-3 text-muted">

                            <div class="col-md-6">
                                <p class="mb-0 text-muted small">Type de contrat</p>
                                <h6 class="fw-bold">
                                    <span class="badge rounded-pill text-bg-{{ match($user->employeeDetail->type_contrat) {
                                        'CDI' => 'primary',
                                        'CDD' => 'warning',
                                        'Stage' => 'success',
                                        'Freelance' => 'info',
                                        default => 'secondary'
                                    } }} bg-opacity-10 text-{{ match($user->employeeDetail->type_contrat) {
                                        'CDI' => 'primary',
                                        'CDD' => 'warning',
                                        'Stage' => 'success',
                                        'Freelance' => 'info',
                                        default => 'secondary'
                                    } }}">{{ $user->employeeDetail->type_contrat }}</span>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0 text-muted small">Salaire</p>
                                <h6 class="fw-bold text-dark">{{ number_format($user->employeeDetail->salaire, 0, ',', ' ') }} FCFA</h6>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-0 text-muted small">Début du contrat</p>
                                <h6 class="fw-bold text-dark">{{ \Carbon\Carbon::parse($user->employeeDetail->date_debut)->format('d/m/Y') }}</h6>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0 text-muted small">Fin du contrat</p>
                                <h6 class="fw-bold text-dark">{{ $user->employeeDetail->date_fin ? \Carbon\Carbon::parse($user->employeeDetail->date_fin)->format('d/m/Y') : 'Contrat indéterminé' }}</h6>
                            </div>

                            <div class="col-12">
                                <p class="mb-0 text-muted small">Adresse</p>
                                <h6 class="fw-bold text-dark">{{ $user->employeeDetail->adresse ?? 'Non renseignée' }}</h6>
                            </div>
                            <div class="col-12">
                                <p class="mb-0 text-muted small">Description du poste</p>
                                <p class="text-secondary">{{ $user->employeeDetail->description_poste ?? 'Non renseignée' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-light text-center" role="alert">
                            <i class="ri-information-line me-2 text-dark"></i>Aucun détail RH trouvé pour cet employé.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            @if (session('success_document'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_document') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0 fs-5 text-dark fw-bold">
                            <i class="ri-file-text-line me-2 text-primary"></i>Documents RH
                        </h5>
                        <button class="btn btn-outline-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addDocumentModal"
                            @if (!$user->employeeDetail) disabled title="Ajoutez d'abord un détail RH" @endif>
                            <i class="ri-add-line align-bottom me-1"></i> Ajouter
                        </button>
                    </div>

                    <div class="row g-3">
                        @forelse($user->employeeDocuments as $doc)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm p-3 h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ri-file-{{ strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION)) }}-line ri-2x text-primary me-2"></i>
                                            <h6 class="mb-0 text-dark fw-bold">{{ $doc->type_document }}</h6>
                                        </div>
                                        <p class="text-muted small mb-0">Ajouté le: {{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="ri-eye-line me-1"></i> Voir
                                        </a>
                                        <form action="{{ route('employee.document.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light text-center" role="alert">
                                    <i class="ri-information-line me-2 text-dark"></i>Aucun document trouvé pour cet employé.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Ajouter/Modifier Détail RH --}}
    @php
        $isEdit = isset($user->employeeDetail);
        $detail = $user->employeeDetail ?? null;
    @endphp

    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ $isEdit ? route('employee_detail.update', $user->id) : route('employee-details.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4" id="employeeDetailForm">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="modal-title fs-5 fw-bold text-dark" id="employeeDetailModalLabel">
                        <i class="ri-file-user-line me-2 text-primary"></i>{{ $isEdit ? 'Modifier le Détail RH' : 'Ajouter un Détail RH' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="matricule" class="form-label text-muted">Matricule</label>
                            <input type="text" id="matricule" name="matricule" class="form-control form-control-lg rounded-3" required value="{{ old('matricule', $detail->matricule ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="salaire" class="form-label text-muted">Salaire</label>
                            <input type="number" id="salaire" name="salaire" step="0.01" class="form-control form-control-lg rounded-3" required value="{{ old('salaire', $detail->salaire ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="type_contrat" class="form-label text-muted">Type de contrat</label>
                            <select id="type_contrat" name="type_contrat" class="form-select form-select-lg rounded-3" required>
                                @foreach (['CDI', 'CDD', 'Stage', 'Freelance'] as $type)
                                    <option value="{{ $type }}" {{ old('type_contrat', $detail->type_contrat ?? '') === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="adresse" class="form-label text-muted">Adresse</label>
                            <input type="text" id="adresse" name="adresse" class="form-control form-control-lg rounded-3" value="{{ old('adresse', $detail->adresse ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label for="description_poste" class="form-label text-muted">Description du poste</label>
                            <textarea id="description_poste" name="description_poste" class="form-control rounded-3" rows="3">{{ old('description_poste', $detail->description_poste ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="date_naissance" class="form-label text-muted">Date de naissance</label>
                            <input type="date" id="date_naissance" name="date_naissance" class="form-control form-control-lg rounded-3" required value="{{ old('date_naissance', $detail->date_naissance ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="genre" class="form-label text-muted">Genre</label>
                            <select id="genre" name="genre" class="form-select form-select-lg rounded-3">
                                <option value="">-- Sélectionnez --</option>
                                <option value="masculin" {{ old('genre', $detail->genre ?? '') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                <option value="feminin" {{ old('genre', $detail->genre ?? '') == 'feminin' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date_debut" class="form-label text-muted">Date début contrat</label>
                            <input type="date" id="date_debut" name="date_debut" class="form-control form-control-lg rounded-3" required value="{{ old('date_debut', $detail->date_debut ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="date_fin" class="form-label text-muted">Date fin contrat</label>
                            <input type="date" id="date_fin" name="date_fin" class="form-control form-control-lg rounded-3" value="{{ old('date_fin', $detail->date_fin ?? '') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-between p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="ri-save-line me-1"></i>{{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal ajout document --}}
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('employee.document.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4" id="addDocumentForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="modal-title fs-5 fw-bold text-dark" id="addDocumentModalLabel">
                        <i class="ri-add-circle-line me-2 text-primary"></i>Ajouter un Document
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="type_document" class="form-label text-muted">Nom du document</label>
                        <input type="text" id="type_document" name="type_document" class="form-control form-control-lg rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="document" class="form-label text-muted">Fichier</label>
                        <input type="file" id="document" name="document" class="form-control form-control-lg rounded-3" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-between p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="ri-upload-cloud-line me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection