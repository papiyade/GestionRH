@extends('layout.admin')
@section('title', 'Créer employé')
@section('page-title', 'Ajouter un employé')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">
                    <i class="ri-user-add-line text-primary me-2"></i>Ajouter un nouvel employé
                </h2>
                <p class="text-muted">Remplissez les informations ci-dessous pour créer un nouveau compte.</p>
            </div>

            <form action="{{ route('create.employe') }}" method="POST">
                @csrf
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Prénom et Nom" required>
                            <label for="name">Prénom et Nom</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Numéro de téléphone (facultatif)">
                            <label for="telephone">Numéro de téléphone <span class="text-muted">(facultatif)</span></label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Adresse E-mail" required>
                            <label for="email">Adresse E-mail</label>
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
                        <div class="form-floating">
                            <select name="role" id="role" class="form-select" required>
                                <option value="" selected disabled>-- Sélectionnez un rôle --</option>
                                <option value="rh">RH</option>
                                <option value="chef_projet">Chef de projet</option>
                                <option value="employee">Employé</option>
                            </select>
                            <label for="role">Rôle</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-dark btn-lg">
                        <i class="ri-save-line me-2"></i>Ajouter l'employé
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
