<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ArretController;
use App\Http\Controllers\LigneController;
use App\Models\Arret;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Ces routes sont utilisées par ton application Flutter et ton site web
| pour interagir avec la base de données.
*/

// Route::get('/api/online-users', function() {
//     $count = collect(Cache::getKeys('online_user_*'))->count();
//     return response()->json(['count' => $count]);
// });

Route::post('/buses/reserver/{bus_id}', [BusController::class, 'reserver']);
Route::post('/buses/liberer/{bus_id}', [BusController::class, 'liberer']);


// â Liste de tous les bus
Route::get('/buses', [BusController::class, 'index']);

// â Liste des positions récentes
Route::get('/positions', [PositionController::class, 'index']);

// â Ajouter une nouvelle position (envoyée depuis Flutter)
Route::post('/positions', [PositionController::class, 'store']);

// â Mise à jour de la position d’un bus spécifique (optionnel)
Route::post('/positions/update/{bus_id}', [PositionController::class, 'updatePosition']);

// â Liste des arrêts (avec leur ligne)
Route::get('/arrets', function () {
    return Arret::with('ligne')->get();
});

// â Liste des lignes (si utilisée par le front)
Route::get('/lignes', [LigneController::class, 'index']);

// â Test API
Route::get('/ping', function () {
    return response()->json(['message' => 'API Laravel en ligne â']);
});

// Middleware Sanctum (non utilisé pour Flutter)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
