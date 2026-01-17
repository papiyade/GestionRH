<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- ... autres CSS ... -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 0;
        }

        .header-content {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .header-tabs {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .tab-item {
            padding: 10px 20px;
            border-radius: 8px;
            color: #666;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-item:hover {
            background: #f5f5f5;
            color: #AE3D7D;
        }

        .tab-item.active {
            background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
            color: white;
        }

        .tab-item i {
            font-size: 1.1rem;
        }

        /* Main Container */
        .main-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 32px;
        }

        .config-container, .help-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 32px;
        }

        /* Section Headers */
        .section-header {
            margin: 40px 0 24px;
        }

        .section-header:first-child {
            margin-top: 0;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-left: 4px;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
            justify-items: center;
            justify-content: center;  /* Centre la grille elle-même */
        }

        /* Menu Box - Style Odoo */
        .menu-box {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 140px;

        }

        .menu-box:hover {
            background: #fafafa;
            border-color: #AE3D7D;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.1);
        }

        .menu-box-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #AE3D7D;
            transition: all 0.2s;
        }

        .menu-box:hover .menu-box-icon {
            transform: scale(1.1);
            color: #861254FF;
        }

        .menu-box-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.3;
        }

        .menu-box:hover .menu-box-title {
            color: #AE3D7D;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .header-tabs {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
            }

            .menu-box {
                min-height: 120px;
                padding: 20px 12px;
            }
        }

        @media (max-width: 576px) {
            .main-container {
                padding: 20px 16px;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .menu-box {
                min-height: 110px;
                padding: 16px 10px;
            }

            .menu-box-icon {
                font-size: 28px;
                width: 40px;
                height: 40px;
            }

            .menu-box-title {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body class="bodyInterface">

    <!-- Top Header -->
    <div class="top-header">
        <div class="header-content">
            <h1 class="header-title">Farlu RH</h1>
            <div class="header-tabs">
                <a href="#application" class="tab-item active">
                    <i class="ti ti-apps"></i>
                    <span>Applications</span>
                </a>
                <a href="#configuration" class="tab-item">
                    <i class="ti ti-settings"></i>
                    <span>Configuration</span>
                </a>
                <a href="#help" class="tab-item">
                    <i class="ti ti-help-circle"></i>
                    <span>Aide</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container" id="application">
        
        <!-- Section: Général -->
        <div class="section-header">
            <h2 class="section-title">Général</h2>
        </div>

        <div class="menu-grid">
            <a href="{{route('rh_dashboard')}}" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-dashboard"></i>
                </div>
                <div class="menu-box-title">Tableau de Bord</div>
            </a>
        </div>

        <!-- Section: Système -->
        <div class="section-header">
            <h2 class="section-title">Système</h2>
        </div>

        <div class="menu-grid">
            <a href="{{ route('employeList') }}" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-users"></i>
                </div>
                <div class="menu-box-title">Employés</div>
            </a>

            <a href="{{ route('teams') }}" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-users-group"></i>
                </div>
                <div class="menu-box-title">Équipes</div>
            </a>

            <a href="{{ route('candidatures.index') }}" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-file-check"></i>
                </div>
                <div class="menu-box-title">Candidatures</div>
            </a>

            <a href="{{ route('rh.index') }}" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-coin"></i>
                </div>
                <div class="menu-box-title">Gestion des Salaires</div>
            </a>

            <a href="/cras" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-file-text"></i>
                </div>
                <div class="menu-box-title">Comptes Rendus</div>
            </a>

            <a href="{{ route('rh.prestataires.index') }}" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-briefcase"></i>
                </div>
                <div class="menu-box-title">Prestataires</div>
            </a>

            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-calendar-event"></i>
                </div>
                <div class="menu-box-title">Congés</div>
            </a>

        </div>

        <!-- Section: Rapports -->
        <div class="section-header">
            <h2 class="section-title">Rapports & Analyses</h2>
        </div>

        <div class="menu-grid">
            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-chart-bar"></i>
                </div>
                <div class="menu-box-title">Statistiques</div>
            </a>

            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-file-spreadsheet"></i>
                </div>
                <div class="menu-box-title">Export Excel</div>
            </a>

            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-printer"></i>
                </div>
                <div class="menu-box-title">Documents</div>
            </a>

            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-clock-hour-4"></i>
                </div>
                <div class="menu-box-title">Pointage</div>
            </a>
        </div>

    </div>

<div class="config-container" id="configuration" style="display:none;">
    <div class="section-header">
        <h2 class="section-title">Configuration</h2>
    </div>

    <div class="menu-grid">
        <a href="#" class="menu-box">
            <div class="menu-box-icon">
                <i class="ti ti-user-cog"></i>
            </div>
            <div class="menu-box-title">Paramètres RH</div>
        </a>

        <a href="#" class="menu-box">
            <div class="menu-box-icon">
                <i class="ti ti-lock"></i>
            </div>
            <div class="menu-box-title">Paramètres de sécurité</div>
        </a>

        <a href="#" class="menu-box">
            <div class="menu-box-icon">
                <i class="ti ti-bell"></i>
            </div>
            <div class="menu-box-title">Notifications</div>
        </a>

        <a href="#" class="menu-box">
            <div class="menu-box-icon">
                <i class="ti ti-database"></i>
            </div>
            <div class="menu-box-title">Sauvegarde des données</div>
        </a>
    </div>
</div> <!-- ✅ TRÈS IMPORTANT -->


    <div class="help-container" id="help" style="display:none;" >
        <!-- Section: Aide -->
        <div class="section-header">
            <h2 class="section-title">Aide</h2>
        </div>

        <div class="menu-grid">
            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-book"></i>
                </div>
                <div class="menu-box-title">Documentation</div>
            </a>
            <a href="#" class="menu-box">
                <div class="menu-box-icon">
                    <i class="ti ti-headset"></i>
                </div>
                <div class="menu-box-title">Support Technique</div>
            </a>
        </div>
    </div>

    {{-- Script d'affichages par tab --}}

<script>
    const tabs = document.querySelectorAll('.tab-item');

    const sections = {
        application: document.getElementById('application'),
        configuration: document.getElementById('configuration'),
        help: document.getElementById('help')
    };

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();

            // Activer l’onglet cliqué
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // Cacher toutes les sections
            Object.values(sections).forEach(section => {
                if (section) section.style.display = 'none';
            });

            // Afficher la section correspondante
            const target = tab.getAttribute('href').replace('#', '');
            if (sections[target]) {
                sections[target].style.display = 'block';
            }
        });
    });
</script>



</body>
</html>