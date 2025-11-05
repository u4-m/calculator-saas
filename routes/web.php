<?php

use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

// Auth routes
require __DIR__.'/auth.php';