<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandlordController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!'
        
    ]);

});

Route::get('/landlords/{id}', [LandlordController::class, 'show']);
Route::get('/landlords', [LandlordController::class, 'index']);
Route::post('/landlords', [LandlordController::class, 'store']);
Route::put('/landlords/{id}', [LandlordController::class, 'update']);
Route::delete('/landlords/{id}', [LandlordController::class, 'destroy']);

    
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'show']);
});

