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

    <div class="min-h-screen flex flex-col">

        {{-- HEADER OPTIMISÉ --}}
        <header class="py-3 px-4  backdrop-blur-md shadow-sm sticky top-0 z-50 border-b dark:border-gray-700">
            <div class="container mx-auto flex justify-between items-center">
                {{-- Logo --}}
                <a href="/" class="text-xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight">
                    🎓 Academica<span class="text-gray-900 dark:text-white">Pro</span>
                </a>
                
                <div class="flex items-center space-x-4">
                    {{-- NAVIGATION DESKTOP --}}
                    <nav class="hidden md:flex items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold hover:text-indigo-600 transition">Dashboard</a>
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="text-sm font-bold text-red-500 hover:text-red-600 transition flex items-center">
                                   <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                   Quitter
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-indigo-600">Connexion</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="py-2 px-5 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-indigo-700 transition">Inscription</a>
                                @endif
                            @endauth
                        @endif
                    </nav>

                    {{-- Theme Toggle --}}
                    <button id="theme-toggle-btn" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:ring-2 ring-indigo-500 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.068A8.999 8.001 0 017 3.707a8.999 8.999 0 1013.586 10.957.5.5 0 00-.293-.016z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM6.591 4.591a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zM4.591 13.409a1 1 0 101.414 1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zM13.409 15.409a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.409 6.591a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707z" /></svg>
                    </button>

                    <button id="mobile-menu-button" class="md:hidden p-2 text-gray-600 dark:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    </button>
                </div>
            </div>
        </header>

        <main class="flex-grow">
            {{-- HERO SECTION --}}
            <section class="pt-16 md:py-24 px-4 md:px-8 pb-0">
                <div class="container  ">
                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white leading-tight mb-6">
                        La <span class="text-indigo-600">Gestion Académique</span><br>enfin simplifiée.
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl  mb-10 leading-relaxed">
                        Optimisez chaque étape de votre année scolaire, de l'inscription à la génération des bilans de compétences avec une précision chirurgicale.
                    </p>
                    <div class="flex flex-wrap  gap-4">
                        <a href="#" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition transform hover:-translate-y-1">
                            Commencer maintenant
                        </a>
                        <a href="#" class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                            Demander une démo
                        </a>
                    </div>
                </div>
            </section>

            {{-- FORMULE DE CALCUL --}}
            <section class="py-16 container mx-auto px-4 pt-0">
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border dark:border-gray-700 flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-10">
                        <h2 class="text-3xl font-bold mb-6">Calcul Automatique & Équitable</h2>
                        <div class="space-y-6">
                            <div class="flex items-center p-4  bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4">1</div>
                                <div>
                                    <h4 class="font-bold">Moyennes Semestrielles</h4>
                                    <p class="text-sm text-gray-500 italic">$\sum (\text{Note} \times \text{Coeff}) / \sum \text{Coeff}$</p>
                                </div>
                            </div>
                            <div class="flex items-center p-4  bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4">2</div>
                                <div>
                                    <h4 class="font-bold">Moyenne Annuelle</h4>
                                    <p class="text-sm text-gray-500 italic">$(S1 + S2) / 2$</p>
                                </div>
                            </div>
                            <div class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4">3</div>
                                <div>
                                    <h4 class="font-bold text-indigo-700 dark:text-indigo-400">Décision Finale</h4>
                                    <p class="text-sm">$(Moy. \times 30\%) + (Comp. \times 70\%)$</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-1/2  dark:bg-gray-900/50 p-10 flex flex-col justify-center border-l dark:border-gray-700">
                        <div class="space-y-6 mb-8">
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-2 uppercase tracking-widest text-gray-500">Évaluations (30%)</div>
                                <div class="w-full  dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 30%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-2 uppercase tracking-widest text-gray-500">Compétences (70%)</div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-inner border dark:border-gray-700 text-center">
                            <p class="text-xs font-bold text-gray-400 mb-4 uppercase">Mentions Automatiques</p>
                            <div class="grid grid-cols-2 gap-2 text-[11px] font-bold">
                                <div class="p-2 bg-green-50 dark:bg-green-900/20 text-green-700 rounded-lg">≥ 16 Très Bien</div>
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 rounded-lg">≥ 14 Bien</div>
                                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 rounded-lg">≥ 12 Assez Bien</div>
                                <div class="p-2 bg-orange-50 dark:bg-orange-900/20 text-orange-700 rounded-lg">≥ 10 Passable</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- FONCTIONNALITÉS GRID --}}
        <section class="py-12 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        {{-- En-tête de section plus compact --}}
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                Écosystème Pédagogique
            </h2>
            <p class="text-sm text-gray-500 mt-2">Une infrastructure logicielle robuste pour vos données académiques.</p>
        </div>

        {{-- Grille optimisée --}}
        <div class="grid md:grid-cols-3 gap-5">
            
            {{-- Feature 1: Analytics --}}
          <div class="group p-6  dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-indigo-500/30  transition-all duration-300 shadow-sm">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-200 dark:shadow-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Analyse de Performance</h3>
                <p class="text-gray-500 text-xs leading-relaxed">Suivi analytique via Chart.js pour visualiser les taux de réussite et les moyennes par promotion en un coup d'œil.</p>
            </div>

            {{-- Feature 2: Automation --}}
            <div class="group p-6  dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-indigo-500/30  transition-all duration-300 shadow-sm">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-200 dark:shadow-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Calcul Automatisé</h3>
                <p class="text-gray-500 text-xs leading-relaxed">Algorithme de calcul pondéré (30/70) éliminant les erreurs humaines lors de la génération des bilans de fin d'année.</p>
            </div>

            {{-- Feature 3: Security --}}
            <div class="group p-6  dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-indigo-500/30  transition-all duration-300 shadow-sm">
                <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-200 dark:shadow-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Accès Sécurisé</h3>
                <p class="text-gray-500 text-xs leading-relaxed">Gestion granulaire des rôles (Admin, Manager, Étudiant) assurant l'intégrité et la confidentialité des notes saisies.</p>
            </div>

        </div>
    </div>
</section>
        </main>

   <footer class="bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center text-center">
            
            {{-- Branding --}}
            <div class="mb-6">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">
                    ScholarChart
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
            <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-gray-50 dark:bg-gray-900/50 rounded-full border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-md">
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400">
                    Propulsé avec amour ❤️ par 
                    <span class="font-bold text-indigo-600 dark:text-indigo-400 ml-1"> <a href="https://borisaubin.vercel.app" target="_blank">Aubin Boris Simo</a></span>
                </span>
            </div>

        </div>
    </div>
</footer>
    </div>
</body>
</html>
