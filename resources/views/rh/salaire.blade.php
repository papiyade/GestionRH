@extends('layout.admin_rh')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Saisie du Salaire - {{ $employee->nom_complet }}</h4>
                </div>

                <div class="card-body">
                    {{-- Salaire actuel --}}
                    @if($employee->salaire)
                        <div class="alert alert-info">
                            <strong>Salaire actuel :</strong>
                            {{ number_format($employee->salaire->salaire_net, 0, ',', ' ') }} FCFA
                        </div>
                    @endif

                    {{-- Formulaire --}}
                    <form action="{{ route('rh.salaire.store', $employee) }}" method="POST">
                        @csrf

                        {{-- SALAIRE DE BASE --}}
                        <div class="mb-4">
                            <label class="form-label">Salaire de Base *</label>
                            <div class="input-group">
                                <input type="number" name="salaire_base" class="form-control @error('salaire_base') is-invalid @enderror"
                                    value="{{ old('salaire_base', $employee->salaire?->salaire_base) }}" step="0.01" required>
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('salaire_base')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- SUR-SALAIRE --}}
                        <div class="mb-4">
                            <label class="form-label">Sursalaire</label>
                            <div class="input-group">
                                <input type="number" name="sursalaire" class="form-control @error('sursalaire') is-invalid @enderror"
                                    value="{{ old('sursalaire', $employee->user->employeeDetail->sursalaire ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('sursalaire')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PRIME --}}
                        <div class="mb-4">
                            <label class="form-label">Prime</label>
                            <div class="input-group">
                                <input type="number" name="prime" class="form-control @error('prime') is-invalid @enderror"
                                    value="{{ old('prime', $employee->salaire?->prime ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('prime')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DEDUCTIONS --}}
                        <div class="mb-4">
                            <label class="form-label">Déductions (autres)</label>
                            <div class="input-group">
                                <input type="number" name="deductions" class="form-control @error('deductions') is-invalid @enderror"
                                    value="{{ old('deductions', $employee->salaire?->deductions ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            <small class="text-muted">Autres retenues diverses.</small>
                            @error('deductions')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- COTISATIONS SOCIALES --}}
                        <h5 class="text-primary mt-4">Cotisations Sociales</h5>
                        <hr>

                        <div class="mb-3">
                            <label class="form-label">Caisse CSS</label>
                            <div class="input-group">
                                <input type="number" name="caisse_css" class="form-control @error('caisse_css') is-invalid @enderror"
                                    value="{{ old('caisse_css', $employee->user->employeeDetail->caisse_css ?? 0) }}" step="0.01" max="63000">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            <small class="text-muted">Plafond : 63 000 FCFA</small>
                            @error('caisse_css')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">IPM (Assurance Maladie)</label>
                            <div class="input-group">
                                <input type="number" name="ipm" class="form-control @error('ipm') is-invalid @enderror"
                                    value="{{ old('ipm', $employee->user->employeeDetail->ipm_assurance ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('ipm')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- IR --}}
                        <div class="mb-3">
                            <label class="form-label">IR</label>
                            <div class="input-group">
                                <input type="number" name="ir" class="form-control @error('ir') is-invalid @enderror"
                                    value="{{ old('ir', $employee->user->employeeDetail->ir ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('ir')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TRIMF --}}
                        <div class="mb-3">
                            <label class="form-label">TRIMF</label>
                            <div class="input-group">
                                <input type="number" name="trimf" class="form-control @error('trimf') is-invalid @enderror"
                                    value="{{ old('trimf', $employee->user->employeeDetail->trimf ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('trimf')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INDEMNITE TRANSPORT (Globale) --}}
                        <div class="mb-4">
                            <label class="form-label">Indemnité Transport (Entreprise)</label>
                            <div class="input-group">
                                <input type="number" name="indemnite_transport" class="form-control"
                                    value="{{ old('indemnite_transport', $employee->entreprise->indemnite_transport ?? 0) }}" step="0.01">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            <small class="text-muted">Cette indemnité s'applique à tous les employés.</small>
                        </div>

                        {{-- RUBRIQUES --}}
                        <h5 class="text-primary mt-4">Rubriques</h5>
                        <hr>

                        <div class="mb-3">
                            <label class="form-label">Rubriques Soumises</label>
                            <textarea name="rubrique_soumise" class="form-control" rows="2" placeholder="Ex : Prime de rendement, Indemnité de logement...">{{ old('rubrique_soumise', $employee->user->employeeDetail->rubrique_soumise ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rubriques Non Soumises</label>
                            <textarea name="rubrique_non_soumise" class="form-control" rows="2" placeholder="Ex : Allocation familiale, indemnités non imposables...">{{ old('rubrique_non_soumise', $employee->user->employeeDetail->rubrique_non_soumise ?? '') }}</textarea>
                        </div>

                        {{-- DATE D’EFFET --}}
                        <div class="mb-4">
                            <label class="form-label">Date d'Effet *</label>
                            <input type="date" name="date_effet" class="form-control @error('date_effet') is-invalid @enderror"
                                value="{{ old('date_effet', now()->format('Y-m-d')) }}" required>
                            @error('date_effet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INFO NET --}}
                        <div class="alert alert-secondary">
                            <strong>Calcul du Salaire Net :</strong>
                            <p class="mb-0">
                                Salaire Net = Salaire de Base + Sursalaire + Prime + Indemnité Transport - (Déductions + Caisse CSS + IPM + IR + TRIMF)
                            </p>
                        </div>

                        {{-- BOUTONS --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rh.show', $employee) }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer le Salaire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
