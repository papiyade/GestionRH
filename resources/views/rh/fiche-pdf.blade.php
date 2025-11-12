<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de Paie - {{ $employee->nom_complet }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Arial', sans-serif; font-size:12px; line-height:1.5; padding:20px; color:#333; }
        .header { text-align:center; border-bottom:3px solid #115f5f; padding-bottom:15px; margin-bottom:25px; }
        .header h1 { color:#115f5f; font-size:24px; margin-bottom:5px; }
        .header p { font-size:11px; color:#7f8c8d; }
        .section-title { background:#e8571e; color:#fff; padding:6px 10px; font-weight:bold; margin:20px 0 10px; font-size:14px; }
        .info-grid { display:table; width:100%; margin-bottom:15px; }
        .info-row { display:table-row; }
        .info-cell { display:table-cell; padding:8px; border:1px solid #ecf0f1; background:#f8f9fa; }
        .info-cell strong { color:#2c3e50; }
        table { width:100%; border-collapse:collapse; margin-bottom:15px; }
        th, td { border:1px solid #bdc3c7; padding:8px; text-align:left; }
        th { background:#34495e; color:#fff; }
        tr:nth-child(even) { background:#ecf0f1; }
        .amount { text-align:right; font-weight:bold; }
        .total-row { background:#77c698; color:#fff; font-weight:bold; }
        .total-row td { border:2px solid #4e7961; background:#4e7961; }
        .signature-section { display:table; width:100%; margin-top:50px; }
        .signature-box { display:table-cell; width:45%; text-align:center; padding:20px; }
        .signature-line { border-top:1px solid #000; margin-top:60px; padding-top:10px; }
        .footer { text-align:center; font-size:10px; color:#7f8c8d; margin-top:30px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BULLETIN DE SALAIRE</h1>
        <p>Date d'effet : {{ \Carbon\Carbon::parse($dernierSalaire->date_effet ?? now())->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
        <p>Émis le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    {{-- Informations Entreprise --}}
    <div class="section-title">INFORMATIONS ENTREPRISE</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell"><strong>Nom :</strong> {{ $employee->entreprise->entreprise_name }}</div>
            <div class="info-cell"><strong>Email :</strong> {{ $employee->entreprise->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell"><strong>Adresse :</strong> {{ $employee->entreprise->adresse }}</div>
            <div class="info-cell"><strong>Téléphone :</strong> {{ $employee->entreprise->telephone }}</div>
        </div>
    </div>

    {{-- Informations Employé --}}
    <div class="section-title">INFORMATIONS EMPLOYÉ</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell"><strong>Nom Complet :</strong> {{ $employee->nom_complet }}</div>
            <div class="info-cell"><strong>Matricule :</strong> EMP-{{ str_pad($employee->id,5,'0',STR_PAD_LEFT) }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell"><strong>Poste :</strong> {{ $employee->fiche_poste ?? '—' }}</div>
            <div class="info-cell"><strong>Date d'embauche :</strong> {{ $employee->created_at->format('d/m/Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell"><strong>Email :</strong> {{ $employee->email }}</div>
            <div class="info-cell"><strong>Téléphone :</strong> {{ $employee->telephone ?? '—' }}</div>
        </div>
    </div>

    {{-- Rubrique Salaire --}}
    <div class="section-title">RUBRIQUE SALAIRE</div>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Base (FCFA)</th>
                <th>Montant (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de base</td>
                <td class="amount">{{ number_format($salaireBase,0,',',' ') }}</td>
                <td class="amount">{{ number_format($salaireBase,0,',',' ') }}</td>
            </tr>
            <tr>
                <td>Sursalaire</td>
                <td class="amount">{{ number_format($sursalaire,0,',',' ') }}</td>
                <td class="amount">{{ number_format($sursalaire,0,',',' ') }}</td>
            </tr>
            <tr>
                <td>Prime</td>
                <td class="amount">{{ number_format($prime,0,',',' ') }}</td>
                <td class="amount">{{ number_format($prime,0,',',' ') }}</td>
            </tr>
            <tr>
                <td>Indemnité</td>
                <td class="amount">{{ number_format($indemnite,0,',',' ') }}</td>
                <td class="amount">{{ number_format($indemnite,0,',',' ') }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Brut</td>
                <td></td>
                <td class="amount">{{ number_format($brut,0,',',' ') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Rubriques Soumises --}}
    <div class="section-title">RUBRIQUES SOUMISES</div>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Taux Salarial (%)</th>
                <th>Taux Patronal (%)</th>
                <th>Part Salariale (FCFA)</th>
                <th>Part Patronale (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>IR</td>
                <td>-</td>
                <td>-</td>
                <td class="amount">{{ number_format($detail->ir ?? 0,0,',',' ') }}</td>
                <td class="amount">0</td>
            </tr>
            <tr>
                <td>TRIMF</td>
                <td>-</td>
                <td>-</td>
                <td class="amount">{{ number_format($detail->trimf ?? 0,0,',',' ') }}</td>
                <td class="amount">0</td>
            </tr>
            @php
                $cotNames = [
                    'ipres_regime_general' => 'IPRES (Régime Général)',
                    'ipres_regime_complementaire' => 'IPRES (Régime Complémentaire Cadre)',
                    'css' => 'CSS (Caisse)',
                    'accident_travail' => 'Accident du Travail',
                    'prestation_famille' => 'Prestation de Famille',
                    'ipm' => 'IPM (Assurance)',
                    'cfce' => 'CFCE (Contribution Employeur)',
                ];
            @endphp
            @foreach ($cotNames as $key => $label)
            <tr>
                <td>{{ $label }}</td>
                <td>{{ $taux[$key]['salarial'] }}%</td>
                <td>{{ $taux[$key]['patronal'] }}%</td>
                <td class="amount">{{ number_format($cotisations[$key]['salariale'],0,',',' ') }}</td>
                <td class="amount">{{ number_format($cotisations[$key]['patronale'],0,',',' ') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td></td>
                <td></td>
                <td class="amount">{{ number_format($totalSalariale,0,',',' ') }}</td>
                <td class="amount">{{ number_format($totalPatronale,0,',',' ') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Rubriques Non Soumises --}}
    <div class="section-title">RUBRIQUES NON SOUMISES</div>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Base (FCFA)</th>
                <th>Montant (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Indemnité de Transport</td>
                <td class="amount">{{ number_format($indemniteTransport,0,',',' ') }}</td>
                <td class="amount">{{ number_format($indemniteTransport,0,',',' ') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Net à Payer --}}
    <div class="section-title">NET À PAYER</div>
    <table>
        <tbody>
            <tr class="total-row">
                <td style="text-align:right;" colspan="2">Net à Payer</td>
                <td class="amount">{{ number_format($net,0,',',' ') }}</td>
            </tr>
        </tbody>
    </table>

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
        Pour vous aider à faire valoir vos droits, conservez ce bulletin sans limitation
    </div>

</body>
</html>
