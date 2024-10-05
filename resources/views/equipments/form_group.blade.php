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

        /* Tùy chỉnh form */
        .form-control {
            padding: 10px 15px;
            font-size: 14px;
            border: 1px solid #d1d3e2;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #1fb948;
            box-shadow: none;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .required::after {
            content: " *";
            color: red;
        }

        /* Tùy chỉnh nút */
        .btn-success {
            background-color: #1fb948;
            border: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #169e38;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #565e64;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 1px solid #e3e6f0;
        }

        /* Căn chỉnh form */
        .form-control-sm rounded-pill {
            border: 1px solid #ced4da;
            padding: 10px 15px;
            border-radius: 6px;
            background-color: #f8f9fa;
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
            <a href="{{ $backToListUrl }}" style="font-size: 10px;" class="btn btn-sm btn-dark rounded-pill">
                <i class="fa fa-arrow-left me-1"></i> Trở Về
            </a>
        </div>
        <div class="card-body p-5">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if ($action == 'edit')
                    @method('PUT')
                @endif

                <!-- Form tạo hoặc chỉnh sửa nhóm vật tư -->
                <div class="form-group">
                    <label class="required fs-5 fw-bold mb-2">Mã Nhóm Vật Tư</label>
                    <input type="text" class="form-control form-control-sm rounded-pill border-success"
                        value="{{ isset($materialGroup) ? $materialGroup->code : old('code') }}" name="code"
                        placeholder="Mã ET ví dụ: ET001" {{ isset($materialGroup) ? 'disabled' : '' }} />
                    {{-- Không cho sửa code khi chỉnh sửa --}}
                </div>

                <div class="form-group">
                    <label class="required fs-5 fw-bold mb-2">Tên Nhóm Vật Tư</label>
                    <input type="text" class="form-control form-control-sm rounded-pill border-success"
                        value="{{ isset($materialGroup) ? $materialGroup->name : old('name') }}" name="name" />
                </div>

                <div class="form-group">
                    <label class="fs-5 fw-bold mb-2">Mô Tả</label>
                    <textarea name="description" class="form-control form-control-sm rounded-3 border-success" cols="30"
                        rows="5">{{ isset($materialGroup) ? $materialGroup->description : old('description') }}</textarea>
                </div>


                <div class="form-group">
                    <label class="fs-5 fw-bold mb-2">Trạng Thái</label>
                    <div class="checkbox-wrapper-6">
                        <!-- Thêm input hidden với giá trị mặc định là 0 -->
                        <input type="hidden" name="status" value="0">

                        <!-- Kiểm tra biến $canEditStatus -->
                        <!-- Kiểm tra biến $materialGroup có tồn tại -->
                        @if (isset($materialGroup))
                            <!-- Nếu có thể chỉnh sửa -->
                            @if (isset($canEditStatus) && $canEditStatus)
                                <input class="tgl tgl-light" id="status" type="checkbox" name="status" value="1"
                                    {{ $materialGroup->status ? 'checked' : '' }} />
                                <label class="tgl-btn" for="status"></label>
                            @else
                                <!-- Nếu không thể chỉnh sửa, checkbox bị vô hiệu hóa -->
                                <input class="tgl tgl-light" id="status" type="checkbox" name="status" value="1"
                                    {{ $materialGroup->status ? 'checked' : '' }} disabled />
                                <label class="tgl-btn" for="status"></label>
                                <small class="text-danger">Trạng thái không thể thay đổi do có liên kết với sản
                                    phẩm.</small>
                            @endif
                        @else
                            <!-- Trường hợp thêm mới, checkbox mặc định không checked -->
                            <input class="tgl tgl-light" id="status" type="checkbox" name="status" value="1" />
                            <label class="tgl-btn" for="status"></label>
                        @endif

                    </div>
                </div>


                <div class="d-grid gap-2 justify-content-end">
                    <button type="submit" class="btn btn-success btn-sm py-2 rounded-pill"
                        style="width: 120px; font-size: 12px; background-color: rgba(46, 204, 113, 0.8);">
                        <!-- Thay đổi màu và độ trong suốt tại đây -->
                        {{ $button_text }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
