<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use \Illuminate\Support\Facades\Hash;

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

Route::post('/login', function (Request $request) {
    if (
        !($user = User::where('email', $request->email)->first()) ||
        !Hash::check($request->password, $user->password)
    ) {
        return response('Login invalid', 503);
    }

    return [
        'data' => [
            'token' => $user->createToken('spa')->plainTextToken
        ]
    ];
});

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return [
        'data' => $request->user()
    ];
});
