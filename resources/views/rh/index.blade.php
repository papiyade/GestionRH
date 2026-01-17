@extends('layout.admin_rh')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #821854ff 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(242, 101, 34, 0.2);
    }

    .page-header h2 {
        color: #fff;
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }

    .breadcrumb {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        margin: 10px 0 0 0;
    }

    .breadcrumb-item {
        color: rgba(255, 255, 255, 0.9);
    }

    .breadcrumb-item.active {
        color: white;
        font-weight: 500;
    }

    .breadcrumb-item a {
        color: white;
        text-decoration: none;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action.primary {
        background: white;
        color: #AE3D7D;
        border: 2px solid white;
    }

    .btn-action.primary:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .main-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }

    .main-card .card-body {
        padding: 24px;
    }

    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .datatable thead th {
        background: linear-gradient(90deg, #AE3D7D 0%, #ff8c52 100%);
        color: white;
        font-weight: 600;
        padding: 16px 12px;
        border: none;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .datatable tbody tr {
        transition: all 0.2s;
        border-bottom: 1px solid #f0f0f0;
    }

    .datatable tbody tr:hover {
        background: #fff5f0;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(242, 101, 34, 0.1);
    }

    .datatable tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        color: #2c3e50;
    }

    .employee-id {
        font-weight: 600;
        color: #AE3D7D;
        font-size: 0.9rem;
    }

    .employee-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .action-btn-group {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        border: 1px solid;
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        cursor: pointer;
        font-size: 16px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .action-btn.view {
        color: #007bff;
        border-color: #007bff;
    }

    .action-btn.view:hover {
        background: #007bff;
        color: white;
    }

    .action-btn.salary {
        color: #17a2b8;
        border-color: #17a2b8;
    }

    .action-btn.salary:hover {
        background: #17a2b8;
        color: white;
    }

    .action-btn.edit {
        color: #ffc107;
        border-color: #ffc107;
    }

    .action-btn.edit:hover {
        background: #ffc107;
        color: white;
    }

    .action-btn.bulletin {
        color: #28a745;
        border-color: #28a745;
    }

    .action-btn.bulletin:hover {
        background: #28a745;
        color: white;
    }

    .action-btn.delete {
        color: #dc3545;
        border-color: #dc3545;
    }

    .action-btn.delete:hover {
        background: #dc3545;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state p {
        color: #999;
        font-size: 1.1rem;
    }

    .badge-custom {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .action-buttons {
            justify-content: center;
        }

        .page-header {
            text-align: center;
        }

        .action-btn-group {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container-fluid py-4">
    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h2><i class="bi bi-people-fill me-2 text-white"></i>Liste des Employés</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('rh.index') }}"><i class="bi bi-house-door"></i> Accueil</a>
                        </li>
                        <li class="breadcrumb-item">RH</li>
                        <li class="breadcrumb-item active text-white">Liste des Employés</li>
                    </ol>
                </nav>
            </div>
            <div class="action-buttons">
                <button class="btn-action primary" id="copyFormLink">
                    <i class="ti ti-link"></i>
                    Copier le lien RH
                </button>
                <a href="{{ route('rh.export.personnel.registry') }}" class="btn-action primary">
                    <i class="ti ti-file-type-xls"></i>
                    Exporter Excel
                </a>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="main-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th style="width: 100px;">#</th>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Poste</th>
                            <th style="width: 120px;">Date</th>
                            <th class="text-center" style="width: 220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>
                                    <span class="employee-id">EMP{{ str_pad($employee->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <span class="employee-name">{{ $employee->nom_complet }}</span>
                                </td>
                                <td>
                                    <i class="bi bi-envelope me-1 text-muted"></i>{{ $employee->email }}
                                </td>
                                <td>
                                    <i class="bi bi-telephone me-1 text-muted"></i>{{ $employee->telephone }}
                                </td>
                                <td>
                                    <span class="badge-custom" style="background: #ece5e9ff; color: #AE3D7D;">
                                        {{ $employee->fiche_poste }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar3 me-1 text-muted"></i>{{ $employee->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="action-btn-group">
                                        <a href="{{ route('rh.show', $employee->id) }}" 
                                           class="action-btn view" 
                                           title="Voir détails">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('rh.salaire.edit', $employee) }}" 
                                           class="action-btn salary" 
                                           title="Gérer salaire">
                                            <i class="ti ti-cash"></i>
                                        </a>
                                        <a href="{{ route('rh.edit', $employee) }}" 
                                           class="action-btn edit" 
                                           title="Modifier">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="{{ route('rh.bulletin.generate', $employee) }}" 
                                           class="action-btn bulletin" 
                                           title="Bulletin de paie">
                                            <i class="ti ti-file-dollar"></i>
                                        </a>
                                        <form action="{{ route('rh.destroy', $employee) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-btn delete" 
                                                    title="Supprimer">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Aucune fiche employé trouvée</p>
                                        <small class="text-muted">Les employés ajoutés apparaîtront ici</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyBtn = document.getElementById('copyFormLink');

        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const entrepriseId = {{ auth()->user()->entreprise_id }};
                const baseUrl = "{{ url('/employees/renseignement-infos') }}";
                const fullLink = `${baseUrl}/${entrepriseId}`;

                navigator.clipboard.writeText(fullLink).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Lien copié !',
                        text: 'Le lien du formulaire RH a été copié dans le presse-papiers.',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }).catch(err => {
                    console.error('Erreur de copie :', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Impossible de copier le lien, veuillez réessayer.',
                        timer: 2000
                    });
                });
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection