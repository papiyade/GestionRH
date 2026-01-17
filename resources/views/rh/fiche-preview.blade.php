@extends('layout.admin_rh')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Prévisualisation Fiche de Paie - {{ $employee->nom_complet }}</h4>
        </div>

        <div class="card-body">

            {{-- Informations Employé - Deux colonnes --}}
            <div class="mb-4">
                <h5 class="text-secondary">Informations Employé</h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Nom Complet</th>
                                <td>{{ $employee->nom_complet }}</td>
                            </tr>
                            <tr>
                                <th>Matricule</th>
                                <td>EMP-{{ str_pad($employee->id,5,'0',STR_PAD_LEFT) ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Poste</th>
                                <td>{{ $employee->fiche_poste ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Date d'embauche</th>
                                <td>{{ $employee->created_at->format('d/m/Y') ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Banque</th>
                                <td>{{ $employee->employeeDetail->banque_nom ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Compte</th>
                                <td>{{ $employee->numero_compte ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Rubrique Salaire --}}
            <div class="mb-4">
                <h5 class="text-secondary">Rubrique Salaire</h5>
                <table class="table table-striped">
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
                            <td>{{ number_format($salaireBase,0,',',' ') }}</td>
                            <td>{{ number_format($salaireBase,0,',',' ') }}</td>
                        </tr>
                        <tr>
                            <td>Sursalaire</td>
                            <td>{{ number_format($sursalaire,0,',',' ') }}</td>
                            <td>{{ number_format($sursalaire,0,',',' ') }}</td>
                        </tr>
                        <tr>
                            <td>Prime</td>
                            <td>{{ number_format($prime,0,',',' ') }}</td>
                            <td>{{ number_format($prime,0,',',' ') }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Indemnité</td>
                            <td>{{ number_format($indemnite,0,',',' ') }}</td>
                            <td>{{ number_format($indemnite,0,',',' ') }}</td>
                        </tr> --}}
                        <tr>
                            <td><strong>Total Brut</strong></td>
                            <td></td>
                            <td><strong>{{ number_format($brut,0,',',' ') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Rubriques Soumises - Nouveau format --}}
            <div class="mb-4">
                <h5 class="text-secondary">Rubriques Soumises</h5>
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle">Libellé</th>
                            <th colspan="2">Part Salariale</th>
                            <th colspan="2">Part Patronale</th>
                        </tr>
                        <tr>
                            <th>Taux (%)</th>
                            <th>Montant (FCFA)</th>
                            <th>Taux (%)</th>
                            <th>Montant (FCFA)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- IR --}}
                        <tr>
                            <td class="text-start">IR</td>
                            <td>-</td>
                            <td>{{ number_format($detail->ir ?? 0,0,',',' ') }}</td>
                            <td>-</td>
                            <td>0</td>
                        </tr>
                        {{-- TRIMF --}}
                        <tr>
                            <td class="text-start">TRIMF</td>
                            <td>-</td>
                            <td>{{ number_format($detail->trimf ?? 0,0,',',' ') }}</td>
                            <td>-</td>
                            <td>0</td>
                        </tr>
                        {{-- Autres cotisations --}}
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
                            <td class="text-start">{{ $label }}</td>
                            <td>{{ $taux[$key]['salarial'] }}%</td>
                            <td>{{ number_format($cotisations[$key]['salariale'],0,',',' ') }}</td>
                            <td>{{ $taux[$key]['patronal'] }}%</td>
                            <td>{{ number_format($cotisations[$key]['patronale'],0,',',' ') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td class="text-start">Total</td>
                            <td></td>
                            <td>{{ number_format($totalSalariale,0,',',' ') }}</td>
                            <td></td>
                            <td>{{ number_format($totalPatronale,0,',',' ') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Rubriques Non Soumises --}}
            <div class="mb-4">
                <h5 class="text-secondary">Rubriques Non Soumises</h5>
                <table class="table table-striped">
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
                            <td>{{ number_format($indemniteTransport,0,',',' ') }}</td>
                            <td>{{ number_format($indemniteTransport,0,',',' ') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Résumé Net à Payer --}}
            <div class="mb-4">
                <h5 class="text-secondary">Résumé du Paiement</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Total Brut</th>
                        <td>{{ number_format($brut,0,',',' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <th>Total Retenues (Part Salariale)</th>
                        <td>{{ number_format($totalSalariale,0,',',' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <th>Indemnité de Transport</th>
                        <td>{{ number_format($indemniteTransport,0,',',' ') }} FCFA</td>
                    </tr>
                    <tr class="table-primary">
                        <th>Net à Payer</th>
                        <td class="fw-bold text-primary">{{ number_format($net,0,',',' ') }} FCFA</td>
                    </tr>
                    <tr class="table-light">
                        <th colspan="2" class="text-center" style="font-style: italic; font-size: 0.95rem; color: #2c3e50; background-color: #f8f9fa; padding: 15px;">
                            <i class="bi bi-info-circle me-2"></i>
                            Arrêté le présent bulletin à la somme de : 
                            <span class="fw-bold text-dark">{{ numberToWords($net) }}</span> francs CFA
                        </th>
                    </tr>
                </table>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('rh.show', $employee) }}" class="btn btn-secondary me-2">Retour</a>
                <a href="{{ route('rh.fiche.generate', $employee) }}" target="_blank" class="btn btn-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Générer la Fiche PDF
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        background: linear-gradient(90deg, #007bff, #00b4d8);
    }
    h5.text-secondary {
        border-left: 4px solid #007bff;
        padding-left: 10px;
        margin-bottom: 10px;
    }
    table th, table td {
        vertical-align: middle !important;
    }

    /* Style pour les colonnes séparées */
    .col-md-6:first-child {
        border-right: 2px solid #dee2e6;
        padding-right: 20px;
    }

    .col-md-6:last-child {
        padding-left: 20px;
    }

    /* Style amélioré pour les tableaux imbriqués */
    thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>
@endpush
