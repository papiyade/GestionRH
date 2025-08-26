<?php

namespace App\Http\Controllers;
use App\Models\Ressource;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', 
            'categorie' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Ressource::create($validated);

    return redirect()->back()->with('success_ressource', 'Ressource ajouté avec succès.');
    }


    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);

        $ressource->delete();

        return redirect()->back()->with('success_ressource', 'Ressource supprimée avec succès.');
    }
}
