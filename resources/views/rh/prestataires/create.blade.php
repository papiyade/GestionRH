@extends('layout.admin_rh')

@section('content')
<div class="d-flex justify-content-center mt-1">
    <div class="w-100" style="max-width: 600px;">
        <h3 class="text-center mb-4">Ajouter un prestataire</h3>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('rh.prestataires.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type de contrat</label>
                        <input type="text" name="type_contrat" class="form-control">
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="reset" class="btn btn-outline-secondary me-2">Annuler</button>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
