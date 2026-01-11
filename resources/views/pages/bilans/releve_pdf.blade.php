<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #000; margin: 0; padding: 0; }
        .header-table { width: 100%; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 15px; }
        .text-center { text-align: center; }
        .uppercase { text-transform: uppercase; }
        .bold { font-weight: bold; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 2px 0; vertical-align: top; text-transform: uppercase; font-size: 10px; }
        .notes-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .notes-table th, .notes-table td { border: 1px solid #000; padding: 5px; }
        .bg-gray { background-color: #f2f2f2; }
        .bg-blue { background-color: #ebf8ff; }
        .bg-green { background-color: #e6fffa; }
        .recap-table { width: 50%; border-collapse: collapse; float: right; margin-top: 10px; }
        .recap-table td { border: 2px solid #000; padding: 5px; font-weight: bold; }
        .grade-scale { width: 45%; border: 1px solid #ccc; padding: 5px; font-style: italic; font-size: 8px; float: left; margin-top: 10px; }
        .signature-section { width: 100%; margin-top: 40px; clear: both; }
        .signature-box { width: 33.33%; float: left; text-align: center; }
        .decision-box { border: 3px double #000; padding: 8px 15px; display: inline-block; font-size: 14px; font-weight: bold; margin-top: 5px; }
        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; font-size: 7px; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="35%" class="text-center bold" style="font-size: 8px;">
                REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>---<br>MINISTERE DE L'ENSEIGNEMENT SUPERIEUR
            </td>
            <td width="30%" class="text-center">
                <span style="font-size: 14px; font-weight: 900; display: block;">RELEVÉ DE NOTES</span>
                <span style="font-size: 8px; font-style: italic;">ACADEMIC TRANSCRIPT</span>
            </td>
            <td width="35%" class="text-center bold" style="font-size: 8px;">
                REPUBLIC OF CAMEROON<br>Peace - Work - Fatherland<br>---<br>MINISTRY OF HIGHER EDUCATION
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td width="60%">Nom / Name: <span class="bold">{{ $etudiant->name }}</span></td>
            <td width="40%" style="text-align: right;">Année: <span class="bold">{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</span></td>
        </tr>
        <tr>
            <td>Matricule / ID: <span class="bold">{{ $etudiant->matricule ?? str_pad($etudiant->id, 4, '0', STR_PAD_LEFT) }}</span></td>
            <td style="text-align: right;">Spécialité: <span class="bold">{{ $etudiant->inscriptions->first()->specialite->nom_specialite ?? 'N/A' }}</span></td>
        </tr>
        <tr>
            <td>Niveau / Level: <span class="bold">{{ $etudiant->inscriptions->first()->classe->nom_classe ?? 'N/A' }}</span></td>
            <td></td>
        </tr>
    </table>

    <table class="notes-table">
        <thead>
            <tr class="bg-gray">
                <th align="left">Unités d'Enseignement (Modules)</th>
                {{-- Suppression de la colonne Sem. ici --}}
                <th width="40">Coef</th>
                <th width="60">Note/20</th>
                <th width="70">Points</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPointsGénéral = 0; $totalCoefsGénéral = 0; @endphp

            {{-- --- SEMESTRE 1 --- --}}
            <tr class="bg-gray"><td colspan="4" class="bold">SEMESTRE 1</td></tr>
            @php $ptsS1 = 0; $coefS1 = 0; @endphp
            @foreach($etudiant->evaluations->where('semestre', 1)->where('module.is_bilan', false) as $eval)
                @php 
                    $p = $eval->note * ($eval->module->coef_module ?? 1);
                    $ptsS1 += $p; $coefS1 += ($eval->module->coef_module ?? 1);
                @endphp
                <tr>
                    <td class="uppercase italic">{{ $eval->module->nom_module }}</td>
                    {{-- Pas de cellule Sem. ici --}}
                    <td class="text-center">{{ $eval->module->coef_module }}</td>
                    <td class="text-center bold">{{ number_format($eval->note, 2) }}</td>
                    <td class="text-center">{{ number_format($p, 2) }}</td>
                </tr>
            @endforeach
            <tr class="bg-blue bold">
                <td align="right">TOTAL & MOYENNE S1 :</td>
                <td class="text-center">{{ $coefS1 }}</td>
                <td class="text-center">{{ $coefS1 > 0 ? number_format($ptsS1 / $coefS1, 2) : '0.00' }}</td>
                <td class="text-center">{{ number_format($ptsS1, 2) }}</td>
            </tr>

            {{-- --- SEMESTRE 2 --- --}}
            <tr class="bg-gray"><td colspan="4" class="bold">SEMESTRE 2</td></tr>
            @php $ptsS2 = 0; $coefS2 = 0; @endphp
            @foreach($etudiant->evaluations->where('semestre', 2)->where('module.is_bilan', false) as $eval)
                @php 
                    $p = $eval->note * ($eval->module->coef_module ?? 1);
                    $ptsS2 += $p; $coefS2 += ($eval->module->coef_module ?? 1);
                @endphp
                <tr>
                    <td class="uppercase italic">{{ $eval->module->nom_module }}</td>
                    {{-- Pas de cellule Sem. ici --}}
                    <td class="text-center">{{ $eval->module->coef_module }}</td>
                    <td class="text-center bold">{{ number_format($eval->note, 2) }}</td>
                    <td class="text-center">{{ number_format($p, 2) }}</td>
                </tr>
            @endforeach
            <tr class="bg-blue bold">
                <td align="right">TOTAL & MOYENNE S2 :</td>
                <td class="text-center">{{ $coefS2 }}</td>
                <td class="text-center">{{ $coefS2 > 0 ? number_format($ptsS2 / $coefS2, 2) : '0.00' }}</td>
                <td class="text-center">{{ number_format($ptsS2, 2) }}</td>
            </tr>

            {{-- --- BILAN FINAL --- --}}
            @php 
                $totalPointsGénéral = $ptsS1 + $ptsS2;
                $totalCoefsGénéral = $coefS1 + $coefS2;
                $evalBilan = $etudiant->evaluations->where('module.is_bilan', true)->first();
            @endphp
            @if($evalBilan)
            <tr class="bg-green bold">
                <td class="uppercase">SYNTHÈSE GLOBALE (EXAMEN FINAL 70%)</td>
                <td class="text-center">1</td>
                <td class="text-center">{{ number_format($evalBilan->note, 2) }}</td>
                <td class="text-center">{{ number_format($evalBilan->note, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    @php
        $evalsModules = $etudiant->evaluations->where('module.is_bilan', false);
        $totalModules = $evalsModules->count();
        $modulesValides = $evalsModules->where('note', '>=', 10)->count();
        $modulesEchoues = $totalModules - $modulesValides;
        $moyFinale = $etudiant->calculerNoteFinale($anneeActive->id);
    @endphp

    <div class="recap-section" style="margin-top: 10px;">
        <div style="width: 45%; float: left;">
            <div style="border: 2px solid #000; padding: 5px; background-color: #f9f9f9; margin-bottom: 5px;">
                <table width="100%" style="border: none; font-size: 8px;">
                    <tr>
                        <td style="border: none; padding: 1px;">TOTAL MODULES :</td>
                        <td style="border: none; padding: 1px;" align="right" class="bold">{{ $totalModules }}</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px; color: green;">MODULES VALIDÉS :</td>
                        <td style="border: none; padding: 1px; color: green;" align="right" class="bold">{{ $modulesValides }}</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px; {{ $modulesEchoues > 0 ? 'color: red;' : '' }}">MODULES ÉCHOUÉS :</td>
                        <td style="border: none; padding: 1px; {{ $modulesEchoues > 0 ? 'color: red;' : '' }}" align="right" class="bold">{{ $modulesEchoues }}</td>
                    </tr>
                </table>
            </div>

            <div style="border: 1px solid #ccc; padding: 5px; font-style: italic; font-size: 7px;">
                <p class="bold underline uppercase" style="margin: 0; font-size: 7px;">Échelle de notation :</p>
                16-20 : Très Bien (A) | 14-15.99 : Bien (B+)<br>
                12-13.99 : Assez Bien (B) | 10-11.99 : Passable (C)<br>
                < 10 : Échec (F)
            </div>
        </div>

        <table class="recap-table" style="width: 50%; float: right; margin-top: 0;">
            <tr>
                <td class="bg-gray uppercase" style="font-size: 8px;">Moy. Évaluations (30%)</td>
                <td class="text-center" style="font-size: 10px;">{{ $totalCoefsGénéral > 0 ? number_format($totalPointsGénéral / $totalCoefsGénéral, 2) : '0.00' }}</td>
            </tr>
            <tr>
                <td class="bg-gray uppercase" style="font-size: 8px;">Examen Bilan (70%)</td>
                <td class="text-center" style="font-size: 10px;">{{ number_format($evalBilan->note ?? 0, 2) }}</td>
            </tr>
            <tr style="background-color: #f4cccc;">
                <td class="uppercase" style="font-size: 9px;">Moyenne Générale / 20</td>
                <td class="text-center" style="font-size: 14px; font-weight: 900;">{{ number_format($moyFinale, 2) }}</td>
            </tr>
        </table>
        <div style="clear: both;"></div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p class="bold underline uppercase" style="font-size: 7px;">Le Responsable Scolarité</p>
            <div style="height: 40px;"></div>
            <p style="font-size: 7px;">Sceau et Signature</p>
        </div>
        <div class="signature-box">
            <p class="bold uppercase" style="font-size: 9px;">Résultat Final:</p>
            <div class="decision-box">{{ $moyFinale >= 10 ? 'ADMIS(E)' : 'ÉCHEC' }}</div>
        </div>
        <div class="signature-box">
            <p class="bold underline uppercase" style="font-size: 7px;">Le Directeur Académique</p>
            <div style="height: 40px;"></div>
            <p style="font-size: 7px;">Fait à .................., le {{ $date }}</p>
        </div>
    </div>

    <div class="footer">
        TOUTE RATURE OU SURCHARGE ANNULE LE PRÉSENT RELEVÉ DE NOTES - DOCUMENT GÉNÉRÉ AUTOMATIQUEMENT
    </div>

</body>
</html>
