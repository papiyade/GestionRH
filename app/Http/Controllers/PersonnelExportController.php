<?php

namespace App\Http\Controllers;

use App\Exports\PersonnelRegistryExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Entreprise;
use App\Models\User;
use App\Models\EmployeDetail;

class PersonnelExportController extends Controller
{
    public function exportPersonnelRegistry(Request $request)
    {
        // Récupérer l'utilisateur connecté (RH)
        $currentUser = auth()->user();
        
        // Vérifier que l'utilisateur est un RH
        if ($currentUser->role !== 'rh') {
            return redirect()->back()->with('error', 'Accès non autorisé. Seuls les RH peuvent exporter le registre du personnel.');
        }
        
        // Récupérer l'entreprise de l'utilisateur connecté
        $entreprise = Entreprise::find($currentUser->entreprise_id);
        
        if (!$entreprise) {
            return redirect()->back()->with('error', 'Aucune entreprise associée à votre compte.');
        }
        
        // Récupérer tous les employés de l'entreprise avec leurs détails
        $employes = User::with('employeDetail')
            ->where('entreprise_id', $entreprise->id)
            ->get();
        
        // Nom du fichier avec le nom de l'entreprise et la date
        $fileName = 'Registre_Personnel_' . str_replace(' ', '_', $entreprise->entreprise_name) . '_' . date('Y_m_d') . '.xlsx';
        
        // Exporter vers Excel
        return Excel::download(
            new PersonnelRegistryExport($employes, $entreprise), 
            $fileName
        );
    }
}