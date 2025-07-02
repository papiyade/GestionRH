<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhController;
use App\Http\Controllers\SuperadminController; 
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\EmployeeDetailController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\JobOfferController; 
use App\Http\Controllers\CandidatureController;





Route::get('/', function () {
   if (Auth::check()) {
        // L'utilisateur est connecté
        $user = Auth::user();
        
        // Vérifie le rôle de l'utilisateur et redirige
        if ($user->role == 'super_admin') {
            return redirect('superadmin');
        } elseif ($user->role == 'admin') {
            return redirect('admin_simple');
        }
        elseif($user->role == 'rh') {
            return redirect('rh_dashboard');
        }
        // Ajoute d'autres rôles si nécessaire
    }

    // Sinon, afficher la page d'accueil
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/admin/dashboard', [SuperadminController::class, 'index'])->name('superadmin');
    // Route::get('/admin/add', [SuperadminController::class, 'addAdmin'])->name('add_admin_view');
    // Route::post('/admin/add-admin', [SuperadminController::class, 'createUsers'])->name('add_admin');
    // Route::get('/admin/list-admin', [SuperadminController::class, 'adminList'])->name('list_admin');




    // Route::get('/admin/company/dashboard', [AdminController::class, 'index'])->name('admin_simple');

    

    
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/dashboard', [SuperadminController::class, 'index'])->name('superadmin');
    Route::get('/admin/add', [SuperadminController::class, 'addAdmin'])->name('add_admin_view');
    Route::post('/admin/add-admin', [SuperadminController::class, 'createUsers'])->name('add_admin');
    Route::get('/admin/list-admin', [SuperadminController::class, 'adminList'])->name('list_admin');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/company/dashboard', [AdminController::class, 'index'])->name('admin_simple');
    Route::get('/admin/company', [AdminController::class, 'companyView'])->name('company');
Route::post('/entreprise/store', [EntrepriseController::class, 'store'])->name('entreprise.store');
     Route::get('/entreprise/edit', [EntrepriseController::class, 'edit'])->name('entreprise.edit');
    Route::put('/entreprise/update', [EntrepriseController::class, 'update'])->name('entreprise.update');
    Route::get('/entreprise/redirection', [EntrepriseController::class, 'redirectionEntreprise'])
    ->name('entreprise.redirect');
    Route::get('/entreprise/employes', [EntrepriseController::class, 'getEmployesPremiereEntreprise'])->name('entreprise.employes');
    Route::get('/employes/create', [AdminController::class, 'formView'])->name('employe.create');
    Route::post('/employes/createe', [AdminController::class, 'createEmploye'])->name('create.employe');
    
});
Route::middleware(['auth','role:rh'])->group(function(){
    Route::get('/rh/dashboard',[RhController::class,'index'])->name('rh_dashboard');
    Route::get('/rh/employe', [RhController::class, 'employeView'])->name('employeList');
    Route::post('/team/create', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::post('/teams/{team}/description', [TeamController::class, 'updateDescription'])->name('teams.updateDescription');
    Route::post('/teams/{team}/add-member/{user}', [TeamController::class, 'addMember'])->name('teams.addMember');
    Route::post('/rh/users/create', [RhController::class, 'createUsers'])->name('rh.createUsers');
    Route::get('/rh/users/create', [RhController::class, 'createUserForm'])->name('rh.users.create');
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.members.remove');
    Route::get('/employe/{id}', [RhController::class, 'show'])->name('employe.show');
Route::get('/users/{id}', [EmployeeDetailController::class, 'show'])->name('users.show');
Route::post('/employee-details', [EmployeeDetailController::class, 'store'])->name('employee-details.store');
Route::post('/employee/document/store', [EmployeeDocumentController::class, 'storeDocument'])->name('employee.document.store');
Route::get('/rh-dashboard/offres', [JobOfferController::class, 'index'])->name('offres.index');

Route::post('/offres', [JobOfferController::class, 'store'])->name('offres.store');
Route::get('/offres/{offre}/edit', [JobOfferController::class, 'edit'])->name('offres.edit');

Route::put('/offres/{offre}', [JobOfferController::class, 'update'])->name('offres.update');

Route::patch('/offres/{offre}/update-status', [JobOfferController::class, 'updateStatus'])->name('offres.updateStatus');

Route::delete('/offres/{offre}', [JobOfferController::class, 'destroy'])->name('offres.destroy');

Route::get('/rh/candidature/candidat/list', [JobOfferController::class, 'list_offer'])->name('offres_candidat.index');

Route::get('/job-offers/{id}/details', [JobOfferController::class, 'showDetails']);

Route::get('/rh/candidature/candidat/{id}/depot', [JobOfferController::class, 'depotform'])->name('offres.depot');

Route::post('/candidature/{jobOffer}/store', [CandidatureController::class, 'store'])->name('candidatures.store');

Route::get('/rh/candidature/candidat/list-depot', [CandidatureController::class, 'index'])->name('candidatures.index');

Route::get('/rh/candidatures/{candidature}', [CandidatureController::class, 'show'])->name('rh.candidatures.show');


Route::post('/rh/candidatures/{candidature}/accepter', [CandidatureController::class, 'accept'])->name('rh.candidatures.accept');
Route::post('/rh/candidatures/{candidature}/rejeter', [CandidatureController::class, 'reject'])->name('rh.candidatures.reject');














    


    



    

});


require __DIR__.'/auth.php';
