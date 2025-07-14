@extends('layouts.admin_entreprise')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            {{-- Header avec animation --}}
            <div class="text-center mb-5">
                <div class="position-relative">
                    <div class="creation-icon mb-3">
                        <i class="fas fa-building display-4 text-primary"></i>
                        <div class="icon-pulse"></div> {{-- Animation visuelle --}}
                    </div>
                    <h1 class="display-5 fw-bold text-gradient mb-2">Création de votre entreprise</h1>
                    <p class="lead text-muted">Construisons ensemble votre présence professionnelle</p>
                </div>
            </div>

            {{-- Progress bar moderne --}}
            <div class="progress-container mb-5">
                <div class="progress-track">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
                <div class="progress-steps">
                    <div class="progress-step active" data-step="1">
                        <div class="step-circle">
                            <i class="fas fa-image"></i>
                        </div>
                        <span class="step-label">Identité</span>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="step-circle">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <span class="step-label">Contact</span>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="step-circle">
                            <i class="fas fa-edit"></i>
                        </div>
                        <span class="step-label">Description</span>
                    </div>
                </div>
            </div>

            {{-- Card principale avec glassmorphism --}}
            <div class="form-card">
                <div class="card-glow"></div> {{-- Effet visuel --}}

                {{-- Affichage des erreurs avec style moderne --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-modern">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <h6 class="alert-title mb-2">Veuillez corriger les erreurs suivantes :</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Formulaire --}}
                <form id="step-form" action="{{ route('entreprise.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Étape 1: Identité --}}
                    <div class="step step-active" id="step1">
                        <div class="step-header mb-4">
                            <h3 class="step-title">
                                <i class="fas fa-image text-primary me-2"></i>
                                Identité de votre entreprise
                            </h3>
                            <p class="step-subtitle">Commençons par l'essentiel : votre logo et votre nom</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">
                                <i class="fas fa-camera me-2"></i>
                                Logo de l'entreprise
                                <span class="optional">(optionnel)</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" class="file-input" id="logo_path" name="logo_path" accept="image/*">
                                <div class="file-upload-area" id="file-upload-area">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="upload-text">
                                        <span class="upload-main">Glissez votre logo ici</span>
                                        <span class="upload-sub">ou cliquez pour parcourir</span>
                                    </div>
                                </div>
                                <div class="file-preview d-none" id="file-preview">
                                    <img id="preview-image" alt="Aperçu du logo">
                                    <button type="button" class="btn-remove-file" id="remove-file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="entreprise_name" class="form-label-modern">
                                <i class="fas fa-building me-2"></i>
                                Nom de l'entreprise
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-modern">
                                <input type="text" class="form-control-modern" id="entreprise_name" 
                                       name="entreprise_name" value="{{ old('entreprise_name') }}" 
                                       placeholder="Ex: Ma Super Entreprise" required>
                                <div class="input-focus-ring"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Étape 2: Informations de contact --}}
                    <div class="step" id="step2">
                        <div class="step-header mb-4">
                            <h3 class="step-title">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                Informations de contact
                            </h3>
                            <p class="step-subtitle">Où peut-on vous trouver ?</p>
                        </div>

                        <div class="mb-4">
                            <label for="adresse" class="form-label-modern">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Adresse complète
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-modern">
                                <input type="text" class="form-control-modern" id="adresse" 
                                       name="adresse" value="{{ old('adresse') }}" 
                                       placeholder="123 Rue de la Paix, 75001 Paris" >
                                <div class="input-focus-ring"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label-modern">
                                <i class="fas fa-envelope me-2"></i>
                                Adresse email professionnelle
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-modern">
                                <input type="email" class="form-control-modern" id="email" 
                                       name="email" value="{{ old('email') }}" 
                                       placeholder="contact@monentreprise.com" required>
                                <div class="input-focus-ring"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Étape 3: Description --}}
                    <div class="step" id="step3">
                        <div class="step-header mb-4">
                            <h3 class="step-title">
                                <i class="fas fa-edit text-primary me-2"></i>
                                Décrivez votre entreprise
                            </h3>
                            <p class="step-subtitle">Parlez-nous de votre activité et de vos valeurs</p>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label-modern">
                                <i class="fas fa-align-left me-2"></i>
                                Description de l'entreprise
                                <span class=""></span>
                            </label>
                            <div class="input-group-modern">
                                <textarea class="form-control-modern textarea-modern" id="description" 
                                          name="description" rows="6"
                                          placeholder="Décrivez votre entreprise, ses activités, sa mission..." >{{ old('description') }}</textarea>
                                <div class="input-focus-ring"></div>
                            </div>
                            <div class="char-counter">
                                <span id="char-count">0</span> caractères
                            </div>
                        </div>
                    </div>

                    {{-- Navigation moderne --}}
                    <div class="form-navigation">
                        <button type="button" class="btn-navigation btn-prev" id="prevBtn" disabled>
                            <i class="fas fa-arrow-left me-2"></i>
                            Précédent
                        </button>
                        <button type="button" class="btn-navigation btn-next" id="nextBtn">
                            <span class="btn-text">
                                Suivant
                                <i class="fas fa-arrow-right ms-2"></i>
                            </span>
                            <div class="btn-ripple"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles pour la card principale */
    .form-card {
        background-color: rgba(255, 255, 255, 0.8); /* Effet glassmorphism */
        backdrop-filter: blur(10px); /* Pour le flou derrière */
        border-radius: 1.5rem; /* Coins plus arrondis */
        padding: 3rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.6s ease-out; /* Animation d'entrée */
        opacity: 0;
        transform: translateY(20px);
    }
    .card-glow { /* Effet de lueur subtile */
        position: absolute;
        top: -50px;
        left: -50px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.3), transparent 70%);
        border-radius: 50%;
        filter: blur(30px);
        animation: glow-move 8s infinite alternate;
        z-index: -1;
    }
    @keyframes glow-move {
        0% { transform: translate(0, 0); }
        50% { transform: translate(calc(100% + 50px), calc(100% + 50px)); }
        100% { transform: translate(0, 0); }
    }

    /* Styles pour le header avec animation */
    .creation-icon {
        position: relative;
        display: inline-block;
    }
    .creation-icon .fa-building {
        color: #667eea; /* Couleur principale */
    }
    .icon-pulse {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        background-color: #667eea;
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        opacity: 0;
        animation: pulse 2s infinite ease-out;
        z-index: -1;
    }
    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0.7; }
        100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
    }
    .text-gradient {
        background: linear-gradient(45deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Progress bar moderne */
    .progress-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        margin-bottom: 3rem;
    }
    .progress-track {
        width: 90%; /* Légèrement plus court */
        height: 6px;
        background-color: #e0e0e0;
        border-radius: 3px;
        overflow: hidden;
        position: relative;
    }
    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(to right, #667eea, #764ba2); /* Dégradé de couleur */
        border-radius: 3px;
        transition: width 0.4s ease-in-out;
    }
    .progress-steps {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: -1.5rem; /* Remonte les cercles sur la barre */
    }
    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        z-index: 1;
        cursor: pointer; /* Indique que les étapes sont cliquables (si on voulait ajouter cette fonction) */
    }
    .step-circle {
        width: 38px;
        height: 38px;
        background-color: #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1rem;
        border: 3px solid #fff; /* Bordure blanche pour le contraste */
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Transition plus douce */
    }
    .step-label {
        margin-top: 1rem;
        font-size: 0.85rem;
        color: #6c757d;
        text-align: center;
        transition: color 0.3s ease;
        white-space: nowrap; /* Empêche le retour à la ligne */
    }
    .progress-step.active .step-circle {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border-color: #fff;
        color: #fff;
        transform: scale(1.15);
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
    }
    .progress-step.active .step-label {
        color: #667eea;
        font-weight: bold;
    }
    .progress-step.completed .step-circle {
        background: #28a745; /* Vert pour complété */
        border-color: #fff;
        color: #fff;
        box-shadow: 0 2px 5px rgba(40, 167, 69, 0.4);
    }
    .progress-step.completed .step-label {
        color: #28a745;
    }

    /* Styles des étapes du formulaire */
    .step {
        display: none;
        animation: fadeIn 0.6s ease-out; /* Animation plus longue */
    }
    .step.step-active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .step-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .step-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #343a40;
    }
    .step-subtitle {
        font-size: 1rem;
        color: #6c757d;
    }

    /* Labels et Inputs modernes */
    .form-label-modern {
        display: block;
        margin-bottom: 0.8rem;
        font-weight: 600;
        color: #495057;
        font-size: 0.95rem;
    }
    .form-label-modern .required {
        color: #e53e3e;
        font-size: 1.1em;
    }
    .form-label-modern .optional {
        color: #999;
        font-size: 0.8em;
        font-weight: normal;
    }
    .input-group-modern {
        position: relative;
        margin-bottom: 1.5rem; /* Ajoute de l'espace */
    }
    .form-control-modern {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.5rem;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }
    .form-control-modern::placeholder {
        color: #adb5bd;
        opacity: 1;
    }
    .form-control-modern:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff; /* Couleur de focus Bootstrap */
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    /* Style pour textarea */
    .textarea-modern {
        min-height: 120px; /* Hauteur minimale */
        resize: vertical; /* Permet uniquement le redimensionnement vertical */
    }
    /* Style pour inputs invalides */
    .form-control-modern.is-invalid {
        border-color: #e53e3e;
    }
    .form-control-modern.is-valid {
        border-color: #28a745;
    }

    /* File Upload moderne */
    .file-upload-wrapper {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .file-input {
        opacity: 0;
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
    .file-upload-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px dashed #a0aec0;
        border-radius: 0.75rem;
        padding: 2.5rem;
        text-align: center;
        cursor: pointer;
        background-color: #f7fafc;
        transition: all 0.3s ease;
    }
    .file-upload-area:hover {
        border-color: #667eea;
        background-color: #edf2f7;
    }
    .file-upload-area.drag-over {
        border-color: #667eea;
        background-color: #e2e8f0;
    }
    .upload-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .file-upload-area:hover .upload-icon {
        transform: scale(1.1);
        color: #5a67d8;
    }
    .upload-text .upload-main {
        display: block;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.25rem;
    }
    .upload-text .upload-sub {
        font-size: 0.9rem;
        color: #718096;
    }
    .file-preview {
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background-color: #f7fafc;
        display: flex; /* S'assure que l'image remplit */
        justify-content: center;
        align-items: center;
        min-height: 180px; /* Hauteur minimale pour l'aperçu */
    }
    .file-preview img {
        max-width: 100%;
        max-height: 180px; /* Limite la hauteur de l'image */
        display: block;
        object-fit: contain; /* S'assure que l'image est contenue */
        padding: 10px; /* Petit padding autour de l'image */
    }
    .btn-remove-file {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: rgba(239, 68, 68, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    .btn-remove-file:hover {
        background-color: #ef4444;
    }

    /* Compteur de caractères */
    .char-counter {
        text-align: right;
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
    .char-counter #char-count {
        font-weight: bold;
    }

    /* Navigation moderne (boutons) */
    .form-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 3rem;
    }
    .btn-navigation {
        padding: 0.8rem 2rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        outline: none;
    }
    .btn-prev {
        background-color: #e2e8f0;
        color: #4a5568;
    }
    .btn-prev:hover:not(:disabled) {
        background-color: #cbd5e0;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-prev:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .btn-next {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
    }
    .btn-next:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(118, 75, 162, 0.4);
        filter: brightness(1.1); /* Légèrement plus lumineux au survol */
    }
    .btn-next.btn-success { /* Style quand il devient le bouton de soumission */
        background: linear-gradient(45deg, #28a745, #218838);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    .btn-next.btn-success:hover:not(:disabled) {
        box-shadow: 0 7px 20px rgba(40, 167, 69, 0.4);
    }
    .btn-ripple { /* Effet d'ondulation */
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
    }
    @keyframes ripple {
        to {
            transform: scale(2.5);
            opacity: 0;
        }
    }

    /* Alerts modernes */
    .alert-modern {
        display: flex;
        align-items: flex-start;
        padding: 1.25rem 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        border-left: 5px solid;
    }
    .alert-modern .alert-icon {
        font-size: 1.8rem;
        margin-right: 1rem;
        margin-top: 0.2rem;
    }
    .alert-modern .alert-content {
        flex-grow: 1;
    }
    .alert-modern .alert-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    .alert-modern ul {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.95rem;
    }
    .alert-modern li {
        margin-bottom: 0.25rem;
    }
    .alert-danger.alert-modern {
        background-color: rgba(255, 99, 71, 0.1); /* Tomato red light */
        border-color: #e53e3e; /* Red dark */
        color: #c53030;
    }
    .alert-danger.alert-modern .alert-icon {
        color: #e53e3e;
    }
</style>

<script>
    let currentStep = 1;
    const totalSteps = 3;
    const steps = document.querySelectorAll('.step');
    const progressSteps = document.querySelectorAll('.progress-step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const progressFill = document.getElementById('progress-fill');

    // File upload elements
    const fileInput = document.getElementById('logo_path');
    const fileUploadArea = document.getElementById('file-upload-area');
    const filePreview = document.getElementById('file-preview');
    const previewImage = document.getElementById('preview-image');
    const removeFileBtn = document.getElementById('remove-file');

    // Character counter elements
    const descriptionTextarea = document.getElementById('description');
    const charCount = document.getElementById('char-count');

    function showStep(step) {
        // Hide all steps
        steps.forEach(s => {
            s.classList.remove('step-active');
        });

        // Show current step
        steps[step - 1].classList.add('step-active');

        // Update progress bar
        const percentage = ((step - 1) / (totalSteps - 1)) * 100;
        progressFill.style.width = `${percentage}%`;

        // Update progress steps
        progressSteps.forEach((ps, index) => {
            ps.classList.remove('active', 'completed');
            if (index + 1 === step) {
                ps.classList.add('active');
            } else if (index + 1 < step) {
                ps.classList.add('completed');
            }
        });

        // Update navigation buttons
        prevBtn.disabled = step === 1;

        if (step === totalSteps) {
            nextBtn.innerHTML = `
                <span class="btn-text">
                    <i class="fas fa-check me-2"></i>
                    Créer l'entreprise
                </span>
                <div class="btn-ripple"></div>
            `;
            nextBtn.type = 'submit';
            nextBtn.classList.remove('btn-primary');
            nextBtn.classList.add('btn-success');
        } else {
            nextBtn.innerHTML = `
                <span class="btn-text">
                    Suivant
                    <i class="fas fa-arrow-right ms-2"></i>
                </span>
                <div class="btn-ripple"></div>
            `;
            nextBtn.type = 'button';
            nextBtn.classList.remove('btn-success');
            nextBtn.classList.add('btn-primary');
        }
    }

    function validateStep(step) {
        const currentStepElement = document.getElementById(`step${step}`);
        const requiredInputs = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid'); // Clear previous states

            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.add('is-valid');
            }
        });

        return isValid;
    }

    function createRipple(event) {
        const button = event.currentTarget;
        let ripple = button.querySelector('.btn-ripple');
        if (!ripple) { // Create ripple element if it doesn't exist
            ripple = document.createElement('div');
            ripple.classList.add('btn-ripple');
            button.appendChild(ripple);
        }

        // Remove existing animation to allow new one
        ripple.style.animation = 'none';
        ripple.offsetHeight; // Trigger reflow
        
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.style.animation = 'ripple 0.6s linear';
    }

    // Event listeners
    nextBtn.addEventListener('click', (e) => {
        createRipple(e); // Play ripple effect

        if (currentStep === totalSteps) {
            if (!validateStep(currentStep)) {
                e.preventDefault(); // Prevent submission if validation fails
            }
        } else {
            if (validateStep(currentStep)) {
                e.preventDefault(); // Prevent form submission
                currentStep++;
                showStep(currentStep);
            } else {
                e.preventDefault(); // Prevent submission if validation fails
            }
        }
    });

    prevBtn.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default button behavior
        createRipple(e); // Play ripple effect

        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // File upload drag and drop and preview logic
    fileUploadArea.addEventListener('click', () => fileInput.click());
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('drag-over');
    });
    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('drag-over');
    });
    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect();
        }
    });

    fileInput.addEventListener('change', handleFileSelect);

    removeFileBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent click from bubbling to fileUploadArea
        fileInput.value = ''; // Clear the input
        filePreview.classList.add('d-none');
        fileUploadArea.classList.remove('d-none');
        previewImage.src = '';
    });

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    fileUploadArea.classList.add('d-none');
                    filePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                alert('Veuillez sélectionner un fichier image valide.');
                fileInput.value = ''; // Clear input if not an image
                filePreview.classList.add('d-none'); // Hide preview
                fileUploadArea.classList.remove('d-none'); // Show upload area
            }
        } else {
            filePreview.classList.add('d-none');
            fileUploadArea.classList.remove('d-none');
            previewImage.src = '';
        }
    }

    // Character counter for description
    descriptionTextarea.addEventListener('input', () => {
        const length = descriptionTextarea.value.length;
        charCount.textContent = length;
        
        if (length > 500) {
            charCount.style.color = '#e53e3e'; // Rouge
        } else if (length > 400) {
            charCount.style.color = '#f59e0b'; // Orange
        } else {
            charCount.style.color = '#6c757d'; // Gris par défaut
        }
    });

    // Smooth focus transitions for inputs
    document.querySelectorAll('.form-control-modern, .textarea-modern').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.input-group-modern').classList.add('input-focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.input-group-modern').classList.remove('input-focused');
        });
    });

    // Initialize the first step and char counter when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        showStep(currentStep);
        // Trigger character count on load if there's old input
        if (descriptionTextarea) {
            const event = new Event('input');
            descriptionTextarea.dispatchEvent(event);
        }

        // Set initial card animation visibility
        document.querySelector('.form-card').style.opacity = '1';
        document.querySelector('.form-card').style.transform = 'translateY(0)';
    });
</script>
@endsection