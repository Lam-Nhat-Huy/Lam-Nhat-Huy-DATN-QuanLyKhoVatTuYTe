<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckWarehouseController extends Controller
{
    protected $route = 'check_warehouse';

    public function index()
    {
        $title = 'Kiểm Kho';

        return view("{$this->route}.check", compact('title'));
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
