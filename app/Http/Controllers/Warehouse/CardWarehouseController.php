<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Equipments;
use App\Models\Exports;
use App\Models\Inventories;
use App\Models\Receipts;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardWarehouseController extends Controller
{
    protected $route = 'warehouse';

    public function index(Request $request)
    {
        $title = "Thẻ kho";
        $equipments = Equipments::all();

        $start_date = $request->session()->get('start_date', Carbon::now()->subMonths(3)->format('Y-m-d'));
        $end_date = $request->session()->get('end_date', Carbon::now()->format('Y-m-d'));
        $equipment_code = $request->session()->get('equipment_code', '');

        return view("{$this->route}.card_warehouse.card", compact('title', 'equipments', 'start_date', 'end_date', 'equipment_code'));
    }
    public function search(Request $request)
    {
        $title = "Thẻ kho";
        $equipments = Equipments::all();

        $request->session()->put('start_date', $request->input('start_date'));
        $request->session()->put('end_date', $request->input('end_date'));
        $request->session()->put('equipment_code', $request->input('equipment_code'));

        $equipment_code = $request->input('equipment_code');
        $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
        $end_date = Carbon::parse($request->input('end_date'))->endOfDay();

        $initial_inventory = 0;

        $total_previous_imports = Receipts::with('details')
            ->whereHas('details', function ($query) use ($equipment_code) {
                $query->where('equipment_code', $equipment_code);
            })
            ->where('receipt_date', '<', $start_date)
            ->get()
            ->sum(function ($import) {
                return $import->details->sum('quantity');
            });

        $total_previous_exports = Exports::with('exportDetail')
            ->whereHas('exportDetail', function ($query) use ($equipment_code) {
                $query->where('equipment_code', $equipment_code);
            })
            ->where('export_date', '<', $start_date)
            ->get()
            ->sum(function ($export) {
                return $export->exportDetail->sum('quantity');
            });

        $beginning_inventory = $initial_inventory + $total_previous_imports - $total_previous_exports;

        $imports = Receipts::with(['details', 'supplier', 'user'])
            ->whereHas('details', function ($query) use ($equipment_code) {
                $query->where('equipment_code', $equipment_code);
            })
            ->whereBetween('receipt_date', [$start_date, $end_date])
            ->where('status', '=', 1)
            ->get()
            ->map(function ($import) {
                return [
                    'type' => 'import',
                    'code' => $import->code,
                    'date' => $import->receipt_date,
                    'transaction_type' => 'Nhập kho',
                    'receipt_no' => $import->receipt_no,
                    'status' => $import->status,
                    'create_by' => $import->user->last_name . " " . $import->user->first_name,
                    'supplier' => $import->supplier->name,
                    'details' => $import->details,
                    'quantity' => $import->details->sum('quantity')
                ];
            });

        $exports = Exports::with(['exportDetail', 'departments'])
            ->whereHas('exportDetail', function ($query) use ($equipment_code) {
                $query->where('equipment_code', $equipment_code);
            })
            ->whereBetween('export_date', [$start_date, $end_date])
            ->where('status', '=', 1)
            ->get()
            ->map(function ($export) {
                return [
                    'type' => 'export',
                    'code' => $export->code,
                    'date' => $export->export_date,
                    'transaction_type' => 'Xuất kho',
                    'department' => $export->departments->name,
                    'status' => $export->status,
                    'create_by' => $export->user->last_name . " " . $export->user->first_name,
                    'details' => $export->exportDetail,
                    'quantity' => $export->exportDetail->sum('quantity')
                ];
            });

        $transactions = $imports->concat($exports)->sortBy('date')->values();

        $transactions = $transactions->map(function ($transaction) use (&$beginning_inventory) {
            $transaction['begin_stock'] = $beginning_inventory;
            if ($transaction['type'] === 'import') {
                $beginning_inventory += $transaction['quantity'];
            } else {
                $beginning_inventory -= $transaction['quantity'];
            }
            $transaction['end_stock'] = $beginning_inventory;
            return $transaction;
        })->sortByDesc('date');
        return view("{$this->route}.card_warehouse.search", compact('title', 'equipments', 'transactions'));
    }
}
