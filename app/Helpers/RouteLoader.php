<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class RouteLoader
{
    public static function load($directory)
    {
        $directory = rtrim($directory, '/') . '/';
        $routeFiles = glob($directory . '*.php');

        foreach ($routeFiles as $filePath) {
            if (file_exists($filePath)) {
                require_once $filePath;
            } else {
                Log::error("Đường dẫn không tồn tại: " . $filePath);
            }
        }
    }
}
