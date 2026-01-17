<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation & Aide - CRA System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
            color: white;
            padding: 0.8rem 2rem;
            box-shadow: 0 4px 20px rgba(174, 61, 125, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-title i {
            font-size: 2rem;
        }

        /* Search Bar */
        .search-container {
            position: relative;
            width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: none;
            border-radius: 25px;
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.95);
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #E46E2F;
            font-size: 1.1rem;
        }

        /* Search Results Dropdown */
        .search-results {
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            max-height: 400px;
            overflow-y: auto;
            display: none;
            z-index: 1001;
        }

        .search-results.show {
            display: block;
        }

        .search-result-item {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background: linear-gradient(90deg, rgba(174, 61, 125, 0.05) 0%, rgba(228, 110, 47, 0.05) 100%);
        }

        .search-result-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.25rem;
        }

        .search-result-section {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-result-section i {
            color: #E46E2F;
        }

        .highlight {
            background: linear-gradient(120deg, #ffeaa7 0%, #fdcb6e 100%);
            padding: 0.1rem 0.2rem;
            border-radius: 3px;
            font-weight: 600;
        }

        .no-results {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }

        /* Main Container */
        .main-container {
            display: flex;
            max-width: 1400px;
            margin: 2rem auto;
            gap: 2rem;
            padding: 0 2rem;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 120px;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-title i {
            background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }

        .nav-link:hover {
            background: linear-gradient(90deg, rgba(174, 61, 125, 0.1) 0%, rgba(228, 110, 47, 0.1) 100%);
            color: #2c3e50;
        }

        .nav-link.active {
            background: linear-gradient(90deg, #AE3D7D 0%, #E46E2F 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
        }

        /* Content Area */
        .content-area {
            flex: 1;
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .section {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid #f0f0f0;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .content-block {
            margin-bottom: 2rem;
        }

        .content-block h3 {
            color: #2c3e50;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-block h3 i {
            color: #E46E2F;
            font-size: 1.2rem;
        }

        .content-block p {
            color: #495057;
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(174, 61, 125, 0.05) 0%, rgba(228, 110, 47, 0.05) 100%);
            border-left: 4px solid #E46E2F;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h4 {
            color: #AE3D7D;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feature-card ul {
            list-style: none;
            padding-left: 0;
        }

        .feature-card li {
            padding: 0.5rem 0;
            color: #495057;
            display: flex;
            align-items: start;
            gap: 0.75rem;
        }

        .feature-card li i {
            color: #E46E2F;
            margin-top: 0.25rem;
        }

        .info-box {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1.25rem;
            margin: 1.5rem 0;
            display: flex;
            gap: 1rem;
        }

        .info-box-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-content h5 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .info-box-content p {
            color: #6c757d;
            margin: 0;
            font-size: 0.95rem;
        }

        .step-list {
            counter-reset: step-counter;
            list-style: none;
            padding-left: 0;
        }

        .step-list li {
            counter-increment: step-counter;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
        }

        .step-list li::before {
            content: counter(step-counter);
            background: linear-gradient(135deg, #AE3D7D 0%, #E46E2F 100%);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(174, 61, 125, 0.3);
        }

        /* Scrollbar */
        .search-results::-webkit-scrollbar,
        .content-area::-webkit-scrollbar {
            width: 8px;
        }

        .search-results::-webkit-scrollbar-track,
        .content-area::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .search-results::-webkit-scrollbar-thumb,
        .content-area::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #AE3D7D 0%, #E46E2F 100%);
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                padding: 0 1rem;
            }

            .sidebar {
                width: 100%;
                position: static;
            }

            .search-container {
                width: 100%;
                margin-top: 1rem;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-book-open"></i>
                <div>
                    <div>Documentation & Aide</div>
                    <div style="font-size: 0.85rem; opacity: 0.9; font-weight: 400;">Centre d'assistance d'utilisation</div>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Rechercher dans la documentation...">
                <div class="search-results" id="searchResults"></div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-title">
                <i class="fas fa-list"></i>
                Sections
            </div>
            <ul class="sidebar-nav">
                <li>
                    <a class="nav-link active" data-section="getting-started">
                        <i class="fas fa-rocket"></i>
                        <span>Premiers Pas</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" data-section="cra-management">
                        <i class="fas fa-file-alt"></i>
                        <span>Gestion des CRA</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Content Area -->
        <main class="content-area">
            <!-- Section: Premiers Pas -->
            <section class="section active" id="getting-started">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h1 class="section-title">Premiers Pas</h1>
                </div>

                <div class="content-block">
                    <h3><i class="fas fa-star"></i> Bienvenue dans le système CRA</h3>
                    <p>Le système de Compte Rendu d'Activité (CRA) vous permet de documenter facilement vos activités hebdomadaires, de suivre vos projets et de partager vos réalisations avec votre équipe.</p>
                    
                    <div class="info-box">
                        <div class="info-box-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="info-box-content">
                            <h5>Qu'est-ce qu'un CRA ?</h5>
                            <p>Un CRA (Compte Rendu d'Activité) est un document hebdomadaire qui résume vos activités, projets, réussites, difficultés et prochaines étapes. C'est un outil essentiel de communication et de suivi.</p>
                        </div>
                    </div>
                </div>

                <div class="content-block">
                    <h3><i class="fas fa-check-circle"></i> Fonctionnalités Principales</h3>
                    
                    <div class="feature-card">
                        <h4><i class="fas fa-plus-circle"></i> Créer un CRA</h4>
                        <ul>
                            <li><i class="fas fa-chevron-right"></i> Interface intuitive avec formulaire guidé</li>
                            <li><i class="fas fa-chevron-right"></i> Sélection automatique de la semaine en cours</li>
                            <li><i class="fas fa-chevron-right"></i> Association à une équipe (optionnel)</li>
                            <li><i class="fas fa-chevron-right"></i> Sauvegarde automatique des brouillons</li>
                        </ul>
                    </div>

                    <div class="feature-card">
                        <h4><i class="fas fa-edit"></i> Modifier et Suivre</h4>
                        <ul>
                            <li><i class="fas fa-chevron-right"></i> Modification possible à tout moment</li>
                            <li><i class="fas fa-chevron-right"></i> Historique complet des changements</li>
                            <li><i class="fas fa-chevron-right"></i> Indicateur de complétude en temps réel</li>
                            <li><i class="fas fa-chevron-right"></i> Export PDF professionnel</li>
                        </ul>
                    </div>
                </div>

                <div class="content-block">
                    <h3><i class="fas fa-list-ol"></i> Démarrage Rapide</h3>
                    <ol class="step-list">
                        <li>
                            <div>
                                <strong>Accédez au tableau de bord</strong>
                                <p>Connectez-vous à votre compte et accédez à la section CRA depuis le menu principal.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <strong>Créez votre premier CRA</strong>
                                <p>Cliquez sur le bouton "Nouveau CRA" et remplissez les informations de la semaine en cours.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <strong>Complétez les sections</strong>
                                <p>Documentez vos activités, points positifs, difficultés et prochaines étapes.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <strong>Soumettez votre CRA</strong>
                                <p>Une fois complété, soumettez votre CRA pour validation par votre responsable.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </section>

            <!-- Section: Gestion des CRA -->
            <section class="section" id="cra-management">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h1 class="section-title">Gestion des CRA</h1>
                </div>

                <div class="content-block">
                    <h3><i class="fas fa-folder-open"></i> Organisation des CRA</h3>
                    <p>Cette section vous guide dans l'organisation et la gestion efficace de vos comptes rendus d'activité.</p>
                    
                    <div class="info-box">
                        <div class="info-box-icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div class="info-box-content">
                            <h5>Période Recommandée</h5>
                            <p>Il est recommandé de créer un CRA par semaine, du lundi au dimanche. Le système propose automatiquement les dates de la semaine en cours.</p>
                        </div>
                    </div>
                </div>

                <div class="content-block">
                    <h3><i class="fas fa-tasks"></i> Structure d'un CRA</h3>
                    
                    <div class="feature-card">
                        <h4><i class="fas fa-clipboard-list"></i> Activités / Projets</h4>
                        <ul>
                            <li><i class="fas fa-chevron-right"></i> Listez tous vos projets actifs</li>
                            <li><i class="fas fa-chevron-right"></i> Décrivez les actions concrètes réalisées</li>
                            <li><i class="fas fa-chevron-right"></i> Mentionnez les réunions importantes</li>
                            <li><i class="fas fa-chevron-right"></i> Indiquez le temps passé sur chaque activité</li>
                        </ul>
                    </div>

                    <div class="feature-card">
                        <h4><i class="fas fa-chart-line"></i> Analyse de la Semaine</h4>
                        <ul>
                            <li><i class="fas fa-chevron-right"></i> <strong>Points positifs :</strong> Succès, objectifs atteints, bonnes pratiques</li>
                            <li><i class="fas fa-chevron-right"></i> <strong>Points négatifs :</strong> Difficultés rencontrées, obstacles, retards</li>
                            <li><i class="fas fa-chevron-right"></i> <strong>Points durs :</strong> Situations critiques nécessitant une attention particulière</li>
                            <li><i class="fas fa-chevron-right"></i> <strong>Recommandations :</strong> Suggestions d'amélioration pour l'équipe</li>
                        </ul>
                    </div>
                </div>

                <div class="content-block">
                    <h3><i class="fas fa-cog"></i> Bonnes Pratiques</h3>
                    <ol class="step-list">
                        <li>
                            <div>
                                <strong>Soyez concis et précis</strong>
                                <p>Privilégiez des phrases courtes et des informations factuelles. Utilisez des listes à puces pour améliorer la lisibilité.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <strong>Mettez à jour régulièrement</strong>
                                <p>Notez vos activités quotidiennement pour ne rien oublier. Un CRA à jour est plus précis et utile.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <strong>Anticipez les prochaines étapes</strong>
                                <p>Définissez clairement vos objectifs pour la semaine suivante avec des échéances réalistes.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <strong>Utilisez l'export PDF</strong>
                                <p>Téléchargez une version PDF de vos CRA pour les archiver ou les partager en externe.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Content searchable data
        const searchableContent = [
            { section: 'getting-started', title: 'Bienvenue dans le système CRA', content: 'Le système de Compte Rendu d\'Activité CRA vous permet de documenter facilement vos activités hebdomadaires suivre vos projets' },
            { section: 'getting-started', title: 'Créer un CRA', content: 'Interface intuitive avec formulaire guidé sélection automatique de la semaine association équipe sauvegarde automatique' },
            { section: 'getting-started', title: 'Modifier et Suivre', content: 'Modification possible tout moment historique complet changements indicateur complétude export PDF professionnel' },
            { section: 'getting-started', title: 'Accédez au tableau de bord', content: 'Connectez-vous votre compte accédez section CRA menu principal' },
            { section: 'getting-started', title: 'Créez votre premier CRA', content: 'Cliquez bouton Nouveau CRA remplissez informations semaine cours' },
            { section: 'cra-management', title: 'Organisation des CRA', content: 'Guide organisation gestion efficace comptes rendus activité' },
            { section: 'cra-management', title: 'Période Recommandée', content: 'Recommandé créer CRA semaine lundi dimanche système propose automatiquement dates' },
            { section: 'cra-management', title: 'Activités Projets', content: 'Listez projets actifs décrivez actions concrètes réalisées mentionnez réunions importantes temps passé' },
            { section: 'cra-management', title: 'Analyse de la Semaine', content: 'Points positifs succès objectifs atteints bonnes pratiques difficultés obstacles retards situations critiques recommandations' },
            { section: 'cra-management', title: 'Soyez concis et précis', content: 'Privilégiez phrases courtes informations factuelles utilisez listes puces améliorer lisibilité' },
            { section: 'cra-management', title: 'Utilisez l\'export PDF', content: 'Téléchargez version PDF CRA archiver partager externe' }
        ];

        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.section');

        // Navigation
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const sectionId = this.getAttribute('data-section');
                
                // Update active states
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                sections.forEach(s => s.classList.remove('active'));
                document.getElementById(sectionId).classList.add('active');
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Search functionality
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            
            if (query.length === 0) {
                searchResults.classList.remove('show');
                return;
            }

            const results = searchableContent.filter(item => 
                item.title.toLowerCase().includes(query) || 
                item.content.toLowerCase().includes(query)
            );

            displaySearchResults(results, query);
        });

        function displaySearchResults(results, query) {
            if (results.length === 0) {
                searchResults.innerHTML = '<div class="no-results"><i class="fas fa-search"></i><br>Aucun résultat trouvé</div>';
                searchResults.classList.add('show');
                return;
            }

            const html = results.map(result => {
                const highlightedTitle = highlightText(result.title, query);
                const sectionName = result.section === 'getting-started' ? 'Premiers Pas' : 'Gestion des CRA';
                
                return `
                    <div class="search-result-item" data-section="${result.section}">
                        <div class="search-result-title">${highlightedTitle}</div>
                        <div class="search-result-section">
                            <i class="fas fa-folder"></i>
                            ${sectionName}
                        </div>
                    </div>
                `;
            }).join('');

            searchResults.innerHTML = html;
            searchResults.classList.add('show');

            // Add click handlers
            document.querySelectorAll('.search-result-item').forEach(item => {
                item.addEventListener('click', function() {
                    const sectionId = this.getAttribute('data-section');
                    navigateToSection(sectionId);
                    searchResults.classList.remove('show');
                    searchInput.value = '';
                });
            });
        }

        function highlightText(text, query) {
            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        function navigateToSection(sectionId) {
            // Update nav
            navLinks.forEach(link => {
                if (link.getAttribute('data-section') === sectionId) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Update sections
            sections.forEach(section => {
                if (section.id === sectionId) {
                    section.classList.add('active');
                } else {
                    section.classList.remove('active');
                }
            });

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });

        // Prevent closing when clicking inside search results
        searchResults.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>

</body>
</html>