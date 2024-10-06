    <?php

    use App\Http\Controllers\Equipments\EquipmentsController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Middleware\CheckLogin;


    Route::prefix('equipments')->middleware(CheckLogin::class)->group(function () {
        // TB
        Route::get('/', [EquipmentsController::class, 'index'])->name('equipments.index');
        Route::post('/', [EquipmentsController::class, 'index'])->name('equipments.index');

        // Thùng rác tb
        Route::get('/equipments_trash', [EquipmentsController::class, 'equipment_trash'])->name('equipments.equipments_trash');
        Route::post('/equipments_trash', [EquipmentsController::class, 'equipment_trash'])->name('equipments.equipments_trash');
        Route::post('/restore/{code}', [EquipmentsController::class, 'restore_equipment'])->name('equipments.restore_equipment');
        Route::delete('/delete_permanently/{code}', [EquipmentsController::class, 'delete_permanently'])->name('equipments.delete_permanently');

        // Thêm tb
        Route::get('/insert_equipments', [EquipmentsController::class, 'insert_equipment'])->name('equipments.insert_equipments');
        Route::post('/create_equipments', [EquipmentsController::class, 'create_equipment'])->name('equipments.create_equipments');

        // Sửa tb
        Route::get('/update_equipments/{code}', [EquipmentsController::class, 'update_equipment'])->name('equipments.update_equipments');
        Route::post('/edit_equipments/{code}', [EquipmentsController::class, 'edit_equipment'])->name('equipments.edit_equipments');

        // Xóa tb
        Route::delete('/delete_equipments/{code}', [EquipmentsController::class, 'delete_equipment'])->name('equipments.delete_equipments');

        // Modal thêm nhóm btn
        Route::post('/create-equipment-group-modal', [EquipmentsController::class, 'create_equipment_group_modal'])->name('equipments.create_equipment_group');
        Route::post('/delete-equipment-group-modal/{code}', [EquipmentsController::class, 'delete_equipment_group_modal'])->name('equipments.delete_equipment_group');

        // Modal thêm đơn vị
        Route::post('/create-unit-modal', [EquipmentsController::class, 'create_unit_modal'])->name('equipments.create_unit');
        Route::post('/delete-unit-modal/{code}', [EquipmentsController::class, 'delete_unit_modal'])->name('equipments.delete_unit');

        //=========================================================================================================================================
        
        // Nhóm TB
        Route::get('/equipments_group', [EquipmentsController::class, 'equipment_group'])->name('equipments.equipments_group');
        Route::post('/equipments_group', [EquipmentsController::class, 'equipment_group'])->name('equipments.equipments_group');
        Route::delete('/delete_equipments_group/{code}', [EquipmentsController::class, 'delete_equipment_group'])->name('equipments.delete_equipments_group');

        // Thùng rác ntb
        Route::get('/equipments_group_trash', [EquipmentsController::class, 'equipment_group_trash'])->name('equipments.equipments_group_trash');
        Route::post('/equipments_group_trash', [EquipmentsController::class, 'equipment_group_trash'])->name('equipments.equipments_group_trash');
        Route::post('/restore_equipment_group/{code}', [EquipmentsController::class, 'restore_equipment_group'])->name('equipments.restore_equipment_group');
        Route::delete('/delete_permanently_group/{code}', [EquipmentsController::class, 'delete_permanently_group'])->name('equipments.delete_permanently_group');

        // Thêm ntb
        Route::get('/add_equipments_group', [EquipmentsController::class, 'showCreateForm'])->name('equipments.add_equipments_group');
        Route::post('/create_equipments_group', [EquipmentsController::class, 'create_equipment_group'])->name('equipments.create_equipments_group');

        // Sửa ntb
        Route::get('/update_equipments_group/{code}', [EquipmentsController::class, 'update_equipment_group'])->name('equipments.update_equipments_group');
        Route::post('/edit_equipments_group/{code}', [EquipmentsController::class, 'edit_equipment_group'])->name('equipments.edit_equipments_group');
    });
