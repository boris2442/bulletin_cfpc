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
use App\Http\Controllers\ClasseController;

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



Route::group(['middleware' => ['web']], function () {
    Route::resource('annee-academiques', AnneeAcademiqueController::class);

    Route::put('annee-academiques/{annee_academique}/toggle-statut', [AnneeAcademiqueController::class, 'toggleStatut'])
        ->name('annee-academiques.toggle-statut');
});

// Route Resource pour la gestion des Spécialités
Route::resource('specialites', SpecialiteController::class);
// Routes pour la gestion des Modules
Route::resource('modules', ModuleController::class);


Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
    Route::get('/', [InscriptionController::class, 'index'])->name('index'); // Affiche tout (Create + Liste)
    Route::post('/store', [InscriptionController::class, 'store'])->name('store');
    Route::put('/{inscription}', [InscriptionController::class, 'update'])->name('update');
    Route::delete('/{inscription}', [InscriptionController::class, 'destroy'])->name('destroy');
});




Route::prefix('evaluations')->name('evaluations.')->group(function () {
    // Route pour afficher la page de saisie et filtrer
    Route::get('/', [EvaluationController::class, 'index'])->name('index');

    // Route pour enregistrer les notes en masse
    Route::post('/store', [EvaluationController::class, 'store'])->name('store');
});


// Groupe avec préfixe d'URL 'bilan' et préfixe de nom 'bilan.'
Route::prefix('bilan')->name('bilan.')->group(function () {

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
});







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
});


// Route pour le tableau de bord
Route::get('tableau-de-bord', [DashboardController::class, 'index'])->name('tableau-de-bord');

Route::get('/affectations', [ModuleEnseignantController::class, 'index'])->name('affectations.index');
Route::post('/affectations', [ModuleEnseignantController::class, 'store'])->name('affectations.store');
// Suppression des affectations d'un enseignant
Route::delete('/affectations/{id}', [ModuleEnseignantController::class, 'destroy'])->name('affectations.destroy');



// Route pour l'espace étudiant
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-notes', [StudentController::class, 'index'])->name('student.notes');

    Route::get('/liste-etudiants', [StudentController::class, 'indexList'])->name('students.indexList');
});


// Route pour la suppression multiple
Route::post('classes/multi-delete', [ClasseController::class, 'multiDelete'])->name('classes.multi-delete');
Route::resource('classes', ClasseController::class);
require __DIR__ . '/auth.php';
