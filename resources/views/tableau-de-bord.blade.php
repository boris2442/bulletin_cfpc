@extends('layouts.admin.layout-admin')

@section('content')
<div
class="ml-0 md:ml-64 min-h-screen  dark:bg-[#1F2937] antialiased transition-colors duration-300 content mt-16" 
>
    
   
<div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
    <div>
        <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Analytics <span class="text-blue-600">Global</span></h1>
        <form action="{{ route('tableau-de-bord') }}" method="GET" class="mt-2">
            <select name="annee_id" onchange="this.form.submit()" class="bg-transparent border-none p-0 text-sm font-bold text-blue-600 focus:ring-0 cursor-pointer">
                @foreach($listeAnnees as $annee)
                    <option value="{{ $annee->id }}" {{ $annee->id == $anneeActive->id ? 'selected' : '' }}>
                        Annee en cours: <span class="underline italic">{{ $annee->date_debut->format('Y') }} - {{ $annee->date_fin->format('Y') }}</span> 
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    
    {{-- État de saisie des notes --}}
    <div class="bg-white dark:bg-neutral-800 p-4 rounded-2xl shadow-sm border dark:border-neutral-700 min-w-[250px]">
        <div class="flex justify-between items-center mb-2">
            <span class="text-xs font-bold uppercase dark:text-gray-400">Saisie des notes</span>
            <span class="text-xs font-black text-blue-600">{{ $etatSaisie['pourcentage'] }}%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $etatSaisie['pourcentage'] }}%"></div>
        </div>
        <p class="text-[10px] text-gray-500 mt-1 italic">{{ $etatSaisie['en_attente'] }} modules restants</p>
    </div>
</div>





    {{-- SECTION 1 : CHIFFRES CLÉS (Cards) --}}
 <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-10">
    {{-- Étudiants --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border dark:border-neutral-700 hover:shadow-md transition-all">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 md:gap-4 text-center sm:text-left">
            <div class="p-3 md:p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-xl md:rounded-2xl">
                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">Inscriptions</p>
                <h2 class="text-xl md:text-3xl font-black dark:text-white">{{ $statsGlobales['total_etudiants'] }}</h2>
            </div>
        </div>
    </div>

    {{-- Enseignants --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border dark:border-neutral-700 hover:shadow-md transition-all">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 md:gap-4 text-center sm:text-left">
            <div class="p-3 md:p-4 bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-xl md:rounded-2xl">
                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="text-[10px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">Staff</p>
                <h2 class="text-xl md:text-3xl font-black dark:text-white">{{ $statsGlobales['total_enseignants'] }}</h2>
            </div>
        </div>
    </div>

    {{-- Taux de Réussite --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border dark:border-neutral-700 hover:shadow-md transition-all">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 md:gap-4 text-center sm:text-left">
            <div class="p-3 md:p-4 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-xl md:rounded-2xl">
                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">Réussite</p>
                <h2 class="text-xl md:text-3xl font-black dark:text-white">{{ $performance['taux_reussite'] }}%</h2>
            </div>
        </div>
    </div>

    {{-- Moyenne Générale --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border dark:border-neutral-700 hover:shadow-md transition-all">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 md:gap-4 text-center sm:text-left">
            <div class="p-3 md:p-4 bg-orange-50 dark:bg-orange-900/20 text-orange-600 rounded-xl md:rounded-2xl">
                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div>
                <p class="text-[10px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">Moy. Gné</p>
                <h2 class="text-xl md:text-3xl font-black dark:text-white">{{ $performance['moyenne_generale'] }}</h2>
            </div>
        </div>
    </div>
</div>






    {{-- SECTION 2 : GRAPHIQUES ET TOP 5 --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Graphique de Répartition --}}
        <div class="lg:col-span-1 bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border dark:border-neutral-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold dark:text-white">Effectifs par Filière</h3>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Visualisation</span>
            </div>
            <div class="h-80">
                <canvas id="chartSpecialite"></canvas>
            </div>
        </div>

       

        {{-- Graphique Mixité (Sexe) --}}
        <div class="bg-white dark:bg-neutral-800 p-8 rounded-3xl shadow-sm border dark:border-neutral-700">
            <h3 class="text-xl font-bold mb-6 dark:text-white">Répartition de Genre</h3>
            <div class="h-64">
                <canvas id="chartSexe"></canvas>
            </div>
        </div>


{{-- SECTION : TABLEAUX D'HONNEUR MULTI-CRITÈRES --}}
<div class="bg-white dark:bg-neutral-800 p-6 rounded-3xl shadow-sm border dark:border-neutral-700 mt-10">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-black dark:text-white tracking-tight">Tableau d'Honneur 🏆</h3>
            <p class="text-[10px] text-gray-500 font-medium italic">Top performances de l'année</p>
        </div>
        
        {{-- Navigation Onglets --}}
        <div class="flex bg-gray-50 dark:bg-neutral-900/50 p-1 rounded-xl border dark:border-neutral-700 w-full sm:w-auto overflow-x-auto">
            <button onclick="switchTab('global')" id="btn-global" class="tab-btn active-tab flex-1 sm:flex-none whitespace-nowrap">Global</button>
          
            <button onclick="switchTab('spé')" id="btn-spé" class="tab-btn flex-1 sm:flex-none whitespace-nowrap">Spécialités</button>
        </div>
    </div>

    {{-- Zone avec Scrollbar personnalisée --}}
    <div class="max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
        {{-- CONTENU : TOP GLOBAL --}}
        <div id="tab-global" class="tab-content space-y-4">
            @forelse($performance['top_global'] as $major)
                <div class="flex items-center justify-between group p-3 hover:bg-gray-50 dark:hover:bg-neutral-700/30 rounded-2xl transition-all border border-transparent hover:border-gray-100 dark:hover:border-neutral-600">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-400 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                            {{ substr($major['nom'], 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-black dark:text-white leading-none">{{ $major['nom'] }}</p>
                            <p class="text-[9px] text-gray-500 uppercase font-bold mt-1">{{ Str::limit($major['specialite'], 20) }}</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-lg text-[10px] font-black">
                        {{ number_format($major['moyenne'], 2) }}
                    </span>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400 text-xs">Aucune donnée</div>
            @endforelse
        </div>

        {{-- CONTENU : TOP SPÉ --}}
        <div id="tab-spé" class="tab-content space-y-4 hidden">
            @forelse($performance['majors_specialites'] as $specialite => $major)
                <div class="flex items-center justify-between group p-3 hover:bg-gray-50 dark:hover:bg-neutral-700/30 rounded-2xl transition-all border border-transparent hover:border-gray-100 dark:hover:border-neutral-600">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-purple-600 to-pink-400 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                            {{ substr($major['nom'], 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-black dark:text-white leading-none">{{ $major['nom'] }}</p>
                            <p class="text-[9px] text-gray-500 uppercase font-bold mt-1">{{ Str::limit($specialite, 20) }}</p>
                        </div>
                    </div>
                    <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-lg text-[10px] font-black">
                        {{ number_format($major['moyenne'], 2) }}
                    </span>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400 text-xs">Aucune donnée</div>
            @endforelse
        </div>
        
        {{-- ... Idem pour tab-spé --}}
    </div>
</div>

<style>
    /* Scrollbar invisible ou très fine pour le look Pro */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { 
        background: #e5e7eb; 
        border-radius: 10px; 
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; }

    .tab-btn { @apply px-4 py-2 text-[10px] font-black uppercase tracking-wider rounded-xl transition-all duration-300; }
    .active-tab { @apply bg-white dark:bg-neutral-800 shadow-sm text-blue-600 dark:text-white; }
</style>


<script>
function switchTab(type) {
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active-tab'));
    
    document.getElementById('tab-' + type).classList.remove('hidden');
    document.getElementById('btn-' + type).classList.add('active-tab');
}
</script>












    </div>
</div>

{{-- CHART.JS CONFIG --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Config Chart Filières
    new Chart(document.getElementById('chartSpecialite'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($repartition->pluck('label')) !!},
            datasets: [{
                label: 'Étudiants',
                data: {!! json_encode($repartition->pluck('total')) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 12,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
        }
    });

    // Config Chart Sexe
    new Chart(document.getElementById('chartSexe'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($demographie->pluck('sexe')) !!},
            datasets: [{
                data: {!! json_encode($demographie->pluck('total')) !!},
                backgroundColor: ['#3b82f6', '#ec4899', '#94a3b8'],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } }
        }
    });
</script>
@endsection
