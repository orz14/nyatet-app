<?php

use App\Http\Controllers\ArtisanCallController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->controller(ArtisanCallController::class)->group(function () {
    Route::get('db-backup', 'dbBackup');
    Route::get('down', 'webDown');
    Route::get('up', 'webUp');
    Route::get('optimize', 'optimize');
});
