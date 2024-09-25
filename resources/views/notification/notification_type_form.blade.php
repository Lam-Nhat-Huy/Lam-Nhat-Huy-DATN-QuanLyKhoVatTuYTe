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
            background: #b5b5b5;
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

@section('scripts')
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('notification.notification_type') }}" class="btn btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="notification.notification_update" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">
                    <div class="mb-5">
                        <label class="required fs-5 fw-bold mb-3">Tên Loại</label>

                        <input type="text" class="form-control form-control-sm form-control-solid border border-success"
                            placeholder="Tên Nhóm Vật Tư.." name="material_type_name" />
                    </div>

                    <div class="mb-5">
                        <label class="required fs-5 fw-bold mb-2">Trạng Thái</label>
                        <div class="checkbox-wrapper-6">
                            <input class="tgl tgl-light" id="cb1-6" type="checkbox" value="2" checked />
                            <label class="tgl-btn" for="cb1-6">
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer flex-right">
                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-twitter btn-sm">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>
@endsection
