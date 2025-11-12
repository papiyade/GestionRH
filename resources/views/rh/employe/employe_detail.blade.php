@extends('layout.admin_rh')

@section('title', 'RH - Détail Employé')
@section('page-title', 'Détails de l\'employé')

@section('content')
    <div class="col-lg-12">
        <div class="col-xl-12">
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
                                                <i
                                                    class="ti ti-{{ $user->employeeDetail && $user->employeeDetail->banque_nom ? 'edit' : 'plus' }}"></i>
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
                                                        FCFA</h6>
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
                                    <div class="tab-content" id="myTabContent3">
                                        {{-- <div class="tab-pane fade show active" id="basic-info2" role="tabpanel"
                                            aria-labelledby="info-tab2" tabindex="0">
                                            <div class="row">
                                                <div class="col-md-6 d-flex">
                                                    <div class="card flex-fill mb-4 mb-md-0">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                                                                <a href="https://smarthr.co.in/demo/html/template/project-details.html"
                                                                    class="flex-shrink-0 me-2">
                                                                    <img src="https://smarthr.co.in/demo/html/template/assets/img/social/project-03.svg"
                                                                        alt="Img">
                                                                </a>
                                                                <div>
                                                                    <h6 class="mb-1"><a
                                                                            href="https://smarthr.co.in/demo/html/template/project-details.html">World
                                                                            Health</a></h6>
                                                                    <div class="d-flex align-items-center">
                                                                        <p class="mb-0 fs-13">8 tasks</p>
                                                                        <p class="fs-13"><span class="mx-1"><i
                                                                                    class="ti ti-point-filled text-primary"></i></span>15
                                                                            Completed</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div>
                                                                        <span class="mb-1 d-block">Deadline</span>
                                                                        <p class="text-dark">31 July 2025</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div>
                                                                        <span class="mb-1 d-block">Project Lead</span>
                                                                        <a href="#"
                                                                            class="fw-normal d-flex align-items-center">
                                                                            <img class="avatar avatar-sm rounded-circle me-2"
                                                                                src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg"
                                                                                alt="Img">
                                                                            Leona
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex">
                                                    <div class="card flex-fill mb-0">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center pb-3 mb-3 border-bottom">
                                                                <a href="https://smarthr.co.in/demo/html/template/project-details.html"
                                                                    class="flex-shrink-0 me-2">
                                                                    <img src="https://smarthr.co.in/demo/html/template/assets/img/social/project-01.svg"
                                                                        alt="Img">
                                                                </a>
                                                                <div>
                                                                    <h6 class="mb-1 text-truncate"><a
                                                                            href="https://smarthr.co.in/demo/html/template/project-details.html">Hospital
                                                                            Administration</a></h6>
                                                                    <div class="d-flex align-items-center">
                                                                        <p class="mb-0 fs-13">8 tasks</p>
                                                                        <p class="fs-13"><span class="mx-1"><i
                                                                                    class="ti ti-point-filled text-primary"></i></span>15
                                                                            Completed</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div>
                                                                        <span class="mb-1 d-block">Deadline</span>
                                                                        <p class="text-dark">31 July 2025</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div>
                                                                        <span class="mb-1 d-block">Project Lead</span>
                                                                        <a href="#"
                                                                            class="fw-normal d-flex align-items-center">
                                                                            <img class="avatar avatar-sm rounded-circle me-2"
                                                                                src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg"
                                                                                alt="Img">
                                                                            Leona
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="address2" role="tabpanel"
                                            aria-labelledby="address-tab2" tabindex="0">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <div class="card flex-fill">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8">
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="https://smarthr.co.in/demo/html/template/project-details.html"
                                                                            class="flex-shrink-0 me-2">
                                                                            <img src="https://smarthr.co.in/demo/html/template/assets/img/products/product-05.jpg"
                                                                                class="img-fluid rounded-circle"
                                                                                alt="img">
                                                                        </a>
                                                                        <div>
                                                                            <h6 class="mb-1"><a
                                                                                    href="https://smarthr.co.in/demo/html/template/project-details.html">Dell
                                                                                    Laptop - #343556656</a></h6>
                                                                            <div class="d-flex align-items-center">
                                                                                <p><span class="text-primary">AST - 001<i
                                                                                            class="ti ti-point-filled text-primary mx-1"></i></span>Assigned
                                                                                    on 22 Nov, 2022 10:32AM </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div>
                                                                        <span class="mb-1 d-block">Assigned by</span>
                                                                        <a href="#"
                                                                            class="fw-normal d-flex align-items-center">
                                                                            <img class="avatar avatar-sm rounded-circle me-2"
                                                                                src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg"
                                                                                alt="Img">
                                                                            Andrew Symon
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="dropdown ms-2">
                                                                        <a href="javascript:void(0);"
                                                                            class="d-inline-flex align-items-center"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            <i class="ti ti-dots-vertical"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                            <li>
                                                                                <a href="javascript:void(0);"
                                                                                    class="dropdown-item rounded-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#asset_info">View
                                                                                    Info</a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:void(0);"
                                                                                    class="dropdown-item rounded-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#refuse_msg">Raise
                                                                                    Issue </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex">
                                                    <div class="card flex-fill mb-0">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8">
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="https://smarthr.co.in/demo/html/template/project-details.html"
                                                                            class="flex-shrink-0 me-2">
                                                                            <img src="https://smarthr.co.in/demo/html/template/assets/img/products/product-06.jpg"
                                                                                class="img-fluid rounded-circle"
                                                                                alt="img">
                                                                        </a>
                                                                        <div>
                                                                            <h6 class="mb-1"><a
                                                                                    href="https://smarthr.co.in/demo/html/template/project-details.html">Bluetooth
                                                                                    Mouse - #478878</a></h6>
                                                                            <div class="d-flex align-items-center">
                                                                                <p><span class="text-primary">AST - 001<i
                                                                                            class="ti ti-point-filled text-primary mx-1"></i></span>Assigned
                                                                                    on 22 Nov, 2022 10:32AM </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div>
                                                                        <span class="mb-1 d-block">Assigned by</span>
                                                                        <a href="#"
                                                                            class="fw-normal d-flex align-items-center">
                                                                            <img class="avatar avatar-sm rounded-circle me-2"
                                                                                src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg"
                                                                                alt="Img">
                                                                            Andrew Symon
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="dropdown ms-2">
                                                                        <a href="javascript:void(0);"
                                                                            class="d-inline-flex align-items-center"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            <i class="ti ti-dots-vertical"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                                                            <li>
                                                                                <a href="javascript:void(0);"
                                                                                    class="dropdown-item rounded-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#asset_info">View
                                                                                    Info</a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:void(0);"
                                                                                    class="dropdown-item rounded-1"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#refuse_msg">Raise
                                                                                    Issue </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $isEdit = isset($user->employeeDetail);
            $detail = $user->employeeDetail ?? null;
        @endphp

        <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form
                    action="{{ $isEdit ? route('employee_detail.update', $user->id) : route('employee-details.store') }}"
                    method="POST" class="modal-content border-0 shadow-lg rounded-4" id="employeeDetailForm">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="modal-title fs-5 fw-bold text-dark" id="employeeDetailModalLabel">
                            <i
                                class="ri-file-user-line me-2 text-primary"></i>{{ $isEdit ? 'Modifier le Détail RH' : 'Ajouter un Détail RH' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="matricule" class="form-label text-muted">Matricule</label>
                                <input type="text" id="matricule" name="matricule"
                                    class="form-control form-control-lg rounded-3" required
                                    value="{{ old('matricule', $detail->matricule ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="salaire" class="form-label text-muted">Salaire</label>
                                <input type="number" id="salaire" name="salaire" step="0.01"
                                    class="form-control form-control-lg rounded-3" required
                                    value="{{ old('salaire', $detail->salaire ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="type_contrat" class="form-label text-muted">Type de contrat</label>
                                <select id="type_contrat" name="type_contrat"
                                    class="form-select form-select-lg rounded-3" required>
                                    @foreach (['CDI', 'CDD', 'Stage', 'Freelance'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('type_contrat', $detail->type_contrat ?? '') === $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="adresse" class="form-label text-muted">Adresse</label>
                                <input type="text" id="adresse" name="adresse"
                                    class="form-control form-control-lg rounded-3"
                                    value="{{ old('adresse', $detail->adresse ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label for="description_poste" class="form-label text-muted">Description du poste</label>
                                <textarea id="description_poste" name="description_poste" class="form-control rounded-3" rows="3">{{ old('description_poste', $detail->description_poste ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="date_naissance" class="form-label text-muted">Date de naissance</label>
                                <input type="date" id="date_naissance" name="date_naissance"
                                    class="form-control form-control-lg rounded-3" required
                                    value="{{ old('date_naissance', $detail->date_naissance ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="genre" class="form-label text-muted">Genre</label>
                                <select id="genre" name="genre" class="form-select form-select-lg rounded-3">
                                    <option value="">-- Sélectionnez --</option>
                                    <option value="masculin"
                                        {{ old('genre', $detail->genre ?? '') == 'masculin' ? 'selected' : '' }}>Masculin
                                    </option>
                                    <option value="feminin"
                                        {{ old('genre', $detail->genre ?? '') == 'feminin' ? 'selected' : '' }}>Féminin
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_debut" class="form-label text-muted">Date début contrat</label>
                                <input type="date" id="date_debut" name="date_debut"
                                    class="form-control form-control-lg rounded-3" required
                                    value="{{ old('date_debut', $detail->date_debut ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="date_fin" class="form-label text-muted">Date fin contrat</label>
                                <input type="date" id="date_fin" name="date_fin"
                                    class="form-control form-control-lg rounded-3"
                                    value="{{ old('date_fin', $detail->date_fin ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-between p-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="ri-save-line me-1"></i>{{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- Modal ajout document --}}
        <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('employee.document.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content border-0 shadow-lg rounded-4" id="addDocumentForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="modal-title fs-5 fw-bold text-dark" id="addDocumentModalLabel">
                            <i class="ri-add-circle-line me-2 text-primary"></i>Ajouter un Document
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="type_document" class="form-label text-muted">Nom du document</label>
                            <input type="text" id="type_document" name="type_document"
                                class="form-control form-control-lg rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label for="document" class="form-label text-muted">Fichier</label>
                            <input type="file" id="document" name="document"
                                class="form-control form-control-lg rounded-3" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-between p-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="ri-upload-cloud-line me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal ajout ressorce --}}
        <div class="modal fade" id="addRessourceModal" tabindex="-1" aria-labelledby="addDocumentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('employee.ressource.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content border-0 shadow-lg rounded-4" id="addDocumentForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="modal-title fs-5 fw-bold text-dark" id="addDocumentModalLabel">
                            <i class="ri-add-circle-line me-2 text-primary"></i>Ajouter une ressource
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="nom" class="form-label text-muted">Nom du ressource</label>
                            <input type="text" id="nom" name="nom"
                                class="form-control form-control-lg rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label for="categorie" class="form-label text-muted">Type de contrat</label>
                            <select id="categorie" name="categorie" class="form-select form-select-lg rounded-3"
                                required>
                                <option value="autres">" autres "</option>
                                <option value="autres">" materiel "</option>
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-muted">description</label>
                            <input type="text" id="description" name="description"
                                class="form-control form-control-lg rounded-3" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-between p-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="ri-upload-cloud-line me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="bankInfoModal" tabindex="-1" aria-labelledby="bankInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
<form action="{{ route('employee-details.bank.store', $user->id) }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="bankInfoModalLabel">Informations bancaires de {{ $user->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
    </div>

    <div class="modal-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="banque_nom" class="form-label">Nom de la banque</label>
                <input type="text" class="form-control" name="banque_nom"
                    value="{{ $user->employeeDetail->banque_nom ?? '' }}">
            </div>

            <div class="col-md-6">
                <label for="nom_titulaire" class="form-label">Titulaire du compte</label>
                <input type="text" class="form-control" name="nom_titulaire"
                    value="{{ $user->employeeDetail->nom_titulaire ?? '' }}">
            </div>

            <div class="col-md-6">
                <label for="numero_compte" class="form-label">Numéro de compte</label>
                <input type="text" class="form-control" name="numero_compte"
                    value="{{ $user->employeeDetail->numero_compte ?? '' }}">
            </div>

            <div class="col-md-6">
                <label for="type_compte" class="form-label">Type de compte</label>
                <select name="type_compte" class="form-select">
                    <option value="">-- Sélectionnez --</option>
                    <option value="courant"
                        {{ ($user->employeeDetail->type_compte ?? '') == 'courant' ? 'selected' : '' }}>
                        Compte courant</option>
                    <option value="épargne"
                        {{ ($user->employeeDetail->type_compte ?? '') == 'épargne' ? 'selected' : '' }}>
                        Compte épargne</option>
                    <option value="autre"
                        {{ ($user->employeeDetail->type_compte ?? '') == 'autre' ? 'selected' : '' }}>
                        Autre</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" class="form-control" name="iban"
                    value="{{ $user->employeeDetail->iban ?? '' }}">
            </div>

            <div class="col-md-6">
                <label for="bic_swift" class="form-label">BIC / SWIFT</label>
                <input type="text" class="form-control" name="bic_swift"
                    value="{{ $user->employeeDetail->bic_swift ?? '' }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
</form>

                </div>
            </div>
        </div>

    @endsection
