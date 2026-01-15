<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
  <style>
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1f2937; line-height: 1.4; }
    
    /* Couleurs institutionnelles */
    .text-main { color: #065f46; } /* Vert profond pour titres */
    .bg-main { background-color: #065f46; color: white; }
    .border-main { border: 1px solid #065f46; }
    
    .header-table { width: 100%; border: none; margin-bottom: 20px; }
    .text-upper { text-transform: uppercase; font-weight: bold; font-size: 8px; color: #374151; }
    
    .main-title { font-size: 24px; font-weight: 900; color: #111827; margin-bottom: 5px; text-align: center; }
    .separator { border-top: 3px solid #065f46; margin: 15px 0; }
    
    /* Stats de Tête - Style Cartes */
    .stats-header-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; margin-bottom: 20px; }
    .stats-card { border: 1px solid #e5e7eb; padding: 12px; text-align: center; background: #f9fafb; border-radius: 4px; }
    .label { font-size: 9px; font-weight: bold; color: #6b7280; text-transform: uppercase; margin-bottom: 4px; display: block; }
    .value { font-size: 18px; font-weight: bold; color: #111827; }
    .value-blue { color: #2563eb; } /* Bleu pour les taux/moyennes */

    /* Tableau des résultats */
    .results-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .results-table th { background-color: #065f46; color: white; padding: 10px 5px; text-transform: uppercase; font-size: 8px; border: 1px solid #065f46; }
    .results-table td { border: 1px solid #d1d5db; padding: 8px 5px; text-align: center; }
    .text-left { text-align: left; padding-left: 10px !important; }
    
    /* Mentions */
    .footer-stats { width: 100%; margin-top: 15px; border-collapse: collapse; }
    .footer-stats td { border: 1px solid #e5e7eb; padding: 12px 5px; text-align: center; }
    .mention-bg { background-color: #f0fdf4; }
</style>
</head>
<body>

<table class="header-table">
    <tr>
        <td width="35%" align="center" class="text-upper">
            REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>-------<br>
            MINISTERE DE L'EMPLOI ET DE LA FORMATION PROFESSIONNELLE
        </td>
        <td width="30%" align="center">
            {{-- Logo avec fallback si image absente --}}
            <img src="{{ public_path('images/logo.jpg') }}" style="height: 70px;">
        </td>
        <td width="35%" align="center" class="text-upper">
            REPUBLIC OF CAMEROON<br>Peace - Work - Fatherland<br>-------<br>
  MINISTRY OF EMPLOYMENT AND
VOCATIONAL TRAINING
        </td>
    </tr>
</table>

<div class="main-title">TABLEAU RÉCAPITULATIF DES RÉSULTATS</div>
<div style="text-align: center; font-size: 12px; color: #4b5563;">
    Session Académique : <strong>{{ $anneeActive->date_debut->format('Y') }} - {{ $anneeActive->date_fin->format('Y') }}</strong>
</div>

<div class="separator"></div>

{{-- 1. INDICATEURS DE PERFORMANCE GLOBALE --}}
<table class="stats-header-table">
    <tr>
        <td class="stats-card">
            <span class="label">Effectif Total</span>
            <span class="value">{{ $stats['total'] }}</span>
        </td>
        <td class="stats-card">
            <span class="label">Taux de Réussite</span>
            <span class="value value-blue">{{ number_format($stats['taux'], 1) }}%</span>
        </td>
        <td class="stats-card">
            <span class="label">Moyenne Générale</span>
            <span class="value">{{ number_format($stats['moyenne_promotion'], 2) }}</span>
        </td>
        <td class="stats-card">
            <span class="label">Major Promotion</span>
            <span class="value" style="font-size: 14px;">{{ number_format($stats['major_absolu']->moyenne_generale ?? 0, 2) }}</span>
        </td>
    </tr>
</table>

{{-- 2. DÉTAILS PAR FILIÈRE --}}
<table class="results-table">
    <thead>
        <tr>
            <th width="30">Rang</th>
            <th class="text-left">Spécialité / Filière de formation</th>
            <th width="50">Effectif</th>
            <th width="50">Admis</th>
            <th class="text-left">Major de Section</th>
            <th width="60">Moyenne</th>
            <th width="70">Taux</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bilanGlobal as $index => $item)
        <tr @if($index % 2 == 0) style="background-color: #ffffff;" @else style="background-color: #f9fafb;" @endif>
            <td><strong>{{ $index + 1 }}</strong></td>
            <td class="text-left"><strong>{{ $item['nom'] }}</strong></td>
            <td>{{ $item['effectif'] }}</td>
            <td style="font-weight: bold; color: #065f46;">{{ $item['admis'] }}</td>
            <td class="text-left" style="font-size: 8px;">{{ $item['major']->name ?? 'N/A' }}</td>
            <td style="background: #f0fdf4; font-weight: bold;">{{ number_format($item['major']->moyenne_generale ?? 0, 2) }}</td>
            <td style="font-weight: bold; color: #2563eb;">{{ number_format($item['taux'], 1) }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- 3. BILAN DES MENTIONS (VOTRE LOGIQUE) --}}
<div style="margin-top: 25px;">
    <div style="background-color: #065f46; color: white; padding: 5px 10px; font-weight: bold; text-transform: uppercase; font-size: 9px;">
        Répartition des Mentions Obtenues
    </div>
    <table class="footer-stats">
        <tr>
            <td class="mention-bg">
                <span class="label">Excellents / Parfaits</span>
                <span class="value" style="font-size: 14px;">{{ $stats['count_excellent'] }}</span>
            </td>
            <td class="mention-bg">
                <span class="label">Très Bien</span>
                <span class="value" style="font-size: 14px;">{{ $stats['count_tres_bien'] }}</span>
            </td>
            <td>
                <span class="label">Bien</span>
                <span class="value" style="font-size: 14px;">{{ $stats['count_bien'] }}</span>
            </td>
            <td>
                <span class="label">Assez Bien</span>
                <span class="value" style="font-size: 14px;">{{ $stats['count_assez_bien'] }}</span>
            </td>
            <td>
                <span class="label">Passables</span>
                <span class="value" style="font-size: 14px;">{{ $stats['count_passable'] }}</span>
            </td>
            <td style="background-color: #fef2f2;">
                <span class="label" style="color: #991b1b;">Ajournés</span>
                <span class="value" style="color: #b91c1c; font-size: 14px;">{{ $stats['total'] - $stats['admis'] }}</span>
            </td>
        </tr>
    </table>
</div>

{{-- 4. MISE EN AVANT DU MAJOR --}}
<div style="margin-top: 20px; border: 1.5px solid #065f46; border-radius: 4px; padding: 12px; background: #f0fdf4;">
    <table width="100%">
        <tr>
            <td width="15%" style="font-size: 20px;">🏆</td>
            <td>
                <span style="color: #065f46; font-weight: bold; text-transform: uppercase; font-size: 10px;">Major de la Promotion Académique</span><br>
                <span style="font-size: 15px; font-weight: 900; color: #111827;">{{ $stats['major_absolu']->name ?? 'N/A' }}</span>
                <span style="font-size: 10px; color: #4b5563;">({{ $stats['major_absolu']->specialite->nom_specialite ?? 'N/A' }})</span>
            </td>
            <td align="right" style="text-align: right;">
                <span class="label">Moyenne</span>
                <span style="font-size: 18px; font-weight: bold; color: #065f46;">{{ number_format($stats['major_absolu']->moyenne_generale ?? 0, 2) }} / 20</span><br>
                <span style="font-weight: bold; color: #2563eb; text-transform: uppercase;">Mention : {{ $stats['major_absolu']->mention_calculee }}</span>
            </td>
        </tr>
    </table>
</div>

{{-- SIGNATURES --}}
<table width="100%" style="margin-top: 40px;">
    <tr>
        <td width="50%" align="center">
            <div style="border-bottom: 1px solid #000; width: 150px; margin: 0 auto 5px auto;"></div>
            <p style="text-transform: uppercase; font-weight: bold; font-size: 9px;">Le Coordonateur</p>
        </td>
        <td width="50%" align="center">
            <p style="font-size: 10px; margin-bottom: 40px;">Fait à Bafoussam, le <strong>{{ $date }}</strong></p>
            <div style="border-bottom: 1px solid #000; width: 150px; margin: 0 auto 5px auto;"></div>
            <p style="text-transform: uppercase; font-weight: bold; font-size: 9px;">Le Directeur du Centre</p>
        </td>
    </tr>
</table>

</body>
</html>
