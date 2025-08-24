@extends('layout.admin')
@section('title', 'Tableau de bord administrateur')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="container my-5">

    {{-- Section des statistiques --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card bg-secondary text-light border-0 rounded-4 shadow-sm p-4 text-center">
                <i class="ri-projector-line fs-2 mb-3"></i>
                <h3 class="fw-bold mb-1">{{ $projectCount }}</h3>
                <p class="text-muted">Projets</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-secondary text-light border-0 rounded-4 shadow-sm p-4 text-center">
                <i class="ri-group-line fs-2 mb-3"></i>
                <h3 class="fw-bold mb-1">{{ $teamCount }}</h3>
                <p class="text-muted">Équipes</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-secondary text-light border-0 rounded-4 shadow-sm p-4 text-center">
                <i class="ri-user-line fs-2 mb-3"></i>
                <h3 class="fw-bold mb-1">{{ $userCount }}</h3>
                <p class="text-muted">Utilisateurs</p>
            </div>
        </div>
    </div>

    {{-- Section des projets --}}
    <div class="card bg-dark text-light border-0 rounded-4 shadow-lg">
        <div class="card-header bg-dark border-bottom-0 rounded-top-4 p-4">
            <h4 class="fw-bold mb-0">
                <i class="ri-list-check text-info me-2"></i>Liste des projets
            </h4>
        </div>
        
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-light">
                    <thead>
                        <tr class="text-muted small">
                            <th scope="col">Nom du projet</th>
                            <th scope="col">Progression</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr class="border-bottom border-secondary">
                                <td>
                                    <h6 class="fw-bold mb-0">{{ $project->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                </td>
                                <td>
                                    <div class="progress bg-secondary" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">{{ $project->progress }}% terminé</small>
                                </td>
                                <td>
                                    @if($project->leadUser)
                                        <span>{{ $project->leadUser->name }}</span>
                                    @else
                                        <span class="text-muted">Aucun responsable</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $project->status == 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($project->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="ri-inbox-line ri-2x mb-3"></i>
                                    Aucun projet n'a encore été créé dans votre entreprise.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
