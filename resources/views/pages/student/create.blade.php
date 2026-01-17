@extends('layouts.admin.layout-admin')

@section('content')
<div class="ml-64 p-8 mt-10">
    {{-- Retour --}}
    <div class="mb-6">
        <a href="{{ route('students.indexList') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 text-sm font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour à la liste
        </a>
    </div>

    <div class="max-w-4xl bg-white dark:bg-gray-800 rounded shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="bg-blue-600 p-6">
            <h2 class="text-xl font-bold text-white">Nouvel Étudiant</h2>
            <p class="text-blue-100 text-sm">Remplissez les informations pour créer le compte et l'inscription.</p>
        </div>

        <form action="{{ route('students.store') }}" method="POST" class="p-8"   enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- SECTION : IDENTITÉ --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-gray-700 dark:text-gray-300 border-b pb-2">État Civil</h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nom complet</label>
                        <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded px-4 py-3 focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                     <div>
    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sexe</label>
    <select name="sexe" required class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500">
        <option value="">Sélectionner...</option>
        
        {{-- On boucle sur la colonne sexe récupérée de la DB --}}
        @foreach($sexes as $sexe)
            <option value="{{ $sexe }}" {{ old('sexe') == $sexe ? 'selected' : '' }}>
                {{ $sexe }}
            </option>
        @endforeach
        
    </select>
    @error('sexe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Matricule</label>
                            <input type="text" name="matricule"  placeholder="Ex: 24X001" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded px-4 py-3 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Date de naissance</label>
                            <input type="date" name="date_naissance" required class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded px-4 py-3 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Lieu de naissance</label>
                            <input type="text" name="lieu_naissance" required class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded px-4 py-3 text-sm">
                        </div>
                    </div>
                </div>

                {{-- SECTION : CONTACT & SCOLARITÉ --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-gray-700 dark:text-gray-300 border-b pb-2">Scolarité & Contact</h3>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Adresse Email</label>
                        <input type="email" name="email" required placeholder="etudiant@exemple.com" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Téléphone</label>
                        <input type="text" name="telephone" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Spécialité d'affectation</label>
                        <select name="specialite_id" required class="w-full bg-blue-50 dark:bg-gray-700 border-2 border-blue-100 dark:border-blue-900 rounded px-4 py-3 text-sm font-semibold text-blue-600">
                            <option value="">Choisir une spécialité...</option>
                            @foreach($specialites as $s)
                                <option value="{{ $s->id }}">{{ $s->nom_specialite }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-4 bg-amber-50 rounded border border-amber-100">
                        <p class="text-xs text-amber-700">
                            <strong>Note :</strong> L'inscription sera automatiquement rattachée à la session active : 
                            <span class="font-bold">{{ $anneeActive->libelle }}</span>.
                        </p>
                    </div>
                </div>
            </div>




<div class="mb-6">
        <label class="mb-2 block font-bold text-xs text-gray-500 uppercase">
            Photo de l'étudiant
        </label>

        <div id="dropZone"
            onclick="document.getElementById('fileInput').click()"
            class="mt-1 flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 hover:border-blue-500 dark:border-gray-700 transition-all">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 0l-4 4m4-4l4 4" />
            </svg>

            <p class="text-sm text-gray-500 text-center">
                <span class="text-blue-600 font-semibold">Cliquez pour uploader</span> ou glissez-déposez<br />
                <span class="text-xs text-gray-400">PNG, JPG (max. 2MB)</span>
            </p>

            <input id="fileInput" type="file" name="photo" accept="image/*" class="hidden">
        </div>

        <div id="imagePreviewContainer" class="relative mt-4 w-max hidden">
            <img id="imagePreview" class="h-24 w-24 rounded-2xl border-2 border-blue-100 object-cover shadow-md">
            <button type="button" id="removeImage"
                class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 shadow-lg">
                ×
            </button>
        </div>

        @error('photo')
            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>







            <div class="mt-8 pt-6 border-t flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded font-bold shadow-lg shadow-blue-200 transition-all">
                    Enregistrer l'étudiant
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');
    const removeBtn = document.getElementById('removeImage');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    removeBtn.addEventListener('click', function() {
        fileInput.value = '';
        previewContainer.classList.add('hidden');
        previewImage.src = '';
    });
</script>
@endsection
