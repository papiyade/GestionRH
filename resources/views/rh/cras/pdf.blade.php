<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Rendu d'Activité (CRA)</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 15px;
            color: #2c3e50;
            line-height: 1.6;
            padding: 30px;
        }

        /* En-tête avec dégradé orange */
        .header {
            background: linear-gradient(135deg, #595f69 0%, #6B7280 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .header .subtitle {
            font-size: 12px;
            opacity: 0.95;
        }

        /* Card d'informations générales */
        .info-card {
            background: #f8f9fa;
            border: 2px solid #6B7280;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table th {
            text-align: left;
            padding: 8px 10px;
            font-weight: 600;
            color: #6B7280;
            width: 35%;
            font-size: 11px;
        }

        .info-table td {
            padding: 8px 10px;
            color: #2c3e50;
            font-size: 11px;
        }

        /* Sections de contenu */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-header {
            background: #6B7280;
            color: white;
            padding: 10px 15px;
            border-radius: 6px 6px 0 0;
            font-size: 13px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .section-header .icon {
            margin-right: 8px;
            font-size: 14px;
        }

        .section-content {
            background: white;
            border: 1px solid #e9ecef;
            border-top: none;
            border-radius: 0 0 6px 6px;
            padding: 15px;
            min-height: 40px;
        }

        .section-content p {
            margin: 0;
            color: #495057;
            line-height: 1.7;
        }

        /* Sections spéciales (positif/négatif) */
        .section-positive .section-header {
            background: #405044;
        }

        .section-negative .section-header {
            background: #786a6b;
        }

        .section-neutral .section-header {
            background: #6c757d;
        }

        /* Tableau des activités */
        .activities-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .activities-table thead {
            background: #f8f9fa;
        }

        .activities-table th {
            padding: 10px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }

        .activities-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            color: #495057;
            font-size: 10px;
            line-height: 1.5;
        }

        .activities-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        /* État vide */
        .no-data {
            font-style: italic;
            color: #adb5bd;
            padding: 10px 0;
        }

        /* Deux colonnes pour les sections bien/mal fonctionné */
        .two-columns {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .column {
            display: table-cell;
            width: 48%;
            vertical-align: top;
        }

        .column:first-child {
            padding-right: 10px;
        }

        .column:last-child {
            padding-left: 10px;
        }

        /* Pied de page */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            color: #6c757d;
            font-size: 10px;
        }

        .footer .logo {
            color: #6B7280;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Indicateur de période */
        .period-badge {
            display: inline-block;
            background: #fff5f0;
            border: 1px solid #5c626e;
            color: #6B7280;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 8px;
        }
    </style>
</head>
<body>

    {{-- En-tête principal --}}
    <div class="header">
        <h1 style="color: #6B7280"> COMPTE RENDU D'ACTIVITÉ</h1>
        <div style="color: #6B7280" class="subtitle">{{ $cra->user->name ?? 'Utilisateur inconnu' }}</div>
        <div class="period-badge">
             Du {{ \Carbon\Carbon::parse($cra->date_debut)->format('d/m/Y') }}
            au {{ \Carbon\Carbon::parse($cra->date_fin)->format('d/m/Y') }}
        </div>
    </div>

    {{-- Informations générales --}}
    <div class="info-card">
        <table class="info-table">
            <tr>
                <th> Employé</th>
                <td>{{ $cra->user->name ?? 'Utilisateur inconnu' }}</td>
            </tr>
            <tr>
                <th> Email</th>
                <td>{{ $cra->user->email ?? '—' }}</td>
            </tr>
            @if($cra->team)
            <tr>
                <th> Équipe</th>
                <td>{{ $cra->team->name }}</td>
            </tr>
            @endif
            <tr>
                <th> Période</th>
                <td>
                    Du {{ \Carbon\Carbon::parse($cra->date_debut)->format('d/m/Y') }}
                    au {{ \Carbon\Carbon::parse($cra->date_fin)->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <th> Date de création</th>
                <td>{{ $cra->created_at ? $cra->created_at->format('d/m/Y à H:i') : '—' }}</td>
            </tr>
            <tr>
                <th> Dernière modification</th>
                <td>{{ $cra->updated_at ? $cra->updated_at->format('d/m/Y à H:i') : '—' }}</td>
            </tr>
        </table>
    </div>

    {{-- Activités réalisées --}}
    <div class="section">
        <div class="section-header">
            <span class="icon">📌</span>
            <span>ACTIVITÉS / PROJETS RÉALISÉS</span>
        </div>
        <div class="section-content">
            @if(!empty($cra->activites))
                <table class="activities-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Activité</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach(explode("\n", $cra->activites) as $activite)
                            @if(trim($activite) !== '')
                                <tr>
                                    <td style="text-align: center; font-weight: 600;">{{ $count++ }}</td>
                                    <td>{{ $activite }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-data"> Aucune activité renseignée.</p>
            @endif
        </div>
    </div>

    {{-- Ce qui a bien/mal fonctionné (deux colonnes) --}}
    <div class="two-columns">
        <div class="column">
            <div class="section section-positive">
                <div class="section-header">
                    <span class="icon"></span>
                    <span>CE QUI A BIEN FONCTIONNÉ</span>
                </div>
                <div class="section-content">
                    @if(!empty($cra->bien_fonctionne))
                        <p>{!! nl2br(e($cra->bien_fonctionne)) !!}</p>
                    @else
                        <p class="no-data">Non renseigné</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="column">
            <div class="section section-negative">
                <div class="section-header">
                    <span class="icon"></span>
                    <span>CE QUI N'A PAS BIEN FONCTIONNÉ</span>
                </div>
                <div class="section-content">
                    @if(!empty($cra->pas_bien_fonctionne))
                        <p>{!! nl2br(e($cra->pas_bien_fonctionne)) !!}</p>
                    @else
                        <p class="no-data">Non renseigné</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Points durs / Faits marquants --}}
    <div class="section section-neutral">
        <div class="section-header">
            <span class="icon">⚠️</span>
            <span>POINTS DURS / FAITS MARQUANTS</span>
        </div>
        <div class="section-content">
            @if(!empty($cra->points_durs))
                <p>{!! nl2br(e($cra->points_durs)) !!}</p>
            @else
                <p class="no-data">Non renseigné</p>
            @endif
        </div>
    </div>

    {{-- Next Steps --}}
    <div class="section">
        <div class="section-header">
            <span class="icon">➡️</span>
            <span>PROCHAINES ÉTAPES (NEXT STEPS)</span>
        </div>
        <div class="section-content">
            @if(!empty($cra->next_steps))
                <p>{!! nl2br(e($cra->next_steps)) !!}</p>
            @else
                <p class="no-data">Non renseigné</p>
            @endif
        </div>
    </div>

    {{-- Commentaires / Recommandations --}}
    <div class="section section-neutral">
        <div class="section-header">
            <span class="icon">💬</span>
            <span>COMMENTAIRES / RECOMMANDATIONS</span>
        </div>
        <div class="section-content">
            @if(!empty($cra->commentaires))
                <p>{!! nl2br(e($cra->commentaires)) !!}</p>
            @else
                <p class="no-data">Non renseigné</p>
            @endif
        </div>
    </div>

    {{-- Pied de page --}}
    <div class="footer">
        <div class="logo">📄 CRA - Système de Gestion des Activités</div>
        <div>Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</div>
        <div style="margin-top: 5px; color: #ff6b35;">Ce document est confidentiel et destiné uniquement à un usage interne</div>
    </div>

</body>
</html>
