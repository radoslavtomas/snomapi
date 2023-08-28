<?php

use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\AddressesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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
    Route::apiResource('contacts', ContactsController::class);
    Route::get('contacts/{contact}/addresses', [AddressesController::class, 'index']);
    Route::get('contacts/{contact}/addresses/{address}', [AddressesController::class, 'show']);
    Route::post('contacts/{contact}/addresses', [AddressesController::class, 'store']);
    Route::put('contacts/{contact}/addresses/{address}', [AddressesController::class, 'update']);
    Route::delete('contacts/{contact}/addresses/{address}', [AddressesController::class, 'destroy']);
});
