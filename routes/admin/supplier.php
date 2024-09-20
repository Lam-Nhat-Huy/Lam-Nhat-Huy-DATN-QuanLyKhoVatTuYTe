<?php

use App\Http\Controllers\Supplier\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;


Route::prefix('supplier')->middleware(CheckLogin::class)->group(function () {

    Route::get('/', [SupplierController::class, 'index'])->name('supplier.list');

    Route::get('/trash', [SupplierController::class, 'trash'])->name('supplier.trash');

    Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');

    Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');

    Route::get('/edit', [SupplierController::class, 'edit'])->name('supplier.edit');

    Route::post('/update', [SupplierController::class, 'update'])->name('supplier.update');


});
