<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $route = 'report';

    public function index()
    {
        $title = 'Báo Cáo';

        return view("admin.{$this->route}.index", compact('title'));
    }
}
