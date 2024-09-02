<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $route = 'chat';

    public function index()
    {
        $title = 'Nhắn Tin';

        return view("{$this->route}.list", compact('title'));
    }

    public function contact()
    {
        $title = 'Danh Bạ';

        return view("{$this->route}.contact", compact('title'));
    }
}
