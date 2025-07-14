@extends('layouts.chef_projet')

@section('content')
    {{-- <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->

        <!-- Tasks Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                <!-- Teams Count Box -->
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md flex items-center">
                    <div class="mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-3-3h-4a3 3 0 00-3 3v2h5zM9 20H4v-2a3 3 0 013-3h4a3 3 0 013 3v2H9zM16 11a4 4 0 11-8 0 4 4 0 018 0zM12 7a4 4 0 100-8 4 4 0 000 8z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ Auth::user()->teams->count() }}</div>
                        <div class="text-sm">Team(s) associé(s)</div>
                    </div>
                </div>

                <!-- Projects Count Box -->
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md flex items-center">
                    <div class="mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18M3 12h18M3 17h18"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">0</div>
                        <div class="text-sm">Projects associés</div>
                    </div>
                </div>

                <!-- Tasks Count Box -->
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md flex items-center">
                    <div class="mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ Auth::user()->tasks->count() }}</div>
                        <div class="text-sm">Tâches assignées</div>
                    </div>
                </div>
            </div>



        </div>
    </div> --}}

    <!-- Recent Activities Section -->
    {{-- <div class="mt-8">
        <h2 class="text-2xl font-bold ml-4">Activités récentes</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <ul>
                @if(Auth::user()->activities && Auth::user()->activities->isNotEmpty())
                    @foreach(Auth::user()->activities as $activity)
                        <li class="border-b border-gray-200 p-4 hover:bg-gray-100 transition duration-300">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">{{ $activity->description }}</div>
                                    <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="border-b border-gray-200 p-4">
                        <div class="text-sm text-gray-500">Aucune activité récente</div>
                    </li>
                @endif
            </ul>
        </div>
    </div> --}}

    <!-- Notifications Section -->
    {{-- <div class="mt-8">
        <h2 class="text-2xl font-bold ml-4">Notifications</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <ul>
                @if(Auth::user()->notifications && Auth::user()->notifications->isNotEmpty())
                    @foreach(Auth::user()->notifications as $notification)
                        <li class="border-b border-gray-200 p-4 hover:bg-gray-100 transition duration-300">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 18.5a1.5 1.5 0 001.5-1.5h-3a1.5 1.5 0 001.5 1.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">{{ $notification->data['message'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="border-b border-gray-200 p-4">
                        <div class="text-sm text-gray-500">Aucune nouvelle notification</div>
                    </li>
                @endif
            </ul>
        </div>
    </div> --}}
    <div class="col">

        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Salut, {{ Auth::user()->name }}!</h4>
                            <p class="text-muted mb-0">Observez l'évolution de vos projets et de vos
                                tâches à faire dès maintenant !</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <form action="javascript:void(0);">
                                <div class="row g-3 mb-0 align-items-center">
                                    <div class="col-sm-auto">
                                        <div class="input-group">
                                            <input type="date" value="{{ now()->format('Y-m-d') }}" class="form-control border-0 minimal-border dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y">
                                            <div class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-2-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-soft-success material-shadow-none"><i class="ri-add-circle-line align-middle me-1"></i> Add Product</button>
                                    </div>
                                    <!--end col-->
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-soft-info btn-icon waves-effect material-shadow-none waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                    </div><!-- end card header -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="row project-wrapper">
                <div class="col-xxl-8">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                                <i data-feather="briefcase" class="text-primary"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Projets</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{ $projectCount }}">0</span></h4>
                                                <span class="badge bg-danger-subtle text-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span>
                                            </div>
                                            <p class="text-muted text-truncate mb-0">Nombre total des projets</p>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                                <i data-feather="award" class="text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase fw-medium text-muted mb-3">Equipes</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{ $teamCount }}">0</span></h4>
                                                <span class="badge bg-success-subtle text-success fs-12"><i class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>3.58 %</span>
                                            </div>
                                            <p class="text-muted mb-0">Nombre total des équipes</p>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle text-info rounded-2 fs-2">
                                                <i data-feather="users" class="text-info"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Utilisateurs</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{ $userCount }}">0</span></h4>
                                                <span class="badge bg-danger-subtle text-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>10.35 %</span>
                                            </div>
                                            <p class="text-muted text-truncate mb-0">Nombre total d'utilisateurs</p>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-xl-7">
                    <div class="card card-height-100">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title flex-grow-1 mb-0">Overview des projets</h4>
                            <div class="flex-shrink-0">
                                <a href="javascript:void(0);" class="btn btn-soft-info btn-sm material-shadow-none">Exporter</a>
                            </div>
                        </div><!-- end cardheader -->
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap table-centered align-middle">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th scope="col">Nom du projet</th>
                                            <th scope="col">Lead</th>
                                            <th scope="col">Progression</th>
                                            <th scope="col">Membres</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" style="width: 10%;">Créé le</th>
                                        </tr><!-- end tr -->
                                    </thead><!-- thead -->

                                    <tbody id="projectTableBody">
                                        @foreach ($projects as $project)
                                        <tr class="project-row">
                                            <td class="fw-medium">{{$project->title}}</td>
                                            <td>
                                                @if($project->lead)
                                                    @if($project->lead->profile_photo_path)
                                                        <img src="{{ asset('storage/' . $project->lead->profile_photo_path) }}"
                                                             class="avatar-xxs rounded-circle me-1 material-shadow" alt="Lead"  data-bs-toggle="tooltip"  data-bs-original-title="{{$project->lead->name}}">
                                                    @else
                                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-primary text-white font-size-16">
                                                                {{ strtoupper(substr($project->lead->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $project->lead->name)[1] ?? '', 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Aucun lead</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-1 text-muted fs-13">{{round($project->progress)}}%</div>
                                                    <div class="progress progress-sm  flex-grow-1" style="width: 68%;">
                                                        <div class="progress-bar bg-primary rounded" role="progressbar" style="width: {{$project->progress}}%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group d-flex flex-nowrap">
                                                    @foreach($project->members as $member)
                                                        <div class="avatar-group-item position-relative">
                                                            <a href="javascript:void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-original-title="{{ $member->name }}">
                                                                @if ($member->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $member->profile_photo_path) }}" alt="" class="rounded-circle avatar-xxs material-shadow border border-white">
                                                                @else
                                                                    <div class="avatar-xs bg-primary text-white rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 24px; height: 24px;">
                                                                        <span class=" text-uppercase">
                                                                            {{ strtoupper(substr($member->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $member->name)[1] ?? '', 0, 1)) }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                            </td>
                                            <td>
                                                @if($project->status=='not_started')
                                                <span class="badge bg-danger-subtle text-danger">Non débuté</span>
                                                @elseif($project->status=='in_progress')
                                                <span class="badge bg-warning-subtle text-warning">En cours</span>
                                                @else
                                                <span class="badge bg-success-subtle text-success">Terminé</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{$project->created_at->format('d, M Y')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table><!-- end table -->
                            </div>

                            <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                                <div class="flex-shrink-0">
                                    <div class="text-muted">Affichage de <span id="currentRange">1-4</span> sur <span id="totalResults"></span> résultats</div>
                                </div>
                                <ul class="pagination pagination-separated pagination-sm mb-0" id="pagination">
                                    <li class="page-item disabled" id="prevPage">
                                        <a href="javascript:void(0);" class="page-link" onclick="changePage(-1)">←</a>
                                    </li>
                                    <li class="page-item" id="nextPage">
                                        <a href="javascript:void(0);" class="page-link" onclick="changePage(1)">→</a>
                                    </li>
                                </ul>

                            </div>


                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-5">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1 py-1">Overview des taches</h4>
                            <div class="flex-shrink-0">
                                <div class="dropdown card-header-dropdown">
                                    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">Tout <i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Tout</a>
                                        <a class="dropdown-item" href="#">Completée </a>
                                        <a class="dropdown-item" href="#">En cours</a>
                                        <a class="dropdown-item" href="#">Non débuté</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-nowrap table-centered align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Titre</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Assignée à</th>
                                        </tr>
                                    </thead><!-- end thead -->

                                    <tbody>
                                        @forelse($projects as $project)
                                            @foreach($project->tasks as $task)
                                                <tr>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d, M Y') : 'Aucune' }}</td>
                                                    <td>
                                                        @if($task->status == 'completed')
                                                            <span class="badge bg-success">Complétée</span>
                                                        @elseif($task->status == 'in_progress')
                                                            <span class="badge bg-warning-subtle text-warning">En cours</span>
                                                        @else
                                                            <span class="badge bg-secondary">Non débutée</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($task->user)
                                                            <div class="d-flex align-items-center">
                                                                @if($task->user->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $task->user->profile_photo_path) }}"
                                                                         class="avatar-xxs rounded-circle me-1 material-shadow" alt="Assigné à">
                                                                @else
                                                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                                                        {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                                                    </span>
                                                                @endif
                                                                <span>{{ $task->user->name }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Non assignée</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <img src="{{ asset('assets/images/illustrator/task.svg') }}" alt="" class="img-fluid" style="max-width: 220px;">
                                                    <h4 class="mt-4">Aucune tâche à afficher</h4>
                                                    <p class="text-muted">Il n'y a pas de tâche à afficher pour le moment.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="javascript:void(0);" class="text-muted text-decoration-underline">Charger</a>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div> <!-- end .h-100-->

    </div> <!-- end col -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const rowsPerPage = 4;
            let currentPage = 1;

            const tableBody = document.getElementById("projectTableBody");
            const rows = Array.from(tableBody.getElementsByClassName("project-row"));
            const totalResults = document.getElementById("totalResults");
            const currentRange = document.getElementById("currentRange");

            function displayRows() {
                let start = (currentPage - 1) * rowsPerPage;
                let end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? "" : "none";
                });

                currentRange.textContent = `${start + 1}-${Math.min(end, rows.length)}`;
                updatePaginationButtons();
            }

            function changePage(direction) {
                const totalPages = Math.ceil(rows.length / rowsPerPage);

                if ((direction === -1 && currentPage > 1) || (direction === 1 && currentPage < totalPages)) {
                    currentPage += direction;
                    displayRows();
                }
            }

            function updatePaginationButtons() {
                const totalPages = Math.ceil(rows.length / rowsPerPage);
                document.getElementById("prevPage").classList.toggle("disabled", currentPage === 1);
                document.getElementById("nextPage").classList.toggle("disabled", currentPage === totalPages);
            }

            totalResults.textContent = rows.length;
            displayRows();

            // Rendre la fonction accessible globalement
            window.changePage = changePage;
        });
    </script>


    @endsection
