<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessCardController;
use App\Http\Controllers\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

    Route::get('/business-cards', [BusinessCardController::class, 'index']);
    Route::get('/business-cards/{id}', [BusinessCardController::class, 'show']);
    Route::post('/business-cards', [BusinessCardController::class, 'store']);
    Route::put('/business-cards/{id}', [BusinessCardController::class, 'update']);
    Route::delete('/business-cards/{id}', [BusinessCardController::class, 'destroy']);

