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
@section('content')
    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Profil</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item text-primary">Paramètres</li>
                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                </ol>
            </nav>
        </div>
        <div class="head-icons ms-2">
            <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-original-title="Collapse" id="collapse-header">
                <i class="ti ti-chevrons-up"></i>
            </a>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="border-bottom mb-3 pb-3">
                <h4>Profil</h4>
            </div>

            <!-- Formulaire du Profil -->
            <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                <div class="border-bottom mb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h6 class="mb-3">Information basique</h6>
                                <div class="background-info d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                    <div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames" id="imagePreviewContainer">
                                        @if ($user->photo_profile_path)
                                            <img src="{{ asset($user->photo_profile_path) }}" width="80" height="80" class="rounded-circle" id="profileImagePreview">
                                        @else
                                            <i class="ti ti-photo text-gray-3 fs-16" id="placeholderIcon"></i>
                                            <img src="" width="80" height="80" class="rounded-circle d-none" id="profileImagePreview">
                                        @endif
                                    </div>
                                    <div class="profile-upload">
                                        <div class="mb-2">
                                            <h6 class="mb-1">Photo de profil</h6>
                                            <p class="fs-12">Taille recommandée : 300x300px (Max: 2MB)</p>
                                            <small id="imageError" class="text-danger d-none"></small>
                                        </div>
                                        <div class="profile-uploader d-flex align-items-center">
                                            <div class="drag-upload-btn btn btn-sm btn-primary me-2">
                                                Téléverser
                                                <input type="file" name="photo_profile_path" class="form-control image-sign" accept="image/jpeg,image/png,image/jpg" id="photoInput">
                                            </div>
                                            <a href="javascript:void(0);" class="btn btn-light btn-sm" id="cancelImage">Annuler</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-4">
                                    <label class="form-label mb-md-0">Nom Complet</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-4">
                                    <label class="form-label mb-md-0">Email</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-4">
                                    <label class="form-label mb-md-0">Téléphone</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="tel" class="form-control" name="telephone" value="{{ $user->telephone }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-outline-light border me-3">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder le profil</button>
                </div>
            </form>

            <!-- Formulaire du Mot de Passe -->
            <form action="{{ route('settings.updatePassword') }}" method="POST" id="passwordForm" class="mt-4">
                @csrf
                <div class="border-bottom mb-3 pb-3">
                    <h6 class="mb-3">Changer le mot de passe</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-5">
                                    <label class="form-label mb-md-0">Mot de passe courant</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="pass-group">
                                        <input type="password" name="current_password" class="pass-input form-control" id="currentPassword">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                    <small class="text-danger d-none" id="currentPasswordError"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-5">
                                    <label class="form-label mb-md-0">Nouveau mot de passe</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="pass-group">
                                        <input type="password" name="password" class="pass-inputs form-control" id="newPassword">
                                        <span class="ti toggle-passwords ti-eye-off"></span>
                                    </div>
                                    <small class="text-muted d-block mt-1" id="passwordStrength"></small>
                                    <small class="text-danger d-none" id="newPasswordError"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-5">
                                    <label class="form-label mb-md-0">Confirmer le mot de passe</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="pass-group">
                                        <input type="password" name="password_confirmation" class="pass-inputa form-control" id="confirmPassword">
                                        <span class="ti toggle-passworda ti-eye-off"></span>
                                    </div>
                                    <small class="text-danger d-none" id="confirmPasswordError"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-outline-light border me-3" id="resetPasswordForm">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .password-weak { color: #dc3545; }
        .password-medium { color: #ffc107; }
        .password-strong { color: #28a745; }
        .pass-group { position: relative; }
        .toggle-password, .toggle-passwords, .toggle-passworda {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>

    <script>
        // ===== Gestion de l'image de profil =====
        const photoInput = document.getElementById('photoInput');
        const profileImagePreview = document.getElementById('profileImagePreview');
        const placeholderIcon = document.getElementById('placeholderIcon');
        const imageError = document.getElementById('imageError');
        const cancelImageBtn = document.getElementById('cancelImage');
        let originalImageSrc = profileImagePreview.src;

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            imageError.classList.add('d-none');

            if (file) {
                // Validation du type de fichier
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    imageError.textContent = 'Format invalide. Utilisez JPG, JPEG ou PNG.';
                    imageError.classList.remove('d-none');
                    photoInput.value = '';
                    return;
                }

                // Validation de la taille (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    imageError.textContent = 'L\'image est trop grande. Maximum 2MB.';
                    imageError.classList.remove('d-none');
                    photoInput.value = '';
                    return;
                }

                // Afficher l'aperçu
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                    profileImagePreview.classList.remove('d-none');
                    if (placeholderIcon) {
                        placeholderIcon.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Annuler l'upload d'image
        cancelImageBtn.addEventListener('click', function() {
            photoInput.value = '';
            if (originalImageSrc) {
                profileImagePreview.src = originalImageSrc;
            } else {
                profileImagePreview.classList.add('d-none');
                if (placeholderIcon) {
                    placeholderIcon.classList.remove('d-none');
                }
            }
            imageError.classList.add('d-none');
        });

        // ===== Validation du mot de passe en temps réel =====
        const currentPassword = document.getElementById('currentPassword');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const passwordStrength = document.getElementById('passwordStrength');
        const newPasswordError = document.getElementById('newPasswordError');
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        const currentPasswordError = document.getElementById('currentPasswordError');

        // Fonction pour évaluer la force du mot de passe
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = '';
            let className = '';

            if (password.length === 0) {
                return { strength: 0, feedback: '', className: '' };
            }

            if (password.length < 8) {
                return { 
                    strength: 0, 
                    feedback: 'Le mot de passe doit contenir au moins 8 caractères', 
                    className: 'password-weak' 
                };
            }

            // Critères de force
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            // Évaluation
            if (strength <= 2) {
                feedback = 'Mot de passe faible ⚠️';
                className = 'password-weak';
            } else if (strength <= 4) {
                feedback = 'Mot de passe moyen 🔸';
                className = 'password-medium';
            } else {
                feedback = 'Mot de passe fort ✓';
                className = 'password-strong';
            }

            return { strength, feedback, className };
        }

        // Validation en temps réel du nouveau mot de passe
        newPassword.addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            passwordStrength.textContent = result.feedback;
            passwordStrength.className = result.className;

            if (this.value.length > 0 && this.value.length < 8) {
                newPasswordError.textContent = 'Le mot de passe doit contenir au moins 8 caractères';
                newPasswordError.classList.remove('d-none');
            } else {
                newPasswordError.classList.add('d-none');
            }

            // Vérifier la correspondance si le champ de confirmation est rempli
            if (confirmPassword.value) {
                validatePasswordMatch();
            }
        });

        // Validation de la correspondance des mots de passe
        function validatePasswordMatch() {
            if (newPassword.value !== confirmPassword.value) {
                confirmPasswordError.textContent = 'Les mots de passe ne correspondent pas';
                confirmPasswordError.classList.remove('d-none');
                return false;
            } else {
                confirmPasswordError.classList.add('d-none');
                return true;
            }
        }

        confirmPassword.addEventListener('input', validatePasswordMatch);

        // Validation du formulaire de mot de passe
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Réinitialiser les erreurs
            currentPasswordError.classList.add('d-none');
            newPasswordError.classList.add('d-none');
            confirmPasswordError.classList.add('d-none');

            // Validation du mot de passe actuel
            if (!currentPassword.value) {
                currentPasswordError.textContent = 'Le mot de passe actuel est requis';
                currentPasswordError.classList.remove('d-none');
                isValid = false;
            }

            // Validation du nouveau mot de passe
            if (!newPassword.value) {
                newPasswordError.textContent = 'Le nouveau mot de passe est requis';
                newPasswordError.classList.remove('d-none');
                isValid = false;
            } else if (newPassword.value.length < 8) {
                newPasswordError.textContent = 'Le mot de passe doit contenir au moins 8 caractères';
                newPasswordError.classList.remove('d-none');
                isValid = false;
            }

            // Validation de la confirmation
            if (!confirmPassword.value) {
                confirmPasswordError.textContent = 'La confirmation est requise';
                confirmPasswordError.classList.remove('d-none');
                isValid = false;
            } else if (!validatePasswordMatch()) {
                isValid = false;
            }

            if (isValid) {
                showAlert('Mise à jour en cours...', 'info');
                this.submit();
            }
        });

        // Réinitialiser le formulaire de mot de passe
        document.getElementById('resetPasswordForm').addEventListener('click', function() {
            document.getElementById('passwordForm').reset();
            passwordStrength.textContent = '';
            currentPasswordError.classList.add('d-none');
            newPasswordError.classList.add('d-none');
            confirmPasswordError.classList.add('d-none');
        });

        // ===== Toggle password visibility =====
        document.querySelector('.toggle-password').addEventListener('click', function() {
            togglePasswordVisibility(currentPassword, this);
        });

        document.querySelector('.toggle-passwords').addEventListener('click', function() {
            togglePasswordVisibility(newPassword, this);
        });

        document.querySelector('.toggle-passworda').addEventListener('click', function() {
            togglePasswordVisibility(confirmPassword, this);
        });

        function togglePasswordVisibility(input, icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            }
        }

        // ===== Fonction pour afficher les alertes =====
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            alertContainer.appendChild(alertDiv);

            // Auto-dismiss après 5 secondes
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }
    </script>
@endsection