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
        .bg-green { background-color: #d9ead3; }
        .bg-grey { background-color: #f3f4f6; }
        .text-left { text-align: left; padding-left: 5px; font-size: 8px; }
        
        /* Rotation pour les noms de modules longs si nécessaire */
        .vertical-text { font-size: 7px; height: 60px; }
        .module-code { font-weight: bold; display: block; }
        .module-name { font-size: 6px; font-style: italic; font-weight: normal; text-transform: lowercase; }
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

    {{-- Tableau des Résultats --}}
    <table class="results">
        <thead>
            <tr class="bg-green">
                <th rowspan="2" width="20">N°</th>
                <th rowspan="2">Noms et Prénoms</th>
                <th colspan="{{ $modulesNormaux->where('semestre', 1)->count() + 1 }}">SEMESTRE 1</th>
                <th colspan="{{ $modulesNormaux->where('semestre', 2)->count() + 1 }}">SEMESTRE 2</th>
                <th rowspan="2" width="40">BILAN<br>(70%)</th>
                <th rowspan="2" width="40">MOY.<br>GEN.</th>
            </tr>
            <tr class="bg-green">
                @foreach($modulesNormaux->where('semestre', 1) as $mod)
                    <th class="vertical-text">
                        <span class="module-code">{{ $mod->code_module }}</span>
                        <span class="module-name">{{ Str::limit($mod->nom_module, 15) }}</span>
                    </th>
                @endforeach
                <th>MOY S1</th>
                @foreach($modulesNormaux->where('semestre', 2) as $mod)
                    <th class="vertical-text">
                        <span class="module-code">{{ $mod->code_module }}</span>
                        <span class="module-name">{{ Str::limit($mod->nom_module, 15) }}</span>
                    </th>
                @endforeach
                <th>MOY S2</th>






                
            </tr>
        </thead>
        <tbody>
            @foreach($etudiants as $index => $etudiant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left" style="font-weight: bold;">{{ $etudiant->name }}</td>
                    
                    {{-- S1 --}}
                    @foreach($modulesNormaux->where('semestre', 1) as $mod)
                        <td>{{ $etudiant->evaluations->where('module_id', $mod->id)->where('semestre', 1)->first()?->note ?? '-' }}</td>
                    @endforeach
                    <td class="bg-grey">{{ number_format($etudiant->moyenne_s1, 2) }}</td>

                    {{-- S2 --}}
                    @foreach($modulesNormaux->where('semestre', 2) as $mod)
                        <td>{{ $etudiant->evaluations->where('module_id', $mod->id)->where('semestre', 2)->first()?->note ?? '-' }}</td>
                    @endforeach
                    <td class="bg-grey">{{ number_format($etudiant->moyenne_s2, 2) }}</td>

                    {{-- Bilan --}}
                    <td style="font-weight: bold;">{{ $etudiant->evaluations->where('module_id', $moduleBilan->id)->first()?->note ?? '-' }}</td>
                    
                    {{-- Moyenne Générale --}}
                    <td style="background-color: #f4cccc; font-weight: bold; color: #b91c1c;">
                        {{ number_format($etudiant->calculerNoteFinale($anneeActive->id), 2) }}
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
