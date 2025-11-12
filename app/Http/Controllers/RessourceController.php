<?php

namespace App\Http\Controllers;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RessourceController extends Controller
{
public function store(Request $request)
{
    // ✅ Validation des données
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'categorie' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'fichier' => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,doc,docx|max:10240', // 10 Mo max
    ]);

    // 📂 Si un fichier est envoyé
    if ($request->hasFile('fichier')) {
        $file = $request->file('fichier');

        // 📁 Dossier de destination dans /public/ressources
        $destinationPath = public_path('ressources');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // 🚀 Nom unique pour éviter les collisions
        $filename = uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // 🚚 Déplacement du fichier vers /public/ressources
        $file->move($destinationPath, $filename);

        // 📄 Enregistrement du chemin relatif pour la base
        $validated['file_path'] = 'ressources/' . $filename;
    }

    // 💾 Création de la ressource
    Ressource::create($validated);

    return redirect()->back()->with('success_ressource', 'Ressource ajoutée avec succès.');
}



    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);

        $ressource->delete();

        return redirect()->back()->with('success_ressource', 'Ressource supprimée avec succès.');
    }
}
