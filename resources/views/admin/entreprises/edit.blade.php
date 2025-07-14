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
                        <div class="icon-pulse"></div>
                    </div>
                    <h1 class="display-5 fw-bold text-gradient mb-2">Mise à jour de votre entreprise</h1>
                    <p class="lead text-muted">Ajustons et améliorons votre présence professionnelle</p>
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
                <div class="card-glow"></div>

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

                <form id="step-form" action="{{ route('entreprise.update', $entreprise->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Indique que c'est une requête PUT pour la mise à jour --}}

                    {{-- Étape 1: Identité --}}
                    <div class="step step-active" id="step1">
                        <div class="step-header mb-4">
                            <h3 class="step-title">
                                <i class="fas fa-image text-primary me-2"></i>
                                Identité de votre entreprise
                            </h3>
                            <p class="step-subtitle">Ajustons votre logo et votre nom</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">
                                <i class="fas fa-camera me-2"></i>
                                Logo de l'entreprise
                                <span class="optional">(optionnel)</span>
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" class="file-input" id="logo_path" name="logo_path" accept="image/*">

                                {{-- Condition pour afficher le logo existant ou la zone d'upload --}}
                                @if ($entreprise->logo_path)
                                    <div class="file-preview" id="file-preview">
                                        <img id="preview-image" src="{{ asset('storage/' . $entreprise->logo_path) }}" alt="Logo actuel de l'entreprise">
                                        <button type="button" class="btn-remove-file" id="remove-file">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        {{-- Champ caché pour indiquer la suppression du logo existant --}}
                                        <input type="hidden" name="remove_logo" id="remove_logo_input" value="0">
                                    </div>
                                    <div class="file-upload-area d-none" id="file-upload-area"> {{-- Initialement caché --}}
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="upload-text">
                                            <span class="upload-main">Glissez votre logo ici</span>
                                            <span class="upload-sub">ou cliquez pour parcourir</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="file-upload-area" id="file-upload-area">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="upload-text">
                                            <span class="upload-main">Glissez votre logo ici</span>
                                            <span class="upload-sub">ou cliquez pour parcourir</span>
                                        </div>
                                    </div>
                                    <div class="file-preview d-none" id="file-preview"> {{-- Initialement caché --}}
                                        <img id="preview-image" alt="Aperçu du nouveau logo">
                                        <button type="button" class="btn-remove-file" id="remove-file">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <input type="hidden" name="remove_logo" id="remove_logo_input" value="0">
                                    </div>
                                @endif
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
                                    name="entreprise_name"
                                    value="{{ old('entreprise_name', $entreprise->entreprise_name) }}"
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
                            <p class="step-subtitle">Mettez à jour vos coordonnées</p>
                        </div>

                        <div class="mb-4">
                            <label for="adresse" class="form-label-modern">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Adresse complète
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-modern">
                                <input type="text" class="form-control-modern" id="adresse"
                                    name="adresse"
                                    value="{{ old('adresse', $entreprise->adresse) }}"
                                    placeholder="123 Rue de la Paix, 75001 Paris" required>
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
                                    name="email"
                                    value="{{ old('email', $entreprise->email) }}"
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
                            <p class="step-subtitle">Précisez votre activité et vos valeurs</p>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label-modern">
                                <i class="fas fa-align-left me-2"></i>
                                Description de l'entreprise
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-modern">
                                <textarea class="form-control-modern textarea-modern" id="description"
                                    name="description" rows="6" required
                                    placeholder="Décrivez votre entreprise, ses activités, sa mission...">{{ old('description', $entreprise->description) }}</textarea>
                                <div class="input-focus-ring"></div>
                            </div>
                            <div class="char-counter">
                                <span id="char-count">0</span> caractères
                            </div>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <div class="form-navigation">
                        <button type="button" class="btn-navigation btn-prev" id="prevBtn">
                            <i class="fas fa-arrow-left me-2"></i>
                            Précédent
                        </button>
                        <button type="button" class="btn-navigation btn-next" id="nextBtn"> {{-- Type button initialement --}}
                            <span class="btn-text">
                                Suivant
                                <i class="fas fa-arrow-right ms-2"></i>
                            </span>
                            <div class="btn-ripple"></div>
                        </button>
                    </div>
                </form>

                {{-- Effet de confetti pour la validation --}}
                <div class="confetti-container" id="confetti-container"></div>
            </div>
        </div>
    </div>
</div>

{{-- Styles CSS modernes (Identiques à ceux du formulaire de création) --}}
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --card-bg: rgba(255, 255, 255, 0.95);
        --shadow-soft: 0 20px 60px rgba(0, 0, 0, 0.05);
        --shadow-hover: 0 30px 80px rgba(0, 0, 0, 0.1);
        --border-radius: 20px;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Header Animation */
    .creation-icon {
        position: relative;
        display: inline-block;
    }

    .icon-pulse {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        border: 2px solid #667eea;
        border-radius: 50%;
        animation: pulse 2s infinite;
        opacity: 0.3;
    }

    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.7; }
        50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.3; }
        100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
    }

    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Progress Bar Moderne */
    .progress-container {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
    }

    .progress-track {
        height: 4px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 2px;
        position: relative;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--primary-gradient);
        border-radius: 2px;
        width: 33.33%; /* Initial width for step 1 */
        transition: var(--transition);
        position: relative;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(102, 126, 234, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 18px;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .progress-step.active .step-circle {
        background: var(--primary-gradient);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .progress-step.completed .step-circle {
        background: var(--success-gradient);
        color: white;
    }

    .step-label {
        font-size: 12px;
        font-weight: 600;
        margin-top: 8px;
        color: #6c757d;
        transition: var(--transition);
    }

    .progress-step.active .step-label {
        color: #667eea;
        font-weight: 700;
    }

    /* Card avec Glassmorphism */
    .form-card {
        position: relative;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        padding: 3rem;
        box-shadow: var(--shadow-soft);
        transition: var(--transition);
    }

    .form-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .card-glow {
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: var(--primary-gradient);
        border-radius: var(--border-radius);
        z-index: -1;
        opacity: 0;
        transition: var(--transition);
    }

    .form-card:hover .card-glow {
        opacity: 0.1;
    }

    /* Steps */
    .step {
        opacity: 0;
        transform: translateX(50px);
        transition: var(--transition);
        display: none;
    }

    .step-active {
        opacity: 1;
        transform: translateX(0);
        display: block;
        animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .step-header {
        text-align: center;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    }

    .step-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .step-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin: 0;
    }

    /* Labels modernes */
    .form-label-modern {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .required {
        color: #e53e3e;
        margin-left: 4px;
    }

    .optional {
        color: #6c757d;
        font-weight: 400;
        font-size: 0.85rem;
        margin-left: 8px;
    }

    /* Inputs modernes */
    .input-group-modern {
        position: relative;
    }

    .form-control-modern {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        transition: var(--transition);
        backdrop-filter: blur(10px);
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #667eea;
        background: rgba(255, 255, 255, 0.95);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.1);
    }

    .textarea-modern {
        resize: vertical;
        min-height: 120px;
    }

    .input-focus-ring {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 12px;
        border: 2px solid transparent;
        pointer-events: none;
        transition: var(--transition);
    }

    .form-control-modern:focus + .input-focus-ring {
        border-color: #667eea;
        animation: focusRing 0.3s ease-out;
    }

    @keyframes focusRing {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .char-counter {
        text-align: right;
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    /* File Upload */
    .file-upload-wrapper {
        position: relative;
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .file-upload-area {
        border: 2px dashed rgba(102, 126, 234, 0.3);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: rgba(102, 126, 234, 0.02);
        transition: var(--transition);
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
        transform: translateY(-2px);
    }

    .upload-icon i {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .upload-main {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .upload-sub {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .file-preview {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        max-width: 200px;
        margin: 0 auto;
        border: 1px solid rgba(102, 126, 234, 0.1); /* Ajout d'une bordure subtile */
        background-color: #f8f9fa; /* Couleur de fond */
        display: flex; /* S'assure que l'image est centrée */
        align-items: center;
        justify-content: center;
        min-height: 150px; /* Pour éviter l'affaissement si l'image est petite */
        padding: 10px; /* Espace autour de l'image */
    }

    .file-preview img {
        width: auto; /* Ajustement automatique de la largeur */
        max-width: 100%; /* Limite la largeur de l'image au conteneur */
        height: auto; /* Ajustement automatique de la hauteur */
        max-height: 180px; /* Limite la hauteur de l'image */
        border-radius: 8px; /* Coins légèrement arrondis pour l'image */
        object-fit: contain; /* S'assure que l'image est contenue sans être coupée */
    }

    .btn-remove-file {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(229, 62, 62, 0.9);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        z-index: 10; /* S'assure qu'il est au-dessus de l'image */
    }

    .btn-remove-file:hover {
        background: #e53e3e;
        transform: scale(1.1);
    }

    /* Navigation */
    .form-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(102, 126, 234, 0.1);
    }

    .btn-navigation {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .btn-prev {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    .btn-prev:hover:not(:disabled) {
        background: rgba(108, 117, 125, 0.2);
        transform: translateX(-5px);
    }

    .btn-prev:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-next {
        background: var(--primary-gradient);
        color: white;
        min-width: 150px;
        justify-content: center;
    }

    .btn-next:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
    }

    .btn-next.btn-submit-final { /* Nouvelle classe pour le bouton final de soumission */
        background: var(--success-gradient);
        box-shadow: 0 15px 35px rgba(56, 239, 125, 0.4);
    }

    .btn-next.btn-submit-final:hover {
        filter: brightness(1.1);
    }

    .btn-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Alert moderne */
    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-start;
        background: rgba(229, 62, 62, 0.05);
        border-left: 4px solid #e53e3e;
    }
     .alert-modern.alert-success { /* Style pour les alertes de succès */
        background-color: rgba(56, 239, 125, 0.1);
        border-left-color: #38a169;
        color: #38a169;
    }

    .alert-modern.alert-success .alert-icon {
        color: #38a169;
    }


    .alert-icon {
        margin-right: 1rem;
        font-size: 1.25rem;
        color: #e53e3e;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        color: #e53e3e;
        margin: 0;
    }

    .alert-content ul {
        list-style: none;
        padding: 0;
    }

    .alert-content li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .alert-content li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #e53e3e;
        font-weight: bold;
    }

    /* Confetti */
    .confetti-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
    }

    .confetti-piece {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #667eea;
        animation: confetti-fall 3s linear infinite;
    }

    @keyframes confetti-fall {
        0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
        100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .progress-steps {
            margin-top: 15px;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }
        
        .step-label {
            font-size: 11px;
        }
        
        .form-navigation {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn-navigation {
            width: 100%;
            justify-content: center;
        }
    }

    /* Shake animation for invalid inputs */
    @keyframes shake {
        0% { transform: translateX(0); }
        20% { transform: translateX(-5px); }
        40% { transform: translateX(5px); }
        60% { transform: translateX(-5px); }
        80% { transform: translateX(5px); }
        100% { transform: translateX(0); }
    }
</style>

{{-- Script JavaScript amélioré --}}
<script>
    let currentStep = 1;
    const totalSteps = 3;
    const steps = document.querySelectorAll('.step');
    const progressSteps = document.querySelectorAll('.progress-step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const progressFill = document.getElementById('progress-fill');
    const confettiContainer = document.getElementById('confetti-container');
    const form = document.getElementById('step-form');

    // File upload handling
    const fileInput = document.getElementById('logo_path');
    const fileUploadArea = document.getElementById('file-upload-area');
    const filePreview = document.getElementById('file-preview');
    const previewImage = document.getElementById('preview-image');
    const removeFileBtn = document.getElementById('remove-file');
    const removeLogoInput = document.getElementById('remove_logo_input'); // Champ caché

    // Character counter
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
        const percentage = ((step - 1) / (totalSteps - 1)) * 100; // Recalculé pour que la dernière étape soit 100%
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
                    Mettre à jour l'entreprise
                </span>
                <div class="btn-ripple"></div>
            `;
            nextBtn.type = 'submit'; // Le bouton devient de type submit
            nextBtn.classList.remove('btn-primary'); // Supprime la classe par défaut si elle existe
            nextBtn.classList.add('btn-submit-final'); // Ajoute la classe pour le style final
        } else {
            nextBtn.innerHTML = `
                <span class="btn-text">
                    Suivant
                    <i class="fas fa-arrow-right ms-2"></i>
                </span>
                <div class="btn-ripple"></div>
            `;
            nextBtn.type = 'button'; // Le bouton reste de type button
            nextBtn.classList.remove('btn-submit-final'); // Supprime la classe de style final
            nextBtn.classList.add('btn-primary'); // Remet la classe par défaut (si nécessaire)
        }
    }

    function validateStep(step) {
        const currentStepElement = document.getElementById(`step${step}`);
        const requiredInputs = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            // Réinitialiser les styles d'erreur précédents
            input.classList.remove('is-invalid', 'shake');
            input.style.borderColor = ''; // Réinitialise la bordure si elle a été mise par JS

            if (!input.value.trim()) {
                input.classList.add('is-invalid', 'shake'); // Ajoute la classe Bootstrap et shake
                input.style.borderColor = '#e53e3e'; // Force la couleur de bordure rouge
                isValid = false;
            } else {
                input.classList.remove('is-invalid'); // S'assure que la classe est retirée si valide
                input.classList.add('is-valid'); // Ajoute une classe Bootstrap pour le succès (optionnel)
                input.style.borderColor = '#28a745'; // Bordure verte pour les champs valides
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

    function createConfetti() {
        const colors = ['#667eea', '#764ba2', '#11998e', '#38ef7d', '#f093fb', '#f5576c'];
        
        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti-piece';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 3 + 's';
            confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
            confettiContainer.appendChild(confetti);
            
            setTimeout(() => {
                confetti.remove();
            }, 5000);
        }
    }

    // Event listeners
    nextBtn.addEventListener('click', (e) => {
        createRipple(e);
        
        if (currentStep === totalSteps) {
            // Dernière étape : Valider et laisser le formulaire soumettre si valide
            if (!validateStep(currentStep)) {
                e.preventDefault(); // Empêcher la soumission si la validation échoue
            } else {
                // Si la validation passe, le formulaire sera soumis.
                // On peut ajouter un feedback visuel ici avant la soumission réelle.
                const successMsg = document.createElement('div');
                successMsg.className = 'alert alert-success alert-modern mt-4';
                successMsg.innerHTML = `
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h6 class="alert-title mb-0" style="color: #38a169;">Mise à jour en cours...</h6>
                    </div>
                `;
                document.querySelector('.form-card').appendChild(successMsg);
                createConfetti(); // Lance les confettis
            }
        } else {
            // Étapes intermédiaires : Valider et passer à l'étape suivante si valide
            if (validateStep(currentStep)) {
                e.preventDefault(); // Empêcher la soumission du formulaire
                currentStep++;
                showStep(currentStep);
            } else {
                e.preventDefault(); // Empêcher la soumission si la validation échoue
            }
        }
    });

    // Gestion du bouton "Précédent"
    prevBtn.addEventListener('click', (e) => {
        e.preventDefault(); // Empêcher l'action par défaut du bouton
        createRipple(e);

        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // File upload logic
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
        fileInput.value = ''; // Clear the file input
        previewImage.src = ''; // Clear image source
        filePreview.classList.add('d-none'); // Hide preview
        fileUploadArea.classList.remove('d-none'); // Show upload area
        removeLogoInput.value = '1'; // Set hidden input to indicate logo removal
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
                    removeLogoInput.value = '0'; // If new file uploaded, don't remove existing
                };
                reader.readAsDataURL(file);
            } else {
                alert('Veuillez sélectionner un fichier image valide.');
                fileInput.value = ''; // Clear input if not an image
                filePreview.classList.add('d-none'); // Hide preview
                fileUploadArea.classList.remove('d-none'); // Show upload area
                removeLogoInput.value = '0'; // No file selected, so not removed
            }
        } else {
            // No file selected (e.g., user opened dialog then cancelled)
            // If there was an existing logo, we want to keep it displayed
            if (previewImage.dataset.originalSrc) { // Check if original src was set
                previewImage.src = previewImage.dataset.originalSrc;
                fileUploadArea.classList.add('d-none');
                filePreview.classList.remove('d-none');
                removeLogoInput.value = '0';
            } else {
                filePreview.classList.add('d-none');
                fileUploadArea.classList.remove('d-none');
                previewImage.src = '';
                removeLogoInput.value = '0';
            }
        }
    }


    // Character counter for description
    if (descriptionTextarea && charCount) {
        descriptionTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            if (length > 500) {
                charCount.style.color = '#e53e3e';
            } else if (length > 400) {
                charCount.style.color = '#f59e0b';
            } else {
                charCount.style.color = '#6c757d';
            }
        });
        
        // Initialize counter
        charCount.textContent = descriptionTextarea.value.length;
        // Trigger initial color check
        const event = new Event('input');
        descriptionTextarea.dispatchEvent(event);
    }

    // Store original logo path for re-display if user cancels file selection
    document.addEventListener('DOMContentLoaded', () => {
        const existingLogoPath = previewImage.getAttribute('src');
        if (existingLogoPath) {
            previewImage.dataset.originalSrc = existingLogoPath; // Store original path
        }
    });

    // Initialisation du formulaire à la première étape au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        showStep(currentStep);
        // Ensure form card is visible with animation
        document.querySelector('.form-card').style.opacity = '1';
        document.querySelector('.form-card').style.transform = 'translateY(0)';
    });
</script>
@endsection