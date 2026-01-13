@extends('layouts.admin.layout-admin')

@section('content')
<div class="container mx-auto px-4 py-8 ml-0 md:ml-64 mt-16 dark:bg-neutral-900 min-h-screen">
    
    {{-- Boutons d'action --}}
    <div class="max-w-4xl mx-auto mb-4 flex justify-between no-print">
        {{-- Correction : on utilise specialite_id pour le retour --}}
        <a href="{{ route('bilan.index', ['specialite_id' => $etudiant->inscriptions->first()->specialite_id ?? '']) }}" class="text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white flex items-center gap-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour à la synthèse
        </a>
        <div class="flex gap-2">
            <a href="{{ route('releve.pdf', $etudiant->id) }}" class="bg-green-700 text-white px-4 py-2 rounded shadow hover:bg-green-800 transition text-sm font-bold">
                📥 Télécharger PDF
            </a>
        </div>
    </div>

    {{-- LE RELEVÉ DE NOTES --}}
    <div class="bg-white p-8 shadow-2xl border border-gray-300 max-w-4xl mx-auto text-black relative" id="printable-area">
        
        {{-- Filigrane --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
            {{-- <img src="{{ asset('images/logo.jpg') }}"    class="w-96"> --}}
        </div>

        {{-- En-tête mis à jour : Ministère de l'Emploi et Centre La Canadienne --}}
      {{-- En-tête avec Logo au milieu et bilingue --}}
<div class="flex justify-between items-start border-b-4 border-double border-black pb-4 mb-6">
    
    {{-- Bloc de Gauche : FRANÇAIS --}}
    <div class="text-center w-1/3 text-[8px] uppercase leading-tight font-bold pt-2">
        République du Cameroun<br>
        Paix - Travail - Patrie<br>
        -------<br>
        Ministère de l'Emploi et de la<br>Formation Professionnelle<br>
        -------<br>
        <span class="text-[9px]">Centre de Formation Professionnelle<br>La Canadienne</span>
    </div>

    {{-- Bloc Central : LOGO --}}
    <div class="text-center w-1/3 flex flex-col items-center justify-center">
        <img src="{{ asset('images/logo.jpg') }}" class="w-24 h-24 object-contain mb-1">
        <span class="font-black text-lg block leading-none border-t border-black pt-1">RELEVÉ DE NOTES</span>
        <span class="text-[9px] italic font-bold">ACADEMIC TRANSCRIPT</span>
    </div>

    {{-- Bloc de Droite : ANGLAIS --}}
    <div class="text-center w-1/3 text-[8px] uppercase leading-tight font-bold pt-2">
        Republic of Cameroon<br>
        Peace - Work - Fatherland<br>
        -------<br>
        Ministry of Employment and<br>Vocational Training<br>
        -------<br>
        <span class="text-[9px]">La Canadienne Professional<br>Training Center</span>
    </div>
</div>

        {{-- Infos Étudiant (SANS CLASSE) --}}
        <div class="grid grid-cols-2 gap-8 mb-6 text-sm uppercase">
            <div class="space-y-1">
                <p>Nom / Name: <span class="font-bold">{{ $etudiant->name }}</span></p>
                <p>Matricule: <span class="font-bold underline">{{ $etudiant->matricule ?? $etudiant->id }}</span></p>
                {{-- Affichage de la spécialité à la place du niveau --}}
                <p>Spécialité: <span class="font-bold">{{ $etudiant->inscriptions->first()->specialite->nom_specialite ?? 'N/A' }}</span></p>
            </div>
            <div class="space-y-1 text-right">
                <p>Année de Formation: <span class="font-bold">{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</span></p>
                <p>Durée du Cycle: <span class="font-bold text-xs">01 AN (FORMATION CONTINUE)</span></p>
            </div>
        </div>

        {{-- TABLEAU DES NOTES --}}
        <table class="w-full border-collapse border-2 border-black text-[11px] relative z-10 table-fixed">
            <thead>
                <tr class="bg-gray-200 uppercase">
                    <th class="border border-black p-2 text-left w-auto">Unités d'Enseignement (Modules)</th>
                    <th class="border border-black p-2 w-16 text-center">Coef</th>
                    <th class="border border-black p-2 w-20 text-center">Note / 20</th>
                    <th class="border border-black p-2 w-24 text-center bg-gray-300">Points</th>
                </tr>
            </thead>
          <tbody>
    {{-- SEMESTRE 1 --}}
    @php $ptsS1 = 0; $coefS1 = 0; @endphp
    <tr class="bg-gray-100 font-bold"><td colspan="4" class="border border-black p-1 px-4 italic uppercase">PREMIÈRE PÉRIODE (Semestre 1)</td></tr>
    @foreach($etudiant->evaluations->where('semestre', 1)->where('module.is_bilan', false) as $eval)
        @php 
            $c = $eval->module->coef_module ?? 1;
            $p = $eval->note * $c;
            $ptsS1 += $p; $coefS1 += $c;
        @endphp
        <tr>
            <td class="border border-black p-2 italic">{{ $eval->module->nom_module }}</td>
            <td class="border border-black p-2 text-center">{{ $c }}</td>
            <td class="border border-black p-2 text-center">{{ number_format($eval->note, 2) }}</td>
            <td class="border border-black p-2 text-center">{{ number_format($p, 2) }}</td>
        </tr>
    @endforeach
    {{-- Sous-total Semestre 1 --}}
    <tr class="bg-gray-50 font-bold">
        <td class="border border-black p-2 text-right uppercase">Sous-total Semestre 1:</td>
        <td class="border border-black p-2 text-center">{{ $coefS1 }}</td>
        <td class="border border-black p-2 bg-gray-100"></td>
        <td class="border border-black p-2 text-center">{{ number_format($ptsS1, 2) }}</td>
    </tr>

    {{-- SEMESTRE 2 --}}
    @php $ptsS2 = 0; $coefS2 = 0; @endphp
    <tr class="bg-gray-100 font-bold border-t-2 border-black"><td colspan="4" class="border border-black p-1 px-4 italic uppercase">DEUXIÈME PÉRIODE (Semestre 2)</td></tr>
    @foreach($etudiant->evaluations->where('semestre', 2)->where('module.is_bilan', false) as $eval)
        @php 
            $c = $eval->module->coef_module ?? 1;
            $p = $eval->note * $c;
            $ptsS2 += $p; $coefS2 += $c;
        @endphp
        <tr>
            <td class="border border-black p-2 italic">{{ $eval->module->nom_module }}</td>
            <td class="border border-black p-2 text-center">{{ $c }}</td>
            <td class="border border-black p-2 text-center">{{ number_format($eval->note, 2) }}</td>
            <td class="border border-black p-2 text-center">{{ number_format($p, 2) }}</td>
        </tr>
    @endforeach
    {{-- Sous-total Semestre 2 --}}
    <tr class="bg-gray-50 font-bold">
        <td class="border border-black p-2 text-right uppercase">Sous-total Semestre 2:</td>
        <td class="border border-black p-2 text-center">{{ $coefS2 }}</td>
        <td class="border border-black p-2 bg-gray-100"></td>
        <td class="border border-black p-2 text-center">{{ number_format($ptsS2, 2) }}</td>
    </tr>

    {{-- TOTAL GÉNÉRAL DES MODULES --}}
    <tr class="bg-blue-50 font-black border-t-2 border-black text-[12px]">
        <td class="border border-black p-2 text-right uppercase">TOTAL GÉNÉRAL </td>
        <td class="border border-black p-2 text-center">{{ $coefS1 + $coefS2 }}</td>
        <td class="border border-black p-2 text-center">Moy: {{ ($coefS1+$coefS2) > 0 ? number_format(($ptsS1+$ptsS2)/($coefS1+$coefS2), 2) : '0.00' }}</td>
        <td class="border border-black p-2 text-center">{{ number_format($ptsS1 + $ptsS2, 2) }}</td>
    </tr>

    {{-- SYNTHÈSE EXAMEN FINAL (70%) --}}
    @php 
        $evalBilan = $etudiant->evaluations->where('module.is_bilan', true)->first();
    @endphp
    @if($evalBilan)
    <tr class="bg-yellow-50 font-black border-t-4 border-black">
        <td class="border border-black p-3 uppercase">EXAMEN DE FIN DE FORMATION (70%)</td>
        <td class="border border-black p-2 text-center">1</td>
        <td class="border border-black p-2 text-center text-lg">{{ number_format($evalBilan->note, 2) }}</td>
        <td class="border border-black p-2 text-center text-lg">{{ number_format($evalBilan->note, 2) }}</td>
    </tr>
    @endif
</tbody>
        </table>

        {{-- Récapitulatif Final --}}
@php
    $moyFinale = $etudiant->calculerNoteFinale($anneeActive->id);
    
    if ($moyFinale >= 20) {
        $mention = 'Parfait';
    } elseif ($moyFinale >= 18) {
        $mention = 'Excellent';
    } elseif ($moyFinale >= 16) {
        $mention = 'Très Bien';
    } elseif ($moyFinale >= 14) {
        $mention = 'Bien';
    } elseif ($moyFinale >= 12) {
        $mention = 'Assez Bien';
    } elseif ($moyFinale >= 10) {
        $mention = 'Passable';
    } else {
        $mention = 'Faible';
    }
@endphp

        <div class="mt-6 flex justify-between items-start">
            <div class="w-1/3">
                <div class="border border-black p-2 text-[10px] font-bold bg-gray-50 uppercase space-y-1">
                    <p class="flex justify-between"><span>TOTAL MODULES:</span> <span>{{ $etudiant->evaluations->where('module.is_bilan', false)->count() }}</span></p>
                    <p class="flex justify-between text-green-700"><span>MODULES VALIDÉS:</span> <span>{{ $etudiant->evaluations->where('module.is_bilan', false)->where('note', '>=', 10)->count() }}</span></p>
                </div>
            </div>

            <div class="w-1/2">
                <table class="w-full border-collapse border-2 border-black text-xs font-bold">
                    <tr>
                        <td class="border border-black p-2 bg-gray-100 uppercase">Moyenne Contrôle Continu (30%)</td>
                        <td class="border border-black p-2 text-center">{{ ($coefS1+$coefS2) > 0 ? number_format(($ptsS1+$ptsS2)/($coefS1+$coefS2), 2) : '0.00' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black p-2 bg-green-700 text-white uppercase">Note Examen Bilan (70%)</td>
                        <td class="border border-black p-2 text-center">{{ number_format($evalBilan->note ?? 0, 2) }}</td>
                    </tr>
                    <tr class="bg-red-50 text-base">
                        <td class="border border-black p-2 font-black uppercase text-sm">Moyenne Générale de Fin de Formation</td>
                        <td class="border border-black p-2 text-center font-black">{{ number_format($moyFinale, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black p-2 uppercase text-[10px]">MENTION / GRADE</td>
                        <td class="border border-black p-2 text-center uppercase">{{ $mention }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Signatures --}}
        <div class="mt-10 flex justify-between italic">
            <div class="text-center w-1/3">
                <p class="underline font-bold text-[10px]">LE RESPONSABLE PÉDAGOGIQUE</p>
                <div class="h-16"></div>
            </div>
            <div class="text-center w-1/3">
                <p class="font-bold text-xs underline">DÉCISION:</p>
                <div class="mt-1 border-4 border-double border-black p-2 font-black text-xl uppercase">
                    {{ $moyFinale >= 10 ? 'Admis(e)' : 'Échec' }}
                </div>
            </div>
            <div class="text-center w-1/3">
                <p class="underline font-bold text-[10px]">LE DIRECTEUR DU CENTRE</p>
                <div class="h-16"></div>
                <p class="text-[9px] not-italic font-bold">Bafoussam, le {{ date('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
