<?php

use App\Http\Controllers\Warehouse\CheckWarehouseController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;

Route::prefix('check_warehouse')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [CheckWarehouseController::class, 'index'])->name('check_warehouse.index');

    Route::get('/trash', [CheckWarehouseController::class, 'trash'])->name('check_warehouse.trash');

    Route::get('/create', [CheckWarehouseController::class, 'create'])->name('check_warehouse.create');

    Route::post('/store', [CheckWarehouseController::class, 'store'])->name('check_warehouse.store');

    Route::get('/edit', [CheckWarehouseController::class, 'edit'])->name('check_warehouse.edit');

    Route::post('/update', [CheckWarehouseController::class, 'update'])->name('check_warehouse.update');

    Route::get('/search-import', [CheckWarehouseController::class, 'search'])->name('check_warehouse.search');

    Route::post('/approve/{code}', [CheckWarehouseController::class, 'approveCheck'])->name('check_warehouse.approve');
});
