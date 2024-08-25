<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Warehouse\ExportController;
use App\Http\Controllers\Warehouse\ImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('system')->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('system.index');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');

    Route::prefix('warehouse')->group(function () {
    
        Route::get('/', [ImportController::class, 'index'])->name('warehouse.import');
    
        Route::get('/warehouse_export', [ExportController::class, 'index'])->name('warehouse.export');
        
    });

    Route::prefix('chat')->group(function () {
    
        Route::get('/', [ChatController::class, 'index'])->name('chat.list');
    
        Route::get('/contact', [ChatController::class, 'contact'])->name('chat.contact');
    
        Route::get('/detail/{id}', [ChatController::class, 'detail'])->name('chat.detail');
        
    });
});