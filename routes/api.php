<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Quote\IndexController;
use App\Http\Controllers\Quote\RefreshController;
use App\Http\Middleware\ApiTokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);

Route::middleware(ApiTokenMiddleware::class)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/quotes', IndexController::class);
    Route::get('/quotes/refresh', RefreshController::class);
});
