@extends('layouts.admin_rh-dashboard')

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
                <div class="card card-hover h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $candidature->prenom }} {{ $candidature->nom }}</h5>
                        <p class="card-text text-muted mb-1">
                            <i class="bi bi-briefcase me-1"></i> {{ $candidature->jobOffer->titre ?? 'Poste non trouvé' }}
                        </p>
                        <p class="card-text text-muted mb-2 small">
                            <i class="bi bi-tag me-1"></i> Équipe {{ $candidature->jobOffer->equipe ?? 'N/A' }} | {{ $candidature->jobOffer->type_contrat ?? 'N/A' }}
                        </p>
                        {{-- Determine badge class dynamically --}}
                        @php
                            $statusBadgeClass = '';
                            switch ($candidature->status_demande) {
                                case 'en_attente': $statusBadgeClass = 'badge-en_attente'; break;
                                case 'accepte': $statusBadgeClass = 'badge-accepte'; break;
                                case 'rejete': $statusBadgeClass = 'badge-rejete'; break;
                                default: $statusBadgeClass = 'bg-secondary'; break;
                            }
                        @endphp
                        <span class="badge badge-status {{ $statusBadgeClass }} mb-2 text-uppercase">
                            {{ str_replace('_', ' ', $candidature->status_demande) }}
                        </span>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-calendar me-1"></i> Candidature le : <strong>{{ $candidature->created_at->format('d/m/Y H:i') }}</strong>
                        </p>
                        <div class="mt-auto d-grid gap-2">
                            <button class="btn btn-outline-primary"
                                    onclick="voirDetails({{ $candidature->id }})">
                                <i class="bi bi-eye"></i> Voir Détails
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted mt-5" id="noResultsMessage">
                <div class="col-12">
                    <i class="bi bi-info-circle fs-4 mb-2"></i>
                    <p class="fs-5">Aucune candidature ne correspond à vos critères de recherche.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- The noResultsMessage div is now handled by @forelse/@empty directive above --}}
</div>

{{-- Modal Details (will be populated by JS via AJAX) --}}
<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="modalNomLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- Changed to modal-lg for more space --}}
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalNomLabel">Détails de la candidature</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <h4 id="modalCandidatNom" class="mb-3 text-dark"></h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="bi bi-briefcase text-primary me-2"></i>Détails du Poste</h6>
                        <p><strong>Poste :</strong> <span id="modalPoste"></span> (<span id="modalContrat"></span>)</p>
                        <p><strong>Équipe :</strong> <span id="modalEquipe"></span></p>
                        <p><strong>Description du poste :</strong> <span id="modalDescription"></span></p>
                        <p><strong>Statut :</strong> <span id="modalStatut" class="badge badge-status"></span></p>
                        <p><strong>Date de candidature :</strong> <span id="modalDateCandidature"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-person-lines-fill text-success me-2"></i>Coordonnées du Candidat</h6>
                        <p><strong>Email :</strong> <span id="modalEmail"></span></p>
                        <p><strong>Téléphone :</strong> <span id="modalTelephone"></span></p>
                        <p><strong>LinkedIn / Portfolio :</strong> <a href="#" id="modalLinkedIn" target="_blank" class="text-primary"></a></p>
                        <p><strong>Disponibilité :</strong> <span id="modalDisponibilite"></span></p>
                        <p><strong>Prétentions salariales :</strong> <span id="modalPretentions"></span></p>
                    </div>
                </div>
                <hr>
                <h6><i class="bi bi-chat-left-text text-info me-2"></i>Message de motivation :</h6>
                <p class="fst-italic" id="modalMotivation"></p>
            </div>
           <div class="modal-footer justify-content-between">
    <div>
        {{-- Vos boutons de CV/Lettre existants --}}
        <a href="#" target="_blank" class="btn btn-primary me-2" id="modalCV"><i class="bi bi-file-earmark-person"></i> Voir le CV</a>
        <a href="#" target="_blank" class="btn btn-info" id="modalLettre"><i class="bi bi-file-earmark-text"></i> Voir Lettre</a>
    </div>
    <div>
        {{-- Boutons pour accepter/rejeter --}}
        <form id="acceptForm" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-success me-2" id="btnAcceptCandidature">
                <i class="bi bi-check-circle me-1"></i> Accepter
            </button>
        </form>
        <form id="rejectForm" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger" id="btnRejectCandidature">
                <i class="bi bi-x-circle me-1"></i> Rejeter
            </button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
    </div>
</div>
        </div>
    </div>
</div>

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