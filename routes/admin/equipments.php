    <?php

    use App\Http\Controllers\Equipments\EquipmentsController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Middleware\CheckLogin;


    Route::prefix('equipments')->middleware(CheckLogin::class)->group(function () {

        Route::get('/', [EquipmentsController::class, 'index'])->name('equipments.index');

        Route::get('/equipments_trash', [EquipmentsController::class, 'material_trash'])->name('equipments.equipments_trash');

        Route::get('/insert_equipments', [EquipmentsController::class, 'insert_material'])->name('equipments.insert_equipments');

        Route::post('/create_equipments', [EquipmentsController::class, 'create_material'])->name('equipments.create_equipments');

        Route::get('/update_equipments/{code}', [EquipmentsController::class, 'update_material'])->name('equipments.update_equipments');

        Route::post('/edit_equipments/{code}', [EquipmentsController::class, 'edit_material'])->name('equipments.edit_equipments');

        Route::delete('/delete_equipments/{code}', [EquipmentsController::class, 'delete_material'])->name('equipments.delete_equipments');

        Route::get('/equipments_group', [EquipmentsController::class, 'material_group'])->name('equipments.equipments_group');

        // Route để hiển thị form thêm nhóm vật tư
        Route::get('/add_equipments_group', [EquipmentsController::class, 'showCreateForm'])->name('equipments.add_equipments_group');

        // Route để xử lý việc thêm nhóm vật tư
        Route::post('/create_equipments_group', [EquipmentsController::class, 'create_material_group'])->name('equipments.create_equipments_group');

        Route::get('/equipments_group_trash', [EquipmentsController::class, 'material_group_trash'])->name('equipments.equipments_group_trash');

        Route::get('/update_equipments_group/{code}', [EquipmentsController::class, 'update_material_group'])->name('equipments.update_equipments_group');

        Route::put('/edit_equipments_group/{code}', [EquipmentsController::class, 'edit_material_group'])->name('equipments.edit_equipments_group');

        Route::delete('/delete_equipments_group/{code}', [EquipmentsController::class, 'delete_material_group'])->name('equipments.delete_equipments_group');
    });
