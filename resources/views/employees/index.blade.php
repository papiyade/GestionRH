@extends('layout.admin_rh')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Fiches Employs</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                            <td>{{ $employee->id }}</td>
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
                                    <a href="{{ route('rh.show', $employee) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('rh.salaire.edit', $employee) }}" class="btn btn-primary" title="Salaire">
                                        <i class="fas fa-money-bill"></i>
                                    </a>
                                    <a href="{{ route('rh.edit', $employee) }}" class="btn btn-warning" title="Éditer">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('rh.bulletin.generate', $employee) }}" class="btn btn-success" title="Bulletin">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <form action="{{ route('rh.destroy', $employee) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
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
@endsection