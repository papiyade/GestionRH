@extends('layout.admin_rh')

@section('title', 'RH - Équipe')
@section('page-title', 'Détails de l\'équipe')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-lg border-0 rounded-4 mt-n4 mx-n4" style>
            <div class="card-body rounded-4 p-4" style="background: linear-gradient(135deg, #FFD580 0%, #FF8800 100%);">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md me-4">
                            <div class="avatar-title rounded-circle fs-24 text-white"
                                 style="background: linear-gradient(135deg, #FFD580 0%, #FF8800 100%); display: flex; align-items: center; justify-content: center; width: 56px; height: 56px;">
                                {{ strtoupper(substr($team->name, 0, 1)) }} 
                            </div>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $team->name }}</h3>
                            <div class="text-muted d-flex flex-wrap gap-3">
                                <span class="d-flex align-items-center"><i class="ri-group-line me-1"></i> Équipe</span>
                                <span class="vr"></span>
                                <span class="d-flex align-items-center"><i class="ri-calendar-line me-1"></i> Créée le : {{ $team->created_at->format('d M, Y') }}</span>
                                <span class="vr"></span>
                                <span class="d-flex align-items-center"><i class="ri-edit-line me-1"></i> Modifiée le : {{ $team->updated_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        @if($team->entreprise)
                            <span class="btn btn-outline-dark btn-sm">
                                <i class="ri-building-line me-1"></i> {{ $team->entreprise->entreprise_name }}
                            </span>
                        @endif
                    </div>
                </div>

                <ul class="nav nav-pills nav-justified mt-4 border-bottom pb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold text-white" data-bs-toggle="tab" href="#team-overview" role="tab">
                            <i class="ri-dashboard-line me-1"></i> Aperçu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#team-members" role="tab">
                            <i class="ri-group-line me-1"></i> Membres
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="team-overview" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 rounded-4 h-100">
                            <div class="card-body position-relative">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-semibold text-uppercase mb-0">
                                        <i class="ri-information-line me-1"></i> Description
                                    </h6>
                                    <button class="btn btn-sm btn-outline-primary create-folder-modal" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                                        <i class="ri-pencil-line me-1 align-bottom"></i>
                                        @if ($team->description) Modifier @else Ajouter @endif
                                    </button>
                                </div>
                                @if ($team->description)
                                    <div class="alert alert-light border-0 rounded-3 px-3 py-2 mb-0" style="font-size: 1.05rem;">
                                        {{ $team->description }}
                                    </div>
                                @else
                                    <div class="alert alert-warning border-0 rounded-3 px-3 py-2 mb-0 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                        <i class="ri-alert-line me-2"></i>
                                        <span>Aucune description disponible pour le moment.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 rounded-4 h-100">
                            <div class="card-body rounded-4" style="background: linear-gradient(135deg, #f6ddab 0%, #f6e3d0 100%);">
                                <h6 class="fw-semibold text-uppercase mb-3">Détails de l'équipe</h6>
                                <div class="vstack gap-2">
                                    <p class="mb-0 text-muted d-flex justify-content-between align-items-center">
                                        <span>Date de Création :</span>
                                        <span class="fw-medium text-dark">{{ $team->created_at->format('d, M Y') }}</span>
                                    </p>
                                    <p class="mb-0 text-muted d-flex justify-content-between align-items-center">
                                        <span>Dernière Modification :</span>
                                        <span class="fw-medium text-dark">{{ $team->updated_at->format('d, M Y') }}</span>
                                    </p>
                                    <p class="mb-0 text-muted d-flex justify-content-between align-items-center">
                                        <span>Effectif :</span>
                                        <span class="badge  fs-12" style="background: linear-gradient(135deg, #FFD580 0%, #FF8800 100%);">{{ $team->members->count() }} Membres</span>
                                    </p>
                                    <p class="mb-0 text-muted d-flex justify-content-between align-items-center">
                                        <span>Ressources :</span>
                                        <span class="text-muted">Aucune ressource</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="team-members" role="tabpanel">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header border-bottom-dashed d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #f6ddab 0%, #f6e3d0 100%);">
                        <h4 class="card-title mb-0 flex-grow-1">Membres de l'équipe ({{ $team->members->count() }})</h4>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteMembersModal">
                                <i class="ri-user-add-line me-1 align-bottom"></i> Inviter des Membres
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="vstack gap-3">
                            @foreach ($team->members as $member)
                                <div class="d-flex align-items-center p-3 rounded-3 hover-bg-light transition-all">
                                    <div class="avatar-md flex-shrink-0 me-4">
                                        <div class="avatar-title rounded-circle fs-24 text-white"
                                        style="background: linear-gradient(135deg, #FFD580 0%, #FF8800 100%); display: flex; align-items: center; justify-content: center; width: 56px; height: 56px;">
                                            {{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-0">
                                            <a href="{{ route('users.show',$member->id) }}" class="text-body fw-medium">{{ $member->name }}</a>
                                        </h5>
                                        <p class="text-muted mb-0 small">Membre de l'équipe</p>
                                    </div>
                                    <div class="flex-shrink-0 dropdown">
                                        <button class="btn btn-sm btn-link text-muted p-1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="ri-eye-line me-2"></i> Voir profil</a></li>
                                            @if(Auth::id() === $team->owner_id && $member->id !== $team->owner_id)
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('remove-member-{{ $member->id }}').submit();">
                                                        <i class="ri-delete-bin-line me-2"></i> Retirer
                                                    </a>
                                                    <form id="remove-member-{{ $member->id }}" action="{{ route('teams.members.remove', [$team->id, $member->id]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoomIn" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-light">
                <h5 class="modal-title" id="createFolderModalLabel">@if ($team->description) Modifier la description @else Ajouter une description @endif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" method="POST" action="{{ route('teams.updateDescription', $team) }}" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="description-input" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description-input" name="description" required placeholder="Entrez votre texte ici" value="{{ old('description', $team->description) }}">
                        <div class="invalid-feedback">Entrez un texte.</div>
                    </div>
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-ghost-dark" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-dark">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-3 bg-light">
                <h5 class="modal-title" id="inviteMembersModalLabel">Inviter des Membres</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label for="search-members" class="form-label">Rechercher des utilisateurs :</label>
                    <input type="text" class="form-control" id="search-members" placeholder="Nom de l'utilisateur...">
                </div>
                <div class="mx-n3 px-3" data-simplebar style="max-height: 250px;">
                    <div class="vstack gap-3">
                        @foreach ($users as $user)
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs flex-shrink-0 me-3">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="" class="img-fluid rounded-circle">
                                        @else
                                            <div class="avatar-title rounded-circle fs-15 text-white"
                                 style="background: linear-gradient(135deg, #FFD580 0%, #FF8800 100%); display: flex; align-items: center; justify-content: center; width: 25px; height: 25px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-13 mb-0">
                                            <a href="#" class="text-body d-block">{{ $user->name }}</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <form action="{{ route('teams.addMember', [$team->id, $user->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection