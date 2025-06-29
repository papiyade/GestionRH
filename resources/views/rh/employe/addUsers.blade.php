@extends('layouts.admin_rh-dashboard')

@section('content')
    <!-- Headings -->
    <h1 class="mb-3">Ajout un nouveau employe </h1>
    <div class="card">
        <form action="{{ route('rh.createUsers') }}" method="POST">
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
               
                <div class="col-6">
                    <div class="mb-3">
                        <label for="team_id" class="form-label">Équipe</label>
                        <select id="team_id" class="form-select" name="team_id" required>
                            <option selected>Associer à</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

              

    
                <!-- Statut de travail -->
               
    
            
               

                <div class="col-lg-12 mb-1">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
@endsection
