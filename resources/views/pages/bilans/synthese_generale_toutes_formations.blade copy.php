<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* On réutilise tes styles existants */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; margin: 0; padding: 0; }
        .header-table { width: 100%; border: none; margin-bottom: 10px; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .text-upper { text-transform: uppercase; font-weight: bold; font-size: 8px; line-height: 1.2; }
        .title-box { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 15px; }
        .info-section { margin-bottom: 15px; font-size: 10px; }
        .info-grid { width: 100%; border: none; }
        table.results { width: 100%; border-collapse: collapse; }
        table.results th, table.results td { border: 1px solid #000; padding: 3px; text-align: center; }
        .bg-green { background-color: #d9ead3 !important; }
        .bg-grey { background-color: #e2efda !important; font-weight: bold; }
        .vertical-text { vertical-align: bottom; text-align: center; height: 80px; }
        .module-code { writing-mode: vertical-rl; transform: rotate(0deg); display: inline-block; font-weight: bold; font-size: 8px; }

        /* LE SECRET POUR LE MULTI-PAGE */
        .page-break {
            page-break-after: always;
        }
        /* Empêcher de couper un tableau en deux si possible */
        table { page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }
    </style>
</head>
<body>

@foreach($toutLeBilan as $index => $bilan)
    <div class="{{ !$loop->last ? 'page-break' : '' }}">
        
        {{-- En-tête (Français/Anglais) identique à ton modèle --}}
        <table class="header-table">
            <tr>
                <td width="35%" align="center" class="text-upper">
                    REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>-------<br>
                    MINISTERE DE L'EMPLOI ET DE LA FORMATION PROFESSIONNELLE
                </td>
                <td width="30%" align="center">
                    <img src="{{ public_path('images/logo.jpg') }}" style="width: 60px;">
                </td>
                <td width="35%" align="center" class="text-upper">
                    REPUBLIC OF CAMEROON<br>Peace - Work - Fatherland<br>-------<br>
                    MINISTRY OF EMPLOYMENT AND VOCATIONAL TRAINING
                </td>
            </tr>
        </table>

        <div class="title-box">
            <span style="font-size: 16px; font-weight: 900; display: block;">SYNTHÈSE DES RÉSULTATS PAR FORMATION</span>
            <span style="font-size: 9px;">SPECIALTY RESULTS SUMMARY</span>
        </div>

        {{-- Infos de la spécialité en cours --}}
        <div class="info-section">
            <table class="info-grid">
                <tr>
                    <td width="15%"><strong>FORMATION :</strong></td>
                    <td width="45%" style="text-transform: uppercase;"><strong>{{ $bilan['specialite']->nom_specialite }}</strong></td>
                    <td width="15%"><strong>SESSION :</strong></td>
                    <td width="25%">{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</td>
                </tr>
            </table>
        </div>

        {{-- Tableau des notes --}}
        <table class="results">
            <thead>
                <tr class="bg-green">
                    <th rowspan="2" width="20">N°</th>
                    <th rowspan="2" width="150">Noms et prénoms</th>
                    {{-- S1 --}}
                    @php $modsS1 = $bilan['modulesNormaux']->filter(fn($m) => $m->pivot->semestre == 1 || $m->pivot->semestre == 'S1'); @endphp
                    <th colspan="{{ $modsS1->count() }}">Semestre 1</th>
                    <th rowspan="2" class="bg-grey">MOY S1</th>
                    {{-- S2 --}}
                    @php $modsS2 = $bilan['modulesNormaux']->filter(fn($m) => $m->pivot->semestre == 2 || $m->pivot->semestre == 'S2'); @endphp
                    <th colspan="{{ $modsS2->count() }}">Semestre 2</th>
                    <th rowspan="2" class="bg-grey">MOY S2</th>
                    <th rowspan="2" width="40">BILAN (70%)</th>
                    <th rowspan="2" width="40" style="background-color: #fce5cd;">MOY.GEN</th>
                </tr>
                <tr class="bg-green">
                    @foreach($modsS1 as $mod) <th class="vertical-text"><span class="module-code">{{ $mod->code_module }}</span></th> @endforeach
                    @foreach($modsS2 as $mod) <th class="vertical-text"><span class="module-code">{{ $mod->code_module }}</span></th> @endforeach
                </tr>
            </thead>
            <tbody>
    @foreach($bilan['etudiants'] as $idx => $etudiant)
    <tr>
        <td>{{ $idx + 1 }}</td>
        <td style="text-align: left; padding-left: 5px;">{{ $etudiant->name }}</td>
        
        {{-- Notes S1 --}}
        @foreach($modsS1 as $mod)
            <td>{{ number_format($etudiant->evaluations->where('module_id', $mod->id)->first()?->note ?? 0, 0) }}</td>
        @endforeach
        <td class="bg-grey">{{ number_format($etudiant->moyenne_s1, 2) }}</td>
        
        {{-- Notes S2 --}}
        @foreach($modsS2 as $mod)
            <td>{{ number_format($etudiant->evaluations->where('module_id', $mod->id)->first()?->note ?? 0, 0) }}</td>
        @endforeach
        <td class="bg-grey">{{ number_format($etudiant->moyenne_s2, 2) }}</td>

        {{-- Note Bilan (LIGNE CORRIGÉE POUR ÉVITER L'ERREUR) --}}
        <td>
            @if($bilan['moduleBilan'])
                {{ number_format($etudiant->evaluations->where('module_id', $bilan['moduleBilan']->id)->first()?->note ?? 0, 2) }}
            @else
                <span style="color:red">N/A</span>
            @endif
        </td>

        {{-- Moyenne Générale --}}
        <td style="background-color: #fce5cd; font-weight: bold;">
            {{ number_format($etudiant->moyenne_generale, 2) }}
        </td>
    </tr>
    @endforeach
</tbody>
        </table>

        {{-- Statistiques et signatures --}}
        <div style="margin-top: 15px;">
            <div style="width: 45%; float: left;">
                <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
                    <tr style="background-color: #eee;"><th colspan="2" style="border: 1px solid #000; padding: 3px;">RÉSUMÉ {{ $bilan['specialite']->nom_specialite }}</th></tr>
                    <tr><td style="border: 1px solid #000; padding: 2px;">Admis / Échecs</td><td style="border: 1px solid #000; padding: 2px;">{{ $bilan['stats']['admis'] }} / {{ $bilan['stats']['echoues'] }}</td></tr>
                    <tr><td style="border: 1px solid #000; padding: 2px;">Taux de réussite</td><td style="border: 1px solid #000; padding: 2px;">{{ number_format(($bilan['stats']['admis'] / max($bilan['stats']['total'], 1)) * 100, 2) }}%</td></tr>
                </table>
            </div>
            <div style="width: 40%; float: right; text-align: center;">
                <p>Le Directeur du Centre</p>
                <br><br>
                <p><strong>(Signature & Cachet)</strong></p>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>
@endforeach

</body>
</html>
