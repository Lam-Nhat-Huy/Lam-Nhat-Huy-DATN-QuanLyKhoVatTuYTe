<?php

use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Route;


Route::prefix('forgot')->group(function () {
    
    Route::get('/forgot', [AccountController::class, 'forgot'])->name('forgot.forgot');
    
});
