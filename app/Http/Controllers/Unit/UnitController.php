<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Units;

class UnitController extends Controller
{
    // Hiển thị danh sách đơn vị
    public function index(Request $request)
    {
        $title = 'Danh Sách Đơn Vị';

        // Lấy các tiêu chí lọc (nếu có)
        $searchKeyword = $request->input('kw');

        // Truy vấn danh sách đơn vị
        $query = Units::query();

        if ($searchKeyword) {
            $query->where('name', 'LIKE', '%' . $searchKeyword . '%')
                  ->orWhere('code', 'LIKE', '%' . $searchKeyword . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchKeyword . '%');
        }

        $allUnits = $query->paginate(10); // Phân trang với 10 đơn vị mỗi trang

        return view('units.index', compact('title', 'allUnits'));
    }

    // Hiển thị form thêm mới đơn vị
    public function create()
    {
        $title = 'Thêm Đơn Vị';
        $action = 'create'; // Define action as create
        return view('units.form', compact('title', 'action'));
    }


    // Xử lý thêm mới đơn vị
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'code' => 'required|string|max:20|unique:units,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'Mã đơn vị là bắt buộc.',
            'code.unique' => 'Mã đơn vị đã tồn tại.',
            'name.required' => 'Tên đơn vị là bắt buộc.',
        ]);

        // Thêm tiền tố "UNIT" vào trước mã đơn vị nếu chưa có
        $code = $request->code;
        if (!str_starts_with($code, 'UNIT')) {
            $code = 'UNIT' . $code;
        }

        // Lấy giá trị 'user_code' từ session
        $createdBy = session('user_code');

        // Tạo đơn vị mới với mã đã được thêm tiền tố và giá trị 'created_by' từ session 'user_code'
        Units::create([
            'code' => $code,
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $createdBy, // Lấy từ session user_code
        ]);

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('units.index')->with('success', 'Đơn vị đã được thêm thành công!');
    }



    // Hiển thị form chỉnh sửa đơn vị
    public function edit($id)
    {
        $title = 'Chỉnh Sửa Đơn Vị';
        $unit = Units::findOrFail($id);
        $action = 'edit'; // Define action as edit
        return view('units.form', compact('title', 'unit', 'action'));
    }


    // Xử lý cập nhật đơn vị
    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Tên đơn vị là bắt buộc.',
        ]);

        // Tìm đơn vị và cập nhật thông tin
        $unit = Units::findOrFail($id);

        // Thêm tiền tố "UNIT" vào trước mã đơn vị nếu chưa có (nếu cần thiết khi chỉnh sửa)
        $code = $unit->code;
        if (!str_starts_with($code, 'UNIT')) {
            $code = 'UNIT' . $code;
        }

        $unit->update([
            'name' => $request->name,
            'description' => $request->description,
            'code' => $code, // Cập nhật mã với tiền tố "UNIT"
        ]);

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('units.index')->with('success', 'Đơn vị đã được cập nhật thành công!');
    }


    // Xóa đơn vị
    public function destroy($id)
    {
        $unit = Units::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Đơn vị đã được xóa thành công!');
    }
}
