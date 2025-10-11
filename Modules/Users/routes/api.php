<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\AuthController;

Route::prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('guests/login', 'loginGuest')
            ->name('login-guest')
            ->middleware(['auth-public', 'throttle:guest']);

        Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
            Route::post('users/login', 'loginUser')->name('login-user');
        });
    });
