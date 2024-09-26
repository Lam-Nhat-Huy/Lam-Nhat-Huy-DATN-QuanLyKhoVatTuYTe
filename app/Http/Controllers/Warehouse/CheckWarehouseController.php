<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Equipments;
use App\Models\Inventories;
use App\Models\Inventory_check_details;
use App\Models\Inventory_checks;
use App\Models\Suppliers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckWarehouseController extends Controller
{
    protected $route = 'check_warehouse';

    public function index()
    {
        $title = 'Kiểm Kho';

        // Lấy danh sách kiểm kho cùng với chi tiết và thiết bị
        $inventoryChecks = Inventory_checks::with(['details.equipment', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();


        // Lấy tất cả nhà cung cấp và người dùng
        $users = Users::all();


        return view("{$this->route}.check", compact('title', 'inventoryChecks', 'users'));
    }

    public function create()
    {
        $title = 'Kiểm Kho';

        $action = 'create';

        // Lấy danh sách vật tư có tồn kho (current_quantity > 0)
        $equipmentsWithStock = Equipments::whereHas('inventories', function ($query) {
            $query->where('current_quantity', '>', 0);
        })->with(['inventories' => function ($query) {
            $query->select('equipment_code', 'current_quantity', 'batch_number'); // Chọn các cột cần từ inventories
        }])->get();


        return view("{$this->route}.form", compact('title', 'action', 'equipmentsWithStock'));
    }

    public function store(Request $request)
    {
        // Lấy dữ liệu từ form (JSON) và chuyển đổi thành mảng
        $materialData = json_decode($request->input('materialData'), true);

        // Kiểm tra nếu dữ liệu rỗng
        if (empty($materialData)) {
            toastr()->error('Đã lưu phiếu kiểm kho thất bại.');
            return redirect()->back();
        }

        // Tạo mảng dữ liệu cho phiếu kiểm kho
        $inventoryCheckData = [
            'equipment_code' => $materialData[0]['equipment_code'],
            'check_date' => $materialData[0]['check_date'],
            'note' => $materialData[0]['note'],
            'user_code' => $materialData[0]['created_by'],
            'status' => $materialData[0]['status']
        ];

        // Lấy phiếu kiểm kho cuối cùng dựa trên thời gian tạo
        $lastInventoryCheck = Inventory_checks::orderBy('created_at', 'desc')->first();

        if ($lastInventoryCheck) {
            // Lấy phần số từ chuỗi mã cuối cùng, ví dụ: 'INC0001' -> '0001' và chuyển thành số nguyên
            $lastInventoryNumber = (int)substr($lastInventoryCheck->code, 3);
            $newInventoryNumber = $lastInventoryNumber + 1;
        } else {
            // Nếu chưa có phiếu kiểm kho nào, bắt đầu từ 1
            $newInventoryNumber = 1;
        }

        // Tạo mã phiếu kiểm kho mới với tiền tố 'INC' và điền số thứ tự 4 chữ số
        $newInventoryCheckCode = 'INC' . str_pad($newInventoryNumber, 4, '0', STR_PAD_LEFT);

        // Kiểm tra xem mã vừa tạo đã tồn tại chưa, nếu có, tăng giá trị số thứ tự
        while (Inventory_checks::where('code', $newInventoryCheckCode)->exists()) {
            $newInventoryNumber++;
            $newInventoryCheckCode = 'INC' . str_pad($newInventoryNumber, 4, '0', STR_PAD_LEFT);
        }

        // Gán mã mới cho dữ liệu phiếu kiểm kho
        $inventoryCheckData['code'] = $newInventoryCheckCode;

        // Tạo phiếu kiểm kho mới
        $inventoryCheck = Inventory_checks::create($inventoryCheckData);

        // Kiểm tra nếu việc lưu phiếu kiểm kho thất bại
        if (!$inventoryCheck) {
            toastr()->error('Lỗi khi lưu phiếu kiểm kho.');
            return redirect()->back();
        }

        // Lấy mã phiếu kiểm kho vừa tạo
        $inventoryCheckCode = $inventoryCheck->code;

        // Tạo dữ liệu chi tiết phiếu kiểm kho
        $inventoryCheckDetailData = [];

        foreach ($materialData as $material) {
            $inventoryCheckDetailData[] = [
                'inventory_check_code' => $inventoryCheckCode,
                'equipment_code' => $material['equipment_code'],
                'batch_number' => $material['batch_number'],
                'current_quantity' => $material['current_quantity'],
                'actual_quantity' => $material['actual_quantity'],
                'unequal' => $material['unequal'],
            ];
        }

        // Lưu dữ liệu chi tiết phiếu kiểm kho vào bảng inventory_check_details
        try {
            Inventory_check_details::insert($inventoryCheckDetailData);
        } catch (\Exception $e) {
            toastr()->error('Lỗi khi lưu chi tiết phiếu kiểm kho: ' . $e->getMessage());
            return redirect()->back();
        }

        // Nếu status == 1, cập nhật số lượng tồn kho theo kết quả kiểm kho
        if ($materialData[0]['status'] == 1) {
            foreach ($materialData as $material) {
                $this->updateInventoryByCheck($material);
            }
            toastr()->success('Đã lưu và cập nhật kho thành công với mã ' . $inventoryCheckCode);
        } else {
            toastr()->warning('Phiếu kiểm kho tạm đã được lưu với mã ' . $inventoryCheckCode);
        }

        // Điều hướng về trang danh sách phiếu kiểm kho sau khi lưu thành công
        return redirect()->route('check_warehouse.index');
    }

    // Hàm cập nhật số lượng tồn kho theo kết quả kiểm kho
    private function updateInventoryByCheck($material)
    {
        // Tìm lô hàng trong kho dựa vào mã thiết bị và số lô
        $inventory = Inventories::where('equipment_code', $material['equipment_code'])
            ->where('batch_number', $material['batch_number'])
            ->first();

        if ($inventory) {
            // Cập nhật số lượng thực tế trong kho
            $inventory->current_quantity = $material['actual_quantity'];
            $inventory->save();
        } else {
            // Nếu không tìm thấy lô hàng, tạo mới record trong bảng inventories
            $newInventoryCode = 'INV' . str_pad(Inventories::count() + 1, 4, '0', STR_PAD_LEFT);
            Inventories::create([
                'code' => $newInventoryCode,
                'equipment_code' => $material['equipment_code'],
                'batch_number' => $material['batch_number'],
                'current_quantity' => $material['actual_quantity'],
                'import_code' => null,
                'import_date' => now(),
                'expiry_date' => $material['expiry_date'],
            ]);
        }
    }

    public function approveCheck($code)
    {
        // Tìm phiếu kiểm kho theo mã code
        $inventoryCheck = Inventory_checks::where('code', $code)->first();

        // Kiểm tra trạng thái phiếu kiểm kho (chỉ duyệt nếu trạng thái là 0)
        if ($inventoryCheck && $inventoryCheck->status == 0) {
            // Thay đổi trạng thái phiếu kiểm kho từ 0 sang 1 (đã duyệt)
            $inventoryCheck->status = 1;
            $inventoryCheck->save();

            // Lấy tất cả các chi tiết phiếu kiểm kho liên quan
            $inventoryCheckDetails = Inventory_check_details::where('inventory_check_code', $code)->get();

            // Cập nhật kho theo lô cho từng chi tiết phiếu kiểm kho
            foreach ($inventoryCheckDetails as $detail) {
                $material = [
                    'equipment_code' => $detail->equipment_code,
                    'batch_number' => $detail->batch_number,
                    'actual_quantity' => $detail->actual_quantity,
                    'unequal' => $detail->unequal
                ];

                // Gọi hàm cập nhật kho (hàm updateInventoryByCheck đã được tạo ở phần trước)
                $this->updateInventoryByCheck($material);
            }

            toastr()->success('Đã duyệt phiếu kiểm kho thành công với mã ' . $inventoryCheck->code);
            return redirect()->back();
        }

        toastr()->success('Phiếu kiểm kho đã được duyệt trước đó.');
        return redirect()->back();
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
}
