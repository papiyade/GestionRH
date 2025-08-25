@extends('layout.superadmin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Superadmin')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            
            <!-- En-tête -->
            <div class="text-center mb-5">
                <h1 class="h2 fw-bold text-dark mb-2">Tableau de bord</h1>
                <p class="text-muted">Vue d'ensemble de votre plateforme</p>
            </div>

            <!-- Statistiques -->
            <div class="row g-4 mb-5">
                
                <!-- Entreprises Totales -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 20px;">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="stats-icon bg-primary me-4">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1 fw-medium">ENTREPRISES TOTALES</p>
                                <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem;">
                                    {{ \App\Models\Entreprise::count() }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Entreprises Actives -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 20px;">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="stats-icon bg-success me-4">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1 fw-medium">ENTREPRISES ACTIVES</p>
                                <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem;">
                                    {{ \App\Models\Entreprise::where('is_actif',1)->count() }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Utilisateurs -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 20px;">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="stats-icon bg-warning me-4">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1 fw-medium">UTILISATEURS TOTAL</p>
                                <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem;">
                                    {{ \App\Models\User::count() }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center bg-dark rounded-circle mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-bolt text-white fs-4"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-2">Actions rapides</h4>
                                <p class="text-muted mb-0">Accédez rapidement aux fonctionnalités principales</p>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                                    <a href="{{ route('add_admin_view') }}" class="action-button">
                                        <div class="d-flex align-items-center p-4 rounded-4 bg-light border-2 border-transparent">
                                            <div class="action-icon bg-dark me-4">
                                                <i class="fas fa-user-plus text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">Nouvel Administrateur</h6>
                                                <p class="text-muted small mb-0">Ajouter un admin à la plateforme</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Statistiques */
.stats-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
}

.stats-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
}

.stats-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.stats-card:hover .stats-icon {
    transform: scale(1.15) rotate(-5deg);
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
}

/* Actions rapides */
.action-button {
    text-decoration: none;
    display: block;
    transition: all 0.3s ease;
    border-radius: 1rem;
}

.action-button:hover {
    text-decoration: none;
    transform: translateY(-3px);
}

.action-button:hover .bg-light {
    background-color: #e9ecef !important;
    border-color: #000 !important;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.action-button:hover .action-icon {
    transform: scale(1.1);
}

/* Typographie */
h1, h2, h4, h6 { letter-spacing: -0.5px; }
.small { letter-spacing: 0.5px; text-transform: uppercase; }

/* Couleurs */
.bg-primary { background-color: #007bff !important; }
.bg-success { background-color: #28a745 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-dark { background-color: #343a40 !important; }

/* Responsive */
@media (max-width: 768px) {
    .stats-icon { width: 60px; height: 60px; font-size: 1.5rem; }
    .card-body h2 { font-size: 2rem !important; }
    .action-icon { width: 45px; height: 45px; font-size: 1.1rem; }
}
</style>
@endsection
