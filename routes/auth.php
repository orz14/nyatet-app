<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('login')->controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('/', 'create')->name('login');
        Route::post('/', 'store');
        Route::get('/{provider}', 'redirectToProvider')->name('login.provider');
        Route::get('/callback/{provider}', 'handleProviderCallback')->name('login.provider.callback');
    });

    Route::prefix('register')->controller(RegisteredUserController::class)->group(function () {
        Route::get('/', 'create')->name('register');
        Route::post('/', 'store');
    });

    Route::name('password.')->group(function () {
        Route::prefix('forgot-password')->controller(PasswordResetLinkController::class)->group(function () {
            Route::get('/', 'create')->name('request');
            Route::post('/', 'store')->name('email');
        });

        Route::prefix('reset-password')->controller(NewPasswordController::class)->group(function () {
            Route::get('/{token}', 'create')->name('reset');
            Route::post('/', 'store')->name('store');
        });
    });
});
