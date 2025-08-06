<?php

use App\Http\Controllers\PlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public plan routes (no auth required)
Route::get('/plans', [PlanController::class, 'index']);
Route::get('/plans/{id}', [PlanController::class, 'show']);

// Protected plan routes (auth required)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/plan-status', [PlanController::class, 'status']);
    Route::post('/user/subscribe', [PlanController::class, 'subscribe']);
    Route::post('/user/confirm-subscription', [PlanController::class, 'confirmSubscription']);
    Route::delete('/user/cancel-plan', [PlanController::class, 'cancel']);
});
