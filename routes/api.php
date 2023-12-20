<?php

use App\Http\Controllers\Api\V1\AddressesController;
use App\Http\Controllers\Api\V1\Auth\PasswordController;
use App\Http\Controllers\Api\V1\ContactsController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('users', [UserController::class, 'index']);
//Route::get('users/{user}', [UserController::class, 'show']);
//Route::post('users', [UserController::class, 'store']);
//Route::put('users/{user}', [UserController::class, 'update']);
//Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::middleware('guest')->group(function() {
    Route::post('register', RegisterController::class);
    Route::post('forgot-password', [PasswordController::class, 'postForgotPassword']);
    Route::post('reset-password', [PasswordController::class, 'postResetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/addresses', [UserController::class, 'getUserAddresses']);
    Route::put('user/update-password', [UserController::class, 'putUpdatePassword']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('contacts', ContactsController::class);

    Route::prefix('contacts/{contact}')->group(function () {
        Route::apiResource('addresses', AddressesController::class);
    });
});
