@extends('layout.admin_rh')

@section('title', 'RH - team')
@section('page-title', 'Gestion des équipes')
@section('content')

    <!-- Page header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 fw-bold">ÉQUIPES</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Équipes</a></li>
                        <li class="breadcrumb-item active">Liste des équipes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Top controls -->
    <div class="row g-3 mb-4 align-items-center">
        <div class="col-auto">
            <button class="btn btn-dark btn-sm" data-bs-target="#createTeamModal" data-bs-toggle="modal">
                <i class="ri-add-line align-bottom me-1"></i> Nouvelle équipe
            </button>
        </div>
        <div class="col d-flex justify-content-end gap-2">
            <div class="search-box w-100" style="max-width: 250px;">
                <input type="text" class="form-control" placeholder="Rechercher...">
                <i class="ri-search-line search-icon"></i>
            </div>
            <select class="form-select w-auto">
                <option value="all" selected>Toutes les équipes</option>
                <option value="recent">Les plus récentes</option>
                <option value="oldest">Les plus anciennes</option>
            </select>
        </div>
    </div>

    <!-- Teams grid -->
  <div class="row g-4">
    @foreach ($teams as $team)
        <div class="col-md-6 col-lg-4 col-xxl-3">
            <div class="card shadow-sm border-0 h-100 rounded-3">
                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-0">
                                <i class="ri-history-line me-1"></i>
                                Modifiée il y a {{ str_replace([' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week', ' months', ' month', ' years', ' year'], [' secondes', ' seconde', ' minutes', ' minute', ' heures', ' heure', ' jours', ' jour', ' semaines', ' semaine', ' mois', ' mois', ' années', ' année'], str_replace(' ago', '', $team->updated_at->diffForHumans())) }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 dropdown">
                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('teams.show',$team->id) }}"><i class="ri-eye-line me-2"></i> Voir</a></li>
                                <li><a class="dropdown-item" href="#"><i class="ri-pencil-line me-2"></i> Editer</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#removeTeamModal"><i class="ri-delete-bin-line me-2"></i> Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <div class="avatar-lg mx-auto mb-3">
                            <span class="avatar-title bg-light text-dark rounded-circle fs-2 fw-bold">
                                {{ strtoupper(substr($team->name, 0, 1)) }}
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <h5 class="fw-bold mb-1">{{ $team->name }}</h5>
                        </a>
                        <p class="text-muted small mt-1" style="min-height: 20px;">
                            {{ $team->description ?? 'Ajouter une description pour ' . $team->name }}
                        </p>
                    </div>

                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-muted small">
                                <i class="ri-group-line me-1"></i> {{ $team->members->count() }} membres
                            </div>
                            <div class="text-muted small">
                                <i class="ri-calendar-line me-1"></i> {{ $team->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <div class="avatar-group mt-3">
    @foreach ($team->members as $member)
        <div class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $member->name }}">
            <div class="avatar-xs">
                <span class="avatar-title rounded-circle bg-primary text-white fw-bold" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
                    {{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                </span>
            </div>
        </div>
    @endforeach

    <!-- Bouton ajouter membre 
    <div class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter des membres">
        <div class="avatar-xs">
            <div class="avatar-title rounded-circle bg-success text-white fw-bold" style="width: 45px; height: 45px; display:flex; align-items:center; justify-content:center; font-size: 1.2rem; cursor:pointer;">
                +
            </div>
        </div>
    </div> -->
</div>


                </div>
            </div>
        </div>
    @endforeach
</div>

    <!-- Modal: Create Team -->
    <div class="modal fade" id="createTeamModal" tabindex="-1" aria-labelledby="createTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title" id="createTeamModalLabel">Nouvelle équipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('teams.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'équipe</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Entrez le nom de l'équipe" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (facultatif)</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Décrivez le rôle de l'équipe..."></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-dark">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Remove Team -->
    <div class="modal fade" id="removeTeamModal" tabindex="-1" aria-labelledby="removeTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body p-4 text-center">
                    <i class="ri-delete-bin-line text-danger display-4 mb-3"></i>
                    <h4 class="mb-2">Êtes-vous sûr ?</h4>
                    <p class="text-muted mb-4">Vous êtes sur le point de supprimer cette équipe. Cette action est irréversible.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger">Oui, supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
