@extends('layouts.admin.layout-admin')

@section('content')
<div class="ml-64 p-8 mt-10">

    {{-- Entête --}}
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestion des Étudiants</h1>
            <p class="text-sm text-gray-500">Session active : <span class="text-blue-600 font-bold">{{ $anneeActive->libelle ?? 'N/A' }}</span></p>
        </div>
        <div class="text-sm text-gray-400">
            {{ $students->total() }} étudiant(s) trouvé(s)
        </div>
    </div>

    {{-- Zone de Filtres --}}
    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm mb-8 border border-gray-100 dark:border-gray-700">
        <form action="{{ route('students.indexList') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            
            {{-- Recherche --}}
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-400 mb-1 block">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou matricule..." 
                       class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            {{-- Filtre Classe --}}
            <div>
                <label class="text-xs font-semibold text-gray-400 mb-1 block">Classe</label>
                <select name="classe_id" onchange="this.form.submit()" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded-xl px-4 py-3 text-sm">
                    <option value="">Toutes</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ request('classe_id') == $c->id ? 'selected' : '' }}>{{ $c->nom_classe }}</option>
                    @endforeach
                </select>
            </div>

          

            {{-- Filtre Spécialité --}}
            <div>
                <label class="text-xs font-semibold text-gray-400 mb-1 block">Spécialité</label>
                <select name="specialite_id" onchange="this.form.submit()" class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded-xl px-4 py-3 text-sm">
                    <option value="">Toutes</option>
                    @foreach($specialites as $s)
                        <option value="{{ $s->id }}" {{ request('specialite_id') == $s->id ? 'selected' : '' }}>{{ $s->nom_specialite }}</option>
                    @endforeach
                </select>
            </div>

        </form>
    </div>

    {{-- Tableau --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Informations</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Classe</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Spécialité</th>
                    {{-- <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Niveau</th> --}}
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($students as $student)
                    @php
                        $insc = $student->inscriptions->first();
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $student->name }}</div>
                            <div class="text-xs text-blue-500 font-mono">{{ $student->matricule }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                            {{ $insc->classe->nom_classe ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                            {{ $insc->specialite->nom_specialite ?? 'N/A' }}
                        </td>
                        {{-- <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold uppercase">
                                {{ $insc->niveau ?? 'N/A' }}
                            </span>
                        </td> --}}
                        <td class="px-6 py-4 text-right">
                            <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                            Aucun étudiant ne correspond à cette recherche pour l'année active.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
