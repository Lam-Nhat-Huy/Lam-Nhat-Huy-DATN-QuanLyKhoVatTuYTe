@extends('master_layout.layout')

@section('styles')
    <style>
        .checkbox-wrapper-6 .tgl {
            display: none;
        }

        .checkbox-wrapper-6 .tgl,
        .checkbox-wrapper-6 .tgl:after,
        .checkbox-wrapper-6 .tgl:before,
        .checkbox-wrapper-6 .tgl *,
        .checkbox-wrapper-6 .tgl *:after,
        .checkbox-wrapper-6 .tgl *:before,
        .checkbox-wrapper-6 .tgl+.tgl-btn {
            box-sizing: border-box;
        }

        .checkbox-wrapper-6 .tgl::-moz-selection,
        .checkbox-wrapper-6 .tgl:after::-moz-selection,
        .checkbox-wrapper-6 .tgl:before::-moz-selection,
        .checkbox-wrapper-6 .tgl *::-moz-selection,
        .checkbox-wrapper-6 .tgl *:after::-moz-selection,
        .checkbox-wrapper-6 .tgl *:before::-moz-selection,
        .checkbox-wrapper-6 .tgl+.tgl-btn::-moz-selection,
        .checkbox-wrapper-6 .tgl::selection,
        .checkbox-wrapper-6 .tgl:after::selection,
        .checkbox-wrapper-6 .tgl:before::selection,
        .checkbox-wrapper-6 .tgl *::selection,
        .checkbox-wrapper-6 .tgl *:after::selection,
        .checkbox-wrapper-6 .tgl *:before::selection,
        .checkbox-wrapper-6 .tgl+.tgl-btn::selection {
            background: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn {
            outline: 0;
            display: block;
            width: 40px;
            height: 22px;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after,
        .checkbox-wrapper-6 .tgl+.tgl-btn:before {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after {
            left: 0;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:before {
            display: none;
        }

        .checkbox-wrapper-6 .tgl:checked+.tgl-btn:after {
            left: 50%;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn {
            background: #f0f0f0;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn:after {
            border-radius: 50%;
            background: #fff;
            transition: all 0.2s ease;
        }

        .checkbox-wrapper-6 .tgl-light:checked+.tgl-btn {
            background: #1fb948;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    if ($action == 'create') {
        $action = route('user.create');

        $button_text = 'Thêm';
    } else {
        $action = route('user.update');

        $button_text = 'Cập Nhật';
    }
@endphp

@section('content')
    <form class="form" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-5 mb-xl-8 pb-5">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-dark">
                        <span class="align-items-center d-flex">
                            <i class="fa fa-arrow-left me-1"></i>
                            Trở Lại
                        </span>
                    </a>
                </div>
            </div>
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row align-items-center mb-5">

                        <div class="col-6 fv-row mb-5">

                            <label class="required fs-5 fw-bold mb-2">Tên</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Người Dùng.." name="name" />

                        </div>

                        <div class="col-6 fv-row mb-5">

                            <label class="required fs-5 fw-bold mb-2">Email</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Email người dùng.." name="name" />

                        </div>

                        <div class="col-6 fv-row mb-5">

                            <label class="required fs-5 fw-bold mb-2">Số Điện Thoại</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Số Điện Thoại Người Dùng.." name="name" />

                        </div>

                        <div class="col-6 fv-row mb-5">

                            <label class="required fs-5 fw-bold mb-2">Mật Khẩu</label>

                            <input type="password"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Mật Khẩu Đăng Nhập.." name="name" />

                        </div>

                        <div class="col-6 fv-row mb-5">

                            <label class="required fs-5 fw-bold mb-3">Vai Trò</label>

                            <select name="" class="form-select form-select-sm form-select-solid setupSelect2">
                                <option value="" name="role_id">Admin</option>
                                <option value="" name="role_id">Kho</option>
                                <option value="" name="role_id">Kế Toán</option>
                                <option value="" name="role_id">Mua Hàng</option>
                            </select>

                        </div>

                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Trạng Thái Tài Khoản</label>

                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cb1-6" type="checkbox" value="2" checked />
                                <label class="tgl-btn" for="cb1-6">
                            </div>
                        </div>

                        <div class="col-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Địa Chỉ Hiện Tại</label>

                            <textarea class="form-control form-control-sm form-control-solid border border-success" name="" id="" cols="30" rows="5" placeholder="Địa Chỉ Hiện Tại Của Người Dùng"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer flex-right pe-0">
                        <button type="submit" class="btn btn-twitter btn-sm">
                            {{ $button_text }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection
