<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
   <style>
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; margin: 0; padding: 0; }
    
    /* En-tête officiel */
    .header-table { width: 100%; border: none; margin-bottom: 10px; }
    .header-table td { border: none; padding: 0; vertical-align: top; }
    .text-upper { text-transform: uppercase; font-weight: bold; font-size: 8px; line-height: 1.2; }
    .title-box { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 15px; }
    
    /* Infos de la classe */
    .info-section { margin-bottom: 15px; font-size: 10px; }
    .info-grid { width: 100%; border: none; }
    .info-grid td { border: none; text-align: left; padding: 2px 0; }

    /* Tableau des notes */
    table.results { width: 100%; border-collapse: collapse; }
    table.results th, table.results td { border: 1px solid #000; padding: 3px; text-align: center; }
    
    /* Couleurs du Design Pattern */
    .bg-green { background-color: #d9ead3 !important; }
    .bg-grey { background-color: #e2efda !important; font-weight: bold; }
    .text-left { text-align: left; padding-left: 5px; font-size: 8px; }

    /* REGLAGE DE LA ROTATION (CORRIGÉ) */
    .vertical-text {
        vertical-align: bottom;
        text-align: center;
        padding: 5px 2px !important;
        height: 80px; 
    }

    .module-code {
        writing-mode: vertical-rl;
        /* On retire le 180deg pour ne plus être à l'envers */
        transform: rotate(0deg); 
        white-space: nowrap;
        display: inline-block;
        font-weight: bold;
        font-size: 8px;
    }

    /* Style des cellules de notes */
    table.results td {
        height: 25px;
        border: 1px solid #999;
    }

    .moy-rouge {
        color: #ff0000 !important;
        font-weight: bold;
    }
</style>
</head>
<body>

 {{-- En-tête Officiel (Style Camerounais avec Établissement) --}}
<table class="header-table">
    <tr>
        {{-- Bloc Gauche (Français) --}}
        <td width="35%" align="center" class="text-upper">
            REPUBLIQUE DU CAMEROUN<br>
            Paix - Travail - Patrie<br>
            -------<br>
            MINISTERE DE L'EMPLOI ET DE LA<br>FORMATION PROFESSIONNELLE<br>
            -------<br>
            <span style="font-size: 9px; color: #000;">CENTRE DE FORMATION PROFESSIONNELLE<br>LA CANADIENNE</span>
        </td>

        {{-- Logo Central --}}
        <td width="30%" align="center" style="vertical-align: middle;">
            {{-- Utilisation de public_path pour garantir l'affichage sur DomPDF --}}
            <img src="{{ public_path('images/logo.jpg') }}" style="width: 80px; height: auto;">
        </td>

        {{-- Bloc Droite (Anglais) --}}
        <td width="35%" align="center" class="text-upper">
            REPUBLIC OF CAMEROON<br>
            Peace - Work - Fatherland<br>
            -------<br>
            MINISTRY OF EMPLOYMENT AND<br>VOCATIONAL TRAINING<br>
            -------<br>
            <span style="font-size: 9px; color: #000;">LA CANADIENNE VOCATIONAL<br>TRAINING CENTRE</span>
        </td>
    </tr>
</table>

    <div class="title-box">
        <span style="font-size: 18px; font-weight: 900; display: block;">SYNTHÈSE ANNUELLE DES RÉSULTATS</span>
        <span style="font-size: 10px; italic">ANNUAL ACADEMIC RESULTS SUMMARY</span>
    </div>

    {{-- Informations détaillées --}}
   {{-- Informations détaillées --}}
<div class="info-section">
    <table class="info-grid">
        <tr>
            <td width="15%"><strong>SESSION :</strong></td>
            <td width="35%">{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</td>
            <td width="15%"><strong>FORMATION :</strong></td>
            <td width="35%" style="text-transform: uppercase;"> 
                <strong>{{ $specialite->nom_specialite }}</strong> 
            </td>
        </tr>
        <tr>
            <td><strong>DATE D'ÉDITION :</strong></td>
            <td>{{ date('d/m/Y') }}</td>
            <td><strong>RÉFÉRENCE :</strong></td>
            <td>MINEFOP/CFP-LC/{{ date('Y') }}</td>
        </tr>
    </table>
</div>
<table class="results">
    <thead>
        <tr class="bg-green">
            <th rowspan="2" width="20">N°</th>
            <th rowspan="2" width="180">Noms et prénoms/names and first names</th>
            
            {{-- Correction Colspan S1 --}}
            @php $countS1 = $modulesNormaux->filter(fn($m) => $m->pivot->semestre == 1 || $m->pivot->semestre == 'S1')->count(); @endphp
            <th colspan="{{ $countS1 }}"> Semestre 1 </th>
            <th rowspan="2" class="bg-grey" width="35">MOY/20 EVAL1</th>

            {{-- Correction Colspan S2 --}}
            @php $countS2 = $modulesNormaux->filter(fn($m) => $m->pivot->semestre == 2 || $m->pivot->semestre == 'S2')->count(); @endphp
            <th colspan="{{ $countS2 }}">Semestre 2</th>
            <th rowspan="2" class="bg-grey" width="35">MOY/20 EVAL2</th>

            <th rowspan="2" width="60">MOY/20 Bilan des compétences (70%) skills assesment</th>
            <th rowspan="2" width="50" style="background-color: #fce5cd; color: #b91c1c;">MOY.GEN. (100%)</th>
        </tr>

        <tr class="bg-green">
            {{-- Boucle S1 avec filter --}}
            @foreach($modulesNormaux->filter(fn($m) => $m->pivot->semestre == 1 || $m->pivot->semestre == 'S1') as $mod)
                <th class="vertical-text">
                    <span class="module-code">{{ $mod->code_module }}</span>
                </th>
            @endforeach

            {{-- Boucle S2 avec filter --}}
            @foreach($modulesNormaux->filter(fn($m) => $m->pivot->semestre == 2 || $m->pivot->semestre == 'S2') as $mod)
                <th class="vertical-text">
                    <span class="module-code">{{ $mod->code_module }}</span>
                </th>
            @endforeach
        </tr>
    </thead>
    
    <tbody>
        @foreach($etudiants as $index => $etudiant)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left"><strong>{{ $etudiant->name }}</strong></td>
                
                {{-- Notes S1 --}}
                @foreach($modulesNormaux->filter(fn($m) => $m->pivot->semestre == 1 || $m->pivot->semestre == 'S1') as $mod)
                    @php $eval = $etudiant->evaluations->where('module_id', $mod->id)->first(); @endphp
                    <td>{{ $eval ? number_format($eval->note, 0) : '-' }}</td>
                @endforeach
                
                <td class="bg-grey"><strong>{{ number_format($etudiant->moyenne_s1, 2) }}</strong></td>

                {{-- Notes S2 --}}
                @foreach($modulesNormaux->filter(fn($m) => $m->pivot->semestre == 2 || $m->pivot->semestre == 'S2') as $mod)
                    @php $eval = $etudiant->evaluations->where('module_id', $mod->id)->first(); @endphp
                    <td>{{ $eval ? number_format($eval->note, 0) : '-' }}</td>
                @endforeach

                <td class="bg-grey"><strong>{{ number_format($etudiant->moyenne_s2, 2) }}</strong></td>

                {{-- Note Bilan --}}
                <td style="font-weight: bold;">
                    @php 
                        $noteBilan = $etudiant->evaluations->where('module_id', $moduleBilan->id)->first()?->note; 
                    @endphp
                    {{ $noteBilan !== null ? number_format($noteBilan, 2) : '-' }}
                </td>
                
                <td style="background-color: #fce5cd; font-weight: bold; color: #b91c1c;">
                    {{ number_format($etudiant->moyenne_generale, 2) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- Section Statistiques --}}
   {{-- Section Statistiques --}}
    <div style="margin-top: 20px; width: 50%; float: left;">
        <table style="width: 100%; border-collapse: collapse; font-size: 8px;">
            <thead>
                <tr style="background-color: #eee;">
                    <th colspan="2" style="border: 1px solid #000; padding: 4px;">STATISTIQUES DE LA FORMATION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000; padding: 3px;">Effectif Total</td>
                    <td style="border: 1px solid #000; padding: 3px; font-weight: bold;">{{ $stats['total'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 3px;">Nombre d'Admis (>= 10)</td>
                    <td style="border: 1px solid #000; padding: 3px; font-weight: bold; color: green;">{{ $stats['admis'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 3px;">Nombre d'Échecs</td>
                    <td style="border: 1px solid #000; padding: 3px; font-weight: bold; color: red;">{{ $stats['echoues'] }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 3px;">Taux de Réussite</td>
                    <td style="border: 1px solid #000; padding: 3px; font-weight: bold;">
                        {{ $stats['total'] > 0 ? number_format(($stats['admis'] / $stats['total']) * 100, 2) : 0 }} %
                    </td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="border: 1px solid #000; padding: 3px;">Moyenne de Formation</td>
                    <td style="border: 1px solid #000; padding: 3px; font-weight: bold;">{{ number_format($stats['moyenne_classe'], 2) }} / 20</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Bloc Signature (ajusté pour rester à droite) --}}
    <div style="margin-top: 20px; width: 40%; float: right; text-align: center; font-size: 10px;">
        <p>Fait à ......................., le {{ date('d/m/Y') }}</p>
        <br><br>
        <p style="font-weight: bold; text-decoration: underline;">Le Directeur</p>
    </div>

    <div style="clear: both;"></div> {{-- Important pour stopper le float --}}

</body>
</html>
