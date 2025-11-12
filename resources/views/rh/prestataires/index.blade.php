@extends('layout.admin_rh')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Prestataires</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        {{-- <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a> --}}
                    </li>
                    <li class="breadcrumb-item">RH</li>
                    <li class="breadcrumb-item active" aria-current="page">Prestataires</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
            {{-- <div class="mb-2 me-2">
                <a href="{{ route('rh.prestataires.prestations-mensuelles') }}" class="btn btn-info d-flex align-items-center">
                    <i class="ti ti-calendar-stats me-2"></i>Prestations Mensuelles
                </a>
            </div> --}}
            <div class="mb-2">
    <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center mb-3" data-bs-toggle="modal" data-bs-target="#addPrestataireModal">
        <i class="ti ti-circle-plus me-2"></i>Nouveau Prestataire
    </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Prestataires</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_prestataires'] }}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-3">
                            <i class="ti ti-users fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Prestations Ce Mois</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_prestations_mois'] }}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-3">
                            <i class="ti ti-file-invoice fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Montant Total Ce Mois</p>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['montant_total_mois'], 0, ',', ' ') }} FCFA</h3>
                        </div>
                        <div class="avatar avatar-lg bg-warning bg-opacity-10 rounded-3">
                            <i class="ti ti-cash fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <div class="mb-2 d-flex justify-content-end">
                <a href="{{ route('rh.prestataires.prestations') }}" class="btn btn-secondary d-flex align-items-center text-left btn-left">
                    <i class="ti ti-clipboard-data me-2"></i>Aller à la page des prestations
                </a>
            </div>

    <!-- Liste des Prestataires -->
    <div class="card border-0 shadow-sm mt-2">


        <div class="card-body p-0">
            <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="ti ti-list me-2"></i>Liste des Prestataires</h5>
                <div class="d-flex gap-2">
                    <input type="text" id="searchPrestataire" class="form-control form-control-sm" placeholder="Rechercher..." style="width: 200px;">
                    <select id="filterType" class="form-select form-select-sm" style="width: 150px;">
                        <option value="">Tous les contrats</option>
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Stage">Stage</option>
                    </select>
                </div>
            </div>
        </div>
            <div class="table-responsive">
                @if ($prestataires)
                    <table class="table table-hover  mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Prestataire</th>
                            <th>Contact</th>
                            <th>Type de Contrat</th>
                            <th>Prestations</th>
                            {{-- <th class="text-center">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestataires as $prestataire)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-primary text-white me-2">
                                            <span>{{ strtoupper(substr($prestataire->prenom, 0, 1)) }}{{ strtoupper(substr($prestataire->nom, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $prestataire->prenom }} {{ $prestataire->nom }}</h6>
                                            <small class="text-muted">Ajouté le {{ $prestataire->created_at->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($prestataire->email)
                                            <small class="d-block"><i class="ti ti-mail me-1"></i>{{ $prestataire->email }}</small>
                                        @endif
                                        @if($prestataire->telephone)
                                            <small class="d-block"><i class="ti ti-phone me-1"></i>{{ $prestataire->telephone }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info-transparent text-info">
                                        {{ $prestataire->type_contrat }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $prestataire->prestations_count }} prestation(s)</span>
                                </td>
                                {{-- <td> --}}
                                    {{-- <div class="d-flex justify-content-center gap-2"> --}}
                                        {{-- <a href="{{ route('rh.prestataires.show', $prestataire) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="ti ti-eye"></i>
                                        </a> --}}
                                        {{-- <a href="{{ route('rh.prestataires.prestations.create', $prestataire) }}" class="btn btn-sm btn-success" title="Ajouter prestation">
                                            <i class="ti ti-plus"></i>
                                        </a> --}}
                                        {{-- <a href="{{ route('rh.prestataires.edit', $prestataire) }}" class="btn btn-sm btn-warning" title="Éditer">
                                            <i class="ti ti-edit"></i>
                                        </a> --}}
                                        {{-- <form action="{{ route('rh.prestataires.destroy', $prestataire) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce prestataire ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form> --}}
                                    {{-- </div> --}}
                                {{-- </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="ti ti-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                    <p class="text-muted mt-3">Aucun prestataire trouvé</p>
                                    <a href="{{ route('rh.prestataires.create') }}" class="btn btn-primary btn-sm">
                                        <i class="ti ti-plus"></i> Ajouter le premier prestataire
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @else
        <div class="alert alert-info m-4">
    Aucun prestataire trouvé.
</div>

                @endif

            </div>
        </div>

        {{-- @if($prestataires->hasPages())
            <div class="card-footer bg-light">
                {{ $prestataires->links() }}
            </div>
        @endif --}}
    </div>

    <div class="modal fade" id="addPrestataireModal" tabindex="-1" aria-labelledby="addPrestataireModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" id="addPrestataireModalLabel">Ajouter un prestataire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rh.prestataires.store') }}" method="POST" enctype="multipart/form-data">
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
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Recherche en temps réel
    document.getElementById('searchPrestataire').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Filtre par type de contrat
    document.getElementById('filterType').addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (!filterValue) {
                row.style.display = '';
            } else {
                const typeCell = row.cells[2]?.textContent.toLowerCase();
                row.style.display = typeCell && typeCell.includes(filterValue) ? '' : 'none';
            }
        });
    });
</script>
@endsection