<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Log;

Route::prefix('system')->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('system.index');

    $routeFiles = [
        'admin/report.php',
        'admin/warehouse.php',
        'admin/chat.php',
        'admin/profile.php',
    ];

    foreach ($routeFiles as $routeFile) {
        $filePath = __DIR__ . '/' . $routeFile;
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            Log::error("Đường dẫn không tồn tại: " . $filePath);
        }
    }
});