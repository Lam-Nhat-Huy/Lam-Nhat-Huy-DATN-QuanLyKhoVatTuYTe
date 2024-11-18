<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\CreateReportRequest;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Models\Reports;
use App\Models\Users;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $route = 'report';

    protected $callModel;

    public function __construct()
    {
        $this->callModel = new Reports();
    }

    public function index(Request $request)
    {
        $title = 'Báo Cáo';

        $AllUser = Users::all();

        $AllReport = $this->callModel::with('users')
            ->orderBy('created_at', 'DESC')
            ->where('deleted_at', null);

        if (isset($request->ur)) {
            $AllReport = $AllReport->where("user_code", $request->ur);
        }

        if (isset($request->st)) {
            $AllReport = $AllReport->where("status", $request->st);
        }

        if (isset($request->kw)) {
            $AllReport = $AllReport->where(function ($query) use ($request) {
                $query->where('content', 'like', '%' . $request->kw . '%')
                    ->orWhere('code', 'like', '%' . $request->kw . '%')
                    ->orWhere('report_type', 'like', '%' . $request->kw . '%');
            });
        }

        $AllReport = $AllReport->paginate(10);

        if (isset($request->report_codes)) {

            if ($request->action_type === 'browse') {

                $this->callModel::whereIn('code', $request->report_codes)->update(['status' => 1]);

                toastr()->success('Duyệt thành công');

                return redirect()->back();
            } elseif ($request->action_type === 'delete') {

                $this->callModel::whereIn('code', $request->report_codes)->delete();

                toastr()->success('Xóa thành công');

                return redirect()->back();
            }
        }

        if (!empty($request->browse_report)) {

            $this->callModel::where('code', $request->browse_report)->update(['status' => 1]);

            toastr()->success('Đã duyệt');

            return redirect()->route('report.index');
        }

        if (!empty($request->delete_report)) {

            $this->callModel::where('code', $request->delete_report)->delete();

            toastr()->success('Đã xóa');

            return redirect()->route('report.index');
        }

        return view("admin.{$this->route}.index", compact('title', 'AllReport', 'AllUser'));
    }

    public function report_trash(Request $request)
    {
        $title = 'Báo Cáo';

        // Lấy các báo cáo đã xóa mềm
        $AllReportTrash = $this->callModel::with('users')
            ->orderBy('deleted_at', 'DESC')
            ->onlyTrashed()
            ->paginate(10);

        // Xử lý các thao tác với báo cáo
        if (isset($request->report_codes)) {
            if ($request->action_type === 'restore') {
                // Khôi phục các báo cáo
                $this->callModel::whereIn('code', $request->report_codes)->restore();

                toastr()->success('Khôi phục thành công');
                return redirect()->back();
            } elseif ($request->action_type === 'delete') {
                // Xóa vĩnh viễn các báo cáo và file liên quan
                $reports = $this->callModel::onlyTrashed()->whereIn('code', $request->report_codes)->get();

                foreach ($reports as $report) {
                    // Xóa file báo cáo khỏi thư mục
                    Storage::disk('public')->delete('reports/' . $report->file);

                    // Xóa báo cáo vĩnh viễn
                    $report->forceDelete();
                }

                toastr()->success('Xóa thành công');
                return redirect()->back();
            }
        }

        // Xử lý khôi phục báo cáo theo mã
        if (isset($request->restore_report)) {
            $this->callModel::where('code', $request->restore_report)->restore();

            toastr()->success('Khôi phục thành công');
            return redirect()->back();
        }

        // Xử lý xóa vĩnh viễn báo cáo theo mã
        if (isset($request->delete_report)) {
            $report = $this->callModel::onlyTrashed()->where('code', $request->delete_report)->first();

            // Xóa file báo cáo khỏi thư mục
            Storage::disk('public')->delete('reports/' . $report->file);

            // Xóa báo cáo vĩnh viễn
            $report->forceDelete();

            toastr()->success('Xóa vĩnh viễn thành công');
            return redirect()->back();
        }

        // Trả về view danh sách báo cáo đã xóa
        return view("admin.{$this->route}.trash", compact('title', 'AllReportTrash'));
    }


    public function insert_report()
    {
        $title = 'Báo Cáo';

        $title_form = 'Tạo Báo Cáo';

        $action = 'create';

        return view("admin.{$this->route}.form", compact('title', 'title_form', 'action'));
    }

    public function create(CreateReportRequest $request)
    {
        // Lấy dữ liệu đã được xác thực từ request
        $data = $request->validated();

        if ($data) {
            // Đặt tên file với timestamp và tên gốc của file để đảm bảo tính duy nhất
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Lưu file vào thư mục public/storage/reports
            $filePath = 'storage/reports/' . $fileName;
            $file->move(public_path('storage/reports'), $fileName);

            // Cập nhật đường dẫn file vào dữ liệu báo cáo
            $data['file'] = $filePath;

            // Gán loại báo cáo và các thông tin bổ sung
            $data['report_type'] = $request->report_type;
            $data['code'] = 'RP' . $this->generateRandomString(8); // Tạo mã báo cáo ngẫu nhiên
            $data['user_code'] = session('user_code');
            $data['created_at'] = now();
            $data['updated_at'] = null;

            // Tạo mới báo cáo trong cơ sở dữ liệu
            $this->callModel::create($data);
        }

        toastr()->success('Đã thêm báo cáo');

        return redirect()->route('report.index');
    }



    public function update_report($code)
    {
        $title = 'Báo Cáo';

        $title_form = 'Cập Nhật Báo Cáo';

        $action = 'update';

        $FirstReport = $this->callModel::where('code', $code)->first();

        return view("admin.{$this->route}.form", compact('title', 'title_form', 'action', 'FirstReport'));
    }

    public function edit(UpdateReportRequest $request, $code)
    {
        // Lấy dữ liệu đã được xác thực từ request
        $data = $request->validated();

        // Tìm báo cáo theo mã code
        $record = $this->callModel::where('code', $code)->first();

        if ($record) {
            // Kiểm tra nếu có file mới được tải lên
            if ($request->hasFile('file')) {
                // Xóa file cũ nếu tồn tại
                if ($record->file) {
                    $oldFilePath = public_path($record->file);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Lưu file mới vào thư mục public/storage/reports
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'storage/reports/' . $fileName;
                $file->move(public_path('storage/reports'), $fileName);

                // Cập nhật đường dẫn file vào dữ liệu
                $data['file'] = $filePath;
            } else {
                // Nếu không có file mới, giữ nguyên file cũ
                unset($data['file']);
            }

            // Cập nhật loại báo cáo và thời gian cập nhật
            $data['report_type'] = $request->report_type;
            $data['updated_at'] = now();

            // Cập nhật dữ liệu báo cáo trong cơ sở dữ liệu
            $record->update($data);

            // Hiển thị thông báo thành công
            toastr()->success('Đã cập nhật báo cáo');
            return redirect()->route('report.index');
        }

        // Nếu không tìm thấy báo cáo, hiển thị thông báo lỗi
        toastr()->error('Không thể cập nhật, thử lại sau');
        return redirect()->route('report.index');
    }



    function generateRandomString($length = 9)
    {
        $characters = '0123456789';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}