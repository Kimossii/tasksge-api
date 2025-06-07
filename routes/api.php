<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController,App\Http\Controllers\API\AuthController;

//Rotas das tarefas
Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('/list', [TaskController::class, 'list']);
    Route::get('/filter/{status}', [TaskController::class, 'filter']);
    Route::post('/store',  [TaskController::class, 'store']);
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
