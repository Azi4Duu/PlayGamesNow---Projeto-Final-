<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GamePlatformController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::apiResource('games', GameController::class)->only(['index', 'show']);
    Route::apiResource('game-platforms', GamePlatformController::class)->only(['index', 'show']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [ProfileController::class, 'show']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('cart-items', CartController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('sales', SaleController::class)->only(['index', 'store', 'show']);
    });
});

