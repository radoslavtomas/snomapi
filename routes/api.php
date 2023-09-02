<?php

use App\Http\Controllers\Api\V1\AddressesController;
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

Route::post('auth/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::get('users/{user}/addresses', [UserController::class, 'userAddresses']);
    Route::apiResource('contacts', ContactsController::class);

    Route::prefix('contacts/{contact}')->group(function () {
        Route::apiResource('addresses', AddressesController::class);
    });
});
