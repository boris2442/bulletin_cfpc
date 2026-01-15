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

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M8 10h.01"></path><path d="M16 10h.01"></path><path d="M8 14h.01"></path><path d="M16 14h.01"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">Gestion Structurelle</h3>
        <p class="text-gray-600 dark:text-gray-300">
            Configuration aisée des années académiques, spécialités et modules, avec gestion des coefficients et des semestres (S1 / S2).
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="M9 14h.01"></path><path d="M9 18h.01"></path><path d="M12 14h.01"></path><path d="M12 18h.01"></path><path d="M15 14h.01"></path><path d="M15 18h.01"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">Saisie Intelligente</h3>
        <p class="text-gray-600 dark:text-gray-300">
            Saisie simple ou multiple des notes par module ou spécialité, avec calcul en temps réel des moyennes pondérées.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">Relevés & Bilans PDF</h3>
        <p class="text-gray-600 dark:text-gray-300">
            Génération automatique de relevés de notes officiels et de bilans de compétences prêts à imprimer.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">Mode Compétences</h3>
        <p class="text-gray-600 dark:text-gray-300">
            Approche moderne combinant notes chiffrées (30 %) et compétences transversales (70 %) pour une évaluation équilibrée.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">Statistiques & Dashboard</h3>
        <p class="text-gray-600 dark:text-gray-300">
            Tableaux de bord interactifs avec Chart.js pour analyser les performances, classements et taux de réussite.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">Gestion des Rôles</h3>
        <p class="text-gray-600 dark:text-gray-300">
            Séparation stricte des droits : Administrateur, Manager et Étudiant, pour une sécurité et une clarté maximales.
        </p>
    </div>

</div>
    </div>
</section>

<section class="max-w-6xl mx-auto my-16 bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
    <div class="flex flex-col lg:flex-row">
        
        <div class="lg:w-1/2 p-8 lg:p-12">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">
                Calcul Automatique & Équitable
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mb-10 leading-relaxed">
                Notre système prend en charge la complexité du calcul des moyennes académiques selon la formule standardisée de l'établissement (30% Évaluations / 70% Compétences).
            </p>

            <div class="space-y-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg">
                        1
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Moyennes Semestrielles</h4>
                        <p class="text-gray-500 text-sm italic">Calcul pondéré : $\sum (\text{Note} \times \text{Coeff}) / \sum \text{Coeff}$</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg">
                        2
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Moyenne Annuelle</h4>
                        <p class="text-gray-500 text-sm italic">Moyenne des deux semestres $(S1 + S2) / 2$</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg">
                        3
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Décision Finale</h4>
                        <p class="text-gray-500 text-sm italic">$(\text{Moyenne Annuelle} \times 30\%) + (\text{Compétences} \times 70\%)$</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:w-1/2 bg-gray-700 dark:bg-gray-900/50 p-8 lg:p-12 flex flex-col justify-center border-l border-gray-100 dark:border-gray-700">
            
            <div class="space-y-6 mb-12">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Évaluations</span>
                        <span class="text-sm font-bold text-indigo-600">30%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-indigo-600 h-3 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Compétences</span>
                        <span class="text-sm font-bold text-indigo-600">70%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-indigo-600 h-3 rounded-full" style="width: 70%"></div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mb-6 flex items-center justify-center gap-2">
                    <span class="text-gray-400 text-xl">=</span> Moyenne Générale
                </h3>
                
                <div class="border-2 border-indigo-200 dark:border-indigo-800 rounded-2xl p-6 bg-white dark:bg-gray-800 shadow-sm">
                    <p class="text-gray-400 text-xs uppercase font-semibold mb-4">Attribution Automatique</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-[10px] md:text-xs font-bold">
                        <div class="text-indigo-900 dark:text-indigo-200">≥ 16 <br> Très Bien</div>
                        <div class="text-indigo-700 dark:text-indigo-300">≥ 14 <br> Bien</div>
                        <div class="text-indigo-500 dark:text-indigo-400">≥ 12 <br> Assez Bien</div>
                        <div class="text-orange-500">≥ 10 <br> Passable</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto py-16 px-4">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Spécialités Agréées </h2>
        <p class="text-gray-500 dark:text-gray-400">Découvrez nos  spécialités professionnelles reconnues</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Secrétariat Bureautique</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> 3è / BEPC / CAP / GCE O Level</p>
                    <p class="mt-3 leading-relaxed text-xs">Formation aux outils bureautiques, gestion administrative et communication professionnelle.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1090 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Comptabilité Informatisée</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> Terminale / Upper Sixth</p>
                    <p class="mt-3 leading-relaxed text-xs">Utilisation de logiciels comptables, gestion financière et analyse.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1220 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Webmestre</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> BAC / GCE A Level</p>
                    <p class="mt-3 leading-relaxed text-xs">Création, maintenance et gestion de sites web et applications.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1270 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Secrétariat de Direction</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> BAC / GCE A Level</p>
                    <p class="mt-3 leading-relaxed text-xs">Support aux cadres supérieurs, organisation et communication.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1440 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Secrétariat Comptable</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> Première / Lower Sixth</p>
                    <p class="mt-3 leading-relaxed text-xs">Combinaison de secrétariat et comptabilité informatisée.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1530 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Maintenance Informatique</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> Première / Lower Sixth</p>
                    <p class="mt-3 leading-relaxed text-xs">Diagnostic et réparation des systèmes informatiques.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">920 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Développement d'Application</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> BAC / GCE A Level</p>
                    <p class="mt-3 leading-relaxed text-xs">Conception et développement d'applications web et mobiles.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1170 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Graphisme de Production</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> Terminale / Upper Sixth</p>
                    <p class="mt-3 leading-relaxed text-xs">Conception graphique, création de supports visuels et impression.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">990 heures</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 3v8h8a9.836 9.836 0 00-1.242-4.827" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Maintenance des Réseaux</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <p><span class="font-bold">Durée:</span> 12 mois</p>
                    <p><span class="font-bold">Accès:</span> Terminale / Upper Sixth</p>
                    <p class="mt-3 leading-relaxed text-xs">Configuration, sécurité et maintenance des réseaux informatiques.</p>
                </div>
            </div>
            <div class="text-red-500 font-bold text-sm border-t border-gray-50 dark:border-gray-700 pt-3">1100 heures</div>
        </div>

    </div>
</section>

<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-10">
            Propulsé par des technologies modernes
        </p>
        
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70 hover:opacity-100 transition-opacity">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#FF2D20" xmlns="http://www.w3.org/2000/svg"><path d="M22.845 5.86l-8.991-3.14a1.2 1.2 0 00-1.201.127l-2.012 1.545a1.2 1.2 0 00-.472.956v11.905c0 .385.185.748.497.973l2.012 1.454a1.2 1.2 0 001.201.037l8.991-4.851a1.2 1.2 0 00.672-1.08V6.94a1.2 1.2 0 00-.707-1.08z"/></svg>
                <span class="text-xl font-bold text-gray-700 dark:text-gray-200">Laravel 12</span>
            </div>

            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#00758F" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.477 2 2 5.582 2 10c0 4.418 4.477 8 10 8s10-3.582 10-8c0-4.418-4.477-8-10-8z"/></svg>
                <span class="text-xl font-bold text-gray-700 dark:text-gray-200">MySQL</span>
            </div>

            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#38B2AC" xmlns="http://www.w3.org/2000/svg"><path d="M12 6.036c-2.667 0-4 1.333-4 4s1.333 4 4 4 4-1.333 4-4-1.333-4-4-4zm0 10c-2.667 0-4 1.333-4 4s1.333 4 4 4 4-1.333 4-4-1.333-4-4-4z"/></svg>
                <span class="text-xl font-bold text-gray-700 dark:text-gray-200">Tailwind CSS</span>
            </div>

            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#FF6384" xmlns="http://www.w3.org/2000/svg"><path d="M21 21H3V3h2v16h16v2zM7 15h2v2H7v-2zm4-4h2v6h-2v-6zm4-4h2v10h-2V7z"/></svg>
                <span class="text-xl font-bold text-gray-700 dark:text-gray-200">Chart.js</span>
            </div>
        </div>
    </div>
</section>

<section class="bg-white dark:bg-gray-900 py-20 px-4"> <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-6">
            Prêt à moderniser votre évaluation ?
        </h2>
        <p class="dark:text-white/90 text-lg mb-10 leading-relaxed max-w-2xl mx-auto">
            Rejoignez les établissements qui utilisent AcademicaPro pour gagner du temps et améliorer la précision de leurs résultats académiques.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#" class="px-8 py-4 bg-[#4338CA] text-gray-100 font-bold rounded-xl shadow-lg hover:bg-[#372E9D] transition-all text-sm md:text-base">
                Créer un compte gratuitement
            </a>
            <a href="#" class="px-8 py-4 border-2   font-bold rounded-xl hover:bg-white/10 transition-all text-sm md:text-base border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-500 dark:hover:border-gray-400">
                Demander une démo ->
            </a>
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
