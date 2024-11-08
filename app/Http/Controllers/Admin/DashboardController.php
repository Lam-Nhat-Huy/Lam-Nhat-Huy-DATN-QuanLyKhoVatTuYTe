<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exports;
use App\Models\Inventories;
use App\Models\Inventory_checks;
use App\Models\Notifications;
use App\Models\Receipt_details;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $route = 'dashboard';

    public function index()
    {
        $title = 'Thống Kê';

        $importantNotification = Notifications::where('lock_warehouse', 1)
            ->whereNull('deleted_at')
            ->first();

        $forecastData = $this->calculateForecast();
        $forecastTrendData = $this->calculateTrendForecast();

        $threshold = 10;
        $warnings = $this->getLowInventoryWarnings($threshold);
        $exportLog = $this->getExportLog();
        $importTotal = Receipt_details::whereMonth('created_at', now()->month)
            ->sum('quantity');
        $exportTotal = Exports::whereMonth('export_date', now()->month)
            ->join('export_details', 'exports.code', '=', 'export_details.export_code')
            ->sum('export_details.quantity');

        $allReceiptDetail = Receipt_details::whereMonth('created_at', now()->month)->get();

        $monthlyImportExpenses = $this->getMonthlyImportExpenses();

        $totalPrice = 0;
        $totalDiscount = 0;
        $totalVAT = 0;

        foreach ($allReceiptDetail as $detail) {
            $price = $detail->price ?? 0;
            $quantity = $detail->quantity;
            $discount = $detail->discount ?? 0;
            $vat = $detail->VAT ?? 0;

            // Tính giá trước chiết khấu
            $itemPrice = $quantity * $price;

            // Tính tổng giá trị chiết khấu cho từng mặt hàng
            $itemDiscount = $itemPrice * ($discount / 100);

            // Tính giá sau chiết khấu
            $itemPriceAfterDiscount = $itemPrice - $itemDiscount;

            // Tính VAT dựa trên giá sau chiết khấu
            $itemVAT = $itemPriceAfterDiscount * ($vat / 100);

            // Cộng dồn tổng giá trị, chiết khấu và VAT
            $totalPrice += $itemPrice;
            $totalDiscount += $itemDiscount;
            $totalVAT += $itemVAT;
        }

        $expenseTotal = $totalPrice - $totalDiscount + $totalVAT;

        // Lấy dữ liệu tồn kho theo tháng
        $inventoryData = Inventories::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(current_quantity) as total_quantity')
        )->groupBy('month')->get();
        $importStatistics = $this->getImportStatistics(now()->month);
        $inventoryCheckLog = $this->getInventoryCheckLog();
        $getEquipmentImportMonth = $this->getEquipmentImportMonth();
        return view("admin.{$this->route}.index", compact(
            'title',
            'getEquipmentImportMonth',
            'inventoryCheckLog',
            'importStatistics',
            'forecastData',
            'forecastTrendData',
            'importantNotification',
            'warnings',
            'exportLog',
            'importTotal',
            'exportTotal',
            'expenseTotal',
            'inventoryData',
            'monthlyImportExpenses'
        ));
    }

    private function calculateForecast()
    {
        $currentInventory = 20;
        $monthlyReduction = 3;

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
            ->paginate(5, ['*'], 'low_inventory_page');

        return $lowInventories;
    }


    public function getExportLog()
    {
        $exports = Exports::with('exportDetail.equipments')
            ->whereNull('deleted_at')
            ->orderBy('export_date', 'desc')
            ->paginate(5, ['*'], 'export_log_page');

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

    public function getImportStatistics($month = null)
    {
        $query = Receipt_details::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(quantity * price) as total_value')
        );

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $importStatistics = $query->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return $importStatistics;
    }

    public function getInventoryCheckLog()
    {
        // Lấy dữ liệu từ bảng Inventory_checks và các bảng liên quan
        $inventoryChecks = Inventory_checks::with(['details.equipment', 'user', 'recheckUser'])
            ->whereNull('deleted_at')
            ->orderBy('check_date', 'desc')
            ->paginate(5, ['*'], 'inventory_check_page'); // Số lượng bản ghi trên một trang

        return $inventoryChecks;
    }

    public function getEquipmentImportMonth()
    {
        $query = Receipt_details::whereMonth('created_at', now()->month)->get();

        return $query;
    }

    public function getMonthlyImportExpenses()
    {
        // Query to calculate monthly expenses for imports
        $monthlyExpenses = Receipt_details::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(quantity * price) as total_expense')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return $monthlyExpenses;
    }
}