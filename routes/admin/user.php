<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');

    Route::get('/user_trash', [UserController::class, 'user_trash'])->name('user.user_trash');

    Route::get('/add', [UserController::class, 'add'])->name('user.add');
    
    Route::post('/create', [UserController::class, 'create'])->name('user.create');
    
    Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
    
    Route::post('/update', [UserController::class, 'update'])->name('user.update');
});
