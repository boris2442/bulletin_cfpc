@extends('layouts.admin.layout-admin')

@section('content')
{{-- Bloc Debug --}}

<section>
<div class="ml-0 md:ml-64 min-h-screen dark:bg-[#1F2937] antialiased transition-colors duration-300 content p-4 mt-14" >

<p class="text-red-500">
   Debug : Total modules = {{ $modulesNormaux->count() }} | 
   S1 = {{ $modulesNormaux->where('semestre', 1)->count() }} | 
   S2 = {{ $modulesNormaux->where('semestre', 2)->count() }}
</p>

{{-- BARRE D'ACTIONS FLOTTANTE (STAY TOP ON SCROLL) --}}
    <div class="sticky top-16 z-30 flex flex-col md:flex-row justify-between items-start md:items-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6 gap-4 no-print">
        <div>
            <h1 class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="p-2 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
                SYNTHÈSE ANNUELLE
            </h1>
            <p class="text-xs text-gray-500 font-medium px-10 italic">{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</p>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            {{-- Bouton Imprimer (Minimaliste) --}}
            <a href="{{ route('bilan.pdf', ['classe_id' => request('classe_id')]) }}" 
               class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 text-xs font-bold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                BILAN COMPLET
            </a>

            {{-- Bouton Actions Groupées (Style Facebook/Modern) --}}
            <div class="relative group">
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 dark:bg-white dark:text-gray-900 text-white rounded-lg text-xs font-bold hover:bg-black transition shadow-lg">
                    ACTIONS SÉLECTION
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                {{-- Dropdown au survol --}}
                <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="p-2 space-y-1">
                        <button type="button" onclick="printSelectedTranscripts()" class="w-full text-left flex items-center gap-3 px-3 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 rounded-lg transition">
                            <span class="text-blue-500 italic">🖨️</span> Imprimer Relevés
                        </button>
                        <button type="button" onclick="document.getElementById('formBilan').submit()" class="w-full text-left flex items-center gap-3 px-3 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 rounded-lg transition">
                            <span class="text-green-500 italic">💾</span> Sauvegarder Notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>












    {{-- Filtre par Classe --}}
    {{-- <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-neutral-700 mb-8 no-print">
        <form action="{{ route('bilan.index') }}" method="GET" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block mb-2 text-xs font-bold uppercase text-gray-500">Choisir une Classe / Niveau</label>
                <select name="classe_id" class="w-full rounded-lg border-gray-300 dark:bg-neutral-700 dark:text-white focus:ring-green-500" onchange="this.form.submit()">
                    <option value="">Sélectionnez une classe...</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ request('classe_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nom_classe }} ({{ $c->specialite->nom_specialite }})
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div> --}}



{{-- Filtre par Spécialité --}}
<div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-neutral-700 mb-8 no-print">
    <form action="{{ route('bilan.index') }}" method="GET" class="flex items-end gap-4">
        <div class="flex-1">
            <label class="block mb-2 text-xs font-bold uppercase text-gray-500">Choisir une Spécialité / Filière</label>
            <select name="specialite_id" class="w-full rounded-lg border-gray-300 dark:bg-neutral-700 dark:text-white focus:ring-green-500" onchange="this.form.submit()">
                <option value="">Sélectionnez une spécialité...</option>
                @foreach($specialites as $s)
                    <option value="{{ $s->id }}" {{ request('specialite_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nom_specialite }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>







    {{-- Vérification principale (CORRIGÉE : classe_id au lieu de specialite_id) --}}
   @if(request('specialite_id'))
        @if(count($etudiants) > 0)
            @if($moduleBilan)
                <form action="{{ route('bilans.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="module_id" value="{{ $moduleBilan->id }}">

                    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl overflow-x-auto border border-green-800">
                        <table class="w-full border-collapse text-[11px] uppercase tracking-tighter">
                    



<thead>
    <tr class="bg-[#d9ead3] text-gray-800 border-b border-green-800">
        <th rowspan="2" class="border border-green-800 p-2 w-8 no-print">
            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
        </th>
        <th rowspan="2" class="border border-green-800 p-2 w-8">N°</th>
        <th rowspan="2" class="border border-green-800 p-2 min-w-[200px]">Nom et prénoms</th>
        
        {{-- Semestre 1 : Colspan dynamique + 1 pour la moyenne --}}
        <th colspan="{{ $modulesNormaux->where('semestre', 1)->count() + 1 }}" class="border border-green-800 p-1 text-center">S1 (30%)</th>
        
        {{-- Semestre 2 : Colspan dynamique + 1 pour la moyenne --}}
        <th colspan="{{ $modulesNormaux->where('semestre', 2)->count() + 1 }}" class="border border-green-800 p-1 text-center">S2 (30%)</th>
        
        <th rowspan="2" class="border border-green-800 bg-[#6aa84f] text-white p-2 w-24">Bilan (70%)</th>
        <th rowspan="2" class="border border-green-800 bg-[#f4cccc] text-red-700 p-2 w-24">MOY. GEN.</th>
    </tr>

    <tr class="bg-[#d9ead3] text-gray-700 border-b border-green-800">
        {{-- Modules S1 --}}
        @foreach($modulesNormaux->where('semestre', 1) as $mod)
            <th class="border border-green-800 p-1 text-center w-12 text-[9px]">
                {{ $mod->code_module ?? 'M' }}
            </th>
        @endforeach
        <th class="border border-green-800 p-1 text-center bg-[#b6d7a8] font-bold italic">MOY S1</th>

        {{-- Modules S2 --}}
        @foreach($modulesNormaux->where('semestre', 2) as $mod)
            <th class="border border-green-800 p-1 text-center w-12 text-[9px]">
                {{ $mod->code_module ?? 'M' }}
            </th>
        @endforeach
        <th class="border border-green-800 p-1 text-center bg-[#b6d7a8] font-bold italic">MOY S2</th>
    </tr>
</thead>












 




<tbody class="divide-y divide-green-800">
    @foreach($etudiants as $index => $etudiant)
    <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition">


<td class="border border-green-800 p-2 text-center no-print">
        <input type="checkbox" name="etudiant_ids[]" value="{{ $etudiant->id }}" class="etudiant-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500">
    </td>


        <td class="border border-green-800 p-2 text-center font-bold">{{ $index + 1 }}</td>
        <td class="border border-green-800 p-2 font-bold text-left">
            <a href="{{ route('bilan.show', $etudiant->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                {{ $etudiant->name }}
            </a>
        </td>

        {{-- BLOC SEMESTRE 1 : On affiche TOUS les modules, mais on force la recherche de la note S1 --}}
     {{-- BLOC SEMESTRE 1 --}}
@foreach($modulesNormaux->where('semestre', 1) as $mod)
    @php 
        $noteS1 = $etudiant->evaluations
            ->where('module_id', $mod->id)
            ->where('semestre', 1) 
            ->first()?->note;
    @endphp
    <td class="border border-green-800 p-2 text-center">{{ $noteS1 ?? '-' }}</td>
@endforeach

<td class="border border-green-800 p-2 text-center font-bold bg-[#edf2f7]">
    {{ number_format($etudiant->moyenne_s1, 2) }}
</td>

{{-- BLOC SEMESTRE 2 --}}
@foreach($modulesNormaux->where('semestre', 2) as $mod)
    @php 
        $noteS2 = $etudiant->evaluations
            ->where('module_id', $mod->id)
            ->where('semestre', 2)
            ->first()?->note;
    @endphp
    <td class="border border-green-800 p-2 text-center">{{ $noteS2 ?? '-' }}</td>
@endforeach

<td class="border border-green-800 p-2 text-center font-bold bg-[#edf2f7]">
    {{ number_format($etudiant->moyenne_s2, 2) }}
</td>

        {{-- Note Bilan (70%) --}}
        <td class="border border-green-800 p-0 bg-[#6aa84f]">
            <input type="number" step="0.01" name="notes[{{ $etudiant->id }}]" 
                   value="{{ $etudiant->evaluations->where('module_id', $moduleBilan->id)->first()?->note ?? '' }}"
                   class="w-full h-full bg-transparent text-white text-center font-bold p-2 outline-none border-none">
        </td>

        {{-- Moyenne Générale --}}
        <td class="border border-green-800 p-2 text-center font-bold text-red-600 bg-[#f4cccc]">
            {{ number_format($etudiant->moyenne_generale, 2) }}
        </td>
    </tr>
    @endforeach
</tbody>







                        </table>
                    </div>

                  <div class="mt-8 flex flex-col sm:flex-row justify-end items-center gap-3 no-print border-t pt-6 dark:border-gray-700">
    
    {{-- Bouton Impression Groupée : Plus fin, bleu pro --}}
    <button type="button" 
            onclick="printSelectedTranscripts()" 
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 hover:bg-blue-600 text-slate-700 hover:text-white border border-slate-300 hover:border-blue-600 rounded-lg text-xs font-bold transition-all duration-200 group">
        <svg class="w-4 h-4 text-slate-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        <span>IMPRIMER LA SÉLECTION</span>
    </button>

    {{-- Bouton Enregistrer : Minimaliste et efficace --}}
    <button type="submit" 
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold shadow-sm hover:shadow-md transition-all active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
        </svg>
        <span>SAUVEGARDER LES NOTES</span>
    </button>

</div>
                </form>
            @else
                {{-- Alerte module bilan absent --}}
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-10">
                    <p class="text-sm text-red-700 font-bold uppercase">Attention : Aucun module n'est marqué comme 'Bilan' (is_bilan = 1) pour cette spécialité.</p>
                </div>
            @endif
        @else
            {{-- Aucun étudiant --}}
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-10">
                <p class="text-yellow-700 italic">Aucun étudiant trouvé inscrit dans cette classe pour l'année {{ $anneeActive->libelle }}.</p>
            </div>
        @endif
    @else
        {{-- État initial --}}
        <div class="flex flex-col items-center justify-center mt-20 opacity-30">
            <svg class="w-20 h-20 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-xl font-bold uppercase text-gray-400">Veuillez sélectionner une classe pour générer la synthèse</p>
        </div>
    @endif

    <div class="mt-4 text-[10px] text-gray-500 italic">
        * Ce document respecte la pondération (30% modules, 70% bilan).
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .content { margin-left: 0 !important; padding: 0 !important; }
        body { background: white; }
        table { font-size: 9px; width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #065f46 !important; }
    }
</style>





<script>
    // 1. Gestion du "Tout cocher"
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.etudiant-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // 2. Fonction d'impression groupée
    function printSelectedTranscripts() {
        // On récupère toutes les cases cochées
        const checkboxes = document.querySelectorAll('.etudiant-checkbox:checked');
        
        // On transforme les éléments cochés en une liste d'IDs (ex: [1, 4, 7])
        const ids = Array.from(checkboxes).map(cb => cb.value);

        // Sécurité : si rien n'est coché
        if (ids.length === 0) {
            alert("⚠️ Veuillez sélectionner au moins un étudiant pour l'impression.");
            return;
        }

        // On construit l'URL vers ton contrôleur
        // Note: l'URL doit correspondre au nom défini dans ton web.php
        const baseUrl = "{{ route('bilan.print-batch') }}";
        const finalUrl = baseUrl + "?ids=" + ids.join(',');

        // On ouvre le PDF généré par DomPDF dans un nouvel onglet
        window.open(finalUrl, '_blank');
    }
</script>



@endsection
