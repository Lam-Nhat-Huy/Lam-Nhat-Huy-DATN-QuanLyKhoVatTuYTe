@extends('master_layout.layout')

@section('styles')
    <style>
        /* Tùy chỉnh hiệu ứng chuyển động cho nút bật/tắt */
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
            width: 40px;
            height: 22px;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
            left: 0;
            border-radius: 50%;
            background: #fff;
            transition: all 0.2s ease;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn {
            background: #f0f0f0;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
        }

        .checkbox-wrapper-6 .tgl-light:checked+.tgl-btn {
            background: #1fb948;
        }

        .checkbox-wrapper-6 .tgl:checked+.tgl-btn:after {
            left: 50%;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    // Xác định URL action dựa trên giá trị của $action
    if ($action == 'edit') {
        $formAction = route('equipments.edit_equipments_group', $materialGroup->code);
        $button_text = 'Cập Nhật';
    } else {
        $formAction = route('equipments.create_equipments_group');
        $button_text = 'Thêm';
    }

    // Đường dẫn về danh sách nhóm vật tư
    $backToListUrl = route('equipments.equipments_group');
@endphp

@section('content')
    <div class="card shadow-sm mb-5">
        <div class="card-header d-flex justify-content-between align-items-center pt-4 pb-4">
            <h3 class="card-title fw-bolder fs-3 mb-0">
                {{ $action == 'edit' ? 'Chỉnh Sửa Nhóm Vật Tư' : 'Thêm Nhóm Vật Tư' }}
            </h3>
            <a href="{{ $backToListUrl }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Trở Về Danh Sách
            </a>
        </div>
        <div class="card-body p-5">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if ($action == 'edit')
                    @method('PUT')
                @endif

                <div class="form-group mb-4">
                    <label class="required fs-5 fw-bold mb-2">Mã Nhóm Vật Tư</label>
                    <input type="text" class="form-control form-control-solid border-success"
                        value="{{ $action == 'edit' ? $materialGroup->code : old('code') }}" name="code"
                        {{ $action == 'edit' ? 'disabled' : '' }} /> {{-- Không cho sửa code khi chỉnh sửa --}}
                </div>

                <div class="form-group mb-4">
                    <label class="required fs-5 fw-bold mb-2">Tên Nhóm Vật Tư</label>
                    <input type="text" class="form-control form-control-solid border-success"
                        value="{{ $action == 'edit' ? $materialGroup->name : old('name') }}" name="name" />
                </div>

                <div class="form-group mb-4">
                    <label class="fs-5 fw-bold mb-2">Mô Tả</label>
                    <textarea name="description" class="form-control form-control-solid border-success" cols="30" rows="5">{{ $action == 'edit' ? $materialGroup->description : old('description') }}</textarea>
                </div>

                <div class="form-group mb-4">
                    <label class="fs-5 fw-bold mb-2">Trạng Thái</label>
                    <div class="checkbox-wrapper-6">
                        <!-- Thêm input hidden với giá trị mặc định là 0 -->
                        <input type="hidden" name="status" value="0">
                        <input class="tgl tgl-light" id="status" type="checkbox" name="status" value="1"
                            {{ $action == 'edit' ? ($materialGroup->status ? 'checked' : '') : 'checked' }} />
                        <label class="tgl-btn" for="status"></label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-sm w-100 py-2">{{ $button_text }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
