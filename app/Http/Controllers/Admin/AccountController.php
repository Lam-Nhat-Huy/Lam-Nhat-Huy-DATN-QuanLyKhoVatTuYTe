<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $route = 'account';

    public function index(){

    }

    public function forgot(){
        $title = 'Quên mật khẩu';

        return view("{$this->route}.forgot", compact('title'));
    }
}
