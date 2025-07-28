<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres d'emploi de l'Entreprise</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #ffffff; /* Fond blanc */
    color: #333;
    min-height: 100vh;
}

.hero-section {
    background-color: #f8f9fa;
    border-radius: 20px;
    border: 1px solid #dee2e6;
    margin-bottom: 2rem;
}

.company-card,
.filter-card,
.job-card {
    background-color: #ffffff;
    border-radius: 20px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.company-card:hover,
.job-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
}

.company-logo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #ffffff;
    object-fit: cover;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.domain-icon {
    background: #667eea;
    color: white;
    font-size: 1.5rem;
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge-custom {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-permanent {
    background: #0d6efd;
    color: white;
}
.badge-cdd {
    background: #6c757d;
    color: white;
}
.badge-stage {
    background: #17a2b8;
    color: white;
}
.badge-alternance {
    background: #28a745;
    color: white;
}

.urgency-indicator {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.text-urgente {
    background: #f8d7da;
    color: #dc3545;
}
.text-moderee {
    background: #fff3cd;
    color: #856404;
}
.text-faible {
    background: #d4edda;
    color: #155724;
}

.btn-apply {
    background: #667eea;
    color: white;
    border: none;
    border-radius: 15px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-apply:hover {
    background: #5a6fd8;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.btn-details {
    border: 2px solid #667eea;
    color: #667eea;
    border-radius: 15px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    background: transparent;
    transition: all 0.3s ease;
}

.btn-details:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.company-info-item {
    background: #f1f3f5;
    border-radius: 10px;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border-left: 4px solid #667eea;
}

.fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.job-meta {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.job-meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.job-meta-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    background: #667eea;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    font-size: 0.9rem;
}

    </style>
</head>
<body>
<div class="container-fluid py-5">
    <!-- Section Entreprise Hero -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="hero-section p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 mx-auto">
                        <div class="company-card p-5">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center mb-4 mb-md-0">
                                    @if($entreprise->logo_path)
                                        <img src="{{ asset('storage/' . $entreprise->logo_path) }}" alt="Logo {{ $entreprise->entreprise_name }}"
                                             class="company-logo">
                                    @else
                                        <div class="company-logo d-flex align-items-center justify-content-center bg-primary">
                                            <i class="bi bi-building fs-1 text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h1 class="fw-bold text-primary mb-3">{{ $entreprise->entreprise_name }}</h1>
                                    
                                    <div class="company-info-item">
                                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                                        <strong>Adresse:</strong> {{ $entreprise->adresse ?? 'Non renseignée' }}
                                    </div>
                                    
                                    <div class="company-info-item">
                                        <i class="bi bi-envelope-fill me-2 text-primary"></i>
                                        <strong>Contact:</strong> {{ $entreprise->email ?? 'Non disponible' }}
                                    </div>
                                    
                                    @if($entreprise->phone)
                                    <div class="company-info-item">
                                        <i class="bi bi-telephone-fill me-2 text-primary"></i>
                                        <strong>Téléphone:</strong> {{ $entreprise->phone }}
                                    </div>
                                    @endif
                                    
                                    @if($entreprise->description)
                                        <p class="text-secondary mt-3 fst-italic">
                                            "{{ Str::limit($entreprise->description, 200) }}"
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="company-stats">
                                        <div class="stat-item mb-3">
                                            <span class="stat-number">{{ $offres->count() }}</span>
                                            <span class="stat-label">Offres disponibles</span>
                                        </div>
                                        <div class="stat-item mb-3">
                                            <span class="stat-number">{{ $offres->where('type_contrat', 'CDI')->count() }}</span>
                                            <span class="stat-label">Postes permanents</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number">{{ $offres->unique('secteur')->count() }}</span>
                                            <span class="stat-label">Domaines d'activité</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Filtres -->
    <div class="row mb-4">
        <div class="col-lg-10 mx-auto">
            <div class="filter-card p-4">
                <form action="{{ route('offres_candidat.index', ['entreprise_id' => $entreprise_id]) }}" method="GET" id="filterForm">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label for="filtreDomaine" class="form-label fw-bold text-dark mb-2">
                                <i class="bi bi-funnel-fill me-2 text-primary"></i>Filtrer par domaine
                            </label>
                            <select id="filtreDomaine" name="domaine" class="form-select form-select-lg border-0 shadow-sm" onchange="document.getElementById('filterForm').submit();">
                                <option value="all" {{ $currentDomaineFilter == 'all' ? 'selected' : '' }}>🌟 Tous les domaines</option>
                                <option value="web" {{ $currentDomaineFilter == 'web' ? 'selected' : '' }}>💻 Développement Web</option>
                                <option value="rh" {{ $currentDomaineFilter == 'rh' ? 'selected' : '' }}>👥 Ressources Humaines</option>
                                <option value="communication" {{ $currentDomaineFilter == 'communication' ? 'selected' : '' }}>📢 Communication</option>
                                <option value="marketing" {{ $currentDomaineFilter == 'marketing' ? 'selected' : '' }}>📈 Marketing</option>
                                <option value="finance" {{ $currentDomaineFilter == 'finance' ? 'selected' : '' }}>💰 Finance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark mb-2">
                                <i class="bi bi-briefcase-fill me-2 text-primary"></i>Répartition des contrats
                            </label>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge badge-custom badge-permanent">{{ $offres->where('type_contrat', 'CDI')->count() }} CDI</span>
                                <span class="badge badge-custom badge-cdd">{{ $offres->where('type_contrat', 'CDD')->count() }} CDD</span>
                                <span class="badge badge-custom badge-stage">{{ $offres->where('type_contrat', 'Stage')->count() }} Stages</span>
                                <span class="badge badge-custom badge-alternance">{{ $offres->where('type_contrat', 'Alternance')->count() }} Alternances</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <label class="form-label fw-bold text-dark mb-2 d-block">Actions rapides</label>
                            <button type="button" class="btn btn-outline-primary me-2" onclick="reinitialiserFiltres()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Réinitialiser
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="copyPublicLink(window.location.href)">
                                <i class="bi bi-share me-1"></i>Partager
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Grille des offres d'emploi -->
    <div class="row g-4" id="grille-postes">
        @forelse($offres as $offre)
            <div class="col-lg-4 col-md-6 fade-in">
                <div class="job-card h-100 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="domain-icon">
                            <i class="bi {{ $offre->domaineIcon ?? 'bi-briefcase' }}"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-custom {{ $offre->badgeClass ?? 'badge-permanent' }} mb-2">{{ $offre->type_contrat }}</span>
                            <div class="urgency-indicator {{ $offre->urgenceClass ?? 'text-faible' }}">
                                <i class="bi bi-clock me-1"></i>{{ $offre->joursRestants ?? 'N/A' }} jour{{ ($offre->joursRestants ?? 0) > 1 ? 's' : '' }}
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="fw-bold mb-3 text-dark">{{ $offre->titre }}</h4>
                    <p class="text-muted mb-4 lh-base">{{ Str::limit($offre->description, 120) }}</p>
                    
                    <div class="job-meta">
                        <div class="job-meta-item">
                            <div class="job-meta-icon">
                                <i class="bi bi-currency-euro"></i>
                            </div>
                            <div>
                                <strong>Salaire:</strong> {{ $offre->salaireDisplay ?? 'Non précisé' }}
                            </div>
                        </div>
                        <div class="job-meta-item">
                            <div class="job-meta-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <div>
                                <strong>Expérience:</strong> {{ $offre->experience_requise ?? 'Non précisée' }}
                            </div>
                        </div>
                        <div class="job-meta-item">
                            <div class="job-meta-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <strong>Date limite:</strong> {{ $offre->formattedDateLimite ?? 'Non précisée' }}
                            </div>
                        </div>
                        @if(isset($offre->teletravail) && $offre->teletravail)
                        <div class="job-meta-item">
                            <div class="job-meta-icon">
                                <i class="bi bi-house"></i>
                            </div>
                            <div>
                                <strong>Télétravail possible</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2 mt-auto">
                        <a href="{{ route('offres.depot', $offre->id) }}" class="btn btn-apply text-white btn-lg" id="apply-btn-{{ $offre->id }}">
                            <i class="bi bi-send me-2"></i>Postuler maintenant
                        </a>
                        <button class="btn btn-details" onclick="voirDetails({{ $offre->id }})">
                            <i class="bi bi-eye me-2"></i>Voir les détails
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div id="aucun-resultat" class="text-center py-5">
                <div class="col-lg-6 mx-auto">
                    <div class="p-5 rounded-4" style="background: rgba(255, 255, 255, 0.9);">
                        <i class="bi bi-search display-1 text-muted mb-3"></i>
                        <h3 class="text-muted mb-3">Aucun poste trouvé avec ces critères</h3>
                        <p class="text-secondary mb-4">Essayez de modifier vos filtres pour voir plus d'opportunités.</p>
                        <button class="btn btn-apply text-white btn-lg" onclick="reinitialiserFiltres()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Voir tous les postes
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal Details --}}
<div class="modal fade" id="modalDetails" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title text-white fw-bold" id="modalTitre"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modalCorps"></div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-apply text-white btn-lg flex-fill me-2" id="modalPostulerBtn">
                    <i class="bi bi-send me-2"></i>Postuler maintenant
                </button>
                <button class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copyPublicLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        // Affichage d'une toast notification plus élégante
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 m-3 p-3 bg-success text-white rounded-3 shadow-lg';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="bi bi-check-circle me-2"></i>Lien copié dans le presse-papier !';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}

function reinitialiserFiltres() {
    document.getElementById('filtreDomaine').value = 'all';
    document.getElementById('filterForm').submit();
}

function postuler(id) {
    const btn = document.getElementById(`apply-btn-${id}`);
    if (btn) {
        btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Candidature envoyée';
        btn.classList.remove('btn-apply');
        btn.classList.add('btn-success');
        btn.disabled = true;
    }
}

function voirDetails(id) {
    fetch(`/job-offers/${id}/details`)
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('Offre non trouvée. Elle a peut-être été supprimée.');
                }
                throw new Error('Erreur réseau ou réponse inattendue.');
            }
            return response.json();
        })
        .then(poste => {
            document.getElementById('modalTitre').textContent = poste.titre;
            document.getElementById('modalCorps').innerHTML = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="job-meta">
                            <div class="job-meta-item">
                                <div class="job-meta-icon"><i class="bi bi-briefcase"></i></div>
                                <div><strong>Domaine:</strong> ${poste.domaine}</div>
                            </div>
                            <div class="job-meta-item">
                                <div class="job-meta-icon"><i class="bi bi-file-text"></i></div>
                                <div><strong>Type de contrat:</strong> ${poste.typeContrat}</div>
                            </div>
                            <div class="job-meta-item">
                                <div class="job-meta-icon"><i class="bi bi-currency-euro"></i></div>
                                <div><strong>Salaire:</strong> ${poste.salaire}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="job-meta">
                            <div class="job-meta-item">
                                <div class="job-meta-icon"><i class="bi bi-award"></i></div>
                                <div><strong>Expérience:</strong> ${poste.experience}</div>
                            </div>
                            <div class="job-meta-item">
                                <div class="job-meta-icon"><i class="bi bi-calendar"></i></div>
                                <div><strong>Date limite:</strong> ${poste.finDepot}</div>
                            </div>
                            <div class="job-meta-item">
                                <div class="job-meta-icon"><i class="bi bi-house"></i></div>
                                <div><strong>Télétravail:</strong> ${poste.teletravail ? 'Oui' : 'Non'}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h6 class="fw-bold mb-3">Description du poste</h6>
                        <div class="p-3 rounded-3" style="background: rgba(102, 126, 234, 0.05);">
                            <p class="mb-0">${poste.description}</p>
                        </div>
                        <div class="urgency-indicator ${poste.urgenceClass || 'text-faible'} mt-3 d-inline-block">
                            <i class="bi bi-clock me-1"></i>${poste.joursRestants} jour${poste.joursRestants > 1 ? 's' : ''} restant${poste.joursRestants > 1 ? 's' : ''}
                        </div>
                    </div>
                </div>
            `;

            const modalPostulerBtn = document.getElementById('modalPostulerBtn');
            modalPostulerBtn.onclick = () => {
                window.location.href = `/rh/candidature/candidat/${poste.id}/depot`;
            };

            new bootstrap.Modal(document.getElementById('modalDetails')).show();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des détails:', error);
            alert('Impossible de charger les détails de l\'offre: ' + error.message);
        });
}

// Animation pour les cartes au scroll
window.addEventListener('scroll', function() {
    const cards = document.querySelectorAll('.job-card');
    cards.forEach(card => {
        const cardTop = card.getBoundingClientRect().top;
        const cardVisible = 150;
        
        if (cardTop < window.innerHeight - cardVisible) {
            card.classList.add('fade-in');
        }
    });
});
</script>
</body>
</html>