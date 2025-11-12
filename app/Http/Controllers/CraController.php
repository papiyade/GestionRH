<?php

namespace App\Http\Controllers;

use App\Models\Cra;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CraController extends Controller
{
    /**
     * Liste tous les CRA de l'utilisateur connecté
     */
    public function index()
    {
        $entrepriseId = Auth::user()->entreprise_id;

        // Récupérer tous les utilisateurs de l'entreprise
        $usersEntreprise = \App\Models\User::where('entreprise_id', $entrepriseId)->pluck('id');

        // Récupérer tous les CRA de l'entreprise
        $cras = Cra::whereIn('user_id', $usersEntreprise)
                ->latest('date_debut')
                ->paginate(15);

        // Statistiques globales de l'entreprise
        $stats = method_exists($this, 'getStatistics') ? $this->getStatistics($usersEntreprise) : [];

        // Grouper les CRA par mois
        $crasParMois = $cras->getCollection()->groupBy(function ($cra) {
            return \Carbon\Carbon::parse($cra->created_at)->format('Y-m');
        });

        // Récupérer les équipes de l'utilisateur
        $teams = Auth::user()->teams()->get();

        return view('rh.cras.index', compact('cras', 'crasParMois', 'stats', 'teams'));
    }

    /**
     * Calcule les statistiques des CRA pour l'entreprise
     */
    private function getStatistics($usersId)
    {
        $now = \Carbon\Carbon::now();
        $startOfWeek = $now->clone()->startOfWeek();
        $endOfWeek = $now->clone()->endOfWeek();

        // Total des employés de l'entreprise
        $totalEmployes = count($usersId);

        // CRA reçus cette semaine
        $crasThisWeek = Cra::whereIn('user_id', $usersId)
                           ->whereBetween('date_debut', [$startOfWeek, $endOfWeek])
                           ->count();

        // Employés ayant soumis un CRA cette semaine
        $employesCrasThisWeek = Cra::whereIn('user_id', $usersId)
                                   ->whereBetween('date_debut', [$startOfWeek, $endOfWeek])
                                   ->distinct('user_id')
                                   ->count('user_id');

        // Taux de complétude cette semaine (%)
        $tauxCompletionThisWeek = $totalEmployes > 0 
            ? (($employesCrasThisWeek / $totalEmployes) * 100)
            : 0;

        // CRA reçus ce mois
        $crasThisMonth = Cra::whereIn('user_id', $usersId)
                            ->whereBetween('date_debut', [$now->clone()->startOfMonth(), $now->clone()->endOfMonth()])
                            ->count();

        // Employés ayant soumis un CRA ce mois
        $employesCrasThisMonth = Cra::whereIn('user_id', $usersId)
                                    ->whereBetween('date_debut', [$now->clone()->startOfMonth(), $now->clone()->endOfMonth()])
                                    ->distinct('user_id')
                                    ->count('user_id');

        // Total des CRA
        $totalCras = Cra::whereIn('user_id', $usersId)->count();

        // Employés n'ayant pas soumis de CRA cette semaine
        $employsManquantThisWeek = $totalEmployes - $employesCrasThisWeek;

        // CRA complétés cette semaine (avec tous les champs remplis)
        $crasCompletes = Cra::whereIn('user_id', $usersId)
                            ->whereBetween('date_debut', [$startOfWeek, $endOfWeek])
                            ->where('bien_fonctionne', '!=', null)
                            ->where('pas_bien_fonctionne', '!=', null)
                            ->where('points_durs', '!=', null)
                            ->where('next_steps', '!=', null)
                            ->count();

        // CRA complétés ce mois
        $crasCompletesMonth = Cra::whereIn('user_id', $usersId)
                                 ->whereBetween('date_debut', [$now->clone()->startOfMonth(), $now->clone()->endOfMonth()])
                                 ->where('bien_fonctionne', '!=', null)
                                 ->where('pas_bien_fonctionne', '!=', null)
                                 ->where('points_durs', '!=', null)
                                 ->where('next_steps', '!=', null)
                                 ->count();

        // CRA par jour cette semaine
        $crasByDay = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->clone()->addDays($i);
            $count = Cra::whereIn('user_id', $usersId)
                       ->whereDate('date_debut', $day)
                       ->count();
            $crasByDay[$day->format('D')] = $count;
        }

        // Employés ayant soumis des CRA (top 5)
        $topEmployes = Cra::whereIn('user_id', $usersId)
                          ->select('user_id')
                          ->selectRaw('COUNT(*) as cra_count')
                          ->groupBy('user_id')
                          ->orderBy('cra_count', 'desc')
                          ->limit(5)
                          ->with('user')
                          ->get();

        // Employés n'ayant jamais soumis de CRA
        $employesSansCra = User::where('entreprise_id', Auth::user()->entreprise_id)
                              ->whereNotIn('id', Cra::whereIn('user_id', $usersId)->pluck('user_id'))
                              ->get();

        return [
            'totalEmployes' => $totalEmployes,
            'crasThisWeek' => $crasThisWeek,
            'employesCrasThisWeek' => $employesCrasThisWeek,
            'employsManquantThisWeek' => $employsManquantThisWeek,
            'tauxCompletionThisWeek' => round($tauxCompletionThisWeek, 2),
            'crasThisMonth' => $crasThisMonth,
            'employesCrasThisMonth' => $employesCrasThisMonth,
            'totalCras' => $totalCras,
            'crasCompletes' => $crasCompletes,
            'crasCompletesMonth' => $crasCompletesMonth,
            'crasByDay' => $crasByDay,
            'topEmployes' => $topEmployes,
            'employesSansCra' => $employesSansCra,
        ];
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $teams = Auth::user()->teams()->get();
        return view('rh.cras.create', compact('teams'));
    }

    /**
     * Enregistre un nouveau CRA
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_debut'           => 'required|date',
            'date_fin'             => 'required|date|after_or_equal:date_debut',
            'activites'            => 'required|string|min:10',
            'bien_fonctionne'      => 'nullable|string',
            'pas_bien_fonctionne'  => 'nullable|string',
            'points_durs'          => 'nullable|string',
            'next_steps'           => 'nullable|string',
            'commentaires'         => 'nullable|string',
            'team_id'              => 'nullable|exists:teams,id',
        ]);

        // Vérifier que l'utilisateur est membre de l'équipe s'il en sélectionne une
        if ($validated['team_id'] ?? null) {
            $team = Team::find($validated['team_id']);
            if (!$team->users->contains(Auth::id()) && $team->owner_id !== Auth::id()) {
                abort(403, 'Vous ne pouvez soumettre un CRA que pour vos équipes.');
            }
        }

        $validated['user_id'] = Auth::id();

        Cra::create($validated);

        return redirect()->route('cras.index')
            ->with('success', '✅ CRA soumis avec succès!');
    }

    /**
     * Affiche un CRA précis
     */
    public function show(Cra $cra)
    {
        $this->authorizeAccess($cra);

        return view('rh.cras.show', compact('cra'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Cra $cra)
    {
        $this->authorizeAccess($cra);

        $teams = Auth::user()->teams()->get();
        return view('rh.cras.edit', compact('cra', 'teams'));
    }

    /**
     * Met à jour un CRA
     */
    public function update(Request $request, Cra $cra)
    {
        $this->authorizeAccess($cra);

        $validated = $request->validate([
            'date_debut'           => 'required|date',
            'date_fin'             => 'required|date|after_or_equal:date_debut',
            'activites'            => 'required|string|min:10',
            'bien_fonctionne'      => 'nullable|string',
            'pas_bien_fonctionne'  => 'nullable|string',
            'points_durs'          => 'nullable|string',
            'next_steps'           => 'nullable|string',
            'commentaires'         => 'nullable|string',
            'team_id'              => 'nullable|exists:teams,id',
        ]);

        // Vérifier que l'utilisateur est membre de l'équipe s'il change l'équipe
        if ($validated['team_id'] ?? null) {
            $team = Team::find($validated['team_id']);
            if (!$team->users->contains(Auth::id()) && $team->owner_id !== Auth::id()) {
                abort(403, 'Vous ne pouvez assigner un CRA que pour vos équipes.');
            }
        }

        $cra->update($validated);

        return redirect()->route('cras.show', $cra)
            ->with('success', '✅ CRA mis à jour avec succès!');
    }

    /**
     * Supprime un CRA
     */
    public function destroy(Cra $cra)
    {
        $this->authorizeAccess($cra);

        $cra->delete();

        return redirect()->route('cras.index')
            ->with('success', '✅ CRA supprimé avec succès!');
    }

      /**
     * Affiche les CRA d'une équipe
     */
    public function teamCras(Team $team)
    {
        $this->authorizeTeamAccess($team);

        $cras = Cra::where('team_id', $team->id)
                   ->orWhereIn('user_id', $team->users->pluck('id'))
                   ->latest('date_debut')
                   ->get();

        return view('rh.cras.team-index', compact('team', 'cras'));
    }

    /**
     * Statistiques des CRA
     */
    public function statistics()
    {
        $stats = [
            'total_cras' => Cra::where('user_id', Auth::id())->count(),
            'this_week' => Cra::where('user_id', Auth::id())->thisWeek()->count(),
            'this_month' => Cra::where('user_id', Auth::id())->thisMonth()->count(),
            'completed' => Cra::where('user_id', Auth::id())
                ->whereNotNull('bien_fonctionne')
                ->whereNotNull('points_durs')
                ->count(),
        ];

        return view('rh.cras.statistics', compact('stats'));
    }

        /**
     * Statistiques des CRA
     */
    public function statistiques()
    {
        $usersId = User::where('entreprise_id', Auth::user()->entreprise_id)->pluck('id');

        $stats = [
            'total_cras' => Cra::whereIn('user_id', $usersId)->count(),
            'this_week' => Cra::whereIn('user_id', $usersId)->thisWeek()->count(),
            'this_month' => Cra::whereIn('user_id', $usersId)->thisMonth()->count(),
            'completed' => Cra::whereIn('user_id', $usersId)
                ->whereNotNull('bien_fonctionne')
                ->whereNotNull('points_durs')
                ->count(),
        ];

        return view('rh.cras.statistics', compact('stats'));
    }

        /**
     * Filtre les CRA par critères
     */
    public function filter(Request $request)
    {
        $entrepriseId = Auth::user()->entreprise_id;
        $usersEntreprise = User::where('entreprise_id', $entrepriseId)->pluck('id');

        $query = Cra::whereIn('user_id', $usersEntreprise);

        // Filtrer par utilisateur
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filtrer par période
        if ($request->date_start) {
            $query->where('date_debut', '>=', $request->date_start);
        }

        if ($request->date_end) {
            $query->where('date_fin', '<=', $request->date_end);
        }

        // Filtrer par statut de complétude
        if ($request->completion === 'complete') {
            $query->where('bien_fonctionne', '!=', null)
                  ->where('pas_bien_fonctionne', '!=', null)
                  ->where('points_durs', '!=', null)
                  ->where('next_steps', '!=', null);
        } elseif ($request->completion === 'incomplete') {
            $query->where(function ($q) {
                $q->whereNull('bien_fonctionne')
                  ->orWhereNull('pas_bien_fonctionne')
                  ->orWhereNull('points_durs')
                  ->orWhereNull('next_steps');
            });
        }

        $cras = $query->latest('date_debut')->get();
        $crasParMois = $cras->groupBy(function ($cra) {
            return \Carbon\Carbon::parse($cra->created_at)->format('Y-m');
        });

        $stats = $this->getStatistics($usersEntreprise);
        $teams = Auth::user()->teams()->get();

        return view('rh.cras.index', compact('cras', 'crasParMois', 'stats', 'teams'));
    }

    /**
     * Exporte un CRA en PDF
     */
    public function exportPdf(Cra $cra)
    {
        $this->authorizeAccess($cra);

        $pdf = PDF::loadView('rh.cras.pdf', compact('cra'));
        return $pdf->download('cra_' . $cra->user->name . '_' . $cra->date_debut->format('Y-m-d') . '.pdf');
    }

    /**
     * Vérifie que l'utilisateur connecté est bien propriétaire du CRA
     */
    private function authorizeAccess(Cra $cra)
    {
        if ($cra->user_id !== Auth::id()) {
            abort(403, '❌ Accès interdit - Vous n\'avez pas la permission d\'accéder à ce CRA.');
        }
    }

    /**
     * Vérifie que l'utilisateur est membre de l'équipe
     */
    private function authorizeTeamAccess(Team $team)
    {
        if (!$team->users->contains(Auth::id()) && $team->owner_id !== Auth::id()) {
            abort(403, '❌ Accès interdit - Vous n\'êtes pas membre de cette équipe.');
        }
    }

}
