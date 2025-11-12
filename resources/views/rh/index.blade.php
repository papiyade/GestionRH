@extends('layout.admin_rh')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
        <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Liste des employés</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        RH
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Liste des employés</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
            {{-- <div class="me-2 mb-2">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="ti ti-file-export me-1"></i>Exporter
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end p-3">
                        <li>
                            <a href="{{ route('rh.export.personnel.registry') }}" class="dropdown-item rounded-1"><i
                                    class="ti ti-file-type-xls me-1"></i>Exporter vers Excel </a>
                        </li>
                    </ul>
                </div>
            </div> --}}
            <button class="btn btn-primary btn-md me-2" id="copyFormLink">
    <i class="ti ti-link"></i> Copier le lien du formulaire RH
</button>
            <div class="mb-2">
                <a href="{{ route('rh.export.personnel.registry') }}"
                    class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Exporter</a>
            </div>
            <div class="head-icons ms-2">
                <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Collapse" id="collapse-header">
                    <i class="ti ti-chevrons-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datatable table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Poste</th>
                            <th>Salaire</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td>Emp00{{ $employee->id }}</td>
                            <td>{{ $employee->nom_complet }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->telephone }}</td>
                            <td>{{ $employee->fiche_poste }}</td>
                            <td>
                                @if($employee->salaire)
                                    <span class="badge bg-success">{{ number_format($employee->salaire->salaire_net, 0, ',', ' ') }} FCFA</span>
                                @else
                                    <span class="badge bg-warning">Non défini</span>
                                @endif
                            </td>
                            <td>
                                @if($employee->statut === 'validé')
                                    <span class="badge bg-success">Validé</span>
                                @elseif($employee->statut === 'rejeté')
                                    <span class="badge bg-danger">Rejeté</span>
                                @else
                                    <span class="badge bg-warning">En attente</span>
                                @endif
                            </td>
                            <td>{{ $employee->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('rh.show', $employee->id) }}" class="btn btn-outline-primary" title="Voir">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('rh.salaire.edit', $employee) }}" class="btn btn-outline-info" title="Salaire">
                                        <i class="ti ti-currency-dollar"></i>
                                    </a>
                                    <a href="{{ route('rh.edit', $employee) }}" class="btn btn-outline-warning" title="Éditer">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="{{ route('rh.bulletin.generate', $employee) }}" class="btn btn-outline-success" title="Bulletin">
                                        <i class="ti ti-file-text"></i>
                                    </a>
                                    <form action="{{ route('rh.destroy', $employee) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-muted">Aucune fiche employé trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyBtn = document.getElementById('copyFormLink');

        copyBtn.addEventListener('click', function () {
            const entrepriseId = {{ auth()->user()->entreprise_id }};
            const baseUrl = "{{ url('/employees/renseignement-infos') }}";
            const fullLink = `${baseUrl}/${entrepriseId}`;

            // Copie dans le presse-papiers
            navigator.clipboard.writeText(fullLink).then(() => {
                // Optionnel : petit message de succès
                Swal.fire({
                    icon: 'success',
                    title: 'Lien copié !',
                    text: 'Le lien du formulaire RH a été copié dans le presse-papiers.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }).catch(err => {
                console.error('Erreur de copie :', err);
                alert('Impossible de copier le lien, veuillez réessayer.');
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection