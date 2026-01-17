<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\ImportExportUserController;
use App\Http\Controllers\ModuleEnseignantController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['web', 'auth', 'role:Administrateur'])->group(function () {

    Route::resource('annee-academiques', AnneeAcademiqueController::class);

    Route::put('annee-academiques/{annee_academique}/toggle-statut', [AnneeAcademiqueController::class, 'toggleStatut'])
        ->name('annee-academiques.toggle-statut');

    // Route Resource pour la gestion des Spécialités
    Route::resource('specialites', SpecialiteController::class);
    // Routes pour la gestion des Modules
    Route::resource('modules', ModuleController::class);
});


Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
    Route::get('/', [InscriptionController::class, 'index'])->name('index'); // Affiche tout (Create + Liste)
    Route::post('/store', [InscriptionController::class, 'store'])->name('store');
    Route::put('/{inscription}', [InscriptionController::class, 'update'])->name('update');
    Route::delete('/{inscription}', [InscriptionController::class, 'destroy'])->name('destroy');
})->middleware(['web', 'auth', 'role:Administrateur,secretaire']);




Route::prefix('evaluations')->name('evaluations.')->group(function () {
    // Route pour afficher la page de saisie et filtrer
    Route::get('/', [EvaluationController::class, 'index'])->name('index');

    // Route pour enregistrer les notes en masse
    Route::post('/store', [EvaluationController::class, 'store'])->name('store');
})->middleware(['web', 'auth', 'role:Administrateur,Enseignant,secretaire']);


// Groupe avec préfixe d'URL 'bilan' et préfixe de nom 'bilan.'
Route::prefix('bilan')->name('bilan.')->group(function () {


    // Route pour la synthèse de toutes les spécialités (Le Grand Livre)
    Route::get('/synthese-globale-pdf', [BilanController::class, 'generateSyntheseToutesSpecialitesPDF'])
        ->name('synthese.globale.pdf');

    // Routes de synthèses et impressions
    Route::get('/synthese-globale', [BilanController::class, 'generateSyntheseGlobalePDF'])->name('synthese.globale');
    Route::get('/synthese-pdf', [BilanController::class, 'generateSynthesePDF'])->name('synthese.pdf');
    Route::get('/print-batch', [BilanController::class, 'printBatch'])->name('print-batch');

    // Routes spécifiques aux étudiants
    Route::prefix('etudiant')->group(function () {
        Route::get('/{id}', [BilanController::class, 'show'])->name('show');
        Route::get('/{id}/pdf', [BilanController::class, 'downloadRelevePdf'])->name('releve.pdf');
    });

    // Génération PDF par ID
    Route::get('/pdf/{id}', [BilanController::class, 'generatePDF'])->name('pdf');

    // Synchronisation / Calcul
    Route::post('/sync/{specialite_id}', [BilanController::class, 'genererSynthese'])->name('sync');

    // Actions générales (Index et Store)
    // Note : J'ai déplacé 'bilan-general' ici pour qu'il devienne '/bilan/general'
    Route::get('/general', [BilanController::class, 'index'])->name('index');
    Route::post('/store', [BilanController::class, 'store'])->name('store');
})->middleware(['web', 'auth', 'role:Administrateur,secretaire']);







Route::middleware(['auth'])->group(function () {

    // Groupe principal pour les utilisateurs
    Route::prefix('users')->name('users.')->group(function () {

        // --- Import / Export ---
        Route::post('import', [ImportExportUserController::class, 'store'])->name('import');
        Route::get('export', [ImportExportUserController::class, 'export'])->name('export');

        // --- Actions Groupées (Bulk) ---
        // Placées avant les routes avec {id} pour éviter les conflits
        Route::delete('bulk-delete', [UserController::class, 'bulkDestroy'])->name('bulkDestroy');
        Route::post('bulk-restore', [UserController::class, 'bulkRestore'])->name('bulkRestore');
        Route::delete('bulk-force-delete', [UserController::class, 'bulkForceDelete'])->name('bulkForceDelete');

        // --- Gestion de la Corbeille (Trash) ---
        Route::get('trash', [UserController::class, 'trash'])->name('trash');
        Route::post('{id}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('{id}/force-delete', [UserController::class, 'forceDelete'])->name('forceDelete');
    });

    // --- Route Resource Standard ---
    // On la garde en dehors du groupe préfixé car Route::resource 
    // génère déjà automatiquement le préfixe 'users' et les noms 'users.*'
    Route::resource('users', UserController::class);
})->middleware(['web', 'auth', 'role:Administrateur,secretaire']);


// Route pour le tableau de bord

Route::get('tableau-de-bord', [DashboardController::class, 'index'])->name('tableau-de-bord')->middleware(['web', 'auth', 'role:Administrateur']);

Route::get('/affectations', [ModuleEnseignantController::class, 'index'])->name('affectations.index')->middleware(['web', 'auth', 'role:Administrateur,secretaire']);
Route::post('/affectations', [ModuleEnseignantController::class, 'store'])->name('affectations.store')->middleware(['web', 'auth', 'role:Administrateur,secretaire']);
// Suppression des affectations d'un enseignant
Route::delete('/affectations/{id}', [ModuleEnseignantController::class, 'destroy'])->name('affectations.destroy')->middleware(['web', 'auth', 'role:Administrateur,secretaire']);

// Route pour l'espace étudiant
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-notes', [StudentController::class, 'index'])->name('student.notes')->middleware(['web', 'auth', 'role:Etudiant']);

    Route::get('/liste-etudiants', [StudentController::class, 'indexList'])->name('students.indexList')->middleware(['web', 'auth', 'role:Administrateur,secretaire']);
});


Route::get('/students/create', [StudentController::class, 'create'])->name('students.create')->middleware(['web', 'auth', 'role:Administrateur,secretaire']);;
Route::post('/students/store', [StudentController::class, 'store'])->name('students.store')->middleware(['web', 'auth', 'role:Administrateur,secretaire']);;



require __DIR__ . '/auth.php';
