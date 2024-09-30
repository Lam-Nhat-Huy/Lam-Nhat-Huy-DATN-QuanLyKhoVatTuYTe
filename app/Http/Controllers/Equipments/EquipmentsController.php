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

        // Tính toán ngày hết hạn và chi tiết ngày còn lại
        foreach ($AllMaterial as $item) {
            if ($item->expiry_date) {
                $expiryDate = Carbon::parse($item->expiry_date);
                $currentDate = Carbon::now();
                $diff = $currentDate->diff($expiryDate);

                // Kiểm tra xem ngày hiện tại đã vượt qua ngày hết hạn hay chưa
                if ($currentDate->lt($expiryDate)) {
                    if ($diff->y > 0) {
                        $item->time_remaining = $diff->y . ' năm ' . $diff->m . ' tháng ' . $diff->d . ' ngày';
                    } elseif ($diff->m > 0) {
                        $item->time_remaining = $diff->m . ' tháng ' . $diff->d . ' ngày';
                    } elseif ($diff->d > 0) {
                        $item->time_remaining = $diff->d . ' ngày';
                    } else {
                        $item->time_remaining = 'Sắp hết hạn';
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
        $title = 'Thùng Rác';

        // Lấy danh sách các vật tư đã bị soft delete (bị xóa mềm)
        $AllMaterialTrash = Equipments::onlyTrashed()->get(); // Lấy các vật tư trong thùng rác

        return view("equipments.material_trash", compact('title', 'AllMaterialTrash'));
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


    public function create_material(\App\Http\Requests\CreateMaterialRequest $request)
    {
        // Dữ liệu đã được validate tự động, bạn có thể xử lý tiếp như sau

        // Xử lý upload ảnh
        $imageName = null;
        if ($request->hasFile('material_image')) {
            $imageName = time() . '.' . $request->material_image->extension();
            $request->material_image->move(public_path('images/equipments'), $imageName);
        }

        // Tạo mới một bản ghi vật tư
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

        // Chuyển hướng về trang danh sách với thông báo thành công
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

        // Thay vì xóa ảnh, chỉ cần đánh dấu thiết bị là đã xóa
        $equipment->deleted_at = now(); // Set the deleted_at timestamp
        $equipment->save(); // Save the changes

        // Xóa thiết bị khỏi cơ sở dữ liệu (chỉ đánh dấu xóa mềm)
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Thiết bị đã được xóa thành công!');
    }

    public function delete_permanently($code)
    {
        // Tìm thiết bị đã bị xóa mềm
        $equipment = Equipments::withTrashed()->where('code', $code)->firstOrFail();

        // Xóa vĩnh viễn thiết bị
        $equipment->forceDelete();

        // Xóa ảnh nếu cần thiết
        if ($equipment->image) {
            $imagePath = public_path('images/equipments/' . $equipment->image);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Xóa ảnh khỏi thư mục
            }
        }

        return redirect()->route('equipments.equipments_trash')->with('success', 'Thiết bị đã được xóa vĩnh viễn!');
    }


    public function restore_material($code)
    {
        // Tìm thiết bị đã bị xóa mềm
        $equipment = Equipments::withTrashed()->where('code', $code)->firstOrFail();

        // Khôi phục thiết bị
        $equipment->restore();

        return redirect()->route('equipments.equipments_trash')->with('success', 'Thiết bị đã được khôi phục thành công!');
    }

    public function material_group(Request $request)
    {
        $title = 'Danh Sách Nhóm Vật Tư';

        // Nhận các tham số tìm kiếm
        $searchKeyword = $request->input('kw');
        $status = $request->input('status');

        // Truy vấn cơ sở dữ liệu
        $query = Equipment_types::query();

        // Tìm kiếm theo từ khóa (mã hoặc tên)
        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('code', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('name', 'LIKE', '%' . $searchKeyword . '%');
            });
        }

        // Lọc theo trạng thái
        if ($status !== null) {
            $query->where('status', $status);
        }

        // Lấy tất cả các nhóm vật tư sau khi đã lọc
        $AllMaterialGroup = $query->get();

        return view("equipments.material_group", compact('title', 'AllMaterialGroup'));
    }


    public function material_group_trash()
    {
        $title = 'Thùng Rác';

        // Lấy các nhóm vật tư đã bị xóa mềm
        $AllMaterialGroupTrash = Equipment_types::onlyTrashed()->get(); // Eloquent Collection

        return view("equipments.material_group_trash", compact('title', 'AllMaterialGroupTrash'));
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
    public function create_material_group_modal(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|string|max:20|unique:equipment_types,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        // Tạo nhóm vật tư mới
        $materialGroup = Equipment_types::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Chuyển hướng quay lại trang trước đó và thông báo thành công
        return redirect()->back()->with('success', 'Nhóm vật tư đã được thêm thành công!');
    }
    public function create_unit_modal(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|string|max:20|unique:units,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Lấy user code từ session hoặc một nguồn khác
        $createdBy = session('user_code');  // Hoặc lấy từ user đang đăng nhập

        // Kiểm tra nếu session không tồn tại
        if (!$createdBy) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin người tạo!');
        }

        // Tạo đơn vị tính mới
        Units::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $createdBy,  // Đặt người tạo chính xác
        ]);

        // Chuyển hướng quay lại trang trước đó và thông báo thành công
        return redirect()->back()->with('success', 'Đơn vị tính đã được thêm thành công!');
    }
    public function create_supplier_modal(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|string|max:20|unique:suppliers,code',
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        // Tạo nhà cung cấp mới
        Suppliers::create([
            'code' => $request->code,
            'name' => $request->name,
            'contact_name' => $request->contact_name,
            'tax_code' => $request->tax_code,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Chuyển hướng quay lại trang trước đó và thông báo thành công
        return redirect()->back()->with('success', 'Nhà cung cấp đã được thêm thành công!');
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
        // Tìm nhóm vật tư theo 'code' và xóa mềm
        $group = Equipment_types::where('code', $code)->firstOrFail();
        $group->delete(); // Xóa mềm

        return redirect()->route('equipments.equipments_group')->with('success', 'Nhóm vật tư đã được xóa thành công!');
    }
    public function restore_material_group($code)
    {
        // Tìm nhóm vật tư đã bị xóa mềm bằng code
        $group = Equipment_types::withTrashed()->where('code', $code)->firstOrFail();

        // Khôi phục
        $group->restore();

        return redirect()->route('equipments.equipments_group_trash')->with('success', 'Nhóm vật tư đã được khôi phục thành công!');
    }

    public function delete_permanently_group($code)
    {
        // Tìm nhóm vật tư đã bị xóa mềm
        $group = Equipment_types::withTrashed()->where('code', $code)->firstOrFail();

        // Xóa vĩnh viễn
        $group->forceDelete();

        return redirect()->route('equipments.equipments_group_trash')->with('success', 'Nhóm vật tư đã được xóa vĩnh viễn!');
    }
}
