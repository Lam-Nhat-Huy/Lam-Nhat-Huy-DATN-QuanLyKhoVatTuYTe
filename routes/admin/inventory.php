<?php

use App\Http\Controllers\Inventory\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;


Route::prefix('inventory')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
});
