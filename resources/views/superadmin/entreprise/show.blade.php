@extends('layout.superadmin')

@section('title', 'Profil Entreprise')
@section('page-title', 'Détail Entreprise')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            
            <!-- En-tête Principal -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        
                        <!-- Logo ou avatar -->
                        <div class="col-auto">
                            <div class="position-relative">
                                <div class="d-flex align-items-center justify-content-center bg-light border rounded-4 shadow-sm" 
                                     style="width: 100px; height: 100px; overflow: hidden;">
                                     
                                    @if ($entreprise->logo_path)
                                        <!-- Logo -->
                                        <img src="{{ asset('storage/' . $entreprise->logo_path) }}" 
                                             alt="Logo {{ $entreprise->entreprise_name }}" 
                                             class="img-fluid p-2" 
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    @else
                                        <!-- Première lettre -->
                                        <span class="fw-bold text-white d-flex align-items-center justify-content-center"
                                              style="width:100%; height:100%; font-size:2.5rem; 
                                                     background: linear-gradient(135deg, #4e73df, #1cc88a); 
                                                     border-radius: 12px;">
                                            {{ strtoupper(mb_substr($entreprise->entreprise_name, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Infos principales -->
                        <div class="col">
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
                                <h1 class="h2 fw-bold text-dark mb-0">{{ $entreprise->entreprise_name }}</h1>
                                @if ($entreprise->is_actif)
                                    <span class="badge bg-success px-3 py-2 rounded-pill fs-6">
                                        <i class="fas fa-check-circle me-1"></i> Actif
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill fs-6">
                                        <i class="fas fa-times-circle me-1"></i> Restreint
                                    </span>
                                @endif
                            </div>
                            <div class="row g-3 text-muted">
                                <div class="col-auto">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <span>{{ $entreprise->email }}</span>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <span>{{ $entreprise->adresse }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages de notification -->
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                        <div>
                            <strong class="d-block">Succès !</strong>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert" style="border-radius: 15px;">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle text-danger fs-4 me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <strong class="d-block mb-2">Erreur détectée :</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contenu Principal -->
            <div class="row g-4 mb-4">
                <!-- Description -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title fw-semibold text-dark mb-0">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Description de l'entreprise
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <p class="text-muted mb-0 lh-base">{{ $entreprise->description ?: 'Aucune description disponible.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Détails clés -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title fw-semibold text-dark mb-0">
                                <i class="fas fa-chart-line text-success me-2"></i>
                                Informations détaillées
                            </h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="vstack gap-3">
                                @if ($adminUser)
                                <div class="p-3 bg-light rounded-3">
                                    <div class="fw-semibold text-dark small mb-1">Administrateur associé</div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-shield text-warning me-2"></i>
                                        <span class="text-dark">{{ $adminUser->name }}</span>
                                        <span class="text-muted ms-2">({{ $adminUser->email }})</span>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="p-3 bg-light rounded-3">
                                    <div class="fw-semibold text-dark small mb-1">Date de création</div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-plus text-info me-2"></i>
                                        <span class="text-dark">{{ $entreprise->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                                
                                <div class="p-3 bg-light rounded-3">
                                    <div class="fw-semibold text-dark small mb-1">Dernière modification</div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-secondary me-2"></i>
                                        <span class="text-dark">{{ $entreprise->updated_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('entreprise.edit', $entreprise->id) }}" 
                               class="btn btn-outline-dark btn-lg w-100 rounded-pill shadow-sm">
                                <i class="fas fa-pencil-alt me-2"></i>
                                Modifier l'entreprise
                            </a>
                        </div>
                        
                        <div class="col-12 col-sm-6">
                            <form action="{{ route('entreprise.toggleStatus', $entreprise->id) }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-dark btn-lg w-100 rounded-pill shadow-sm">
                                    @if ($entreprise->is_actif)
                                        <i class="fas fa-ban me-2"></i>
                                        Restreindre l'entreprise
                                    @else
                                        <i class="fas fa-check-circle me-2"></i>
                                        Activer l'entreprise
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Styles personnalisés pour améliorer l'apparence */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
}

.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.alert {
    border-left: 4px solid;
}

.alert-success {
    border-left-color: var(--bs-success);
}

.alert-danger {
    border-left-color: var(--bs-danger);
}

.bg-light {
    background-color: #f8f9fa !important;
}

.text-primary { color: #007bff !important; }
.text-success { color: #28a745 !important; }
.text-danger { color: #dc3545 !important; }
.text-warning { color: #ffc107 !important; }
.text-info { color: #17a2b8 !important; }
.text-secondary { color: #6c757d !important; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
}
</style>
@endsection
