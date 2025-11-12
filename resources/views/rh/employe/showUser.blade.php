@extends('layout.admin_rh')

@section('title', 'RH')
@section('page-title', 'Detail')
@section('content')
    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0"><a href="{{ route('employeList') }}">
                    <i class="ti ti-arrow-left me-2"></i>Retour à la liste</a>
            </h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            <div class="mb-2">
                <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary d-flex align-items-center"><i
                        class="ti ti-settings-cog me-2"></i>Modification</a>
            </div>
            <div class="head-icons ms-2">
                <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Collapse" id="collapse-header">
                    <i class="ti ti-chevrons-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="row">
        <div class="col-xl-4 theiaStickySidebar">
            <div class="card card-bg-1">
                <div class="card-body p-0">
                    <span class="avatar avatar-xl avatar-rounded border border-2 border-white m-auto d-flex ">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                    </span>
                    <div class="text-center px-3 pb-3 border-bottom">
                        <div class="mb-3">
                            <h5 class="d-flex align-items-center justify-content-center mb-1">{{ $user->name }}<i
                                    class="ti ti-discount-check-filled text-success ms-1"></i></h5>
                            <span class="badge badge-soft-dark fw-medium me-2">
                                <i class="ti ti-point-filled me-1"></i>{{ $user->role }}
                            </span>
                            <span
                                class="badge badge-soft-secondary fw-medium">{{ $user->teams->first()->name ?? 'Aucune équipe' }}</span>
                        </div>
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-id me-2"></i>
                                    ID
                                </span>
                                <p class="text-dark">EMP-00{{ $user->id }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-star me-2"></i>
                                    Team
                                </span>
                                <p class="text-dark">{{ $user->teams->first()->name ?? 'Aucune équipe' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-calendar-check me-2"></i>
                                    Date d'entrée
                                </span>
                                <p class="text-dark">
                                    @if ($user->employeeDetail && $user->employeeDetail->date_debut)
                                        {{ \Carbon\Carbon::parse($user->employeeDetail->date_debut)->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="row gx-2 mt-3">
                                <div class="col-12">
                                    <div>
                                        <a href="#" class="btn btn-dark w-100" data-bs-toggle="modal"
                                            data-bs-target="#edit_employee"><i class="ti ti-edit me-1"></i>Editer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6>Information Basique</h6>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit_employee"><i class="ti ti-edit"></i></a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="d-inline-flex align-items-center">
                                <i class="ti ti-phone me-2"></i>
                                Télephone
                            </span>
                            <p class="text-dark">{{ $user->telephone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="d-inline-flex align-items-center">
                                <i class="ti ti-mail-check me-2"></i>
                                Email
                            </span>
                            <a href="javascript:void(0);"
                                class="text-info d-inline-flex align-items-center">{{ $user->email }}</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="d-inline-flex align-items-center">
                                <i class="ti ti-cake me-2"></i>
                                Date de Naissance
                            </span>
                            <p class="text-dark text-end">
                                @if ($user->employeDetail && $user->employeDetail->date_naissance)
                                    {{ \Carbon\Carbon::parse($user->employeeDetail->date_naissance)->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="d-inline-flex align-items-center">
                                <i class="ti ti-map-pin-check me-2"></i>
                                Adresse
                            </span>
                            <p class="text-dark text-end">{{ $user->employeeDetail->adresse ?? 'Non renseignée' }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="d-inline-flex align-items-center">
                                <i class="ti ti-bookmark-plus me-2"></i>
                                Genre
                            </span>
                            <p class="text-dark text-end">{{ ucfirst($user->employeeDetail->genre ?? 'Non spécifié') }}</p>
                        </div>
                    </div>
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6>Autres informations </h6>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit_personal"><i class="ti ti-edit"></i></a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div>
                <div class="tab-content custom-accordion-items">
                    <div class="tab-pane active show" id="bottom-justified-tab1" role="tabpanel">
                        <div class="accordion accordions-items-seperate" id="accordionExample">

                                                        <div class="accordion-item">
                                <div class="accordion-header" id="headingBank">
                                    @if (session('success_bank'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_bank') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Fermer"></button>
                                        </div>
                                    @endif
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center flex-fill">
                                            <h5>Informations bancaires</h5>
                                            <a href="#" class="btn btn-sm btn-icon ms-auto" data-bs-toggle="modal"
                                                data-bs-target="#bankInfoModal">
                                                {{-- <i
                                                    class="ti ti-{{ $user->employeeDetail && $user->employeeDetail->banque_nom ? 'edit' : 'plus' }}"></i> --}}
                                            </a>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#bankCollapse"
                                                aria-expanded="false" aria-controls="bankCollapse">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="bankCollapse" class="accordion-collapse collapse border-top"
                                    aria-labelledby="headingBank" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @if ($user->employeeDetail && $user->employeeDetail->banque_nom)
                                                <div class="col-md-4 mt-2">
                                                    <span class="d-inline-flex align-items-center">Banque</span>
                                                    <h6 class="fw-medium mt-2">{{ $user->employeeDetail->banque_nom }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="d-inline-flex align-items-center">Titulaire du
                                                        compte</span>
                                                    <h6 class="fw-medium mt-2">{{ $user->employeeDetail->nom_titulaire }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="d-inline-flex align-items-center">Type de compte</span>
                                                    <h6 class="fw-medium mt-2">
                                                        {{ ucfirst($user->employeeDetail->type_compte ?? '-') }}</h6>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="d-inline-flex align-items-center">Numéro de compte</span>
                                                    <h6 class="fw-medium mt-2">{{ $user->employeeDetail->numero_compte }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="d-inline-flex align-items-center">IBAN</span>
                                                    <h6 class="fw-medium mt-2">{{ $user->employeeDetail->iban ?? '-' }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="d-inline-flex align-items-center">BIC / SWIFT</span>
                                                    <h6 class="fw-medium mt-2">
                                                        {{ $user->employeeDetail->bic_swift ?? '-' }}</h6>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <span class="d-inline-flex align-items-center">
                                                        Aucune information bancaire disponible. Veuillez les ajouter.
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <div class="accordion-header" id="headingTwo">
                                    @if (session('success_detail'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_detail') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Fermer"></button>
                                        </div>
                                    @endif
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center flex-fill">
                                            <h5>Détails RH de {{ $user->name }}</h5>
                                            </button>
                                            <a href="#" class="btn btn-sm btn-icon ms-auto" data-bs-toggle="modal"
                                                data-bs-target="#employeeDetailModal"><i
                                                    class="ti ti-{{ $user->employeeDetail ? 'edit' : 'add' }}"></i></a>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#primaryBorderTwo"
                                                aria-expanded="false" aria-controls="primaryBorderTwo">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="primaryBorderTwo" class="accordion-collapse collapse border-top"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @if ($user->employeeDetail)
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Matricule
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ $user->employeeDetail->matricule ?? '-' }}</h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Date de naissance
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ \Carbon\Carbon::parse($user->employeeDetail->date_naissance)->format('d/m/Y') }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Genre
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-1">
                                                        {{ ucfirst($user->employeeDetail->genre ?? 'Non spécifié') }}</h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Type de contrat
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-1"><span
                                                            class="badge rounded-pill text-bg-{{ match ($user->employeeDetail->type_contrat) {
                                                                'CDI' => 'primary',
                                                                'CDD' => 'warning',
                                                                'Stage' => 'success',
                                                                'Freelance' => 'info',
                                                                default => 'secondary',
                                                            } }} bg-opacity-10 text-{{ match ($user->employeeDetail->type_contrat) {
                                                                'CDI' => 'primary',
                                                                'CDD' => 'warning',
                                                                'Stage' => 'success',
                                                                'Freelance' => 'info',
                                                                default => 'secondary',
                                                            } }}">{{ $user->employeeDetail->type_contrat }}</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Salaire
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ number_format($user->employeeDetail->salaire, 0, ',', ' ') }}
                                                        FCFA
                                                    </h6>

                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Début du contrat
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ \Carbon\Carbon::parse($user->employeeDetail->date_debut)->format('d/m/Y') }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Fin du contrat
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ $user->employeeDetail->date_fin ? \Carbon\Carbon::parse($user->employeeDetail->date_fin)->format('d/m/Y') : 'Contrat indéterminé' }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Adresse
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ $user->employeeDetail->adresse ?? 'Non renseignée' }}</h6>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <span class="d-inline-flex align-items-center">
                                                        Description du poste
                                                    </span>
                                                    <h6 class="d-flex align-items-center fw-medium mt-2">
                                                        {{ $user->employeeDetail->description_poste ?? 'Non renseignée' }}
                                                    </h6>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <span class="d-inline-flex align-items-center">
                                                        Aucune information disponible. Veuillez ajouter des
                                                        détails.
                                                    </span>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingThree">
                                    @if (session('success_document'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_document') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Fermer"></button>
                                        </div>
                                    @endif
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between flex-fill">
                                            <h5>Documents RH</h5>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-icon btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#addDocumentModal"
                                                    @if (!$user->employeeDetail) disabled title="Ajoutez d'abord un détail RH" @endif><i
                                                        class="ti ti-edit"></i></a>
                                                <a href="#"
                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                    data-bs-toggle="collapse" data-bs-target="#primaryBorderThree"
                                                    aria-expanded="false" aria-controls="primaryBorderThree">
                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="primaryBorderThree" class="accordion-collapse collapse border-top"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @forelse($user->employeeDocuments as $doc)
                                                <div class="card flex-fill mb-0">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="d-flex align-items-center">
                                                                    <a href="{{ asset($doc->file_path) }}"
                                                                        target="_blank" class="flex-shrink-0 me-2">
                                                                        @if (strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION)) === 'pdf')
                                                                            <img src="{{ asset('assets/img/icons/pdf-icon.svg') }}"
                                                                                alt="img" class="mb-3">
                                                                        @elseif(in_array(strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION)), ['doc', 'docx']))
                                                                            <img src="{{ asset('assets/img/icons/file.svg') }}"
                                                                                alt="img" class="mb-3">
                                                                        @elseif(in_array(strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION)), ['xls', 'xlsx']))
                                                                            <img src="{{ asset('assets/img/icons/pdf-icon.svg') }}"
                                                                                alt="img" class="mb-3">
                                                                        @elseif(in_array(strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']))
                                                                            <img src="{{ asset('assets/img/icons/image.svg') }}"
                                                                                alt="img" class="mb-3">
                                                                        @else
                                                                            <i
                                                                                class="ti ti-file ri-2x text-secondary me-2"></i>
                                                                        @endif
                                                                    </a>
                                                                    <div>
                                                                        <h6 class="mb-1"><a
                                                                                href="{{ asset($doc->file_path) }}"
                                                                                target="_blank">{{ $doc->type_document }}</a>
                                                                        </h6>
                                                                        <div class="d-flex align-items-center">
                                                                            <p><span class="text-primary">{{ $doc->type_document }}<i
                                                                                        class="ti ti-point-filled text-primary mx-1"></i></span>{{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="dropdown ms-2">
                                                                    <a href="javascript:void(0);"
                                                                        class="d-inline-flex align-items-center"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="ti ti-dots-vertical"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                        <li>
                                                                            <a href="{{ asset($doc->file_path) }}"
                                                                                target="_blank"
                                                                                class="dropdown-item rounded-1">Ouvrir</a>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('employee.document.destroy', $doc->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')"
                                                                                class="dropdown-item rounded-1">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-link p-0 m-0 align-baseline text-danger">Supprimer</button>

                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-md-12">
                                                    <span class="d-inline-flex align-items-center">
                                                        Aucun document disponible. Veuillez en ajouter.
                                                    </span>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingThree">
                                    @if (session('success_ressource'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_ressource') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Fermer"></button>
                                        </div>
                                    @endif
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between flex-fill">
                                            <h5>Ressources attribuées</h5>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-icon btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#addRessourceModal"><i class="ti ti-edit"></i></a>
                                                <a href="#"
                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                    data-bs-toggle="collapse" data-bs-target="#primaryBorderOne"
                                                    aria-expanded="false" aria-controls="primaryBorderOne">
                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="primaryBorderOne" class="accordion-collapse collapse border-top"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @if ($user->ressources->count())
                                                <div class="row g-3">
                                                    @foreach ($user->ressources as $ressource)
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="card border-0 shadow-sm p-3 h-100">
                                                                <h6 class="text-dark fw-bold">{{ $ressource->nom }}</h6>
                                                                <p class="mb-1"><strong>Catégorie :</strong>
                                                                    {{ $ressource->categorie }}</p>
                                                                <p class="mb-1 text-muted">{{ $ressource->description }}
                                                                </p>
                                                                <form
                                                                    action="{{ route('ressource.destroy', $ressource->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Supprimer cette ressource ?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-outline-danger btn-sm rounded-pill mt-2">
                                                                        <i class="ri-delete-bin-line me-1"></i> Supprimer
                                                                    </button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-light text-center" role="alert">
                                                    <i class="ri-information-line me-2 text-dark"></i>Aucune ressource
                                                    attribuée à cet employé.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="contact-grids-tab p-0 mb-3">
                                        <ul class="nav nav-underline" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="info-tab2" data-bs-toggle="tab"
                                                    data-bs-target="#basic-info2" type="button" role="tab"
                                                    aria-selected="true">Projets</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="address-tab2" data-bs-toggle="tab"
                                                    data-bs-target="#address2" type="button" role="tab"
                                                    aria-selected="false">Documents</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
