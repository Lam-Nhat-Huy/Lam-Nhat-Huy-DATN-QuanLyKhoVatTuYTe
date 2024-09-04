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
    </script>
@endsection

@php
    if ($action == 'create') {
        $action = route('notification.notification_create');

        $button_text = 'Thêm';
    } else {
        $action = route('notification.notification_update');

        $button_text = 'Cập Nhật';
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
        <form class="form" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="mb-5">

                        <label class="required fs-5 fw-bold mb-3">Chọn Loại Thông Báo</label>

                        <div class="d-flex align-items-center">

                            <select name="" class="form-select form-select-sm form-select-solid setupSelect2">
                                <option value="0">Chọn Loại Thông Báo...</option>
                                <option value="A">A</option>
                            </select>

                            <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_ncc_"
                                title="Thêm Loại Thông Báo"><i
                                    class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i></span>

                            <div class="modal fade" id="add_modal_ncc_" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="deleteModalLabel">Thêm Loại Thông Báo</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="required fs-5 fw-bold mb-2">Tên Loại Thông Báo</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control-solid border border-success"
                                                        placeholder="Tên Loại Thông Báo.." name="" />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-sm btn-twitter">Thêm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">

                        <label class="required fs-5 fw-bold mb-3">Nội Dung Thông Báo</label>

                        <textarea name="content" id="content"></textarea>

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
@endsection
