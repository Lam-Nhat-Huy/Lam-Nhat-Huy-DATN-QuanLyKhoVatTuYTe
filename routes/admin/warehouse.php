<?php

use App\Http\Controllers\Warehouse\CardWarehouseController;
use App\Http\Controllers\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('warehouse')->group(function () {
    Route::get('/import', [WarehouseController::class, 'import'])->name('warehouse.import');
    Route::get('/export', [WarehouseController::class, 'export'])->name('warehouse.export');
    Route::get('/create_import', [WarehouseController::class, 'create_import'])->name('warehouse.create_import');
    Route::get('/create_export', [WarehouseController::class, 'create_export'])->name('warehouse.create_export');
    Route::post('/store_export', [WarehouseController::class, 'store_export'])->name('warehouse.store_export');
    Route::post('/store_import', [WarehouseController::class, 'store_import'])->name('warehouse.store_import');
    Route::get('/inventory', [WarehouseController::class, 'inventory'])->name('warehouse.inventory');
});

Route::prefix('card_warehouse')->group(function () {
    Route::get('/index', [CardWarehouseController::class, 'index'])->name('card_warehouse.index');
});
