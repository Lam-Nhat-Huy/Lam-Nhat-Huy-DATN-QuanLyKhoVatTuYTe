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
        $createdBy = $request->input('created_by'); // Thêm tiêu chí tìm kiếm theo người tạo
        $startDate = $request->input('start_date'); // Ngày bắt đầu
        $endDate = $request->input('end_date'); // Ngày kết thúc

        // Truy vấn danh sách đơn vị
        $query = Units::query();

        if ($searchKeyword) {
            $query->where('name', 'LIKE', '%' . $searchKeyword . '%')
                ->orWhere('code', 'LIKE', '%' . $searchKeyword . '%')
                ->orWhere('description', 'LIKE', '%' . $searchKeyword . '%');
        }

        // Tìm kiếm theo người tạo
        if ($createdBy) {
            $query->where('created_by', 'LIKE', '%' . $createdBy . '%');
        }

        // Tìm kiếm theo ngày tạo
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
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

        // Trả về thông báo thành công
        toastr()->success('Đơn vị đã được thêm thành công!');

        // Chuyển hướng về trang danh sách
        return redirect()->route('units.index');
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

        // Trả về thông báo thành công
        toastr()->success('Đơn vị đã được cập nhật thành công!');

        // Chuyển hướng về trang danh sách
        return redirect()->route('units.index');
    }

    // Xóa đơn vị
    public function destroy($id)
    {
        // Tìm đơn vị theo ID
        $unit = Units::findOrFail($id);

        // Kiểm tra nếu đơn vị có liên kết với thiết bị nào
        if ($unit->equipments()->count() > 0) {
            // Nếu có liên kết, trả về thông báo lỗi
            return redirect()->route('units.index')->with('error', 'Không thể xóa đơn vị vì nó đang được liên kết với thiết bị.');
        }

        // Nếu không có liên kết, cho phép xóa đơn vị
        $unit->delete();

        // Trả về thông báo thành công
        toastr()->success('Đơn vị đã được xóa thành công!');

        return redirect()->route('units.index');
    }

    // Phương thức AJAX tìm kiếm
    public function ajaxSearch(Request $request)
    {
        $searchKeyword = $request->input('kw');
        $createdBy = $request->input('created_by');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Units::query();

        // Tìm kiếm theo từ khóa
        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('code', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchKeyword . '%');
            });
        }

        // Tìm kiếm theo người tạo
        if ($createdBy) {
            $query->where('created_by', 'LIKE', '%' . $createdBy . '%');
        }

        // Tìm kiếm theo ngày tạo
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Lấy danh sách đơn vị (không phân trang)
        $allUnits = $query->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($allUnits);
    }
}
