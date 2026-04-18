<?php

use App\Http\Controllers\acceuilController;
use App\Http\Controllers\ArretController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ConducteurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\LigneController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Auth;


// racine du projet qui m'affiche le login
Route::get('/admin', function () {
    return view('auth.login');
});
// fin racine du projet qui m'affiche le login

// racine du projet qui m'affiche le login
Route::get('/', [acceuilController::class, 'index'])->name('accueil');
// fin racine du projet qui m'affiche le login



//debut route pour la modification du mot de passe
Route::get('/change-mdp', [UserController::class, 'formulaireMdp'])->name('modifierMdp');
Route::post('/changepassword', [UserController::class, 'updatePassword']);
//fin route pour la modification du mot de passe

   Route::get('/api/lignes', [LigneController::class, 'getByVille']);
    Route::get('/api/arrets', [ArretController::class, 'getByLigne']);
    Route::get('/api/positions', [PositionController::class, 'getByVilleLigne']);


Auth::routes();

// route pour le tableau de bord
Route::get('/home', [HomeController::class, 'index'])->name('dashboards.accueil');
// fin route pour le tableau de bord

Route::group(['middleware' => ['auth']], function () {

    //                /la vue/  et le controler
 
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('dashboards', dashboardController::class);
    Route::resource('lignes', LigneController::class);
    Route::resource('buses', BusController::class);
    Route::resource('conducteurs', ConducteurController::class);
    Route::resource('arrets', ArretController::class);
    Route::resource('positions', PositionController::class);
});
