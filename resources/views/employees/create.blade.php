<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: rgb(209, 86, 9);">
                        <h3 class="mb-0 text-center">Fiche d'Inscription Employé</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('rh.employees.store', ['id' => $entreprise->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-3" style="color: rgb(209, 86, 9)">Informations Personnelles</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prénom *</label>
                                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                                    @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom *</label>
                                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de Naissance *</label>
                                    <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lieu de Naissance *</label>
                                    <input type="text" name="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror" value="{{ old('lieu_naissance') }}" required>
                                    @error('lieu_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Adresse *</label>
                                <textarea name="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="2" required>{{ old('adresse') }}</textarea>
                                @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Résidence Actuelle *</label>
                                <input type="text" name="residence_actuelle" class="form-control @error('residence_actuelle') is-invalid @enderror" value="{{ old('residence_actuelle') }}" required>
                                @error('residence_actuelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Téléphone *</label>
                                    <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" required>
                                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fiche de Poste *</label>
                                <input type="text" name="fiche_poste" class="form-control @error('fiche_poste') is-invalid @enderror" value="{{ old('fiche_poste') }}" placeholder="Ex: Développeur, Comptable, etc." required>
                                @error('fiche_poste')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <h5 class="mb-3 mt-4" style="color: rgb(209, 86, 9)">Documents Requis</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Photocopie Identité/Passeport * (PDF ou Image)</label>
                                    <input type="file" name="photocopie_identite" class="form-control @error('photocopie_identite') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                    @error('photocopie_identite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Extrait de Naissance * (PDF ou Image)</label>
                                    <input type="file" name="extrait_naissance" class="form-control @error('extrait_naissance') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                    @error('extrait_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Certificat de Résidence (PDF ou Image)</label>
                                    <input type="file" name="certificat_residence" class="form-control @error('certificat_residence') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('certificat_residence')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fiche de Dotation de Matériels (Si applicable)</label>
                                    <input type="file" name="fiche_dotation_materiels" class="form-control @error('fiche_dotation_materiels') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('fiche_dotation_materiels')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <h5 class="mb-3 mt-4 " style="color: rgb(209, 86, 9)">Situation Familiale (Optionnel)</h5>

                            <div class="mb-3">
                                <label class="form-label">Certificat de Mariage (Si marié)</label>
                                <input type="file" name="certificat_mariage" class="form-control @error('certificat_mariage') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                @error('certificat_mariage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Extraits de Naissance des Enfants (Si vous avez des enfants)</label>
                                <input type="file" name="extraits_naissance_enfants[]" class="form-control @error('extraits_naissance_enfants.*') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" multiple>
                                <small class="text-muted">Vous pouvez sélectionner plusieurs fichiers</small>
                                @error('extraits_naissance_enfants.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-lg text-white" style="background: rgb(209, 86, 9)">Soumettre ma Fiche</button>
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
