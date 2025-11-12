@extends('layout.admin_rh')

@section('title', 'Tableau de Bord RH')
@section('page-title', 'Ajouter un employé')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">Ajouter un employé</h2>
                <p class="text-muted">Remplissez les informations ci-dessous pour créer un nouveau compte.</p>
            </div>

            <form action="{{ route('rh.createUsers') }}" method="POST">
                @csrf
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-3 fw-bold text-primary" >Informations Personnelles</h5>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Nom et Prénom" required>
                            <label for="name">Nom et Prénom</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control rounded-3" id="telephone" name="telephone" placeholder="Numéro de téléphone">
                            <label for="telephone">Numéro de téléphone <span class="text-muted">(facultatif)</span></label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3 fw-bold text-primary">Accès et Sécurité</h5>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="Adresse Email" required>
                            <label for="email">Adresse Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Mot de passe" required>
                            <label for="password">Mot de passe</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <h5 class="mb-3 fw-bold text-primary" >Affectation</h5>
                        <div class="form-floating">
                            <select id="team_id" class="form-select rounded-3" name="team_id" required>
                                <option value="" selected disabled>Sélectionnez une équipe...</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <label for="team_id">Équipe</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-gradient btn-lg text-white" style="background: linear-gradient(135deg, #ea6a09, #df4613); border: none;">
                        <i class="ti ti-circle-plus me-2"></i>Ajouter l'employé
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Input focus */
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(147, 112, 219, 0.25);
        border-color: #9370db;
    }

    /* Badge-style selects */
    .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(147, 112, 219, 0.25);
        border-color: #9370db;
    }

    /* Bouton hover */
    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: all 0.2s;
    }
</style>
@endpush
@endsection
