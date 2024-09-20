<?php

use App\Http\Controllers\Material\MaterialController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;


Route::prefix('material')->middleware(CheckLogin::class)->group(function () {
    
    Route::get('/', [MaterialController::class, 'index'])->name('material.index');
    
    Route::get('/material_trash', [MaterialController::class, 'material_trash'])->name('material.material_trash');

    Route::get('/insert_material', [MaterialController::class, 'insert_material'])->name('material.insert_material');

    Route::post('/create_material', [MaterialController::class, 'create_material'])->name('material.create_material');
    
    Route::get('/update_material', [MaterialController::class, 'update_material'])->name('material.update_material');

    Route::post('/edit_material', [MaterialController::class, 'edit_material'])->name('material.edit_material');

    Route::get('/material_group', [MaterialController::class, 'material_group'])->name('material.material_group');

    Route::post('/create_material_group', [MaterialController::class, 'create_material_group'])->name('material.create_material_group');
    
    Route::get('/material_group_trash', [MaterialController::class, 'material_group_trash'])->name('material.material_group_trash');

    Route::get('/update_material_group', [MaterialController::class, 'update_material_group'])->name('material.update_material_group');

    Route::post('/edit_material_group', [MaterialController::class, 'edit_material_group'])->name('material.edit_material_group');
});
