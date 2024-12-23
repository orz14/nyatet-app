<?php

use App\Http\Controllers\Api\AuthController;
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
        Route::get('/me', [AuthController::class, 'me']);
        Route::delete('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('/todo')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TodoController::class, 'apiIndex']);
    Route::get('/history', [TodoController::class, 'apiHistory']);
    Route::post('/', [TodoController::class, 'apiCreate']);
    Route::patch('/{todo}', [TodoController::class, 'apiChangeStatus']);
    Route::get('/{todo}', [TodoController::class, 'apiEdit']);
    Route::patch('/{todo}/update', [TodoController::class, 'apiUpdate']);
    Route::delete('/{todo}', [TodoController::class, 'apiDestroy']);
});
