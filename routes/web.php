<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
        Route::patch('{note}', 'update')->name('update');
    });

    // Profile
    Route::prefix('profile')->controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
    });
});

// Sitemap
Route::get('/sitemap.xml', SitemapController::class);

require __DIR__.'/admin.php';

require __DIR__.'/auth.php';
