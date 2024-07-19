<?php

use Illuminate\Support\Facades\Route;
use Modules\messenger\app\Http\Controllers\MessengerProfileController;

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

Route::put('/active-status', [MessengerProfileController::class, 'updateActiveStatus']);

