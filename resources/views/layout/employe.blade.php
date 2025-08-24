<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Farlu - Gestion de Projets')</title>

    <!-- CSS externes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <style>
        .btn-outline-black {
    background-color: #fff; /* fond blanc */
    color: #000;            /* texte noir */
    border: 1px solid #000; /* bordure noire */
    transition: all 0.2s ease;
}

.btn-outline-black:hover {
    background-color: #000; /* fond noir au hover */
    color: #fff;            /* texte blanc au hover */
}

        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f7f6f3;
            --sidebar-bg: #fbfbfa;
            --border-light: rgba(55, 53, 47, 0.09);
            --border-medium: rgba(55, 53, 47, 0.16);
            --text-primary: #37352f;
            --text-secondary: rgba(55, 53, 47, 0.65);
            --text-tertiary: rgba(55, 53, 47, 0.4);
            --hover-bg: rgba(55, 53, 47, 0.08);
            --active-bg: rgba(55, 53, 47, 0.12);
            --sidebar-width: 260px;
            --header-height: 60px;
            --accent-blue: #2383e2;
            --accent-blue-light: rgba(35, 131, 226, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, sans-serif;
            background-color: var(--bg-secondary);
            margin: 0;
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-light);
            padding: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.2, 0, 0, 1);
        }

        /* Header Sidebar */
        .sidebar-header {
            padding: 16px 20px 12px;
            border-bottom: 1px solid var(--border-light);
            background: var(--bg-primary);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .brand-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-primary);
            padding: 6px 8px;
            border-radius: 6px;
            transition: background-color 0.15s ease;
            font-weight: 600;
            font-size: 15px;
        }

        .brand-link:hover {
            background-color: var(--hover-bg);
            color: var(--text-primary);
        }

        .brand-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 600;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--border-medium) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: var(--border-medium);
            border-radius: 2px;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 8px 12px;
            user-select: none;
        }

        .nav-item {
            margin-bottom: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 400;
            transition: all 0.15s ease;
            position: relative;
            cursor: pointer;
            user-select: none;
        }

        .nav-link:hover {
            background-color: var(--hover-bg);
            color: var(--text-primary);
        }

        .nav-link.active {
            background-color: var(--active-bg);
            color: var(--text-primary);
            font-weight: 500;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 16px;
            background-color: var(--accent-blue);
            border-radius: 0 2px 2px 0;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--text-secondary);
            transition: color 0.15s ease;
        }

        .nav-link:hover .nav-icon,
        .nav-link.active .nav-icon {
            color: var(--text-primary);
        }

        .nav-arrow {
            margin-left: auto;
            width: 16px;
            height: 16px;
            color: var(--text-tertiary);
            transition: transform 0.2s ease, color 0.15s ease;
        }

        .nav-link[aria-expanded="true"] .nav-arrow {
            transform: rotate(90deg);
            color: var(--text-secondary);
        }

        /* Submenu */
        .submenu {
            padding-left: 32px;
            margin-top: 4px;
            overflow: hidden;
        }

        .submenu .nav-link {
            padding: 6px 12px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .submenu .nav-link:hover {
            color: var(--text-primary);
        }

        /* Header */
        .main-header {
            position: sticky;
            top: 0;
            height: var(--header-height);
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            margin-left: var(--sidebar-width);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
        }

        .breadcrumb {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item:not(:last-child)::after {
            content: '/';
            margin: 0 8px;
            color: var(--text-tertiary);
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-button {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            background: transparent;
            border: none;
            border-radius: 6px;
            color: var(--text-primary);
            cursor: pointer;
            transition: background-color 0.15s ease;
            font-size: 14px;
        }

        .user-button:hover {
            background-color: var(--hover-bg);
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            font-size: 12px;
            margin-left: 8px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: calc(100vh - var(--header-height));
            padding: 32px 24px;
            background-color: var(--bg-primary);
        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Footer */
        .main-footer {
            margin-left: var(--sidebar-width);
            padding: 20px 24px;
            background-color: var(--bg-primary);
            border-top: 1px solid var(--border-light);
            text-align: center;
            color: var(--text-tertiary);
            font-size: 12px;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            padding: 8px;
            min-width: 200px;
            background-color: var(--bg-primary);
        }

        .dropdown-item {
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            color: var(--text-primary);
            transition: background-color 0.15s ease;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: var(--hover-bg);
            color: var(--text-primary);
        }

        .dropdown-divider {
            margin: 8px 0;
            border-top: 1px solid var(--border-light);
        }

        .dropdown-header {
            padding: 8px 12px 4px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-header {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 20px 16px;
            }

            .main-footer {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-section {
            animation: slideIn 0.3s ease-out;
        }

        /* Custom scrollbar for webkit browsers */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: var(--border-medium);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background-color: var(--text-tertiary);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('employe.dashboard') }}" class="brand-link">
            <div class="brand-icon">F</div>
            <span>Farlu</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu</div>
            <div class="nav-item">
                <a class="nav-link" href="{{ route('employe.dashboard') }}">
                    <i class="nav-icon ri-dashboard-2-line"></i>
                    <span>Tableau de Bord</span>
                </a>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Projets</div>
            <div class="nav-item">
                <a class="nav-link" href="{{ route('employe.projects') }}">
                    <i class="nav-icon ri-layout-4-fill"></i>
                    <span>Mes Projets</span>
                </a>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Communication</div>
            <div class="nav-item">
                <a class="nav-link" href="{{ route('chatify') }}">
                    <i class="nav-icon ri-chat-2-line"></i>
                    <span>Messagerie</span>
                    <span id="chat-badge-sub" class="badge bg-danger ms-2" style="display:none;"></span>
                </a>
            </div>
        </div>
    </nav>
</aside>

<!-- Main Layout -->
<div class="main-layout">
    <!-- Header -->
    <header class="main-header">
        <nav class="breadcrumb">
            <div class="breadcrumb-item">
                <span>Farlu</span>
            </div>
            <div class="breadcrumb-item">
                <span>@yield('page-title', 'Tableau de Bord')</span>
            </div>
        </nav>

        <div class="user-menu">
            <div class="dropdown">
                <button class="user-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>{{ Auth::user()->name }}</span>
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-account-circle me-2"></i>
                            <span>Mon profil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-calendar-check-outline me-2"></i>
                            <span>Mes tâches</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-cog-outline me-2"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-logout me-2"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <p>© 2024 Farlu. Tous droits réservés.</p>
    </footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Active navigation management
    function setActiveNav() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
                
                // Open parent collapse if exists
                const collapse = link.closest('.collapse');
                if (collapse) {
                    collapse.classList.add('show');
                    const trigger = document.querySelector(`[data-bs-target="#${collapse.id}"]`);
                    if (trigger) trigger.setAttribute('aria-expanded', 'true');
                }
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        setActiveNav();
        
        // Handle collapse arrows
        const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
        collapseElements.forEach(element => {
            element.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                if (target) {
                    setTimeout(() => {
                        const isExpanded = target.classList.contains('show');
                        this.setAttribute('aria-expanded', isExpanded);
                    }, 100);
                }
            });
        });
    });

    // Copy link function
    function copyPublicOfferLink() {
        const input = document.getElementById("publicLinkInput");
        navigator.clipboard.writeText(input.value).then(() => {
            // Create a toast notification
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success alert-dismissible fade show';
            toast.style.zIndex = '9999';
            toast.innerHTML = 'Lien copié avec succès !';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        });
    }

    // Mobile sidebar toggle (if needed)
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('show');
    }

     function updateUnreadMessages() {
        fetch('{{ route('messages.unread.count') }}')
            .then(response => response.json())
            .then(data => {
                const mainBadge = document.getElementById('chat-badge-main');
                const subBadge = document.getElementById('chat-badge-sub');

                if (data.count > 0) {
                    mainBadge.textContent = data.count;
                    subBadge.textContent = data.count;

                    mainBadge.style.display = 'inline-block';
                    subBadge.style.display = 'inline-block';
                } else {
                    mainBadge.style.display = 'none';
                    subBadge.style.display = 'none';
                }
            })
            .catch(error => console.error('Erreur fetch:', error));
    }

    updateUnreadMessages();

  
    setInterval(updateUnreadMessages, 10000);

    document.getElementById('copy-link-btn').addEventListener('click', function() {
    const entrepriseId = this.dataset.entreprise;

    const link = "{{ url('/rh/candidature/candidat/list') }}/" + entrepriseId;

    navigator.clipboard.writeText(link).then(function() {
        document.getElementById('copy-link-text').textContent = "Lien copié !";
        
        setTimeout(() => {
            document.getElementById('copy-link-text').textContent = "Copier le lien de candidature";
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie : ', err);
    });
});
</script>

</body>
</html>