@extends('layout.admin')
@section('title', 'Modifier entreprise')
@section('page-title', 'Configuration entreprise & informations')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">

            {{-- Header --}}
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">
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

            <form id="entrepriseForm" action="{{ route('entreprise.update', $entreprise->id) }}" method="POST" enctype="multipart/form-data" class="w-100">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- Logo upload --}}
                    <div class="col-md-12 mb-4">
                        <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3">
                            <div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                @if ($entreprise->logo_path)
                                    <img src="{{ asset('storage/' . $entreprise->logo_path) }}" alt="Logo actuel" class="rounded-circle" style="height: 80px; width: 80px; object-fit: cover;">
                                @else
                                    <i class="ti ti-photo text-gray-2 fs-16"></i>
                                @endif
                            </div>
<div class="profile-upload">
    <div class="mb-2">
        <h6 class="mb-1">Téléverser le logo de l’entreprise</h6>
        <p class="fs-12">L’image doit être inférieure à 4 Mo (formats acceptés : JPG, PNG, JPEG)</p>
    </div>

    <div class="profile-uploader d-flex align-items-center">
        <div class="drag-upload-btn btn btn-sm btn-primary me-2">
            Choisir une image
            <input type="file" class="form-control image-sign" name="logo_path" accept="image/*">
        </div>

        @if ($entreprise->logo_path)
            <button type="button" class="btn btn-outline-danger btn-sm" id="remove-file">
                Supprimer l’image actuelle
            </button>
            <input type="hidden" name="remove_logo" id="remove_logo_input" value="0">
        @else
            <a href="javascript:void(0);" class="btn btn-light btn-sm">Annuler</a>
        @endif
    </div>

    @if ($entreprise->logo_path)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $entreprise->logo_path) }}" alt="Logo actuel"
                 class="img-thumbnail" width="40">
        </div>
    @endif
</div>

                        </div>
                    </div>
                    {{-- Inputs group 1 --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="entreprise_name" value="{{ old('entreprise_name', $entreprise->entreprise_name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Adresse complète <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="adresse" value="{{ old('adresse', $entreprise->adresse) }}" required>
                        </div>
                    </div>
                    {{-- Inputs group 2 --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Adresse email professionnelle <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $entreprise->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Description de l'entreprise <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" style="height: 150px" required>{{ old('description', $entreprise->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5">Enregistrer</button>
                    </div>
                </div>
            </form>

            @push('scripts')
            <script>
                document.getElementById('remove-file')?.addEventListener('click', function() {
                    document.getElementById('remove_logo_input').value = '1';
                    this.closest('.avatar').querySelector('img').style.display = 'none';
                    this.style.display = 'none';
                });
            </script>
            @endpush
        </div>
    </div>
</div>
@endsection
