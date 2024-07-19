<?php

use Illuminate\Support\Facades\Route;
use Modules\messenger\app\Http\Controllers\MessengerUserMessageController;

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

Route::get('', [MessengerUserMessageController::class, 'index']);

Route::post('', [MessengerUserMessageController::class, 'store']);

Route::prefix('/{message_id}')->group(function () {

    Route::delete('', [MessengerUserMessageController::class, 'distroy']);

});
