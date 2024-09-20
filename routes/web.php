<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Middleware\Authenticationed;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->middleware(Authenticationed::class)->group(function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/handleLogin', [HomeController::class, 'handleLogin'])->name('home.handleLogin');

});

Route::get('/logout', [HomeController::class, 'logout'])->name('home.logout');

// Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');

// Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
