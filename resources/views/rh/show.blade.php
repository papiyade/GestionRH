@extends('layout.admin_rh')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Fiche Employé - {{ $employee->nom_complet }}</h2>
        <a href="{{ route('rh.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations Personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Prénom:</strong>
                            <p>{{ $employee->prenom }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Nom:</strong>
                            <p>{{ $employee->nom }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Date de Naissance:</strong>
                            <p>{{ $employee->date_naissance->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Lieu de Naissance:</strong>
                            <p>{{ $employee->lieu_naissance }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Adresse:</strong>
                        <p>{{ $employee->adresse }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Résidence Actuelle:</strong>
                        <p>{{ $employee->residence_actuelle }}</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Téléphone:</strong>
                            <p>{{ $employee->telephone }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p>{{ $employee->email }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Fiche de Poste:</strong>
                        <p>{{ $employee->fiche_poste }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Statut:</strong>
                        @if($employee->statut === 'validé')
                            <span class="badge bg-success">Validé</span>
                        @elseif($employee->statut === 'rejeté')
                            <span class="badge bg-danger">Rejeté</span>
                        @else
                            <span class="badge bg-warning">En attente</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Documents</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($employee->photocopie_identite)
                        <div class="col-md-6 mb-3">
                            <strong>Photocopie Identité/Passeport:</strong><br>
<a href="{{ asset( $employee->photocopie_identite) }}" target="_blank" class="btn btn-sm btn-outline-primary">
    <i class="fas fa-download"></i> Télécharger
</a>

                        </div>
                        @endif

                        @if($employee->extrait_naissance)
                        <div class="col-md-6 mb-3">
                            <strong>Extrait de Naissance:</strong><br>
                            <a href="{{ asset( $employee->extrait_naissance) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->certificat_residence)
                        <div class="col-md-6 mb-3">
                            <strong>Certificat de Résidence:</strong><br>
                            <a href="{{ asset( $employee->certificat_residence) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->fiche_dotation_materiels)
                        <div class="col-md-6 mb-3">
                            <strong>Fiche de Dotation:</strong><br>
                            <a href="{{ asset( $employee->fiche_dotation_materiels) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->certificat_mariage)
                        <div class="col-md-6 mb-3">
                            <strong>Certificat de Mariage:</strong><br>
                            <a href="{{ asset('public/' . $employee->certificat_mariage) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        {{-- @if($employee->extraits_naissance_enfants)
                        <div class="col-md-12 mb-3">
                            <strong>Extraits de Naissance des Enfants:</strong><br>
                            @foreach($employee->extraits_naissance_enfants as $index => $doc)
                                <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2 mb-2">
                                    <i class="fas fa-download"></i> Enfant {{ $index + 1 }}
                                </a>
                            @endforeach
                        </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations Salaire</h5>
                </div>
                <div class="card-body">
                    @if($employee->salaire)
                        <div class="mb-3">
                            <strong>Salaire de Base:</strong>
                            <p class="h5 ">{{ number_format($employee->salaire->salaire_base, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="mb-3">
                            <strong>Prime:</strong>
                            <p>{{ number_format($employee->salaire->prime, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="mb-3">
                            <strong>Déductions:</strong>
                            <p>{{ number_format($employee->salaire->deductions, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <strong>Salaire Net:</strong>
                            <p class="h4 text-primary">{{ number_format($employee->salaire->salaire_net, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="mb-3">
                            <strong>Date d'Effet:</strong>
                            <p>{{ $employee->salaire->date_effet->format('d/m/Y') }}</p>
                        </div>
                    @else
                        <p class="text-muted">Aucun salaire défini</p>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(90deg, #dad1bc 60%, #eba66e 100%);">
                    <h5 class="mb-0 text-black">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('rh.edit', $employee) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Modifier la Fiche
                        </a>
                        <a href="{{ route('rh.salaire.edit', $employee) }}" class="btn btn-primary">
                            <i class="fas fa-money-bill"></i> {{ $employee->salaire ? 'Modifier' : 'Définir' }} le Salaire
                        </a>
                        <a href="{{ route('rh.fiche.generate', $employee) }}" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Télécharger Fiche PDF
                        </a>
                            <a href="{{ route('rh.fiche.preview', $employee) }}" class="btn btn-success">
        <i class="bi bi-file-earmark-text"></i> Prévisualiser la Fiche de Paie
    </a>
                        {{-- @if($employee->salaire)
                        <a href="{{ route('rh.bulletin.generate', $employee) }}" class="btn btn-success">
                            <i class="fas fa-file-invoice"></i> Bulletin de Salaire
                        </a>
                        @endif --}}
                        <form action="{{ route('rh.destroy', $employee) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
