<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController, App\Http\Controllers\API\AuthController;

Route::prefix('v1')->group(function () {
    Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::put('/status/{id}', [TaskController::class, 'updateStatus']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
        
        Route::get('/filter/{status}', [TaskController::class, 'filter']);
    });
});
// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



