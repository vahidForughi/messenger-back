<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware([
    \Modules\messenger\app\Http\Middleware\JsonApiMiddleware::class,
    'auth:sanctum',
])->group(function () {

    Route::prefix('/')->group(
        base_path('modules/messenger/routes/groups/handler.php')
    );

});
