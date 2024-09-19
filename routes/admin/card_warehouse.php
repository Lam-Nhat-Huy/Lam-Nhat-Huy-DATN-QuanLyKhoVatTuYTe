<?php

use App\Http\Controllers\Warehouse\CardWarehouseController;
use Illuminate\Support\Facades\Route;

Route::prefix('card_warehouse')->group(function () {
    Route::get('/index', [CardWarehouseController::class, 'index'])->name('card_warehouse.index');
});
