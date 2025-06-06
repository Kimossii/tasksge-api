<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController,App\Http\Controllers\API\AuthController;

Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/store',  [TaskController::class, 'store']);
    //Route::get('/tasks/{task}', [TaskController::class, 'updateStatus']);
    Route::put('/status', [TaskController::class, 'updateStatus']);
    Route::delete('/delete/{id}', [TaskController::class, 'destroy']);
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
