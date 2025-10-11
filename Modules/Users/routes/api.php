<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\AuthController;

Route::prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        // Public routes
        Route::post('guests/login', 'loginGuest')
            ->name('login-guest')
            ->middleware(['auth-public', 'throttle:guest']);

        Route::middleware([
            'auth:sanctum',
            'role:guest',
            'throttle:api',
        ])->group(function () {
            Route::post('register', 'register')->name('register');
            Route::post('users/login', 'loginUser')->name('login-user');
            Route::post('forgot-password', 'forgotPassword')->name(
                'forgot-password',
            );
            Route::post('reset-password', 'resetPassword')->name(
                'reset-password',
            );
        });
    });
