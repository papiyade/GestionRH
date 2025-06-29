@extends('layouts.admin_rh-dashboard')

@section('content')

<div class="row">
<div class="col-lg-12">
    <div class="card mt-n4 mx-n4">
        <div class="bg-warning-subtle">
            <div class="card-body pb-0 px-4">
                <div class="row mb-3">
                    <div class="col-md">
                        <div class="row align-items-center g-3">
                            <div class="col-md-auto">
                                <div class="avatar-md">
                                    <div class="avatar-title bg-white rounded-circle">
                                        <img src="{{ asset('assets/images/brands/slack.png') }}" alt="" class="avatar-xs">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div>
                                    <h4 class="fw-bold">{{ $team->name }}</h4>
                                    <div class="hstack gap-3 flex-wrap">
                                        <div><i class="ri-building-line align-bottom me-1"></i> Team</div>
                                        <div class="vr"></div>
                                        <div>Date de Création : <span class="fw-medium">{{ $team->created_at->format('d M, Y') }}</span></div>
                                        <div class="vr"></div>
                                        <div>Date de dernière modification: <span class="fw-medium">{{ $team->updated_at->format('d M, Y') }}</span></div>
                                        <div class="vr"></div>
                                        {{-- <div class="badge rounded-pill bg-info fs-12">New</div>
                                        <div class="badge rounded-pill bg-danger fs-12">High</div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="hstack gap-1 flex-wrap">
                            <button type="button" class="btn py-0 fs-16 favourite-btn material-shadow-none active">
                                <i class="ri-star-fill"></i>
                            </button>
                            <button type="button" class="btn py-0 fs-16 text-body material-shadow-none">
                                <i class="ri-share-line"></i>
                            </button>
                            <button type="button" class="btn py-0 fs-16 text-body material-shadow-none">
                                <i class="ri-flag-line"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#project-overview" role="tab">
                            Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-team" role="tab">
                            Team
                        </a>
                    </li>
                </ul>
            </div>
            <!-- end card body -->
        </div>
    </div>

</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-content text-muted">
            <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted">
                                    <h6 class="mb-3 fw-semibold text-uppercase">Description</h6>
                                    <p>{{ $team->description }}</p>
                                    <button class="btn btn-success w-sm create-folder-modal flex-shrink-0" data-bs-toggle="modal" data-bs-target="#createFolderModal"><i class="ri-add-line align-bottom me-1"></i> @if ($team->description) Modifier la description @else Ajouter une description @endif</button>

                                    <div class="modal fade zoomIn" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header p-3 bg-success-subtle">
                                                    <h5 class="modal-title" id="createFolderModalLabel">@if ($team->description) Modifier la description @else Ajouter une description @endif</h5>
                                                     </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="addFolderBtn-close" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form autocomplete="off" class="needs-validation createfolder-form" id="createfolder-form" method="POST" action="{{ route('teams.updateDescription', $team) }}" novalidate>
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="description-input" class="form-label">Description</label>
                                                            <input type="text" class="form-control" id="description-input" name="description" required placeholder="Entrez votre texte ici" value="{{ old('description', $team->description) }}">
                                                            <div class="invalid-feedback">Entrez votre texte ici.</div>
                                                        </div>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-ghost-success material-shadow-none" data-bs-dismiss="modal"><i class="ri-close-line align-bottom"></i> Annuler</button>
                                                            <button type="submit" class="btn btn-primary" id="addNewFolder">Ajouter</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 border-top border-top-dashed mt-4">
                                        <div class="row gy-3">

                                            <div class="col-lg-4 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium">Date de Création :</p>
                                                    <h5 class="fs-15 mb-0">{{ $team->created_at->format('d, M Y') }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium">Dernière Modification:</p>
                                                    <h5 class="fs-15 mb-0">{{ $team->updated_at->format('d, M  Y') }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium">Effectif :</p>
                                                    <div class="badge bg-danger fs-12">{{ $team->members->count() }}</div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium">Status :</p>
                                                    <div class="badge bg-warning fs-12">Inprogress</div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="pt-3 border-top border-top-dashed mt-4">
                                        <h6 class="mb-3 fw-semibold text-uppercase">Ressources</h6>
                                      
                                        Aucune ressource pour le moment
                                        <!-- end row -->
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <!-- end card -->
                    </div>
                    <!-- ene col -->
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">tags</h5>
                                <div class="d-flex flex-wrap gap-2 fs-16">
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">UI/UX</div>
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">Figma</div>
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">HTML</div>
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">CSS</div>
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">Javascript</div>
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">C#</div>
                                    <div class="badge fw-medium bg-secondary-subtle text-secondary">Nodejs</div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header align-items-center d-flex border-bottom-dashed">
                                <h4 class="card-title mb-0 flex-grow-1">Membres</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-danger btn-sm material-shadow-none" data-bs-toggle="modal" data-bs-target="#inviteMembersModal"><i class="ri-share-line me-1 align-bottom"></i> Ajouter un Membre</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div data-simplebar style="height: 235px;" class="mx-n3 px-3">
                                    <div class="vstack gap-3">
                                        @foreach ($team->members as $member)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title rounded bg-info-subtle text-info material-shadow">
                                                    {{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                                                </div>
                                            </div>
                                           <div class="flex-grow-1">
    <h5 class="fs-13 mb-0">
        <a href="#" class="text-body d-block">{{ $member->name }}</a>
    </h5>
</div>
<div class="flex-shrink-0">
    <div class="d-flex align-items-center gap-1">
        <div class="dropdown">
            <button class="btn btn-icon btn-sm fs-16 text-muted dropdown material-shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-fill"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="ri-eye-fill text-muted me-2 align-bottom"></i>Voir</a></li>
                <li><a class="dropdown-item" href="#"><i class="ri-star-fill text-muted me-2 align-bottom"></i>Favourite</a></li>

                @if(Auth::id() === $team->owner_id && $member->id !== $team->owner_id)
                <li>
                    <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('remove-member-{{ $member->id }}').submit();">
                        <i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Retirer
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
</div>

                                        </div>
                                        @endforeach

                                        <!-- end member item -->
                                    </div>
                                    <!-- end list -->
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header align-items-center d-flex border-bottom-dashed">
                                <h4 class="card-title mb-0 flex-grow-1">Attachments</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-info btn-sm"><i class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="vstack gap-2">
                                    <div class="border rounded border-dashed p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">App-pages.zip</a></h5>
                                                <div>2.2MB</div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none"><i class="ri-download-2-line"></i></button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown material-shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Rename</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded border-dashed p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-file-ppt-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">Velzon-admin.ppt</a></h5>
                                                <div>2.4MB</div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none"><i class="ri-download-2-line"></i></button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown material-shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Rename</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded border-dashed p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">Images.zip</a></h5>
                                                <div>1.2MB</div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none"><i class="ri-download-2-line"></i></button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown material-shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Rename</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded border-dashed p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-image-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">bg-pattern.png</a></h5>
                                                <div>1.1MB</div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none"><i class="ri-download-2-line"></i></button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown material-shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Rename</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2 text-center">
                                        <button type="button" class="btn btn-success">View more</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade" id="project-team" role="tabpanel">
                <div class="row g-4 mb-3">
                    <div class="col-sm">
                        <div class="d-flex">
                            <div class="search-box me-2">
                                <input type="text" class="form-control" placeholder="Rechercher un membre...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#inviteMembersModal"><i class="ri-add-fill me-1 align-bottom"></i> Ajouter un membre</button>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="team-list list-view-filter">
                    @foreach ($team->members as $member)
                    <div class="card team-box">
                        <div class="card-body px-4">
                            <div class="row align-items-center team-row">
                                <div class="col team-settings">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="flex-shrink-0 me-2">
                                                <button type="button" class="btn fs-16 p-0 favourite-btn">
                                                    <i class="ri-star-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col text-end dropdown">
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill fs-17"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill text-muted me-2 align-bottom"></i>Détails</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-fill text-muted me-2 align-bottom"></i>Favoris</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Supprimer</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col">
                                    <div class="team-profile-img">
                                        <div class="avatar-md">
                                            <div class="avatar-title rounded bg-info-subtle text-info material-shadow">
                                                {{ strtoupper(substr($member->name, 0, 1) . (strpos($member->name, ' ') !== false ? substr($member->name, strpos($member->name, ' ') + 1, 1) : '')) }}
                                            </div>
                                        </div>
                                        <div class="team-content">
                                            <a href="#" class="d-block">
                                                <h5 class="fs-16 mb-1">{{ $member->name  }}</h5>
                                            </a>
                                            <p class="text-muted mb-0">Membre</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col">
                                    <div class="row text-muted text-center">
                                        <div class="col-6 border-end border-end-dashed">
                                            <h5 class="mb-1">
                                                @if ($member->projects)
                                                {{ $member->projects->count() }}
                                                @else
                                                0
                                                @endif</h5>
                                            <p class="text-muted mb-0">Projets</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="mb-1">
                                                @if ($member->tasks)
                                                {{ $member->tasks->count() }}
                                                @else
                                                Aucune tache

                                                @endif
                                            </h5>
                                            <p class="text-muted mb-0">Taches</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col">
                                    <div class="text-end">
                                        <a href="pages-profile.html" class="btn btn-light view-btn">Voir le profil</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!-- end team list -->

                <div class="row g-0 text-center text-sm-start align-items-center mb-3">
                    <div class="col-sm-6">
                        <div>
                            <p class="mb-sm-0">Affichage de 1 to 1 sur 1 entrée(s)</p>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-sm-6">
                        <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                            <li class="page-item disabled"> <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a> </li>
                            <li class="page-item"> <a href="#" class="page-link">1</a> </li>
                            <li class="page-item active"> <a href="#" class="page-link">2</a> </li>
                            <li class="page-item"> <a href="#" class="page-link">3</a> </li>
                            <li class="page-item"> <a href="#" class="page-link">4</a> </li>
                            <li class="page-item"> <a href="#" class="page-link">5</a> </li>
                            <li class="page-item"> <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a> </li>
                        </ul>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
            <!-- end tab pane -->
        </div>
        <div class="modal fade" id="inviteMembersModal" tabindex="-1" aria-labelledby="inviteMembersModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header p-3 ps-4 bg-success-subtle">
                        <h5 class="modal-title" id="inviteMembersModalLabel">Members</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="search-box mb-3">
                            <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                            <i class="ri-search-line search-icon"></i>
                        </div>

                        <div class="mb-4 d-flex align-items-center">
                            <div class="me-2">
                                <h5 class="mb-0 fs-13">Members :</h5>
                            </div>
                            <div class="avatar-group justify-content-center">
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Brent Gonzalez">
                                    <div class="avatar-xs">
                                        <img src="assets/images/users/avatar-3.jpg" alt="" class="rounded-circle img-fluid">
                                    </div>
                                </a>
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Sylvia Wright">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded-circle bg-secondary">
                                            S
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ellen Smith">
                                    <div class="avatar-xs">
                                        <img src="assets/images/users/avatar-4.jpg" alt="" class="rounded-circle img-fluid">
                                    </div>
                                </a>
                            </div>
                        </div>
                       <div class="mx-n4 px-4" data-simplebar style="max-height: 225px;">
    <div class="vstack gap-3">
        @foreach ($users as $user)
            <div class="d-flex align-items-center">
                <div class="avatar-xs flex-shrink-0 me-3">
                    @if ($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="" class="img-fluid rounded-circle">
                    @else
                        <div class="avatar-title bg-secondary-subtle text-secondary rounded-circle">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <h5 class="fs-13 mb-0">
                        <a href="#" class="text-body d-block">{{ $user->name }}</a>
                    </h5>
                </div>
                <div class="flex-shrink-0">
                    <form action="{{ route('teams.addMember', [$team->id, $user->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm material-shadow-none">Ajouter</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light w-xs" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success w-xs">Invite</button>
                    </div>
                </div>
                <!-- end modal-content -->
            </div>
            <!-- modal-dialog -->
        </div>
    </div>


    <!-- end col -->
</div>
@endsection
