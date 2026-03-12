<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-neutral-900 dark:border-neutral-700 overflow-y-auto  transition-all duration-300"
    data-collapsed="false">
    <!-- Bouton réduire/ouvrir -->
    <div class="absolute top-4 right-[-12px] z-50">
        <button id="toggle-collapse" class="bg-blue-600 text-white p-2 rounded-full shadow-md">
            <i class="fas fa-angle-left"></i>
        </button>
    </div>
    <!-- Titre entreprise -->
    <div
        class="flex items-center justify-center uppercase font-bold text-xl 
                tracking-wide border-b border-gray-200 dark:border-neutral-700">
        {{-- S.G.E.M.A --}}
        <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="w-12 h-12 m-2 rounded">
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-4 space-y-2">
        <!-- Accueil -->
        <a href=" /" title="retourner a l'accueil" aria-label="Retournez a la page d'accueil"
            class="flex items-center py-2.5 px-4 rounded-lg transition duration-200
              text-gray-400 hover:bg-gray-100 dark:text-gray-400  ">
            <i class="fas fa-home mr-3"></i>
            <span class="sidebar-label  transition-all duration-300">Accueil</span>
        </a>


        @auth
            @if (Auth::user()->role === 'Administrateur')
                <!-- Dashboard -->
                <a href=" {{ route('tableau-de-bord') }}" title="Tableau de bord" aria-label="  Voir le tableau de bord"
                    class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 
                  'bg-blue-600  text-gray-400 hover:bg-gray-100 dark:text-gray-300 '">
                    <i class="fas fa-chart-line mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Tableau de bord</span>
                </a>




                <!-- Années Académiques -->
                <a href="{{ route('annee-academiques.index') }}" title="  Années académiques  "
                    aria-label=" Gérer les années académiques"
                    class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 
   {{ request()->routeIs('annee-academiques.*')
       ? 'bg-[#F3F4F6] dark:bg-black text-gray-900 dark:text-white'
       : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">

                    <i class="fas fa-calendar-alt mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Années Académiques</span>
                </a>

                {{-- Si les liens sont active on do --}}
                <!-- Specialites -->
                <a title="  Specialites  " aria-label=" Gérer les Specialites" href="{{ route('specialites.index') }}"
                    class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 
   {{ request()->routeIs('specialites.*')
       ? 'bg-[#F3F4F6] text-gray-900'
       : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">
                    <i class="fas fa-graduation-cap mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Specialites</span>
                </a>





                <!-- Clients -->
                <a href="{{ route('modules.index') }}" title="  Modules  " aria-label=" Gérer les Modules"
                    class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 
   {{ request()->routeIs('modules.*')
       ? 'bg-[#F3F4F6] dark:bg-neutral-800 text-gray-900 dark:text-white'
       : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">

                    <i class="fas fa-book mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Modules</span>
                </a>


                <!-- Affectation -->
                <a href="{{ route('affectations.index') }}" title=" Affectations  " aria-label="Gestion des affectations"
                    class="
          flex items-center py-2.5 px-4 rounded-lg transition duration-200 
          {{ request()->routeIs('affectations.index')
              ? 'bg-blue-600 text-white'
              : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Affectation</span>
                </a>




                <!--Utilisateurs-->
                <a href="{{ route('users.index') }}" title=" Utilisateurs  " aria-label=" Gérer les Utilisateurs"
                    class="
          flex items-center py-2.5 px-4 rounded-lg transition duration-200 
          {{ request()->routeIs('users.index')
              ? 'bg-blue-600 text-white'
              : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">
                    <i class="fas fa-users mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Utilisateurs</span>
                </a>
            @endif

        @endauth




        @auth
            @if (Auth::user()->role === 'Administrateur' || Auth::user()->role === 'secretaire')
                <!-- Bilan general -->
                <a href="{{ route('bilan.index') }}" title=" Bilan general  " aria-label="Gestion des bilans generaux"
                    class="
          flex items-center py-2.5 px-4 rounded-lg transition duration-200 
          {{ request()->routeIs('bilan.index')
              ? 'bg-blue-600 text-white'
              : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Bilan general</span>
                </a>

                <!-- Inscriptions -->
                <a href="{{ route('inscriptions.index') }}" title=" Inscriptions  " aria-label=" Gérer les Inscriptions"
                    class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 
          {{ request()->routeIs('inscriptions.*')
              ? 'bg-blue-600 text-white'
              : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300 ' }}">
                    <i class="fas fa-user-graduate mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Inscriptions</span>
                </a>


                <a href="{{ route('students.indexList') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition  {{ request()->routeIs('students.*')
                        ? 'bg-blue-600 text-white'
                        : 'text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <i class="fas fa-user-graduate mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Étudiants</span>
                </a>
            @endif

        @endauth



        @auth
            @if (Auth::user()->role === 'Enseignant' ||
                    Auth::user()->role === 'Administrateur' ||
                    Auth::user()->role === 'secretaire')
                <!-- Eva -->
                <a href="{{ route('evaluations.index') }}" title="Evaluations" aria-label="Gérer les Evaluations"
                    class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 
         {{ request()->routeIs('evaluations.*')
             ? 'bg-blue-600 text-white'
             : 'text-gray-400 hover:bg-gray-100 dark:text-gray-300' }}">
                    <i class="fas fa-file-alt mr-3"></i>
                    <span class="sidebar-label  transition-all duration-300">Evaluations</span>
                </a>
            @endif
        @endauth



        <!-- Séparateur -->
        <div class="border-t border-gray-200 dark:border-neutral-700 my-4"></div>

        <!-- Déconnexion -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit"
                class="flex items-center w-full py-2.5 px-4 rounded-lg transition duration-200
                           bg-red-500 hover:bg-red-600 text-white dark:hover:bg-red-700">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span class="sidebar-label  transition-all duration-300">Déconnexion</span>
            </button>
        </form>
    </nav>
</aside>

<!-- Overlay mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden" onclick="toggleSidebar()">
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const isOpen = sidebar.classList.contains('translate-x-0');

        if (isOpen) {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        }
    }

    // Initialisation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        // Sur mobile, cacher la sidebar par défaut
        if (window.innerWidth < 768) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        }
    });




    const toggleCollapse = document.getElementById('toggle-collapse');
    const sidebar = document.getElementById('sidebar');

    toggleCollapse.addEventListener('click', () => {
        const collapsed = sidebar.dataset.collapsed === 'true';

        if (collapsed) {
            // Ouvrir
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            document.querySelectorAll('.sidebar-label').forEach(el => {
                el.classList.remove('hidden');
            });
            sidebar.dataset.collapsed = 'false';
            toggleCollapse.innerHTML = '<i class="fas fa-angle-left"></i>';
        } else {
            // Réduire
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            document.querySelectorAll('.sidebar-label').forEach(el => {
                el.classList.add('hidden');
            });
            sidebar.dataset.collapsed = 'true';
            toggleCollapse.innerHTML = '<i class="fas fa-angle-right"></i>';
        }
    });
</script>
