<?php

use Illuminate\Support\Facades\Route;
use Modules\messenger\app\Http\Controllers\MessengerUserController;

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

Route::get('/', [MessengerUserController::class, 'index']);

Route::prefix('/{messenger_user_id}')->group(function () {

    Route::get('/', [MessengerUserController::class, 'show']);

    Route::prefix('/messages')->group(
        base_path('modules/messenger/routes/groups/messenger-user-message.php')
    );

});
