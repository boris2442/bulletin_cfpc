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

    <div class="max-w-4xl bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        {{-- Header avec bannière et Photo --}}
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
        
        <div class="px-8 pb-8">
            <div class="relative -mt-16 mb-6 flex items-end justify-between">
                <div class="flex items-end gap-6">
                    {{-- Photo de l'étudiant --}}
                    <div class="relative">
                        @if($student->photo)
                            <img src="{{ asset('uploads/students/' . $student->photo) }}" class="h-40 w-40 rounded-3xl border-4 border-white dark:border-gray-800 object-cover shadow-xl bg-gray-100">
                        @else
                            <div class="h-40 w-40 rounded-3xl border-4 border-white dark:border-gray-800 bg-blue-100 flex items-center justify-center shadow-xl">
                                <span class="text-4xl font-bold text-blue-600">{{ substr($student->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-2">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $student->name }}</h1>
                        <p class="text-blue-600 font-mono font-bold">{{ $student->matricule }}</p>
                    </div>
                </div>

                {{-- Bouton Modifier rapide --}}
                <a href="{{ route('students.edit', $student->id) }}" class="mb-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                    Modifier le profil
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
                
                {{-- Colonne 1 : État Civil --}}
                <div class="space-y-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b pb-2">État Civil</h3>
                    
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-2xl text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Sexe</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-200">{{ $student->sexe }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-2xl text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Date et lieu de naissance</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($student->date_naissance)->format('d M Y') }} à {{ $student->lieu_naissance }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Colonne 2 : Contact & Scolarité --}}
                <div class="space-y-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b pb-2">Scolarité & Contact</h3>

                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-2xl text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Email professionnel</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-200">{{ $student->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-2xl text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Téléphone</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-200">{{ $student->telephone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-2xl text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Spécialité actuelle</p>
                            <p class="font-bold text-gray-800 dark:text-white">
                                {{ $student->inscriptions->first()->specialite->nom_specialite ?? 'Aucune inscription active' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
