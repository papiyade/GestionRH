@extends('layout.admin')
@section('title', 'Tableau de bord administrateur')
@section('page-title', 'Tableau de bord')

@section('content')

				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Projets</h2>
						<nav>
							<ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									Admin
								</li>
								<li class="breadcrumb-item active" aria-current="page">Liste des projets</li>
							</ol>
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
						<div class="ms-2 mb-0 head-icons">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>

                				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
						<h4>Projets</h4>
						<div class="d-flex align-items-center flex-wrap row-gap-3">
							<div class="avatar-list-stacked avatar-group-sm me-3">
@php
    $maxAvatars = 3;
    $totalUsers = $userTeams->count();
@endphp

<div class="d-flex align-items-center">
    @foreach ($userTeams->take($maxAvatars) as $user)
        @php
            // Extraire les initiales (première lettre de chaque mot du nom)
            $initials = collect(explode(' ', $user->name))
                        ->map(fn($word) => strtoupper(Str::substr($word, 0, 1)))
                        ->join('');
        @endphp

        @if (!empty($user->profile_photo_url))
            <span class="avatar avatar-rounded me-1">
                <img class="border border-white"
                     src="{{ $user->profile_photo_url }}"
                     alt="{{ $user->name }}">
            </span>
        @else
            <span class="avatar avatar-rounded bg-light text-dark fw-medium me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px">
                {{ $initials }}
            </span>
        @endif
    @endforeach

    {{-- Si plus de 3 utilisateurs, afficher le badge +N --}}
    @if ($totalUsers > $maxAvatars)
        <span class="avatar avatar-rounded bg-primary text-white fw-bold fs-12 d-flex align-items-center justify-content-center">
            +{{ $totalUsers - $maxAvatars }}
        </span>
    @endif
</div>

</div>



							</div>
							<div class="d-flex align-items-center me-3">
								<p class="mb-0 me-3 pe-3 border-end fs-14">Total projets : <span class="text-dark"> {{ $projectCount }} </span></p>
								<p class="mb-0 me-3 pe-3 border-end fs-14">Non débuté : <span class="text-dark"> {{$projectNotStartedCount}} </span></p>
								<p class="mb-0 me-3 pe-3 border-end fs-14">En cours : <span class="text-dark"> {{$projectEnCoursCount}} </span></p>
								<p class="mb-0 fs-14">Complétées : <span class="text-dark"> {{ $projectCompleteCount }} </span></p>
							</div>
							<div class="input-icon-start position-relative">
								<span class="input-icon-addon">
									<i class="ti ti-search"></i>
								</span>
								<input type="text" class="form-control" placeholder="Rechercher un Projet">
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel">
								<div class="d-flex align-items-start overflow-auto project-status pb-4">
									{{-- Projets Non débutés --}}
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-pink p-1 d-flex rounded-circle me-2"><span class="bg-pink rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Non débuté</h5>
													<span class="badge bg-light rounded-pill">{{$projectNotStartedCount}}</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											@foreach($projectNotStarted as $project)
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-danger badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Non débuté</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">{{$project->title}} <span class="fs-12 ms-2 text-gray">PRJ-{{$project->id}}</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Taches</span>
																@if($project->tasks->isNotEmpty())
																<p class="fs-12 text-dark">{{$project->completedTasks/2}}</p>
																@else
																<p class="fs-5 text-center">Aucune Tache pour le moment</p>
																@endif
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Créé le</span>
																<p class="fs-12 text-dark">{{$project->created_at->format(' d/M/Y')}}</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											@endforeach
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												Nouveau projet
											</a>
										</div>
									</div>
									{{-- Projets en Cours --}}
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-skyblue p-1 d-flex rounded-circle me-2"><span class="bg-skyblue rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">En cours</h5>
													<span class="badge bg-light rounded-pill">{{ $projectEnCoursCount }}</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											@forelse($projectEnCours as $project)
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-purple badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-156</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											@empty
											<p class="text-center mt-4">Aucun projet en cours</p>
											@endforelse
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												Nouveau Projet
											</a>
										</div>
									</div>
									{{-- Projets Terminés --}}
									<div class="p-3 rounded bg-transparent-secondary w-100">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-success p-1 d-flex rounded-circle me-2"><span class="bg-success rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Terminé</h5>
													<span class="badge bg-light rounded-pill">{{$projectCompleteCount}}</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
                                            @forelse ($projectComplete as $project)
                                            <div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-161</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
                                            @empty
                                                Aucun projet terminé
                                            @endforelse

										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												Nouveau Projet
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-contact" role="tabpanel">
								<div class="d-flex align-items-start overflow-auto project-status pb-4">
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-pink p-1 d-flex rounded-circle me-2"><span class="bg-pink rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">New</h5>
													<span class="badge bg-light rounded-pill">02</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-skyblue p-1 d-flex rounded-circle me-2"><span class="bg-skyblue rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Inprogress</h5>
													<span class="badge bg-light rounded-pill">13</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-purple badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-156</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-purple badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-157</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-danger p-1 d-flex rounded-circle me-2"><span class="bg-danger rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">On-hold</h5>
													<span class="badge bg-light rounded-pill">04</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-purple badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-159</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-success p-1 d-flex rounded-circle me-2"><span class="bg-success rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Completed</h5>
													<span class="badge bg-light rounded-pill">10</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-purple badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-161</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-medium" role="tabpanel">
								<div class="d-flex align-items-start overflow-auto project-status pb-4">
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-pink p-1 d-flex rounded-circle me-2"><span class="bg-pink rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">New</h5>
													<span class="badge bg-light rounded-pill">02</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-154</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-155</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-skyblue p-1 d-flex rounded-circle me-2"><span class="bg-skyblue rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Inprogress</h5>
													<span class="badge bg-light rounded-pill">13</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-156</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-157</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-danger p-1 d-flex rounded-circle me-2"><span class="bg-danger rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">On-hold</h5>
													<span class="badge bg-light rounded-pill">04</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-159</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-success p-1 d-flex rounded-circle me-2"><span class="bg-success rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Completed</h5>
													<span class="badge bg-light rounded-pill">10</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-warning badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-161</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-low" role="tabpanel">
								<div class="d-flex align-items-start overflow-auto project-status pb-4">
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-pink p-1 d-flex rounded-circle me-2"><span class="bg-pink rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">New</h5>
													<span class="badge bg-light rounded-pill">02</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-success badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-154</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-success badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-155</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-skyblue p-1 d-flex rounded-circle me-2"><span class="bg-skyblue rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Inprogress</h5>
													<span class="badge bg-light rounded-pill">13</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-success badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-156</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-success badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-157</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100 me-3">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-danger p-1 d-flex rounded-circle me-2"><span class="bg-danger rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">On-hold</h5>
													<span class="badge bg-light rounded-pill">04</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-success badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-159</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
									<div class="p-3 rounded bg-transparent-secondary w-100">
										<div class="bg-white p-2 rounded mb-2">
											<div class="d-flex align-items-center justify-content-between">
												<div class="d-flex align-items-center">
													<span class="bg-soft-success p-1 d-flex rounded-circle me-2"><span class="bg-success rounded-circle d-block p-1"></span></span>
													<h5 class="me-2">Completed</h5>
													<span class="badge bg-light rounded-pill">10</span>
												</div>
												<div class="dropdown">
													<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
														<i class="ti ti-dots-vertical"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-end p-3">
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="kanban-drag-wrap">
											<div>
												<div class="card kanban-card mb-2">
													<div class="card-body">
														<div class="d-flex align-items-center justify-content-between mb-3">
															<div class="d-flex align-items-center">
																<span class="badge bg-outline-dark me-2">Web Layout</span>
																<span class="badge bg-success badge-xs d-flex align-items-center justify-content-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>
															</div>
															<div class="dropdown">
																<a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown">
																	<i class="ti ti-dots-vertical"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-end p-3">
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);" class="dropdown-item rounded-1" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="d-flex align-items-center mb-2">
															<span class="avatar avatar-xs rounded-circle bg-warning me-2">
																<img src="https://smarthr.co.in/demo/html/template/assets/img/icons/kanban-arrow.svg" class="w-auto h-auto" alt="Img">
															</span>
															<h6 class="d-flex align-items-center">Project Title <span class="fs-12 ms-2 text-gray">PRJ-161</span></h6>
														</div>
														<div class="d-flex align-items-center border-bottom mb-3 pb-3">
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Budget</span>
																<p class="fs-12 text-dark">$24,000</p>
															</div>
															<div class="me-3 pe-3 border-end">
																<span class="fw-medium fs-12 d-block mb-1">Tasks</span>
																<p class="fs-12 text-dark">12/15</p>
															</div>
															<div class="">
																<span class="fw-medium fs-12 d-block mb-1">Due on</span>
																<p class="fs-12 text-dark">15 Apr 2024</p>
															</div>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<div class="avatar-list-stacked avatar-group-sm me-3">
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-19.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-29.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-16.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-01.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-02.jpg" alt="img">
																</span>
																<span class="avatar avatar-rounded">
																	<img class="border border-white" src="https://smarthr.co.in/demo/html/template/assets/img/profiles/avatar-03.jpg" alt="img">
																</span>
																<a href="#" class="avatar avatar-rounded bg-primary fs-12 text-white">
																	1+
																</a>
															</div>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark me-2"><i class="ti ti-message-circle text-gray me-1"></i>14</a>
																<a href="javascript:void(0);" class="d-flex align-items-center text-dark"><i class="ti ti-paperclip text-gray me-1"></i>14</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="pt-2">
											<a href="#" class="btn btn-white border border-dashed d-flex align-items-center justify-content-center">
												<i class="ti ti-plus me-2"></i>
												New Project
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

@endsection
