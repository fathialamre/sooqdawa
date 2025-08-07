<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Version 1
Route::prefix('v1')->group(function () {
    
    // Authentication routes (public)
    
    // Phone-based authentication (new)
    Route::post('/auth/phone/register', [AuthController::class, 'phoneRegister']);
    Route::post('/auth/phone/verify-otp', [AuthController::class, 'verifyRegistrationOtp']);
    Route::post('/auth/phone/login', [AuthController::class, 'phoneLogin']);
    
    // Password reset with phone
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);
    
    // Public plan routes (no auth required)
    Route::get('/plans', [PlanController::class, 'index']);
    Route::get('/plans/{id}', [PlanController::class, 'show']);
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);
        Route::get('/auth/profile', [AuthController::class, 'profile']);
        
        // Protected plan routes (auth required)
        Route::get('/user/plan-status', [PlanController::class, 'status']);
        Route::post('/user/subscribe', [PlanController::class, 'subscribe']);
        Route::post('/user/confirm-subscription', [PlanController::class, 'confirmSubscription']);
        Route::delete('/user/cancel-plan', [PlanController::class, 'cancel']);
    });
});

// Legacy route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
