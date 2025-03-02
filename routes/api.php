<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/payments', [PaymentController::class, 'list']);
Route::middleware('auth:sanctum')->post('/payments', [PaymentController::class, 'store']);
Route::middleware('auth:sanctum')->post('/payments/withdraw', [PaymentController::class, 'withdraw']);
Route::middleware('auth:sanctum')->post('/accounts', [AccountController::class, 'store']);
Route::middleware('auth:sanctum')->get('/accounts/{account}/history', [AccountController::class, 'history']);
Route::middleware('auth:sanctum')->get('/accounts', [AccountController::class, 'list']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
//Route::post('/accounts', [AccountController::class, 'store']);
//Route::post('/payments', [PaymentController::class, 'store']);
