<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Offres d'emploi - {{ $entreprise->nom_entreprise }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<body class="bg-light">
<div class="container my-5">
<h1 class="mb-4">Offres d'emploi - {{ $entreprise->nom_entreprise }}</h1>

<form action="{{ route('public.offres.list', $entreprise->id) }}" method="GET" id="filterForm" class="mb-4">
    <label for="filtreDomaine" class="form-label fw-semibold text-muted mb-2">
        <i class="bi bi-funnel me-2"></i>Filtrer par domaine
    </label>
    <select id="filtreDomaine" name="domaine" class="form-select" onchange="document.getElementById('filterForm').submit();">
        <option value="all" {{ $currentDomaineFilter == 'all' ? 'selected' : '' }}>🌟 Tous les domaines</option>
        <option value="web" {{ $currentDomaineFilter == 'web' ? 'selected' : '' }}>💻 Développement Web</option>
        <option value="rh" {{ $currentDomaineFilter == 'rh' ? 'selected' : '' }}>👥 Ressources Humaines</option>
        <option value="communication" {{ $currentDomaineFilter == 'communication' ? 'selected' : '' }}>📢 Communication</option>
    </select>
</form>

<div class="row g-4">
    @forelse($offres as $offre)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge {{ $offre->badgeClass }}">{{ $offre->type_contrat }}</span>
                        <small class="text-muted">{{ $offre->secteur ?? 'Non spécifié' }}</small>
                    </div>
                    <h5 class="card-title">{{ $offre->titre }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit($offre->description, 100) }}</p>

                    <div class="mt-auto">
                        <small class="{{ $offre->urgenceClass }}">
                            <i class="bi bi-clock"></i>
                            {{ $offre->joursRestants }} jour{{ $offre->joursRestants > 1 ? 's' : '' }} restant{{ $offre->joursRestants > 1 ? 's' : '' }}
                        </small>
                        <br>
                        <small class="text-muted">Date limite : {{ $offre->formattedDateLimite }}</small>

                        <div class="mt-3">
                            <a href="{{ route('offres.depot', $offre->id) }}" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-send me-1"></i> Postuler maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">Aucune offre disponible pour le moment.</p>
    @endforelse
</div>
</div>
</body>
</html>
