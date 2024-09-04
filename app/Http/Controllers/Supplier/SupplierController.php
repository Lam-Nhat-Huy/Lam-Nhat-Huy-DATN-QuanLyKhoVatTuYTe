<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $route = 'supplier';

    public function index()
    {
        $title = 'Nhà Cung Cấp';

        return view("{$this->route}.list", compact('title'));
    }

    public function trash()
    {
        $title = 'Nhà Cung Cấp';

        return view("{$this->route}.trash", compact('title'));
    }

    public function create()
    {
        $title = 'Thêm Nhà Cung Cấp';

        $config['method'] = 'create';

        return view("{$this->route}.form", compact('title', 'config'));
    }

    public function store(Request $request) {}

    public function edit()
    {
        $title = 'Nhà Cung Cấp';
        
        $config['method'] = 'edit';

        return view("{$this->route}.form", compact('title', 'config'));
    }

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
