<?php

use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\Identity\AuthenticatedSessionController;
use App\Http\Controllers\Api\V1\Identity\CurrentUserController;
use App\Http\Controllers\Api\V1\Identity\RegisteredUserController;
use App\Http\Controllers\Api\V1\JourneyController;
use App\Http\Controllers\Api\V1\JourneyItineraryController;
use App\Http\Controllers\Api\V1\JourneyTransitionController;
use App\Http\Controllers\Api\V1\ReadinessController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/health', HealthController::class)->name('health');
    Route::get('/readiness', ReadinessController::class)->name('readiness');

    Route::prefix('auth')->name('auth.')->group(function (): void {
        Route::post('/register', RegisteredUserController::class)
            ->middleware('throttle:identity-registration')
            ->name('register');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('throttle:identity-login')
            ->name('login');

        Route::middleware(['auth:sanctum', 'throttle:identity-authenticated'])->group(function (): void {
            Route::get('/user', CurrentUserController::class)->name('user');
            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        });
    });

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::apiResource('journeys', JourneyController::class)->only(['index', 'store', 'show']);
        Route::get('/journeys/{journey}/itinerary', [JourneyItineraryController::class, 'show'])
            ->name('journeys.itinerary.show');
        Route::post('/journeys/{journey}/itinerary', [JourneyItineraryController::class, 'store'])
            ->name('journeys.itinerary.store');
        Route::post('/journeys/{journey}/transitions', JourneyTransitionController::class)
            ->name('journeys.transitions.store');
    });
});
