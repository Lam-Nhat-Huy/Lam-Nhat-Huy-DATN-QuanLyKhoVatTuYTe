<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $route = 'report';

    public function index(Request $request)
    {
        $title = 'Báo Cáo';

        $AllReport = [
            [
                'id' => 1,
                'code' => '341GD',
                'user_create' => 'HIHI - KT - BS123',
                'content' => 'Nội Dung..',
                'report_type_id' => 'HDNK',
                'file' => 'abc.com',
                'status' => 1,
            ],
            [
                'id' => 2,
                'code' => '341GD',
                'user_create' => 'HIHI - KT - BS123',
                'content' => 'Nội Dung..',
                'report_type_id' => 'HDNK',
                'file' => 'abc.com',
                'status' => 2,
            ],
            [
                'id' => 3,
                'code' => '341GD',
                'user_create' => 'HIHI - KT - BS123',
                'content' => 'Nội Dung..',
                'report_type_id' => 'HDNK',
                'file' => 'abc.com',
                'status' => 2,
            ],
        ];

        $AllReportType = [
            [
                'id' => 1,
                'name' => 'Type 1',
            ],
            [
                'id' => 2,
                'name' => 'Type 2',
            ],
        ];

        return view("admin.{$this->route}.index", compact('title', 'AllReportType', 'AllReport'));
    }

    public function report_trash()
    {

        $title = 'Báo Cáo';

        $AllReportTrash = [
            [
                'id' => 1,
                'code' => '341GD',
                'user_create' => 'HIHI - KT - BS123',
                'content' => 'Nội Dung..',
                'report_type_id' => 'HDNK',
                'file' => 'abc.com',
                'status' => 1,
            ],
            [
                'id' => 2,
                'code' => '341GD',
                'user_create' => 'HIHI - KT - BS123',
                'content' => 'Nội Dung..',
                'report_type_id' => 'HDNK',
                'file' => 'abc.com',
                'status' => 2,
            ],
            [
                'id' => 3,
                'code' => '341GD',
                'user_create' => 'HIHI - KT - BS123',
                'content' => 'Nội Dung..',
                'report_type_id' => 'HDNK',
                'file' => 'abc.com',
                'status' => 2,
            ],
        ];

        return view("admin.{$this->route}.trash", compact('title', 'AllReportTrash'));
    }

    public function insert_report()
    {
        $title = 'Báo Cáo';

        $title_form = 'Tạo Báo Cáo';

        $action = 'create';

        $AllReportType = [
            [
                'id' => 1,
                'name' => 'Type 1',
            ],
            [
                'id' => 2,
                'name' => 'Type 2',
            ],
        ];

        return view("admin.{$this->route}.form", compact('title', 'title_form', 'action', 'AllReportType'));
    }

    public function create() {}

    public function update_report()
    {
        $title = 'Báo Cáo';

        $title_form = 'Cập Nhật Báo Cáo';

        $action = 'update';

        $AllReportType = [
            [
                'id' => 1,
                'name' => 'Type 1',
            ],
            [
                'id' => 2,
                'name' => 'Type 2',
            ],
        ];

        $FirstReport = [
            'id' => 1,
            'report_code' => 'RP01',
            'user_create' => 'Lữ Phát Huy - BS849',
            'content' => 'Content',
            'report_type_id' => 2,
        ];

        return view("admin.{$this->route}.form", compact('title', 'title_form', 'action', 'AllReportType', 'FirstReport'));
    }

    public function edit() {}
}
