<?php

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::prefix('login')->middleware(Authenticationed::class)->group(function () {
//     Route::get('/{role_id}', [LoginController::class, 'index'])->name('login.index')->where(['role_id' => '[0-9]+']);

//     Route::post('/send_otp', [LoginController::class, 'send_otp'])->name('login.send_otp');

//     Route::get('/enter_otp', [LoginController::class, 'enter_otp'])->name('login.enter_otp');

//     Route::post('/confirm_otp', [LoginController::class, 'confirm_otp'])->name('login.confirm_otp');
// });

// Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');

// Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');