<?php

use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->group(function () {
    
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    
});
