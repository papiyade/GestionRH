@php
    $layout = 'layout.admin'; // par défaut pour admin

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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">CRAs</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        CRA
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des CRA</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            <div class="mb-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#add_deals"
                    class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Nouveau CRA</a>
            </div>
            <div class="head-icons ms-2">
                <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Collapse" id="collapse-header">
                    <i class="ti ti-chevrons-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Deals Grid -->
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5>Comptes rendus et Activités</h5>
            </div>
        </div>
    </div>
    <!-- Statistiques Globales de l'Entreprise -->
    <div class="row mb-4">
        <!-- Total Employés -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Employés</p>
                            <h4 class="fw-bold mb-0">{{ $stats['totalEmployes'] }}</h4>
                        </div>
                        <div class="avatar avatar-lg bg-primary bg-opacity-10 text-primary rounded">
                            <i class="ti ti-users fs-15"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CRA cette semaine -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">CRA Cette Semaine</p>
                            <h4 class="fw-bold mb-0">{{ $stats['crasThisWeek'] }}</h4>
                            <small class="text-success">
                                <i class="ti ti-users"></i>
                                {{ $stats['employesCrasThisWeek'] }}/{{ $stats['totalEmployes'] }} employés
                            </small>
                        </div>
                        <div class="avatar avatar-lg bg-success bg-opacity-10 text-success rounded">
                            <i class="ti ti-file-check fs-15"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taux de Complétude -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Taux de Complétude</p>
                            <h4 class="fw-bold mb-0">{{ $stats['tauxCompletionThisWeek'] }}%</h4>
                            <small class="text-danger">
                                <i class="ti ti-alert-circle"></i>
                                {{ $stats['employsManquantThisWeek'] }} employé(s) manquant(s)
                            </small>
                        </div>
                        <div class="avatar avatar-lg bg-warning bg-opacity-10 text-warning rounded">
                            <i class="ti ti-chart-line fs-15"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CRA Complétés Cette Semaine -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">CRA Complétés</p>
                            <h4 class="fw-bold mb-0">{{ $stats['crasCompletes'] }}</h4>
                            <small class="text-info">
                                <i class="ti ti-check"></i> Tous les champs remplis
                            </small>
                        </div>
                        <div class="avatar avatar-lg bg-info bg-opacity-10 text-info rounded">
                            <i class="ti ti-checkbox fs-15"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">CRA Ce Mois</h5>
                    <span class="badge bg-primary">{{ $stats['crasThisMonth'] }} CRA</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $stats['employesCrasThisMonth'] }}/{{ $stats['totalEmployes'] }}
                            </h3>
                            <small class="text-muted">employés ont soumis un CRA</small>
                        </div>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ ($stats['employesCrasThisMonth'] / $stats['totalEmployes']) * 100 }}%"
                            aria-valuenow="{{ $stats['employesCrasThisMonth'] }}" aria-valuemin="0"
                            aria-valuemax="{{ $stats['totalEmployes'] }}">
                            {{ round(($stats['employesCrasThisMonth'] / $stats['totalEmployes']) * 100, 1) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CRA Complétés Ce Mois -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">CRA Complétés Ce Mois</h5>
                    <span class="badge bg-info">{{ $stats['crasCompletesMonth'] }} CRA</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <h3 class="fw-bold mb-0">{{ $stats['crasCompletesMonth'] }}/{{ $stats['crasThisMonth'] }}</h3>
                            <small class="text-muted">CRA avec tous les champs remplis</small>
                        </div>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" role="progressbar"
                            style="width: {{ $stats['crasThisMonth'] > 0 ? ($stats['crasCompletesMonth'] / $stats['crasThisMonth']) * 100 : 0 }}%"
                            aria-valuenow="{{ $stats['crasCompletesMonth'] }}" aria-valuemin="0"
                            aria-valuemax="{{ $stats['crasThisMonth'] }}">
                            {{ $stats['crasThisMonth'] > 0 ? round(($stats['crasCompletesMonth'] / $stats['crasThisMonth']) * 100, 1) : 0 }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employés Manquants Cette Semaine -->
    @if ($stats['employsManquantThisWeek'] > 0)
        <div class="alert alert-warning border-0 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="ti ti-alert-circle"></i>
                    <strong>Attention!</strong> {{ $stats['employsManquantThisWeek'] }} employé(s) n'a/ont pas encore
                    soumis de CRA cette semaine.
                </div>
                <a href="#employees-without-cra" data-bs-toggle="modal" data-bs-target="#employees-without-cra"
                    class="btn btn-sm btn-warning">Voir la liste</a>
            </div>
        </div>
    @endif

    <!-- Top Employés -->
    @if ($stats['topEmployes']->count() > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ti ti-star"></i> Top 5 Employés (Nombre de CRA)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Employé</th>
                                <th class="text-center">Nombre de CRA</th>
                                <th class="text-center">Taux de Complétude</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['topEmployes'] as $employe)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-primary text-white me-2">
                                                <span>{{ strtoupper(substr($employe->user->name, 0, 1)) }}</span>
                                            </div>
                                            {{ $employe->user->name }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $employe->cra_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">100%</span>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


    @php
        // Grouper les CRA selon le mois de création
        $crasParMois = $cras->groupBy(function ($cra) {
            return \Carbon\Carbon::parse($cra->created_at)->format('Y-m');
        });
    @endphp

    <!-- CRA Groupés par Mois -->
    <div class="d-flex overflow-x-auto align-items-start mb-4" style="gap: 20px;">
        @forelse ($crasParMois as $mois => $crasDuMois)
            @php
                $nbMois = $crasParMois->count();
                if ($nbMois == 1) {
                    $colClass = 'col-xl-6 col-md-8';
                } elseif ($nbMois == 2) {
                    $colClass = 'col-xl-6 col-md-6';
                } elseif ($nbMois == 3) {
                    $colClass = 'col-lg-4 col-md-6';
                } else {
                    $colClass = 'col-lg-3 col-md-4';
                }
            @endphp

            <div class="{{ $colClass }}  kanban-list-items bg-white rounded shadow-sm p-3"
                style="min-width: 350px; flex-shrink: 0;">
                <!-- En-tête du mois -->
                <div class="card mb-0 border-0">
                    <div class="card-body pb-2 pt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-medium d-flex align-items-center mb-1">
                                    <i class="ti ti-circle-filled fs-8 text-primary me-2"></i>
                                    {{ \Carbon\Carbon::parse($mois)->locale('fr')->isoFormat('MMMM YYYY') }}
                                </h4>
                                <span class="fw-normal text-default">
                                    {{ $crasDuMois->count() }} CRA{{ $crasDuMois->count() > 1 ? 's' : '' }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="action-icon d-inline-flex gap-2">
                                    <span class="badge rounded-pill border border-primary text-primary bg-white small">
                                        Total: {{ $crasDuMois->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des CRA du mois -->
                <div class="kanban-drag-wrap pt-3" style="max-height: 600px; overflow-y: auto;">
                    @forelse ($crasDuMois as $cra)
                        <div class="card kanban-card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-block">
                                    <div class="border-primary border border-2 mb-3"></div>
                                    <div class="d-flex align-items-center mb-3">
                                        <a href="#" class="avatar avatar-lg bg-gray flex-shrink-0 me-2">
                                            <span
                                                class="avatar-title text-dark">{{ strtoupper(substr($cra->user->name, 0, 1)) }}</span>
                                        </a>
                                        <h6 class="fw-medium mb-0">
                                            <a href="{{ route('cras.show', $cra) }}">CRA de {{ $cra->user->name }}</a>
                                        </h6>
                                    </div>
                                </div>

                                <div class="mb-3 d-flex flex-column">
                                    <p class="text-default d-inline-flex align-items-center mb-2">
                                        <i class="ti ti-calendar-event text-dark me-2"></i>
                                        Du {{ \Carbon\Carbon::parse($cra->date_debut)->format('d/m/Y') }}
                                        au {{ \Carbon\Carbon::parse($cra->date_fin)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2">
                                        <i class="ti ti-list text-dark me-2"></i>
                                        {{ Str::limit($cra->activites, 100) }}
                                    </p>
                                    @if ($cra->commentaires)
                                        <div class="mb-3">
                                            <strong class="text-muted d-block mb-2">Notes:</strong>
                                            <p class="card-text text-truncate"
                                                style="max-height: 40px; overflow: hidden;">
                                                {{ Str::limit($cra->commentaires, 80) }}
                                            </p>
                                        </div>
                                    @endif
                                    <p class="text-default d-inline-flex align-items-center mb-2">
                                        <i class="ti ti-progress text-primary me-2"></i>
                                        Complétude: {{ $cra->getCompletion() ?? '0' }}%
                                    </p>

                                    <!-- Badges statut -->
                                    <div class="d-flex gap-1 mt-2">
                                        @if ($cra->bien_fonctionne)
                                            <span class="badge badge-sm bg-success-transparent text-success"
                                                title="Points positifs remplis">
                                                <i class="ti ti-check"></i>
                                            </span>
                                        @endif
                                        @if ($cra->pas_bien_fonctionne)
                                            <span class="badge badge-sm bg-warning-transparent text-warning"
                                                title="Points négatifs remplis">
                                                <i class="ti ti-alert-triangle"></i>
                                            </span>
                                        @endif
                                        @if ($cra->points_durs)
                                            <span class="badge badge-sm bg-danger-transparent text-danger"
                                                title="Points durs remplis">
                                                <i class="ti ti-exclamation-circle"></i>
                                            </span>
                                        @endif
                                        @if ($cra->next_steps)
                                            <span class="badge badge-sm bg-info-transparent text-info"
                                                title="Next steps remplis">
                                                <i class="ti ti-arrow-right"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                    <span class="text-dark small">
                                        <i class="ti ti-calendar-due text-gray-5"></i>
                                        Créé le {{ $cra->created_at->format('d/m/Y') }}
                                    </span>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('cras.show', $cra) }}" class="text-primary me-2"
                                            title="Voir">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if (Auth::id() === $cra->user_id || Auth::user()->role === 'rh')
                                            <a href="{{ route('cras.edit', $cra) }}" class="text-secondary me-2"
                                                title="Éditer">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('cras.destroy', $cra) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce CRA ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0"
                                                    title="Supprimer">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="ti ti-inbox" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Aucun CRA pour ce mois</h4>
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-inbox" style="font-size: 4rem; color: #ccc;"></i>
                        <h4 class="mt-3 text-muted">Aucun CRA disponible pour le moment</h4>
                        <p class="text-muted">Créez votre premier compte rendu d'activité en cliquant sur le bouton
                            ci-dessous</p>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#add_deals"
                            class="btn btn-primary mt-2">
                            <i class="ti ti-plus"></i> Créer un CRA
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

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
                                    <div class="card-header bg-danger text-white">
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
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0 text-white">
                    <i class="ti ti-alert-circle"></i> Employés Sans CRA (Jamais)
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($stats['employesSansCra'] as $employe)
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center p-2 border rounded">
                                <div class="avatar avatar-sm bg-danger text-white me-2">
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
