<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $route = 'inventory';

    public function index()
    {
        $title = 'Tồn Kho';

        return view("{$this->route}.inventory", compact('title'));
    }
}
