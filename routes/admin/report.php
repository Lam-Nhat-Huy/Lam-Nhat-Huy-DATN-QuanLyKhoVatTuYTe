<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Middleware\CheckLogin;

Route::prefix('report')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('report.index');

    Route::post('/', [ReportController::class, 'index'])->name('report.index');
    
    Route::get('/report_trash', [ReportController::class, 'report_trash'])->name('report.report_trash');
    
    Route::post('/report_trash', [ReportController::class, 'report_trash'])->name('report.report_trash');

    Route::get('/insert_report', [ReportController::class, 'insert_report'])->name('report.insert_report');

    Route::post('/create_report_type', [ReportController::class, 'create_report_type'])->name('report.create_report_type');

    Route::post('/delete_report_type/{id}', [ReportController::class, 'delete_report_type'])->name('report.delete_report_type');

    Route::post('/create', [ReportController::class, 'create'])->name('report.create');
    
    Route::get('/update_report/{code}', [ReportController::class, 'update_report'])->name('report.update_report');
    
    Route::post('/edit/{code}', [ReportController::class, 'edit'])->name('report.edit');
});
