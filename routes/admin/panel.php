<?php

use App\Helpers\RouteLoader;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\CheckLogin;


Route::prefix('system')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('system.index');
    RouteLoader::load(__DIR__, "/");
});
