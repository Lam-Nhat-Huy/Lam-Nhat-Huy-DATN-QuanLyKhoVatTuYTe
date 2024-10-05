@extends('master_layout.layout')

@section('styles')
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

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            document.getElementById('show-err-notification-type').innerText = '';

            const form = this.closest('form');

            form.submit();
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
                <a href="{{ route('notification.index') }}" class="btn rounded-pill btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="mb-5">

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Chọn Loại Thông Báo</label>

                        <div class="d-flex align-items-center">

                            <select name="notification_type" class="form-select form-select-sm rounded-pill setupSelect2">
                                <option value="0">Chọn Loại Thông Báo...</option>
                                @foreach ($allNotificationType as $item)
                                    <option value="{{ $item->id }}"
                                        {{ (!empty($firstNotification) && !empty($firstNotification->notification_type == $item->id)) || old('notification_type') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_notification_type"
                                title="Thêm Nhà Cung Cấp">
                                <i class="fa fa-plus bg-primary rounded-circle p-2 text-white"
                                    style="width: 25px; height: 25px;"></i>
                            </span>
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

                    <div class="action d-flex">
                        <div class="form-group me-20">
                            <label class="fs-5 fw-bold mb-2">Thông Báo Quan Trọng</label>
                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cb1-6" type="checkbox" value="1" name="important"
                                    {{ (isset($firstNotification) && $firstNotification->important == 1) || old('important') == 1 ? 'checked' : '' }} />
                                <label class="tgl-btn" for="cb1-6"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="fs-5 fw-bold mb-2">Trạng thái</label>
                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cb1-7" type="checkbox" value="1" name="status"
                                    {{ (isset($firstNotification) && $firstNotification->status == 1) || old('status') == 1 ? 'checked' : '' }} />
                                <label class="tgl-btn" for="cb1-7"></label>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


            <div class="modal-footer flex-right">
                <button type="submit" class="btn rounded-pill btn-twitter btn-sm load_animation">
                    {{ $button_text }}
                </button>
            </div>
        </form>
    </div>

    {{-- Form thêm loại thông báo --}}
    <form action="{{ route('notification.create_notification_type') }}" method="POST">
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
                                    @forelse ($allNotificationType as $key => $item)
                                        <tr class="hover-table pointer">
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn rounded-pill btn-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal_notification_type"
                                                    onclick="setDeleteForm('{{ route('notification.delete_notification_type', $item->id) }}')">
                                                    <i class="fa fa-trash p-0"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="noDataAlert">
                                            <td colspan="10" class="text-center">
                                                <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4 mb-0"
                                                    role="alert"
                                                    style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                                    <div class="mb-3">
                                                        <i class="fas fa-ban"
                                                            style="font-size: 36px; color: #6c757d;"></i>
                                                    </div>
                                                    <div class="text-center">
                                                        <h5 style="font-size: 16px; font-weight: 600; color: #495057;">
                                                            Không Có Dữ Liệu</h5>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn rounded-pill btn-sm btn-secondary"
                            data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn rounded-pill btn-sm btn-twitter"
                            id="submit_notification_type">Thêm</button>
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
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="deleteModalLabel">Xóa Loại Thông
                            Báo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-3" method="POST">
                        @csrf
                        <input type="hidden" name="delete_notification" value="{{ $item->code }}">
                        <div class="modal-body pb-0 text-center">
                            <p class="text-danger mb-4">Xóa Loại Thông Báo Này?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit"
                                class="btn rounded-pill btn-sm btn-danger px-4 load_animation">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
