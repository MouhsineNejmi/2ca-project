<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
  Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'create']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/', [TaskController::class,'delete']);
  });
  
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
});

Route::get('/health', function () {
  return response()->json(['message' => 'SERVER RUNNING!!!']);
});