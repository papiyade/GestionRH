@extends('layout.employe')

@section('title', 'Tableau de Bord')
@section('page-title', 'Répertoire statistique')

@section('content')
				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Tableau de Bord</h2>
						<nav>
							<ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									Tableau de bord
								</li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard employé</li>
							</ol>
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
						<div class="ms-2 head-icons">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Breadcrumb -->

                				<div class="row">
					<div class="col-xl-3 col-md-6">
						<div class="card position-relative">
							<div class="card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-md br-10 icon-rotate bg-primary flex-shrink-0">
										<span class="d-flex align-items-center"><i class="ti ti-delta text-white fs-16"></i></span>
									</div>
									<div class="ms-3">
										<p class="fw-medium text-truncate mb-1">Mes tâches</p>
										<h5>{{ $totalTasks }}</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card position-relative">
							<div class="card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-md br-10 icon-rotate bg-primary flex-shrink-0">
										<span class="d-flex align-items-center"><i class="ti ti-currency text-white fs-16"></i></span>
									</div>
									<div class="ms-3">
										<p class="fw-medium text-truncate mb-1">Tâches en cours</p>
										<h5>{{ $inProgressTasks }}</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card position-relative">
							<div class="card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-md br-10 icon-rotate bg-secondary flex-shrink-0">
										<span class="d-flex align-items-center"><i class="ti ti-stairs-up text-white fs-16"></i></span>
									</div>
									<div class="ms-3">
										<p class="fw-medium text-truncate mb-1">Tâches terminées</p>
										<h5>{{ $completedTasks }}</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6">
						<div class="card position-relative">
							<div class="card-body">
								<div class="d-flex align-items-center mb-3">
									<div class="avatar avatar-md br-10 icon-rotate bg-purple flex-shrink-0">
										<span class="d-flex align-items-center"><i class="ti ti-users-group text-white fs-16"></i></span>
									</div>
									<div class="ms-3">
										<p class="fw-medium text-truncate mb-1">Tâches récentes</p>
										<a href="{{ route('employe.projects') }}">Voir</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                <div class="row">
					<div class="col-xl-12 d-flex">
						<div class="card flex-fill">
							<div class="card-header">
								<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
									<h5>Tâches récentes</h5>
									<div>
										<a href="" class="btn btn-sm btn-light px-3">Tout voir</a>
									</div>
								</div>
							</div>
<div class="card-body schedule-timeline activity-timeline">
    @if($recentTasks->isEmpty())
        <div class="text-center py-10 text-gray-500 border border-dashed border-gray-300 rounded-xl">
            Aucune tâche récente pour le moment.
        </div>
    @else
        @foreach($recentTasks as $task)
            <div class="d-flex align-items-start mb-4">
                <!-- Icône / Avatar selon priorité -->
                <div class="avatar avatar-sm avatar-rounded flex-shrink-0
                    @if($task->priority === 'High') bg-danger
                    @elseif($task->priority === 'Medium') bg-warning
                    @else bg-success
                    @endif">
                    <i class="ti ti-list-details fs-15 text-white"></i>
                </div>

                <!-- Contenu de la tâche -->
                <div class="flex-fill ps-3 timeline-flow">
                    <p class="fw-medium text-gray-9 mb-1">
                        <a href="javascript:void(0);" class="text-dark">
                            {{ $task->title }}
                        </a>
                    </p>

                    <span class="text-gray-500 text-sm">
                        Projet : <span class="fw-medium text-dark">{{ $task->project->title ?? 'N/A' }}</span> |
                        Statut : <span class="fw-medium">
                            @if($task->status === 'completed') ✅ Terminée
                            @elseif($task->status === 'in progress') ⏳ En cours
                            @else  Non commencée
                            @endif
                        </span> |
                        Échéance : <span class="fw-medium">{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}</span>
                    </span>

                    <!-- Barre de progression -->
                    <div class="progress progress-sm mt-2" role="progressbar" aria-label="Progress" aria-valuenow="{{ $task->progress ?? 1 }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar
                            @if($task->status === 'completed') bg-success
                            @elseif($task->status === 'in progress') bg-warning
                            @else bg-gray-400
                            @endif"
                            style="width: {{ $task->progress ?? 1 }}%">
                        </div>
                    </div>
                    <span class="text-xs text-gray-500 mt-1 d-block">{{ $task->progress ?? 0 }}%</span>

                    <!-- Actions et méta -->
<div class="d-flex align-items-center justify-content-between mt-2">
    <div class="d-flex align-items-center">
        <!-- Commentaires -->
        <a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2">
            <i class="ti ti-message-circle text-gray me-1"></i> {{ $task->comments->count() }}
        </a>

        <!-- Fichiers -->
        <a href="javascript:void(0);" class="d-flex align-items-center text-dark">
            <i class="ti ti-paperclip text-gray me-1"></i> {{ $task->files->count() }}
        </a>
    </div>

    <!-- Dernière mise à jour -->
    @if($task->updated_at)
        <span class="text-xs text-gray-400">Màj : {{ $task->updated_at->diffForHumans() }}</span>
    @endif
</div>

                </div>
            </div>
        @endforeach
    @endif
</div>

						</div>
					</div>
				</div>


                <div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Toutes mes tâches</h5>
    </div>
    <div class="card-body">
        @if($tasks->isEmpty())
            <div class="text-center text-gray-500 py-5">
                Aucune tâche assignée pour le moment.
            </div>
        @else
            <div class="list-group">
                @foreach($tasks as $task)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $task->title }}</strong>
                            <span class="d-block text-muted small">
                                Projet : {{ $task->project->title ?? 'N/A' }} |
                                Statut : {{ ucwords($task->status) }} |
                                Échéance : {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                            </span>
                        </div>
                        <span class="badge 
                            @if($task->priority === 'High') bg-danger
                            @elseif($task->priority === 'Medium') bg-warning
                            @else bg-success
                            @endif
                        ">{{ $task->priority }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>


<div class="row">
    @forelse($tasks as $task)
        @php
            $priorityColors = [
                'High' => 'bg-danger text-white',
                'Medium' => 'bg-warning text-dark',
                'Low' => 'bg-success text-white',
            ];
            $statusColors = [
                'completed' => 'bg-success',
                'in progress' => 'bg-warning',
                'pending' => 'bg-secondary',
            ];
            $priorityClass = $priorityColors[$task->priority] ?? 'bg-light text-dark';
            $statusClass = $statusColors[$task->status] ?? 'bg-secondary';
            $progress = $task->progress ?? 1;
        @endphp

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h5 class="card-title mb-1">{{ $task->title }}</h5>
                            <small class="text-muted">Projet : <strong>{{ $task->project->title ?? 'N/A' }}</strong></small>
                        </div>
                        <div class="dropdown">
                            <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Éditer</a></li>
                                <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-2"></i>Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Badge priorité -->
                    <span class="badge {{ $priorityClass }} mb-2">{{ $task->priority }}</span>

                    <!-- Barre de progression -->
                    <div class="progress mb-2" style="height: 6px;">
                        <div class="progress-bar {{ $statusClass }}" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <!-- Échéance -->
                    <p class="mb-2"><small class="text-muted">Échéance : {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}</small></p>

                    <!-- Métadonnées messages / pièces jointes -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                        <div class="d-flex align-items-center text-muted small">
                            <a href="#" class="me-3 d-flex align-items-center"><i class="ti ti-message-circle me-1"></i>{{$task->comments->count()}} </a>
                            <a href="#" class="d-flex align-items-center"><i class="ti ti-paperclip me-1"></i> {{$task->files->count()}}</a>
                        </div>
                        @if($task->updated_at)
                            <small class="text-muted">Màj : {{ $task->updated_at->diffForHumans() }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 border border-dashed rounded">
            Aucune tâche pour le moment.
        </div>
    @endforelse

    <div class="mb-6">
    <h2 class="h5 mb-3">Projets rattachés</h2>

    @if($projects->isEmpty())
        <div class="text-center py-4 border border-dashed rounded">
            Aucun projet pour le moment.
        </div>
    @else
        <div class="row g-3">
            @foreach($projects as $project)
            <div class="col-md-4">
                <div class="card border shadow-sm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary">{{ $project->status ?? 'Actif' }}</span>
                        <small class="text-muted">{{ $project->created_at->format('d/m/Y') }}</small>
                    </div>
                    <h5 class="card-title">{{ $project->title }}</h5>
                    <p class="card-text text-truncate">{{ $project->description ?? '' }}</p>
                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary mt-2">Voir projet</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
</div>



@endsection
