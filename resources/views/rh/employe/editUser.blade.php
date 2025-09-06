@extends('layout.admin_rh')

@section('title', 'Tableau de Bord RH')
@section('page-title', 'Modifier un employé')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">Modifier un employé</h2>
                    <p class="text-muted">Mettez à jour les informations de l'employé.</p>
                </div>
                <a href="{{ route('employeList') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <form action="{{ route('rh.updateUsers', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-3 fw-bold" style="color: rgba(138, 43, 226, 0.6);">Informations Personnelles</h5>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Nom et Prénom" value="{{ old('name', $user->name) }}" required>
                            <label for="name">Nom et Prénom</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control rounded-3" id="telephone" name="telephone" placeholder="Numéro de téléphone" value="{{ old('telephone', $user->telephone) }}">
                            <label for="telephone">Numéro de téléphone <span class="text-muted">(facultatif)</span></label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3 fw-bold" style="color: rgba(138, 43, 226, 0.6);">Accès et Sécurité</h5>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="Adresse Email" value="{{ old('email', $user->email) }}" required>
                            <label for="email">Adresse Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Mot de passe">
                            <label for="password">Mot de passe <span class="text-muted">(laisser vide pour ne pas changer)</span></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le mot de passe">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <h5 class="mb-3 fw-bold" style="color: rgba(138, 43, 226, 0.6);">Affectation</h5>
                        <div class="form-floating">
                            <select id="team_id" class="form-select rounded-3" name="team_id" required>
                                <option value="" disabled>Sélectionnez une équipe...</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" {{ $user->teams->pluck('id')->contains($team->id) ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="team_id">Équipe</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-gradient btn-lg text-white" style="background: linear-gradient(135deg, #9370db, #8a2be2); border: none;">
                        <i class="ti ti-edit me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(147, 112, 219, 0.25);
        border-color: #9370db;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s;
    }
</style>
@endpush
@endsection
