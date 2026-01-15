<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; margin: 0; padding: 20px; color: #333; }
        
        /* En-tête */
        .header-table { width: 100%; border: none; margin-bottom: 20px; }
        .header-table td { border: none; text-align: center; vertical-align: top; text-transform: uppercase; font-weight: bold; font-size: 8px; }
        
        .title-box { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; }

        /* Style du grand tableau unique */
        table.results { width: 100%; border-collapse: collapse; page-break-inside: auto; }
        table.results thead { display: table-header-group; } /* Répète l'entête sur chaque page physique */
        
        table.results th { background-color: #f2f2f2; border: 1px solid #000; padding: 6px; text-transform: uppercase; font-size: 9px; }
        table.results td { border: 1px solid #000; padding: 5px; text-align: center; }

        /* Ligne de séparation pour changer de spécialité sans changer de page */
        .row-specialite { background-color: #444 !important; color: white; font-weight: bold; text-align: left !important; padding-left: 10px !important; }
        
        .name-cell { text-align: left !important; padding-left: 8px !important; }
        .moy-gen { font-weight: bold; background-color: #fce5cd; } /* Ton orange clair */
        
        .text-admis { color: green; font-weight: bold; }
        .text-echec { color: red; font-weight: bold; }
        .page-break {
    page-break-after: always;
}

table { page-break-inside: auto; }
tr    { page-break-inside: avoid; page-break-after: auto; }
thead { display: table-header-group; }
tfoot { display: table-footer-group; }
    </style>
</head>
<body>

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td width="35%">REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>-------<br>MINEFOP</td>
            <td width="30%"><img src="{{ public_path('images/logo.jpg') }}" style="width: 50px;"></td>
            <td width="35%">REPUBLIC OF CAMEROON<br>Peace - Work - Fatherland<br>-------<br>MINEFOP</td>
        </tr>
    </table>

    <div class="title-box">
        <h2 style="margin: 0;">SYNTHÈSE GÉNÉRALE DES RÉSULTATS ANNUELS</h2>
        <small>SESSION : {{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</small>
    </div>

    <table class="results">
        <thead>
            <tr>
                <th width="30">RANG</th>
                <th width="80">MATRICULE</th>
                <th>NOM & PRÉNOM</th>
                <th width="40">SPÉ.</th>
                <th width="40">S1</th>
                <th width="40">S2</th>
                <th width="40">BILAN</th>
                <th width="50">MOY. GÉN.</th>
                <th width="90">DÉCISION</th>
            </tr>
        </thead>
        <tbody>
            @foreach($toutLeBilan as $bilan)
                {{-- Ligne de titre de la spécialité --}}
                <tr>
                    <td colspan="9" class="row-specialite">
                        FORMATION : {{ strtoupper($bilan['specialite']->nom_specialite) }} 
                        (Taux de réussite : {{ number_format(($bilan['stats']['admis'] / max($bilan['stats']['total'], 1)) * 100, 2) }}%)
                    </td>
                </tr>

                {{-- Liste des étudiants de cette spécialité --}}
                @foreach(collect($bilan['etudiants'])->sortByDesc('moyenne_generale')->values() as $idx => $etudiant)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td style="font-size: 8px;">{{ $etudiant->matricule ?? '---' }}</td>
                    <td class="name-cell">{{ strtoupper($etudiant->name) }}</td>
                    <td>{{ $bilan['specialite']->code_unique ?? substr($bilan['specialite']->nom_specialite, 0, 3) }}</td>
                    <td>{{ number_format($etudiant->moyenne_s1, 2) }}</td>
                    <td>{{ number_format($etudiant->moyenne_s2, 2) }}</td>
                    <td>
                        @if($bilan['moduleBilan'])
                            {{ number_format($etudiant->evaluations->where('module_id', $bilan['moduleBilan']->id)->first()?->note ?? 0, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="moy-gen">{{ number_format($etudiant->moyenne_generale, 2) }}</td>
                    <td>
                        @if($etudiant->moyenne_generale >= 10)
                            <span class="text-admis">ADMIS</span>
                        @else
                            <span class="text-echec">AJOURNÉ</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p style="text-align: right;">Fait à ......................., le .......................</p>
        <p style="text-align: right; margin-right: 50px;"><strong>Le Directeur</strong></p>
    </div>

</body>
</html>
