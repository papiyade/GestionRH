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
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomMessagesController;
use App\Http\Controllers\ChefProjetcontroller;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\PublicJobOfferController;
use App\Http\Controllers\PersonnelExportController;






use Illuminate\Support\Facades\Mail;







Route::get('/', function () {
   if (Auth::check()) {

        $user = Auth::user();


        if ($user->role == 'super_admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role == 'admin') {
            return redirect('admin_simple');
        }
        elseif($user->role == 'rh') {
            return redirect('rh_dashboard');
        }
         elseif($user->role == 'chef_projet') {
            return redirect('/chef-projet/dashboard');
        }
        elseif($user->role == 'employe') {
            return redirect('/my-dashboard');
        }
    }


    return view('welcome');
});
Route::get('/import-db', function () {
    $sql = file_get_contents(base_path('projet-rh.sql'));
    DB::unprepared($sql);
    return 'Import terminé !';
});


Route::get('/test-mail', function () {
    Mail::raw('Ceci est un mail de test.', function ($message) {
        $message->to('malickwane26@gmail.com')
                ->subject('Test d\'envoi mail Laravel');
    });

    return 'Mail envoyé (ou erreur si ça coince)';
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/admin/dashboard', [SuperadminController::class, 'index'])->name('superadmin');
    // Route::get('/admin/add', [SuperadminController::class, 'addAdmin'])->name('add_admin_view');
    // Route::post('/admin/add-admin', [SuperadminController::class, 'createUsers'])->name('add_admin');
    // Route::get('/admin/list-admin', [SuperadminController::class, 'adminList'])->name('list_admin');




    // Route::get('/admin/company/dashboard', [AdminController::class, 'index'])->name('admin_simple');
        Route::get('/status', [SuperadminController::class, 'status'])->name('status');





});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/dashboard', [SuperadminController::class, 'index'])->name('superadmin');
    Route::get('/admin/add', [SuperadminController::class, 'addAdmin'])->name('add_admin_view');
    Route::post('/admin/add-admin', [SuperadminController::class, 'createUsers'])->name('add_admin');
    Route::get('/admin/list-admin', [SuperadminController::class, 'adminList'])->name('list_admin');
  Route::post('/entreprises/{entreprise}/toggle-status', [EntrepriseController::class, 'toggleStatus'])->name('entreprise.toggleStatus');
Route::get('/entreprises/{entreprise}', [EntrepriseController::class, 'show'])->name('entreprise.show');

});
    Route::get('/admin/entreprise/teams', [AdminController::class, 'showTeams'])->name('admin.team.show');
    Route::get('/admin/entreprise/project', [AdminController::class, 'showProjects'])->name('admin.project.show');
       Route::get('/entreprise/employes', [EntrepriseController::class, 'getEmployesPremiereEntreprise'])->name('entreprise.employes');

    Route::get('/listeemploye', [AdminController::class, 'list_users']);

Route::middleware(['auth', 'role:admin'])->group(function () {
//Route::get('/entreprises/employes', [EntrepriseController::class, 'getEmployesPremiereEntreprise'])->name('entreprise.employes');

    Route::get('/entreprises/employes', [EntrepriseController::class, 'index']);

    Route::get('/admin/company/dashboard', [AdminController::class, 'index'])->name('admin_simple');
    Route::get('/admin/company', [AdminController::class, 'companyView'])->name('company');
Route::post('/entreprise/store', [EntrepriseController::class, 'store'])->name('entreprise.store');
     Route::get('/entreprise/edit', [EntrepriseController::class, 'edit'])->name('entreprise.edit');
    Route::put('/entreprise/update', [EntrepriseController::class, 'update'])->name('entreprise.update');
    Route::get('/entreprise/redirection', [EntrepriseController::class, 'redirectionEntreprise'])
    ->name('entreprise.redirect');

    Route::get('/employes/create', [AdminController::class, 'formView'])->name('employe.create');
    Route::post('/employes/createe', [AdminController::class, 'createEmploye'])->name('create.employe');
//    Route::get('/admin/entreprise/teams', [AdminController::class, 'showTeams'])->name('admin.team.show'); 

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
    Route::get('/employe/{id}/edit', [EmployeeDetailController::class, 'edit'])->name('employee_detail.edit');
Route::put('/employe/{id}', [EmployeeDetailController::class, 'update'])->name('employee_detail.update');

    Route::get('/rh/users/create', [RhController::class, 'createUserForm'])->name('rh.users.create');
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.members.remove');
    Route::get('/employe/{id}', [RhController::class, 'show'])->name('employe.show');
Route::get('/users/{id}', [EmployeeDetailController::class, 'show'])->name('users.show');
Route::post('/employee-details', [EmployeeDetailController::class, 'store'])->name('employee-details.store');
Route::post('/employee/document/store', [EmployeeDocumentController::class, 'storeDocument'])->name('employee.document.store');
Route::delete('/employee-document/{id}', [EmployeeDocumentController::class, 'destroy'])->name('employee.document.destroy');

Route::get('/rh-dashboard/offres', [JobOfferController::class, 'index'])->name('offres.index');

Route::post('/offres', [JobOfferController::class, 'store'])->name('offres.store');
Route::get('/offres/{offre}/edit', [JobOfferController::class, 'edit'])->name('offres.edit');

Route::put('/offres/{offre}', [JobOfferController::class, 'update'])->name('offres.update');

Route::patch('/offres/{offre}/update-status', [JobOfferController::class, 'updateStatus'])->name('offres.updateStatus');

Route::delete('/offres/{offre}', [JobOfferController::class, 'destroy'])->name('offres.destroy');


 Route::get('/rh/export-personnel-registry', [PersonnelExportController::class, 'exportPersonnelRegistry'])
        ->name('rh.export.personnel.registry');



Route::get('/rh/candidature/candidat/list-depot', [CandidatureController::class, 'index'])->name('candidatures.index');

Route::get('/rh/candidatures/{candidature}', [CandidatureController::class, 'show'])->name('rh.candidatures.show');


Route::post('/rh/candidatures/{candidature}/accepter', [CandidatureController::class, 'accept'])->name('rh.candidatures.accept');
Route::post('/rh/candidatures/{candidature}/rejeter', [CandidatureController::class, 'reject'])->name('rh.candidatures.reject');

});

Route::get('/unread-messages-count', [CustomMessagesController::class, 'unreadCount'])->name('messages.unread.count');



Route::middleware(['auth','role:chef_projet'])->group(function(){

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::delete('/projects/{project}/update-members', [ProjectController::class, 'updateMembers'])->name('projects.updateMembers');
    Route::get('/chef-projet/dashboard', [ChefProjetcontroller::class, 'index'])->name('chef_projet.dashboard');

// Route pour ajouter un commentaire
Route::post('/projects/{project}/comments', [ProjectController::class, 'storeComment'])->name('comments.store');
// Route pour ajouter un fichier
Route::post('projects/{project}/files', [ProjectController::class, 'storeFile'])->name('files.store');
Route::post('/projects/{project}/tasks', [ProjectController::class, 'storeTask'])->name('tasks.store');
Route::patch('/tasks/{task}', [ProjectController::class, 'updateTask'])->name('tasks.update');
Route::post('/tasks/{task}/assign', [ProjectController::class, 'assignTask'])->name('tasks.assign');
Route::delete('/tasks/{task}', [ProjectController::class, 'deleteTask'])->name('tasks.delete');
Route::get('/my-tasks', [ProjectController::class, 'myTasks'])->name('tasks.myTasks');
Route::delete('/files/{file}', [ProjectController::class, 'destroyFile'])->name('files.delete');
Route::patch('/projects/{project}/members/{user}/toggle-lead', [ProjectController::class, 'toggleLead'])->name('projects.toggleLead');
Route::get('/tasks/{task}', [ProjectController::class, 'showTask'])->name('tasks.show');
Route::post('/tasks/{task}/comments', [ProjectController::class, 'storeTaskComment'])->name('tasks.comments.store');
Route::delete('/comments/{comment}', [ProjectController::class, 'deleteComment'])->name('comments.delete');
Route::post('/projects/{project}/members/{user}', [ProjectController::class, 'addMember'])->name('projects.addMember');
Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])->name('projects.removeMember');




Route::prefix('projets/{projet}')->group(function () {
    Route::get('/taches', [TacheController::class, 'showTachesParProjet'])->name('projets.taches');
    Route::post('/taches/{tache}/statut', [TacheController::class, 'changerStatut'])->name('projets.taches.changerStatut');
    Route::post('/taches/{tache}/commentaire', [TacheController::class, 'ajouterCommentaire'])->name('projets.taches.ajouterCommentaire');
Route::patch('/taches/{tache}/priorite', [TacheController::class, 'changerPriorite'])->name('projets.taches.changerPriorites');

});




});
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-projets', [App\Http\Controllers\EmployeController::class, 'mesProjets'])->name('employe.projects');
    Route::get('/my-dashboard', [App\Http\Controllers\EmployeController::class, 'index'])->name('employe.dashboard');
    Route::get('/mes-projets/{project}', [App\Http\Controllers\EmployeController::class, 'voirProjet'])->name('employe.projects.show');
    Route::patch('/mes-projets/taches/{task}/statut', [App\Http\Controllers\EmployeController::class, 'changerStatut'])->name('employe.tasks.changerStatut');
    Route::post('/mes-projets/taches/{task}/commentaire', [App\Http\Controllers\EmployeController::class, 'ajouterCommentaire'])->name('employe.tasks.commenter');
    
});
Route::middleware('auth')->group(function () {
    Route::patch('/projets/{project}/taches/{tache}/changer-priorite', [EmployeController::class, 'changerPrioriteTache'])->name('projets.taches.changerPriorite');
    Route::post('/projets/{project}/taches', [EmployeController::class, 'storeTask'])->name('tasks.store');
    
});

use App\Http\Controllers\MeetingController;

Route::prefix('projets/{project}')->group(function () {
    Route::get('/reunions', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/reunions/create', [MeetingController::class, 'create'])->name('meetings.create');
});

Route::post('/reunions', [MeetingController::class, 'store'])->name('meetings.store');
Route::get('/reunions/{id}', [MeetingController::class, 'show'])->name('meetings.show');


Route::get('/offres/{entreprise}', [PublicJobOfferController::class, 'listByEntreprise'])
    ->name('public.offres.list');

    Route::get('/rh/candidature/candidat/list/{entreprise_id}', [JobOfferController::class, 'list_offer'])->name('offres_candidat.index');
Route::get('/rh/candidature/candidat/{id}/depot', [JobOfferController::class, 'depotform'])->name('offres.depot');

Route::post('/candidature/{jobOffer}/store', [CandidatureController::class, 'store'])->name('candidatures.store');
Route::get('/job-offers/{id}/details', [JobOfferController::class, 'showDetails']);


require __DIR__.'/auth.php';
