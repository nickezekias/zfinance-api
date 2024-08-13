<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardRequestController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return response()->json(['error' => 'Already authenticated'], 200);
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users/auth', function (Request $request) {
            return new UserResource(Auth::user());
        });

        Route::apiResource('credit-cards/requests', CreditCardRequestController::class);

        Route::apiResource('credit-cards', CreditCardController::class);

    });
});

Route::get('/user', function (Request $request) {
    return new UserResource(Auth::user());
})->middleware('auth:sanctum');
