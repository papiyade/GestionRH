@extends('layouts.admin_rh-dashboard')

@section('content')

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a href="{{ route('offres_candidat.index') }}" class="navbar-brand fw-bold">
      <i class="bi bi-arrow-left me-2"></i>Retour aux offres
    </a>
    <div class="navbar-nav ms-auto">
      @if(isset($offre))
        <span class="nav-link text-white-50">
          <i class="bi bi-clock me-1"></i>{{ $offre->joursRestants }} jour{{ $offre->joursRestants > 1 ? 's' : '' }} restant{{ $offre->joursRestants > 1 ? 's' : '' }}
        </span>
      @endif
    </div>
  </div>
</nav>
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

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      
      <!-- En-tête du poste -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
              <i class="bi bi-code-slash text-primary fs-4"></i>
            </div>
            <div>
              <h2 class="mb-1 fw-bold">{{$offre->titre}}</h2>
              <div class="d-flex gap-2">
                <span class="badge bg-success">{{$offre->type_contrat}}</span>
                <span class="badge bg-light text-dark">{{$offre->salaire}} {{ $offre->devise }}/{{ $offre->periode_salaire }}</span>
                <span class="badge bg-light text-dark">{{$offre->experience_requise}}</span>
              </div>
            </div>
          </div>
          
          <!-- Indicateur de progression -->
          <div class="d-flex align-items-center justify-content-center gap-2 mt-4">
            <div class="progress-step active"></div>
            <div class="flex-grow-1 bg-light" style="height: 2px;"></div>
            <div class="progress-step"></div>
            <div class="flex-grow-1 bg-light" style="height: 2px;"></div>
            <div class="progress-step"></div>
          </div>
          <div class="d-flex justify-content-between text-sm text-muted mt-2">
            <span class="fw-semibold text-primary">Informations</span>
            <span>Documents</span>
            <span>Confirmation</span>
          </div>
        </div>
      </div>

      <form id="candidatureForm"
      class="needs-validation"
      novalidate
      method="POST"
      action="{{ route('candidatures.store', $offre->id) }}"
      enctype="multipart/form-data">
    @csrf

        <div class="step-content" id="step1">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
              <h5 class="mb-0">
                <i class="bi bi-person-circle me-2"></i>
                Vos informations personnelles
              </h5>
            </div>
            <div class="card-body p-4 step-indicator">

              <div class="row g-3">
                <div class="col-md-6 step">
                  <label class="form-label fw-semibold">Prénom *</label>
                  <input type="text" class="form-control form-control-lg" name="prenom" required>
                  <div class="invalid-feedback">Veuillez saisir votre prénom</div>
                </div>
                <div class="col-md-6 step">
                  <label class="form-label fw-semibold">Nom *</label>
                  <input type="text" class="form-control form-control-lg" name="nom" required>
                  <div class="invalid-feedback">Veuillez saisir votre nom</div>
                </div>
                <div class="col-md-8 step">
                  <label class="form-label fw-semibold">Email *</label>
                  <input type="email" class="form-control form-control-lg" name="email" required>
                  <div class="invalid-feedback">Veuillez saisir un email valide</div>
                </div>
                <div class="col-md-4 step">
                  <label class="form-label fw-semibold">Téléphone *</label>
                  <input type="tel" class="form-control form-control-lg" name="telephone" required>
                  <div class="invalid-feedback">Numéro requis</div>
                </div>
                <div class="col-12 step">
                  <label class="form-label fw-semibold">LinkedIn / Portfolio</label>
                  <input type="url" class="form-control form-control-lg" name="linkedin" placeholder="https://...">
                </div>
              </div>

              <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-primary btn-lg px-4" onclick="nextStep()">
                  Suivant <i class="bi bi-arrow-right ms-2"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="step-content d-none" id="step2">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
              <h5 class="mb-0">
                <i class="bi bi-file-earmark-text me-2"></i>
                Vos documents
              </h5>
            </div>
            <div class="card-body p-4">

              <div class="mb-4">
                <label class="form-label fw-semibold">CV * (PDF, DOC, DOCX - Max 5Mo)</label>
                <div class="file-drop-zone rounded p-4 text-center">
                  <input type="file" class="form-control d-none" id="cv-upload" name="cv" accept=".pdf,.doc,.docx" required>
                  <i class="bi bi-cloud-upload text-primary fs-1 mb-2"></i>
                  <p class="mb-2">Glissez votre CV ici ou <strong class="text-primary">cliquez pour parcourir</strong></p>
                  <small class="text-muted">Formats acceptés: PDF, DOC, DOCX</small>
                  <div class="mt-2" id="cv-preview"></div>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Lettre de motivation</label>
                <div class="file-drop-zone rounded p-4 text-center">
                  <input type="file" class="form-control d-none" id="lettre-upload" name="lettre" accept=".pdf,.doc,.docx">
                  <i class="bi bi-envelope text-success fs-1 mb-2"></i>
                  <p class="mb-2">Glissez votre lettre ici ou <strong class="text-success">cliquez pour parcourir</strong></p>
                  <small class="text-muted">Optionnel - PDF, DOC, DOCX</small>
                  <div class="mt-2" id="lettre-preview"></div>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Message de motivation</label>
                <textarea class="form-control" rows="4" name="message" placeholder="Expliquez brièvement pourquoi ce poste vous intéresse..."></textarea>
                <div class="form-text">
                  <i class="bi bi-info-circle me-1"></i>
                  Partagez votre motivation en quelques lignes (optionnel)
                </div>
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Disponibilité</label>
                  <select class="form-select form-select-lg" name="disponibilite">
                    <option value="Immédiate">Immédiate</option>
                    <option value="1 mois">1 mois</option>
                    <option value="2 mois">2 mois</option>
                    <option value="3 mois">3 mois</option>
                    <option value="À négocier">À négocier</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Prétentions salariales</label>
                  <input type="text" class="form-control form-control-lg" name="pretention" placeholder="Ex: 50k € ou À négocier">
                </div>
              </div>

              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="prevStep()">
                  <i class="bi bi-arrow-left me-2"></i>Précédent
                </button>
                <button type="button" class="btn btn-primary btn-lg px-4" onclick="nextStep()">
                  Suivant <i class="bi bi-arrow-right ms-2"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="step-content d-none" id="step3">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white py-3">
              <h5 class="mb-0">
                <i class="bi bi-check-circle me-2"></i>
                Confirmation de votre candidature
              </h5>
            </div>
            <div class="card-body p-4">

              <div class="alert alert-info border-0">
                <i class="bi bi-info-circle me-2"></i>
                Vérifiez vos informations avant d'envoyer votre candidature
              </div>

              <div id="resume-candidature">
                </div>

              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="accepterConditions" required>
                <label class="form-check-label" for="accepterConditions">
                  J'accepte que mes données soient traitées dans le cadre de ma candidature *
                </label>
                <div class="invalid-feedback">Vous devez accepter les conditions pour postuler.</div>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="prevStep()">
                  <i class="bi bi-arrow-left me-2"></i>Précédent
                </button>
                <button type="submit" class="btn btn-success btn-lg px-4">
                  <i class="bi bi-send me-2"></i>Envoyer ma candidature
                </button>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
let currentStep = 1;
const totalSteps = 3;

// Gestion des étapes
function nextStep() {
  if (validateCurrentStep()) {
    if (currentStep < totalSteps) {
      document.getElementById(`step${currentStep}`).classList.add('d-none');
      currentStep++;
      document.getElementById(`step${currentStep}`).classList.remove('d-none');
      updateProgressIndicator();

      if (currentStep === 3) {
        generateResume();
      }
    }
  }
}

function prevStep() {
  if (currentStep > 1) {
    document.getElementById(`step${currentStep}`).classList.add('d-none');
    currentStep--;
    document.getElementById(`step${currentStep}`).classList.remove('d-none');
    updateProgressIndicator();
  }
}

function updateProgressIndicator() {
  document.querySelectorAll('.progress-step').forEach((step, index) => {
    step.classList.toggle('active', index < currentStep);
  });
}

function validateCurrentStep() {
  const currentStepDiv = document.getElementById(`step${currentStep}`);
  // Select all input fields within the current step that are required and visible
  const requiredFields = currentStepDiv.querySelectorAll('[required]:not(.d-none)');
  let isValid = true;

  requiredFields.forEach(field => {
    // For file inputs, check if files are selected
    if (field.type === 'file') {
      if (field.files.length === 0) {
        field.classList.add('is-invalid');
        isValid = false;
      } else {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
      }
    } else if (field.type === 'checkbox') {
        if (!field.checked) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    } else if (!field.value.trim()) {
      field.classList.add('is-invalid');
      isValid = false;
    } else {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
    }
  });

  return isValid;
}


// Gestion des fichiers
function setupFileUpload(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  const dropZone = input.closest('.file-drop-zone');

  dropZone.addEventListener('click', () => input.click());

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('drag-over');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('drag-over');
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    if (e.dataTransfer.files.length > 0) {
      input.files = e.dataTransfer.files;
      displayFilePreview(input.files[0], preview);
    }
  });

  input.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
      displayFilePreview(e.target.files[0], preview);
    } else {
        // Clear preview if file is unselected
        preview.innerHTML = '';
        input.classList.remove('is-valid');
        // If required, mark as invalid
        if (input.hasAttribute('required')) {
            input.classList.add('is-invalid');
        }
    }
  });
}

function displayFilePreview(file, previewDiv) {
  const size = (file.size / 1024 / 1024).toFixed(2);
  previewDiv.innerHTML = `
    <div class="alert alert-success border-0 mt-3">
      <i class="bi bi-file-check me-2"></i>
      <strong>${file.name}</strong> (${size} Mo)
      <button type="button" class="btn-close float-end" onclick="removeFilePreview(this, '${file.name}', '${previewDiv.id}')"></button>
    </div>
  `;
}

function removeFilePreview(closeButton, fileName, previewDivId) {
    closeButton.closest('.alert').remove();
    const inputId = previewDivId === 'cv-preview' ? 'cv-upload' : 'lettre-upload';
    const fileInput = document.getElementById(inputId);

    // Clear the file input's value
    fileInput.value = ''; // This clears the selected file

    // Re-run validation for the file input if needed
    if (fileInput.hasAttribute('required')) {
        fileInput.classList.remove('is-valid');
        fileInput.classList.add('is-invalid');
    }
}


function generateResume() {
  const form = document.getElementById('candidatureForm');
  // Access input values using their 'name' attributes
  const prenom = form.querySelector('[name="prenom"]').value;
  const nom = form.querySelector('[name="nom"]').value;
  const email = form.querySelector('[name="email"]').value;
  const telephone = form.querySelector('[name="telephone"]').value;
  const linkedin = form.querySelector('[name="linkedin"]').value;
  const cvFile = document.getElementById('cv-upload').files[0];
  const lettreFile = document.getElementById('lettre-upload').files[0];
  const message = form.querySelector('[name="message"]').value;
  const disponibilite = form.querySelector('[name="disponibilite"]').value;
  const pretention = form.querySelector('[name="pretention"]').value;

  const resume = document.getElementById('resume-candidature');
  resume.innerHTML = `
    <div class="row g-3">
      <div class="col-md-6">
        <h6 class="text-primary">Informations personnelles</h6>
        <p class="mb-1"><i class="bi bi-person me-2"></i>${prenom} ${nom}</p>
        <p class="mb-1"><i class="bi bi-envelope me-2"></i>${email}</p>
        <p class="mb-1"><i class="bi bi-phone me-2"></i>${telephone}</p>
        ${linkedin ? `<p class="mb-1"><i class="bi bi-linkedin me-2"></i><a href="${linkedin}" target="_blank">${linkedin}</a></p>` : ''}
      </div>
      <div class="col-md-6">
        <h6 class="text-success">Documents et Autres</h6>
        <p class="mb-1"><i class="bi bi-file-earmark-text me-2"></i>CV: ${cvFile ? cvFile.name : 'Non attaché'}</p>
        ${lettreFile ? `<p class="mb-1"><i class="bi bi-file-earmark-text me-2"></i>Lettre de motivation: ${lettreFile.name}</p>` : ''}
        ${message ? `<p class="mb-1"><i class="bi bi-chat-dots me-2"></i>Message: ${message}</p>` : ''}
        <p class="mb-1"><i class="bi bi-calendar me-2"></i>Disponibilité: ${disponibilite}</p>
        <p class="mb-1"><i class="bi bi-currency-euro me-2"></i>Prétentions salariales: ${pretention || 'Non spécifié'}</p>
      </div>
    </div>
  `;
}


// Intercept form submission to run validation, then allow native submit
document.getElementById('candidatureForm').addEventListener('submit', function(e) {
  // Only validate the final step's required fields (e.g., checkbox)
  const accepterConditionsCheckbox = document.getElementById('accepterConditions');
  if (!accepterConditionsCheckbox.checked) {
    e.preventDefault(); // Prevent native form submission
    accepterConditionsCheckbox.classList.add('is-invalid');
    return;
  } else {
    accepterConditionsCheckbox.classList.remove('is-invalid');
    accepterConditionsCheckbox.classList.add('is-valid');
  }

  // If validation passes, allow the native form submission to proceed
  // The 'action' attribute of the form will handle routing to your Laravel controller
  // You can remove the setTimeout fake success message here, as Laravel will handle the redirect/response
  console.log('Form submission allowed to proceed to Laravel.');

  // Optional: Add the loading state to the button immediately before native submit
  const submitBtn = e.target.querySelector('button[type="submit"]');
  submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Envoi en cours...';
  submitBtn.disabled = true;

  // Let the form submit naturally
});


// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    setupFileUpload('cv-upload', 'cv-preview');
    setupFileUpload('lettre-upload', 'lettre-preview');
    updateProgressIndicator(); // Ensure progress indicator is correct on load
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection