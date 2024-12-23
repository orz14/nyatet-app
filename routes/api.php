<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/current-user', [AuthController::class, 'currentUser']);
        Route::patch('/current-user/profile', [AuthController::class, 'updateProfile']);
        Route::patch('/current-user/password', [AuthController::class, 'updatePassword']);
        Route::delete('/current-user', [AuthController::class, 'destroyUser']);
        Route::delete('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('/todo')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TodoController::class, 'apiIndex']);
    Route::get('/history', [TodoController::class, 'apiHistory']);
    Route::post('/', [TodoController::class, 'apiCreate']);
    Route::patch('/{slug}/status', [TodoController::class, 'apiChangeStatus']);
    Route::get('/{slug}', [TodoController::class, 'apiEdit']);
    Route::patch('/{slug}', [TodoController::class, 'apiUpdate']);
    Route::delete('/{slug}', [TodoController::class, 'apiDestroy']);
});

Route::prefix('/note')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [NoteController::class, 'apiIndex']);
    Route::post('/', [NoteController::class, 'apiCreate']);
    Route::get('/{slug}', [NoteController::class, 'apiEdit']);
    Route::patch('/{slug}', [NoteController::class, 'apiUpdate']);
    Route::delete('/{slug}', [NoteController::class, 'apiDestroy']);
    Route::patch('/{slug}/lock', [NoteController::class, 'apiLock']);
    Route::patch('/{slug}/unlock', [NoteController::class, 'apiUnlock']);
});
