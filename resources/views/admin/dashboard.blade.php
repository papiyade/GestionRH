@extends('layout.admin')
@section('title', 'Tableau de Bord Admin')
@section('page-title', 'admin')



@section('content')
@if(session('first_time_login'))
    <div class="alert alert-info alert-border-left alert-dismissible fade show material-shadow" role="alert">
        <i class="ri-notification-off-line me-3 align-middle"></i>
        <strong>Bienvenue !</strong> C’est votre première connexion.<br>
        <ul class="mt-2 mb-0">
            <li>
                🔐 <strong><a href="#" class="text-decoration-underline text-info">Changez votre mot de passe</a></strong> — c’est important pour votre sécurité.
            </li>
            <li>
                🏢 <strong><a href="{{ route('company') }}" class="text-decoration-underline text-info">Configurez votre entreprise</a></strong> — pour commencer à l’utiliser pleinement.
            </li>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-info alert-border-left alert-dismissible fade show material-shadow" role="alert">
        <i class="ri-notification-off-line me-3 align-middle"></i>
         {{ session('success') }}
        <ul class="mt-2 mb-0">
            <li>
                🏢 <strong><a href="#" class="text-decoration-underline text-info">Ajoutez votre equipes</a></strong>
            </li>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif



<h1>Admin dashboard</h1>

@endsection