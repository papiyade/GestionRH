@extends('layout.admin_rh')

@section('content')
<style>
    .stats-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 32px 24px;
    }

    .stats-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .stats-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-header p {
        color: #7f8c8d;
        font-size: 1.1rem;
        margin-top: 8px;
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .kpi-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(174, 61, 125, 0.15);
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #AE3D7D 0%, #861254FF 100%);
    }

    .kpi-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
    }

    .kpi-icon.purple {
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.1) 0%, rgba(134, 18, 84, 0.1) 100%);
        color: #AE3D7D;
    }

    .kpi-icon.blue {
        background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(21, 101, 192, 0.1) 100%);
        color: #2196F3;
    }

    .kpi-icon.green {
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(56, 142, 60, 0.1) 100%);
        color: #4CAF50;
    }

    .kpi-icon.orange {
        background: linear-gradient(135deg, rgba(255, 152, 0, 0.1) 0%, rgba(245, 124, 0, 0.1) 100%);
        color: #FF9800;
    }

    .kpi-label {
        color: #7f8c8d;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .kpi-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1;
        margin-bottom: 12px;
    }

    .kpi-detail {
        color: #999;
        font-size: 0.85rem;
    }

    /* Section Headers */
    .section-header {
        margin: 48px 0 24px;
        padding-bottom: 12px;
        border-bottom: 3px solid #f0f0f0;
    }

    .section-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header h2 i {
        color: #AE3D7D;
        font-size: 1.6rem;
    }

    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }

    .chart-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 24px;
    }

    /* Progress Bars */
    .progress-item {
        margin-bottom: 24px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .progress-label span:first-child {
        font-weight: 600;
        color: #2c3e50;
    }

    .progress-label span:last-child {
        color: #AE3D7D;
        font-weight: 700;
    }

    .progress-bar-custom {
        height: 12px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #AE3D7D 0%, #861254FF 100%);
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    /* List Items */
    .list-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .list-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .list-item:hover {
        background: #f8f9fa;
    }

    .list-item-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 20px;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
    }

    .list-item-content {
        flex: 1;
    }

    .list-item-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .list-item-subtitle {
        color: #999;
        font-size: 0.85rem;
    }

    .list-item-value {
        font-weight: 700;
        font-size: 1.2rem;
        color: #AE3D7D;
    }

    /* Grid Layouts */
    .two-col-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .two-col-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    /* Badge */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-badge.success {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.warning {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.danger {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<div class="stats-container">
    <!-- Header -->
    <div class="stats-header">
        <h1><i class="bi bi-graph-up-arrow me-2"></i>Statistiques & Rapports</h1>
        <p>Vue d'ensemble complète de votre entreprise</p>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">
        <!-- Total Employés -->
        <div class="kpi-card card">
            <div class="kpi-icon purple">
                <i class="ti ti-users"></i>
            </div>
            <div class="kpi-label txt">Total Employés</div>
            <div class="kpi-value txt">{{ $totalEmployees }}</div>
            <div class="kpi-detail">Actifs dans l'entreprise</div>
        </div>

        <!-- Équipes -->
        <div class="kpi-card card">
            <div class="kpi-icon blue">
                <i class="ti ti-users-group"></i>
            </div>
            <div class="kpi-label txt">Équipes</div>
            <div class="kpi-value txt">{{ $totalTeams }}</div>
            <div class="kpi-detail">{{ $totalMembers }} membres au total</div>
        </div>

        <!-- Projets -->
        <div class="kpi-card card">
            <div class="kpi-icon green">
                <i class="ti ti-briefcase"></i>
            </div>
            <div class="kpi-label txt">Projets Actifs</div>
            <div class="kpi-value txt">{{ $totalProjects }}</div>
            <div class="kpi-detail">En cours de réalisation</div>
        </div>

        <!-- Masse Salariale -->
        <div class="kpi-card card">
            <div class="kpi-icon orange">
                <i class="ti ti-coin"></i>
            </div>
            <div class="kpi-label txt">Masse Salariale Mensuelle</div>
            <div class="kpi-value txt">{{ number_format($totalSalaries, 0, ',', ' ') }}</div>
            <div class="kpi-detail">FCFA / mois</div>
        </div>

        <!-- Candidatures -->
        <div class="kpi-card card">
            <div class="kpi-icon purple">
                <i class="ti ti-file-check"></i>
            </div>
            <div class="kpi-label txt">Candidatures</div>
            {{-- <div class="kpi-value txt">{{ $totalCandidatures }}</div> --}}
            <div class="kpi-detail">{{ $pendingCandidatures }} en attente</div>
        </div>

        <!-- Prestataires -->
        <div class="kpi-card card">
            <div class="kpi-icon blue">
                <i class="ti ti-briefcase"></i>
            </div>
            <div class="kpi-label txt">Prestataires</div>
            <div class="kpi-value txt">{{ $totalPrestataires }}</div>
            <div class="kpi-detail">Partenaires externes</div>
        </div>

        <!-- CRA du mois -->
        <div class="kpi-card card">
            <div class="kpi-icon green">
                <i class="ti ti-file-text"></i>
            </div>
            <div class="kpi-label txt">CRA Ce Mois</div>
            <div class="kpi-value txt">{{ $crasThisMonth }}</div>
            <div class="kpi-detail">{{ $tauxCompletionCRA }}% de complétude</div>
        </div>

        <!-- Documents -->
        <div class="kpi-card card">
            <div class="kpi-icon orange">
                <i class="ti ti-files"></i>
            </div>
            <div class="kpi-label txt">Documents RH</div>
            <div class="kpi-value txt">{{ $totalDocuments }}</div>
            <div class="kpi-detail">Stockés et sécurisés</div>
        </div>
    </div>

    <!-- Section: Ressources Humaines -->
    <div class="section-header">
        <h2><i class="ti ti-users"></i>Ressources Humaines</h2>
    </div>

    <div class="two-col-grid">
        <!-- Répartition par Poste -->
        <div class="chart-card card">
            <h3>Répartition par Poste</h3>
            @if($employeesByPosition->count() > 0)
                @foreach($employeesByPosition as $position)
                <div class="progress-item">
                    <div class="progress-label">
                        <span>{{ $position->fiche_poste ?? 'Non défini' }}</span>
                        <span>{{ $position->total }} employé(s)</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: {{ ($position->total / $totalEmployees) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="ti ti-inbox"></i>
                    <p>Aucune donnée disponible</p>
                </div>
            @endif
        </div>

        <!-- Répartition par Type de Contrat -->
        <div class="chart-card card">
            <h3>Types de Contrat</h3>
            @if($employeesByContract->count() > 0)
                @foreach($employeesByContract as $contract)
                <div class="progress-item">
                    <div class="progress-label">
                        <span>{{ ucfirst($contract->type_contrat ?? 'Non défini') }}</span>
                        <span>{{ $contract->total }} employé(s)</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: {{ ($contract->total / $totalEmployees) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="ti ti-inbox"></i>
                    <p>Aucune donnée disponible</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Section: Projets & Tâches -->
    <div class="section-header">
        <h2><i class="ti ti-briefcase"></i>Projets & Tâches</h2>
    </div>

    <div class="two-col-grid">
        <!-- Projets par Équipe -->
        <div class="list-card card">
            <h3 style="margin-bottom: 24px;">Projets par Équipe</h3>
            @forelse($projectsByTeam as $team)
            <div class="list-item">
                <div class="list-item-icon">{{ substr($team->name, 0, 1) }}</div>
                <div class="list-item-content">
                    <div class="list-item-title txt">{{ $team->name }}</div>
                    <div class="list-item-subtitle">{{ $team->members_count }} membre(s)</div>
                </div>
                <div class="list-item-value">{{ $team->projects_count }}</div>
            </div>
            @empty
            <div class="empty-state">
                <i class="ti ti-inbox"></i>
                <p>Aucune équipe avec projets</p>
            </div>
            @endforelse
        </div>

        <!-- Statut des Tâches -->
        <div class="chart-card card">
            <h3>Statut Global des Tâches</h3>
            <div class="progress-item">
                <div class="progress-label">
                    <span>Complétées</span>
                    {{-- <span>{{ $completedTasks }} / {{ $totalTasks }}</span> --}}
                </div>
                <div class="progress-bar-custom">
                    {{-- <div class="progress-fill" style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div> --}}
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span>En cours</span>
                    {{-- <span>{{ $inProgressTasks }} / {{ $totalTasks }}</span> --}}
                </div>
                <div class="progress-bar-custom">
                    {{-- <div class="progress-fill" style="width: {{ $totalTasks > 0 ? ($inProgressTasks / $totalTasks) * 100 : 0 }}%"></div> --}}
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span>En attente</span>
                    {{-- <span>{{ $pendingTasks }} / {{ $totalTasks }}</span> --}}
                </div>
                <div class="progress-bar-custom">
                    {{-- <div class="progress-fill" style="width: {{ $totalTasks > 0 ? ($pendingTasks / $totalTasks) * 100 : 0 }}%"></div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Candidatures -->
    <div class="section-header">
        <h2><i class="ti ti-file-check"></i>Recrutement</h2>
    </div>

    <div class="two-col-grid">
        <!-- Candidatures par Statut -->
        <div class="chart-card card">
            <h3>Candidatures par Statut</h3>
            <div class="progress-item">
                <div class="progress-label">
                    <span>En attente</span>
                    {{-- <span class="status-badge warning">{{ $pendingCandidatures }}</span> --}}
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span>Acceptées</span>
                    {{-- <span class="status-badge success">{{ $acceptedCandidatures }}</span> --}}
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-label">
                    <span>Rejetées</span>
                    {{-- <span class="status-badge danger">{{ $rejectedCandidatures }}</span> --}}
                </div>
            </div>
        </div>

        <!-- Offres d'emploi -->
        <div class="list-card card">
            <h3 style="margin-bottom: 24px;">Offres d'Emploi Actives</h3>
            {{-- @forelse($jobOffers->take(5) as $offer)
            <div class="list-item">
                <div class="list-item-icon">{{ substr($offer->titre, 0, 1) }}</div>
                <div class="list-item-content">
                    <div class="list-item-title">{{ $offer->titre }}</div>
                    <div class="list-item-subtitle">{{ $offer->candidatures_count ?? 0 }} candidature(s)</div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="ti ti-inbox"></i>
                <p>Aucune offre active</p>
            </div>
            @endforelse --}}
        </div>
    </div>

    <!-- Section: CRA -->
    <div class="section-header">
        <h2><i class="ti ti-file-text"></i>Comptes Rendus d'Activités</h2>
    </div>

    <div class="chart-card card">
        <h3>Activité CRA - 6 Derniers Mois</h3>
        <div class="progress-item">
            <div class="progress-label">
                <span>Taux de soumission ce mois</span>
                <span>{{ $tauxCompletionCRA }}%</span>
            </div>
            <div class="progress-bar-custom">
                <div class="progress-fill" style="width: {{ $tauxCompletionCRA }}%"></div>
            </div>
        </div>
        <div class="mt-4" style="color: #666;">
            <p><i class="ti ti-info-circle me-2"></i>{{ $crasThisMonth }} CRA soumis ce mois sur {{ $totalEmployees }} employés</p>
        </div>
    </div>
</div>

@endsection
