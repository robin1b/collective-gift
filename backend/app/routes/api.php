<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

// De middleware-stack die cookies, sessies én CSRF opzet
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
/*
|--------------------------------------------------------------------------
| Publice Events CRUD (zonder CSRF of Auth)
|--------------------------------------------------------------------------
|
| Voorlopig slaan we login over: iedereen kan events zien, maken, updaten, verwijderen.
|
*/

Route::get('/events/{admin_code}', [EventController::class, 'showAdmin']);
Route::put('/events/{admin_code}', [EventController::class, 'updateAdmin']);
Route::get('/events/join/{join_code}', [EventController::class, 'showGuest']);

Route::post('/events', [EventController::class, 'store']);
Route::get('/events',         [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);
Route::post('/events',        [EventController::class, 'store']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy']);

Route::middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    VerifyCsrfToken::class,            // <<< dwing CSRF af
    EnsureFrontendRequestsAreStateful::class,
])->group(function () {
    // 1) CSRF-cookie endpoint
    Route::get('/sanctum/csrf-cookie', fn() => response()->noContent());

    // 2) Open auth-routes (CSRF verplichting nu actief)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout']);

    // 3) Beschermde routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', fn(Request $request) => $request->user());
    });
});
