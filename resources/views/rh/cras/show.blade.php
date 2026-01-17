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
@section('title', 'Voir le CRA')
@section('content')
<style>
    .progress-modern {
    width: 100%;
    height: 10px;
    background-color: #e5e7eb; /* gris clair */
    border-radius: 8px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    border-radius: 8px;
    transition: width 0.6s ease;
}

    .cra-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px #bfa7b5;
    }

    .cra-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .cra-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .cra-card-header {
        background: #f8f9fa;
        border-bottom: 2px solid #c8a1b7;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cra-card-header i {
        color: #AE3D7D;
        font-size: 1.1rem;
    }

    .cra-card-body {
        padding: 1.5rem;
        line-height: 1.8;
        color: #495057;
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fff5f0;
        border: 1px solid #ffe4d6;
        color: #AE3D7D;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .user-avatar {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #AE3D7D, #ff8c42);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.25);
    }

    .meta-info {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #f0f0f0;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .meta-item:last-child {
        margin-bottom: 0;
    }

    .meta-item i {
        color: #AE3D7D;
        width: 20px;
    }

    .meta-item strong {
        color: #2c3e50;
        font-weight: 600;
    }

    .completion-card {
        background: linear-gradient(135deg, #fff5f0 0%, #ffffff 100%);
        border: 1px solid #ffe4d6;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }

    .completion-value {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #AE3D7D, #ff8c42);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .completion-label {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .progress-modern {
        height: 8px;
        border-radius: 10px;
        background: #f0f0f0;
        overflow: hidden;
        margin-top: 1rem;
    }

    .progress-modern .progress-bar {
        background: linear-gradient(90deg, #AE3D7D, #ff8c42);
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    .btn-orange {
        background: linear-gradient(135deg, #AE3D7D, #ff8c42);
        border: none;
        color: white;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255, 107, 53, 0.2);
    }

    .btn-orange:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        color: white;
    }

    .btn-outline-orange {
        background: white;
        border: 2px solid #AE3D7D;
        color: #AE3D7D;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-orange:hover {
        background: #AE3D7D;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.2);
    }

    .team-alert {
        background: #fff5f0;
        border-left: 4px solid #AE3D7D;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #AE3D7D;
        font-weight: 500;
    }

    .empty-state {
        color: #adb5bd;
        font-style: italic;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e9ecef, transparent);
        margin: 2rem 0;
    }
</style>

<div class="container-fluid py-4">
    <!-- En-tête principal -->
    <div class="cra-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-file-alt" style="font-size: 1.5rem;"></i>
                    <h2 class="mb-0 fw-bold text-white">Compte Rendu d'Activité</h2>
                </div>
                <div class="d-flex align-items-center gap-2" style="font-size: 1.05rem; opacity: 0.95;">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Semaine du {{ $cra->date_debut->format('d M Y') }} au {{ $cra->date_fin->format('d M Y') }}</span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('cras.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Informations utilisateur et métriques -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="meta-info h-100">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="user-avatar">
                        {{ strtoupper(substr($cra->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold text-dark">{{ $cra->user->name }}</h5>
                        <div class="text-muted">{{ $cra->user->email }}</div>
                    </div>
                </div>
                <div class="section-divider my-3"></div>
                <div class="meta-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Créé le</span>
                    <strong>{{ $cra->created_at->format('d/m/Y à H:i') }}</strong>
                </div>
                <div class="meta-item">
                    <i class="fas fa-edit"></i>
                    <span>Modifié le</span>
                    <strong>{{ $cra->updated_at->format('d/m/Y à H:i') }}</strong>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="completion-card h-100">
                <div class="completion-value">{{ $cra->getCompletion() }}%</div>
                <div class="completion-label">Complétude</div>
<div class="progress-modern">
    <div
        class="progress-bar"
        role="progressbar"
        aria-valuenow="{{ $cra->getCompletion() }}"
        aria-valuemin="0"
        aria-valuemax="100"
        style="width: {{ $cra->getCompletion() }}%;">
    </div>
</div>

            </div>
        </div>
    </div>

    @if($cra->team)
        <div class="team-alert mb-4">
            <i class="fas fa-users" style="font-size: 1.2rem;"></i>
            <span><strong>Équipe :</strong> {{ $cra->team->name }}</span>
        </div>
    @endif

    <!-- Activités / Projets -->
    <div class="cra-card mb-4">
        <div class="cra-card-header">
            <i class="fas fa-tasks"></i>
            <span>Activités / Projets</span>
        </div>
        <div class="cra-card-body">
            <div style="white-space: pre-wrap;">{{ $cra->activites }}</div>
        </div>
    </div>

    <!-- Points positifs et négatifs -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="cra-card h-100">
                <div class="cra-card-header" style="border-bottom-color: #28a745;">
                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                    <span>Ce qui a bien fonctionné</span>
                </div>
                <div class="cra-card-body">
                    @if(!empty($cra->bien_fonctionne))
                        <div style="white-space: pre-wrap;">{{ $cra->bien_fonctionne }}</div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-info-circle"></i>
                            <span>Non renseigné</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="cra-card h-100">
                <div class="cra-card-header" style="border-bottom-color: #dc3545;">
                    <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                    <span>Ce qui n'a pas bien fonctionné</span>
                </div>
                <div class="cra-card-body">
                    @if(!empty($cra->pas_bien_fonctionne))
                        <div style="white-space: pre-wrap;">{{ $cra->pas_bien_fonctionne }}</div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-info-circle"></i>
                            <span>Non renseigné</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Points durs / Faits marquants -->
    <div class="cra-card mb-4">
        <div class="cra-card-header">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Points Durs / Faits Marquants</span>
        </div>
        <div class="cra-card-body">
            @if(!empty($cra->points_durs))
                <div style="white-space: pre-wrap;">{{ $cra->points_durs }}</div>
            @else
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <span>Non renseigné</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Prochaines étapes -->
    <div class="cra-card mb-4">
        <div class="cra-card-header">
            <i class="fas fa-arrow-right"></i>
            <span>Prochaines Étapes (Next Steps)</span>
        </div>
        <div class="cra-card-body">
            @if(!empty($cra->next_steps))
                <div style="white-space: pre-wrap;">{{ $cra->next_steps }}</div>
            @else
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <span>Non renseigné</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Commentaires / Recommandations -->
    <div class="cra-card mb-4">
        <div class="cra-card-header">
            <i class="fas fa-comments"></i>
            <span>Commentaires / Recommandations</span>
        </div>
        <div class="cra-card-body">
            @if(!empty($cra->commentaires))
                <div style="white-space: pre-wrap;">{{ $cra->commentaires }}</div>
            @else
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <span>Non renseigné</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="d-flex justify-content-end gap-3 mt-4">
        <a href="{{ route('cras.export-pdf', $cra->id) }}" class="btn btn-outline-orange">
            <i class="fas fa-file-pdf me-2"></i>Télécharger en PDF
        </a>
        <a href="{{ route('cras.edit', $cra) }}" class="btn btn-orange">
            <i class="fas fa-edit me-2"></i>Modifier le CRA
        </a>
    </div>
</div>
@endsection
