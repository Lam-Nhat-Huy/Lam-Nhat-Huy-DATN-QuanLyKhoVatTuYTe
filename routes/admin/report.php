<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;

Route::prefix('report')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('report.index');
    
    Route::get('/report_trash', [ReportController::class, 'report_trash'])->name('report.report_trash');

    Route::get('/insert_report', [ReportController::class, 'insert_report'])->name('report.insert_report');

    Route::get('/create', [ReportController::class, 'create'])->name('report.create');
    
    Route::get('/update_report', [ReportController::class, 'update_report'])->name('report.update_report');
    
    Route::get('/edit', [ReportController::class, 'edit'])->name('report.edit');
});
