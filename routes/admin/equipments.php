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
        // Route để khôi phục thiết bị từ thùng rác
        Route::post('/restore/{code}', [EquipmentsController::class, 'restore_material'])->name('equipments.restore_material');
        // Route để xóa vĩnh viễn thiết bị
        Route::delete('/delete_permanently/{code}', [EquipmentsController::class, 'delete_permanently'])->name('equipments.delete_permanently');

        Route::get('/equipments_group', [EquipmentsController::class, 'material_group'])->name('equipments.equipments_group');

        // Route để hiển thị form thêm nhóm vật tư
        Route::get('/add_equipments_group', [EquipmentsController::class, 'showCreateForm'])->name('equipments.add_equipments_group');

        // Route để xử lý việc thêm nhóm vật tư
        Route::post('/create_equipments_group', [EquipmentsController::class, 'create_material_group'])->name('equipments.create_equipments_group');

        Route::get('/equipments_group_trash', [EquipmentsController::class, 'material_group_trash'])->name('equipments.equipments_group_trash');

        Route::get('/update_equipments_group/{code}', [EquipmentsController::class, 'update_material_group'])->name('equipments.update_equipments_group');

        Route::put('/edit_equipments_group/{code}', [EquipmentsController::class, 'edit_material_group'])->name('equipments.edit_equipments_group');

        Route::delete('/delete_equipments_group/{code}', [EquipmentsController::class, 'delete_material_group'])->name('equipments.delete_equipments_group');
        // Route để xử lý việc thêm nhóm vật tư từ modal
        Route::post('/create-material-group-modal', [EquipmentsController::class, 'create_material_group_modal'])
            ->name('equipments.create_material_group_modal');
        // Route để xử lý việc thêm đơn vị tính từ modal
        Route::post('/create-unit-modal', [EquipmentsController::class, 'create_unit_modal'])
            ->name('equipments.create_unit_modal');
        // Route để xử lý việc thêm nhà cung cấp từ modal
        Route::post('/create-supplier-modal', [EquipmentsController::class, 'create_supplier_modal'])
            ->name('equipments.create_supplier_modal');

        Route::post('/restore_material_group/{code}', [EquipmentsController::class, 'restore_material_group'])->name('equipments.restore_material_group');
        Route::delete('/delete_permanently_group/{code}', [EquipmentsController::class, 'delete_permanently_group'])->name('equipments.delete_permanently_group');
    });
