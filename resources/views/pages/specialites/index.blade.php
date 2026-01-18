@extends('layouts.admin.layout-admin') 

@section('content')
{{-- Le x-data englobe TOUT le contenu pour que la modal fonctionne --}}
<div 
    class="ml-0 md:ml-64 min-h-screen dark:bg-[#1F2937] antialiased transition-colors duration-300 content mt-16" 
    x-data="{ showImportModal: false }"
>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Gestion des Spécialités</h1>
            
            {{-- Bouton Kebab Menu --}}
            <div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" type="button" 
                        class="p-2 rounded-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-none shadow-md transition duration-150">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </button>

                <div x-show="open" x-cloak
                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-neutral-700 ring-1 ring-black ring-opacity-5 z-20">
                    <div class="py-1">
                        <a href="{{ route('specialites.create') }}" class="text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-neutral-600">
                            ➕ Ajouter une Spécialité
                        </a>
                        <div class="border-t border-gray-100 dark:border-neutral-600"></div>
                        <button @click="showImportModal = true; open = false" class="w-full text-left text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-neutral-600">
                            📥 Importer (Excel/CSV)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages Flash --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 dark:bg-green-800 dark:text-green-50">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tableau Mode Bureau --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden hidden sm:block">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm">
                        <th class="py-3 px-6 text-left">Nom</th>
                        <th class="py-3 px-6 text-left">Code</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300 text-sm">
                    @forelse ($specialites as $specialite)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-6 font-medium dark:text-gray-200">{{ $specialite->nom_specialite }}</td>
                            <td class="py-3 px-6">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded">{{ $specialite->code_unique }}</span>
                            </td>
                            <td class="py-3 px-6">{{ Str::limit($specialite->description, 50) }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('specialites.edit', $specialite) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    <form action="{{ route('specialites.destroy', $specialite) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center">Aucune donnée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Liste Mode Mobile --}}
   {{-- Liste Mode Mobile --}}
{{-- Liste Mode Mobile --}}
<div class="sm:hidden space-y-4 p-4">
    @foreach ($specialites as $specialite)
        {{-- On ajoute 'relative' ici pour que le bouton puisse se placer par rapport à la carte --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-100 dark:border-gray-700 relative" 
             x-data="{ openOptions: false }">
            
            {{-- Contenu de la carte --}}
            <div class="pr-8"> {{-- padding-right pour ne pas chevaucher le bouton --}}
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-bold text-gray-900 dark:text-white">{{ $specialite->nom_specialite }}</span>
                    <span class="text-[10px] px-2 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                        {{ $specialite->code_unique }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                    {{ Str::limit($specialite->description, 80) }}
                </p>
            </div>

            {{-- Menu Kebab positionné en BAS à DROITE --}}
            <div class="absolute bottom-2 right-2">
                <button @click="openOptions = !openOptions" @click.outside="openOptions = false"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-full transition focus:outline-none">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </button>

                {{-- Dropdown Menu (s'ouvre vers le haut car on est en bas) --}}
                <div x-show="openOptions" x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     {{-- 'bottom-full mb-2' fait monter le menu au lieu de le faire descendre --}}
                     class="absolute right-0 bottom-full mb-2 w-40 bg-white dark:bg-gray-700 rounded-md shadow-xl border border-gray-100 dark:border-gray-600 z-30">
                    
                    <div class="py-1">
                        <a href="{{ route('specialites.edit', $specialite) }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            Éditer
                        </a>

                        <form action="{{ route('specialites.destroy', $specialite) }}" method="POST" 
                              onsubmit="return confirm('Supprimer cette spécialité ?');">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
    </div>

    {{-- MODAL D'IMPORTATION (Placée ici pour qu'elle soit cliquable) --}}
    <div x-show="showImportModal" 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         style="display: none;" 
         x-cloak>
        
        {{-- Fond noir --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="showImportModal = false"></div>

        {{-- Contenu Modal --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-6" @click.stop>
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold dark:text-white uppercase">Importer des Spécialités</h3>
                    <p class="text-sm text-gray-500 mt-2">Format attendu : .xlsx ou .csv</p>
                </div>

                <form action="{{ route('specialites.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Zone de fichier corrigée (Opacity-0 au lieu de Hidden) --}}
                {{-- Zone de sélection du fichier --}}
<div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-500 transition">
    <input type="file" name="file" id="file_import" required 
           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
           onchange="updateFileName(this)">
    
    <div class="space-y-3">
        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <p id="file-name-display" class="text-sm text-gray-600 dark:text-gray-300 font-medium">
            Cliquez ou glissez le fichier ici
        </p>
        
        <hr class="border-gray-200 dark:border-gray-700">

        {{-- Petit tableau explicatif de la structure --}}
        <div class="mt-2">
            <p class="text-[10px] uppercase font-bold text-gray-400 mb-1 text-left">Structure attendue :</p>
            <table class="w-full text-[11px] border border-gray-200 dark:border-gray-700 rounded">
                <thead class="bg-gray-50 dark:bg-gray-900 text-gray-500">
                    <tr>
                        <th class="border-r border-b px-2 py-1">nom_specialite</th>
                        <th class="border-r border-b px-2 py-1">code_unique</th>
                        <th class="border-b px-2 py-1">description</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400 italic">
                    <tr>
                        <td class="border-r px-2 py-1 text-left">Génie Civil</td>
                        <td class="border-r px-2 py-1">GC-2024</td>
                        <td class="px-2 py-1">Étude...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="showImportModal = false" class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg">
                            Annuler
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg">
                            Importer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        if (input.files && input.files[0]) {
            document.getElementById('file-name-display').textContent = "✅ " + input.files[0].name;
            document.getElementById('file-name-display').classList.add('text-blue-600', 'font-bold');
        }
    }
</script>
@endsection
