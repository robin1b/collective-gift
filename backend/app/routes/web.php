<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RecommendedGiftController;

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
Route::middleware('auth')->group(function () {
    // alleen superadmin mag hier in:
    Route::middleware('can:create,App\Models\RecommendedGift')->prefix('admin')->name('admin.')->group(function () {
        Route::get('recommended-gifts', [RecommendedGiftController::class, 'index'])->name('gifts.index');
        Route::get('recommended-gifts/create', [RecommendedGiftController::class, 'create'])->name('gifts.create');
        Route::post('recommended-gifts', [RecommendedGiftController::class, 'store'])->name('gifts.store');
        Route::get('recommended-gifts/{recommended_gift}/edit', [RecommendedGiftController::class, 'edit'])->name('gifts.edit');
        Route::put('recommended-gifts/{recommended_gift}', [RecommendedGiftController::class, 'update'])->name('gifts.update');
        Route::delete('recommended-gifts/{recommended_gift}', [RecommendedGiftController::class, 'destroy'])->name('gifts.destroy');
    });
});

require __DIR__ . '/auth.php';
