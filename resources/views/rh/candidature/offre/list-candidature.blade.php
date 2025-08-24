@extends('layout.admin_rh')

@section('title', 'RH - Offre d emploi')
@section('page-title', 'Gestion des offres')
@section('content')

<style>
    /* Custom CSS for badges based on status */
    .badge-status {
        padding: 0.5em 0.75em;
        border-radius: 0.3rem;
        font-weight: 600;
        color: #fff; /* Default text color for badges */
    }
    .badge-en_attente {
        background-color: #ffc107; /* Warning color, yellow */
        color: #343a40; /* Dark text for light background */
    }
    .badge-accepte {
        background-color: #28a745; /* Success color, green */
    }
    .badge-rejete {
        background-color: #dc3545; /* Danger color, red */
    }

    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<div class="container my-5">
    <h2 class="mb-4 text-center text-primary">Liste des Candidatures Reçues</h2>
    <hr class="mb-5">

    <div class="row mb-4">
        <div class="col-lg-10 mx-auto">
            <form action="{{ route('candidatures.index') }}" method="GET" id="filterForm">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                    <input type="text" class="form-control w-100 w-md-50" id="searchNom" name="searchNom" placeholder="🔍 Rechercher un candidat..." value="{{ $currentSearchNom ?? '' }}">
                    <select class="form-select" id="filtrePoste" name="filtrePoste">
                        <option value="all">Tous les postes</option>
                        @foreach($jobOffers as $jobOffer)
                            <option value="{{ $jobOffer->id }}" {{ ($currentFiltrePoste ?? '') == $jobOffer->id ? 'selected' : '' }}>
                                {{ $jobOffer->titre }}
                            </option>
                        @endforeach
                    </select>
                    <select class="form-select" id="filtreStatut" name="filtreStatut">
                        <option value="all" {{ ($currentFiltreStatut ?? '') == 'all' ? 'selected' : '' }}>Tous les statuts</option>
                        <option value="En attente" {{ ($currentFiltreStatut ?? '') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="accepte" {{ ($currentFiltreStatut ?? '') == 'accepte' ? 'selected' : '' }}>Accepté</option>
                        <option value="rejete" {{ ($currentFiltreStatut ?? '') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                    <button type="submit" class="btn btn-primary d-none d-md-block">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

   <div class="row g-4" id="listeCandidats">
    @forelse($candidatures as $candidature)
        <div class="col-md-6 col-lg-4 fade-in">
            <div class="card shadow-sm h-100 border-0 rounded-3 overflow-hidden">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="card-title text-primary fw-bold mb-0 me-auto">
                            <i class="bi bi-person-circle me-2"></i> {{ $candidature->prenom }} {{ $candidature->nom }}
                        </h5>
                        {{-- Determine badge class dynamically --}}
                        @php
                            $statusBadgeClass = '';
                            switch ($candidature->status_demande) {
                                case 'en_attente': $statusBadgeClass = 'bg-warning text-dark'; break;
                                case 'accepte': $statusBadgeClass = 'bg-success'; break;
                                case 'rejete': $statusBadgeClass = 'bg-danger'; break;
                                default: $statusBadgeClass = 'bg-secondary'; break;
                            }
                        @endphp
                        <span class="badge {{ $statusBadgeClass }} text-uppercase fw-normal py-2 px-3 rounded-pill">
                            {{ str_replace('_', ' ', $candidature->status_demande) }}
                        </span>
                    </div>

                    <p class="card-text text-muted mb-2 small">
                        <i class="bi bi-briefcase me-2 text-secondary"></i>
                        <span class="fw-semibold">{{ $candidature->jobOffer->titre ?? 'Poste non trouvé' }}</span>
                    </p>
                    <p class="card-text text-muted mb-3 small">
                        <i class="bi bi-tag me-2 text-secondary"></i>
                        Équipe: <span class="fw-semibold">{{ $candidature->jobOffer->equipe ?? 'N/A' }}</span> | Contrat: <span class="fw-semibold">{{ $candidature->jobOffer->type_contrat ?? 'N/A' }}</span>
                    </p>

                    <hr class="text-muted my-2">

                    <p class="text-muted small mb-4">
                        <i class="bi bi-calendar me-2 text-secondary"></i>
                        Candidature le: <strong class="text-dark">{{ $candidature->created_at->format('d/m/Y H:i') }}</strong>
                    </p>

                    <div class="mt-auto d-grid">
                        <button class="btn btn-primary btn-lg rounded-pill shadow-sm"
                                onclick="voirDetails({{ $candidature->id }})">
                            <i class="bi bi-eye me-2"></i> Voir Détails
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center text-muted mt-5 py-5 border rounded-3 bg-light" id="noResultsMessage">
                <i class="bi bi-info-circle fs-1 mb-3 text-secondary"></i>
                <p class="fs-5 fw-light">Aucune candidature ne correspond à vos critères de recherche.</p>
                <p class="lead">Veuillez ajuster vos filtres et réessayer.</p>
            </div>
        </div>
    @endforelse
</div>

{{-- Custom CSS for finer control and animations (add this to your stylesheet) --}}
<style>
    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .badge-status {
        font-size: 0.75rem; /* Adjust as needed */
    }
    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

    {{-- The noResultsMessage div is now handled by @forelse/@empty directive above --}}
</div>

{{-- Modal Details (will be populated by JS via AJAX) --}}
<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="modalNomLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"> {{-- Added modal-dialog-scrollable --}}
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-primary text-white p-4 rounded-top-4">
                <h4 class="modal-title fw-bold" id="modalNomLabel">
                    <i class="bi bi-person-fill me-2"></i> Détails de la Candidature
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <h3 id="modalCandidatNom" class="mb-0 text-dark fw-bold me-auto">
                        <i class="bi bi-person-circle text-primary me-2"></i> </h3>
                    <span id="modalStatut" class="badge text-uppercase fw-normal py-2 px-3 rounded-pill fs-6"></span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-briefcase me-2"></i> Informations sur le Poste
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>Poste :</strong> <span id="modalPoste"></span> (<span id="modalContrat"></span>)</li>
                            <li class="mb-2"><strong>Équipe :</strong> <span id="modalEquipe"></span></li>
                            <li class="mb-2"><strong>Date de candidature :</strong> <span id="modalDateCandidature" class="fw-bold"></span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">
                            <i class="bi bi-person-lines-fill me-2"></i> Coordonnées du Candidat
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>Email :</strong> <a href="#" id="modalEmail" class="text-decoration-none text-dark d-inline-block text-truncate" style="max-width: 90%;"></a></li>
                            <li class="mb-2"><strong>Téléphone :</strong> <span id="modalTelephone"></span></li>
                            <li class="mb-2"><strong>LinkedIn / Portfolio :</strong> <a href="#" id="modalLinkedIn" target="_blank" class="text-primary text-decoration-none d-inline-block text-truncate" style="max-width: 90%;"></a></li>
                        </ul>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <h6 class="text-info mb-3">
                        <i class="bi bi-calendar-check me-2"></i> Disponibilité & Attentes
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Disponibilité :</strong> <span id="modalDisponibilite"></span></li>
                        <li><strong>Prétentions salariales :</strong> <span id="modalPretentions"></span></li>
                    </ul>
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <h6 class="text-secondary mb-3">
                        <i class="bi bi-file-earmark-text me-2"></i> Description du Poste
                    </h6>
                    <p class="text-muted" id="modalDescription"></p>
                </div>

                <hr class="my-4">

                <div>
                    <h6 class="text-dark mb-3">
                        <i class="bi bi-chat-left-text me-2"></i> Message de Motivation
                    </h6>
                    <p class="fst-italic text-break" id="modalMotivation"></p>
                </div>

            </div>
            <div class="modal-footer d-flex flex-wrap justify-content-between align-items-center p-4">
                <div class="d-flex flex-wrap gap-2 mb-2 mb-md-0">
                    <a href="#" target="_blank" class="btn btn-outline-primary btn-sm" id="modalCV">
                        <i class="bi bi-file-earmark-person me-1"></i> Voir le CV
                    </a>
                    <a href="#" target="_blank" class="btn btn-outline-info btn-sm" id="modalLettre">
                        <i class="bi bi-file-earmark-text me-1"></i> Voir Lettre
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <form id="acceptForm" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg px-4 rounded-pill" id="btnAcceptCandidature">
                            <i class="bi bi-check-circle me-2"></i> Accepter
                        </button>
                    </form>
                    <form id="rejectForm" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg px-4 rounded-pill" id="btnRejectCandidature">
                            <i class="bi bi-x-circle me-2"></i> Rejeter
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary btn-lg px-4 rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styles for the status badge in the modal */
    .modal-body .badge {
        font-size: 0.95em; /* Slightly larger for emphasis */
        font-weight: 500;
        padding: 0.5em 0.8em;
    }

    /* Override Bootstrap's default for clarity if needed */
    .modal-body ul {
        padding-left: 0;
        list-style: none;
    }
</style>

<script>
    // This JavaScript function would be responsible for populating the modal
    // with data when a "Voir Détails" button is clicked.
    // Ensure this function is correctly implemented in your main JS file.
    function voirDetails(candidatureId) {
        // Example: Fetch data (replace with your actual AJAX call or data retrieval)
        // This is a placeholder for demonstration purposes.
        const candidaturesData = {
            1: {
                prenom: 'Alice',
                nom: 'Dubois',
                jobOffer: {
                    titre: 'Développeur Web Full Stack',
                    equipe: 'Innovation',
                    type_contrat: 'CDI',
                    description: "Recherche un développeur passionné pour rejoindre notre équipe agile et contribuer à la conception et au développement de nos applications web innovantes.",
                },
                status_demande: 'en_attente',
                created_at: new Date('2025-07-20T10:30:00'),
                email: 'alice.dubois@example.com',
                telephone: '+221 77 123 45 67',
                linkedin: 'https://linkedin.com/in/alicedubois',
                disponibilite: 'Immédiate',
                pretentions: '40 000 - 45 000 EUR/an',
                motivation: "Je suis très intéressée par le poste de Développeur Web Full Stack au sein de votre équipe d'innovation. Mon expérience en développement front-end et back-end, combinée à ma passion pour les nouvelles technologies, correspond parfaitement aux exigences du poste. Je suis impatiente de contribuer au succès de vos projets."
            },
            2: {
                prenom: 'Omar',
                nom: 'Diop',
                jobOffer: {
                    titre: 'Designer UI/UX',
                    equipe: 'Produit',
                    type_contrat: 'CDD',
                    description: "Nous recherchons un designer UI/UX créatif et expérimenté pour concevoir des interfaces utilisateur intuitives et esthétiques pour nos plateformes numériques.",
                },
                status_demande: 'accepte',
                created_at: new Date('2025-07-15T14:00:00'),
                email: 'omar.diop@example.com',
                telephone: '+221 70 987 65 43',
                linkedin: '', // No LinkedIn
                disponibilite: 'Sous 1 mois',
                pretentions: '30 000 - 35 000 EUR/an',
                motivation: "Mon parcours en design UI/UX m'a permis de développer une forte expertise dans la création d'expériences utilisateur exceptionnelles. Je suis enthousiasmé par l'opportunité de mettre mes compétences au service de votre équipe Produit et de participer à l'évolution de vos produits."
            }
        };

        const candidature = candidaturesData[candidatureId]; // Get data for the specific ID

        if (candidature) {
            // Update candidate name and status in the header
            document.getElementById('modalCandidatNom').innerHTML = `<i class="bi bi-person-circle text-primary me-2"></i> ${candidature.prenom} ${candidature.nom}`;

            // Update status badge
            const statusBadge = document.getElementById('modalStatut');
            statusBadge.textContent = candidature.status_demande.replace('_', ' ');
            statusBadge.className = 'badge text-uppercase fw-normal py-2 px-3 rounded-pill fs-6'; // Reset classes
            switch (candidature.status_demande) {
                case 'en_attente': statusBadge.classList.add('bg-warning', 'text-dark'); break;
                case 'accepte': statusBadge.classList.add('bg-success'); break;
                case 'rejete': statusBadge.classList.add('bg-danger'); break;
                default: statusBadge.classList.add('bg-secondary'); break;
            }

            // Update Job Details
            document.getElementById('modalPoste').textContent = candidature.jobOffer.titre ?? 'Non trouvé';
            document.getElementById('modalContrat').textContent = candidature.jobOffer.type_contrat ?? 'N/A';
            document.getElementById('modalEquipe').textContent = candidature.jobOffer.equipe ?? 'N/A';
            document.getElementById('modalDescription').textContent = candidature.jobOffer.description ?? 'Non spécifiée.';
            document.getElementById('modalDateCandidature').textContent = candidature.created_at ? new Date(candidature.created_at).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'N/A';

            // Update Candidate Contact Info
            const modalEmail = document.getElementById('modalEmail');
            modalEmail.textContent = candidature.email ?? 'Non spécifié.';
            modalEmail.href = `mailto:${candidature.email}`;

            document.getElementById('modalTelephone').textContent = candidature.telephone ?? 'Non spécifié.';

            const modalLinkedIn = document.getElementById('modalLinkedIn');
            if (candidature.linkedin) {
                modalLinkedIn.textContent = candidature.linkedin.replace(/(^\w+:|^)\/\//, ''); // Display without http(s)://
                modalLinkedIn.href = candidature.linkedin;
                modalLinkedIn.classList.remove('d-none'); // Show if URL exists
            } else {
                modalLinkedIn.textContent = 'Non spécifié.';
                modalLinkedIn.removeAttribute('href');
                modalLinkedIn.classList.add('d-none'); // Hide if no URL
            }


            document.getElementById('modalDisponibilite').textContent = candidature.disponibilite ?? 'Non spécifiée.';
            document.getElementById('modalPretentions').textContent = candidature.pretentions ?? 'Non spécifiées.';
            document.getElementById('modalMotivation').textContent = candidature.motivation ?? 'Aucun message de motivation.';

            // Update CV and Lettre de motivation links (assuming these are URLs)
            const modalCV = document.getElementById('modalCV');
            // Example: Assume CV and Lettre URLs are stored in candidature.cv_url and candidature.lettre_url
            // For this example, I'll just disable if not available
            if (candidature.cv_url) {
                modalCV.href = candidature.cv_url;
                modalCV.classList.remove('disabled');
            } else {
                modalCV.href = '#';
                modalCV.classList.add('disabled');
            }

            const modalLettre = document.getElementById('modalLettre');
            if (candidature.lettre_url) {
                modalLettre.href = candidature.lettre_url;
                modalLettre.classList.remove('disabled');
            } else {
                modalLettre.href = '#';
                modalLettre.classList.add('disabled');
            }

            // Update form actions for accept/reject
            document.getElementById('acceptForm').action = `/candidatures/${candidatureId}/accept`; // Adjust your route
            document.getElementById('rejectForm').action = `/candidatures/${candidatureId}/reject`; // Adjust your route

            // Show the modal
            const myModal = new bootstrap.Modal(document.getElementById('modalDetails'));
            myModal.show();
        } else {
            console.error('Candidature not found for ID:', candidatureId);
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JS is now primarily for opening the modal via AJAX and handling filter submission

    function voirDetails(candidatureId) {
        // Fetch details from your Laravel backend using AJAX
        fetch(`/rh/candidatures/${candidatureId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Populate modal with data from the server
                document.getElementById('modalCandidatNom').textContent = `${data.prenom} ${data.nom}`;
                document.getElementById('modalPoste').textContent = data.poste_titre;
                document.getElementById('modalContrat').textContent = data.poste_contrat;
                document.getElementById('modalEquipe').textContent = data.poste_equipe;
                document.getElementById('modalDescription').textContent = data.poste_description;

                const modalStatutBadge = document.getElementById('modalStatut');
                modalStatutBadge.textContent = data.statut.replace('_', ' ');
                modalStatutBadge.className = `badge badge-status ${data.statut_class} text-uppercase`; // Use class from backend

                document.getElementById('modalDateCandidature').textContent = data.date_candidature;
                document.getElementById('modalEmail').textContent = data.email;
                document.getElementById('modalTelephone').textContent = data.telephone;

                const acceptForm = document.getElementById('acceptForm');
            const rejectForm = document.getElementById('rejectForm');

            // Si vous utilisez deux méthodes distinctes (Option A)
            acceptForm.action = `/rh/candidatures/${candidatureId}/accepter`;
            rejectForm.action = `/rh/candidatures/${candidatureId}/rejeter`;

                const linkedinLink = document.getElementById('modalLinkedIn');
                if (data.linkedin) {
                    linkedinLink.href = data.linkedin;
                    linkedinLink.textContent = data.linkedin.replace(/(^\w+:|^)\/\//, '');
                    linkedinLink.classList.remove('d-none');
                } else {
                    linkedinLink.textContent = "Non fourni";
                    linkedinLink.href = "#";
                    linkedinLink.classList.add('d-none');
                }

                document.getElementById('modalDisponibilite').textContent = data.disponibilite;
                document.getElementById('modalPretentions').textContent = data.pretentions_salariales;
                document.getElementById('modalMotivation').textContent = data.motivation || "Non fourni.";

                // File links
                document.getElementById('modalCV').href = data.cv_url;

                const lettreLink = document.getElementById('modalLettre');
                if (data.lettre_url) {
                    lettreLink.href = data.lettre_url;
                    lettreLink.classList.remove('d-none');
                } else {
                    lettreLink.classList.add('d-none');
                }

                // Show the modal
                new bootstrap.Modal(document.getElementById('modalDetails')).show();
            })
            .catch(error => {
                console.error('Error fetching candidature details:', error);
                alert('Impossible de charger les détails de la candidature.');
            });
    }

    // Automatically submit the form when filter inputs change
    document.querySelectorAll('#searchNom, #filtrePoste, #filtreStatut').forEach(element => {
        element.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
        // For text input, you might prefer a debounce or a specific search button
        // For now, it will submit on change (blur or enter)
    });

    // You can remove window.onload logic for populating filters, as it's now handled by PHP
    // and the data is directly passed from the controller.
</script>
@endsection