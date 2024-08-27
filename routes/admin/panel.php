<?php

use App\Helpers\RouteLoader;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;


Route::prefix('system')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('system.index');
    RouteLoader::load(__DIR__, "/");
});
