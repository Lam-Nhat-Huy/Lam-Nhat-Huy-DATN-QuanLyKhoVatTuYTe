<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected $route = 'warehouse';

    public function index()
    {
        $title = 'Xuất Kho';

        return view("{$this->route}.export", compact('title'));
    }
}
