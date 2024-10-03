<?php

use App\Http\Controllers\Warehouse\CardWarehouseController;
use App\Http\Controllers\Warehouse\ImportController;
use Illuminate\Support\Facades\Route;

Route::prefix('warehouse')->group(function () {
    Route::get('/import', [ImportController::class, 'import'])->name('warehouse.import');
    Route::get('/create_import', [ImportController::class, 'create_import'])->name('warehouse.create_import');
    Route::post('/store_import', [ImportController::class, 'store_import'])->name('warehouse.store_import');
    Route::get('/get_equipment/{code}', [ImportController::class, 'getEquipmentData'])->name('warehouse.get_equipment');
    Route::get('/search-import', [ImportController::class, 'searchImport'])->name('warehouse.search_import');
    Route::post('/receipts/approve/{code}', [ImportController::class, 'approve'])->name('receipts.approve');
    Route::post('receipts/delete/{code}', [ImportController::class, 'delete'])->name('receipts.delete');
    Route::get('/export-excel', [ImportController::class, 'exportExcel'])->name('warehouse.exportExcel');
    Route::post('/import-excel', [ImportController::class, 'importExcel'])->name('warehouse.importExcel');
    Route::get('/check-batch-number/{batch_number}/{equipment_code}', [ImportController::class, 'checkBatchNumber'])->name('warehouse.check_batch_number');
});
