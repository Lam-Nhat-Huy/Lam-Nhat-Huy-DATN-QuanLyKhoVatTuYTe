<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $route = 'profile';

    public function index()
    {
        $title = 'Hồ Sơ';
        
        return view("$this->route.profile", compact('title'));
    }
}
