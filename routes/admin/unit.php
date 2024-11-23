<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Unit\UnitController;
use App\Http\Middleware\CheckLogin;

Route::prefix('units')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [UnitController::class, 'index'])->name('units.index');
    Route::post('/', [UnitController::class, 'index'])->name('units.index');
    Route::get('/unit_trash', [UnitController::class, 'unit_trash'])->name('units.unit_trash');
    Route::post('/unit_trash', [UnitController::class, 'unit_trash'])->name('units.unit_trash');
    Route::get('/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/store', [UnitController::class, 'store'])->name('units.store');
    Route::get('/edit/{code}', [UnitController::class, 'edit'])->name('units.edit');
    Route::post('/update/{code}', [UnitController::class, 'update'])->name('units.update');
    Route::post('/delete/{code}', [UnitController::class, 'destroy'])->name('units.destroy');
});
