<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\EmployeeDocument;



class EmployeeDocumentController extends Controller
{
    //
public function storeDocument(Request $request)
{
    // ✅ Validation des données
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'type_document' => 'required|string|max:255',
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    // 📂 Dossier de destination dans /public/documents
    $destinationPath = public_path('documents');
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    // 📁 Nom unique pour éviter les collisions
    $file = $request->file('document');
    $filename = uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

    // 🚀 Déplacement du fichier vers /public/documents
    $file->move($destinationPath, $filename);

    // 📄 Sauvegarder le chemin relatif dans la base
    $filePath = 'documents/' . $filename;

    // 💾 Enregistrement dans la base de données
    EmployeeDocument::create([
        'user_id' => $validated['user_id'],
        'type_document' => $validated['type_document'],
        'file_path' => $filePath,
    ]);

    return redirect()->back()->with('success_document', 'Document employé ajouté avec succès.');
}

 function destroy($id)
{
    // Récupérer le document
    $document = EmployeeDocument::findOrFail($id);

    // Supprimer le fichier physique du disque
    if (Storage::disk('public')->exists($document->file_path)) {
        Storage::disk('public')->delete($document->file_path);
    }

    // Supprimer l'enregistrement de la base de données
    $document->delete();

    // Retour avec message de succès
    return redirect()->back()->with('success_document', 'Document supprimé avec succès.');
}
}
