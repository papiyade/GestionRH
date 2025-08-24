@extends('layout.admin')
@section('title', 'Liste des équipes')
@section('page-title', 'Vos équipes')

@section('content')
<div class="container my-5" style="max-width: 1000px;">

    {{-- Header de la page --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark fs-1">
                <i class="ri-group-line text-dark me-3"></i>Toutes les équipes
            </h2>
            <p class="text-muted fs-6 mt-3">Gérez et explorez les équipes au sein de votre entreprise.</p>
        </div>
        <a href="#" class="btn btn-dark px-4 py-2 fw-bold rounded-3 shadow-sm">
            <i class="ri-add-line me-2"></i>Nouvelle équipe
        </a>
    </div>

    {{-- Grille des équipes --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($teams as $team)
            <div class="col">
                <div class="card h-100 border-0 rounded-4 shadow-sm p-3">
                    <div class="card-body d-flex flex-column">
                        {{-- Nom de l'équipe --}}
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-folder-line text-dark me-2 fs-4"></i>
                            <h5 class="card-title fw-bold text-dark mb-0">
                                {{ $team->name ?? 'Nom d\'équipe non défini' }}
                            </h5>
                        </div>

                        {{-- Description --}}
                        <p class="card-text text-muted small mb-4" style="min-height: 45px;">
                            {{ Str::limit($team->description ?? 'Pas de description disponible.', 70) }}
                        </p>

                        {{-- Détails clés --}}
                        <ul class="list-unstyled text-dark mb-4 small">
                            <li class="mb-2">
                                <i class="ri-user-line text-muted me-2"></i>
                                Membres : <span class="fw-bold">{{ $team->users_count ?? '0' }}</span>
                            </li>
                            <li class="mb-2">
                                <i class="ri-award-line text-muted me-2"></i>
                                Gérant :
                                <span class="fw-bold">
                                    {{ $team->owner->name ?? 'Non défini' }}
                                </span>
                            </li>
                        </ul>

                        {{-- Liens d'action --}}
                        <div class="d-flex justify-content-between mt-auto pt-3 border-top">
                            <a href="#" class="btn btn-link text-dark text-decoration-none fw-bold p-0">
                                Voir plus <i class="ri-arrow-right-s-line ms-1"></i>
                            </a>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <form action="#" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-dark rounded-4 text-center py-5" role="alert">
                    <h4 class="fw-bold mb-3">
                        <i class="ri-group-line me-2"></i>Aucune équipe n'a encore été créée.
                    </h4>
                    <p class="mb-0">Commencez dès maintenant à organiser votre travail d'équipe !</p>
                    <a href="#" class="btn btn-dark mt-4 px-4 py-2 fw-bold rounded-3 shadow-sm">
                        Créer votre première équipe
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
    // Initialiser les tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection
