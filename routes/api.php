<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\TransactionController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function () {
        return auth()->user();
    });

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::post('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);

    Route::get('/balance/{user}', [BalanceController::class, 'show']);

    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::get('/transaction/{user}', [TransactionController::class, 'show']);
    Route::get('/transaction/{user}/export', [TransactionController::class, 'export']);
    Route::delete('/transaction/{transaction}', [TransactionController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::fallback(function () {
    if (env('APP_DEBUG') && env('APP_ENV') !== 'production') {
        abort(Response::HTTP_NOT_FOUND, 'API resource not found');
    }

    response()->json(['message' => 'API Resource Not Found'], Response::HTTP_NOT_FOUND);
});
