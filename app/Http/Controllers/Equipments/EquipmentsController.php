<?php

namespace App\Http\Controllers\Equipments;

use App\Http\Controllers\Controller;
use App\Models\Equipment_types;
use App\Models\Equipments;
use App\Models\Suppliers;
use App\Models\Units;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipmentsController extends Controller
{
    protected $route = 'equipments';

    public function index(Request $request)
    {
        $title = 'Danh Sách Vật Tư';

        $searchKeyword = $request->input('kw');
        $equipmentType = $request->input('equipment_type_code');
        $unit = $request->input('unit_code');

        $query = Equipments::with(['supplier', 'units', 'equipmentType', 'inventories']);

        if ($searchKeyword) {
            $query->where('name', 'LIKE', '%' . $searchKeyword . '%')
                ->orWhere('code', 'LIKE', '%' . $searchKeyword . '%')
                ->orWhere('description', 'LIKE', '%' . $searchKeyword . '%');
        }

        if ($equipmentType) {
            $query->where('equipment_type_code', $equipmentType);
        }

        if ($unit) {
            $query->where('unit_code', $unit);
        }

        $AllMaterial = $query->get();

        foreach ($AllMaterial as $item) {
            if ($item->expiry_date) {
                $expiryDate = Carbon::parse($item->expiry_date);
                $currentDate = Carbon::now();
                $diff = $currentDate->diff($expiryDate);

                if ($currentDate->lt($expiryDate)) {
                    if ($diff->m > 0 && $diff->d > 0) {
                        $item->time_remaining = $diff->m . ' tháng ' . $diff->d . ' ngày';
                    } elseif ($diff->m > 0) {
                        $item->time_remaining = $diff->m . ' tháng';
                    } elseif ($diff->d > 0) {
                        $item->time_remaining = $diff->d . ' ngày';
                    }
                } else {
                    $item->time_remaining = 'Đã hết hạn';
                }
            } else {
                $item->time_remaining = 'Không Có';
            }
        }

        // Lấy danh sách các nhóm vật tư và đơn vị tính để đưa vào bộ lọc
        $equipmentTypes = Equipment_types::all();
        $units = Units::all();

        return view("equipments.list", compact('title', 'AllMaterial', 'equipmentTypes', 'units'));
    }


    public function material_trash()
    {
        $title = 'Vật Tư';

        $AllMaterialTrash = [
            [
                'id' => 1,
                'material_code' => 'VT001',
                'material_image' => 'https://shopmebauembe.com/wp-content/uploads/2022/07/thucphamsachonline-gon-vien-bach-tuyet-1.jpg',
                'material_name' => 'Bông y tế',
                'material_type_id' => 'Vật tư tiêu hao',
                'unit_id' => 'Gói',
                'description' => 'Dùng lau rửa vết thương, thấm máu và thấm dịch vùng phẫu thuật',
                'expiry' => 24,
            ],
            [
                'id' => 2,
                'material_code' => 'VT002',
                'material_image' => 'https://duocphamotc.com/wp-content/uploads/2021/09/su-dung-may-do-duong-huyet.jpg',
                'material_name' => 'Máy đo đường huyết',
                'material_type_id' => 'Thiết bị y tế nhỏ',
                'unit_id' => 'Cái',
                'description' => 'Dùng để đo lường lượng glucose trong máu, giúp bệnh nhân tiểu đường kiểm soát lượng đường huyết của họ',
                'expiry' => 0,
            ],
        ];

        return view("{$this->route}.material_trash", compact('title', 'AllMaterialTrash'));
    }



    public function insert_material()
    {
        $title = 'Vật Tư';
        $title_form = 'Thêm Vật Tư';
        $action = 'create';

        // Lấy danh sách các nhóm vật tư có trạng thái "Có"
        $equipmentTypes = Equipment_types::where('status', 1)->get();

        // Tương tự với các đơn vị tính hoặc nhà cung cấp nếu cần thiết
        $units = Units::all();
        $suppliers = Suppliers::all();
        return view('equipments.form_material', compact('title', 'action', 'title_form', 'equipmentTypes', 'suppliers', 'units'));
    }


    public function create_material(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'material_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'equipment_type_code' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'expiry_date' => 'nullable|date', // Validate ngày hết hạn
            'supplier_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Xử lý upload ảnh
        $imageName = null;
        if ($request->hasFile('material_image')) {
            $imageName = time() . '.' . $request->material_image->extension();
            $request->material_image->move(public_path('images/equipments'), $imageName);
        }

        // Tạo mới một bản ghi thiết bị
        Equipments::create([
            'code' => 'EQ' . time(),
            'name' => $request->name,
            'barcode' => '123456',
            'description' => $request->description,
            'price' => $request->price,
            'country' => $request->country,
            'equipment_type_code' => $request->equipment_type_code,
            'supplier_code' => $request->supplier_code,
            'unit_code' => $request->unit_code,
            'image' => $imageName,
            'expiry_date' => $request->expiry_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Chuyển hướng về trang danh sách
        return redirect()->route('equipments.index')->with('success', 'Thiết bị đã được thêm thành công!');
    }


    public function update_material($code)
    {
        $title = 'Cập Nhật Vật Tư';
        $title_form = 'Cập Nhật Vật Tư';
        $action = 'edit';

        // Tìm vật tư bằng code thay vì id
        $currentEquipment = Equipments::where('code', $code)->firstOrFail();
        $equipmentTypes = Equipment_types::all();
        $suppliers = Suppliers::all();
        $units = Units::all();

        return view("equipments.form_material", compact('title', 'action', 'title_form', 'currentEquipment', 'equipmentTypes', 'suppliers', 'units'));
    }

    public function edit_material(Request $request, $code)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'material_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'equipment_type_code' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'expiry_date' => 'nullable|date',
            'supplier_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Tìm thiết bị theo code
        $equipment = Equipments::where('code', $code)->firstOrFail();

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('material_image')) {
            // Xóa ảnh cũ nếu có
            if ($equipment->image) {
                $oldImagePath = public_path('images/equipments/' . $equipment->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload ảnh mới
            $imageName = time() . '.' . $request->material_image->extension();
            $request->material_image->move(public_path('images/equipments'), $imageName);
            $equipment->image = $imageName;
        }

        // Cập nhật thông tin thiết bị
        $equipment->update([
            'name' => $request->name,
            'equipment_type_code' => $request->equipment_type_code,
            'unit_code' => $request->unit_code,
            'price' => $request->price,
            'expiry_date' => $request->expiry_date,
            'supplier_code' => $request->supplier_code,
            'country' => $request->country,
            'description' => $request->description,
            'updated_at' => now(),
        ]);

        return redirect()->route('equipments.index')->with('success', 'Thiết bị đã được cập nhật thành công!');
    }
    public function delete_material($code)
    {
        // Tìm thiết bị theo code
        $equipment = Equipments::where('code', $code)->firstOrFail();

        // Xóa ảnh nếu có
        if ($equipment->image) {
            $imagePath = public_path('images/equipments/' . $equipment->image);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Xóa ảnh khỏi thư mục
            }
        }

        // Xóa thiết bị khỏi cơ sở dữ liệu
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Thiết bị đã được xóa thành công!');
    }


    public function material_group()
    {
        $title = 'Nhóm Vật Tư';

        // Lấy danh sách tất cả các nhóm vật tư từ cơ sở dữ liệu
        $AllMaterialGroup = Equipment_types::all();

        // Trả về view với dữ liệu từ cơ sở dữ liệu
        return view("{$this->route}.material_group", compact('title', 'AllMaterialGroup'));
    }

    public function material_group_trash()
    {
        $title = 'Nhóm Vật Tư';

        $AllMaterialGroupTrash = [
            [
                'id' => 1,
                'material_type_code' => 'VT001',
                'material_type_name' => 'Vật tư tiêu hao',
                'description' => 'ABCDEF',
                'status' => 2,
            ],
            [
                'id' => 2,
                'material_type_code' => 'VT002',
                'material_type_name' => 'Thiết bị y tế nhỏ',
                'description' => '123456',
                'status' => 1,
            ],
        ];

        return view("{$this->route}.material_group_trash", compact('title', 'AllMaterialGroupTrash'));
    }
    public function showCreateForm()
    {
        $title = 'Thêm Nhóm Vật Tư';
        $action = 'create'; // Hành động tạo mới
        return view('equipments.form_group', compact('title', 'action'));
    }
    public function create_material_group(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|string|max:20|unique:equipment_types,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean', // Xử lý giá trị nullable cho status
        ]);

        // Chuyển đổi giá trị 'status' từ form sang boolean
        $status = $request->input('status', 0); // Lấy giá trị mặc định là 0 nếu không có

        // Tạo nhóm vật tư mới
        Equipment_types::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $status,
        ]);

        return redirect()->route('equipments.equipments_group')->with('success', 'Nhóm vật tư đã được tạo thành công!');
    }


    public function update_material_group($code)
    {
        $title = 'Chỉnh Sửa Nhóm Vật Tư';
        $materialGroup = Equipment_types::where('code', $code)->firstOrFail();
        $action = 'edit'; // Hành động chỉnh sửa
        return view('equipments.form_group', compact('title', 'action', 'materialGroup'));
    }


    public function edit_material_group(Request $request, $code)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        // Tìm nhóm vật tư theo 'code' và cập nhật thông tin
        $group = Equipment_types::where('code', $code)->firstOrFail();

        $status = $request->input('status', 0); // Lấy giá trị status hoặc 0 nếu không có

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $status,
        ]);

        return redirect()->route('equipments.equipments_group')->with('success', 'Nhóm vật tư đã được cập nhật thành công!');
    }


    public function delete_material_group($code)
    {
        // Tìm nhóm vật tư theo 'code' và xóa
        $group = Equipment_types::where('code', $code)->firstOrFail();
        $group->delete(); // Nếu có SoftDeletes thì đây sẽ là xóa mềm, nếu không thì xóa hoàn toàn

        return redirect()->route('equipments.equipments_group')->with('success', 'Nhóm vật tư đã được xóa thành công!');
    }
}
