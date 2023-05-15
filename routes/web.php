<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
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
    Route::get('todo', [TodoController::class, 'index'])->name('todo.index');
    Route::post('todo', [TodoController::class, 'store'])->name('todo.store');
    Route::patch('todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
    Route::get('todo/history', [TodoController::class, 'history'])->name('todo.history');

    Route::get('note', [NoteController::class, 'index'])->name('note.index');
    Route::get('note/add', [NoteController::class, 'create'])->name('note.create');
    Route::post('note', [NoteController::class, 'store'])->name('note.store');
    Route::get('note/{note}/edit', [NoteController::class, 'edit'])->name('note.edit');
    Route::patch('note/{note}', [NoteController::class, 'update'])->name('note.update');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
