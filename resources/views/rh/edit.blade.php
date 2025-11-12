@extends('layout.admin_rh')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Modifier la Fiche - {{ $employee->nom_complet }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('rh.update', $employee) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-primary">Informations Personnelles</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom *</label>
                                <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" 
                                       value="{{ old('prenom', $employee->prenom) }}" required>
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom *</label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                                       value="{{ old('nom', $employee->nom) }}" required>
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de Naissance *</label>
                                <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" 
                                       value="{{ old('date_naissance', $employee->date_naissance->format('Y-m-d')) }}" required>
                                @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lieu de Naissance *</label>
                                <input type="text" name="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror" 
                                       value="{{ old('lieu_naissance', $employee->lieu_naissance) }}" required>
                                @error('lieu_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse *</label>
                            <textarea name="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="2" required>{{ old('adresse', $employee->adresse) }}</textarea>
                            @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Résidence Actuelle *</label>
                            <input type="text" name="residence_actuelle" class="form-control @error('residence_actuelle') is-invalid @enderror" 
                                   value="{{ old('residence_actuelle', $employee->residence_actuelle) }}" required>
                            @error('residence_actuelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone *</label>
                                <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                       value="{{ old('telephone', $employee->telephone) }}" required>
                                @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $employee->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fiche de Poste *</label>
                            <input type="text" name="fiche_poste" class="form-control @error('fiche_poste') is-invalid @enderror" 
                                   value="{{ old('fiche_poste', $employee->fiche_poste) }}" required>
                            @error('fiche_poste')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut *</label>
                            <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
                                <option value="en_attente" {{ old('statut', $employee->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="validé" {{ old('statut', $employee->statut) == 'validé' ? 'selected' : '' }}>Validé</option>
                                <option value="rejeté" {{ old('statut', $employee->statut) == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                            @error('statut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Les documents ne peuvent pas être modifiés depuis cette page. Contactez l'employé pour une mise à jour des documents.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('rh.show', $employee) }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection