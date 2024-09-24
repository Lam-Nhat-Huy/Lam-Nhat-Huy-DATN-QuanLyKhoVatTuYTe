<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Inventory_checks;
use App\Models\Suppliers;
use App\Models\Users;
use Illuminate\Http\Request;

class CheckWarehouseController extends Controller
{
    protected $route = 'check_warehouse';

    public function index()
    {
        $title = 'Kiểm Kho';

        // Lấy danh sách kiểm kho cùng với chi tiết và thiết bị
        $inventoryChecks = Inventory_checks::with(['details.equipment', 'user'])->get();

        // Lấy tất cả nhà cung cấp và người dùng
        $users = Users::all();

        return view("{$this->route}.check", compact('title', 'inventoryChecks', 'users'));
    }

    public function search(Request $request)
    {
        $title = 'Kiểm Kho';

        $query = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $userCode = $request->input('user_code');
        $status = $request->input('status');

        $inventoryChecks = Inventory_checks::with(['user'])
            ->where(function ($q) use ($query) {
                $q->where('code', 'LIKE', "%{$query}%")
                    ->orWhere('note', 'LIKE', "%{$query}%");
            })
            ->when($startDate, function ($q) use ($startDate) {
                return $q->whereDate('check_date', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                return $q->whereDate('check_date', '<=', $endDate);
            })
            ->when($userCode, function ($q) use ($userCode) {
                return $q->where('user_code', $userCode);
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->get();

        return view("{$this->route}.search", [
            'title' => $title,
            'inventoryChecks' => $inventoryChecks,
        ]);
    }



    public function trash()
    {
        $title = 'Kiểm Kho';

        return view("{$this->route}.trash", compact('title'));
    }

    public function create()
    {
        $title = 'Kiểm Kho';

        $action = 'create';

        return view("{$this->route}.form", compact('title', 'action'));
    }

    public function store(Request $request) {}

    public function edit()
    {
        $title = 'Kiểm Kho';

        $action = 'edit';

        return view("{$this->route}.form", compact('title', 'action'));
    }

    public function update(Request $request) {}
}
