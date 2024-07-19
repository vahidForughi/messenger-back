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

Route::prefix('/messenger-profile')->group(
    base_path('modules/messenger/routes/groups/messenger-profile.php')
);

Route::prefix('/messenger-users')->group(
    base_path('modules/messenger/routes/groups/messenger-user.php')
);

Route::prefix('/messenger-favorites')->group(
    base_path('modules/messenger/routes/groups/messenger-favorite.php')
);

Route::prefix('/messenger-files')->group(
    base_path('modules/messenger/routes/groups/messenger-file.php')
);
