<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Routes accessibles uniquement aux invités (non connectés)
Route::middleware('guest')->group(function () {
    // Routes d'authentification
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Routes d'inscription
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Routes de réinitialisation de mot de passe
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Routes accessibles uniquement aux utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    Route::get('/', [ClientController::class, 'search'])->name('home');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/search', [ClientController::class, 'search'])->name('search');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('show');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::put('/{client}', [ClientController::class, 'update'])->name('update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');

        Route::prefix('{client}/sites')->name('sites.')->group(function () {
            Route::get('/', [SiteController::class, 'index'])->name('index');
            Route::get('/create', [SiteController::class, 'create'])->name('create');
            Route::post('/', [SiteController::class, 'store'])->name('store');

            Route::get('/{site}/export-pdf', [SiteController::class, 'exportPDF'])
                ->name('export-pdf')
                ->where('site', '[0-9]+|principal');

            Route::get('/{site}', [SiteController::class, 'show'])
                ->name('show')
                ->where('site', '[0-9]+|principal');

            Route::get('/{site}/edit', [SiteController::class, 'edit'])
                ->name('edit')
                ->where('site', '[0-9]+|principal');

            Route::put('/{site}', [SiteController::class, 'update'])
                ->name('update')
                ->where('site', '[0-9]+|principal');

            Route::delete('/{site}', [SiteController::class, 'destroy'])
                ->name('destroy')
                ->where('site', '[0-9]+|principal');

            Route::get('/{site}/services', [SiteController::class, 'services'])
                ->name('services')
                ->where('site', '[0-9]+|principal');

            Route::post('/{site}/services', [SiteController::class, 'updateServices'])
                ->name('services.update')
                ->where('site', '[0-9]+|principal');
        });
    });
});

// Route par défaut
Route::fallback(function () {
    return redirect()->route('clients.search');
});
Route::post('/clients/{client}/update-field', [ClientController::class, 'updateField'])->name('clients.update-field');

Route::post('/clients/{client}/sites/{site}/update-field', [SiteController::class, 'updateField'])
    ->name('clients.sites.update-field')
    ->where('site', '[0-9]+|principal');
