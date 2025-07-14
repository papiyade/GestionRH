
@extends('layouts.admin_rh-dashboard')

@section('content')

<div id="layout-wrapper" class="container my-4">
    <h2 class="text-center text-primary mb-4">Gestion des Offres d'Emploi</h2>
    <hr class="mb-5">

    <div class="row g-4 mb-4">
        <div class="col-sm-auto">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createJobOfferModal" id="addJobOfferBtn">
                <i class="ri-add-line align-bottom me-1"></i> Créer une Offre
            </button>
        </div>
        {{-- Suppression des éléments de filtre et recherche si non gérés par PHP --}}
        {{-- Si vous voulez ajouter des filtres/recherche PHP plus tard, réactivez la section <form> ici --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row gy-2 mb-2" id="job-offer-list">
        {{-- Boucle PHP pour afficher chaque offre --}}
        @forelse($offres as $offre)
            <div class="col-12" id="job-card-{{ $offre->id }}"> {{-- Ajoutez un ID à la carte pour manipulation JS --}}
                <div class="card shadow-sm">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <h5 class="mb-1">{{ $offre->titre }}</h5>
                            <p class="mb-0 text-muted">💼 Équipe {{ $offre->equipe }} | 📄 {{ Str::limit($offre->description, 100) }}</p>
                            <p class="mb-0 text-muted">📅 Fin de dépôt : <strong>{{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}</strong></p>
                            <span class="badge {{ match($offre->type_contrat) {
                                'CDI' => 'bg-primary',
                                'CDD' => 'bg-warning text-dark',
                                'Stage' => 'bg-success',
                                'Alternance' => 'bg-info',
                                'Freelance' => 'bg-secondary',
                                default => 'bg-secondary'
                            } }}">{{ $offre->type_contrat }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                            {{-- Le select appelle une fonction JS pour la mise à jour AJAX --}}
                            <select class="form-select form-select-sm" onchange="updateJobStatus({{ $offre->id }}, this.value)">
                                <option value="En cours" {{ $offre->statut === "En cours" ? "selected" : "" }}>En cours</option>
                                <option value="Clôturé" {{ $offre->statut === "Clôturé" ? "selected" : "" }}>Clôturé</option>
                                <option value="Annulé" {{ $offre->statut === "Annulé" ? "selected" : "" }}>Annulé</option>
                            </select>
                            {{-- Les boutons appellent des fonctions JS pour les actions AJAX --}}
                            <button class="btn btn-outline-info btn-sm" onclick="editJobOffer({{ $offre->id }})">✏️</button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteJobOffer({{ $offre->id }})">🗑️</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center">Aucune offre d'emploi trouvée.</p>
            </div>
        @endforelse
    </div>

    {{-- Pas de pagination si on ne gère pas la pagination en PHP --}}
    {{-- Si vous aviez paginate() dans le contrôleur, vous mettriez ici : {{ $offres->links('pagination::bootstrap-5') }} --}}
    <div class="row g-0 justify-content-end mb-4" id="pagination-element">
        <div class="col-sm-6">
            <nav>
                {{-- Si vous utilisez $offres->paginate(X) dans votre contrôleur, décommentez ceci: --}}
                {{-- {{ $offres->links('pagination::bootstrap-5') }} --}}
                <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                    {{-- Si vous ne paginez pas en PHP, cette section n'est pas nécessaire. --}}
                </ul>
            </nav>
        </div>
    </div>
</div>
{{-- Modal Création/Édition Offre --}}
<div class="modal fade" id="createJobOfferModal" tabindex="-1" aria-labelledby="createJobOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="createJobOfferModalLabel"><i class="ri-briefcase-line me-2"></i> Offre d'Emploi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                {{-- Global Error Display (Optional, but good for summary) --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <strong>Oups!</strong> Il y a eu des problèmes avec votre soumission.
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="createJobOfferForm" class="needs-validation" method="POST" action="{{ route('offres.store') }}" novalidate>
                    @csrf
                    {{-- Champs du formulaire --}}
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="jobTitle" class="form-label fw-semibold">Titre du Poste <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jobTitle') is-invalid @enderror" id="jobTitle" name="jobTitle" value="{{ old('jobTitle') }}" required placeholder="Ex: Développeur Full Stack Senior">
                            <div class="invalid-feedback">Veuillez saisir le titre du poste.</div>
                            {{-- Specific Error Message for jobTitle --}}
                            @error('jobTitle')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jobTeam" class="form-label fw-semibold">Équipe / Département <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jobTeam') is-invalid @enderror" id="jobTeam" name="jobTeam" value="{{ old('jobTeam') }}" required placeholder="Ex: Web, RH, Marketing...">
                            <div class="invalid-feedback">Veuillez saisir l'équipe/département.</div>
                            @error('jobTeam')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jobSector" class="form-label fw-semibold">Secteur d'Activité</label>
                            <select class="form-select @error('jobSector') is-invalid @enderror" id="jobSector" name="jobSector">
                                <option value="">Sélectionner un secteur...</option>
                                <option value="Informatique" {{ old('jobSector') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                <option value="Finance" {{ old('jobSector') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Droit" {{ old('jobSector') == 'Droit' ? 'selected' : '' }}>Droit</option>
                                <option value="Bâtiment" {{ old('jobSector') == 'Bâtiment' ? 'selected' : '' }}>Bâtiment</option>
                                <option value="Sport" {{ old('jobSector') == 'Sport' ? 'selected' : '' }}>Sport</option>
                                <option value="Marketing" {{ old('jobSector') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Communication" {{ old('jobSector') == 'Communication' ? 'selected' : '' }}>Communication</option>
                            </select>
                            @error('jobSector')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="jobDescription" class="form-label fw-semibold">Description du Poste <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('jobDescription') is-invalid @enderror" id="jobDescription" name="jobDescription" rows="5" required placeholder="Détails des responsabilités, missions, compétences requises...">{{ old('jobDescription') }}</textarea>
                            <div class="invalid-feedback">Veuillez saisir une description du poste.</div>
                            @error('jobDescription')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contractType" class="form-label fw-semibold">Type de Contrat <span class="text-danger">*</span></label>
                            <select class="form-select @error('contractType') is-invalid @enderror" id="contractType" name="contractType" required>
                                <option value="">Sélectionner...</option>
                                <option value="CDI" {{ old('contractType') == 'CDI' ? 'selected' : '' }}>CDI (Contrat à Durée Indéterminée)</option>
                                <option value="CDD" {{ old('contractType') == 'CDD' ? 'selected' : '' }}>CDD (Contrat à Durée Déterminée)</option>
                                <option value="Stage" {{ old('contractType') == 'Stage' ? 'selected' : '' }}>Stage</option>
                                <option value="Alternance" {{ old('contractType') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                <option value="Freelance" {{ old('contractType') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                            <div class="invalid-feedback">Veuillez sélectionner un type de contrat.</div>
                            @error('contractType')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="applicationDeadline" class="form-label fw-semibold">Date Limite de Candidature <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('applicationDeadline') is-invalid @enderror" id="applicationDeadline" name="applicationDeadline" value="{{ old('applicationDeadline') }}" required>
                            <div class="invalid-feedback">Veuillez saisir la date limite.</div>
                            @error('applicationDeadline')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salaryAmount" class="form-label fw-semibold">Salaire (Optionnel)</label>
                            <input type="number" class="form-control @error('salaryAmount') is-invalid @enderror" id="salaryAmount" name="salaryAmount" value="{{ old('salaryAmount') }}" placeholder="Ex: 500000">
                            @error('salaryAmount')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salaryCurrency" class="form-label fw-semibold">Devise</label>
                            <select class="form-select @error('salaryCurrency') is-invalid @enderror" id="salaryCurrency" name="salaryCurrency">
                                <option value="XOF" {{ old('salaryCurrency') == 'XOF' ? 'selected' : '' }}>XOF (CFA)</option>
                                <option value="EUR" {{ old('salaryCurrency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="USD" {{ old('salaryCurrency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="CAD" {{ old('salaryCurrency') == 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                                <option value="GBP" {{ old('salaryCurrency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="" {{ old('salaryCurrency') == '' ? 'selected' : '' }}>Non spécifié</option>
                            </select>
                            @error('salaryCurrency')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="salaryPeriod" class="form-label fw-semibold">Période Salariale</label>
                            <select class="form-select @error('salaryPeriod') is-invalid @enderror" id="salaryPeriod" name="salaryPeriod">
                                <option value="monthly" {{ old('salaryPeriod') == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                                <option value="annual" {{ old('salaryPeriod') == 'annual' ? 'selected' : '' }}>Annuel</option>
                                <option value="" {{ old('salaryPeriod') == '' ? 'selected' : '' }}>Non spécifié</option>
                            </select>
                            @error('salaryPeriod')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="experienceRequired" class="form-label fw-semibold">Expérience Requise <span class="text-danger">*</span></label>
                            <select class="form-select @error('experienceRequired') is-invalid @enderror" id="experienceRequired" name="experienceRequired" required>
                                <option value="">Sélectionner...</option>
                                <option value="Non spécifiée" {{ old('experienceRequired') == 'Non spécifiée' ? 'selected' : '' }}>Non spécifiée</option>
                                <option value="Moins de 1 an" {{ old('experienceRequired') == 'Moins de 1 an' ? 'selected' : '' }}>Moins de 1 an</option>
                                <option value="1-3 ans" {{ old('experienceRequired') == '1-3 ans' ? 'selected' : '' }}>1-3 ans</option>
                                <option value="3-5 ans" {{ old('experienceRequired') == '3-5 ans' ? 'selected' : '' }}>3-5 ans</option>
                                <option value="Plus de 5 ans" {{ old('experienceRequired') == 'Plus de 5 ans' ? 'selected' : '' }}>Plus de 5 ans</option>
                            </select>
                            <div class="invalid-feedback">Veuillez spécifier l'expérience requise.</div>
                            @error('experienceRequired')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jobStatus" class="form-label fw-semibold">Statut de l'Offre <span class="text-danger">*</span></label>
                            <select class="form-select @error('jobStatus') is-invalid @enderror" id="jobStatus" name="jobStatus" required>
                                <option value="En cours" {{ old('jobStatus') == 'En cours' ? 'selected' : '' }}>En cours</option>
                                <option value="Clôturé" {{ old('jobStatus') == 'Clôturé' ? 'selected' : '' }}>Clôturé</option>
                                <option value="Annulé" {{ old('jobStatus') == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                            <div class="invalid-feedback">Veuillez sélectionner un statut.</div>
                            @error('jobStatus')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input @error('remoteOption') is-invalid @enderror" type="checkbox" id="remoteOption" name="remoteOption" value="1" {{ old('remoteOption') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remoteOption">
                                    Télétravail possible
                                </label>
                                @error('remoteOption')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-4"><i class="ri-save-line me-2"></i> Enregistrer l'Offre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // This script ensures the modal stays open on validation error
    @if ($errors->any())
        var createJobOfferModal = new bootstrap.Modal(document.getElementById('createJobOfferModal'));
        createJobOfferModal.show();
    @endif

    // Optional: Add a client-side validation handler to Bootstrap's native validation
    (function () {
        'use strict'
        var form = document.getElementById('createJobOfferForm');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })()
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // --- Initialisation du modal de Création/Édition d'Offre d'Emploi ---
    const createJobOfferModal = new bootstrap.Modal(document.getElementById('createJobOfferModal'));
    const createJobOfferForm = document.getElementById('createJobOfferForm');

    // Fonction pour réinitialiser le formulaire
    function resetCreateJobOfferForm() {
        createJobOfferForm.reset();
        createJobOfferForm.classList.remove('was-validated');
        
        // Définit le statut par défaut et la date limite par défaut
        document.getElementById('jobStatus').value = "En cours";
        const defaultDate = new Date();
        defaultDate.setMonth(defaultDate.getMonth() + 1);
        const year = defaultDate.getFullYear();
        const month = String(defaultDate.getMonth() + 1).padStart(2, '0');
        const day = String(defaultDate.getDate()).padStart(2, '0');
        document.getElementById('applicationDeadline').value = `${year}-${month}-${day}`;

        // Réinitialise le titre du modal et les champs cachés d'édition
        document.getElementById('createJobOfferModalLabel').innerHTML = '<i class="ri-briefcase-line me-2"></i> Créer une nouvelle Offre d\'Emploi';
        const hiddenIdInput = document.getElementById('editJobId');
        if (hiddenIdInput) hiddenIdInput.remove();
        const methodInput = document.getElementById('methodInput');
        if (methodInput) methodInput.remove();

        // Réinitialise l'action et la méthode du formulaire pour la création
        createJobOfferForm.action = "{{ route('offres.store') }}";
        createJobOfferForm.method = "POST";
    }

  //  document.getElementById('createJobOfferModal').addEventListener('show.bs.modal', resetCreateJobOfferForm);
    document.getElementById('createJobOfferModal').addEventListener('hidden.bs.modal', resetCreateJobOfferForm);


    // --- Fonctions CRUD via AJAX ---

    /**
     * Met à jour le statut d'une offre via AJAX.
     * @param {number} id L'ID de l'offre à mettre à jour.
     * @param {string} newStatus Le nouveau statut (En cours, Clôturé, Annulé).
     */
    function updateJobStatus(id, newStatus) {
        if (!confirm(`Voulez-vous vraiment changer le statut de cette offre à "${newStatus}" ?`)) {
            // Si l'utilisateur annule, restaure la valeur précédente du select
            // Note: `event.target` est disponible car la fonction est appelée `onchange`
            event.target.value = event.target.dataset.originalStatus || 'En cours'; // Utilisez une valeur par défaut ou l'attribut data-original-status
            return;
        }

        fetch(`/offres/${id}/update-status`, { // Utilisez la route PATCH pour le statut
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => {
            if (!response.ok) {
                // Si la réponse n'est pas OK (par exemple 4xx ou 5xx), lancez une erreur
                return response.json().then(err => { throw new Error(err.message || 'Erreur serveur'); });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Statut mis à jour avec succès !');
                // Optionnel: Mettre à jour l'interface utilisateur sans recharger
                // Pour une simplicité, un rechargement complet est souvent plus simple après un update visuel
                // mais pour un simple changement de statut, c'est souvent suffisant.
                // window.location.reload(); // Décommentez si vous voulez un rechargement complet après updateStatus
            } else {
                alert('Erreur lors de la mise à jour du statut : ' + (data.message || ''));
            }
        })
        .catch(error => {
            console.error('Erreur AJAX lors de la mise à jour du statut:', error);
            alert('Une erreur est survenue lors de la mise à jour du statut.');
        });
    }

    /**
     * Récupère les données d'une offre et remplit le formulaire d'édition.
     * @param {number} id L'ID de l'offre à éditer.
     */
    function editJobOffer(id) {
        // Faire une requête AJAX pour obtenir les détails de l'offre
        fetch(`/offres/${id}/edit`) // Assurez-vous que cette route existe dans web.php
            .then(response => {
                if (!response.ok) {
                    throw new Error('Offre non trouvée ou erreur serveur.');
                }
                return response.json();
            })
            .then(jobToEdit => {
                // Mettre à jour le titre du modal
                document.getElementById('createJobOfferModalLabel').innerHTML = '<i class="ri-briefcase-line me-2"></i> Modifier l\'Offre d\'Emploi';

                // Remplir les champs du formulaire avec les données de l'offre
                document.getElementById('jobTitle').value = jobToEdit.titre;
                document.getElementById('jobTeam').value = jobToEdit.equipe;
                document.getElementById('jobDescription').value = jobToEdit.description;
                document.getElementById('contractType').value = jobToEdit.type_contrat;
                document.getElementById('applicationDeadline').value = jobToEdit.date_limite; // Laravel renvoie déjà au format YYYY-MM-DD
                document.getElementById('salaryAmount').value = jobToEdit.salaire;
                document.getElementById('salaryCurrency').value = jobToEdit.devise || '';
                document.getElementById('salaryPeriod').value = jobToEdit.periode_salaire || '';
                document.getElementById('experienceRequired').value = jobToEdit.experience_requise;
                document.getElementById('jobSector').value = jobToEdit.secteur || '';
                document.getElementById('jobStatus').value = jobToEdit.statut;
                document.getElementById('remoteOption').checked = jobToEdit.teletravail;

                // Ajouter les champs cachés pour l'ID et la méthode PUT
                let hiddenIdInput = document.getElementById('editJobId');
                if (!hiddenIdInput) {
                    hiddenIdInput = document.createElement('input');
                    hiddenIdInput.type = 'hidden';
                    hiddenIdInput.id = 'editJobId';
                    hiddenIdInput.name = 'id'; // Nécessaire pour le Model Binding de Laravel si vous ne mettez pas l'ID dans l'action
                    createJobOfferForm.appendChild(hiddenIdInput);
                }
                hiddenIdInput.value = jobToEdit.id;

                let methodInput = document.getElementById('methodInput');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.id = 'methodInput';
                    createJobOfferForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';

                // Modifier l'action du formulaire pour pointer vers la route de mise à jour
                createJobOfferForm.action = `/offres/${jobToEdit.id}`;
                createJobOfferForm.method = 'POST'; // Toujours POST pour simuler PUT/PATCH avec _method

                createJobOfferModal.show(); // Afficher le modal
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données de l\'offre pour édition:', error);
                alert('Impossible de récupérer les détails de l\'offre pour édition.');
            });
    }

    /**
     * Supprime une offre via AJAX.
     * @param {number} id L'ID de l'offre à supprimer.
     */
    function deleteJobOffer(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette offre d\'emploi ? Cette action est irréversible.')) {
            fetch(`/offres/${id}`, { // Route DELETE
                method: 'POST', // Simule DELETE avec _method
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.message || 'Erreur serveur'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Offre supprimée avec succès ! La page va se recharger.');
                    window.location.reload(); // Recharger la page après suppression pour refléter le changement
                } else {
                    alert('Erreur lors de la suppression de l\'offre : ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Erreur AJAX lors de la suppression:', error);
                alert('Une erreur est survenue lors de la suppression de l\'offre.');
            });
        }
    }
</script>

@endsection