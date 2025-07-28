<?php

// app/Http/Controllers/PublicJobOfferController.php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicJobOfferController extends Controller
{
    /**
     * Affiche la liste publique des offres d'une entreprise (sans login)
     */
    public function listByEntreprise(Request $request, Entreprise $entreprise): View
    {
        $query = JobOffer::query()->where('entreprise_id', $entreprise->id);

        if ($request->has('domaine') && $request->input('domaine') !== 'all') {
            $domaine = $request->input('domaine');
            $mappedSecteur = match ($domaine) {
                'web' => 'Informatique',
                'rh' => 'Ressources Humaines',
                'communication' => 'Communication',
                default => $domaine,
            };
            $query->where('secteur', $mappedSecteur);
        }

        $offres = $query->orderBy('created_at', 'desc')->get();

        foreach ($offres as $offre) {
            $dateLimite = \Carbon\Carbon::parse($offre->date_limite)->startOfDay();
            $aujourdHui = \Carbon\Carbon::now()->startOfDay();
            $diff = $aujourdHui->diffInDays($dateLimite, false);
            $joursRestants = max(0, $diff);

            $offre->joursRestants = $joursRestants;

            $offre->urgenceClass = match (true) {
                $joursRestants > 0 && $joursRestants <= 7 => 'text-danger',
                $joursRestants > 0 && $joursRestants <= 14 => 'text-warning',
                default => 'text-success',
            };

            $offre->badgeClass = match ($offre->type_contrat) {
                'CDI' => 'bg-success',
                'CDD' => 'bg-warning text-dark',
                'Stage' => 'bg-info',
                'Alternance' => 'bg-primary',
                'Freelance' => 'bg-secondary',
                default => 'bg-secondary',
            };

            $offre->domaineIcon = match ($offre->secteur) {
                'Informatique', 'Développement Web' => 'bi-code-slash',
                'Ressources Humaines', 'RH' => 'bi-people',
                'Communication' => 'bi-megaphone',
                default => 'bi-briefcase',
            };

            $offre->salaireDisplay = 'Non spécifié';
            if ($offre->salaire) {
                $offre->salaireDisplay = $offre->salaire . ' ' . ($offre->devise ?? '');
                if ($offre->periode_salaire) {
                    $offre->salaireDisplay .= ' / ' . $offre->periode_salaire;
                }
            }

            $offre->formattedDateLimite = \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y');
        }

        $currentDomaineFilter = $request->input('domaine', 'all');

        return view('public.offres.list', compact('offres', 'currentDomaineFilter', 'entreprise'));
    }
}
