<?php

use Illuminate\Support\Facades\Route;
use Modules\Uploads\Http\Controllers\UploadController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
 */

Route::middleware(['auth-public'])
    ->controller(UploadController::class)
    ->group(function () {
        Route::post('/uploads', 'store')->name('uploads.store');
    });
