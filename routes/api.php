<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return response()->json(['error' => 'Already authenticated'], 200);
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users/auth', function (Request $request) {
            return $request->user();
        });
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
