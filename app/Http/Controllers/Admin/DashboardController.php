<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $route = 'dashboard';

    public function index()
    {
        $title = 'Thống Kê';

        $importantNotification = Notifications::where('important', 1)
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->first();

        // Example forecast data (replace with actual logic)
        $forecastData = $this->calculateForecast();

        return view("admin.{$this->route}.index", compact('title', 'forecastData', 'importantNotification'));
    }

    private function calculateForecast()
    {
        // Example logic: generate dummy forecast data for the next 5 months
        $currentInventory = 20; // Example current inventory
        $monthlyReduction = 3; // Example reduction per month

        $forecast = [];
        for ($i = 1; $i <= 5; $i++) {
            $month = Carbon::now()->addMonths($i)->format('F');
            $forecast[] = [
                'month' => $month,
                'inventory' => max($currentInventory - ($monthlyReduction * $i), 0)
            ];
        }

        return $forecast;
    }
}
