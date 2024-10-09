<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->middleware(Authentication::class)->group(function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/handleLogin', [HomeController::class, 'handleLogin'])->name('home.handleLogin');

});

Route::get('/logout', [HomeController::class, 'logout'])->name('home.logout');

// Route để hiển thị form "Quên mật khẩu" (GET)
Route::get('/forgot', [HomeController::class, 'showForgotForm'])->name('home.forgot');

// Route để xử lý form "Quên mật khẩu" (POST)
Route::post('/forgot', [HomeController::class, 'processForgot'])->name('home.processForgot');

Route::get('/reset_pass', [HomeController::class, 'resetPassword'])->name('home.resetPassword');

Route::post('/reset_pass', [HomeController::class, 'updatePassword'])->name('home.reset_password');


// Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');

// Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
