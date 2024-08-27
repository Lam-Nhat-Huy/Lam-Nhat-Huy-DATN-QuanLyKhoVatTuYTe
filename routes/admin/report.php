<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;

Route::prefix('system')->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
});
