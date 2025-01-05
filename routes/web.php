<?php

use App\Http\Controllers\CSRFTokenController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    // Todo
    Route::prefix('todo')->controller(TodoController::class)->name('todo.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('history', 'history')->name('history');
    });

    // Note
    Route::prefix('note')->controller(NoteController::class)->name('note.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('add', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{note}/edit', 'edit')->name('edit');
        Route::match(['get', 'patch'], '{note}', 'update')->name('update');
    });

    // Profile
    Route::prefix('profile')->controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
    });
});

// Sitemap
Route::get('/sitemap.xml', SitemapController::class);

// Token Management
Route::get('/refresh-csrf', CSRFTokenController::class)->name('refresh-csrf');
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])->name('sanctum.csrf-cookie');

require __DIR__ . '/admin.php';

require __DIR__ . '/auth.php';
