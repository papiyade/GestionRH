@extends('layout.superadmin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Superadmin')

@section('content')

				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Tableau de Bord</h2>
						<nav>
							{{-- <ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="https://farlu.com"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									Superadmin
								</li>
								<li class="breadcrumb-item active" aria-current="page">Tableau de Bord</li>
							</ol> --}}
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
						<div class="input-icon mb-2 position-relative">
							<span class="input-icon-addon">
								<i class="ti ti-calendar text-gray-9"></i>
							</span>
							<input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy">
						</div>
						<div class="ms-2 head-icons">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Breadcrumb -->

    				<!-- Welcome Wrap -->
				<div class="welcome-wrap mb-4">
					<div class=" d-flex align-items-center justify-content-between flex-wrap">
						<div class="mb-3">
							<h2 class="mb-1 text-white">Bonjour , {{ Auth::user()->role }} </h2>
							<p class="text-light">Passez une bonne journée sur la plateforme !</p>
						</div>
						<div class="d-flex align-items-center flex-wrap mb-1">
							<a href="{{ route('list_admin') }}" class="btn btn-dark btn-md me-2 mb-2">Admins</a>
							<a href="https://smarthr.co.in/demo/html/template/packages.html" class="btn btn-light btn-md mb-2">Entreprises</a>
						</div>
					</div>
					<div class="welcome-bg">
						{{-- <img src="{{ asset('assets/img/bg/card-bg-02.png') }}" alt="img" class="welcome-bg-01">
						<img src="{{ asset('assets/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02">
						<img src="{{ asset('assets/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03"> --}}
					</div>
				</div>	
				<!-- /Welcome Wrap -->

                <div class="row">

					<!-- Total Companies -->
					<div class="col-xl-4 col-sm-6 d-flex">
						<div class="card flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between">
									<span class="avatar avatar-md bg-dark mb-3">
										<i class="ti ti-building fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<h2 class="mb-1">{{ \App\Models\Entreprise::count() }}</h2>
										<p class="fs-13">Total Entreprises</p>
									</div>
									<div class="company-bar1">5,10,7,5,10,7,5</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Total Companies -->

					<!-- Active Companies -->
					<div class="col-xl-4 col-sm-6 d-flex">
						<div class="card flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between">
									<span class="avatar avatar-md bg-dark mb-3">
										<i class="ti ti-carousel-vertical fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<h2 class="mb-1">{{ \App\Models\Entreprise::where('is_actif',1)->count() }}</h2>
										<p class="fs-13">Entreprises actives</p>
									</div>
									<div class="company-bar2">5,3,7,6,3,10,5</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Active Companies -->

					<!-- Total Subscribers -->
					<div class="col-xl-4 col-sm-6 d-flex">
						<div class="card flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between">
									<span class="avatar avatar-md bg-dark mb-3">
										<i class="ti ti-chalkboard-off fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<h2 class="mb-1">{{ \App\Models\User::count() }}</h2>
										<p class="fs-13">Total Utilisateurs</p>
									</div>
									<div class="company-bar3">8,10,10,8,8,10,8</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Total Subscribers -->

                <div class="row">

					<!-- Top Plans -->
<!-- Overview sur les entreprises -->
<div class="col-xxl-3 col-xl-12 d-flex">
    <div class="card flex-fill">
        <div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
            <h5 class="mb-2">Overview sur les entreprises</h5>
        </div>
        <div class="card-body">
            <div id="entreprise-overview"></div>
        </div>
    </div>
</div>

					<!-- /Top Plans -->

				</div>

				<div class="row">

					<!-- Recent Transactions -->
					<div class="col-xxl-4 col-xl-12 d-flex">
						<div class="card flex-fill">
							<div class="card-header pb-2 d-flex align-items-center justify-content-between flex-wrap">
								<h5 class="mb-2">Entreprises récemment créées</h5>
								<a href="{{ route('entreprises.list') }}" class="btn btn-light btn-md mb-2">Voir tout</a>
							</div>
							<div class="card-body pb-2">
                                @foreach ($entreprises as $entreprise)
								<div class="d-sm-flex justify-content-between flex-wrap mb-3">
                                    <div class="d-flex align-items-center mb-2">                                         
                                        <a href="javscript:void(0);" class="avatar avatar-md bg-gray-100 rounded-circle flex-shrink-0">
                                            <img src="{{ asset('assets/img/company/company-02.svg') }}" class="img-fluid w-auto h-auto" alt="img">
                                        </a>
                                        <div class="ms-2 flex-fill">
                                            <h6 class="fs-medium text-truncate mb-1"><a href="javscript:void(0);">{{$entreprise->entreprise_name}}</a></h6>
                                            <p class="fs-13 d-inline-flex align-items-center"><span class="text-info">#{{ $entreprise->id }}</span><i class="ti ti-circle-filled fs-4 text-primary mx-1"></i>{{ $entreprise->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-sm-end mb-2">
                                        <h6 class="mb-1">Statut</h6>
                                        @if ($entreprise->is_actif==true)
                                            <span class="badge badge-soft-success">Active</span>
                                            @else
                                            <span class="badge badge-soft-primary">Inactive</span>
                                        @endif
                                    </div>
                                    
                                </div>
                                <hr>
                                @endforeach
							</div>
						</div>
					</div>
					<!-- /Recent Transactions -->
				</div>
				</div>
@endsection

{{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'donut',
                height: 300
            },
            series: [{{ $actives }}, {{ $inactives }}],
            labels: ['Actives', 'Inactives'],
            colors: ['#47AB2E', '#FB6B19'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                formatter: function (val, opts) {
                    return val.toFixed(1) + "%";
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#entreprise-overview"), options);
        chart.render();
    });
</script>

