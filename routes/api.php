<?php

use App\Http\Controllers\CalculationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Calculation history routes
    Route::apiResource('calculations', CalculationController::class)->except(['update']);
    
    // Additional calculation routes can be added here
    // For example, a route to get calculation statistics
    Route::get('/calculation-stats', [CalculationController::class, 'stats']);
});

// Public routes (if any) can be added here
