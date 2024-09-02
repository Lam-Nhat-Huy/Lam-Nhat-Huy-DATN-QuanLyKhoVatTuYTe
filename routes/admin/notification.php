<?php

use App\Http\Controllers\Notification\NotificationController;
use Illuminate\Support\Facades\Route;


Route::prefix('notification')->group(function () {

    Route::get('/', [NotificationController::class, 'index'])->name('notification.index');

    Route::get('/notification_trash', [NotificationController::class, 'notification_trash'])->name('notification.notification_trash');

    Route::get('/notification_add', [NotificationController::class, 'notification_add'])->name('notification.notification_add');

    Route::post('/notification_create', [NotificationController::class, 'notification_create'])->name('notification.notification_create');

    Route::get('/notification_edit', [NotificationController::class, 'notification_edit'])->name('notification.notification_edit');

    Route::post('/notification_update', [NotificationController::class, 'notification_update'])->name('notification.notification_update');

    Route::get('/notification_type', [NotificationController::class, 'notification_type'])->name('notification.notification_type');

    Route::get('/notification_type_trash', [NotificationController::class, 'notification_type_trash'])->name('notification.notification_type_trash');

    Route::get('/notification_type_add', [NotificationController::class, 'notification_type_add'])->name('notification.notification_type_add');

    Route::post('/notification_type_create', [NotificationController::class, 'notification_type_create'])->name('notification.notification_type_create');

    Route::get('/notification_type_edit', [NotificationController::class, 'notification_type_edit'])->name('notification.notification_type_edit');

    Route::post('/notification_type_update', [NotificationController::class, 'notification_type_update'])->name('notification.notification_type_update');
});
