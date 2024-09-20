<?php

use App\Http\Controllers\MaterialRequest\MaterialRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;


Route::prefix('material_request')->middleware(CheckLogin::class)->name('material_request.')->group(function () {

    // Nhập
    Route::get('/import', [MaterialRequestController::class, 'import_material_request'])->name('import');
    Route::get('/import_trash', [MaterialRequestController::class, 'import_material_request_trash'])->name('import_trash');
    Route::get('/create_import', [MaterialRequestController::class, 'create_import_material_request'])->name('create_import');
    Route::post('/store_import', [MaterialRequestController::class, 'store_import_material_request'])->name('store_import');
    Route::get('/update_import', [MaterialRequestController::class, 'update_import_material_request'])->name('update_import');
    Route::post('/edit_import', [MaterialRequestController::class, 'edit_import_material_request'])->name('edit_import');

    // Xuất
    Route::get('/export', [MaterialRequestController::class, 'export_material_request'])->name('export');
    Route::get('/export_trash', [MaterialRequestController::class, 'export_material_request_trash'])->name('export_trash');
    Route::get('/create_export', [MaterialRequestController::class, 'create_export_material_request'])->name('create_export');
    Route::post('/store_export', [MaterialRequestController::class, 'store_export_material_request'])->name('store_export');
    Route::get('/update_export', [MaterialRequestController::class, 'update_export_material_request'])->name('update_export');
    Route::post('/edit_export', [MaterialRequestController::class, 'edit_export_material_request'])->name('edit_export');
});
