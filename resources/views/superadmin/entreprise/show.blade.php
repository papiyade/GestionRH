@extends('layouts.admin-dashboard')

@section('content')
<div class="container-fluid py-5 min-vh-100 d-flex flex-column align-items-center justify-content-center">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">

            {{-- Page Header --}}
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-gradient mb-3">
                    Profil de l'Entreprise
                </h1>
                <p class="lead text-muted">
                    Informations détaillées et gestion du statut pour <strong class="text-primary">{{ $entreprise->entreprise_name }}</strong>.
                </p>
            </div>

            {{-- Success/Error Messages (Reusing alert-modern styles) --}}
            @if (session('success'))
                <div class="alert alert-success alert-modern fade show mb-4" role="alert">
                    <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="alert-content">
                        <h6 class="alert-title mb-0" style="color: #38a169;">Succès !</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-modern mb-4">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-content">
                        <h6 class="alert-title mb-2">Une erreur est survenue :</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Company Profile Card --}}
            <div class="form-card p-5">
                <div class="card-glow"></div> {{-- Visual effect --}}

                <div class="d-flex flex-column flex-md-row align-items-center mb-4 pb-4 border-bottom">
                    <div class="company-logo-container me-md-4 mb-4 mb-md-0">
                        @if ($entreprise->logo_path)
                            <img src="{{ asset('storage/' . $entreprise->logo_path) }}" alt="Logo {{ $entreprise->entreprise_name }}" class="company-logo">
                        @else
                            <div class="company-logo-placeholder">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-center text-md-start">
                        <h2 class="display-6 fw-bold mb-2">{{ $entreprise->entreprise_name }}</h2>
                        <p class="lead text-muted mb-1"><i class="fas fa-envelope me-2 text-primary"></i>{{ $entreprise->email }}</p>
                        <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $entreprise->adresse }}</p>
                    </div>
                </div>

                {{-- Description Section --}}
                <div class="mb-4 pb-4 border-bottom">
                    <h3 class="h5 fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Description</h3>
                    <p class="text-muted">{{ $entreprise->description }}</p>
                </div>

                {{-- Status and Dates Section --}}
                <div class="row mb-4 pb-4 border-bottom">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="h5 fw-bold mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Statut</h3>
                        <p class="mb-0">
                            Actuellement :
                            @if ($entreprise->is_actif)
                                <span class="badge bg-success status-badge">Active</span>
                                <span class="text-success ms-2">Visible et opérationnelle.</span>
                            @else
                                <span class="badge bg-danger status-badge">Restreinte</span>
                                <span class="text-danger ms-2">Non visible publiquement ou non opérationnelle.</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h5 fw-bold mb-3"><i class="fas fa-calendar-alt me-2 text-primary"></i>Dates Clés</h3>
                        <p class="mb-1 text-muted">Créée le : <strong>{{ $entreprise->created_at->format('d/m/Y H:i') }}</strong></p>
                        <p class="mb-0 text-muted">Dernière mise à jour : <strong>{{ $entreprise->updated_at->format('d/m/Y H:i') }}</strong></p>
                    </div>
                </div>

                {{-- Admin User Section --}}
                @if ($adminUser)
                <div class="mb-4 pb-4 border-bottom">
                    <h3 class="h5 fw-bold mb-3"><i class="fas fa-user-shield me-2 text-primary"></i>Administrateur Associé</h3>
                    <p class="mb-1 text-muted">Nom : <strong>{{ $adminUser->name }}</strong></p>
                    <p class="mb-0 text-muted">Email : <strong>{{ $adminUser->email }}</strong></p>
                </div>
                @endif


                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('entreprise.edit', $entreprise->id) }}" class="btn btn-secondary btn-navigation">
                        <i class="fas fa-pencil-alt me-2"></i> Modifier l'Entreprise
                    </a>

                    {{-- Toggle Status Form --}}
                    <form action="{{ route('entreprise.toggleStatus', $entreprise->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-navigation {{ $entreprise->is_actif ? 'btn-warning' : 'btn-success' }}">
                            @if ($entreprise->is_actif)
                                <i class="fas fa-ban me-2"></i> Restreindre l'Entreprise
                            @else
                                <i class="fas fa-check-circle me-2"></i> Dérestreindre l'Entreprise
                            @endif
                            <div class="btn-ripple"></div> {{-- Ripple effect --}}
                        </button>
                    </form>
                </div>

            </div> {{-- End .form-card --}}

        </div>
    </div>
</div>

{{-- Add your existing modern CSS styles here, or ensure they are imported via your layout --}}
<style>
    /* Ensure your global styles for .form-card, .text-gradient, .btn-navigation, .btn-ripple, etc. are included from your previous setup. */
    /* I'm providing specific styles for this view below to ensure they look good */
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
        color: #2d3748;
    }

    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-card {
        position: relative;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        padding: 3rem;
        box-shadow: var(--shadow-soft);
        transition: var(--transition);
        overflow: hidden; /* For ripple effect */
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

    /* Company Logo */
    .company-logo-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid var(--primary-gradient);
        box-shadow: 0 0 0 8px rgba(102, 126, 234, 0.1);
        flex-shrink: 0;
    }

    .company-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .company-logo-placeholder {
        width: 100%;
        height: 100%;
        background-color: #f0f4f8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccd7e4;
    }

    /* Badge styles */
    .status-badge {
        font-size: 0.9rem;
        padding: 0.5em 1em;
        border-radius: 0.5rem;
        font-weight: 600;
        min-width: 90px;
        text-align: center;
    }

    /* Alert modern styles (copied from previous snippets) */
    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: flex-start;
        border-left: 4px solid; /* Defined by specific type below */
    }

    .alert-modern.alert-success {
        background-color: rgba(56, 239, 125, 0.1);
        border-left-color: #38a169;
    }

    .alert-modern.alert-danger {
        background-color: rgba(229, 62, 62, 0.1);
        border-left-color: #e53e3e;
    }

    .alert-icon {
        margin-right: 1rem;
        font-size: 1.25rem;
        color: inherit; /* Color inherited from alert type */
    }

    .alert-modern.alert-success .alert-icon { color: #38a169; }
    .alert-modern.alert-danger .alert-icon { color: #e53e3e; }


    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        margin: 0;
        color: inherit; /* Color inherited from alert type */
    }

    .alert-modern.alert-success .alert-title { color: #38a169; }
    .alert-modern.alert-danger .alert-title { color: #e53e3e; }

    .alert-content ul {
        list-style: none;
        padding: 0;
        margin-bottom: 0;
    }

    .alert-content li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        color: #6c757d; /* Default text color for list items */
    }

    .alert-content li::before {
        content: '•';
        position: absolute;
        left: 0;
        font-weight: bold;
        color: inherit; /* Color inherited from alert type */
    }
    .alert-modern.alert-danger .alert-content li { color: #e53e3e; }


    /* Navigation Button */
    .btn-navigation {
        padding: 0.8rem 1.8rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .btn-navigation.btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-navigation.btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .btn-navigation.btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
    }
    .btn-navigation.btn-warning:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 152, 0, 0.3);
    }

    .btn-navigation.btn-success {
        background: var(--success-gradient);
        color: white;
    }
    .btn-navigation.btn-success:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(56, 239, 125, 0.3);
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

    @media (max-width: 768px) {
        .form-card {
            padding: 2rem;
            margin: 0 1rem;
        }
        .d-flex.flex-column.flex-md-row {
            flex-direction: column !important;
            text-align: center;
        }
        .company-logo-container {
            margin-bottom: 1.5rem !important;
            margin-right: 0 !important;
        }
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
        .btn-navigation {
            width: 100%;
        }
    }
</style>

{{-- Script for ripple effect --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.btn-navigation').forEach(button => {
            button.addEventListener('click', function(e) {
                // Only create ripple for submit buttons to avoid double ripple
                if (this.type === 'submit' || this.tagName === 'A') { // Added condition for <a> tags
                    let ripple = this.querySelector('.btn-ripple');
                    if (!ripple) {
                        ripple = document.createElement('span');
                        ripple.classList.add('btn-ripple');
                        this.appendChild(ripple);
                    } else {
                        ripple.remove(); // Remove previous ripple to restart animation
                        ripple = document.createElement('span');
                        ripple.classList.add('btn-ripple');
                        this.appendChild(ripple);
                    }

                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = `${size}px`;
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                }
            });
        });
    });
</script>
@endsection