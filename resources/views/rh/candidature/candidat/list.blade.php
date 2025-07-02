@extends('layouts.admin_rh-dashboard')

@section('content')
<body class="bg-light">
<div class="container my-5">
  <div class="row mb-4">
    <div class="col-lg-8 mx-auto">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <form action="{{ route('offres_candidat.index') }}" method="GET" id="filterForm">
            <div class="row g-3 align-items-center">
              <div class="col-md-6">
                <label for="filtreDomaine" class="form-label fw-semibold text-muted mb-2">
                  <i class="bi bi-funnel me-2"></i>Filtrer par domaine
                </label>
                <select id="filtreDomaine" name="domaine" class="form-select" onchange="document.getElementById('filterForm').submit();">
                  <option value="all" {{ $currentDomaineFilter == 'all' ? 'selected' : '' }}>🌟 Tous les domaines</option>
                  <option value="web" {{ $currentDomaineFilter == 'web' ? 'selected' : '' }}>💻 Développement Web</option>
                  <option value="rh" {{ $currentDomaineFilter == 'rh' ? 'selected' : '' }}>👥 Ressources Humaines</option>
                  <option value="communication" {{ $currentDomaineFilter == 'communication' ? 'selected' : '' }}>📢 Communication</option>
                  {{-- Ajoutez d'autres options si vous avez d'autres secteurs dans votre DB --}}
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4" id="grille-postes">
    @forelse($offres as $offre)
        <div class="col-md-6 col-lg-4 fade-in">
          <div class="card h-100 border-0 shadow-sm card-hover">
            <div class="card-body p-4 d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center">
                  <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                    <i class="bi {{ $offre->domaineIcon }} text-primary fs-5"></i>
                  </div>
                  <div>
                    <span class="badge {{ $offre->badgeClass }} mb-1">{{ $offre->type_contrat }}</span>
                    <div class="text-muted small text-capitalize">{{ $offre->secteur ?? 'Non spécifié' }}</div>
                  </div>
                </div>
              </div>
              <h5 class="card-title fw-bold mb-3">{{ $offre->titre }}</h5>
              <p class="card-text text-muted mb-3 flex-grow-1">{{ Str::limit($offre->description, 100) }}</p>
              <div class="border-top pt-3 mt-auto">
                <div class="row g-2 mb-3">
                  <div class="col-6">
                    <div class="d-flex align-items-center text-muted small">
                      <i class="bi bi-currency-euro me-1"></i><span>{{ $offre->salaireDisplay }}</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center text-muted small">
                      <i class="bi bi-award me-1"></i><span>{{ $offre->experience_requise }}</span>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="d-flex align-items-center {{ $offre->urgenceClass }} small">
                    <i class="bi bi-clock me-1"></i><span>{{ $offre->joursRestants }} jour{{ $offre->joursRestants > 1 ? 's' : '' }} restant{{ $offre->joursRestants > 1 ? 's' : '' }}</span>
                  </div>
                  <span class="text-muted small">{{ $offre->formattedDateLimite }}</span>
                </div>
                <div class="d-grid gap-2">
                  <a href="{{ route('offres.depot', $offre->id) }}" class="btn btn-primary btn-lg" id="apply-btn-{{ $offre->id }}">
    <i class="bi bi-send me-2"></i>Postuler maintenant
</a>

                  <button class="btn btn-outline-secondary" onclick="voirDetails({{ $offre->id }})">
                    <i class="bi bi-eye me-2"></i>Voir les détails
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    @empty
        <div id="aucun-resultat" class="text-center py-5">
            <div class="col-lg-6 mx-auto">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h3 class="text-muted">Aucun poste trouvé avec ces critères.</h3>
                <button class="btn btn-primary" onclick="reinitialiserFiltres()">
                    <i class="bi bi-arrow-clockwise me-2"></i>Voir tous les postes
                </button>
            </div>
        </div>
    @endforelse
  </div>
</div>

{{-- Modal Details (sera rempli par JS via AJAX) --}}
<div class="modal fade" id="modalDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitre"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalCorps"></div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="modalPostulerBtn">Postuler maintenant</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// --- Fonctions utilitaires pour le front-end ---
function reinitialiserFiltres() {
    document.getElementById('filtreDomaine').value = 'all';
    document.getElementById('filterForm').submit();
}

function postuler(id) {
    const btn = document.getElementById(`apply-btn-${id}`);
    if (btn) {
        btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Candidature envoyée';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');
        btn.disabled = true;

        // AJAX call to submit application would go here
        // Example:
        /*
        fetch(`/job-offers/${id}/apply`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Candidature soumise avec succès !');
            } else {
                console.error('Erreur lors de la soumission de la candidature:', data.message);
            }
        })
        .catch(error => {
            console.error('Erreur AJAX lors de la candidature:', error);
            alert('Une erreur est survenue lors de la soumission de votre candidature.');
        });
        */
    }
}


// ... (your other JS functions)

function voirDetails(id) {
    // FIX HERE: Use `id` parameter directly in the URL
    fetch(`/job-offers/${id}/details`)
        .then(response => {
            if (!response.ok) {
                // Check for 404 specifically for better error handling
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
                <p><strong>Domaine :</strong> ${poste.domaine}</p>
                <p><strong>Description :</strong> ${poste.description}</p>
                <p><strong>Date limite :</strong> ${poste.finDepot} (${poste.joursRestants} jour${poste.joursRestants > 1 ? 's' : ''} restant${poste.joursRestants > 1 ? 's' : ''})</p>
                <p><strong>Type de contrat :</strong> ${poste.typeContrat}</p>
                <p><strong>Salaire :</strong> ${poste.salaire}</p>
                <p><strong>Expérience :</strong> ${poste.experience}</p>
                <p><strong>Télétravail :</strong> ${poste.teletravail ? 'Oui' : 'Non'}</p>
            `;

            const modalPostulerBtn = document.getElementById('modalPostulerBtn');
           modalPostulerBtn.onclick = () => {
    window.location.href = `/rh/candidature/candidat/${poste.id}/depot`;
    // Pas besoin de fermer le modal car on quitte la page
};


            new bootstrap.Modal(document.getElementById('modalDetails')).show();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des détails:', error);
            alert('Impossible de charger les détails de l\'offre: ' + error.message);
        });
}

</script>

</body>
@endsection