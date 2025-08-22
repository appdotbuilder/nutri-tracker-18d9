<?php

use App\Http\Controllers\FitnessController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FoodLogController;
use App\Http\Controllers\ExerciseLogController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [FitnessController::class, 'index'])->name('dashboard');
    
    // Fitness tracking routes
    Route::post('fitness/profile', [UserProfileController::class, 'store'])->name('fitness.profile.store');
    Route::post('fitness/food', [FoodLogController::class, 'store'])->name('fitness.food.store');
    Route::post('fitness/exercise', [ExerciseLogController::class, 'store'])->name('fitness.exercise.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
