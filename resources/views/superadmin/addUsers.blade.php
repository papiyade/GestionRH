@extends('layouts.admin-dashboard')

@section('content')
    <!-- Headings -->
    <h2 class="mb-3">Ajout d'un nouveau administrateur d'entreprise </h2>
    <div class="card">
        <form action="{{ route('add_admin') }}" method="POST">
            @csrf
            <div class="col-12 mt-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Prénom et Nom</label>
                    <input type="text" class="form-control" name="name" placeholder="Entrez le nom complet" id="name" required>
                </div>
            </div>
    
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro téléphone</label>
                        <input type="tel" name="telephone" class="form-control" placeholder="(facultatif)" id="telephone">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" id="email" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                    </div>
                </div>

                <div class="col-lg-12 mb-1">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
@endsection
