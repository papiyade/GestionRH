@extends('layout.admin_rh')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #AE3D7D 0%, #861254ff 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(242, 101, 34, 0.2);
    }

    .profile-header h2 {
        color: #fff;
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }

    .profile-header .subtitle {
        margin-top: 5px;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 24px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .info-card-header {
        background: linear-gradient(90deg, #AE3D7D 0%, #861254FF 100%);
        color: white;
        padding: 16px 20px;
        border: none;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .info-card-body {
        padding: 24px;
    }

    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #555;
        min-width: 160px;
        display: flex;
        align-items: center;
    }

    .info-label i {
        margin-right: 8px;
        color: #AE3D7D;
        width: 20px;
    }

    .info-value {
    margin-left: 20%;
        color: #2c3e50;
        flex: 1;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-badge.validé {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.rejeté {
        background: #f8d7da;
        color: #721c24;
    }

    .status-badge.en-attente {
        background: #fff3cd;
        color: #856404;
    }

    .document-item {
        background: #f8f9fa !important;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.2s;
    }

    .document-item:hover {
        background: #e9ecef;
    }

    .document-item strong {
        color: #2c3e50 !important;
        font-size: 0.95rem;
    }

    .btn-download {
        background: white;
        border: 1px solid #AE3D7D;
        color: #AE3D7D;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .btn-download:hover {
        background: #AE3D7D;
        color: white;
    }

    .salary-highlight {
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #AE3D7D;
        margin-bottom: 20px;
    }

    .salary-amount {
        font-size: 2rem;
        font-weight: 700;
        color: #AE3D7D;
        margin: 10px 0;
    }

    .action-btn {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
        margin-bottom: 12px;
        border: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-btn.primary {
        background: linear-gradient(90deg, #AE3D7D 0%, #861254FF 100%);
        color: white;
    }

    .action-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(242, 101, 34, 0.3);
    }

    .action-btn.success {
        background: #156c29;
        color: white;
    }

    .action-btn.success:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .action-btn.danger {
        background: #b0212f;
        color: white;
    }

    .action-btn.danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    /* Styles pour masquer/afficher les salaires */
    .salary-hidden {
        filter: blur(8px);
        transition: filter 0.3s ease;
        user-select: none;
    }

    .salary-visible {
        filter: blur(0);
        transition: filter 0.3s ease;
    }

    #toggleSalaryBtn {
        transition: all 0.2s;
    }

    #toggleSalaryBtn:hover {
        background: rgba(255,255,255,0.3) !important;
        transform: scale(1.1);
    }
</style>

<script>
    let salaryVisible = false;

    function toggleSalaryVisibility() {
        const salaryElements = document.querySelectorAll('.salary-hidden, .salary-visible');
        const eyeIcon = document.getElementById('eyeIcon');

        salaryVisible = !salaryVisible;

        salaryElements.forEach(element => {
            if (salaryVisible) {
                element.classList.remove('salary-hidden');
                element.classList.add('salary-visible');
                element.textContent = element.getAttribute('data-value');
                eyeIcon.className = 'ti ti-eye icon-plus';
            } else {
                element.classList.remove('salary-visible');
                element.classList.add('salary-hidden');
                element.textContent = '••••••••' + (element.getAttribute('data-value').includes('FCFA') ? ' FCFA' : '');
                eyeIcon.className = 'ti ti-eye-off icon-plus';
            }
        });
    }
</script>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="profile-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>{{ $employee->nom_complet }}</h2>
                <div class="subtitle">{{ $employee->fiche_poste ?? 'Poste non défini' }}</div>
            </div>
            <a href="{{ route('rh.index') }}" class="btn btn-light text-primary">
                <i class="ti ti-arrow-left text-primary"></i> Retour à la liste
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Colonne principale --}}
        <div class="col-lg-8">
            {{-- Informations Personnelles --}}
            <div class="info-card">
                <div class="info-card-header">
                    <span ><i class="ti ti-info-square-rounded me-2"></i>Informations Personnelles</span>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-person"></i>Prénom
                        </div>
                        <div class="info-value">{{ $employee->prenom }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-person"></i>Nom
                        </div>
                        <div class="info-value">{{ $employee->nom }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-calendar"></i>Date de Naissance
                        </div>
                        <div class="info-value">{{ $employee->date_naissance->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-geo-alt"></i>Lieu de Naissance
                        </div>
                        <div class="info-value">{{ $employee->lieu_naissance }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-house"></i>Adresse
                        </div>
                        <div class="info-value">{{ $employee->adresse }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-pin-map"></i>Résidence Actuelle
                        </div>
                        <div class="info-value">{{ $employee->residence_actuelle }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-telephone"></i>Téléphone
                        </div>
                        <div class="info-value">{{ $employee->telephone }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-envelope"></i>Email
                        </div>
                        <div class="info-value">{{ $employee->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-briefcase"></i>Fiche de Poste
                        </div>
                        <div class="info-value">{{ $employee->fiche_poste }}</div>
                    </div>
                    {{-- <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-shield-check"></i>Statut
                        </div>
                        <div class="info-value">
                            @if($employee->statut === 'validé')
                                <span class="status-badge validé">Validé</span>
                            @elseif($employee->statut === 'rejeté')
                                <span class="status-badge rejeté">Rejeté</span>
                            @else
                                <span class="status-badge en-attente">En attente</span>
                            @endif
                        </div>
                    </div> --}}
                </div>
            </div>

            {{-- Documents --}}
            <div class="info-card">
                <div class="info-card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>Documents
                </div>
                <div class="info-card-body">
                    @php
                        $hasDocuments = $employee->photocopie_identite ||
                                      $employee->extrait_naissance ||
                                      $employee->certificat_residence ||
                                      $employee->fiche_dotation_materiels ||
                                      $employee->certificat_mariage;
                    @endphp

                    @if($hasDocuments)
                        @if($employee->photocopie_identite)
                        <div class="document-item">
                            <strong><i class="bi bi-file-earmark-pdf me-2"></i>Photocopie Identité/Passeport</strong>
                            <a href="{{ asset($employee->photocopie_identite) }}" target="_blank" class="btn-download">
                                <i class="bi bi-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->extrait_naissance)
                        <div class="document-item">
                            <strong><i class="bi bi-file-earmark-pdf me-2"></i>Extrait de Naissance</strong>
                            <a href="{{ asset($employee->extrait_naissance) }}" target="_blank" class="btn-download">
                                <i class="bi bi-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->certificat_residence)
                        <div class="document-item">
                            <strong><i class="bi bi-file-earmark-pdf me-2"></i>Certificat de Résidence</strong>
                            <a href="{{ asset($employee->certificat_residence) }}" target="_blank" class="btn-download">
                                <i class="bi bi-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->fiche_dotation_materiels)
                        <div class="document-item">
                            <strong><i class="bi bi-file-earmark-pdf me-2"></i>Fiche de Dotation</strong>
                            <a href="{{ asset($employee->fiche_dotation_materiels) }}" target="_blank" class="btn-download">
                                <i class="bi bi-download"></i> Télécharger
                            </a>
                        </div>
                        @endif

                        @if($employee->certificat_mariage)
                        <div class="document-item">
                            <strong><i class="bi bi-file-earmark-pdf me-2"></i>Certificat de Mariage</strong>
                            <a href="{{ asset('public/' . $employee->certificat_mariage) }}" target="_blank" class="btn-download">
                                <i class="bi bi-download"></i> Télécharger
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Aucun document disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Colonne latérale --}}
        <div class="col-lg-4">
            {{-- Informations Salaire --}}
            <div class="info-card">
                <div class="info-card-header d-flex justify-content-between align-items-center">
                    <span><i class="ti ti-alert-square-rounded me-2"></i>Informations Salariales</span>
                    <button onclick="toggleSalaryVisibility()" class="btn btn-sm" style="background: rgba(255,255,255,0.2); border: none; color: white;" id="toggleSalaryBtn">
                        <i class="ti ti-eye-off icon-plus" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="info-card-body">
                    @if($employee->salaire)
                        <div class="salary-highlight">
                            <small class="text-white">Salaire Net</small>
                            <div class="salary-amount salary-hidden text-white" data-value="{{ number_format($employee->salaire->salaire_net, 0, ',', ' ') }}">
                                ••••••••
                            </div>
                            <small class="text-white">FCFA</small>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Salaire de Base</div>
                            <div class="info-value2 salary-hidden text-primary fw-bold" data-value="{{ number_format($employee->salaire->salaire_base, 0, ',', ' ') }} FCFA">
                                •••••••• FCFA
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Prime</div>
                            <div class="info-value2 salary-hidden text-primary fw-bold" data-value="{{ number_format($employee->salaire->prime, 0, ',', ' ') }} FCFA">
                                •••••••• FCFA
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Déductions</div>
                            <div class="info-value2 salary-hidden text-primary fw-bold" data-value="{{ number_format($employee->salaire->deductions, 0, ',', ' ') }} FCFA">
                                •••••••• FCFA
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Date d'Effet</div>
                            <div class="info-value2">{{ $employee->salaire->date_effet->format('d/m/Y') }}</div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-cash"></i>
                            <p>Aucun salaire défini</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="info-card">
                <div class="info-card-header">
                    <i class="bi bi-lightning-charge me-2"></i>Actions Rapides
                </div>
                <div class="info-card-body">
                    <button onclick="location.href='{{ route('rh.edit', $employee) }}'" class="action-btn primary">
                        <i class="bi bi-pencil-square"></i>
                        Modifier la Fiche
                    </button>

                    <button onclick="location.href='{{ route('rh.salaire.edit', $employee) }}'" class="action-btn primary">
                        <i class="bi bi-cash-stack"></i>
                        {{ $employee->salaire ? 'Modifier' : 'Définir' }} le Salaire
                    </button>

                    <button onclick="location.href='{{ route('rh.fiche.generate', $employee) }}'" class="action-btn primary">
                        <i class="bi bi-file-pdf"></i>
                        Télécharger Fiche PDF
                    </button>

                    <button onclick="location.href='{{ route('rh.fiche.preview', $employee) }}'" class="action-btn success">
                        <i class="bi bi-file-earmark-text"></i>
                        Prévisualiser Fiche de Paie
                    </button>

                    <form action="{{ route('rh.destroy', $employee) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette fiche ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn danger">
                            <i class="bi bi-trash"></i>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
