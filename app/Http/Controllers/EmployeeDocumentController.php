<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeDocument;



class EmployeeDocumentController extends Controller
{
    //
  public function storeDocument(Request $request)
{
    // Valider les données
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'type_document' => 'required|string|max:255',
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    // Stocker le fichier
    $filePath = $request->file('document')->store('documents', 'public');

    // Enregistrer dans la base de données
    EmployeeDocument::create([
        'user_id' => $validated['user_id'],
        'type_document' => $validated['type_document'],
        'file_path' => $filePath,
    ]);

    return redirect()->back()->with('success_document', 'Document employé ajouté avec succès.');
}
}
