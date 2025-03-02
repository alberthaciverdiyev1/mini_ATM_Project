<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('payments')->group(function () {
        Route::post('/', [PaymentController::class, 'store']);
        Route::post('/withdraw', [PaymentController::class, 'withdraw']);
        Route::delete('/{payment}', [PaymentController::class, 'destroy']);
    });

    Route::prefix('accounts')->group(function () {
        Route::post('/', [AccountController::class, 'store']);
        Route::get('/', [AccountController::class, 'list']);
        Route::get('/{account}/history', [AccountController::class, 'history']);
    });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
