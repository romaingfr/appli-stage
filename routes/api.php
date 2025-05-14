<?php

use App\Http\Controllers\PhoneTerminalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    // Routes pour les clients et leurs services
    Route::prefix('clients')->group(function () {
        // Services des sites
        Route::post('{client}/sites/{site}/services', [ServiceController::class, 'update'])
            ->name('clients.sites.services.update');

        // Routes existantes
        Route::get('{client}/sites/principal/services', [ServiceController::class, 'getPrincipal']);
        Route::post('{client}/sites/principal/services', [ServiceController::class, 'storePrincipal']);

        Route::get('{client}/sites/{site}/services', [ServiceController::class, 'get']);
        Route::post('{client}/sites/{site}/services', [ServiceController::class, 'store']);

        // Détails des sites
        Route::get('{client}/sites/{site}/details', [SiteController::class, 'details']);
    });

    // Route pour la liste des clients
    Route::get('/', function () {
        return redirect('/');
    });
});

Route::get('/api/terminals/search', [PhoneTerminalController::class, 'search'])->name('terminals.search');
Route::get('/api/terminals/brands', [PhoneTerminalController::class, 'brands'])->name('terminals.brands');
Route::get('/api/terminals/types', [PhoneTerminalController::class, 'types'])->name('terminals.types');

Route::get('/api/terminals', function() {
    return \App\Models\Terminal::select('id', 'model', 'serial_number')->get();
});
Route::get('/terminals', 'App\Http\Controllers\TerminalController@index');
