<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $route = 'notification';

    public function index()
    {
        $title = 'Thông Báo';

        $AllNotification = [
            [
                'id' => 1,
                'notification_code' => 'HD001',
                'user_create' => 'Lữ Phát Huy - KT - BS231',
                'content' => 'ABCB UGU ISIFD',
                'date_of_entry' => '30/08/2024',
                'status' => 1
            ],
            [
                'id' => 2,
                'notification_code' => 'HD002',
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'content' => 'AB123CB U23GU ISI123FD',
                'date_of_entry' => '10/09/2024',
                'status' => 2
            ],
        ];

        return view("{$this->route}.notification", compact('title', 'AllNotification'));
    }

    public function notification_trash()
    {
        $title = 'Thông Báo';

        $AllNotificationTrash = [
            [
                'id' => 1,
                'notification_code' => 'HD001',
                'user_create' => 'Lữ Phát Huy - KT - BS231',
                'content' => 'ABCB UGU ISIFD',
                'date_of_entry' => '30/08/2024',
            ],
            [
                'id' => 2,
                'notification_code' => 'HD002',
                'user_create' => 'Lữ Phát Huy - KT - BS2334',
                'content' => 'AB123CB U23GU ISI123FD',
                'date_of_entry' => '10/09/2024',
            ],
        ];

        return view("{$this->route}.notification_trash", compact('title', 'AllNotificationTrash'));
    }

    public function notification_add()
    {
        $title = 'Thông Báo';

        $title_form = 'Thêm Thông Báo';

        $action = 'create';

        return view("{$this->route}.notification_form", compact('title', 'action', 'title_form'));
    }

    public function notification_create() {}

    public function notification_edit()
    {
        $title = 'Thông Báo';

        $title_form = 'Cập Nhật Thông Báo';

        $action = 'edit';

        return view("{$this->route}.notification_form", compact('title', 'action', 'title_form'));
    }

    public function notification_update() {}

    public function notification_type()
    {
        $title = 'Loại Thông Báo';

        $AllNotificationType = [
            [
                'id' => 1,
                'notification_type_code' => 'HD001',
                'notification_type_name' => 'Thông báo về mức tồn kho',
                'status' => 1
            ],
            [
                'id' => 2,
                'notification_type_code' => 'HD002',
                'notification_type_name' => 'Thông báo về hạn sử dụng',
                'status' => 2
            ],
            [
                'id' => 3,
                'notification_type_code' => 'HD003',
                'notification_type_name' => 'Thông báo về đơn đặt hàng',
                'status' => 2
            ],
        ];

        return view("{$this->route}.notification_type", compact('title', 'AllNotificationType'));
    }

    public function notification_type_trash()
    {
        $title = 'Loại Thông Báo';

        $AllNotificationTypeTrash = [
            [
                'id' => 1,
                'notification_type_code' => 'HD001',
                'notification_type_name' => 'ABCB UGU ISIFD',
            ],
            [
                'id' => 2,
                'notification_type_code' => 'HD002',
                'notification_type_name' => 'AB123CB U23GU ISI123FD',
            ],
        ];

        return view("{$this->route}.notification_type_trash", compact('title', 'AllNotificationTypeTrash'));
    }

    public function notification_type_create() {}

    public function notification_type_edit()
    {
        $title = 'Loại Thông Báo';

        $title_form = 'Cập Nhật Loại Thông Báo';

        return view("{$this->route}.notification_type_form", compact('title', 'title_form'));
    }

    public function notification_type_update() {}
}
