@extends('layouts.admin.layout-admin')

@section('content')
{{-- Changement du nom de la variable Alpine pour la clarté --}}
<section x-data="{ selectedEtudiants: [], filterSpec: '' }">
    <div class="ml-0 md:ml-64 min-h-screen dark:bg-[#1F2937] antialiased p-4 md:p-6 content mt-16 pb-20">
        
        {{-- SECTION FILTRE --}}
        <div class="mb-4 flex items-center gap-4">
            <div class="relative flex-1 md:flex-none md:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-filter text-xs"></i>
                </span>
                {{-- On lie le select à filterSpec --}}
                <select x-model="filterSpec" class="pl-10 w-full bg-white dark:bg-neutral-800 border-none rounded-xl shadow-sm text-sm focus:ring-2 focus:ring-blue-500 dark:text-gray-300">
                    <option value="">Toutes les spécialités</option>
                    @foreach($specialites as $s)
                        <option value="{{ $s->nom_specialite }}">{{ $s->nom_specialite }}</option>
                    @endforeach
                </select>
            </div>
            
            <span class="text-xs text-gray-400 font-medium" x-show="filterSpec !== ''">
                Filtrage par : <span class="text-blue-500" x-text="filterSpec"></span>
            </span>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold dark:text-white flex items-center gap-2">
                <i class="fas fa-user-graduate text-blue-600"></i>
                Inscriptions <span class="text-gray-400 font-light">| {{ $anneeActive->libelle }}</span>
            </h1>
        </div>

        {{-- ALERTES ERREURS --}}
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                <strong>Oups !</strong> Vérifiez les champs :
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULAIRE --}}
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-2xl shadow-sm mb-8 border dark:border-neutral-700">
            <h2 class="text-sm font-black uppercase text-blue-600 mb-4 tracking-wider">Nouvelle inscription groupée</h2>
            
            <form action="{{ route('inscriptions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="annee_academique_id" value="{{ $anneeActive->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Étape 1 : Choisir la Spécialité --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">1. Choisir la Spécialité</label>
                        <select name="specialite_id" class="w-full rounded-xl border-gray-200 dark:bg-neutral-700 dark:text-white dark:border-neutral-600" required>
                            <option value="">Sélectionner une spécialité...</option>
                            @foreach($specialites as $s)
                                <option value="{{ $s->id }}">{{ $s->nom_specialite }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Étape 2 : Liste des étudiants --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">2. Sélectionner les Étudiants</label>
                        <div class="max-h-48 overflow-y-auto border dark:border-neutral-700 rounded-xl p-2 dark:bg-neutral-900/50">
                            @forelse($etudiantsDisponibles as $e)
                                <label class="flex items-center p-2 hover:bg-white dark:hover:bg-neutral-800 rounded-lg cursor-pointer transition-colors">
                                    <input type="checkbox" name="etudiant_ids[]" value="{{ $e->id }}" class="rounded text-blue-600 mr-3">
                                    <span class="text-sm dark:text-gray-300">{{ $e->name }} <span class="text-[10px] text-gray-500 ml-2">({{ $e->matricule }})</span></span>
                                </label>
                            @empty
                                <p class="p-4 text-center text-xs text-gray-500">Aucun étudiant disponible.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/20 transition-all">
                        Valider l'inscription
                    </button>
                </div>
            </form>
        </div>

        {{-- TABLEAU DES INSCRITS --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl border dark:border-neutral-700 shadow-sm overflow-hidden">
            <div class="p-4 border-b dark:border-neutral-700 flex justify-between items-center">
                <h2 class="text-sm font-black uppercase text-gray-400">Liste des inscrits</h2>
                <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-2 py-1 rounded-full">{{ $inscriptionsActuelles->count() }} TOTAL</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-neutral-700/50 text-[10px] font-black uppercase text-gray-400">
                        <tr>
                            <th class="p-4">Étudiant</th>
                            <th class="p-4">Spécialité</th>
                            <th class="p-4 text-right px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-neutral-700">
                        @foreach($inscriptionsActuelles as $ins)
                        <tr 
                            x-show="filterSpec === '' || filterSpec === '{{ $ins->specialite->nom_specialite }}'"
                            x-transition
                            class="hover:bg-gray-50 dark:hover:bg-neutral-750 transition-colors"
                        >
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-bold dark:text-white">{{ $ins->etudiant->name }}</span>
                                    <span class="text-[10px] text-gray-500">{{ $ins->etudiant->matricule }}</span>
                                </div>
                            </td>
                            
                            <td class="p-4">
                                <span class="text-sm font-medium text-blue-500 font-bold uppercase">
                                    {{ $ins->specialite->nom_specialite }}
                                </span>
                            </td>

                            <td class="p-4 text-right px-6">
                                <form action="{{ route('inscriptions.destroy', $ins->id) }}" method="POST" onsubmit="return confirm('Annuler cette inscription ?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
