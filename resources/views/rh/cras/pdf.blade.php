<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Rendu d'Activité (CRA)</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #2d2d2d; }
        h1 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .section-title { font-size: 15px; font-weight: bold; margin-top: 25px; margin-bottom: 10px; text-transform: uppercase; }
        .no-data { font-style: italic; color: #777; }
    </style>
</head>
<body>

    <h1>Compte Rendu d'Activité (CRA)</h1>

    {{-- 🔹 Informations Générales --}}
    <div class="section-title">Informations Générales</div>
    <table>
        <tr>
            <th>Nom</th>
            <td>{{ $cra->user->name ?? 'Utilisateur inconnu' }}</td>
        </tr>
        <tr>
            <th>Période</th>
            <td>
                Du {{ \Carbon\Carbon::parse($cra->date_debut)->format('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($cra->date_fin)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <th>Date de création</th>
            <td>{{ $cra->created_at ? $cra->created_at->format('d/m/Y') : '—' }}</td>
        </tr>
    </table>
    {{-- 🔹 Ce qui a bien fonctionné --}}
    <div class="section-title">Ce qui a bien fonctionné</div>
    @if(!empty($cra->bien_fonctionne))
        <p>{!! nl2br(e($cra->bien_fonctionne)) !!}</p>
    @else
        <p class="no-data">Aucune information renseignée.</p>
    @endif

    {{-- 🔹 Ce qui a mal fonctionné --}}
    <div class="section-title">Ce qui a mal fonctionné</div>
    @if(!empty($cra->pas_bien_fonctionne))
        <p>{!! nl2br(e($cra->pas_bien_fonctionne)) !!}</p>
    @else
        <p class="no-data">Aucune information renseignée.</p>
    @endif

    {{-- 🔹 Next Steps --}}
    <div class="section-title">Next Steps</div>
    @if(!empty($cra->next_steps))
        <p>{!! nl2br(e($cra->next_steps)) !!}</p>
    @else
        <p class="no-data">Aucune information renseignée.</p>
    @endif

    {{-- 🔹 Activités --}}
    <div class="section-title">Activités réalisées</div>
    <table>
        <thead>
            <tr>
                <th>Activité</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($cra->activites))
                @foreach(explode("\n", $cra->activites) as $activite)
                    @if(trim($activite) !== '')
                        <tr>
                            <td>{{ $activite }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td class="no-data">Aucune activité renseignée.</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- 🔹 Commentaires --}}
    <div class="section-title">Commentaires</div>
    @if(!empty($cra->commentaires))
        <p>{!! nl2br(e($cra->commentaires)) !!}</p>
    @else
        <p class="no-data">Aucun commentaire ajouté.</p>
    @endif

    {{-- 🔹 Génération --}}

    <p style="text-align:center; font-size:11px; margin-top:30px;">
        Généré automatiquement le {{ now()->format('d/m/Y à H:i') }}
    </p>

</body>
</html>
