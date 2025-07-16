@extends('layouts.admin_rh-dashboard')

@section('content')
    <div class="row">
        <!-- SECTION 1: Employee Details -->
        <div class="col-lg-12">
            @if (session('success_detail'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_detail') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Détails RH - {{ $user->name }}</h4>
                    <button class="btn {{ $user->employeeDetail ? 'btn-primary' : 'btn-success' }}" data-bs-toggle="modal"
                        data-bs-target="#employeeDetailModal">
                        <i class="ri-{{ $user->employeeDetail ? 'edit' : 'add' }}-line align-bottom me-1"></i>
                        {{ $user->employeeDetail ? 'Modifier' : 'Ajouter' }}
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Matricule</th>
                                    <th>Date de naissance</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Adresse</th>
                                    <th>Type de contrat</th>
                                    <th>Salaire</th>
                                    <th>Description poste</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($user->employeeDetail)
                                    <tr>
                                        <td>{{ $user->employeeDetail->matricule }}</td>
                                        <td>{{ $user->employeeDetail->date_naissance }}</td>
                                        <td>{{ $user->employeeDetail->date_debut }}</td>
                                        <td>{{ $user->employeeDetail->date_fin ?? '-' }}</td>
                                        <td>{{ $user->employeeDetail->adresse ?? '-' }}</td>
                                        <td>{{ $user->employeeDetail->type_contrat ?? '-' }}</td>
                                        <td>{{ number_format($user->employeeDetail->salaire, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $user->employeeDetail->description_poste ?? '-' }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center text-danger">Aucun détail trouvé.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Documents -->
        <div class="col-lg-12 mt-4">
            @if (session('success_document'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_document') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Documents RH</h4>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDocumentModal"
                        @if (!$user->employeeDetail) disabled title="Ajoutez d'abord un détail RH" @endif>
                        <i class="ri-add-line align-bottom me-1"></i> Ajouter
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-nowrap align-middle" id="employeeDocumentsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom du document</th>
                                    <th>Fichier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->employeeDocuments as $doc)
                                    <tr>
                                        <td>{{ $doc->type_document }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm">
                                                Voir
                                            </a>

                                            <form action="{{ route('employee.document.destroy', $doc->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-outline-danger btn-sm">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-danger">Aucun document trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
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

    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ $isEdit ? route('employee_detail.update', $user->id) : route('employee-details.store') }}"
                method="POST" class="modal-content" id="employeeDetailForm">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailModalLabel">
                        {{ $isEdit ? 'Modifier le Détail RH' : 'Ajouter un Détail RH' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label>Matricule</label>
                            <input type="text" name="matricule" class="form-control" required
                                value="{{ old('matricule', $detail->matricule ?? '') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Salaire</label>
                            <input type="number" name="salaire" step="0.01" class="form-control" required
                                value="{{ old('salaire', $detail->salaire ?? '') }}">
                        </div>
                    </div>

                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label>Type de contrat</label>
                            <select name="type_contrat" class="form-control" required>
                                @foreach (['CDI', 'CDD', 'Stage', 'Freelance'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('type_contrat', $detail->type_contrat ?? '') === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control"
                                value="{{ old('adresse', $detail->adresse ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Description du poste</label>
                        <textarea name="description_poste" class="form-control" rows="2">{{ old('description_poste', $detail->description_poste ?? '') }}</textarea>
                    </div>

                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance" class="form-control" required
                                value="{{ old('date_naissance', $detail->date_naissance ?? '') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Genre</label>
                            <select name="genre" class="form-control">
                                <option value="">-- Sélectionnez --</option>
                                <option value="masculin"
                                    {{ old('genre', $detail->genre ?? '') == 'masculin' ? 'selected' : '' }}>Masculin
                                </option>
                                <option value="feminin"
                                    {{ old('genre', $detail->genre ?? '') == 'feminin' ? 'selected' : '' }}>Féminin
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row row">
                        <div class="mb-3 col-md-6">
                            <label>Date début contrat</label>
                            <input type="date" name="date_debut" class="form-control" required
                                value="{{ old('date_debut', $detail->date_debut ?? '') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label>Date fin contrat</label>
                            <input type="date" name="date_fin" class="form-control"
                                value="{{ old('date_fin', $detail->date_fin ?? '') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal ajout document --}}
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('employee.document.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content" id="addDocumentForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">Ajouter un Document - {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
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
@endsection
