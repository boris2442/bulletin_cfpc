<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AcademicaPro | Gestion Académique Simplifiée</title>


    
<link rel="icon" type="image/jpg" href="{{ asset('images/logo.jpg') }}">
<link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">


<meta name="description" content="Academia+ est la plateforme leader de gestion académique au Cameroun. Suivi des performances, relevés de notes officiels, analytics en temps réel et gestion des effectifs pour établissements d'enseignement supérieur.">
<meta name="keywords" content="gestion scolaire Cameroun, logiciel académique, relevé de notes Cameroun, analytics étudiant, suivi pédagogique, Academia+, plateforme éducation, MINESUP Cameroun">
<meta name="author" content="Ton Nom ou Nom de ton Entreprise">
<meta name="robots" content="index, follow">

<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="Academia+ | Système de Gestion Académique Intégré">
<meta property="og:description" content="Optimisez la gestion de votre établissement : Relevés de notes, statistiques de réussite et suivi des enseignants.">
<meta property="og:image" content="{{ asset('images/logo.jpg') }}">

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="Academia+ | Analytics Académiques">
<meta property="twitter:description" content="Visualisez les performances de votre institution en un clin d'œil.">


    {{-- <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}"> --}}
    
    <style>
        .dark-mode-transition {
            transition: background-color 0.3s, color 0.3s;
        }

        /* Empêcher le scroll horizontal global */
        body { overflow-x: hidden; }
    </style>
    
    <script>
        // Script initial pour éviter le flash de contenu non stylisé (FOUC)
        const rootHtml = document.documentElement;
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            rootHtml.classList.add('dark');
        } else {
            rootHtml.classList.remove('dark');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            
            // Mise à jour de l'icône au chargement
            if (rootHtml.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                // Ajout temporaire de la transition
                rootHtml.classList.add('dark-mode-transition');
                
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                rootHtml.classList.toggle('dark');
                
                if (rootHtml.classList.contains('dark')) {
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    localStorage.setItem('color-theme', 'light');
                }

                // Retirer la transition après un court délai
                setTimeout(() => {
                    rootHtml.classList.remove('dark-mode-transition');
                }, 300);
            });
        });
    </script>
      <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'])
      
        @endif
</head>

<body class="dark-mode-transition dark:bg-gray-900 font-sans antialiased text-gray-800 dark:text-gray-200">

    <div class="min-h-screen flex flex-col justify-between">

       
        

<header class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-md relative z-50">
    <div class="container mx-auto flex justify-between items-center">
        {{-- Logo --}}
        <a href="/" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 flex-shrink-0">
            🎓 AcademicaPro
        </a>
        
        <div class="flex items-center space-x-3">
            {{-- Bouton Dark Mode (Toujours visible) --}}
            <button id="theme-toggle-btn" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2.5 transition">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.068A8.999 8.001 0 017 3.707a8.999 8.999 0 1013.586 10.957.5.5 0 00-.293-.016z"></path></svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM6.591 4.591a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zM4.591 13.409a1 1 0 101.414 1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zM13.409 15.409a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.409 6.591a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707z" /></svg>
            </button>

            {{-- NAVIGATION DESKTOP --}}
            <nav class="hidden md:flex items-center space-x-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600 dark:text-gray-300 font-medium hover:text-indigo-600 transition">Tableau de Bord</a>
                        
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="flex items-center text-red-600 dark:text-red-400 font-bold hover:opacity-80 transition">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Quitter
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-medium">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="py-2 px-5 bg-indigo-600 text-white rounded-lg font-medium shadow-sm hover:bg-indigo-700 transition">Inscription</a>
                        @endif
                    @endauth
                @endif
            </nav>

            {{-- BOUTON MENU MOBILE --}}
            <button id="mobile-menu-button" class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM18 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </button>
        </div>
    </div>

    {{-- MENU MOBILE DÉROULANT --}}
    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-white dark:bg-gray-800 shadow-2xl border-t dark:border-gray-700">
        <div class="flex flex-col p-5 space-y-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block text-lg text-gray-700 dark:text-gray-200 font-medium">Tableau de Bord</a>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="flex items-center text-red-600 dark:text-red-400 font-bold py-2">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Déconnexion
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block text-lg text-gray-700 dark:text-gray-200 font-medium py-2">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full text-center py-4 bg-indigo-600 text-white rounded-xl font-bold shadow-lg">Créer un compte</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    {{-- FORMULAIRE DÉCONNEXION (Obligatoire pour Laravel) --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</header>





        {{-- Section Principale (Hero) --}}
        <main class="flex-grow flex items-center flex-col">
  
      <section>
            <div class=" mx-auto px-4  sm:py-24 text-center pb-0">
                
                <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight mb-4">
                    La <span class="text-indigo-600 dark:text-indigo-400">Gestion Académique</span> Simplifiée.
                </h1>
                
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-10">
                    Optimisez chaque étape de votre année scolaire, de l'inscription des étudiants à la génération des bilans de compétences. Un seul outil, une clarté totale.
                </p>
                
                <div class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                            Accéder au Tableau de Bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                            Commencer maintenant
                        </a>
                    @endauth
                </div>

                {{-- Illustration simple --}}
                {{-- <div class="mt-12 opacity-90 max-w-5xl mx-auto">
                    
                </div> --}}

            </div>
        </section>



            {{-- Section Fonctionnalités --}}
<section class=" dark:bg-gray-900 ">
    <div class="container mx-auto px-4">

        <!-- Titre -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                Tout ce qu’il faut pour gérer vos évaluations
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Une suite complète d’outils pédagogiques pensée pour les administrateurs,
                les enseignants et les étudiants.
            </p>
        </div>

        <!-- Grille des fonctionnalités -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Gestion Structurelle -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                    Gestion Structurelle
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Configuration aisée des années académiques, spécialités et modules,
                    avec gestion des coefficients et des semestres (S1 / S2).
                </p>
            </div>

            <!-- Saisie Intelligente -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                    Saisie Intelligente
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Saisie simple ou multiple des notes par module ou spécialité,
                    avec calcul en temps réel des moyennes pondérées.
                </p>
            </div>

            <!-- Relevés & Bilans PDF -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                    Relevés & Bilans PDF
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Génération automatique de relevés de notes officiels et
                    de bilans de compétences prêts à imprimer.
                </p>
            </div>

            <!-- Mode Compétences -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                    Mode Compétences
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Approche moderne combinant notes chiffrées (30 %)
                    et compétences transversales (70 %) pour une évaluation équilibrée.
                </p>
            </div>

            <!-- Statistiques & Dashboard -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                    Statistiques & Dashboard
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Tableaux de bord interactifs avec Chart.js pour analyser
                    les performances, classements et taux de réussite.
                </p>
            </div>

            <!-- Gestion des Rôles -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                    Gestion des Rôles
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Séparation stricte des droits :
                    Administrateur, Manager et Étudiant,
                    pour une sécurité et une clarté maximales.
                </p>
            </div>

        </div>
    </div>
</section>

        </main>

        {{-- Footer --}}
    <footer class="border-t bg-white p-4 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
    &copy; {{ date('Y') }} AcademicaPro. Tous droits réservés. |
    Propulsé avec ❤️ par
    <a
        href="https://borisaubin.vercel.app"
        target="_blank"
        rel="noopener"
        class="group font-semibold text-[var(--primary-blue)] transition-all duration-300 hover:text-[var(--dark-gold)] underline-flex"
    >
        Aubin Boris Simo
        <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1">
            →
        </span>
    </a>
</footer>

    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });

    // Fermer le menu si on clique ailleurs sur l'écran
    window.addEventListener('click', function(e) {
        if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
});
</script>
    </body>
</html>
