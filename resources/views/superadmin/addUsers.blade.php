@extends('layout.superadmin')

@section('title', 'Tableau de Bord SuperAdmin')
@section('page-title', 'Ajouter un Admin Entreprise')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4 p-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Ajouter un nouvel administrateur d'entreprise</h2>
            <p class="text-muted">Remplissez les informations ci-dessous pour créer un compte.</p>
        </div>

        <form action="{{ route('add_admin') }}" method="POST">
            @csrf
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Prénom et Nom" required>
                        <label for="name">Prénom et Nom</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Numéro de téléphone (facultatif)">
                        <label for="telephone">Numéro de téléphone <span class="text-muted">(facultatif)</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Adresse Email" required>
                        <label for="email">Adresse Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                        <label for="password">Mot de passe</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                    </div>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-dark btn-lg">Ajouter</button>
            </div>
        </form>
    </div>
</div>
@endsection
