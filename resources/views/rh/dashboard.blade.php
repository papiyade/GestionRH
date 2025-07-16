<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.admin_rh-dashboard')


@section('content')
    <div class="container-fluid">
        <!-- En-tête avec titre et actions rapides -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Tableau de Bord RH
                </h1>
                <p class="text-muted">Aperçu des ressources humaines de votre entreprise</p>
            </div>

            <!--
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download me-1"></i> Rapport
                    </button>
                    <button type="button" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nouvel Employé
                    </button>
                </div>
            </div>-->
        </div>

        <!-- Cartes de statistiques principales -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                    Employés Totaux
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">{{ $totalEmployes }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('employeList') }}" class="text-primary text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> Voir tous les employés
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                    Offres Actives
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">{{ $offresEmploiActives }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('offres.index') }}" class="text-success text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> Gérer les offres
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                    Candidatures en Attente
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">{{ $candidaturesEnAttente }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('candidatures.index') }}" class="text-warning text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> Examiner les candidatures
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                    Équipes Totales
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">{{ $totalEquipes }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-info rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-users-cog text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('teams') }}" class="text-info text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> Gérer les équipes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques supplémentaires -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h6 class="text-primary fw-bold m-0">
                            <i class="fas fa-chart-line me-2"></i>
                            Candidatures Récentes
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($candidaturesRecentes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Candidat</th>
                                            <th>Poste</th>
                                            <th>Statut</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($candidaturesRecentes as $candidature)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                            style="width: 30px; height: 30px;">
                                                            <i class="fas fa-user text-white small"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $candidature->user->name ?? 'N/A' }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $candidature->user->email ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $candidature->jobOffer->titre ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($candidature->status_demande === 'pending')
                                                        <span class="badge bg-warning">En attente</span>
                                                    @elseif($candidature->status_demande === 'accepted')
                                                        <span class="badge bg-success">Accepté</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejeté</span>
                                                    @endif
                                                </td>
                                                <td>{{ $candidature->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-muted">Aucune candidature récente</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h6 class="text-primary fw-bold m-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Statistiques du Mois
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="h4 mb-0 text-primary">{{ $candidaturesCeMois }}</div>
                                    <small class="text-muted">Candidatures</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="h4 mb-0 text-success">{{ $totalEmployes }}</div>
                                <small class="text-muted">Employés</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h6 class="text-primary fw-bold m-0">
                            <i class="fas fa-rocket me-2"></i>
                            Actions Rapides
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('rh.createUsers') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i>
                                Ajouter un Employé
                            </a>
                            <a href="{{ route('offres.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-briefcase me-2"></i>
                                Créer une Offre
                            </a>

                            <!--
                            <a href="#" class="btn btn-outline-warning">
                                <i class="fas fa-calendar-check me-2"></i>
                                Demandes de Congé
                            </a>
                            <a href="#" class="btn btn-outline-info">
                                <i class="fas fa-chart-bar me-2"></i>
                                Rapports RH
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertes et notifications -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h6 class="text-primary fw-bold m-0">
                            <i class="fas fa-bell me-2"></i>
                            Notifications & Alertes
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="alert alert-info border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>{{ $candidaturesEnAttente }}</strong> candidatures en attente de traitement
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-success border-0" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>{{ $offresEmploiActives }}</strong> offres d'emploi actives
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-warning border-0" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Prochaine évaluation dans 5 jours
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
