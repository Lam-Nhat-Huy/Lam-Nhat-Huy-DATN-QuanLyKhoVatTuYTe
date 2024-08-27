<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected $route = 'warehouse';

    public function import()
    {
        $title = 'Nhập Kho';

        return view("{$this->route}.import", compact('title'));
    }

    public function export()
    {
        $title = 'Xuất Kho';

        return view("{$this->route}.export", compact('title'));
    }
}
