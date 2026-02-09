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
	<title>Farlu | Employé</title>

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
	    <!-- ... autres CSS ... -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}">

    		    <style>
/* Sidebar Padding */
.sidebar-inner {
    padding: 0 8px;
}

/* Menu Items */
#sidebar-menu ul li a {
    padding: 12px 16px;
    margin: 6px 0;
    margin-right: 8px;
    border-radius: 10px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

#sidebar-menu ul li a i {
    font-size: 20px;
    margin-right: 10px;
    color: #666 !important;
    transition: all 0.3s ease;
}

#sidebar-menu ul li a span {
    color: #333;
    transition: all 0.3s ease;
}

/* Hover Effect */
#sidebar-menu ul li a:hover {
    background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
    color: white !important;
    transform: translateX(4px);
}

#sidebar-menu ul li a:hover i,
#sidebar-menu ul li a:hover span {
    color: white !important;
}

/* Active State */
#sidebar-menu ul li a.active {
    background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%) !important;
    color: white !important;
}

#sidebar-menu ul li a.active i,
#sidebar-menu ul li a.active span {
    color: white !important;
}

/* Submenu Parent Active */
#sidebar-menu ul li.submenu.active > a {
    background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
    color: white !important;
}

#sidebar-menu ul li.submenu.active > a i,
#sidebar-menu ul li.submenu.active > a span,
#sidebar-menu ul li.submenu.active > a .menu-arrow {
    color: white !important;
}

/* Submenu Items Simple */
#sidebar-menu ul li.submenu ul {
    padding-left: 0;
    margin-top: 4px;
}

#sidebar-menu ul li.submenu ul li a {
    padding: 10px 16px 10px 46px;
    font-size: 14px;
    margin-right: 8px;
}

/* Menu Title */
.menu-title {
    padding: 12px 16px 8px;
    margin-top: 16px;
    font-size: 11px;
    font-weight: 700;
    color: #999;
}
.theme-toggle {
    cursor: pointer;
    font-size: 0.9rem;
    color: #4a1f3a;
}


/* Animation pour le badge */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

.notification-status-dot {
    animation: pulse 2s infinite;
}

/* Styles pour les items de notification */
.notif-item {
    padding: 0.75rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    gap: 0.75rem;
    align-items: start;
    margin-bottom: 0.5rem;
    border-left: 3px solid transparent;
}

.notif-item:hover {
    background: #f8f9fa;
}

.notif-item.unread {
    background: linear-gradient(90deg, rgba(174, 61, 125, 0.05) 0%, rgba(228, 110, 47, 0.05) 100%);
    border-left-color: #E46E2F;
}

.notif-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.notif-icon.today {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.notif-icon.tomorrow {
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.notif-icon.overdue {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.notif-content {
    flex: 1;
    min-width: 0;
}

.notif-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.notif-text {
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.notif-time {
    color: #adb5bd;
    font-size: 0.75rem;
}

.empty-notif {
    padding: 2rem 1rem;
    text-align: center;
    color: #adb5bd;
}

.empty-notif i {
    font-size: 2.5rem;
    margin-bottom: 0.75rem;
    opacity: 0.3;
}

</style>

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
							</div>
						</div>
						<div class="d-flex align-items-center">
                            <div class="me-1">
                                <!-- Theme Toggle -->
                                <div class="theme-toggle d-flex align-items-center ms-3" id="themeToggle"
                                    role="button">
                                    <i class="ti ti-sun theme-icon theme-light"></i>
                                    <i class="ti ti-moon theme-icon theme-dark d-none"></i>
                                </div>
                            </div>
                            <!-- Dropdown Notifications -->
<div class="me-1 notification_item">
    <a href="#" class="btn btn-menubar position-relative me-1" id="notificationBell"
        data-bs-toggle="dropdown">
        <i class="ti ti-bell"></i>
        <span class="notification-status-dot" id="notificationBadge" style="display: none;"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-end notification-dropdown p-4" id="notificationMenu">
        <div class="d-flex align-items-center justify-content-between border-bottom p-0 pb-3 mb-3">
            <h4 class="notification-title">Notifications <span id="notificationCount" class="badge bg-danger ms-2" style="display: none;">0</span></h4>
            <div class="d-flex align-items-center">
                <a href="#" class="text-primary fs-15 lh-1" id="markAllRead">Tout marquer comme lue</a>
            </div>
        </div>

        <!-- Liste des notifications -->
        <div id="notificationList" style="max-height: 400px; overflow-y: auto;">
            <!-- Les notifications seront chargées ici -->
        </div>

        <div class="d-flex p-0 mt-3">
            <button class="btn btn-light w-100" data-bs-dismiss="dropdown">Fermer</button>
        </div>
    </div>
</div>
							<div class="dropdown profile-dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
									<span class="avatar avatar-sm online">
										{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
									</span>
								</a>
								<div class="dropdown-menu shadow-none">
									<div class="card mb-0">
										<div class="card-header">
											<div class="d-flex align-items-center">
												<span class="avatar avatar-lg me-2 avatar-rounded">
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
												href="{{route('settings.edit')}}">
												<i class="ti ti-user-circle me-1"></i>Profil
											</a>
											<a class="dropdown-item d-inline-flex align-items-center p-0 py-2" href="{{route('settings.preferences')}}">
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
						<a class="dropdown-item" href="https://smarthr.co.in/demo/html/template/profile.html">My Profile</a>
						<a class="dropdown-item" href="https://smarthr.co.in/demo/html/template/profile-settings.html">Settings</a>
						<a class="dropdown-item" href="https://smarthr.co.in/demo/html/template/login.html">Logout</a>
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
                <a href="{{ route('rh_dashboard') }}" class="logo logo-normal">
                    <img src="{{ asset('assets/img/farlu.png') }}" alt="Logo">
                </a>
                <a href="{{ route('rh_dashboard') }}" class="logo-small">
                    <img src="{{ asset('assets/img/logo-small.svg') }}" alt="Logo">
                </a>
                <a href="{{ route('rh_dashboard') }}" class="dark-logo">
                    <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Logo">
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
									<a href="{{ route('employe.dashboard') }}" class="{{ request()->routeIs('employe.dashboard') ? 'active' : '' }}">
										<i class="ti ti-user-star"></i><span>Tableau de Bord</span>
									</a>
								</li>
							</ul>
						<li class="menu-title"><span>Système</span></li>
						<li>
							<ul>
								<li>
									<a href="{{ route('projects.index') }}"
                                    class="{{ request()->routeIs('projects*') ? 'active' : '' }}"
                                    >
										<i class="ti ti-activity"></i><span> Liste des projets</span>
									</a>
								</li>
                                <li>
									<a href="{{ route('tasks.my-tasks') }}"
                                     class="{{ request()->routeIs('tasks.my-tasks*') ? 'active' : '' }}"
                                    >
										<i class="ti ti-activity"></i><span> Mes taches </span>
									</a>
								</li>
								<li href="/cras">
									<a href="/cras" class="{{ request()->is('cras*') ? 'active' : '' }}">
										<i class="ti ti-file"></i><span>Comptes rendus/Activités<script></script></span>
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

		<!-- Drag Card -->
	<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
	<script src="{{asset('assets/js/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- Color Picker JS -->
	<script src="{{asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js')}}"></script>

	<!-- Custom JS -->
	<script src="{{asset('assets/js/theme-colorpicker.js')}}"></script>
	<script src="{{asset('assets/js/script.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bell = document.getElementById('notificationBell');
    const menu = document.getElementById('notificationMenu');
    const badge = document.getElementById('notificationBadge');
    const countBadge = document.getElementById('notificationCount');
    const list = document.getElementById('notificationList');
    const markAllBtn = document.getElementById('markAllRead');

    // Charger les notifications quand on ouvre le dropdown
    bell.addEventListener('click', function() {
        setTimeout(() => loadNotifications(), 100);
    });

    // Charger les notifications
    function loadNotifications() {
        fetch('{{ route("notifications.unread") }}')
            .then(response => response.json())
            .then(data => {
                updateBadge(data.count);
                displayNotifications(data.notifications);
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Mettre à jour le badge
    function updateBadge(count) {
        if (count > 0) {
            badge.style.display = 'block';
            countBadge.textContent = count > 99 ? '99+' : count;
            countBadge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
            countBadge.style.display = 'none';
        }
    }

    // Afficher les notifications
    function displayNotifications(notifications) {
        if (notifications.length === 0) {
            list.innerHTML = `
                <div class="empty-notif">
                    <i class="ti ti-bell-off d-block"></i>
                    <p class="mb-0">Aucune nouvelle notification</p>
                </div>
            `;
            return;
        }

        list.innerHTML = notifications.map(notif => {
            return `
                <div class="notif-item unread" data-id="${notif.id}" data-url="${notif.url}">
                    <div class="notif-icon ${notif.type}">
                        ${notif.icon}
                    </div>
                    <div class="notif-content">
                        <div class="notif-title">${notif.task_title}</div>
                        <div class="notif-text">${notif.message}</div>
                        <div class="notif-text"><i class="ti ti-folder me-1"></i>${notif.project_title}</div>
                        <div class="notif-time">${formatDate(notif.deadline)}</div>
                    </div>
                </div>
            `;
        }).join('');

        // Ajouter les événements de clic
        document.querySelectorAll('.notif-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;
                markAsRead(id, url);
            });
        });
    }

    // Marquer comme lu
    function markAsRead(id, url) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(() => {
            window.location.href = url;
        })
        .catch(error => console.error('Erreur:', error));
    }

    // Marquer tout comme lu
    markAllBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        fetch('{{ route("notifications.readAll") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(() => {
            loadNotifications();
        })
        .catch(error => console.error('Erreur:', error));
    });

    // Formater la date
    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();

        if (date.toDateString() === now.toDateString()) {
            return `Aujourd'hui ${date.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`;
        }

        const tomorrow = new Date(now);
        tomorrow.setDate(tomorrow.getDate() + 1);
        if (date.toDateString() === tomorrow.toDateString()) {
            return `Demain ${date.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`;
        }

        if (date < now) {
            const days = Math.floor((now - date) / (1000 * 60 * 60 * 24));
            return `Il y a ${days} jour${days > 1 ? 's' : ''}`;
        }

        return date.toLocaleDateString('fr-FR');
    }

    // Charger au démarrage
    loadNotifications();

    // Recharger toutes les minutes
    setInterval(loadNotifications, 60000);
});
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const themeToggle = document.getElementById('themeToggle');
            const sunIcon = themeToggle.querySelector('.theme-light');
            const moonIcon = themeToggle.querySelector('.theme-dark');

            const defaultTheme = '{{ Auth::user()->preferences['appearance']['theme'] ?? 'light' }}';
            let currentTheme = localStorage.getItem('userTheme') || defaultTheme;

            applyTheme(currentTheme);
            updateIcons();

            themeToggle.addEventListener('click', function() {
                currentTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
                localStorage.setItem('userTheme', currentTheme);
                applyTheme(currentTheme);
                updateIcons();
            });

            function applyTheme(theme) {
                const body = document.body;

                if (theme === 'dark') {
                    body.classList.add('dark-mode');
                    body.classList.remove('light-mode');
                } else if (theme === 'light') {
                    body.classList.add('light-mode');
                    body.classList.remove('dark-mode');
                } else if (theme === 'auto') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    body.classList.toggle('dark-mode', prefersDark);
                    body.classList.toggle('light-mode', !prefersDark);
                }
            }

            function updateIcons() {
                const isDark = document.body.classList.contains('dark-mode');

                sunIcon.classList.toggle('d-none', isDark);
                moonIcon.classList.toggle('d-none', !isDark);
            }

            // Auto mode watcher
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    const savedTheme = localStorage.getItem('userTheme');
                    if (savedTheme === 'auto') {
                        applyTheme('auto');
                        updateIcons();
                    }
                });
            }

        });
    </script>


</body>


<!-- Mirrored from smarthr.co.in/demo/html/template/dashboard by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Sep 2025 19:08:12 GMT -->
</html>
