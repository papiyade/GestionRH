<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from smarthr.co.in/demo/html/template/dashboard by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Sep 2025 19:08:12 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Smarthr - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
	<meta name="author" content="Dreams technologies - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Farlu - RH </title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">

	<!-- Theme Script js -->
	<script src="{{asset('assets/js/theme-script.js')}}"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/icons/feather/feather.css')}}">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{asset('assets/plugins/tabler-icons/tabler-icons.min.css')}}">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">

    	<!-- Datatable CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap5.min.css')}}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">

	<!-- Summernote CSS -->
	<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-lite.min.css')}}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

	<!-- Color Picker Css -->
	<link rel="stylesheet" href="{{asset('assets/plugins/flatpickr/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/@simonwep/pickr/themes/nano.min.css')}}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

</head>

<body>

	<div id="global-loader">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<div class="header">
			<div class="main-header">

				<div class="header-left">
					<a href="https://smarthr.co.in/demo/html/template/index.html" class="logo">
						<img src="{{asset('assets/img/logo.svg')}}" alt="Logo">
					</a>
					<a href="https://smarthr.co.in/demo/html/template/index.html" class="dark-logo">
						<img src="{{asset('assets/img/logo-white.svg')}}" alt="Logo">
					</a>
				</div>

				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>

				<div class="header-user">
					<div class="nav user-menu nav-list">

						<div class="me-auto d-flex align-items-center" id="header-search">
							<a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar me-1">
								<i class="ti ti-arrow-bar-to-left"></i>
							</a>
							<!-- Search -->
							<div class="input-group input-group-flat d-inline-flex me-1">
								<span class="input-icon-addon">
									<i class="ti ti-search"></i>
								</span>
								<input type="text" class="form-control" placeholder="Rechercher...">
								<span class="input-group-text">
									<kbd>CTRL + / </kbd>
								</span>
							</div>
							<!-- /Search -->
							<div class="dropdown crm-dropdown">
								<a href="#" class="btn btn-menubar me-1" data-bs-toggle="dropdown">
									<i class="ti ti-layout-grid"></i>
								</a>
								<div class="dropdown-menu dropdown-lg dropdown-menu-start">
									<div class="card mb-0 border-0 shadow-none">
										<div class="card-header">
											<h4>Applications</h4>
										</div>
										<div class="card-body pb-1">
											<div class="row">
												<div class="col-sm-6">
													<a href="{{ route('employeList') }}" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
														<span class="d-flex align-items-center me-3">
															<i class="ti ti-user-shield text-default me-2"></i>Employés
														</span>
														<i class="ti ti-arrow-right"></i>
													</a>
													<a href="{{route('rh.index')}}" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
														<span class="d-flex align-items-center me-3">
															<i class="ti ti-activity text-default me-2"></i>Fiches salariéss
														</span>
														<i class="ti ti-arrow-right"></i>
													</a>

												</div>
												<div class="col-sm-6">
													<a href="{{ route('teams') }}" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
														<span class="d-flex align-items-center me-3">
															<i class="ti ti-building text-default me-2"></i>equipes
														</span>
														<i class="ti ti-arrow-right"></i>
													</a>
													<a href="{{ route('candidatures.index') }}" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
														<span class="d-flex align-items-center me-3">
															<i class="ti ti-user-check text-default me-2"></i>Candidatures
														</span>
														<i class="ti ti-arrow-right"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="d-flex align-items-center">
							<div class="me-1">
								<a href="#" class="btn btn-menubar btnFullscreen">
									<i class="ti ti-maximize"></i>
								</a>
							</div>
							<div class="dropdown me-1">
								<a href="#" class="btn btn-menubar" data-bs-toggle="dropdown">
									<i class="ti ti-layout-grid-remove"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="card mb-0 border-0 shadow-none">
										<div class="card-header">
											<h4>Applications</h4>
										</div>
										<div class="card-body">
											<a href="{{ route('employeList') }}" class="d-block pb-2">
												<span class="avatar avatar-md bg-transparent-dark me-2"><i class="ti ti-calendar text-gray-9"></i></span>Employés
											</a>
											<a href="{{route('teams')}}" class="d-block py-2">
												<span class="avatar avatar-md bg-transparent-dark me-2"><i class="ti ti-subtask text-gray-9"></i></span>Equipes											</a>
											<a href="{{ route('candidatures.index') }}" class="d-block py-2">
												<span class="avatar avatar-md bg-transparent-dark me-2"><i class="ti ti-notes text-gray-9"></i></span>Candidatures
											</a>
                                            <a href="{{ route('rh.index') }}" class="d-block py-2">
												<span class="avatar avatar-md bg-transparent-dark me-2"><i class="ti ti-notes text-gray-9"></i></span>Fiches salariés
											</a>
										</div>
									</div>
								</div>
							</div>
							{{-- <div class="me-1">
								<a href="https://smarthr.co.in/demo/html/template/chat.html" class="btn btn-menubar position-relative">
									<i class="ti ti-brand-hipchat"></i>
									<span class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
								</a>
							</div> --}}
							<div class="me-1 notification_item">
								<a href="#" class="btn btn-menubar position-relative me-1" id="notification_popup"
									data-bs-toggle="dropdown">
									<i class="ti ti-bell"></i>
									<span class="notification-status-dot"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-end notification-dropdown p-4">
									<div class="d-flex align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
										<h4 class="notification-title">Notifications</h4>
										{{-- <div class="d-flex align-items-center">
											<a href="#" class="text-primary fs-15 me-3 lh-1">Mark all as read</a>
											<div class="dropdown">
												<a href="javascript:void(0);" class="bg-white dropdown-toggle"
													data-bs-toggle="dropdown">
													<i class="ti ti-calendar-due me-1"></i>Today
												</a>
												<ul class="dropdown-menu mt-2 p-3">
													<li>
														<a href="javascript:void(0);" class="dropdown-item rounded-1">
															This Week
														</a>
													</li>
													<li>
														<a href="javascript:void(0);" class="dropdown-item rounded-1">
															Last Week
														</a>
													</li>
													<li>
														<a href="javascript:void(0);" class="dropdown-item rounded-1">
															Last Month
														</a>
													</li>
												</ul>
											</div>
										</div> --}}
									</div>
									<div class="noti-content">
										{{-- <div class="d-flex flex-column">
											<div class="border-bottom mb-3 pb-3">
												<a href="https://smarthr.co.in/demo/html/template/activity.html">
													<div class="d-flex">
														<span class="avatar avatar-lg me-2 flex-shrink-0">
															<img src="{{asset('assets/img/profiles/avatar-27.jpg')}}" alt="Profile">
														</span>
														<div class="flex-grow-1">
															<p class="mb-1"><span
																	class="text-dark fw-semibold">Shawn</span>
																performance in Math is below the threshold.</p>
															<span>Just Now</span>
														</div>
													</div>
												</a>
											</div>
											<div class="border-bottom mb-3 pb-3">
												<a href="https://smarthr.co.in/demo/html/template/activity.html" class="pb-0">
													<div class="d-flex">
														<span class="avatar avatar-lg me-2 flex-shrink-0">
															<img src="{{asset('assets/img/profiles/avatar-23.jpg')}}" alt="Profile">
														</span>
														<div class="flex-grow-1">
															<p class="mb-1"><span
																	class="text-dark fw-semibold">Sylvia</span> added
																appointment on 02:00 PM</p>
															<span>10 mins ago</span>
															<div
																class="d-flex justify-content-start align-items-center mt-1">
																<span class="btn btn-light btn-sm me-2">Deny</span>
																<span class="btn btn-primary btn-sm">Approve</span>
															</div>
														</div>
													</div>
												</a>
											</div>
										</div> --}}
									</div>
									<div class="d-flex p-0">
										<a href="#" class="btn btn-light w-100 me-2">Fermer</a>
										{{-- <a href="#" class="btn btn-primary w-100">Voir tout</a> --}}
									</div>
								</div>
							</div>
							<div class="dropdown profile-dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
									<span class="avatar avatar-sm online bg-primary">
										{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
									</span>
								</a>
								<div class="dropdown-menu shadow-none">
									<div class="card mb-0">
										<div class="card-header">
											<div class="d-flex align-items-center">
												<span class="avatar avatar-lg me-2 avatar-rounded bg-primary">
													{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
												</span>
												<div>
													<h5 class="mb-0">{{Auth::user()->name}}</h5>
													<p class="fs-12 fw-medium mb-0"><a >{{Auth::user()->email}}</a></p>
												</div>
											</div>
										</div>
										<div class="card-body">
											<a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
												href="https://smarthr.co.in/demo/html/template/profile.html">
												<i class="ti ti-user-circle me-1"></i>Profil
											</a>
											<a class="dropdown-item d-inline-flex align-items-center p-0 py-2" href="https://smarthr.co.in/demo/html/template/bussiness-settings.html">
												<i class="ti ti-settings me-1"></i>Paramètres
											</a>
										</div>
										<div class="card-footer py-1">
                                                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-inline-flex align-items-center p-0 py-2">
                                <i class="ti ti-login me-2"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-ellipsis-v"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<a class="dropdown-item" href="">Mon Profil</a>
						<a class="dropdown-item" href="">Paramètres</a>
										<div class="card-footer py-1">
                                                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-inline-flex align-items-center p-0 py-2">
                                <i class="ti ti-login me-2"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
										</div>
					</div>
				</div>
				<!-- /Mobile Menu -->

			</div>

		</div>
		<!-- /Header -->

		<!-- Sidebar -->
		<div class="sidebar" id="sidebar">
			<!-- Logo -->
			<div class="sidebar-logo">
				<a href="https://smarthr.co.in/demo/html/template/index.html" class="logo logo-normal">
					<img src="{{asset('assets/img/logo.svg')}}" alt="Logo">
				</a>
				<a href="https://smarthr.co.in/demo/html/template/index.html" class="logo-small">
					<img src="{{asset('assets/img/logo-small.svg')}}" alt="Logo">
				</a>
				<a href="https://smarthr.co.in/demo/html/template/index.html" class="dark-logo">
					<img src="{{asset('assets/img/logo-white.svg')}}" alt="Logo">
				</a>
			</div>
			<!-- /Logo -->
			<div class="modern-profile p-3 pb-0">
				<div class="text-center rounded bg-light p-3 mb-4 user-profile">
					<div class="avatar avatar-lg online mb-3">
						<img src="{{asset('assets/img/profiles/avatar-02.jpg')}}" alt="Img" class="img-fluid rounded-circle">
					</div>
					<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
					<p class="fs-10">System Admin</p>
				</div>
				<div class="sidebar-nav mb-3">
					<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent"
						role="tablist">
						<li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
						<li class="nav-item"><a class="nav-link border-0" href="https://smarthr.co.in/demo/html/template/chat.html">Chats</a></li>
						<li class="nav-item"><a class="nav-link border-0" href="https://smarthr.co.in/demo/html/template/email.html">Inbox</a></li>
					</ul>
				</div>
			</div>
			<div class="sidebar-header p-3 pb-0 pt-2">
				<div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
					<div class="avatar avatar-md onlin">
						<img src="{{asset('assets/img/profiles/avatar-02.jpg')}}" alt="Img" class="img-fluid rounded-circle">
					</div>
					<div class="text-start sidebar-profile-info ms-2">
						<h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
						<p class="fs-10">System Admin</p>
					</div>
				</div>
				<div class="input-group input-group-flat d-inline-flex mb-4">
					<span class="input-icon-addon">
						<i class="ti ti-search"></i>
					</span>
					<input type="text" class="form-control" placeholder="Search in HRMS">
					<span class="input-group-text">
						<kbd>CTRL + / </kbd>
					</span>
				</div>
				<div class="d-flex align-items-center justify-content-between menu-item mb-3">
					<div class="me-3">
						<a href="https://smarthr.co.in/demo/html/template/calendar.html" class="btn btn-menubar">
							<i class="ti ti-layout-grid-remove"></i>
						</a>
					</div>
					<div class="me-3">
						<a href="https://smarthr.co.in/demo/html/template/chat.html" class="btn btn-menubar position-relative">
							<i class="ti ti-brand-hipchat"></i>
							<span class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
						</a>
					</div>
					<div class="me-3 notification-item">
						<a href="https://smarthr.co.in/demo/html/template/activity.html" class="btn btn-menubar position-relative me-1">
							<i class="ti ti-bell"></i>
							<span class="notification-status-dot"></span>
						</a>
					</div>
					<div class="me-0">
						<a href="https://smarthr.co.in/demo/html/template/email.html" class="btn btn-menubar">
							<i class="ti ti-message"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="menu-title"><span>GENERAL</span></li>
						<li>
							<ul>
								<li class="">
									<a href="{{route('rh_dashboard')}}" class="active subdrop">
										<i class="ti ti-user-star"></i><span>Tableau de Bord</span>
									</a>
								</li>
							</ul>
						<li class="menu-title"><span>Système</span></li>
						<li>
							<ul>
								<li class="submenu">
									<a href="#">
										<i class="ti ti-user-shield"></i><span>Employés<script></script></span>
                                        <span class="menu-arrow"></span>
									</a>

                                    <ul>
										<li><a href="{{ route("employeList") }}">Liste des employés</a></li>
										<li><a href="{{ route('rh.users.create') }}">Créer un nouvel employé</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="#">
										<i class="ti ti-shield"></i><span>Equipes<script></script></span>
                                        <span class="menu-arrow"></span>
									</a>

                                    <ul>
										<li><a href="{{ route("teams") }}">Liste des équipes</a></li>
										<li><a href="{{ route('rh.users.create') }}">Créer une nouvelle équipe</a></li>
									</ul>
								</li>
                                <li class="submenu">
									<a href="#">
										<i class="ti ti-user-shield"></i><span>Candidatures<script></script></span>
                                        <span class="menu-arrow"></span>
									</a>

                                    <ul>
										<li><a href="{{ route("offres.index") }}">Liste des offres</a></li>
										<li><a href="{{ route('candidatures.index') }}">Suivi des candidatures</a></li>
									</ul>
								</li>
                                <li class="submenu">
									<a href="#">
										<i class="ti ti-coin"></i><span>Gestion des salaires<script></script></span>
                                        <span class="menu-arrow"></span>
									</a>

                                    <ul>
										<li><a href="{{ route("rh.index") }}">Fiches employés</a></li>
									</ul>
								</li>
                                <li href="/cras">
									<a href="/cras">
										<i class="ti ti-file"></i><span>Comptes rendus/Activités<script></script></span>
									</a>
								</li>
                                <li href="{{ route('rh.prestataires.index') }}">
                                    <a href="{{ route('rh.prestataires.index') }}">
                                        <i class="ti ti-users"></i><span>Prestataires<script></script></span>
                                    </a>
                                </li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
                <div>
                    @yield('content')
                </div>
			</div>

			<div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
				<p class="mb-0"> 2025 &copy; Farlu.</p>
				<p> By <a href="javascript:void(0);" class="text-primary">BBS MASTER GROUP</a></p>
			</div>

		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script data-cfasync="false" src="https://smarthr.co.in/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

	<!-- Feather Icon JS -->
	<script src="{{asset('assets/js/feather.min.js')}}"></script>

    	<!-- Datatable JS -->
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.bootstrap5.min.js')}}"></script>

    	<!-- Sticky Sidebar JS -->
	<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
	<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

    	<!-- Sweetalert 2 -->
	<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
	<script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>

	<!-- Slimscroll JS -->
	<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>

	<!-- Chart JS -->
	<script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
	<script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>

	<!-- Chart JS -->
	<script src="https://smarthr.co.in/demo/html/template/assets/plugins/chartjs/chart.min.js"></script>
	<script src="https://smarthr.co.in/demo/html/template/assets/plugins/chartjs/chart-data.js"></script>

	<!-- Datetimepicker JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>

	<!-- Daterangepikcer JS -->
	<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>

	<!-- Summernote JS -->
	<script src="{{asset('assets/plugins/summernote/summernote-lite.min.js')}}"></script>

	<!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

	<!-- Chart JS -->
	<script src="{{asset('assets/plugins/peity/jquery.peity.min.js')}}"></script>
	<script src="{{asset('assets/plugins/peity/chart-data.js')}}"></script>

	<!-- Color Picker JS -->
	<script src="{{asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js')}}"></script>

	<!-- Custom JS -->
	<script src="{{asset('assets/js/theme-colorpicker.js')}}"></script>
	<script src="{{asset('assets/js/script.js')}}"></script>

</body>


<!-- Mirrored from smarthr.co.in/demo/html/template/dashboard by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Sep 2025 19:08:12 GMT -->
</html>
