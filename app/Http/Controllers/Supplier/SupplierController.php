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

    public function create()
    {
        $title = 'Thêm Nhà Cung Cấp';

        $config['method'] = 'create';

        return view("{$this->route}.add_customer", compact('title','config'));
    }
    public function store(Request $request)
    {
        dd("thêm thành công");
    }
    public function edit(string $id)
    {
        $config['method'] = 'edit';

        return view("{$this->route}.add_customer", compact('title','config'));
    }
    public function update(Request $request, string $id)
    {
        
    }
    public function destroy(string $id)
    {
        
    }
}
