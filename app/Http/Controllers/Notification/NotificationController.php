<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\CreateNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Models\Notifications;
use App\Models\Users;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $route = 'notification';

    protected $callModel;

    public function __construct()
    {
        $this->callModel = new Notifications();
    }

    public function index(Request $request)
    {
        $title = 'Thông Báo';

        $AllUser = Users::all();

        $AllNotification = $this->callModel::with('users')
            ->orderBy('created_at', 'DESC')
            ->where('lock_warehouse', 0)
            ->whereNull('deleted_at');

        if (isset($request->ur)) {
            $AllNotification = $AllNotification->where("user_code", $request->ur);
        }

        if (isset($request->kw)) {
            $AllNotification = $AllNotification->where(function ($query) use ($request) {
                $query->where('content', 'like', '%' . $request->kw . '%')
                    ->orWhere('code', 'like', '%' . $request->kw . '%');
            });
        }

        $AllNotification = $AllNotification->paginate(10);

        if (isset($request->notification_codes)) {

            if ($request->action_type === 'delete') {

                $this->callModel::whereIn('code', $request->notification_codes)->delete();

                toastr()->success('Xóa thành công');

                return redirect()->back();
            }
        }

        if (!empty($request->delete_notification)) {

            $this->callModel::where('code', $request->delete_notification)->delete();

            toastr()->success('Đã xóa');

            return redirect()->route('notification.index');
        }

        return view("{$this->route}.notification", compact('title', 'AllNotification', 'AllUser'));
    }

    public function notification_trash(Request $request)
    {
        $title = 'Thông Báo';

        $AllNotificationTrash = $this->callModel::with(['users'])
            ->orderBy('deleted_at', 'DESC')
            ->onlyTrashed()
            ->paginate(10);

        if (isset($request->notification_codes)) {

            if ($request->action_type === 'restore') {

                $this->callModel::whereIn('code', $request->notification_codes)->restore();

                toastr()->success('Khôi phục thành công');

                return redirect()->back();
            } elseif ($request->action_type === 'delete') {

                $this->callModel::onlyTrashed()->whereIn('code', $request->notification_codes)->forceDelete();

                toastr()->success('Xóa thành công');

                return redirect()->back();
            }
        }

        if (isset($request->restore_notification)) {

            $this->callModel::where('code', $request->restore_notification)->restore();

            toastr()->success('Khôi phục thành công');

            return redirect()->back();
        }

        if (isset($request->delete_notification)) {

            $notification = $this->callModel::onlyTrashed()->where('code', $request->delete_notification)->forceDelete();

            toastr()->success('Xóa vĩnh viễn thành công');

            return redirect()->back();
        }

        return view("{$this->route}.notification_trash", compact('title', 'AllNotificationTrash'));
    }

    public function notification_add()
    {
        $title = 'Thông Báo';

        $title_form = 'Thêm Thông Báo';

        $action = 'create';

        return view("{$this->route}.notification_form", compact('title', 'action', 'title_form'));
    }

    public function notification_create(CreateNotificationRequest $request)
    {
        $data = $request->validated();

        if ($data) {
            $data['code'] = 'TB' . $this->generateRandomString(8);

            $data['user_code'] = session('user_code');

            $data['created_at'] = now();

            $data['updated_at'] = null;

            $this->callModel::create($data);

            toastr()->success('Đã thêm thông báo');

            return redirect()->route('notification.index');
        }
    }

    public function notification_update(UpdateNotificationRequest $request, $code)
    {
        $data = $request->validated();
        if ($data) {
            $data['updated_at'] = now();

            $rs = $this->callModel::where('code', $code)->update($data);

            if ($rs) {
                toastr()->success('Đã cập nhật thông báo');
                return redirect()->route('notification.index');
            }

            toastr()->error('Không thể cập nhật, thử lại sau');
            return redirect()->route('notification.index');
        }
    }

    public function notification_edit($code)
    {
        $title = 'Thông Báo';

        $title_form = 'Cập Nhật Thông Báo';

        $action = 'edit';

        $firstNotification = $this->callModel::where('code', $code)->first();

        return view("{$this->route}.notification_form", compact('title', 'action', 'title_form', 'firstNotification'));
    }

    function generateRandomString($length = 9)
    {
        $characters = '0123456789';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function getNewNotificationCount()
    {
        $user_code = session('user_code');

        // Đếm số lượng thông báo mới (chưa đọc bởi người dùng hiện tại)
        $count = $this->callModel::where('lock_warehouse', 0)
            ->where(function ($query) use ($user_code) {
                $query->whereNull('is_read') // Trường hợp chưa có ai đọc
                    ->orWhereJsonDoesntContain('is_read', $user_code); // Không chứa user_code trong JSON
            })
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markNotificationsAsRead()
    {
        $user_code = session('user_code');

        $notifications = $this->callModel::where('lock_warehouse', 0)
            ->where(function ($query) use ($user_code) {
                $query->whereNull('is_read') // Trường hợp chưa có ai đọc
                    ->orWhereJsonDoesntContain('is_read', $user_code); // Không chứa user_code trong JSON
            })
            ->get();

        foreach ($notifications as $notification) {
            $currentIsRead = json_decode($notification->is_read, true) ?? []; // Giải mã JSON hoặc khởi tạo mảng

            // Nếu mã người dùng chưa có trong danh sách, thêm vào
            if (!in_array($user_code, $currentIsRead)) {
                $currentIsRead[] = $user_code; // Thêm mã người dùng
            }

            // Cập nhật lại cột 'is_read' với mảng mới
            $notification->is_read = json_encode($currentIsRead);
            $notification->save();
        }

        return response()->json(['success' => true]);
    }
}
