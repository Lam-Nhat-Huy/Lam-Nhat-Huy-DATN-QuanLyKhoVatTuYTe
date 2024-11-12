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

        $receiptsBeforeStart = Receipt_details::where('equipment_code', $equipment_code)
            ->where('created_at', '<=', $start_date)
            ->whereHas('receipt', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->get(['batch_number', 'quantity']);

        $beginning_balance_total = 0;

        foreach ($receiptsBeforeStart as $receipt) {
            $batch_number = $receipt->batch_number;

            $totalImportBeforeStart = Receipt_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->where('created_at', '<=', $start_date)
                ->whereHas('receipt', function ($subReceipt) {
                    $subReceipt->whereNull('deleted_at')
                        ->where('status', 1);
                })
                ->sum('quantity');

            $totalExportBeforeStart = Export_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->where('created_at', '<=', $start_date)
                ->whereHas('export', function ($subReceipt) {
                    $subReceipt->whereNull('deleted_at')
                        ->where('status', 1);
                })
                ->sum('quantity');

            $beginning_balance_batch = $totalImportBeforeStart - $totalExportBeforeStart;

            $beginning_balance_total += $beginning_balance_batch;
        }

        $ending_balance_total = $beginning_balance_total;

        $receiptsInPeriod = Receipt_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('receipt', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->get(['batch_number', 'quantity']);

        foreach ($receiptsInPeriod as $receipt) {
            $batch_number = $receipt->batch_number;

            $totalImportInPeriod = Receipt_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->whereHas('receipt', function ($subReceipt) {
                    $subReceipt->whereNull('deleted_at')
                        ->where('status', 1);
                })
                ->sum('quantity');

            $totalExportInPeriod = Export_details::where('equipment_code', $equipment_code)
                ->where('batch_number', $batch_number)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->whereHas('export', function ($subReceipt) {
                    $subReceipt->whereNull('deleted_at')
                        ->where('status', 1);
                })
                ->sum('quantity');

            $ending_balance_batch = $totalImportInPeriod - $totalExportInPeriod;

            $ending_balance_total += $ending_balance_batch;
        }

        $getImportBetweenDate = Receipt_details::where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('receipt', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->get();

        $getExportBetweenDate = Export_details::with(['export'])
            ->where('equipment_code', $equipment_code)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->whereHas('export', function ($subReceipt) {
                $subReceipt->whereNull('deleted_at')
                    ->where('status', 1);
            })
            ->get();

        return view("{$this->route}.card_warehouse.search", compact('title', 'equipments', 'nameEquipment', 'beginning_balance_total', 'ending_balance_total', 'getImportBetweenDate', 'getExportBetweenDate'));
    }
}
