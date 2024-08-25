<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected $route = 'warehouse';

    public function index()
    {
        $title = 'Nhập Kho';

        return view("{$this->route}.import", compact('title'));
    }
}
