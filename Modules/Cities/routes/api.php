<?php

use Illuminate\Support\Facades\Route;
use Modules\Cities\Http\Controllers\GetCitiesListController;

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

Route::get('cities', GetCitiesListController::class)
    ->middleware(['auth-public'])
    ->name('cities.index');
