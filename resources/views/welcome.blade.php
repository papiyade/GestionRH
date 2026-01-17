<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Farlu - Gestion RH & Projets</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Figtree', sans-serif; }

        .gradient-purple { background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%); }
        .gradient-purple-soft { background: linear-gradient(135deg, #f3e5ed 0%, #f8f0f5 100%); }
        .text-purple { color: #AE3D7D; }
        .border-purple { border-color: #AE3D7D; }
        .bg-purple { background-color: #AE3D7D; }
        .hover-purple:hover { background: linear-gradient(135deg, #c24d8f 0%, #9a2065 100%); }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(174, 61, 125, 0.2);
        }
    </style>
</head>
<body class="antialiased">

    <!-- Header -->
    <header class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#accueil" class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-purple rounded-lg flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">F</span>
                    </div>
                    <span class="text-2xl font-bold text-purple">Farlu</span>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#accueil" class="text-gray-700 hover:text-purple-600 font-medium transition">Accueil</a>
                    <a href="#fonctionnalites" class="text-gray-700 hover:text-purple-600 font-medium transition">Fonctionnalités</a>
                    <a href="#a-propos" class="text-gray-700 hover:text-purple-600 font-medium transition">À propos</a>
                    <a href="#pricing" class="text-gray-700 hover:text-purple-600 font-medium transition">Offres</a>
                    <a href="#contact" class="text-gray-700 hover:text-purple-600 font-medium transition">Contact</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    <a href="{{route('login') }}" class="hidden sm:block px-6 py-2 text-purple font-semibold hover:bg-gray-100 rounded-lg transition">
                        Connexion
                    </a>
                    {{-- <a href="{{ route('register') }}" class="px-6 py-2 gradient-purple text-white font-semibold rounded-lg hover-purple transition shadow-md">
                        Inscription
                    </a> --}}
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="accueil" class="pt-32 pb-20 gradient-purple-soft">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <!-- Content -->
                <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0">
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Gestion RH et de projets
                        <span class="text-purple block mt-2">simplifiée</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Des stratégies efficaces pour optimiser la collaboration et la productivité au sein de votre équipe.
                        Découvrez nos outils pour atteindre vos objectifs avec succès.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{-- route('login') --}}" class="px-8 py-4 gradient-purple text-white font-semibold rounded-lg hover-purple transition shadow-lg text-center">
                            Commencer maintenant
                        </a>
                        <a href="#fonctionnalites" class="px-8 py-4 bg-white text-purple font-semibold rounded-lg border-2 border-purple hover:bg-gray-50 transition text-center">
                            En savoir plus
                        </a>
                    </div>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2">
                    <img src="{{asset('assets/img/capture.jpeg')}}" alt="Dashboard" class="rounded-2xl shadow-2xl animate-float">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Nos fonctionnalités
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Des outils puissants pour gérer vos projets et équipes de manière efficace
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-gray-100 card-hover">
                    <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gestion de projets</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Des outils et méthodes pour planifier, organiser et suivre vos projets de manière efficace.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-gray-100 card-hover">
                    <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gestion d'équipes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Solutions pour améliorer la collaboration, la communication et la productivité de votre équipe.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-gray-100 card-hover">
                    <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Suivi des performances</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Indicateurs clés pour évaluer les performances de votre équipe et de vos projets.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="a-propos" class="py-20 gradient-purple text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">À propos de nous</h2>
                <p class="text-xl opacity-90 max-w-3xl mx-auto">
                    Une équipe passionnée par l'innovation et la technologie, dédiée à vous fournir les meilleures solutions de gestion.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-8">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Notre Mission</h3>
                    <p class="opacity-90">
                        Fournir des outils pour planifier, organiser et suivre vos projets de manière efficace.
                    </p>
                </div>

                <div class="text-center p-8">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Notre Vision</h3>
                    <p class="opacity-90">
                        Améliorer la collaboration et la productivité grâce à des solutions innovantes.
                    </p>
                </div>

                <div class="text-center p-8">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Nos Valeurs</h3>
                    <p class="opacity-90">
                        Engagement, innovation et excellence au cœur de notre approche.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Nos Offres</h2>
                <p class="text-xl text-gray-600">Choisissez le plan qui vous convient</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Plan 1 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-gray-200 card-hover">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Mensuel</h3>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-purple">10€</span>
                        <span class="text-gray-600">/mois</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Accès à toutes les fonctionnalités
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Support 24/7
                        </li>
                    </ul>
                    <button class="w-full py-3 border-2 border-purple text-purple font-semibold rounded-lg hover:bg-purple-50 transition">
                        Souscrire
                    </button>
                </div>

                <!-- Plan 2 - Popular -->
                <div class="bg-white p-8 rounded-2xl border-2 border-purple card-hover relative">
                    <div class="absolute top-0 right-0 bg-purple text-white px-4 py-1 rounded-bl-lg rounded-tr-lg text-sm font-semibold">
                        Populaire
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Annuel</h3>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-purple">100€</span>
                        <span class="text-gray-600">/an</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Accès à toutes les fonctionnalités
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Support 24/7
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            2 mois gratuits
                        </li>
                    </ul>
                    <button class="w-full py-3 gradient-purple text-white font-semibold rounded-lg hover-purple transition">
                        Souscrire
                    </button>
                </div>

                <!-- Plan 3 -->
                <div class="bg-white p-8 rounded-2xl border-2 border-gray-200 card-hover">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Entreprise</h3>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-purple">Sur devis</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tout inclus
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Support prioritaire
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Formation incluse
                        </li>
                    </ul>
                    <button class="w-full py-3 border-2 border-purple text-purple font-semibold rounded-lg hover:bg-purple-50 transition">
                        Contactez-nous
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 gradient-purple-soft">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h2>
                <p class="text-xl text-gray-600">Nous serions ravis de vous entendre</p>
            </div>

            <form class="bg-white p-8 rounded-2xl shadow-xl">
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                    <input type="text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple focus:outline-none transition">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple focus:outline-none transition">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Message</label>
                    <textarea rows="5" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple focus:outline-none transition"></textarea>
                </div>
                <button type="submit" class="w-full py-4 gradient-purple text-white font-semibold rounded-lg hover-purple transition shadow-lg">
                    Envoyer le message
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="gradient-purple text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Farlu</h3>
                    <p class="opacity-90">Votre partenaire pour la gestion d'équipes et de projets</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="#accueil" class="opacity-90 hover:opacity-100 transition">Accueil</a></li>
                        <li><a href="#fonctionnalites" class="opacity-90 hover:opacity-100 transition">Fonctionnalités</a></li>
                        <li><a href="#a-propos" class="opacity-90 hover:opacity-100 transition">À propos</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact</h3>
                    <p class="opacity-90">contact@farlu.com</p>
                    <p class="opacity-90">+33 1 23 45 67 89</p>
                </div>
            </div>
            <div class="border-t border-white/20 pt-8 text-center opacity-90">
                © {{date('Y')}} Farlu. Tous droits réservés.
            </div>
        </div>
    </footer>

    <!-- Scroll to top button -->
    <button id="scrollTop" class="fixed bottom-8 right-8 w-12 h-12 gradient-purple text-white rounded-full shadow-lg hover-purple transition hidden">
        <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
        </svg>
    </button>

    <script>
        const scrollTop = document.getElementById('scrollTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTop.classList.remove('hidden');
            } else {
                scrollTop.classList.add('hidden');
            }
        });
        scrollTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>
