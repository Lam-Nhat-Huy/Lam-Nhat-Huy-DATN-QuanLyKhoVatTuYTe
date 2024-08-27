<?php

use App\Http\Controllers\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Route;


Route::prefix('warehouse')->group(function () {
    
    Route::get('/import', [WarehouseController::class, 'import'])->name('warehouse.import');

    Route::get('/export', [WarehouseController::class, 'export'])->name('warehouse.export');
    
});
