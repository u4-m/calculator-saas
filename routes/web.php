<?php

use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Calculation history
    Route::get('/history', [CalculatorController::class, 'history'])->name('calculator.history');
    
    // Save calculation
    Route::post('/save-calculation', [CalculatorController::class, 'saveCalculation'])->name('calculator.save');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';