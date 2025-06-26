<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    EventController,
    ContributionController,
    ChatController,
    VoteController,
    GiftIdeaController
};
use App\Http\Controllers\Admin\RecommendedGiftController;


// ───────── Publiek ─────────
// admin-view van een event (door admin_code):
Route::get(
    '/events/admin/{admin_code}',
    [EventController::class, 'showAdmin']
);

// Lijst alle publieke events
Route::get('/events',                       [EventController::class, 'index']);
// Toon één event (door ID)
Route::get('/events/{event}',               [EventController::class, 'show']);
// Gast-view (met join_code)
Route::get('/events/join/{join_code}',      [EventController::class, 'showGuest']);
// Gast-view: chat bekijken voor iedereen
Route::get(
    '/events/join/{join_code}/chat',
    [ChatController::class, 'index']
);
// Gast-bijdrage
Route::post(
    '/events/join/{join_code}/contribute',
    [ContributionController::class, 'storeGuest']
);
// Gast-stemmen (anoniem)
Route::get(
    '/events/join/{join_code}/votes',
    [VoteController::class, 'indexGuest']
);
Route::post(
    '/events/join/{join_code}/votes',
    [VoteController::class, 'storeGuest']
);
Route::get(
    '/events/join/{join_code}/gift_ideas',
    [GiftIdeaController::class, 'indexGuest']
);
Route::post(
    '/events/join/{join_code}/gift_ideas',
    [GiftIdeaController::class, 'storeGuest']
);

// ───────── Authenticatie ─────────
// Registreren & inloggen zonder token
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Alle routes hieronder vereisen een geldig Sanctum-token
Route::middleware('auth:sanctum')->group(function () {
    // Uitloggen
    Route::post('/logout',       [AuthController::class, 'logout']);

    // User-info
    Route::get('/user',          fn(Request $r) => $r->user());
    // Dashboard: events van deze ingelogde user
    Route::get('/user/events',   [EventController::class, 'userEvents']);

    // Event-CRUD (create, update, delete)
    Route::post('/events',        [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete(
        '/events/{event}',
        [EventController::class, 'destroy']
    );
    // chat voor ingelogde user

    Route::post(
        '/events/join/{join_code}/chat',
        [ChatController::class, 'store']
    );
});
Route::middleware(['auth:sanctum', 'can:create,App\Models\RecommendedGift'])
    ->prefix('admin')
    ->group(function () {
        Route::apiResource('recommended_gifts', RecommendedGiftController::class)
            ->except(['show']);
    });
