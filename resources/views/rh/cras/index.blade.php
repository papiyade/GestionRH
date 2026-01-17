@php
    $layout = 'layout.admin';
    if (Auth::check()) {
        if (Auth::user()->role === 'rh') {
            $layout = 'layout.admin_rh';
        } elseif (Auth::user()->role === 'admin') {
            $layout = 'layout.admin';
        } elseif (Auth::user()->role === 'employe') {
            $layout = 'layout.employe';
        }
    }
@endphp

@extends($layout)

@section('content')
<style>

    .bg-linear-gradiant {
        background: linear-gradient(115.43deg, #FFFFFF 0.45%, #FFF3ED 100%);
    }
    .cra-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(242, 101, 34, 0.2);
    }

    .cra-header h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }

    .stat-card {
        text-align: center;
        background: rgb(245, 240, 244);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: none;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
    }

    .stat-icon.success {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
    }

    .stat-icon.warning {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
    }

    .stat-icon.info {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
    }

    .stat-value {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1;
        margin: 12px 0;
    }

    .stat-label {
        text-align: center;
        color: #7f8c8d;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .stat-detail {
        text-align: center;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
        font-size: 0.9rem;
        color: #555;
    }

    .progress-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        height: 100%;
    }

    .progress-card-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 20px;
    }

    .progress-card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .progress-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .month-column {
        background: white;
        border-radius: 12px;
        padding: 20px;
        min-width: 380px;
        max-width: 380px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        height: fit-content;
    }

    .month-header {
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 3px solid #AE3D7D;
    }

    .month-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .month-count {
        color: #7f8c8d;
        font-size: 0.95rem;
    }

    .cra-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 16px;
        border-left: 4px solid #AE3D7D;
        transition: all 0.2s;
    }

    .cra-card:hover {
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }

    .cra-user {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .cra-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #AE3D7D 0%, #ff8c52 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .cra-user-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1.05rem;
    }

    .cra-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: #555;
    }

    .cra-info-item i {
        color: #AE3D7D;
        width: 20px;
    }

    .cra-badges {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin: 12px 0;
    }

    .cra-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .cra-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        margin-top: 12px;
        border-top: 1px solid #e0e0e0;
    }

    .cra-date {
        font-size: 0.85rem;
        color: #999;
    }

    .cra-action-btns {
        display: flex;
        gap: 8px;
    }

    .cra-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        cursor: pointer;
    }

    .cra-action-btn:hover {
        transform: translateY(-2px);
    }

    .cra-action-btn.view {
        background: #e3f2fd;
        color: #1976d2;
    }

    .cra-action-btn.edit {
        background: #fff3e0;
        color: #AE3D7D;
    }

    .cra-action-btn.delete {
        background: #ffebee;
        color: #d32f2f;
    }

    .months-container {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        padding-bottom: 20px;
    }

    .months-container::-webkit-scrollbar {
        height: 8px;
    }

    .months-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .months-container::-webkit-scrollbar-thumb {
        background: #AE3D7D;
        border-radius: 10px;
    }

    .alert-custom {
        border-radius: 10px;
        border: none;
        padding: 16px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .alert-custom.warning {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .empty-state i {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 24px;
    }

    .empty-state h4 {
        color: #999;
        margin-bottom: 12px;
    }

    .empty-state p {
        color: #bbb;
        margin-bottom: 24px;
    }

    .btn-new-cra {
        background: #fff;
        color: #AE3D7D;
        padding: 12px 28px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-new-cra:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(242, 101, 34, 0.3);
        color: #AE3D7D;
    }

    .top-employees-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .employee-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.2s;
    }

    .employee-item:hover {
        background: #f8f9fa;
    }

    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 12px;
    }

    .completion-progress {
        height: 8px;
        border-radius: 10px;
        background: #e0e0e0;
        overflow: hidden;
        margin: 8px 0;
    }

    .completion-fill {
        height: 100%;
        background: linear-gradient(90deg, #AE3D7D 0%, #ff8c52 100%);
        border-radius: 10px;
        transition: width 0.3s;
    }
</style>

<div class="container-fluid py-4">
    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745; border-radius: 10px;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="cra-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h2 class=" title-cras"><i class="bi bi-file-earmark-text "></i>Comptes Rendus d'Activités</h2>
                <p class="mb-0 mt-2 opacity-90 me-2 title-cras">Suivi et gestion des CRA de l'équipe</p>
            </div>
            <button class="btn-new-cra" data-bs-toggle="modal" data-bs-target="#add_deals">
                <i class="ti ti-file-plus fw-bold"></i>
                Nouveau CRA
            </button>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="ti ti-users icon-plus"></i>
                </div>
                <div class="stat-label">Total Employés</div>
                <div class="stat-value">{{ $stats['totalEmployes'] }}</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="ti ti-files icon-plus"></i>
                </div>
                <div class="stat-label">CRA Cette Semaine</div>
                <div class="stat-value">{{ $stats['crasThisWeek'] }}</div>
                <div class="stat-detail">
                    <i class="ti ti-user-check me-1"></i>
                    {{ $stats['employesCrasThisWeek'] }}/{{ $stats['totalEmployes'] }} employés
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="ti ti-message-2-check icon-plus"></i>
                </div>
                <div class="stat-label">Taux de Complétude</div>
                <div class="stat-value">{{ $stats['tauxCompletionThisWeek'] }}%</div>
                <div class="stat-detail text-danger">
                    <i class="ti ti-square-off me-1"></i>
                    {{ $stats['employsManquantThisWeek'] }} manquant(s)
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="ti ti-circle-dashed-check icon-plus"></i>
                </div>
                <div class="stat-label">CRA Complétés</div>
                <div class="stat-value">{{ $stats['crasCompletes'] }}</div>
                <div class="stat-detail text-success" style="color: #1f6623;">
                    <i class="ti ti-checkup-list me-1"></i>
                    Tous les champs remplis
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="progress-card">
                <div class="progress-card-header">
                    <div class="progress-card-title">CRA Ce Mois</div>
                    <span class="progress-badge" style="background: #e3f2fd; color: #1976d2;">
                        {{ $stats['crasThisMonth'] }} CRA
                    </span>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">{{ $stats['employesCrasThisMonth'] }}/{{ $stats['totalEmployes'] }}</span>
                        <span class="text-muted">employés ont soumis</span>
                    </div>
                    <div class="completion-progress">
                        <div class="completion-fill" style="width: {{ ($stats['employesCrasThisMonth'] / $stats['totalEmployes']) * 100 }}%"></div>
                    </div>
                    <div class="text-end mt-2">
                        <small class="fw-bold" style="color: #F26522;">
                            {{ round(($stats['employesCrasThisMonth'] / $stats['totalEmployes']) * 100, 1) }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="progress-card">
                <div class="progress-card-header">
                    <div class="progress-card-title">CRA Complétés Ce Mois</div>
                    <span class="progress-badge" style="background: #e8f5e9; color: #2e7d32;">
                        {{ $stats['crasCompletesMonth'] }} CRA
                    </span>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">{{ $stats['crasCompletesMonth'] }}/{{ $stats['crasThisMonth'] }}</span>
                        <span class="text-muted">avec tous les champs</span>
                    </div>
                    <div class="completion-progress">
                        <div class="completion-fill" style="width: {{ $stats['crasThisMonth'] > 0 ? ($stats['crasCompletesMonth'] / $stats['crasThisMonth']) * 100 : 0 }}%"></div>
                    </div>
                    <div class="text-end mt-2">
                        <small class="fw-bold" style="color: #F26522;">
                            {{ $stats['crasThisMonth'] > 0 ? round(($stats['crasCompletesMonth'] / $stats['crasThisMonth']) * 100, 1) : 0 }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Employés Manquants --}}
    @if ($stats['employsManquantThisWeek'] > 0)
        <div class="alert-custom warning mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="warning-cras">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Attention!</strong> {{ $stats['employsManquantThisWeek'] }} employé(s) n'a/ont pas encore soumis de CRA cette semaine.
                </div>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#employees-without-cra">
                    Voir la liste
                </button>
            </div>
        </div>
    @endif

    {{-- Top Employés --}}
    @if ($stats['topEmployes']->count() > 0)
        <div class="top-employees-card mb-4">
            <h5 class="mb-4" style="background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%); color: white; padding: 10px 16px; border-radius: 8px;">
                <i class="bi bi-trophy-fill text-warning me-2"></i>Top 5 Employés</h5>
            @foreach($stats['topEmployes'] as $index => $employe)
                <div class="employee-item">
                    <div class="employee-avatar">
                        {{ strtoupper(substr($employe->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold">{{ $employe->user->name }}</div>
                        <small class="text-muted">{{ $employe->cra_count }} CRA soumis</small>
                    </div>
                    <span class="badge badge-text" style="background: #e3f2fd; color: #1976d2;">
                        #{{ $index + 1 }}
                    </span>
                </div>
                <hr>
            @endforeach
        </div>
    @endif

    {{-- CRA par Mois --}}
    @php
        $crasParMois = $cras->groupBy(function ($cra) {
            return \Carbon\Carbon::parse($cra->created_at)->format('Y-m');
        });
    @endphp

    @if($crasParMois->count() > 0)
        <div class="months-container">
            @foreach ($crasParMois as $mois => $crasDuMois)
                <div class="month-column">
                    <div class="month-header">
                        <div class="month-title">
                            <i class="bi bi-calendar-month" style="color: #F26522;"></i>
                            {{ \Carbon\Carbon::parse($mois)->locale('fr')->isoFormat('MMMM YYYY') }}
                        </div>
                        <div class="month-count">{{ $crasDuMois->count() }} CRA</div>
                    </div>

                    <div style="max-height: 700px; overflow-y: auto; padding-right: 8px;">
                        @foreach ($crasDuMois as $cra)
                            <div class="cra-card">
                                <div class="cra-user">
                                    <div class="cra-avatar">
                                        {{ strtoupper(substr($cra->user->name, 0, 1)) }}
                                    </div>
                                    <div class="cra-user-name">{{ $cra->user->name }}</div>
                                </div>

                                <div class="cra-info-item">
                                    <i class="bi bi-calendar-range"></i>
                                    Du {{ \Carbon\Carbon::parse($cra->date_debut)->format('d/m/Y') }}
                                    au {{ \Carbon\Carbon::parse($cra->date_fin)->format('d/m/Y') }}
                                </div>

                                <div class="cra-info-item">
                                    <i class="bi bi-list-task"></i>
                                    {{ Str::limit($cra->activites, 80) }}
                                </div>

                                @if ($cra->commentaires)
                                    <div class="cra-info-item">
                                        <i class="bi bi-chat-left-quote"></i>
                                        {{ Str::limit($cra->commentaires, 60) }}
                                    </div>
                                @endif

                                <div class="cra-badges">
                                    @if ($cra->bien_fonctionne)
                                        <span class="cra-badge" style="background: #d4edda; color:  #155724 !important;">
                                            <i class="bi bi-check-circle"></i> Positif
                                        </span>
                                    @endif
                                    @if ($cra->pas_bien_fonctionne)
                                        <span class="cra-badge" style="background: #fff3cd; color: #856404 !important;">
                                            <i class="bi bi-exclamation-triangle"></i> Négatif
                                        </span>
                                    @endif
                                    @if ($cra->points_durs)
                                        <span class="cra-badge" style="background: #f8d7da; color: #721c24 !important;">
                                            <i class="bi bi-exclamation-circle"></i> Points durs
                                        </span>
                                    @endif
                                    @if ($cra->next_steps)
                                        <span class="cra-badge" style="background: #d1ecf1; color: #0c5460 !important;">
                                            <i class="bi bi-arrow-right-circle"></i> Next steps
                                        </span>
                                    @endif
                                </div>

                                <div class="cra-info-item mt-2">
                                    <i class="ti ti-percentage-10"></i>
                                    Complétude: {{ $cra->getCompletion() ?? '0' }}%
                                </div>

                                <div class="cra-actions">
                                    <span class="cra-date">
                                        <i class="ti ti-clock"></i>
                                        {{ $cra->created_at->format('d/m/Y') }}
                                    </span>
                                    <div class="cra-action-btns">
                                        <a href="{{ route('cras.show', $cra) }}" class="cra-action-btn view">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if (Auth::id() === $cra->user_id || Auth::user()->role === 'rh')
                                            <a href="{{ route('cras.edit', $cra) }}" class="cra-action-btn edit">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('cras.destroy', $cra) }}" method="POST" style="display: inline;"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce CRA ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cra-action-btn delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h4>Aucun CRA disponible pour le moment</h4>
            <p>Créez votre premier compte rendu d'activité en cliquant sur le bouton ci-dessous</p>
            <button class="btn-new-cra" data-bs-toggle="modal" data-bs-target="#add_deals">
                <i class="bi bi-plus-lg"></i>
                Créer un CRA
            </button>
        </div>
    @endif
</div>

{{-- Modals conservés (add_deals, employees-without-cra) --}}
{{-- ... Copiez vos modals existants ici ... --}}
        <!-- Modal de création d'un nouveau CRA -->
    <div class="modal fade" id="add_deals">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau CRA</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('cras.store') }}" method="POST">
                    @csrf

                    <div class="modal-body pb-0">
                        <div class="alert alert-info border-0">
                            <i class="fas fa-lightbulb"></i>
                            <strong>CRA = Compte Rendu d'Activité</strong> - Documentez vos activités hebdomadaires, vos
                            projets, les points difficiles et vos recommandations.
                        </div>

                        <!-- Section Dates -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-calendar"></i> Période du CRA
                        </h5>
                        <div class="row mb-4 col-xl-12">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Date Début *</label>
                                <div class="input-group">
                                    <input type="text" name="date_debut" placeholder="dd/mm/yyyy"
                                        class="form-control datetimepicker @error('date_debut') is-invalid @enderror"
                                        value="{{ old('date_debut', now()->startOfWeek()->format('d/m/Y')) }}" required
                                        autocomplete="off">
                                    <span class="input-group-text bg-white">
                                        <i class="ti ti-calendar-event text-primary"></i>
                                    </span>
                                </div>
                                <small class="text-muted">Premier jour de la semaine</small>
                                @error('date_debut')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Date Fin *</label>
                                <div class="input-group">
                                    <input type="text" name="date_fin" placeholder="dd/mm/yyyy"
                                        class="form-control datetimepicker @error('date_fin') is-invalid @enderror"
                                        value="{{ old('date_fin', now()->endOfWeek()->format('d/m/Y')) }}" required
                                        autocomplete="off">
                                    <span class="input-group-text bg-white">
                                        <i class="ti ti-calendar-event text-primary"></i>
                                    </span>
                                </div>
                                <small class="text-muted">Dernier jour de la semaine</small>
                                @error('date_fin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($teams->count() > 0)
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Équipe (Optionnel)</label>
                                    <select name="team_id" class="form-select @error('team_id') is-invalid @enderror">
                                        <option value="">-- Sélectionner une équipe --</option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}"
                                                {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Section Activités -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-tasks"></i> Activités / Projets
                        </h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Activités Principales * <span
                                    class="text-danger">●</span></label>
                            <textarea name="activites" class="form-control @error('activites') is-invalid @enderror" rows="5" required
                                placeholder="Décrivez vos activités et projets de la semaine:&#10;- Projet/Action 1&#10;- Projet/Action 2&#10;- Réunions importantes&#10;- Etc.">{{ old('activites') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Énumérez tous vos projets, actions et activités
                                principales
                            </small>
                            @error('activites')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Positive/Négative -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-chart-pie"></i> Analyse de la Semaine
                        </h5>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="card bg-light border-success">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-circle"></i> Ce qui a bien fonctionné
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="bien_fonctionne" class="form-control @error('bien_fonctionne') is-invalid @enderror" rows="4"
                                            placeholder="Décrivez les points positifs et succès...">{{ old('bien_fonctionne') }}</textarea>
                                        @error('bien_fonctionne')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card bg-light border-danger">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-times-circle"></i> Ce qui n'a pas bien fonctionné
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="pas_bien_fonctionne" class="form-control @error('pas_bien_fonctionne') is-invalid @enderror"
                                            rows="4" placeholder="Décrivez les difficultés, obstacles...">{{ old('pas_bien_fonctionne') }}</textarea>
                                        @error('pas_bien_fonctionne')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Points Durs -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-exclamation-triangle"></i> Points Durs & Faits Marquants
                        </h5>
                        <div class="mb-4">
                            <textarea name="points_durs" class="form-control @error('points_durs') is-invalid @enderror" rows="4"
                                placeholder="Décrivez les situations difficiles, les obstacles rencontrés ou les événements importants...">{{ old('points_durs') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Quels sont les défis à relever, les blocages ou les
                                faits marquants?
                            </small>
                            @error('points_durs')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Next Steps -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-arrow-right"></i> Prochaines Étapes (Next Steps)
                        </h5>
                        <div class="mb-4">
                            <textarea name="next_steps" class="form-control @error('next_steps') is-invalid @enderror" rows="4"
                                placeholder="- Tâche 1 (échéance: date)&#10;- Tâche 2 (échéance: date)&#10;- Suivi de...&#10;- Etc.">{{ old('next_steps') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Planifiez vos prochaines actions et définissez les
                                échéances
                            </small>
                            @error('next_steps')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Commentaires -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-comment"></i> Commentaires & Recommandations
                        </h5>
                        <div class="mb-4">
                            <textarea name="commentaires" class="form-control @error('commentaires') is-invalid @enderror" rows="4"
                                placeholder="Ajoutez vos recommandations, observations ou commentaires supplémentaires...">{{ old('commentaires') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Recommandations pour l'équipe, observations,
                                autocritique...
                            </small>
                            @error('commentaires')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Soumettre le CRA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Modal liste des employés qui n'ont pas envoyés de CRA --}}
    <!-- Employés Sans CRA Cette Semaine -->

    <div class="modal fade" id="employees-without-cra">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Employés sans CRA cette semaine</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($stats['employsManquantThisWeek'] > 0)
                        <table class="table datatable table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $idsCrasThisWeek = \App\Models\Cra::whereBetween('date_debut', [
                                        \Carbon\Carbon::now()->startOfWeek(),
                                        \Carbon\Carbon::now()->endOfWeek(),
                                    ])
                                        ->pluck('user_id')
                                        ->toArray();

                                    $employesManquants = \App\Models\User::where(
                                        'entreprise_id',
                                        Auth::user()->entreprise_id,
                                    )
                                        ->whereNotIn('id', $idsCrasThisWeek)
                                        ->get();
                                @endphp

                                @foreach ($employesManquants as $index => $employe)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $employe->name }}</td>
                                        <td>{{ $employe->email }}</td>
                                        <td>{{ $employe->telephone ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-success text-center">
                            Tous les employés ont soumis leur CRA cette semaine ✅
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>


    @if ($stats['employesSansCra']->count() > 0)
        <div class="card border-0 shadow-sm mb-4" id="employees-without-cra">
            <div class="card-header bg-linear-gradient text-white" style="background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);">
                <h5 class="card-title mb-0 text-white">
                    <i class="ti ti-alert-circle"></i> Employés Sans CRA (Jamais)
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($stats['employesSansCra'] as $employe)
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center p-2 border rounded">
                                <div class="avatar avatar-sm bg-primary text-white me-2">
                                    <span>{{ strtoupper(substr($employe->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <strong>{{ $employe->name }}</strong><br>
                                    <small class="text-muted">{{ $employe->email }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection
