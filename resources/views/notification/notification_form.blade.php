@extends('master_layout.layout')

@section('styles')
    <style>
        .checkbox-wrapper-6 .tgl {
            display: none;
        }

        .checkbox-wrapper-6 .tgl,
        .checkbox-wrapper-6 .tgl:after,
        .checkbox-wrapper-6 .tgl:before,
        .checkbox-wrapper-6 .tgl *:after,
        .checkbox-wrapper-6 .tgl *:before,
        .checkbox-wrapper-6 .tgl+.tgl-btn {
            box-sizing: border-box;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn {
            outline: 0;
            display: block;
            width: 50px;
            height: 26px;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #ddd;
            border-radius: 26px;
            transition: background-color 0.3s;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            background: #fff;
            border-radius: 50%;
            left: 2px;
            top: 2px;
            transition: all 0.3s ease;
        }

        .checkbox-wrapper-6 .tgl-light:checked+.tgl-btn {
            background: #1fb948;
        }

        .checkbox-wrapper-6 .tgl:checked+.tgl-btn:after {
            transform: translateX(24px);
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });

        function setDeleteForm(actionUrl) {
            document.getElementById('form-3').action = actionUrl;
        }

        document.getElementById('submit_notification_type').addEventListener('click', function(event) {
            var notificationTypeName = document.getElementById('notification_type_name').value.trim();
            var existingNotificationTypes = @json($allNotificationType->pluck('name')->toArray());

            if (notificationTypeName === '') {
                event.preventDefault();
                document.getElementById('show-err-notification-type').innerText = 'Vui lòng nhập tên loại';
                document.getElementById('notification_type_name').focus();
                return;
            }

            if (existingNotificationTypes.includes(notificationTypeName)) {
                event.preventDefault();
                document.getElementById('show-err-notification-type').innerText = 'Tên loại thông báo đã tồn tại';
                document.getElementById('notification_type_name').focus();
                return;
            }

            document.getElementById('show-err-notification-type').innerText = '';
        });

        document.getElementById('form-1').addEventListener('submit', function(event) {
            submitAnimation(event);
        });

        document.getElementById('form-2').addEventListener('submit', function(event) {
            submitAnimation(event);
        });

        document.getElementById('form-3').addEventListener('submit', function(event) {
            submitAnimation(event);
        });
    </script>
@endsection

@php
    if ($action == 'create') {
        $action = route('notification.notification_create');

        $button_text = 'Thêm';

        $required = 'required';
    } else {
        $action = route('notification.notification_update', request('code'));

        $button_text = 'Cập Nhật';

        $required = '';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('notification.index') }}" class="btn btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $action }}" id="form-1" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="mb-5">

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Chọn Loại Thông Báo</label>

                        <div class="d-flex align-items-center">

                            <select name="notification_type" class="form-select form-select-sm setupSelect2">
                                <option value="0">Chọn Loại Thông Báo...</option>
                                @foreach ($allNotificationType as $item)
                                    <option value="{{ $item->id }}"
                                        {{ (!empty($firstNotification) && !empty($firstNotification->notification_type == $item->id)) || old('notification_type') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_notification_type"
                                title="Thêm Loại Thông Báo"><i
                                    class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i></span>
                        </div>

                        @error('notification_type')
                            <div class="message_error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Nội Dung Thông Báo</label>

                        <textarea name="content" id="content">
                            {{ !empty($firstNotification) && !empty($firstNotification->content) ? $firstNotification->content : old('content') }}
                        </textarea>

                        @error('content')
                            <div class="message_error">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label class="fs-5 fw-bold mb-2">Trạng Thái</label>
                        <div class="checkbox-wrapper-6">
                            <input type="hidden" name="important" value="0">
                            <input class="tgl tgl-light" id="important" type="checkbox" name="important" value="1" />
                            <label class="tgl-btn" for="important"></label>
                        </div>
                    </div>

                </div>
            </div>


            <div class="modal-footer flex-right">
                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-twitter btn-sm">
                    {{ $button_text }}
                </button>
            </div>
        </form>
    </div>

    {{-- Form thêm loại thông báo --}}
    <form action="{{ route('notification.create_notification_type') }}" id="form-2" method="POST">
        @csrf
        <div class="modal fade" id="add_modal_notification_type" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="deleteModalLabel">Thêm Loại Thông Báo</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="required fs-5 fw-bold mb-2">Tên Loại Thông
                                Báo</label>
                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Loại thông báo.." name="notification_type_name"
                                id="notification_type_name" />
                            <div class="message_error" id="show-err-notification-type"></div>
                        </div>
                    </div>

                    <div class="modal-body pt-0">
                        <div class="overflow-auto" style="max-height: 300px;">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr class="fw-bolder bg-success">
                                        <th class="ps-4" style="width: 10%;">STT</th>
                                        <th class="" style="width: 60%;">Tên loại</th>
                                        <th class="pe-3 text-center" style="width: 30%;">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allNotificationType as $key => $item)
                                        <tr class="hover-table pointer">
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal_notification_type"
                                                    onclick="setDeleteForm('{{ route('notification.delete_notification_type', $item->id) }}')">
                                                    <i class="fa fa-trash p-0"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-sm btn-twitter" id="submit_notification_type">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Tạo form riêng biệt --}}
    @foreach ($allNotificationType as $item)
        <div class="modal fade" id="delete_modal_notification_type" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="form-3" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h3 class="modal-title" id="deleteModalLabel">Xóa Loại thông báo</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <h6 class="text-danger">Bạn có chắc chắn muốn xóa loại thông báo này?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#add_modal_notification_type">Trở Lại</button>
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
