@extends('layout.employe')

@section('title', 'Projets')

@section('page-title', 'Mes projets')

@section('content')

				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Projets</h2>
						<nav>
							<ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									Employé
								</li>
								<li class="breadcrumb-item active" aria-current="page">Mes projets</li>
							</ol>
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
						<div class="mb-2">
							<a href="{{ route('employe.dashboard') }}"  class="btn btn-primary d-flex align-items-center"><i class="ti ti-arrow-left me-2"></i>Retour</a>
						</div>
						<div class="ms-2 head-icons">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Breadcrumb -->

                				<div class="card">
					<div class="card-body p-3">
						<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
							<h5>Mes projets</h5>
							<div class="d-flex align-items-center flex-wrap row-gap-3">
							</div>
						</div>
					</div>
				</div>

<div class="row">
    <!-- Colonnes Kanban -->
    @php
        $statuses = [
            'not_started' => 'Non débutés',
            'in_progress' => 'En cours',
            'completed' => 'Terminés',
        ];
    @endphp

    @foreach($statuses as $statusKey => $statusLabel)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-center text-primary">{{ $statusLabel }}</h6>
                </div>
                <div class="card-body p-3" style="min-height:400px;">
                    @forelse($projets->where('status', $statusKey) as $projet)
                        @php
                            $isLead = $projet->users()->where('user_id', Auth::id())->wherePivot('is_lead', true)->exists();
                            $totalTasks = $projet->tasks->count();
                            $completedTasks = $projet->tasks->where('status', 'completed')->count();
                            $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                            $projectUsers = $projet->users;
                        @endphp

                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">

                                <!-- Titre et menu -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0">
                                        <a href="{{ route('employe.projects.show', $projet) }}">
                                            {{ $projet->title }}
                                        </a>
                                    </h6>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end p-2">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#edit_project">
                                                    <i class="ti ti-edit me-2"></i>Modifier
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3 pb-3 border-bottom">
                                    <p class="text-truncate line-clamp-3 mb-0">
                                        {{ $projet->description ?? 'Aucune description disponible.' }}
                                    </p>
                                </div>

                                <!-- Leader et deadline -->
                                @php
                                    $leader = $projet->users->first();
                                    $initials = $leader ? collect(explode(' ', $leader->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('') : 'NA';
                                @endphp
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center file-name-icon">
                                        <span class="avatar avatar-md avatar-rounded flex-shrink-0 text-white fw-bold d-flex align-items-center justify-content-center me-2"
                                              style="background: linear-gradient(135deg, #FF8C00, #FFA500); width:40px; height:40px;">
                                            {{ $initials }}
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="fw-normal fs-12 mb-0">
                                                <a href="javascript:void(0);">{{ $leader->name ?? 'N/A' }}</a>
                                            </h6>
                                            <span class="fs-12 fw-normal">{{ $isLead ? 'Project Leader' : 'Member' }}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fs-12 fw-normal">Deadline</span>
                                        <p class="mb-0 fs-12">{{ \Carbon\Carbon::parse($projet->deadline ?? now())->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <!-- Progression -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm avatar-rounded bg-success-transparent flex-shrink-0 me-2">
                                            <i class="ti ti-checklist text-success fs-16"></i>
                                        </span>
                                        <p class="mb-0 fs-12">
                                            <small>Taches : </small>
                                            <span class="text-dark">{{ $completedTasks }}</span>/{{ $totalTasks }}
                                        </p>
                                    </div>

                                    <!-- Membres -->
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        @foreach($projectUsers->take(3) as $user)
                                            @php
                                                $userInitials = collect(explode(' ', $user->name))->map(fn($n) => strtoupper(substr($n,0,1)))->join('');
                                            @endphp
                                            <span class="avatar avatar-md avatar-rounded flex-shrink-0 text-white fw-bold d-flex align-items-center justify-content-center me-1"
                                                  style="background: linear-gradient(135deg, #FF8C00, #FFA500); width:30px; height:30px;">
                                                {{ $userInitials }}
                                            </span>
                                        @endforeach
                                        @if($projectUsers->count() > 3)
                                            <a class="avatar bg-primary avatar-rounded text-white fs-12 fw-medium" href="javascript:void(0);">
                                                +{{ $projectUsers->count() - 3 }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Aucun projet</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</div>



@endsection
