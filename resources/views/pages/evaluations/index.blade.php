@extends('layouts.admin.layout-admin')

@section('content')
<section>

<div
class="ml-0 md:ml-64 min-h-screen  dark:bg-[#1F2937] antialiased transition-colors duration-300 content  mt-3" 
 >
 {{-- Message de succès --}}
@if(session('success'))
    <div id="success-alert" class="mt-16 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900 dark:text-green-100 flex justify-between items-center transition-opacity duration-500">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('success-alert').remove()" class="text-green-700 dark:text-green-100 font-bold">&times;</button>
    </div>
    <script>
        // Disparition automatique après 4 secondes
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if(alert) alert.style.opacity = '0';
            setTimeout(() => alert ? alert.remove() : null, 500);
        }, 4000);
    </script>
@endif
    <h1 class="text-2xl font-bold mb-6 dark:text-white mt-16">Saisie des Notes - {{ $anneeActive->libelle }}</h1>

    {{-- Formulaire de FILTRAGE --}}
    <div class="bg-white dark:bg-neutral-800 p-6 rounded-xl shadow mb-8">
     <form action="{{ route('evaluations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
    {{-- 1. Spécialité --}}
    <div>
        <label class="block mb-2 text-sm dark:text-gray-300 font-bold">1. Spécialité</label>
        <select name="specialite_id" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 dark:bg-neutral-700 dark:text-white">
            <option value="">Choisir...</option>
            @foreach($specialites as $s)
                <option value="{{ $s->id }}" {{ request('specialite_id') == $s->id ? 'selected' : '' }}>{{ $s->nom_specialite }}</option>
            @endforeach
        </select>
    </div>

    {{-- 2. Semestre (On rafraîchit la page au changement pour filtrer les modules) --}}
    <div>
        <label class="block mb-2 text-sm dark:text-gray-300 font-bold">2. Semestre</label>
        <select name="semestre" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 dark:bg-neutral-700 dark:text-white">
            <option value="">Choisir...</option>
            <option value="S1" {{ request('semestre') == 'S1' ? 'selected' : '' }}>Semestre 1</option>
            <option value="S2" {{ request('semestre') == 'S2' ? 'selected' : '' }}>Semestre 2</option>
        </select>
    </div>

    {{-- 3. Module (Maintenant filtré par Spécialité ET Semestre) --}}
    <div>
        <label class="block mb-2 text-sm dark:text-gray-300 font-bold">3. Module</label>
        <select name="module_id" class="w-full rounded-lg border-gray-300 dark:bg-neutral-700 dark:text-white">
            <option value="">Choisir...</option>
            @foreach($modules as $m)
                <option value="{{ $m->id }}" {{ request('module_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->nom_module }} (Coef: {{ $m->coef_module }})
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-bold">
        Afficher la liste
    </button>
</form>
    </div>

    {{-- SECTION SAISIE DES NOTES --}}
    @if(count($etudiants) > 0)
    <form action="{{ route('evaluations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="module_id" value="{{ request('module_id') }}">
        <input type="hidden" name="semestre" value="{{ request('semestre') }}">
        <input type="hidden" name="annee_academique_id" value="{{ $anneeActive->id }}">

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="p-4 dark:text-white">Matricule</th>
                        <th class="p-4 dark:text-white">Nom de l'étudiant</th>
                        <th class="p-4 dark:text-white w-32">Note / 20</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-neutral-700">
                    @foreach($etudiants as $etudiant)
                    <tr>
                        <td class="p-4 dark:text-gray-300">{{ $etudiant->matricule }}</td>
                        <td class="p-4 dark:text-gray-300">{{ $etudiant->name }}</td>
                        <td class="p-4">
                            {{-- <input type="number" 
                                   name="notes[{{ $etudiant->id }}]" 
                                   step="0.25" min="0" max="20"
                                   value="{{ $etudiant->evaluations->first()?->note }}"
                                   class="w-full rounded border-gray-300 dark:bg-neutral-700 dark:text-white focus:ring-blue-500"> --}}

                              <input type="number" 
           name="notes[{{ $etudiant->id }}]" 
           step="0.25" min="0" max="20"
           {{-- On récupère la première évaluation chargée par le with() --}}
           value="{{ $etudiant->evaluations->first()?->note }}"
           placeholder="Néant"
           class="note-input w-full rounded border-gray-300 dark:bg-neutral-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-6 border-t dark:border-neutral-700 flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-lg font-bold shadow-lg hover:bg-green-700 transition">Enregistrer toutes les notes</button>
            </div>
        </div>
    </form>
    @elseif(request('module_id'))
        <div class="text-center p-10 bg-gray-100 dark:bg-neutral-800 rounded-xl">
            <p class="text-gray-500 italic">Aucun étudiant inscrit dans cette spécialité pour cette année.</p>
        </div>
    @endif
</div>
<script>
document.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && e.target.classList.contains('note-input')) {
        e.preventDefault(); // Empêche l'envoi du formulaire
        
        const inputs = Array.from(document.querySelectorAll('.note-input'));
        const index = inputs.indexOf(e.target);
        
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus(); // Passe au suivant
            inputs[index + 1].select(); // Optionnel : sélectionne le texte pour écraser
        } else if (index === inputs.length - 1) {
            // Si c'est le dernier, on peut proposer de soumettre ou juste rester là
            if(confirm("Dernière note saisie. Enregistrer tout ?")) {
                e.target.form.submit();
            }
        }
    }
});
</script>
</section>
@endsection
