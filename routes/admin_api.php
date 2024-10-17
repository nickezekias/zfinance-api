<?php

use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('admin')->group(function() {
        Route::name('admin.')->group(function() {
            Route::post('login', 'App\Http\Controllers\Admin\AuthController@login')->name('login');
            Route::post('forgot-password', 'App\Http\Controllers\Admin\AuthController@forgotPassword')->name('password.email');
            Route::post('reset-password', 'App\Http\Controllers\Admin\AuthController@resetPassword')->name('password.reset');

            Route::middleware('auth:admin')->group(function() {
                Route::post('logout', 'App\Http\Controllers\Admin\AuthController@logout')->name('logout');

                Route::get('/users/auth', function (Request $request) {
                    return new AdminResource(Auth::guard('admin')->user());
                });
            });
        });
    });
});