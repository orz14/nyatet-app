<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/current-user', [AuthController::class, 'currentUser']);
        Route::patch('/current-user/profile', [AuthController::class, 'updateProfile']);
        Route::patch('/current-user/password', [AuthController::class, 'updatePassword']);
        Route::delete('/current-user', [AuthController::class, 'destroyUser']);
        Route::delete('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('/todo')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TodoController::class, 'getAllTodo']);
    Route::get('/history', [TodoController::class, 'getAllHistoryTodo']);
    Route::post('/', [TodoController::class, 'store']);
    Route::patch('/{slug}/status', [TodoController::class, 'changeStatus']);
    Route::get('/{slug}', [TodoController::class, 'getTodo']);
    Route::patch('/{slug}', [TodoController::class, 'update']);
    Route::delete('/{slug}', [TodoController::class, 'destroy']);
});

Route::prefix('/note')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [NoteController::class, 'getAllNote']);
    Route::post('/', [NoteController::class, 'store']);
    Route::get('/{slug}', [NoteController::class, 'getNote']);
    Route::patch('/{slug}', [NoteController::class, 'update']);
    Route::delete('/{slug}', [NoteController::class, 'destroy']);
    Route::patch('/{slug}/lock', [NoteController::class, 'lock']);
    Route::patch('/{slug}/unlock', [NoteController::class, 'unlock']);
});
