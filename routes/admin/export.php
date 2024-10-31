<?php

use App\Http\Controllers\Warehouse\ExportController;
use Illuminate\Support\Facades\Route;

Route::prefix('warehouse')->group(function () {
    Route::get('/export', [ExportController::class, 'export'])->name('warehouse.export');
    Route::post('/export', [ExportController::class, 'export'])->name('warehouse.export');
    Route::get('/trash_export', [ExportController::class, 'exportTrash'])->name('warehouse.trash_export');
    Route::post('/trash_export', [ExportController::class, 'exportTrash'])->name('warehouse.trash_export');
    Route::get('/create_export', [ExportController::class, 'create_export'])->name('warehouse.create_export');
    Route::post('/create_export', [ExportController::class, 'create_export'])->name('warehouse.create_export');
    Route::post('/store_export', [ExportController::class, 'store_export'])->name('warehouse.store_export');
    Route::post('/export_equipment_request', [ExportController::class, 'export_equipment_request'])->name('warehouse.export_equipment_request');
    Route::get('/edit_export/{code}', [ExportController::class, 'edit_export'])->name('warehouse.edit_export');
    Route::post('/edit_export/{code}', [ExportController::class, 'edit_export'])->name('warehouse.edit_export');
    Route::post('/update_export/{code}', [ExportController::class, 'update_export'])->name('warehouse.update_export');
    Route::post('/approve_export', [ExportController::class, 'approve'])->name('warehouse.approve');
    Route::post('/delete_export', [ExportController::class, 'delete'])->name('warehouse.delete');
});
