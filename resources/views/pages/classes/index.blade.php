@extends('layouts.admin.layout-admin')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

<section x-data="{ selectedClasses: [] }" class="relative">
    <div class="ml-0 md:ml-64 min-h-screen dark:bg-[#1F2937] antialiased p-4 md:p-6 content mt-16 pb-20">
        
        {{-- En-tête --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold dark:text-white">Classes & Niveaux</h1>
            
            {{-- Bouton Suppression Groupée (Flottant sur mobile) --}}
            <button 
                x-show="selectedClasses.length > 0"
                x-cloak
                @click="if(confirm('Supprimer ces ' + selectedClasses.length + ' classes ?')) $refs.multiDeleteForm.submit()"
                class="bg-red-600 text-white px-5 py-2.5 rounded-full shadow-2xl hover:bg-red-700 transition-all flex items-center gap-2 fixed bottom-10 left-1/2 -translate-x-1/2 md:static md:translate-x-0 z-[110]"
            >
                <i class="fas fa-trash"></i> 
                <span>Supprimer (<span x-text="selectedClasses.length"></span>)</span>
            </button>
        </div>

        {{-- Formulaire d'Ajout --}}
        <div class="bg-white dark:bg-neutral-800 p-5 rounded-2xl shadow-sm mb-8 border dark:border-neutral-700">
            <form action="{{ route('classes.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2 ml-1">Nom du niveau</label>
                    <input type="text" name="nom_classe" placeholder="Ex: Licence 1" 
                           class="w-full rounded-xl border-gray-200 dark:bg-neutral-700 dark:text-white dark:border-neutral-600 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2 ml-1">Spécialité</label>
                    <select name="specialite_id" class="w-full rounded-xl border-gray-200 dark:bg-neutral-700 dark:text-white dark:border-neutral-600" required>
                        <option value="">Choisir...</option>
                        @foreach($specialites as $s)
                            <option value="{{ $s->id }}">{{ $s->nom_specialite }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/20">
                    Ajouter
                </button>
            </form>
        </div>

        {{-- Liste des classes --}}
        <form x-ref="multiDeleteForm" action="{{ route('classes.multi-delete') }}" method="POST">
            @csrf
            <div class="bg-white dark:bg-neutral-800 rounded-2xl border dark:border-neutral-700 shadow-sm">
                
                {{-- Header (PC uniquement) --}}
                <div class="hidden md:grid grid-cols-12 gap-4 p-4 bg-gray-50 dark:bg-neutral-700/50 border-b dark:border-neutral-700 text-[10px] font-black uppercase text-gray-400">
                    <div class="col-span-1 text-center font-bold">#</div>
                    <div class="col-span-5">Niveau / Classe</div>
                    <div class="col-span-4">Spécialité</div>
                    <div class="col-span-2 text-right px-4">Actions</div>
                </div>

                <div class="divide-y dark:divide-neutral-700">
                    @forelse($classes as $classe)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 items-center hover:bg-gray-50 dark:hover:bg-neutral-750 transition-colors relative">
                        
                        {{-- Sélection --}}
                        <div class="md:col-span-1 flex justify-center absolute top-4 left-4 md:static">
                            <input type="checkbox" name="ids[]" value="{{ $classe->id }}" x-model="selectedClasses" 
                                   class="w-5 h-5 md:w-4 md:h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </div>

                        {{-- Nom --}}
                        <div class="md:col-span-5 pl-10 md:pl-0">
                            <h3 class="font-bold dark:text-white tracking-tight">{{ $classe->nom_classe }}</h3>
                            <span class="md:hidden text-[10px] font-bold uppercase text-blue-500 bg-blue-50 dark:bg-blue-900/20 px-2 py-0.5 rounded">
                                {{ $classe->specialite->nom_specialite }}
                            </span>
                        </div>

                        {{-- Spécialité (PC) --}}
                        <div class="hidden md:block md:col-span-4 text-sm text-gray-600 dark:text-gray-400 font-medium">
                            {{ $classe->specialite->nom_specialite }}
                        </div>

                        {{-- Menu Action --}}
                        <div class="md:col-span-2 text-right absolute top-4 right-4 md:static" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="p-2 text-gray-300 hover:text-blue-600 transition-colors">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            
                            {{-- Menu déroulant avec Z-index forcé --}}
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-700 border dark:border-neutral-600 rounded-xl shadow-2xl z-[120] py-2">
                                
                                <button type="button" class="w-full px-4 py-2.5 text-sm text-left dark:text-white hover:bg-gray-50 dark:hover:bg-neutral-600 flex items-center gap-2">
                                    <i class="fas fa-edit text-gray-400"></i> Modifier
                                </button>

                                <button type="button" 
                                        @click="if(confirm('Supprimer cette classe ?')) document.getElementById('delete-form-{{ $classe->id }}').submit()"
                                        class="w-full px-4 py-2.5 text-sm text-left text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 font-semibold">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center text-gray-400 text-sm">
                        Aucune classe trouvée.
                    </div>
                    @endforelse
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Formulaires de suppression unique (Indépendants pour éviter les conflits HTML) --}}
@foreach($classes as $classe)
<form id="delete-form-{{ $classe->id }}" action="{{ route('classes.destroy', $classe->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endforeach

@endsection
