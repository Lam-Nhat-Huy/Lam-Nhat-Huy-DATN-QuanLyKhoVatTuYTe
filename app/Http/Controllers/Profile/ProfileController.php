<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $route = 'profile';

    protected $callModel;

    public function __construct()
    {
        $this->callModel = new Users();
    }

    public function index()
    {
        $title = 'Hồ Sơ';

        $getUserProfile = $this->callModel::where('code', session('user_code'))
            ->first();

        return view("$this->route.profile", compact('title', 'getUserProfile'));
    }

    public function update(Request $request)
    {
        $data = [];

        if (!empty($request->input())) {

            $record = $this->callModel::where('code', session('user_code'));

            if (!empty($request->file('avatar'))) {

                $user = $record->first();

                if ($user->avatar) {

                    Storage::disk('public')->delete($user->avatar);
                }

                $data['avatar'] = $request->file('avatar')->store('uploads', 'public');

                session()->put('avatar', $data['avatar']);
            }

            $data['updated_at'] = now();

            $data['last_name'] = $request->last_name;

            $data['first_name'] = $request->first_name;

            $data['birth_day'] = $request->birth_day;

            $data['address'] = $request->address;

            session()->put('fullname', $data['last_name'] . ' ' . $data['first_name']);

            $rs = $record->update($data);

            if ($rs) {

                toastr()->success("Cập nhật thành công");

                return redirect()->back();
            }

            toastr()->error('Không thể cập nhật, thử lại sau');

            return redirect()->back();
        }
    }
}
