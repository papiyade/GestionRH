<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres d'emploi - {{ $entreprise->nom_entreprise }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
            --primary-color: #AE3D7D;
            --primary-dark: #861254FF;
        }

        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-gradient {
            background: var(--primary-gradient);
            padding: 5px 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(174, 61, 125, 0.2);
        }

        .header-gradient h1 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }

        .header-gradient .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.6rem;
            margin-top: 0.5rem;
        }

        .filter-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border: none;
        }

        .filter-label {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(174, 61, 125, 0.15);
        }

        .job-card {
            background: white;
            border-radius: 16px;
            padding: 1.75rem;
            height: 100%;
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .job-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(174, 61, 125, 0.2);
        }

        .job-card:hover::before {
            transform: scaleX(1);
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            gap: 0.75rem;
        }

        .contract-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .sector-tag {
            background: #f8f9fa;
            color: #6c757d;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.813rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .job-title {
            color: #212529;
            font-size: 1.375rem;
            font-weight: 700;
            margin-bottom: 0.875rem;
            line-height: 1.3;
        }

        .job-description {
            color: #6c757d;
            font-size: 0.938rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            min-height: 60px;
        }

        .job-footer {
            border-top: 1px solid #f1f3f5;
            padding-top: 1.25rem;
            margin-top: auto;
        }

        .deadline-info {
            background: #fff3cd;
            color: #856404;
            padding: 0.6rem 0.9rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .deadline-info.urgent {
            background: #f8d7da;
            color: #721c24;
        }

        .deadline-info.safe {
            background: #d4edda;
            color: #155724;
        }

        .deadline-date {
            color: #6c757d;
            font-size: 0.813rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .apply-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .apply-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(174, 61, 125, 0.3);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .stats-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 20px;
            font-size: 0.938rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .header-gradient h1 {
                font-size: 1.875rem;
            }
            
            .job-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Header avec gradient -->
    <div class="header-gradient">
        <div class="container">
            <h1>
                <i class="ti ti-briefcase me-2"></i>
                Offres d'emploi
            </h1>
            <p class="subtitle mb-0">{{ $entreprise->nom_entreprise }}</p>
            <div class="stats-badge">
                <i class="ti ti-file-text"></i>
                <span>{{ count($offres) }} offre{{ count($offres) > 1 ? 's' : '' }} disponible{{ count($offres) > 1 ? 's' : '' }}</span>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Filtre -->
        <form action="{{ route('public.offres.list', $entreprise->id) }}" method="GET" id="filterForm">
            <div class="filter-card">
                <label for="filtreDomaine" class="filter-label">
                    <i class="ti ti-filter"></i>
                    Filtrer par domaine
                </label>
                <select id="filtreDomaine" name="domaine" class="form-select" onchange="document.getElementById('filterForm').submit();">
                    <option value="all" {{ $currentDomaineFilter == 'all' ? 'selected' : '' }}>
                        <i class="ti ti-star"></i> Tous les domaines
                    </option>
                    <option value="web" {{ $currentDomaineFilter == 'web' ? 'selected' : '' }}>
                        Développement Web
                    </option>
                    <option value="rh" {{ $currentDomaineFilter == 'rh' ? 'selected' : '' }}>
                        Ressources Humaines
                    </option>
                    <option value="communication" {{ $currentDomaineFilter == 'communication' ? 'selected' : '' }}>
                        Communication
                    </option>
                </select>
            </div>
        </form>

        <!-- Grille des offres -->
        <div class="row g-4">
            @forelse($offres as $offre)
                <div class="col-md-6 col-lg-4">
                    <div class="job-card">
                        <div class="job-header">
                            <span class="contract-badge">
                                <i class="ti ti-file-certificate"></i>
                                {{ $offre->type_contrat }}
                            </span>
                            <span class="sector-tag">
                                <i class="ti ti-building"></i>
                                {{ $offre->secteur ?? 'Non spécifié' }}
                            </span>
                        </div>

                        <h5 class="job-title">{{ $offre->titre }}</h5>
                        <p class="job-description">
                            {{ \Illuminate\Support\Str::limit($offre->description, 100) }}
                        </p>

                        <div class="job-footer">
                            <div class="deadline-info {{ $offre->joursRestants <= 3 ? 'urgent' : ($offre->joursRestants > 10 ? 'safe' : '') }}">
                                <i class="ti ti-clock"></i>
                                <span>
                                    {{ $offre->joursRestants }} jour{{ $offre->joursRestants > 1 ? 's' : '' }} restant{{ $offre->joursRestants > 1 ? 's' : '' }}
                                </span>
                            </div>

                            <div class="deadline-date">
                                <i class="ti ti-calendar-event"></i>
                                <span>Date limite : {{ $offre->formattedDateLimite }}</span>
                            </div>

                            <a href="{{ route('offres.depot', $offre->id) }}" class="apply-btn">
                                <i class="ti ti-send"></i>
                                Postuler maintenant
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="ti ti-folder-off"></i>
                        <h3>Aucune offre disponible</h3>
                        <p>Il n'y a pas d'offres d'emploi pour le moment. Revenez bientôt !</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>