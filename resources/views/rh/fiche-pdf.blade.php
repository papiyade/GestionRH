<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de Paie - {{ $employee->nom_complet }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Arial', sans-serif; font-size:14px; line-height:1.8; padding:17px; color:#333; }

        /* Optimisation pour tenir sur une page */
        @page { size: A4; margin: 10mm; }
        @media print { body { padding:0; } }

        .header { text-align:center; border-bottom:2px solid #6B7280; padding-bottom:8px; margin-bottom:12px; }
        .header h1 { color:#6B7280; font-size:18px; margin-bottom:3px; }
        .header p { font-size:9px; color:#7f8c8d; }
        .section-title { background:#6B7280; color:#fff; padding:4px 8px; font-weight:bold; margin:10px 0 6px; font-size:11px; }

        .salaire-lettre { text-align: center;}

        /* Informations en deux colonnes - Compacte */
        .info-grid { display:table; width:100%; margin-bottom:8px; border-collapse:collapse; }
        .info-row { display:table-row; }
        .info-cell { display:table-cell; width:50%; padding:5px; border:1px solid #ecf0f1; background:#f8f9fa; vertical-align:top; font-size:9px; }
        .info-cell strong { color:#2c3e50; }
        .info-cell-left { border-right:3px solid #6B7280; }

        /* Tables standards - Compactes */
        table { width:100%; border-collapse:collapse; margin-bottom:8px; }
        th, td { border:1px solid #bdc3c7; padding:4px 6px; text-align:left; font-size:9px; }
        th { background:#34495e; color:#fff; font-weight:bold; }
        tr:nth-child(even) { background:#ecf0f1; }
        .amount { text-align:right; font-weight:bold; }

        /* Table rubriques soumises avec colonnes imbriquées */
        .rubriques-table th { background:#34495e; color:#fff; font-weight:bold; text-align:center; padding:3px; }
        .rubriques-table .header-group { background:#6B7280; }
        .rubriques-table .sub-header { background:#415a6b; font-size:8px; }
        .rubriques-table td.label { text-align:left; }
        .rubriques-table td.center { text-align:center; }

        .total-row { background:#77c698; color:#fff; font-weight:bold; }
        .total-row td { border:2px solid #4e7961; background:#4e7961; }

        /* Signatures compactes */
        .signature-section { display:table; width:100%; margin-top:15px; }
        .signature-box { display:table-cell; width:45%; text-align:center; padding:10px; font-size:9px; }
        .signature-line { border-top:1px solid #000; margin-top:30px; padding-top:5px; }

        .footer { text-align:center; font-size:8px; color:#7f8c8d; margin-top:10px; }

        /* Réduction des marges pour les sections */
        .compact-section { margin-bottom:6px; }
    </style>
</head>
<body>

        <div class="header-logo">
@if ($employee->entreprise->logo_path) 
<img src="{{ public_path($employee->entreprise->logo_path) }}"
     alt="Logo entreprise"
     style="height:60px;">

@else
    <span>—</span>
@endif

    </div>
    <div class="header">
        <h1>BULLETIN DE SALAIRE</h1>
        <p>Date d'effet : {{ \Carbon\Carbon::parse($dernierSalaire->date_effet ?? now())->locale('fr')->isoFormat('D MMMM YYYY') }} | Émis le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    {{-- Informations Entreprise - Deux colonnes --}}
    <div class="section-title">INFORMATIONS ENTREPRISE</div>
    <div class="info-grid compact-section">
        <div class="info-row">
            <div class="info-cell info-cell-left">
                <strong>Nom :</strong> {{ $employee->entreprise->entreprise_name }}<br>
                <strong>Adresse :</strong> {{ $employee->entreprise->adresse }}
            </div>
            <div class="info-cell">
                <strong>Email :</strong> {{ $employee->entreprise->email }}<br>
                <strong>Téléphone :</strong> {{ $employee->entreprise->telephone }}
            </div>
        </div>
    </div>

    {{-- Informations Employé - Deux colonnes --}}
    <div class="section-title">INFORMATIONS EMPLOYÉ</div>
    <div class="info-grid compact-section">
        <div class="info-row">
            <div class="info-cell info-cell-left">
                <strong>Nom :</strong> {{ $employee->nom_complet }}<br>
                <strong>Poste :</strong> {{ $employee->fiche_poste ?? '—' }}
            </div>
            <div class="info-cell">
                <strong>Matricule :</strong> EMP-{{ str_pad($employee->id,5,'0',STR_PAD_LEFT) }}<br>
                <strong>Embauche :</strong> {{ $employee->created_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- Rubrique Salaire --}}
    <div class="section-title">RUBRIQUE SALAIRE</div>
    <table class="compact-section">
        <thead>
            <tr>
                <th>Libellé</th>
                <th style="width:25%;">Base (FCFA)</th>
                <th style="width:25%;">Montant (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de base</td>
                <td class="amount">{{ number_format($salaireBase,0,',',' ') }} F</td>
                <td class="amount">{{ number_format($salaireBase,0,',',' ') }} F</td>
            </tr>
            <tr>
                <td>Sursalaire</td>
                <td class="amount">{{ number_format($sursalaire,0,',',' ') }} F</td>
                <td class="amount">{{ number_format($sursalaire,0,',',' ') }} F</td>
            </tr>
            <tr>
                <td>Prime</td>
                <td class="amount">{{ number_format($prime,0,',',' ') }} F</td>
                <td class="amount">{{ number_format($prime,0,',',' ') }} F</td>
            </tr>
            <tr>
                <td>Indemnité</td>
                <td class="amount">{{ number_format($indemnite,0,',',' ') }} F</td>
                <td class="amount">{{ number_format($indemnite,0,',',' ') }} F</td>
            </tr>
            <tr class="total-row">
                <td>Total Brut</td>
                <td></td>
                <td class="amount">{{ number_format($brut,0,',',' ') }} F</td>
            </tr>
        </tbody>
    </table>

    {{-- Rubriques Soumises - Nouveau format avec colonnes imbriquées --}}
    <div class="section-title">RUBRIQUES SOUMISES</div>
    <table class="rubriques-table compact-section">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align:middle; width:30%;">Libellé</th>
                <th colspan="2" class="header-group">Part Salariale</th>
                <th colspan="2" class="header-group">Part Patronale</th>
            </tr>
            <tr>
                <th class="sub-header" style="width:10%;">Taux</th>
                <th class="sub-header" style="width:20%;">Montant</th>
                <th class="sub-header" style="width:10%;">Taux</th>
                <th class="sub-header" style="width:20%;">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label">IR</td>
                <td class="center">-</td>
                <td class="amount">{{ number_format($detail->ir ?? 0,0,',',' ') }}</td>
                <td class="center">-</td>
                <td class="amount">0</td>
            </tr>
            <tr>
                <td class="label">TRIMF</td>
                <td class="center">-</td>
                <td class="amount">{{ number_format($detail->trimf ?? 0,0,',',' ') }}</td>
                <td class="center">-</td>
                <td class="amount">0</td>
            </tr>
            @php
                $cotNames = [
                    'ipres_regime_general' => 'IPRES (Rég. Général)',
                    'ipres_regime_complementaire' => 'IPRES (Rég. Compl.)',
                    'css' => 'CSS',
                    'accident_travail' => 'Accident Travail',
                    'prestation_famille' => 'Prestation Famille',
                    'ipm' => 'IPM',
                    'cfce' => 'CFCE',
                ];
            @endphp
            @foreach ($cotNames as $key => $label)
            <tr>
                <td class="label">{{ $label }}</td>
                <td class="center">{{ $taux[$key]['salarial'] }}%</td>
                <td class="amount">{{ number_format($cotisations[$key]['salariale'],0,',',' ') }} F</td>
                <td class="center">{{ $taux[$key]['patronal'] }}%</td>
                <td class="amount">{{ number_format($cotisations[$key]['patronale'],0,',',' ') }} F</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td class="label">Total</td>
                <td></td>
                <td class="amount">{{ number_format($totalSalariale,0,',',' ') }} F</td>
                <td></td>
                <td class="amount">{{ number_format($totalPatronale,0,',',' ') }} F</td>
            </tr>
        </tbody>
    </table>

    {{-- Rubriques Non Soumises et Net à Payer en deux colonnes --}}
    <table style="width:100%; border:none; margin-bottom:8px;">
        <tr>
            <td style="width:48%; vertical-align:top; border:none; padding-right:2%;">
                <div class="section-title">RUBRIQUES NON SOUMISES</div>
                <table>
                    <thead>
                        <tr>
                            <th>Libellé</th>
                            <th style="width:40%;">Montant (FCFA)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Indemnité Transport</td>
                            <td class="amount">{{ number_format($indemniteTransport,0,',',' ') }} F</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width:48%; vertical-align:top; border:none; padding-left:2%;">
                <div class="section-title">NET À PAYER</div>
                <table>
                    <tbody>
                        <tr class="total-row">
                            <td style="text-align:right;">Net à Payer</td>
                            <td class="amount" style="width:50%; font-size:11px;">{{ number_format($net,0,',',' ') }} F</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>              
<div class="d-flex justify-content-center salaire-lettre">
    <p class="text-center fst-italic small text-secondary fw-bold  p-3 " style="font-style: italic; font-size: 0.75rem;">
        <i class="bi bi-info-circle me-2"></i>
        Arrêté le présent bulletin à la somme de :
        <span class="fw-bold text-dark">{{ numberToWords($net) }}</span>
        francs CFA
    </p>
</div>

    {{-- Signatures --}}
    <div class="signature-section">
        <div class="signature-box">
            <div>Signature Employeur</div>
            <div class="signature-line"></div>
        </div>
        <div class="signature-box">
            <div>Signature Employé</div>
            <div class="signature-line"></div>
        </div>
    </div>

    <div class="footer">
        Conservez ce bulletin sans limitation de durée pour faire valoir vos droits
    </div>

</body>
</html>
