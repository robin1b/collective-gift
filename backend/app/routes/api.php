<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// De middleware-stack die cookies & sessies opzet
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| Stateful CSRF + Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    EnsureFrontendRequestsAreStateful::class,
])->group(function () {
    // CSRF-cookie endpoint
    Route::get('/sanctum/csrf-cookie', fn() => response()->noContent());

    // Open auth-routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout']);

    // **Protected** routes binnen dezelfde session-stack
    Route::middleware('auth:sanctum')->group(function () {
        // Haal de ingelogde user op
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        // Hier kun je alle andere apiResource- of POST/PUT/DELETE routes zetten
    });
});
