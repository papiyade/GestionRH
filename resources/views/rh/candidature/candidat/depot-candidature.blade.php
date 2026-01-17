<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postuler à l'offre : {{ $offre->titre ?? 'Offre d\'emploi' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
            --primary-color: #AE3D7D;
            --primary-dark: #861254FF;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        /* Navbar avec gradient */
        .navbar-gradient {
            background: var(--primary-gradient);
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.2);
        }

        .navbar-gradient .navbar-brand,
        .navbar-gradient .nav-link {
            color: white !important;
            font-weight: 600;
        }

        .navbar-gradient .nav-link {
            opacity: 0.9;
        }

        /* En-tête de l'offre */
        .offer-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .offer-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--primary-gradient);
        }

        .icon-wrapper {
            background: linear-gradient(135deg, rgba(174, 61, 125, 0.1) 0%, rgba(134, 18, 84, 0.1) 100%);
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-wrapper i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .offer-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.75rem;
        }

        .badge-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge-light-custom {
            background: #f8f9fa;
            color: #495057;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Progression */
        .progress-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .progress-step {
            width: 2.5rem;
            height: 2.5rem;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #6c757d;
            transition: all 0.4s ease;
            position: relative;
            z-index: 2;
        }

        .progress-step.active {
            background: var(--primary-gradient);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
        }

        .progress-line {
            height: 3px;
            background: #e9ecef;
            flex-grow: 1;
            position: relative;
            margin: 0 -1px;
        }

        .progress-line.active {
            background: var(--primary-gradient);
        }

        .step-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .step-label.active {
            color: var(--primary-color);
        }

        /* Cartes de formulaire */
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: none;
        }

        .form-card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-card-header i {
            font-size: 1.5rem;
        }

        .form-card-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .form-card-body {
            padding: 2rem;
        }

        /* Champs de formulaire */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(174, 61, 125, 0.15);
        }

        .form-control-lg {
            padding: 0.875rem 1.25rem;
            font-size: 1.05rem;
        }

        /* Zone de dépôt de fichiers */
        .file-drop-zone {
            border: 3px dashed #d0d5dd;
            border-radius: 16px;
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            position: relative;
        }

        .file-drop-zone:hover {
            border-color: var(--primary-color);
            background: rgba(174, 61, 125, 0.05);
        }

        .file-drop-zone.drag-over {
            border-color: var(--primary-color);
            background: rgba(174, 61, 125, 0.1);
            transform: scale(1.02);
        }

        .file-drop-zone i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .file-drop-zone.primary i {
            color: var(--primary-color);
        }

        .file-drop-zone.success i {
            color: #28a745;
        }

        .file-preview {
            background: linear-gradient(135deg, rgba(174, 61, 125, 0.1) 0%, rgba(134, 18, 84, 0.1) 100%);
            border: 2px solid var(--primary-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-preview i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .file-preview .btn-close {
            opacity: 0.7;
        }

        .file-preview .btn-close:hover {
            opacity: 1;
        }

        /* Boutons */
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(174, 61, 125, 0.3);
            color: white;
        }

        .btn-outline-gradient {
            background: white;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-gradient:hover {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
            color: white;
        }

        /* Alerts */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-custom i {
            font-size: 1.25rem;
        }

        .alert-info-custom {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        /* Résumé */
        .resume-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .resume-section h6 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resume-section p {
            margin-bottom: 0.5rem;
            color: #495057;
            display: flex;
            align-items: start;
            gap: 0.5rem;
        }

        .resume-section i {
            color: var(--primary-color);
            margin-top: 0.25rem;
        }

        /* Checkbox personnalisé */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(174, 61, 125, 0.25);
        }

        .form-check-label {
            font-weight: 500;
            color: #495057;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-content {
            animation: slideIn 0.4s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .offer-header {
                padding: 1.5rem;
            }

            .offer-title {
                font-size: 1.375rem;
            }

            .form-card-body {
                padding: 1.5rem;
            }

            .progress-step {
                width: 2rem;
                height: 2rem;
                font-size: 0.875rem;
            }

            .step-label {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-gradient">
    <div class="container">
        <a href="javascript:history.back()" class="navbar-brand">
            <i class="ti ti-arrow-left me-2"></i>Retour aux offres
        </a>

        <div class="navbar-nav ms-auto">
            @if(isset($offre))
                <span class="nav-link">
                    <i class="ti ti-clock me-1"></i>{{ $offre->joursRestants }} jour{{ $offre->joursRestants > 1 ? 's' : '' }} restant{{ $offre->joursRestants > 1 ? 's' : '' }}
                </span>
            @endif
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <!-- En-tête de l'offre -->
            <div class="offer-header">
                <div class="d-flex align-items-start gap-3">
                    <div class="icon-wrapper">
                        <i class="ti ti-briefcase"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="offer-title">{{$offre->titre ?? 'Titre du poste'}}</h2>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge-custom">
                                <i class="ti ti-file-certificate me-1"></i>
                                {{$offre->type_contrat ?? 'Non spécifié'}}
                            </span>
                            <span class="badge-light-custom">
                                <i class="ti ti-currency-dollar me-1"></i>
                                {{$offre->salaire ?? 'Non spécifié'}} {{ $offre->devise ?? 'Fcfa' }}/{{ $offre->periode_salaire ?? '' }}
                            </span>
                            <span class="badge-light-custom">
                                <i class="ti ti-clock-hour-4 me-1"></i>
                                {{$offre->experience_requise ?? 'Non spécifié'}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barre de progression -->
            <div class="progress-container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-center" style="flex: 0 0 auto;">
                        <div class="progress-step active" id="progress-1">1</div>
                        <div class="step-label active">Informations</div>
                    </div>
                    <div class="progress-line" id="line-1"></div>
                    <div class="text-center" style="flex: 0 0 auto;">
                        <div class="progress-step" id="progress-2">2</div>
                        <div class="step-label">Documents</div>
                    </div>
                    <div class="progress-line" id="line-2"></div>
                    <div class="text-center" style="flex: 0 0 auto;">
                        <div class="progress-step" id="progress-3">3</div>
                        <div class="step-label">Confirmation</div>
                    </div>
                </div>
            </div>

            <form id="candidatureForm"
                class="needs-validation"
                novalidate
                method="POST"
                action="{{ route('candidatures.store', $offre->id ?? 'offre_id_placeholder') }}"
                enctype="multipart/form-data">
                @csrf

                <!-- Étape 1: Informations personnelles -->
                <div class="step-content" id="step1">
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="ti ti-user-circle"></i>
                            <h5>Vos informations personnelles</h5>
                        </div>
                        <div class="form-card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="ti ti-user"></i>
                                        Prénom *
                                    </label>
                                    <input type="text" class="form-control form-control-lg" name="prenom" placeholder="Votre prénom" required>
                                    <div class="invalid-feedback">Veuillez saisir votre prénom</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="ti ti-user"></i>
                                        Nom *
                                    </label>
                                    <input type="text" class="form-control form-control-lg" name="nom" placeholder="Votre nom" required>
                                    <div class="invalid-feedback">Veuillez saisir votre nom</div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">
                                        <i class="ti ti-mail"></i>
                                        Email *
                                    </label>
                                    <input type="email" class="form-control form-control-lg" name="email" placeholder="votre@email.com" required>
                                    <div class="invalid-feedback">Veuillez saisir un email valide</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">
                                        <i class="ti ti-phone"></i>
                                        Téléphone *
                                    </label>
                                    <input type="tel" class="form-control form-control-lg" name="telephone" placeholder="+221 XX XXX XX XX" required>
                                    <div class="invalid-feedback">Numéro requis</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">
                                        <i class="ti ti-brand-linkedin"></i>
                                        LinkedIn / Portfolio
                                    </label>
                                    <input type="url" class="form-control form-control-lg" name="linkedin" placeholder="https://linkedin.com/in/...">
                                    <small class="text-muted">Optionnel - Partagez votre profil professionnel</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn-gradient" onclick="nextStep()">
                                    Suivant <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2: Documents -->
                <div class="step-content d-none" id="step2">
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="ti ti-files"></i>
                            <h5>Vos documents</h5>
                        </div>
                        <div class="form-card-body">

                            <!-- CV -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="ti ti-file-cv"></i>
                                    CV * (PDF, DOC, DOCX - Max 5Mo)
                                </label>
                                <div class="file-drop-zone primary">
                                    <input type="file" class="d-none" id="cv-upload" name="cv" accept=".pdf,.doc,.docx" required>
                                    <i class="ti ti-cloud-upload"></i>
                                    <p class="mb-2"><strong>Glissez votre CV ici</strong> ou cliquez pour parcourir</p>
                                    <small class="text-muted">Formats acceptés: PDF, DOC, DOCX</small>
                                    <div id="cv-preview"></div>
                                </div>
                            </div>

                            <!-- Lettre de motivation -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="ti ti-mail-opened"></i>
                                    Lettre de motivation
                                </label>
                                <div class="file-drop-zone success">
                                    <input type="file" class="d-none" id="lettre-upload" name="lettre" accept=".pdf,.doc,.docx">
                                    <i class="ti ti-file-text"></i>
                                    <p class="mb-2"><strong>Glissez votre lettre ici</strong> ou cliquez pour parcourir</p>
                                    <small class="text-muted">Optionnel - PDF, DOC, DOCX</small>
                                    <div id="lettre-preview"></div>
                                </div>
                            </div>

                            <!-- Message de motivation -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="ti ti-message-2"></i>
                                    Message de motivation
                                </label>
                                <textarea class="form-control" rows="5" name="message" placeholder="Expliquez en quelques lignes pourquoi ce poste vous intéresse et ce que vous pouvez apporter à l'entreprise..."></textarea>
                                <small class="text-muted">
                                    <i class="ti ti-info-circle me-1"></i>
                                    Partagez votre motivation (optionnel mais recommandé)
                                </small>
                            </div>

                            <!-- Disponibilité et prétentions -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="ti ti-calendar-time"></i>
                                        Disponibilité
                                    </label>
                                    <select class="form-select form-select-lg" name="disponibilite">
                                        <option value="Immédiate">Immédiate</option>
                                        <option value="1 mois">1 mois</option>
                                        <option value="2 mois">2 mois</option>
                                        <option value="3 mois">3 mois</option>
                                        <option value="À négocier">À négocier</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="ti ti-currency-dollar"></i>
                                        Prétentions salariales
                                    </label>
                                    <input type="text" class="form-control form-control-lg" name="pretention" placeholder="Ex: 50k € ou À négocier">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn-outline-gradient" onclick="prevStep()">
                                    <i class="ti ti-arrow-left"></i> Précédent
                                </button>
                                <button type="button" class="btn-gradient" onclick="nextStep()">
                                    Suivant <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 3: Confirmation -->
                <div class="step-content d-none" id="step3">
                    <div class="form-card">
                        <div class="form-card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                            <i class="ti ti-circle-check"></i>
                            <h5>Confirmation de votre candidature</h5>
                        </div>
                        <div class="form-card-body">

                            <div class="alert-custom alert-info-custom mb-4">
                                <i class="ti ti-info-circle"></i>
                                <span>Vérifiez attentivement vos informations avant d'envoyer votre candidature</span>
                            </div>

                            <div id="resume-candidature"></div>

                            <div class="form-check mb-4 p-3" style="background: #f8f9fa; border-radius: 12px;">
                                <input class="form-check-input" type="checkbox" id="accepterConditions" required style="width: 1.25rem; height: 1.25rem;">
                                <label class="form-check-label ms-2" for="accepterConditions">
                                    <strong>J'accepte que mes données soient traitées dans le cadre de ma candidature *</strong>
                                    <br>
                                    <small class="text-muted">Vos informations seront utilisées uniquement pour traiter votre candidature</small>
                                </label>
                                <div class="invalid-feedback">Vous devez accepter les conditions pour postuler.</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn-outline-gradient" onclick="prevStep()">
                                    <i class="ti ti-arrow-left"></i> Précédent
                                </button>
                                <button type="submit" class="btn-success-custom">
                                    <i class="ti ti-send"></i> Envoyer ma candidature
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let currentStep = 1;
const totalSteps = 3;

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            document.getElementById(`step${currentStep}`).classList.add('d-none');
            currentStep++;
            document.getElementById(`step${currentStep}`).classList.remove('d-none');
            updateProgressIndicator();

            if (currentStep === 3) {
                generateResume();
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        document.getElementById(`step${currentStep}`).classList.add('d-none');
        currentStep--;
        document.getElementById(`step${currentStep}`).classList.remove('d-none');
        updateProgressIndicator();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function updateProgressIndicator() {
    for (let i = 1; i <= totalSteps; i++) {
        const step = document.getElementById(`progress-${i}`);
        const label = step.nextElementSibling;
        
        if (i < currentStep) {
            step.classList.add('active');
            step.innerHTML = '<i class="ti ti-check" style="font-size: 1.25rem;"></i>';
            label.classList.add('active');
        } else if (i === currentStep) {
            step.classList.add('active');
            step.textContent = i;
            label.classList.add('active');
        } else {
            step.classList.remove('active');
            step.textContent = i;
            label.classList.remove('active');
        }
    }

    for (let i = 1; i < totalSteps; i++) {
        const line = document.getElementById(`line-${i}`);
        if (i < currentStep) {
            line.classList.add('active');
        } else {
            line.classList.remove('active');
        }
    }
}

function validateCurrentStep() {
    const currentStepDiv = document.getElementById(`step${currentStep}`);
    const requiredFields = currentStepDiv.querySelectorAll('[required]:not(.d-none)');
    let isValid = true;

    requiredFields.forEach(field => {
        if (field.type === 'file') {
            if (field.files.length === 0) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (field.type === 'checkbox') {
            if (!field.checked) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        } else if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    });

    return isValid;
}

function setupFileUpload(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const dropZone = input.closest('.file-drop-zone');

    dropZone.addEventListener('click', () => input.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        if (e.dataTransfer.files.length > 0) {
            input.files = e.dataTransfer.files;
            displayFilePreview(input.files[0], preview);
        }
    });

    input.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            displayFilePreview(e.target.files[0], preview);
        } else {
            preview.innerHTML = '';
            input.classList.remove('is-valid');
            if (input.hasAttribute('required')) {
                input.classList.add('is-invalid');
            }
        }
    });
}

function displayFilePreview(file, previewDiv) {
    const size = (file.size / 1024 / 1024).toFixed(2);
    previewDiv.innerHTML = `
        <div class="file-preview">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-file-check"></i>
                <div>
                    <strong>${file.name}</strong>
                    <br>
                    <small class="text-muted">${size} Mo</small>
                </div>
            </div>
            <button type="button" class="btn-close" onclick="removeFilePreview(this, '${file.name}', '${previewDiv.id}')"></button>
        </div>
    `;
}

function removeFilePreview(closeButton, fileName, previewDivId) {
    closeButton.closest('.file-preview').remove();
    const inputId = previewDivId === 'cv-preview' ? 'cv-upload' : 'lettre-upload';
    const fileInput = document.getElementById(inputId);

    fileInput.value = '';

    if (fileInput.hasAttribute('required')) {
        fileInput.classList.remove('is-valid');
        fileInput.classList.add('is-invalid');
    }
}

function generateResume() {
    const form = document.getElementById('candidatureForm');
    const prenom = form.querySelector('[name="prenom"]').value;
    const nom = form.querySelector('[name="nom"]').value;
    const email = form.querySelector('[name="email"]').value;
    const telephone = form.querySelector('[name="telephone"]').value;
    const linkedin = form.querySelector('[name="linkedin"]').value;
    const cvFile = document.getElementById('cv-upload').files[0];
    const lettreFile = document.getElementById('lettre-upload').files[0];
    const message = form.querySelector('[name="message"]').value;
    const disponibilite = form.querySelector('[name="disponibilite"]').value;
    const pretention = form.querySelector('[name="pretention"]').value;

    const resume = document.getElementById('resume-candidature');
    resume.innerHTML = `
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="resume-section">
                    <h6><i class="ti ti-user-circle"></i> Informations personnelles</h6>
                    <p><i class="ti ti-user"></i> <span>${prenom} ${nom}</span></p>
                    <p><i class="ti ti-mail"></i> <span>${email}</span></p>
                    <p><i class="ti ti-phone"></i> <span>${telephone}</span></p>
                    ${linkedin ? `<p><i class="ti ti-brand-linkedin"></i> <span><a href="${linkedin}" target="_blank" style="color: var(--primary-color);">${linkedin}</a></span></p>` : ''}
                </div>
            </div>
            <div class="col-md-6">
                <div class="resume-section">
                    <h6><i class="ti ti-files"></i> Documents et Disponibilité</h6>
                    <p><i class="ti ti-file-check"></i> <span>CV: ${cvFile ? cvFile.name : 'Non attaché'}</span></p>
                    ${lettreFile ? `<p><i class="ti ti-file-text"></i> <span>Lettre: ${lettreFile.name}</span></p>` : ''}
                    <p><i class="ti ti-calendar-time"></i> <span>Disponibilité: ${disponibilite}</span></p>
                    <p><i class="ti ti-currency-dollar"></i> <span>Prétentions: ${pretention || 'Non spécifié'}</span></p>
                </div>
            </div>
            ${message ? `
            <div class="col-12">
                <div class="resume-section">
                    <h6><i class="ti ti-message-2"></i> Message de motivation</h6>
                    <p style="display: block;">${message}</p>
                </div>
            </div>
            ` : ''}
        </div>
    `;
}

document.getElementById('candidatureForm').addEventListener('submit', function(e) {
    const accepterConditionsCheckbox = document.getElementById('accepterConditions');
    if (!accepterConditionsCheckbox.checked) {
        e.preventDefault();
        accepterConditionsCheckbox.classList.add('is-invalid');
        return;
    } else {
        accepterConditionsCheckbox.classList.remove('is-invalid');
        accepterConditionsCheckbox.classList.add('is-valid');
    }

    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="ti ti-loader-2" style="animation: spin 1s linear infinite;"></i> Envoi en cours...';
    submitBtn.disabled = true;
});

document.addEventListener('DOMContentLoaded', () => {
    setupFileUpload('cv-upload', 'cv-preview');
    setupFileUpload('lettre-upload', 'lettre-preview');
    updateProgressIndicator();
});
</script>