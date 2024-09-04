<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $route = 'user';

    public function index()
    {
        $title = 'Người Dùng';

        return view("{$this->route}.index", compact('title'));
    }

    public function user_trash()
    {
        $title = 'Người Dùng';

        return view("{$this->route}.user_trash", compact('title'));
    }

    public function add()
    {
        $title = 'Người Dùng';

        $title_form = 'Thêm Người Dùng';

        $action = 'create';

        return view("{$this->route}.form", compact('title', 'title_form', 'action'));
    }

    public function create(Request $request) {}

    public function edit()
    {
        $title = 'Người Dùng';

        $title_form = 'Cập Nhật Người Dùng';

        $action = 'edit';

        return view("{$this->route}.form", compact('title', 'title_form', 'action'));
    }

    public function update(Request $request) {}
}
