<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .form-header {
            background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
            color: white;
            padding: 40px;
            border-radius: 16px 16px 0 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.2);
        }

        .form-header h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .form-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .main-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border: none;
            overflow: hidden;
        }

        .form-body {
            padding: 40px;
        }

        .section-title {
            color: #AE3D7D;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 30px 0 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #AE3D7D;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title:first-child {
            margin-top: 0;
        }

        .section-title i {
            font-size: 1.6rem;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            color: #AE3D7D;
            font-size: 1rem;
        }

        .form-label .required {
            color: #dc3545;
            font-weight: 700;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #AE3D7D;
            box-shadow: 0 0 0 0.2rem rgba(174, 61, 125, 0.15);
        }

        .form-control:hover,
        .form-select:hover {
            border-color: #c24d8f;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .file-upload-wrapper {
            position: relative;
        }

        .file-upload-wrapper .form-control {
            cursor: pointer;
        }

        .file-upload-wrapper .form-control::file-selector-button {
            background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            margin-right: 12px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .file-upload-wrapper .form-control::file-selector-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(174, 61, 125, 0.3);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .input-icon .form-control {
            padding-left: 45px;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f1f5 0%, #f0e8ee 100%);
            border-left: 4px solid #AE3D7D;
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .info-box i {
            color: #AE3D7D;
            font-size: 1.2rem;
            margin-right: 8px;
        }

        .info-box p {
            margin: 0;
            color: #555;
        }

        .btn-submit {
            background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
            color: white;
            padding: 16px 40px;
            border-radius: 10px;
            border: none;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(174, 61, 125, 0.4);
            color: white;
        }

        .btn-submit i {
            margin-left: 8px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: none;
            border-left: 4px solid #28a745;
            border-radius: 10px;
            padding: 16px 20px;
        }

        .card-footer-custom {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 24px 40px;
            border-top: 2px solid #e0e0e0;
        }

        small.text-muted {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: #777;
        }

        .optional-badge {
            display: inline-block;
            background: #f0f0f0;
            color: #666;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-left: 8px;
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 24px;
            }

            .form-header {
                padding: 30px 20px;
            }

            .form-header h3 {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-card">
                    <!-- Header -->
                    <div class="form-header">
                        <h3><i class="bi bi-person-badge me-2"></i>Fiche d'Inscription Employé</h3>
                        <p>Veuillez remplir tous les champs requis avec précision</p>
                    </div>

                    <!-- Body -->
                    <div class="form-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <div class="info-box">
                            <i class="bi bi-info-circle"></i>
                            <strong>Important :</strong> Les champs marqués d'un <span class="required">*</span> sont obligatoires.
                        </div>

                        <form action="{{ route('rh.employees.store', ['id' => $entreprise->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Section: Informations Personnelles -->
                            <h5 class="section-title">
                                <i class="bi bi-person-circle"></i>
                                Informations Personnelles
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-person"></i>
                                        Prénom <span class="required">*</span>
                                    </label>
                                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Entrez votre prénom" required>
                                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-person"></i>
                                        Nom <span class="required">*</span>
                                    </label>
                                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Entrez votre nom" required>
                                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-calendar"></i>
                                        Date de Naissance <span class="required">*</span>
                                    </label>
                                    <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-geo-alt"></i>
                                        Lieu de Naissance <span class="required">*</span>
                                    </label>
                                    <input type="text" name="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror" value="{{ old('lieu_naissance') }}" placeholder="Ville/Pays de naissance" required>
                                    @error('lieu_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-house"></i>
                                    Adresse <span class="required">*</span>
                                </label>
                                <textarea name="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="3" placeholder="Adresse complète" required>{{ old('adresse') }}</textarea>
                                @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-pin-map"></i>
                                    Résidence Actuelle <span class="required">*</span>
                                </label>
                                <input type="text" name="residence_actuelle" class="form-control @error('residence_actuelle') is-invalid @enderror" value="{{ old('residence_actuelle') }}" placeholder="Ville/Quartier actuel" required>
                                @error('residence_actuelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-telephone"></i>
                                        Téléphone <span class="required">*</span>
                                    </label>
                                    <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" placeholder="+221 XX XXX XX XX" required>
                                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-envelope"></i>
                                        Email <span class="required">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="exemple@email.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-briefcase"></i>
                                    Fiche de Poste <span class="required">*</span>
                                </label>
                                <input type="text" name="fiche_poste" class="form-control @error('fiche_poste') is-invalid @enderror" value="{{ old('fiche_poste') }}" placeholder="Ex: Développeur, Comptable, Manager..." required>
                                @error('fiche_poste')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Section: Documents Requis -->
                            <h5 class="section-title">
                                <i class="bi bi-file-earmark-text"></i>
                                Documents Requis
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-card-image"></i>
                                        Photocopie Identité/Passeport <span class="required">*</span>
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="photocopie_identite" class="form-control @error('photocopie_identite') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    <small class="text-muted">Formats acceptés: PDF, JPG, PNG</small>
                                    @error('photocopie_identite')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        Extrait de Naissance <span class="required">*</span>
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="extrait_naissance" class="form-control @error('extrait_naissance') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                    </div>
                                    <small class="text-muted">Formats acceptés: PDF, JPG, PNG</small>
                                    @error('extrait_naissance')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-house-check"></i>
                                        Certificat de Résidence
                                        <span class="optional-badge">Optionnel</span>
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="certificat_residence" class="form-control @error('certificat_residence') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <small class="text-muted">Formats acceptés: PDF, JPG, PNG</small>
                                    @error('certificat_residence')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-laptop"></i>
                                        Fiche de Dotation de Matériels
                                        <span class="optional-badge">Optionnel</span>
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="fiche_dotation_materiels" class="form-control @error('fiche_dotation_materiels') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <small class="text-muted">Si applicable</small>
                                    @error('fiche_dotation_materiels')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Section: Situation Familiale -->
                            <h5 class="section-title">
                                <i class="bi bi-heart"></i>
                                Situation Familiale
                                <span class="optional-badge">Section Optionnelle</span>
                            </h5>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-file-earmark-heart"></i>
                                    Certificat de Mariage
                                    <span class="optional-badge">Si marié(e)</span>
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="certificat_mariage" class="form-control @error('certificat_mariage') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <small class="text-muted">À fournir uniquement si vous êtes marié(e)</small>
                                @error('certificat_mariage')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-people"></i>
                                    Extraits de Naissance des Enfants
                                    <span class="optional-badge">Si applicable</span>
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="extraits_naissance_enfants[]" class="form-control @error('extraits_naissance_enfants.*') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" multiple>
                                </div>
                                <small class="text-muted">Vous pouvez sélectionner plusieurs fichiers (maintenir Ctrl/Cmd)</small>
                                @error('extraits_naissance_enfants.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <!-- Footer avec bouton -->
                            <div class="card-footer-custom">
                                <div class="d-grid">
                                    <button type="submit" class="btn-submit">
                                        <i class="bi bi-check-circle"></i>
                                        Soumettre ma Fiche
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-shield-check"></i>
                                        Vos données sont sécurisées et confidentielles
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>