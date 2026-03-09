<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AcademicaPro | Gestion Académique Simplifiée</title>

    <link rel="icon" type="image/jpg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">

    <meta name="description"
        content="Academia+ est la plateforme leader de gestion académique au Cameroun. Suivi des performances, relevés de notes officiels, analytics en temps réel et gestion des effectifs pour établissements d'enseignement supérieur.">
    <meta name="keywords"
        content="gestion scolaire Cameroun, logiciel académique, relevé de notes Cameroun, analytics étudiant, suivi pédagogique, Academia+, plateforme éducation, MINESUP Cameroun">
    <meta name="author" content="Aubin Boris Simo">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Academia+ | Système de Gestion Académique Intégré">
    <meta property="og:description"
        content="Optimisez la gestion de votre établissement : Relevés de notes, statistiques de réussite et suivi des enseignants.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="Academia+ | Analytics Académiques">
    <meta property="twitter:description" content="Visualisez les performances de votre institution en un clin d'œil.">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])
    @endif

    <style>
        /* Animations personnalisées */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        /* Classes d'animation */
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }

        .animate-slide-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-slide-right {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .animate-scale {
            animation: scaleIn 0.6s ease-out forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-100 {
            animation-delay: 100ms;
        }

        .animation-delay-200 {
            animation-delay: 200ms;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        .animation-delay-400 {
            animation-delay: 400ms;
        }

        .animation-delay-500 {
            animation-delay: 500ms;
        }

        .animation-delay-600 {
            animation-delay: 600ms;
        }

        .animation-delay-700 {
            animation-delay: 700ms;
        }

        .animation-delay-800 {
            animation-delay: 800ms;
        }

        .animation-delay-900 {
            animation-delay: 900ms;
        }

        .animation-delay-1000 {
            animation-delay: 1000ms;
        }

        .animation-delay-2000 {
            animation-delay: 2000ms;
        }

        .animation-delay-4000 {
            animation-delay: 4000ms;
        }

        /* Effet de verre */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Effet de gradient animé */
        .animated-gradient {
            background: linear-gradient(-45deg, #4f46e5, #7c3aed, #2563eb, #4f46e5);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Effet de brillance */
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }

        .dark .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            background-size: 1000px 100%;
        }

        /* Empêcher le scroll horizontal global */
        body {
            overflow-x: hidden;
        }

        /* État initial des éléments animés */
        .fade-in-on-load,
        .slide-up-on-load,
        .slide-left-on-load,
        .slide-right-on-load,
        .scale-on-load {
            opacity: 0;
        }

        /* Style pour l'image du dashboard */
        .dashboard-preview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            padding: 4px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .dashboard-preview-inner {
            background: white;
            border-radius: 20px;
            padding: 20px;
        }

        .dark .dashboard-preview-inner {
            background: #1f2937;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .floating-element {
            position: absolute;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        // 1. Gestion du Dark Mode (S'exécute immédiatement pour éviter le flash blanc)
        const rootHtml = document.documentElement;
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            rootHtml.classList.add('dark');
        } else {
            rootHtml.classList.remove('dark');
        }

        // 2. Initialisation des interactions après le chargement du HTML
        document.addEventListener('DOMContentLoaded', function() {

            // --- GESTION DU DARK MODE (Bouton) ---
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (themeToggleBtn) {
                // Mise à jour de l'icône au chargement
                if (rootHtml.classList.contains('dark')) {
                    themeToggleLightIcon?.classList.remove('hidden');
                } else {
                    themeToggleDarkIcon?.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', function() {
                    rootHtml.classList.add('dark-mode-transition');
                    themeToggleDarkIcon?.classList.toggle('hidden');
                    themeToggleLightIcon?.classList.toggle('hidden');
                    rootHtml.classList.toggle('dark');

                    localStorage.setItem('color-theme', rootHtml.classList.contains('dark') ? 'dark' :
                        'light');

                    setTimeout(() => rootHtml.classList.remove('dark-mode-transition'), 300);
                });
            }

            // --- GESTION DU MENU MOBILE ---
            const mobileMenuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }

            // --- AJOUT DES CLASSES D'ANIMATION AU SCROLL ---
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-animate').forEach(el => {
                observer.observe(el);
            });

            // Appliquer les animations initiales
            document.querySelector('.slide-left-on-load')?.classList.add('animate-slide-left');
            document.querySelector('.slide-right-on-load')?.classList.add('animate-slide-right');
            document.querySelector('.slide-up-on-load')?.classList.add('animate-slide-up');
        });
    </script>
</head>

<body
    class="dark-mode-transition dark:bg-gray-900 font-sans antialiased text-gray-800 dark:text-gray-200 overflow-x-hidden relative">
    <div id="particles-js" class="absolute top-0 left-0 w-full h-full"></div>
    <!-- Particules d'arrière-plan -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div
            class="absolute top-20 left-10 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute bottom-20 right-10 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute top-40 right-40 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="min-h-screen flex flex-col relative z-10">

        {{-- HEADER OPTIMISÉ AVEC ANIMATION --}}
        <header
            class="py-3 px-4 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b dark:border-gray-700 glass-effect">
            <div class="container mx-auto flex justify-between items-center">
                {{-- Logo avec animation --}}
                <a href="/"
                    class="text-xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight group">
                    <span class="flex items-center space-x-2">
                        <span
                            class="w-8 h-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white text-sm">AP</span>
                        <span
                            class="text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors duration-300">Academica<span
                                class="text-indigo-600">Pro</span></span>
                    </span>
                </a>

                <div class="flex items-center space-x-4">
                    {{-- NAVIGATION DESKTOP --}}
                    <nav class="hidden md:flex items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-sm font-semibold text-indigo-600 transition hover:scale-105 transform duration-200 relative group">
                                    Dashboard
                                    <span
                                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                                </a>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-sm font-bold text-red-500 hover:text-red-600 transition flex items-center hover:scale-105 transform duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Quitter
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition hover:scale-105 transform duration-200 relative group">
                                    Connexion
                                    <span
                                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                                </a>
                                {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="py-2 px-5 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-indigo-700 transition hover:scale-105 transform duration-200 hover:shadow-xl">
                                        Inscription
                                    </a>
                                @endif --}}
                            @endauth
                        @endif
                    </nav>

                    {{-- Theme Toggle --}}
                    <button id="theme-toggle-btn"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:ring-2 ring-indigo-500 transition hover:rotate-12 duration-300">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M17.293 13.068A8.999 8.001 0 017 3.707a8.999 8.999 0 1013.586 10.957.5.5 0 00-.293-.016z">
                            </path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM6.591 4.591a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zM4.591 13.409a1 1 0 101.414 1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zM13.409 15.409a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.409 6.591a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707z" />
                        </svg>
                    </button>

                    <button id="mobile-menu-button"
                        class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        {{-- MENU MOBILE AVEC ANIMATION --}}
        <div id="mobile-menu"
            class="hidden md:hidden absolute top-[64px] left-0 w-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-b dark:border-gray-700 px-6 py-8 space-y-6 shadow-2xl z-40 transform transition-all duration-300">
            @if (Route::has('login'))
                <nav class="flex flex-col space-y-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 hover:translate-x-2 transition-transform duration-200">Tableau
                            de bord</a>
                        <div class="h-px bg-gray-100 dark:bg-gray-800"></div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-lg font-semibold text-red-500 flex items-center hover:translate-x-2 transition-transform duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Déconnexion
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-lg font-medium text-gray-700 dark:text-gray-200 hover:translate-x-2 transition-transform duration-200">Connexion</a>
                        {{-- <a href="{{ route('register') }}"
                            class="w-full py-4 bg-indigo-600 text-white rounded-xl text-center font-bold shadow-lg shadow-indigo-200 dark:shadow-none transition hover:scale-105 transform duration-200">
                            Créer un compte
                        </a> --}}
                    @endauth
                </nav>
            @endif
        </div>

        <main class="flex-grow">
            {{-- HERO SECTION AVEC IMAGE À DROITE --}}
            <section class="pt-16 md:py-24 px-4 md:px-8 pb-12">
                <div class="container mx-auto">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        {{-- Left Content --}}
                        <div>


                            <h1
                                class="slide-left-on-load text-4xl md:text-6xl font-black text-gray-900 dark:text-white leading-tight mb-6">

                                La <span class="text-indigo-600" id="typewriter"></span><br>
                                enfin simplifiée.

                            </h1>
                            <p class="mt-4 text-gray-600 dark:text-gray-400         ">
                                Optimisez chaque étape de votre année scolaire, de l'inscription à la génération des
                                bilans de compétences avec une précision chirurgicale.

                            </p>

                            <p class="mt-4 text-gray-600 dark:text-gray-400         ">
                                Suivi en temps réel, analytics avancés et gestion des effectifs n'ont jamais été aussi
                                simples à maîtriser.

                            </p>

                            {{-- Features mini cards --}}
                            <div class="slide-left-on-load animation-delay-400 grid grid-cols-2 gap-4 mb-10">
                                <div
                                    class="flex items-center space-x-2 p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105">
                                    <div
                                        class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium">Suivi en temps réel</span>
                                </div>
                                <div
                                    class="flex items-center space-x-2 p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105">
                                    <div
                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium">Analytics avancés</span>
                                </div>
                            </div>

                            <div class="slide-left-on-load animation-delay-600 flex flex-wrap gap-4">
                                <a href="#"
                                    class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition transform hover:-translate-y-2 hover:shadow-xl duration-300">
                                    Commencer maintenant
                                    <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition transform hover:-translate-y-2 duration-300">
                                    Demander une démo
                                </a>
                            </div>
                        </div>

                        {{-- Right Content - Image/Dashboard Preview --}}
                        <div class="slide-right-on-load relative">
                            <!-- Dashboard Preview Card -->
                            <div class="dashboard-preview">
                                <div class="dashboard-preview-inner">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg">
                                            </div>
                                            <span class="font-semibold dark:text-white">Tableau de bord</span>
                                        </div>
                                        <div class="flex space-x-1">
                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        </div>
                                    </div>

                                    <!-- Stats Cards -->
                                    <div class="grid grid-cols-3 gap-3 mb-6">
                                        <div class="stat-card p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                            <div class="text-xs text-yellow-600 dark:text-yellow-400">Étudiants</div>
                                            <div class="text-xl font-bold text-yellow-700 dark:text-yellow-300">2,450
                                            </div>
                                            <div class="text-[10px] text-yellow-600 dark:text-yellow-400">+12%</div>
                                        </div>
                                        <div class="stat-card p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                            <div class="text-xs text-blue-600 dark:text-blue-400">Cours</div>
                                            <div class="text-xl font-bold text-blue-700 dark:text-blue-300">128</div>
                                            <div class="text-[10px] text-blue-600 dark:text-blue-400">+5%</div>
                                        </div>
                                        <div class="stat-card p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                            <div class="text-xs text-green-600 dark:text-green-400">Réussite</div>
                                            <div class="text-xl font-bold text-green-700 dark:text-green-300">94%</div>
                                            <div class="text-[10px] text-green-600 dark:text-green-400">+8%</div>
                                        </div>
                                    </div>

                                    <!-- Activity Graph -->
                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-xs font-semibold dark:text-white">Performance
                                                académique</span>
                                            <span class="text-xs text-indigo-600">Ce semestre</span>
                                        </div>
                                        <div class="flex items-end space-x-1 h-24">
                                            <div class="flex-1 bg-indigo-200 dark:bg-indigo-900/30 rounded-t-lg h-16 hover:bg-indigo-300 transition-all duration-300"
                                                style="height: 40%"></div>
                                            <div class="flex-1 bg-indigo-300 dark:bg-indigo-800/40 rounded-t-lg h-20 hover:bg-indigo-400 transition-all duration-300"
                                                style="height: 55%"></div>
                                            <div class="flex-1 bg-indigo-400 dark:bg-indigo-700/50 rounded-t-lg h-24 hover:bg-indigo-500 transition-all duration-300"
                                                style="height: 70%"></div>
                                            <div class="flex-1 bg-indigo-500 dark:bg-indigo-600/60 rounded-t-lg h-28 hover:bg-indigo-600 transition-all duration-300"
                                                style="height: 85%"></div>
                                            <div class="flex-1 bg-indigo-600 rounded-t-lg h-32 hover:bg-indigo-700 transition-all duration-300"
                                                style="height: 100%"></div>
                                            <div class="flex-1 bg-indigo-500 dark:bg-indigo-600/60 rounded-t-lg h-28 hover:bg-indigo-600 transition-all duration-300"
                                                style="height: 80%"></div>
                                            <div class="flex-1 bg-indigo-400 dark:bg-indigo-700/50 rounded-t-lg h-24 hover:bg-indigo-500 transition-all duration-300"
                                                style="height: 65%"></div>
                                        </div>
                                    </div>

                                    <!-- Activity List -->
                                    <div class="space-y-2">
                                        <div
                                            class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                                                <div>
                                                    <div class="text-xs font-medium dark:text-white">Martin Simo</div>
                                                    <div class="text-[10px] text-gray-500">Mathématiques</div>
                                                </div>
                                            </div>
                                            <span
                                                class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-bold rounded-full">18/20</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                                                <div>
                                                    <div class="text-xs font-medium dark:text-white">Marie Lienou</div>
                                                    <div class="text-[10px] text-gray-500">Physique</div>
                                                </div>
                                            </div>
                                            <span
                                                class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-bold rounded-full">16/20</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                                                <div>
                                                    <div class="text-xs font-medium dark:text-white">Pierre Rostand
                                                    </div>
                                                    <div class="text-[10px] text-gray-500">Informatique</div>
                                                </div>
                                            </div>
                                            <span
                                                class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 text-[10px] font-bold rounded-full">14/20</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Elements -->
                            <div
                                class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl rotate-12 shadow-xl animate-float floating-element">
                            </div>
                            <div
                                class="absolute -bottom-4 -left-4 w-20 h-20 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl -rotate-12 shadow-xl animate-float animation-delay-1000 floating-element">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- STATS BANNER --}}
            <section class="scroll-animate py-12  ">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="p-4 dark:bg-[#EEF2FF] rounded-2xl border dark:border-gray-700">
                            <div class="text-3xl md:text-4xl font-black text-indigo-600 dark:text-indigo-400">50+</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Établissements</div>
                        </div>
                        <div class="p-4 dark:bg-[#EEF2FF] rounded-2xl border dark:border-gray-700">
                            <div class="text-3xl md:text-4xl font-black text-indigo-600 dark:text-indigo-400">10k+
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Étudiants</div>
                        </div>
                        <div class="p-4 dark:bg-[#EEF2FF] rounded-2xl border dark:border-gray-700">
                            <div class="text-3xl md:text-4xl font-black text-indigo-600 dark:text-indigo-400">500+
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Enseignants</div>
                        </div>
                        <div class="p-4 dark:bg-[#EEF2FF] rounded-2xl border dark:border-gray-700">
                            <div class="text-3xl md:text-4xl font-black text-indigo-600 dark:text-indigo-400">98%</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Satisfaction</div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- FORMULE DE CALCUL --}}
            <section class="scroll-animate py-16 container mx-auto px-4">
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border dark:border-gray-700 flex flex-col lg:flex-row transform transition-all duration-500 hover:shadow-2xl">
                    <div class="lg:w-1/2 p-10">
                        <h2 class="text-3xl font-bold mb-6">Calcul Automatique & Équitable</h2>
                        <div class="space-y-6">
                            <div
                                class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                <div
                                    class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4 animate-pulse-slow">
                                    1</div>
                                <div>
                                    <h4 class="font-bold">Moyennes Semestrielles</h4>
                                    <p class="text-sm text-gray-500 italic">∑ (Note × Coeff) / ∑ Coeff</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                <div
                                    class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4 animate-pulse-slow animation-delay-200">
                                    2</div>
                                <div>
                                    <h4 class="font-bold">Moyenne Annuelle</h4>
                                    <p class="text-sm text-gray-500 italic">(S1 + S2) / 2</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                <div
                                    class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4 animate-pulse-slow animation-delay-400">
                                    3</div>
                                <div>
                                    <h4 class="font-bold text-indigo-700 dark:text-indigo-400">Décision Finale</h4>
                                    <p class="text-sm">(Moy. × 30%) + (Comp. × 70%)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="lg:w-1/2 dark:bg-gray-900/50 p-10 flex flex-col justify-center border-l dark:border-gray-700">
                        <div class="space-y-6 mb-8">
                            <div>
                                <div
                                    class="flex justify-between text-xs font-bold mb-2 uppercase tracking-widest text-gray-500">
                                    Évaluations (30%)</div>
                                <div class="w-full dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-indigo-600 h-2 rounded-full shimmer" style="width: 30%"></div>
                                </div>
                            </div>
                            <div>
                                <div
                                    class="flex justify-between text-xs font-bold mb-2 uppercase tracking-widest text-gray-500">
                                    Compétences (70%)</div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-indigo-500 h-2 rounded-full shimmer" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-inner border dark:border-gray-700 text-center transform transition-all duration-300 hover:scale-105">
                            <p class="text-xs font-bold text-gray-400 mb-4 uppercase">Mentions Automatiques</p>
                            <div class="grid grid-cols-2 gap-2 text-[11px] font-bold">
                                <div
                                    class="p-2 bg-green-50 dark:bg-green-900/20 text-green-700 rounded-lg hover:bg-green-100 transition">
                                    ≥ 16 Très Bien</div>
                                <div
                                    class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                                    ≥ 14 Bien</div>
                                <div
                                    class="p-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 rounded-lg hover:bg-indigo-100 transition">
                                    ≥ 12 Assez Bien</div>
                                <div
                                    class="p-2 bg-orange-50 dark:bg-orange-900/20 text-orange-700 rounded-lg hover:bg-orange-100 transition">
                                    ≥ 10 Passable</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- FONCTIONNALITÉS GRID --}}
            <section class="scroll-animate py-12 bg-white dark:bg-gray-900">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-2xl mx-auto mb-10">
                        <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                            Écosystème Pédagogique
                        </h2>
                        <p class="text-sm text-gray-500 mt-2">Une infrastructure logicielle robuste pour vos données
                            académiques.</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-5">

                        {{-- Feature 1: Analytics --}}
                        <div
                            class="group p-6 dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-indigo-500/30 transition-all duration-300 shadow-sm hover:shadow-xl transform hover:-translate-y-2">
                            <div
                                class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-200 dark:shadow-none group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Analyse de Performance
                            </h3>
                            <p class="text-gray-500 text-xs leading-relaxed">Suivi analytique pour visualiser les taux
                                de réussite et les moyennes par promotion en un coup d'œil.</p>
                        </div>

                        {{-- Feature 2: Automation --}}
                        <div
                            class="group p-6 dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-indigo-500/30 transition-all duration-300 shadow-sm hover:shadow-xl transform hover:-translate-y-2">
                            <div
                                class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-200 dark:shadow-none group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Calcul Automatisé</h3>
                            <p class="text-gray-500 text-xs leading-relaxed">Algorithme de calcul pondéré (30/70)
                                éliminant les erreurs humaines lors de la génération des bilans.</p>
                        </div>

                        {{-- Feature 3: Security --}}
                        <div
                            class="group p-6 dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-indigo-500/30 transition-all duration-300 shadow-sm hover:shadow-xl transform hover:-translate-y-2">
                            <div
                                class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-200 dark:shadow-none group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Accès Sécurisé</h3>
                            <p class="text-gray-500 text-xs leading-relaxed">Gestion granulaire des rôles (Admin,
                                Manager, Étudiant) assurant l'intégrité des données.</p>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <footer class="scroll-animate bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col items-center text-center">

                    {{-- Branding --}}
                    <div class="mb-6 transform hover:scale-110 transition-transform duration-300">
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">
                            AcademicaPro
                        </h2>
                        <div class="h-1 w-8 bg-indigo-600 mx-auto mt-1 rounded-full"></div>
                    </div>

                    {{-- Mentions Légales --}}
                    <div class="mb-8">
                        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">
                            Système de Gestion Académique &bull; &copy; 2026
                        </p>
                        <p class="text-[10px] text-gray-400 mt-1 italic">
                            Tous droits réservés.
                        </p>
                    </div>

                    {{-- Signature Professionnelle & SEO --}}
                    <div
                        class="inline-flex items-center gap-3 px-5 py-2.5 bg-gray-50 dark:bg-gray-900/50 rounded-full border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-md hover:scale-105 transform duration-300">
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">
                            Propulsé avec amour ❤️ par
                            <span class="font-bold text-indigo-600 dark:text-indigo-400 ml-1">
                                <a href="https://borisaubin.vercel.app" target="_blank"
                                    class="hover:text-indigo-700 transition">Aubin Boris Simo</a>
                            </span>
                        </span>
                    </div>

                </div>
            </div>
        </footer>
    </div>

    {{-- Formulaire de déconnexion invisible --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>


    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 200
                },
                color: {
                    value: "#6366f1"
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.5
                },
                size: {
                    value: 3
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#6366f1",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 3
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    }
                }
            },
            retina_detect: true
        });
    </script>
</body>

</html>
