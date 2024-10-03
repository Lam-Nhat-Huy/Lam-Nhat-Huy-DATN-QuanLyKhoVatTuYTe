<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\LoginRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    protected $route = 'home';

    public function index()
    {
        return view("$this->route");
    }

    public function handleLogin(LoginRequest $request)
    {
        $request->validated();

        $userFind = Users::where('phone', $request->phone)
            ->where('status', 1)
            ->first();

        if ($userFind && Hash::check($request->password, $userFind->password)) {

            session()->put('user_code', $userFind->code);

            session()->put('fullname', $userFind->last_name . ' ' . $userFind->first_name);

            session()->put('email', $userFind->email);

            session()->put('avatar', $userFind->avatar);

            session()->put('address', $userFind->address);

            session()->put('dob', $userFind->birth_day);

            session()->put('isAdmin', $userFind->isAdmin);

            return redirect()->route('system.index');
        } else {

            toastr()->error('Tài Khoản Không Tồn Tại Hoặc Bị Khóa');

            return back();
        }
    }

    public function logout()
    {
        session()->forget(['user_code', 'isAdmin']);

        toastr()->success('Đăng Xuất Thành Công');

        return redirect()->route('home');
    }
}
