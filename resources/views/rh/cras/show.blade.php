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
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold mb-1">Compte Rendu d'Activité</h2>
            <div class="text-black small">
                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                Semaine du {{ $cra->date_debut->format('d M Y') }} au {{ $cra->date_fin->format('d M Y') }}
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('cras.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4 align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center mb-2">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; font-size: 1.2rem;">
                    {{ strtoupper(substr($cra->user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold text-dark">{{ $cra->user->name }}</div>
                    <div class="small text-dark">{{ $cra->user->email }}</div>
                </div>
            </div>
            <div class="mb-1">
                <span class="small text-dark">Créé le</span>
                <span class="fw-semibold ms-1 text-dark">{{ $cra->created_at->format('d/m/Y') }}</span>
                <span class="small ms-2 text-dark">{{ $cra->created_at->format('H:i') }}</span>
            </div>
            <div>
                <span class="small text-dark">Modifié le</span>
                <span class="fw-semibold ms-1 text-dark">{{ $cra->updated_at->format('d/m/Y') }}</span>
                <span class="small ms-2 text-dark">{{ $cra->updated_at->format('H:i') }}</span>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="mb-1">
                <span class="small text-dark">Complétude</span>
                <span class="fw-semibold ms-1 text-dark">{{ $cra->getCompletion() }}%</span>
            </div>
            <div class="progress" style="height: 4px; max-width: 300px; margin-left: auto;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $cra->getCompletion() }}%"></div>
            </div>
        </div>
    </div>

    @if($cra->team)
        <div class="alert alert-info d-flex align-items-center gap-2 py-2 px-3 mb-4 border-0">
            <i class="fas fa-users"></i>
            <span><strong>Équipe:</strong> {{ $cra->team->name }}</span>
        </div>
    @endif

    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-secondary text-white py-2">
            <i class="fas fa-tasks me-2"></i> Activités / Projets
        </div>
        <div class="card-body">
            <div class="lh-lg" style="white-space: pre-wrap;">{{ $cra->activites }}</div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-success text-white py-2">
                    <i class="fas fa-thumbs-up me-2"></i> Ce qui a bien fonctionné
                </div>
                <div class="card-body">
                    @if(!empty($cra->bien_fonctionne))
                        <div class="lh-lg" style="white-space: pre-wrap;">{{ $cra->bien_fonctionne }}</div>
                    @else
                        <div class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i> Non renseigné</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-danger text-white py-2">
                    <i class="fas fa-thumbs-down me-2"></i> Ce qui n'a pas bien fonctionné
                </div>
                <div class="card-body">
                    @if(!empty($cra->pas_bien_fonctionne))
                        <div class="lh-lg" style="white-space: pre-wrap;">{{ $cra->pas_bien_fonctionne }}</div>
                    @else
                        <div class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i> Non renseigné</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-secondary text-white py-2">
            <i class="fas fa-exclamation-triangle me-2"></i> Points Durs / Faits Marquants
        </div>
        <div class="card-body">
            @if(!empty($cra->points_durs))
                <div class="lh-lg" style="white-space: pre-wrap;">{{ $cra->points_durs }}</div>
            @else
                <div class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i> Non renseigné</div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-secondary text-white py-2">
            <i class="fas fa-arrow-right me-2"></i> Prochaines Étapes (Next Steps)
        </div>
        <div class="card-body">
            @if(!empty($cra->next_steps))
                <div class="lh-lg" style="white-space: pre-wrap;">{{ $cra->next_steps }}</div>
            @else
                <div class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i> Non renseigné</div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-secondary text-white py-2">
            <i class="fas fa-comments me-2"></i> Commentaires / Recommandations
        </div>
        <div class="card-body">
            @if(!empty($cra->commentaires))
                <div class="lh-lg" style="white-space: pre-wrap;">{{ $cra->commentaires }}</div>
            @else
                <div class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i> Non renseigné</div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="{{ route('cras.export-pdf', $cra->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-file-pdf me-1"></i> Télécharger en PDF
        </a>
        <a href="{{ route('cras.edit', $cra) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Modifier le CRA
        </a>
    </div>
</div>
@endsection
