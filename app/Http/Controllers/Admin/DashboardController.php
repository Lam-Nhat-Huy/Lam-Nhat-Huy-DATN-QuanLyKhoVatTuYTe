<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exports;
use App\Models\Inventories;
use App\Models\Notifications;
use App\Models\Receipt_details;
use App\Models\Receipts;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $forecastTrendData = $this->calculateTrendForecast();
        
        $threshold = 10; // Ngưỡng cảnh báo tồn kho (ví dụ 10)
        $warnings = $this->getLowInventoryWarnings($threshold);
        $exportLog = $this->getExportLog();
        $importTotal = Receipt_details::whereMonth('created_at', now()->month)
            ->sum('quantity');
        $exportTotal = Exports::whereMonth('export_date', now()->month)
            ->join('export_details', 'exports.code', '=', 'export_details.export_code')  // Kết hợp bảng exports và export_details
            ->sum('export_details.quantity');  // Tính tổng số lượng từ bảng export_details

        $expenseTotal = Receipt_details::whereMonth('created_at', now()->month)
            ->sum(DB::raw('quantity * price'));
        // Lấy dữ liệu tồn kho theo tháng
        $inventoryData = Inventories::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(current_quantity) as total_quantity')
        )->groupBy('month')->get();

        return view("admin.{$this->route}.index", compact('title', 'forecastData','forecastTrendData', 'importantNotification', 'warnings', 'exportLog', 'importTotal', 'exportTotal', 'expenseTotal','inventoryData'));
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
    public function getLowInventoryWarnings($threshold = 10)
    {
        $lowInventories = Inventories::where('current_quantity', '<=', $threshold)
            ->whereNull('deleted_at')
            ->paginate(7, ['*'], 'low_inventory_page');  // Đặt tên cho phân trang

        return $lowInventories;
    }


    public function getExportLog()
    {
        $exports = Exports::with('exportDetail.equipments')
            ->whereNull('deleted_at')
            ->orderBy('export_date', 'desc')
            ->paginate(4, ['*'], 'export_log_page');  // Đặt tên cho phân trang

        return $exports;
    }
    private function calculateTrendForecast()
{
    // Lấy dữ liệu tồn kho từ 6 tháng trước
    $historicalData = Inventories::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(current_quantity) as total_quantity')
    )->where('created_at', '>=', Carbon::now()->subMonths(6))
     ->groupBy('month')
     ->orderBy('month', 'asc')
     ->get()
     ->pluck('total_quantity')
     ->toArray();

    $forecast = [];
    $numMonths = count($historicalData);
    
    // Nếu có đủ dữ liệu, áp dụng trung bình động
    if ($numMonths > 0) {
        $average = array_sum($historicalData) / $numMonths;

        // Dự báo cho 5 tháng tới dựa trên giá trị trung bình
        for ($i = 1; $i <= 5; $i++) {
            $month = Carbon::now()->addMonths($i)->format('F');
            $forecast[] = [
                'month' => $month,
                'inventory' => max($average, 0) // Ngăn chặn giá trị âm
            ];
        }
    }

    return $forecast;
}

}
