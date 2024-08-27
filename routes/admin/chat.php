<?php

use App\Http\Controllers\Chat\ChatController;
use Illuminate\Support\Facades\Route;


Route::prefix('chat')->group(function () {
    
    Route::get('/', [ChatController::class, 'index'])->name('chat.list');

    Route::get('/contact', [ChatController::class, 'contact'])->name('chat.contact');

    Route::get('/detail/{id}', [ChatController::class, 'detail'])->name('chat.detail');
    
});
