<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Equipments;
use App\Models\Export_details;
use App\Models\Receipt_details;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardWarehouseController extends Controller
{
    protected $route = 'warehouse';

    public function index(Request $request)
    {
        $title = "Thẻ kho";

        $equipments = Equipments::all();

        return view("{$this->route}.card_warehouse.card", compact('title', 'equipments'));
    }

    public function search(Request $request)
    {
        $title = "Thẻ kho";

        $equipments = Equipments::all();

        $equipment_code = $request->input('equipment_code');
        $start_date = Carbon::parse($request->input('start_date'));
        $end_date = Carbon::parse($request->input('end_date'));

        // Lấy tên thiết bị
        $nameEquipment = Equipments::with('units')
            ->where('code', $equipment_code)
            ->whereNull('deleted_at')
            ->first();

        // Lấy tất cả dữ liệu nhập trước ngày bắt đầu, gom theo batch_number
        $receiptsBeforeStart = Receipt_details::where('equipment_code', $equipment_code)
            ->where('created_at', '<=', $start_date)
            ->whereHas('receipt', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->groupBy('batch_number')
            ->selectRaw('batch_number, SUM(quantity) as total_import')
            ->get();

        // Lấy tất cả dữ liệu xuất trước ngày bắt đầu, gom theo batch_number
        $exportsBeforeStart = Export_details::where('equipment_code', $equipment_code)
            ->where('created_at', '<=', $start_date)
            ->whereHas('export', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->groupBy('batch_number')
            ->selectRaw('batch_number, SUM(quantity) as total_export')
            ->get()->keyBy('batch_number');

        // Tính toán số dư đầu kỳ
        $beginning_balance_total = 0;
        foreach ($receiptsBeforeStart as $receipt) {
            $batch_number = $receipt->batch_number;
            $totalImportBeforeStart = $receipt->total_import;
            $totalExportBeforeStart = $exportsBeforeStart[$batch_number]->total_export ?? 0;

            $beginning_balance_total += ($totalImportBeforeStart - $totalExportBeforeStart);
        }

        // Tính toán số dư cuối kỳ, khởi đầu bằng số dư đầu kỳ
        $ending_balance_total = $beginning_balance_total;

        // Lấy tất cả dữ liệu nhập trong khoảng thời gian giữa start_date và end_date, gom theo batch_number
        $receiptsInPeriod = Receipt_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('receipt', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->groupBy('batch_number')
            ->selectRaw('batch_number, SUM(quantity) as total_import')
            ->get();

        // Lấy tất cả dữ liệu xuất trong khoảng thời gian giữa start_date và end_date, gom theo batch_number
        $exportsInPeriod = Export_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('export', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->groupBy('batch_number')
            ->selectRaw('batch_number, SUM(quantity) as total_export')
            ->get()->keyBy('batch_number');

        // Tính toán số dư cuối kỳ
        foreach ($receiptsInPeriod as $receipt) {
            $batch_number = $receipt->batch_number;
            $totalImportInPeriod = $receipt->total_import;
            $totalExportInPeriod = $exportsInPeriod[$batch_number]->total_export ?? 0;

            $ending_balance_total += ($totalImportInPeriod - $totalExportInPeriod);
        }

        // Lấy tất cả các phiếu nhập trong khoảng thời gian giữa start_date và end_date
        $getImportBetweenDate = Receipt_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('receipt', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->get();

        // Lấy tất cả các phiếu xuất trong khoảng thời gian giữa start_date và end_date
        $getExportBetweenDate = Export_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('export', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->get();

        return view("{$this->route}.card_warehouse.search", compact('title', 'equipments', 'nameEquipment', 'beginning_balance_total', 'ending_balance_total', 'getImportBetweenDate', 'getExportBetweenDate'));
    }
}
