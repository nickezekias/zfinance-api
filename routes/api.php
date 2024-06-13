<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return response()->json(['error' => 'Already authenticated'], 200);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
