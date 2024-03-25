<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessCardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/business-cards', [BusinessCardController::class, 'index']);
Route::get('/business-cards/{id}', [BusinessCardController::class, 'show']);
Route::post('/business-cards', [BusinessCardController::class, 'store']);
Route::put('/business-cards/{id}', [BusinessCardController::class, 'update']);
Route::delete('/business-cards/{id}', [BusinessCardController::class, 'destroy']);

