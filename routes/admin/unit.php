<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Unit\UnitController;
use App\Http\Middleware\CheckLogin;

Route::prefix('units')->middleware(CheckLogin::class)->group(function () {
    Route::get('/', [UnitController::class, 'index'])->name('units.index'); // Trang danh sách đơn vị
    Route::get('/create', [UnitController::class, 'create'])->name('units.create'); // Trang thêm đơn vị
    Route::post('/store', [UnitController::class, 'store'])->name('units.store'); // Xử lý thêm đơn vị
    Route::get('/edit/{code}', [UnitController::class, 'edit'])->name('units.edit'); // Trang chỉnh sửa đơn vị
    Route::put('/update/{code}', [UnitController::class, 'update'])->name('units.update'); // Sử dụng PUT cho cập nhật đơn vị
    Route::delete('/delete/{code}', [UnitController::class, 'destroy'])->name('units.destroy'); // Xóa đơn vị
    Route::get('/search/ajax', [UnitController::class, 'ajaxSearch'])->name('units.ajax.search');
});
