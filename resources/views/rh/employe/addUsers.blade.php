@extends('layout.admin_rh')

@section('title', 'Tableau de Bord RH')
@section('page-title', 'Ajouter un employe')

@section('content')
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Ajouter un employé</h2>
                    <p class="text-muted">Remplissez les informations ci-dessous pour créer un nouveau compte.</p>
                </div>

                <form action="{{ route('rh.createUsers') }}" method="POST">
                    @csrf
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3 text-muted">Informations Personnelles</h5>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nom et Prénom" required>
                                <label for="name">Nom et Prénom</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Numéro de téléphone">
                                <label for="telephone">Numéro de téléphone <span class="text-muted">(facultatif)</span></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3 text-muted">Accès et Sécurité</h5>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Adresse Email" required>
                                <label for="email">Adresse Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                <label for="password">Mot de passe</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12">
                            <h5 class="mb-3 text-muted">Affectation</h5>
                            <div class="form-floating">
                                <select id="team_id" class="form-select" name="team_id" required>
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
                        <button type="submit" class="btn btn-dark btn-lg">Ajouter l'employé</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection