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

        Route::apiResource('credit-cards/requests', CreditCardRequestController::class);

        Route::apiResource('credit-cards', CreditCardController::class);
        Route::post('credit-cards/transfer-money', 'App\Http\Controllers\CreditCardController@transferMoney');
        Route::post('credit-cards/recharge', 'App\Http\Controllers\CreditCardController@rechargeCard');

        Route::apiResource('transactions', TransactionController::class);

        Route::put('users/auth', 'App\Http\Controllers\ProfileController@update');
        Route::get('users/auth/notifications', 'App\Http\Controllers\NotificationController@index');
    });
});

Route::get('/user', function (Request $request) {
    return new UserResource(Auth::user());
})->middleware('auth:sanctum');




/*
 *  ADMIN ROUTES
 * 
 */
require __DIR__ . '/admin_api.php';

/* Route::prefix('v1')->group(function () {
    Route::prefix('admin')->group(function() {
        Route::name('admin.')->group(function() {
            Route::post('login', 'App\Http\Controllers\Admin\AuthController@login')->name('login');
            Route::post('forgot-password', 'App\Http\Controllers\Admin\AuthController@forgotPassword')->name('password.email');
            Route::post('reset-password', 'App\Http\Controllers\Admin\AuthController@resetPassword')->name('password.reset');

            Route::middleware('auth:admin')->group(function() {
                Route::get('logout', 'App\Http\Controllers\Admin\AuthController@logout')->name('logout');
            });
        });
    });
});
 */