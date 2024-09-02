<?php

use App\Http\Controllers\OrderRequest\OrderRequestController;
use Illuminate\Support\Facades\Route;


Route::prefix('order_request')->group(function () {
    
    Route::get('/', [OrderRequestController::class, 'index'])->name('order_request.index');
    
    Route::get('/order_request_trash', [OrderRequestController::class, 'order_request_trash'])->name('order_request.order_request_trash');

    Route::get('/insert_order_request', [OrderRequestController::class, 'insert_order_request'])->name('order_request.insert_order_request');

    Route::get('/create', [OrderRequestController::class, 'create'])->name('order_request.create');
    
    Route::get('/update_order_request', [OrderRequestController::class, 'update_order_request'])->name('order_request.update_order_request');

    Route::get('/edit', [OrderRequestController::class, 'edit'])->name('order_request.edit');
});
