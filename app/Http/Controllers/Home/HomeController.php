<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $route = 'home';

    public function index()
    {
        return view("$this->route");
    }
}
