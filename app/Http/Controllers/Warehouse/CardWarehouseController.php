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
        $start_date = Carbon::parse($request->input('start_date'))->startOfDay(); // Đặt thời gian thành 00:00:00
        $end_date = Carbon::parse($request->input('end_date'))->endOfDay(); // Đặt thời gian thành 23:59:59

        // Lấy tên thiết bị
        $nameEquipment = Equipments::with('units')
            ->where('code', $equipment_code)
            ->whereNull('deleted_at')
            ->first();

        // Lấy danh sách tất cả batch_number từ nhập và xuất
        $allBatchNumbers = Receipt_details::where('equipment_code', $equipment_code)
            ->where('created_at', '<=', $start_date)
            ->groupBy('batch_number')
            ->pluck('batch_number')
            ->merge(
                Export_details::where('equipment_code', $equipment_code)
                    ->where('created_at', '<=', $start_date)
                    ->groupBy('batch_number')
                    ->pluck('batch_number')
            )
            ->unique();

        $beginning_balance_total = 0;

        foreach ($allBatchNumbers as $batch_number) {
            // Tính tổng nhập cho batch này
            $totalImportBeforeStart = Receipt_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->where('created_at', '<=', $start_date)
                ->sum('quantity');

            // Tính tổng xuất cho batch này
            $totalExportBeforeStart = Export_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->where('created_at', '<=', $start_date)
                ->sum('quantity');

            // Cộng dồn vào tồn đầu kỳ
            $beginning_balance_total += ($totalImportBeforeStart - $totalExportBeforeStart);
        }

        $ending_balance_total = $beginning_balance_total;

        // Lấy các số lô có hành động trong khoảng thời gian từ start_date đến end_date
        $allBatchNumbersInPeriod = Receipt_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('batch_number')
            ->pluck('batch_number')
            ->merge(
                Export_details::where('equipment_code', $equipment_code)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->groupBy('batch_number')
                    ->pluck('batch_number')
            )
            ->unique();

        foreach ($allBatchNumbersInPeriod as $batch_number) {
            // Tính tổng nhập trong kỳ cho batch này
            $totalImportInPeriod = Receipt_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->sum('quantity');


            // Tính tổng xuất trong kỳ cho batch này
            $totalExportInPeriod = Export_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->sum('quantity');

            // Cộng dồn vào tồn cuối kỳ
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
