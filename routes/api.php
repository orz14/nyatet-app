<?php

use App\Http\Controllers\Api\ArtisanCallController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckConnectionController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Route;

// Testing
Route::get('/test', function () {
    return response()->json([
        'statusss' => true,
        'message' => Inspiring::quote()
    ]);
});

// Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/new-password', [AuthController::class, 'newPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/current-user', [AuthController::class, 'currentUser']);
        Route::patch('/current-user/profile', [AuthController::class, 'updateProfile']);
        Route::patch('/current-user/password', [AuthController::class, 'updatePassword']);
        Route::delete('/current-user', [AuthController::class, 'destroyUser']);
        Route::delete('/logout', [AuthController::class, 'logout']);
        Route::patch('/set-fingerprint', [AuthController::class, 'setFingerprint']);
    });

    Route::get('/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
});

// User
Route::prefix('/user')->middleware(['auth:sanctum', 'sanctum.admin'])->group(function () {
    Route::get('/', [UserController::class, 'getAllUser']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'getUser']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

// Role
Route::prefix('/role')->middleware(['auth:sanctum', 'sanctum.admin'])->group(function () {
    Route::get('/', [RoleController::class, 'getAllRole']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/{id}', [RoleController::class, 'getRole']);
    Route::patch('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
});

// Todo
Route::prefix('/todo')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TodoController::class, 'getAllTodo']);
    Route::get('/history', [TodoController::class, 'getAllHistoryTodo']);
    Route::post('/', [TodoController::class, 'store']);
    Route::patch('/{slug}/status', [TodoController::class, 'changeStatus']);
    Route::get('/{slug}', [TodoController::class, 'getTodo']);
    Route::patch('/{slug}', [TodoController::class, 'update']);
    Route::delete('/{slug}', [TodoController::class, 'destroy']);
});

// Note
Route::prefix('/note')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [NoteController::class, 'getAllNote']);
    Route::post('/', [NoteController::class, 'store']);
    Route::get('/{slug}', [NoteController::class, 'getNote']);
    Route::patch('/{slug}', [NoteController::class, 'update']);
    Route::delete('/{slug}', [NoteController::class, 'destroy']);
    Route::patch('/{slug}/lock', [NoteController::class, 'lock']);
    Route::patch('/{slug}/unlock', [NoteController::class, 'unlock']);
});

// Token
Route::prefix('/token')->middleware('auth:sanctum')->group(function () {
    Route::get('/info', [TokenController::class, 'tokenInfo']);
    Route::delete('/expired/clear', [TokenController::class, 'clearExpiredToken'])->middleware('sanctum.admin');
    Route::get('/login-log', [TokenController::class, 'getLoginLog']);
    Route::delete('/logout/{token_name}', [TokenController::class, 'logoutToken']);
    Route::delete('/clear', [TokenController::class, 'clearToken'])->middleware('sanctum.admin');
    Route::delete('/password/clear', [TokenController::class, 'clearPasswordToken'])->middleware('sanctum.admin');
});

// Artisan Call
Route::middleware(['auth:sanctum', 'sanctum.admin'])->group(function () {
    Route::post('/database-backup', [ArtisanCallController::class, 'databaseBackup']);
    Route::post('/optimize-clear', [ArtisanCallController::class, 'optimizeClear']);
});

// Other
Route::get('/check-connection', CheckConnectionController::class);

Route::get('/log', [LogController::class, 'getLog'])->middleware(['auth:sanctum', 'sanctum.admin']);
Route::post('/log', [LogController::class, 'store']);

Route::get('/next-log', [LogController::class, 'nextLogGet'])->middleware(['auth:sanctum', 'sanctum.admin']);
Route::post('/next-log', [LogController::class, 'nextLogStore']);
Route::delete('/next-log', [LogController::class, 'nextLogDestroy'])->middleware(['auth:sanctum', 'sanctum.admin']);
