<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DgController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth', 'role.dg','verified'])->group(function () {
    // Directeur Général
    Route::get('/dg/dashboard', [DgController::class, 'dashboard'])->name('dg.dashboard');

    Route::get('/periods/create', [DgController::class, 'createPeriod'])->name('periods.create');
    Route::post('/periods/store', [DgController::class, 'storePeriod'])->name('periods.store');

    Route::get('/global-goals/create', [DgController::class, 'createGlobalGoal'])->name('global-goals.create');
    Route::post('/global-goals/store', [DgController::class, 'storeGlobalGoal'])->name('global-goals.store');

    Route::get('/services/index', [DgController::class, 'indexServices'])->name('services.index');

    Route::get('/reports/generate-pdf', [DgController::class, 'generatePdf'])->name('reports.generate-pdf');

   // Gestion rapports DG (liste + hiérarchie)
    Route::get('/dg/reports', [DgController::class, 'reportsIndex'])->name('dg.reports.index');
    Route::get('/dg/reports/period/{periode}', [DgController::class, 'reportsByPeriod'])->name('dg.reports.period');
    Route::get('/dg/reports/service/{periode}/{service}', [DgController::class, 'reportsByService'])->name('dg.reports.service');
    Route::get('/dg/reports/report/{rapport}', [DgController::class, 'reportShow'])->name('dg.reports.show');
    // Liste des rapports (entrée principale)
    Route::get('/dg/reports', [DgController::class, 'reportsIndex'])->name('dg.reports.index');

    // Détail d'une période
    Route::get('/dg/reports/period/{periode}', [DgController::class, 'reportsByPeriod'])->name('dg.reports.period');

    // Rapports d'un service pour une période
    Route::get('/dg/reports/service/{periode}/{service}', [DgController::class, 'reportsByService'])->name('dg.reports.service');

    // Détail d'un rapport unique
    Route::get('/dg/reports/report/{rapport}', [DgController::class, 'reportShow'])->name('dg.reports.show');

    // PDF consolidé par période
    Route::get('/dg/reports/pdf-consolide/{periode}', [DgController::class, 'pdfConsolide'])->name('dg.reports.pdf.consolide');

    // PDF individuel d'un rapport
    Route::get('/dg/reports/pdf/{rapport}', [DgController::class, 'pdfIndividual'])->name('dg.reports.pdf.individual');
});


Route::middleware(['auth', 'role.chef','verified'])->group(function () {
    // Chef de Service
    Route::get('/chef/dashboard', [ChefController::class, 'dashboard'])->name('chef.dashboard');

    Route::get('/global-goals/show', [ChefController::class, 'showGlobalGoals'])->name('global-goals.show');
    Route::get('/individual-goals/create/{objectif}', [ChefController::class, 'createIndividualGoal'])->name('individual-goals.create');

    Route::post('/individual-goals/store/{objectif}', [ChefController::class, 'storeIndividualGoal'])->name('individual-goals.store');

    Route::get('/reports/index', [ChefController::class, 'indexReports'])->name('reports.index');
    Route::patch('/reports/validate/{rapport}', [ChefController::class, 'validateReport'])->name('reports.validate');
    Route::patch('/reports/reject/{rapport}', [ChefController::class, 'rejectReport'])->name('reports.reject');

});






// Employé
Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');

Route::get('/individual-goals/show', [EmployeeController::class, 'showIndividualGoals'])->name('individual-goals.show');

Route::get('/reports/create', [EmployeeController::class, 'createReport'])->name('reports.create');
Route::post('/reports/store', [EmployeeController::class, 'storeReport'])->name('reports.store');
Route::get('/reports/edit/{rapport}', [EmployeeController::class, 'editReport'])->name('reports.edit');
Route::patch('/reports/update/{rapport}', [EmployeeController::class, 'updateReport'])->name('reports.update');

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
