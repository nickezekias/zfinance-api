<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardRequestController;
use App\Http\Controllers\TransactionController;
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


        Route::post('credit-cards/recharge', 'App\Http\Controllers\CreditCardController@rechargeCard');
        Route::apiResource('credit-cards/requests', CreditCardRequestController::class);
        Route::post('credit-cards/transfer-money', 'App\Http\Controllers\CreditCardController@transferMoney');
        Route::apiResource('credit-cards', CreditCardController::class);

        Route::apiResource('transactions', TransactionController::class);

        Route::put('users/auth', 'App\Http\Controllers\ProfileController@update');
        Route::get('users/auth/notifications', 'App\Http\Controllers\NotificationController@index');
    });
});

Route::get('/user', function (Request $request) {
    return new UserResource(Auth::user());
})->middleware('auth:sanctum');
