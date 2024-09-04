<?php

use App\Http\Controllers\Supplier\SupplierController;
use Illuminate\Support\Facades\Route;


Route::prefix('supplier')->group(function () {
    
    Route::get('/', [SupplierController::class, 'index'])->name('supplier.list');

    Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');

    Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');

    Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit')->where(['id' => '[0-9]+']);

    Route::post('/update', [SupplierController::class, 'update'])->name('supplier.update');

    
});
