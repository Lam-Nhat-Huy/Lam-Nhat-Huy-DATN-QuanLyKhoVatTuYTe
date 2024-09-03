<?php

use App\Http\Controllers\Warehouse\CheckWarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('warehouse')->group(function () {
    Route::get('/index', [CheckWarehouseController::class, 'index'])->name('check_warehouse.index');
    Route::get('/store', [CheckWarehouseController::class, 'create'])->name('check_warehouse.create');
    Route::post('/store', [CheckWarehouseController::class, 'store'])->name('check_warehouse.store');
});

