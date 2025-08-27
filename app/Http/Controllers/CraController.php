<?php

namespace App\Http\Controllers;

use App\Models\Cra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CraController extends Controller
{
    /**
     * Liste tous les CRA de l'utilisateur connecté
     */
    public function index()
    {
        $cras = Cra::where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('cras.index', compact('cras'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('cras.create');
    }

    /**
     * Enregistre un nouveau CRA
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_debut'   => 'required|date',
            'date_fin'     => 'required|date|after_or_equal:date_debut',
            'activites'    => 'required|string',
            'commentaires' => 'nullable|string',
        ]);

        Cra::create([
            'date_debut'   => $request->date_debut,
            'date_fin'     => $request->date_fin,
            'activites'    => $request->activites,
            'commentaires' => $request->commentaires,
            'user_id'      => Auth::id(), // 🔥 user connecté
        ]);

        return redirect()->route('cras.index')->with('success', 'CRA soumis avec succès.');
    }

    /**
     * Affiche un CRA précis
     */
    public function show(Cra $cra)
    {
        $this->authorizeAccess($cra);

        return view('cras.show', compact('cra'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Cra $cra)
    {
        $this->authorizeAccess($cra);

        return view('cras.edit', compact('cra'));
    }

    /**
     * Met à jour un CRA
     */
    public function update(Request $request, Cra $cra)
    {
        $this->authorizeAccess($cra);

        $request->validate([
            'date_debut'   => 'required|date',
            'date_fin'     => 'required|date|after_or_equal:date_debut',
            'activites'    => 'required|string',
            'commentaires' => 'nullable|string',
        ]);

        $cra->update($request->only(['date_debut', 'date_fin', 'activites', 'commentaires']));

        return redirect()->route('cras.index')->with('success', 'CRA mis à jour avec succès.');
    }

    /**
     * Supprime un CRA
     */
    public function destroy(Cra $cra)
    {
        $this->authorizeAccess($cra);

        $cra->delete();

        return redirect()->route('cras.index')->with('success', 'CRA supprimé avec succès.');
    }

    /**
     * Vérifie que l’utilisateur connecté est bien propriétaire du CRA
     */
    private function authorizeAccess(Cra $cra)
    {
        if ($cra->user_id !== Auth::id()) {
            abort(403, 'Accès interdit');
        }
    }
}
