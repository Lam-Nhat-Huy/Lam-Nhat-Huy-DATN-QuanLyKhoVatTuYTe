<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardWarehouseController extends Controller
{
    protected $route = 'warehouse';

    public function index()
    {
        $title = "Thẻ kho";
        $results = collect(); // Khởi tạo một Collection rỗng

        return view("{$this->route}.card_warehouse.card", compact('title', 'results'));
    }
}
