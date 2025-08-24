@extends('layout.admin')
@section('title', 'Modifier entreprise')
@section('page-title', 'Configuration entreprise & informations')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">

            {{-- Header --}}
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">
                    <i class="ri-building-2-line text-primary me-2"></i>Configuration de l'entreprise
                </h2>
                <p class="text-muted">Mettez à jour les informations essentielles de votre entreprise.</p>
            </div>

            {{-- Affichage erreurs --}}
            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <h6 class="fw-bold mb-2">Veuillez corriger les erreurs suivantes :</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="step-form" action="{{ route('entreprise.update', $entreprise->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Step 1 --}}
                <div class="step step-active" id="step1">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="ri-image-add-line text-primary me-2"></i>Identité de votre entreprise
                    </h5>

                    {{-- Logo --}}
                    <div class="mb-4">
                        <label class="form-label">Logo de l'entreprise <span class="text-muted">(optionnel)</span></label>
                        @if ($entreprise->logo_path)
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $entreprise->logo_path) }}" class="rounded shadow-sm" alt="Logo actuel" style="height: 80px;">
                                <button type="button" class="btn btn-sm btn-outline-danger" id="remove-file">
                                    <i class="ri-close-line me-1"></i> Supprimer
                                </button>
                                <input type="hidden" name="remove_logo" id="remove_logo_input" value="0">
                            </div>
                        @endif
                        <input type="file" class="form-control mt-3" id="logo_path" name="logo_path" accept="image/*">
                    </div>

                    {{-- Nom entreprise --}}
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="entreprise_name" name="entreprise_name"
                               value="{{ old('entreprise_name', $entreprise->entreprise_name) }}"
                               placeholder="Nom de l'entreprise" required>
                        <label for="entreprise_name">Nom de l'entreprise</label>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="step d-none" id="step2">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="ri-map-pin-line text-primary me-2"></i>Informations de contact
                    </h5>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="adresse" name="adresse"
                               value="{{ old('adresse', $entreprise->adresse) }}"
                               placeholder="Adresse complète" required>
                        <label for="adresse">Adresse complète</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email', $entreprise->email) }}"
                               placeholder="Adresse email professionnelle" required>
                        <label for="email">Adresse email professionnelle</label>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="step d-none" id="step3">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="ri-file-list-3-line text-primary me-2"></i>Décrivez votre entreprise
                    </h5>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="description" name="description" style="height: 150px" required
                                  placeholder="Description de l'entreprise">{{ old('description', $entreprise->description) }}</textarea>
                        <label for="description">Description de l'entreprise</label>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="d-flex justify-content-between mt-5">
                    <button type="button" class="btn btn-outline-dark px-4" id="prevBtn">
                        <i class="ri-arrow-left-line me-2"></i>Précédent
                    </button>
                    <button type="button" class="btn btn-dark px-5" id="nextBtn">
                        Suivant <i class="ri-arrow-right-line ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
