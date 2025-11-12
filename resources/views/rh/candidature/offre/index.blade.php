@extends('layout.admin_rh')

@section('title', 'RH - Offre d emploi')
@section('page-title', 'Gestion des offres')
@section('content')

				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Offres d'emploi</h2>
						<nav>
							<ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									RH
								</li>
								<li class="breadcrumb-item active" aria-current="page">Offres d'emploi</li>
							</ol>
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">

						<div class="mb-2">
							<a href="#" data-bs-toggle="modal" data-bs-target="#createJobOfferModal" id="addJobOfferBtn" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Nouvelle offre</a>
						</div>
						<div class="head-icons ms-2">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Breadcrumb -->

				<div class="card">
					<div class="card-body p-3">
						<div class="d-flex align-items-center justify-content-between">
							<h5>Toutes les offres</h5>
                            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                        Statut
                                    </a>
                                    <ul class="dropdown-menu  dropdown-menu-end p-3">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1">En cours</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Cloturée</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Annulée</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
						</div>
					</div>
				</div>

                <div class="row row-cols-1 row-cols-md-3 g-4 mb-2" id="job-offer-list">
                    @forelse($offres as $offre)
                        <div class="col" id="job-card-{{ $offre->id }}">
                            <div class="card shadow-sm h-100 border-0" style="background: linear-gradient(135deg, #fff7e6 0%, #ffe5d0 100%);">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-md avatar-rounded bg-orange me-3">
                                            <i class="ti ti-briefcase fs-20 text-black"></i>
                                        </span>
                                        <div>
                                            <h5 class="mb-1 text-orange">{{ $offre->titre }}</h5>
                                            <span class="badge {{ match($offre->type_contrat) {
                                                'CDI' => 'bg-primary',
                                                'CDD' => 'bg-warning text-dark',
                                                'Stage' => 'bg-success',
                                                'Alternance' => 'bg-info',
                                                'Freelance' => 'bg-secondary',
                                                default => 'bg-secondary'
                                            } }}">{{ $offre->type_contrat }}</span>
                                        </div>
                                    </div>
                                    <p class="mb-2 text-muted"><i class="ti ti-users me-1 text-orange"></i>Équipe {{ $offre->equipe }}</p>
                                    <p class="mb-2 text-muted"><i class="ti ti-file-description me-1 text-orange"></i>{{ Str::limit($offre->description, 80) }}</p>
                                    <p class="mb-2 text-muted"><i class="ti ti-calendar-time me-1 text-orange"></i>Fin de dépôt : <strong>{{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}</strong></p>
                                    <div class="mt-auto d-flex align-items-center gap-2">
                                        <select class="form-select form-select-sm w-auto border-orange bg-primary text-white" style="min-width:110px" onchange="updateJobStatus({{ $offre->id }}, this.value)">
                                            <option class="bg-light" value="En cours" {{ $offre->statut === "En cours" ? "selected" : "" }}>En cours</option>
                                            <option class="bg-light" value="Clôturé" {{ $offre->statut === "Clôturé" ? "selected" : "" }}>Clôturé</option>
                                            <option class="bg-light" value="Annulé" {{ $offre->statut === "Annulé" ? "selected" : "" }}>Annulé</option>
                                        </select>
                                        <button class="btn btn-icon btn-outline-orange btn-sm" onclick="editJobOffer({{ $offre->id }})" title="Modifier">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-icon btn-outline-danger btn-sm" onclick="deleteJobOffer({{ $offre->id }})" title="Supprimer">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted text-center">Aucune offre d'emploi trouvée.</p>
                        </div>
                    @endforelse
                </div>

                <div class="row g-0 justify-content-end mb-4" id="pagination-element">
                    <div class="col-sm-6">
                        <nav>
                            <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                            </ul>
                        </nav>
                    </div>
                </div>
		{{-- <div class="modal fade" id="add_post">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Post Job</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<form id="createJobOfferForm" class="needs-validation" method="POST" action="{{ route('offres.store') }}" novalidate>
                        @csrf
						<div class="modal-body pb-0">
							<div class="row">
                                <div class="contact-grids-tab pt-0">
                                    <ul class="nav nav-underline" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                          <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-selected="true">Basic Information</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                          <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-selected="false">Location</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="info-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">                                                
                                                    <div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                        <img src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-30.jpg" alt="img" class="rounded-circle">
                                                    </div>                                              
                                                    <div class="profile-upload">
                                                        <div class="mb-2">
                                                            <h6 class="mb-1">Upload Profile Image</h6>
                                                            <p class="fs-12">Image should be below 4 mb</p>
                                                        </div>
                                                        <div class="profile-uploader d-flex align-items-center">
                                                            <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                                                Upload
                                                                <input type="file" class="form-control image-sign" multiple="">
                                                            </div>
                                                            <a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Titre du poste <span class="text-danger"> *</span></label>
                                                    <input type="text" name="jobTitle" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Description du poste<span class="text-danger"> *</span></label>
                                                    <textarea name="jobDescription" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Job Category <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>IOS</option>
                                                        <option>Web & Application</option>
                                                        <option>Networking</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Job Type <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Full Time</option>
                                                        <option>Part Time</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Job Level <span class="text-danger"> *</span></label>
                                                    <select class="select">
														<option>Select</option>
                                                        <option>Team Lead</option>
                                                        <option>Manager</option>
														<option>Senior</option>
														<option>junior</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Experience <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Entry Level</option>
                                                        <option>Mid Level</option>
                                                        <option>Expert</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Qualification <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Bachelore Degree</option>
                                                        <option>Master Degree</option>
                                                        <option>Others</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Gender <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Min. Sallary <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>10k - 15k</option>
                                                        <option>15k -20k</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Max. Sallary <span class="text-danger"> *</span></label>
                                                    <select class="select">
                                                        <option>Select</option>
                                                        <option>40k - 50k</option>
                                                        <option>50k - 60k</option>
                                                    </select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 ">
                                                    <label class="form-label">Job Expired Date <span class="text-danger"> *</span></label>
                                                    <div class="input-icon-end position-relative">
														<input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
														<span class="input-icon-addon">
															<i class="ti ti-calendar text-gray-7"></i>
														</span>
													</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Required Skills</label>
                                                    <input type="text" class="form-control">
                                                </div>									
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#success_modal">Save & Next</button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Address <span class="text-danger"> *</span></label>
                                                    <input type="text" class="form-control">
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
													<label class="form-label">Country <span class="text-danger"> *</span></label>
													<select class="select">
														<option>Select</option>
														<option>USA</option>
														<option>Canada</option>
														<option>Germany</option>
														<option>France</option>
													</select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">State <span class="text-danger"> *</span></label>
                                                    <select class="select">
														<option>Select</option>
														<option>California</option>
														<option>New York</option>
														<option>Texas</option>
														<option>Florida</option>
													</select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
													<label class="form-label">City <span class="text-danger"> *</span></label>
                                                    <select class="select">
														<option>Select</option>
														<option>Los Angeles</option>
														<option>San Diego</option>
														<option>Fresno</option>
														<option>San Francisco</option>
													</select>
                                                </div>									
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Zip Code <span class="text-danger"> *</span></label>
                                                    <input type="text" class="form-control">
                                                </div>									
                                            </div>
                                            <div class="col-md-12">
                                                <div class="map-grid mb-3">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6509170.989457427!2d-123.80081967108484!3d37.192957227641294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb9fe5f285e3d%3A0x8b5109a227086f55!2sCalifornia%2C%20USA!5e0!3m2!1sen!2sin!4v1669181581381!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-100"></iframe>
                                                </div>									
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#success_modal">Post</button>
                                        </div>
                                    </div>
                                </div>								
							</div>
						</div>						
					</form>
				</div>
			</div>
		</div> --}}
        <div class="modal fade" id="createJobOfferModal" tabindex="-1" aria-labelledby="createJobOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="createJobOfferModalLabel"><i class="ri-briefcase-line me-2"></i> Offre d'Emploi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <strong>Oups!</strong> Il y a eu des problèmes avec votre soumission.
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="createJobOfferForm" class="needs-validation" method="POST" action="{{ route('offres.store') }}" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="jobTitle" class="form-label fw-semibold">Titre du Poste <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jobTitle') is-invalid @enderror" id="jobTitle" name="jobTitle" value="{{ old('jobTitle') }}" required placeholder="Ex: Développeur Full Stack Senior">
                            <div class="invalid-feedback">Veuillez saisir le titre du poste.</div>
                            @error('jobTitle')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jobTeam" class="form-label fw-semibold">Équipe / Département <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jobTeam') is-invalid @enderror" id="jobTeam" name="jobTeam" value="{{ old('jobTeam') }}" required placeholder="Ex: Web, RH, Marketing...">
                            <div class="invalid-feedback">Veuillez saisir l'équipe/département.</div>
                            @error('jobTeam')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jobSector" class="form-label fw-semibold">Secteur d'Activité</label>
                            <select class="form-select @error('jobSector') is-invalid @enderror" id="jobSector" name="jobSector">
                                <option value="">Sélectionner un secteur...</option>
                                <option value="Informatique" {{ old('jobSector') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                <option value="Finance" {{ old('jobSector') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Droit" {{ old('jobSector') == 'Droit' ? 'selected' : '' }}>Droit</option>
                                <option value="Bâtiment" {{ old('jobSector') == 'Bâtiment' ? 'selected' : '' }}>Bâtiment</option>
                                <option value="Sport" {{ old('jobSector') == 'Sport' ? 'selected' : '' }}>Sport</option>
                                <option value="Marketing" {{ old('jobSector') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Communication" {{ old('jobSector') == 'Communication' ? 'selected' : '' }}>Communication</option>
                            </select>
                            @error('jobSector')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="jobDescription" class="form-label fw-semibold">Description du Poste <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('jobDescription') is-invalid @enderror" id="jobDescription" name="jobDescription" rows="5" required placeholder="Détails des responsabilités, missions, compétences requises...">{{ old('jobDescription') }}</textarea>
                            <div class="invalid-feedback">Veuillez saisir une description du poste.</div>
                            @error('jobDescription')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contractType" class="form-label fw-semibold">Type de Contrat <span class="text-danger">*</span></label>
                            <select class="form-select @error('contractType') is-invalid @enderror" id="contractType" name="contractType" required>
                                <option value="">Sélectionner...</option>
                                <option value="CDI" {{ old('contractType') == 'CDI' ? 'selected' : '' }}>CDI (Contrat à Durée Indéterminée)</option>
                                <option value="CDD" {{ old('contractType') == 'CDD' ? 'selected' : '' }}>CDD (Contrat à Durée Déterminée)</option>
                                <option value="Stage" {{ old('contractType') == 'Stage' ? 'selected' : '' }}>Stage</option>
                                <option value="Alternance" {{ old('contractType') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                <option value="Freelance" {{ old('contractType') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                            <div class="invalid-feedback">Veuillez sélectionner un type de contrat.</div>
                            @error('contractType')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="applicationDeadline" class="form-label fw-semibold">Date Limite de Candidature <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('applicationDeadline') is-invalid @enderror" id="applicationDeadline" name="applicationDeadline" value="{{ old('applicationDeadline') }}" required>
                            <div class="invalid-feedback">Veuillez saisir la date limite.</div>
                            @error('applicationDeadline')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salaryAmount" class="form-label fw-semibold">Salaire (Optionnel)</label>
                            <input type="number" class="form-control @error('salaryAmount') is-invalid @enderror" id="salaryAmount" name="salaryAmount" value="{{ old('salaryAmount') }}" placeholder="Ex: 500000">
                            @error('salaryAmount')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salaryCurrency" class="form-label fw-semibold">Devise</label>
                            <select class="form-select @error('salaryCurrency') is-invalid @enderror" id="salaryCurrency" name="salaryCurrency">
                                <option value="XOF" {{ old('salaryCurrency') == 'XOF' ? 'selected' : '' }}>XOF (CFA)</option>
                                <option value="EUR" {{ old('salaryCurrency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="USD" {{ old('salaryCurrency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="CAD" {{ old('salaryCurrency') == 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                                <option value="GBP" {{ old('salaryCurrency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="" {{ old('salaryCurrency') == '' ? 'selected' : '' }}>Non spécifié</option>
                            </select>
                            @error('salaryCurrency')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salaryPeriod" class="form-label fw-semibold">Période Salariale</label>
                            <select class="form-select @error('salaryPeriod') is-invalid @enderror" id="salaryPeriod" name="salaryPeriod">
                                <option value="monthly" {{ old('salaryPeriod') == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                                <option value="annual" {{ old('salaryPeriod') == 'annual' ? 'selected' : '' }}>Annuel</option>
                                <option value="" {{ old('salaryPeriod') == '' ? 'selected' : '' }}>Non spécifié</option>
                            </select>
                            @error('salaryPeriod')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="experienceRequired" class="form-label fw-semibold">Expérience Requise <span class="text-danger">*</span></label>
                            <select class="form-select @error('experienceRequired') is-invalid @enderror" id="experienceRequired" name="experienceRequired" required>
                                <option value="">Sélectionner...</option>
                                <option value="Non spécifiée" {{ old('experienceRequired') == 'Non spécifiée' ? 'selected' : '' }}>Non spécifiée</option>
                                <option value="Moins de 1 an" {{ old('experienceRequired') == 'Moins de 1 an' ? 'selected' : '' }}>Moins de 1 an</option>
                                <option value="1-3 ans" {{ old('experienceRequired') == '1-3 ans' ? 'selected' : '' }}>1-3 ans</option>
                                <option value="3-5 ans" {{ old('experienceRequired') == '3-5 ans' ? 'selected' : '' }}>3-5 ans</option>
                                <option value="Plus de 5 ans" {{ old('experienceRequired') == 'Plus de 5 ans' ? 'selected' : '' }}>Plus de 5 ans</option>
                            </select>
                            <div class="invalid-feedback">Veuillez spécifier l'expérience requise.</div>
                            @error('experienceRequired')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jobStatus" class="form-label fw-semibold">Statut de l'Offre <span class="text-danger">*</span></label>
                            <select class="form-select @error('jobStatus') is-invalid @enderror" id="jobStatus" name="jobStatus" required>
                                <option value="En cours" {{ old('jobStatus') == 'En cours' ? 'selected' : '' }}>En cours</option>
                                <option value="Clôturé" {{ old('jobStatus') == 'Clôturé' ? 'selected' : '' }}>Clôturé</option>
                                <option value="Annulé" {{ old('jobStatus') == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                            <div class="invalid-feedback">Veuillez sélectionner un statut.</div>
                            @error('jobStatus')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input @error('remoteOption') is-invalid @enderror" type="checkbox" id="remoteOption" name="remoteOption" value="1" {{ old('remoteOption') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remoteOption">
                                    Télétravail possible
                                </label>
                                @error('remoteOption')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4"><i class="ri-save-line me-2"></i> Enregistrer l'Offre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
		<!-- /Post Job -->

@endsection