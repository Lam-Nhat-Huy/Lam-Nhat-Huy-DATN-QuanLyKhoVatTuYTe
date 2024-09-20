<?php

use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;

Route::prefix('profile')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    
});
