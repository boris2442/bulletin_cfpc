<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Systeme de gestion des evaluations') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <link rel="icon" type="image/jpg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">


    <meta name="description"
        content="Academia+ est la plateforme leader de gestion académique au Cameroun. Suivi des performances, relevés de notes officiels, analytics en temps réel et gestion des effectifs pour établissements d'enseignement supérieur.">
    <meta name="keywords"
        content="gestion scolaire Cameroun, logiciel académique, relevé de notes Cameroun, analytics étudiant, suivi pédagogique, Academia+, plateforme éducation, MINESUP Cameroun">
    <meta name="author" content="Ton Nom ou Nom de ton Entreprise">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Academia+ | Système de Gestion Académique Intégré">
    <meta property="og:description"
        content="Optimisez la gestion de votre établissement : Relevés de notes, statistiques de réussite et suivi des enseignants.">
    <meta property="og:image" content="{{ asset('images/logo.jpg') }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="Academia+ | Analytics Académiques">
    <meta property="twitter:description" content="Visualisez les performances de votre institution en un clin d'œil.">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- <body class="font-sans text-gray-900 antialiased"> --}}

<body
    class="dark-mode-transition dark:bg-gray-900 font-sans antialiased text-gray-800 dark:text-gray-200 overflow-x-hidden relative">
    <div id="particles-js" class="absolute top-0 left-0 w-full h-full"></div>
    <div class="max-h-[500px] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4  dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 350
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
