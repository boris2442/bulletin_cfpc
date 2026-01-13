<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #000; margin: 0; padding: 0; }
        .header-table { width: 100%; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header-side { width: 35%; text-align: center; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .header-center { width: 30%; text-align: center; vertical-align: middle; }
        .logo { width: 70px; height: auto; }
        
        .title-main { font-size: 14px; font-weight: 900; display: block; margin-top: 5px; }
        .title-sub { font-size: 8px; font-style: italic; display: block; }

        .info-table { width: 100%; margin-bottom: 15px; text-transform: uppercase; }
        .bold { font-weight: bold; }
        
        .notes-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; border: 1px solid #000; }
        .notes-table th { background-color: #f2f2f2; border: 1px solid #000; padding: 5px; font-size: 9px; }
        .notes-table td { border: 1px solid #000; padding: 5px; }
        
        .bg-gray { background-color: #f9f9f9; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .recap-section { width: 100%; margin-top: 10px; }
        .recap-table { width: 50%; border-collapse: collapse; float: right; }
        .recap-table td { border: 2px solid #000; padding: 5px; font-weight: bold; }
        
        .signature-section { width: 100%; margin-top: 40px; clear: both; }
        .signature-box { width: 33.33%; float: left; text-align: center; font-size: 8px; }
        .decision-box { border: 4px double #000; padding: 10px; display: inline-block; font-size: 14px; font-weight: bold; margin-top: 5px; }

        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; font-size: 7px; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="header-side">
                REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>---<br>MINISTERE DE L'EMPLOI ET DE LA FORMATION PROFESSIONNELLE
            </td>
            <td class="header-center">
                {{-- Assure-toi que le logo est dans public/images/logo.jpg --}}
                <img src="{{ public_path('images/logo.jpg') }}" class="logo"><br>
                <span class="title-main">RELEVÉ DE NOTES</span>
                <span class="title-sub">ACADEMIC TRANSCRIPT</span>
            </td>
            <td class="header-side">
                REPUBLIC OF CAMEROON<br>Peace - Work - Fatherland<br>---<br>MINISTRY OF EMPLOYMENT AND VOCATIONAL TRAINING
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td width="60%">Nom / Name: <span class="bold">{{ $etudiant->name }}</span></td>
            <td width="40%" class="text-right">Année: <span class="bold">{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</span></td>
        </tr>
        <tr>
            <td>Matricule / ID: <span class="bold">{{ $etudiant->matricule ?? str_pad($etudiant->id, 4, '0', STR_PAD_LEFT) }}</span></td>
            <td class="text-right">Spécialité: <span class="bold">{{ $etudiant->inscriptions->first()->specialite->nom_specialite ?? 'N/A' }}</span></td>
        </tr>
    </table>

  <table class="notes-table">
        <thead>
            <tr>
                <th align="left">Unités d'Enseignement (Modules)</th>
                <th width="50">Coef</th>
                <th width="60">Note/20</th>
                <th width="70">Points</th>
            </tr>
        </thead>
        <tbody>
            {{-- SEMESTRE 1 --}}
            @php $ptsS1 = 0; $coefS1 = 0; @endphp
            <tr class="bg-gray"><td colspan="4">SEMESTRE 1</td></tr>
            @foreach($etudiant->evaluations->where('semestre', 1)->where('module.is_bilan', false) as $eval)
                @php 
                    $c = $eval->module->coef_module ?? 1;
                    $p = $eval->note * $c;
                    $ptsS1 += $p; $coefS1 += $c;
                @endphp
                <tr>
                    <td>{{ $eval->module->nom_module }}</td>
                    <td class="text-center">{{ $c }}</td>
                    <td class="text-center bold">{{ number_format($eval->note, 2) }}</td>
                    <td class="text-center">{{ number_format($p, 2) }}</td>
                </tr>
            @endforeach
            {{-- Total intelligent S1 --}}
            <tr style="background-color: #f0f0f0; font-weight: bold; font-style: italic;">
                <td class="text-right">Total Semestre 1 :</td>
                <td class="text-center">{{ $coefS1 }}</td>
                <td></td>
                <td class="text-center">{{ number_format($ptsS1, 2) }}</td>
            </tr>

            {{-- SEMESTRE 2 --}}
            @php $ptsS2 = 0; $coefS2 = 0; @endphp
            <tr class="bg-gray"><td colspan="4">SEMESTRE 2</td></tr>
            @foreach($etudiant->evaluations->where('semestre', 2)->where('module.is_bilan', false) as $eval)
                @php 
                    $c = $eval->module->coef_module ?? 1;
                    $p = $eval->note * $c;
                    $ptsS2 += $p; $coefS2 += $c;
                @endphp
                <tr>
                    <td>{{ $eval->module->nom_module }}</td>
                    <td class="text-center">{{ $c }}</td>
                    <td class="text-center bold">{{ number_format($eval->note, 2) }}</td>
                    <td class="text-center">{{ number_format($p, 2) }}</td>
                </tr>
            @endforeach
            {{-- Total intelligent S2 --}}
            <tr style="background-color: #f0f0f0; font-weight: bold; font-style: italic;">
                <td class="text-right">Total Semestre 2 :</td>
                <td class="text-center">{{ $coefS2 }}</td>
                <td></td>
                <td class="text-center">{{ number_format($ptsS2, 2) }}</td>
            </tr>

            {{-- TOTAL GÉNÉRAL CONTRÔLE CONTINU --}}
            <tr style="background-color: #e2e8f0; font-weight: bold; border-top: 2px solid #000;">
                <td class="text-right uppercase">Total Général Contrôle Continu (CC) :</td>
                <td class="text-center">{{ $coefS1 + $coefS2 }}</td>
                <td class="text-center" style="font-size: 8px;">Moy: {{ ($coefS1+$coefS2) > 0 ? number_format(($ptsS1+$ptsS2)/($coefS1+$coefS2), 2) : '0' }}</td>
                <td class="text-center">{{ number_format($ptsS1 + $ptsS2, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @php 
        $evalBilan = $etudiant->evaluations->where('module.is_bilan', true)->first();
        $moyFinale = $etudiant->calculerNoteFinale($anneeActive->id);
    @endphp

    <div class="recap-section">
        <table class="recap-table">
            <tr>
                <td style="background-color: #f2f2f2;">MOY. EVALUATIONS (30%)</td>
                <td class="text-center">{{ ($coefS1 + $coefS2) > 0 ? number_format(($ptsS1 + $ptsS2) / ($coefS1 + $coefS2), 2) : '0.00' }}</td>
            </tr>
            <tr>
                <td style="background-color: #f2f2f2;">EXAMEN BILAN (70%)</td>
                <td class="text-center">{{ number_format($evalBilan->note ?? 0, 2) }}</td>
            </tr>
            <tr style="background-color: #f4cccc;">
                <td>MOYENNE GÉNÉRALE / 20</td>
                <td class="text-center" style="font-size: 16px;">{{ number_format($moyFinale, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p class="bold underline">LE SURVEILLANT GÉNÉRAL</p>
        </div>
        <div class="signature-box">
            <p class="bold">RÉSULTAT:</p>
            <div class="decision-box">{{ $moyFinale >= 10 ? 'ADMIS(E)' : 'ÉCHEC' }}</div>
        </div>
        <div class="signature-box">
            <p class="bold underline">LE DIRECTEUR</p>
            <p style="margin-top: 40px;">Fait à .................., le {{ date('d/m/Y') }}</p>
        </div>
    </div>

    <div class="footer">
        TOUTE RATURE ANNULE LE PRÉSENT DOCUMENT - GÉNÉRÉ LE {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
