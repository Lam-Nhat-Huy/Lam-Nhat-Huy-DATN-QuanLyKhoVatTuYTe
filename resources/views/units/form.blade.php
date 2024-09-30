@extends('master_layout.layout')

@section('styles')
    <style>
        .text-danger {
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@php
    // Xác định URL cho form action dựa vào hành động là thêm hay sửa
    if ($action == 'edit') {
        $form_action = route('units.update', $unit->code); // Route cập nhật đơn vị
        $button_text = 'Cập Nhật';
    } else {
        $form_action = route('units.store'); // Route tạo mới đơn vị
        $button_text = 'Thêm';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span
                    class="card-label fw-bolder fs-3 mb-1">{{ $action == 'edit' ? 'Chỉnh Sửa Đơn Vị' : 'Thêm Đơn Vị' }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('units.index') }}" class="btn btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $form_action }}" method="POST">
            @csrf
            @if ($action == 'edit')
                @method('PUT') <!-- Sử dụng PUT cho cập nhật đơn vị -->
            @endif
            <div class="py-5 px-lg-17">
                <div class="me-n7 pe-7">
                    <div class="row align-items-center mb-8">
                        <!-- Mã Đơn Vị -->
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Mã Đơn Vị</label>
                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success" name="code"
                                placeholder="Mã Đơn Vị.." value="{{ isset($unit) ? $unit->code : old('code') }}"
                                {{ $action == 'edit' ? 'disabled' : '' }}>
                            <!-- Không cho phép chỉnh sửa mã đơn vị khi cập nhật -->
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tên Đơn Vị -->
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Tên Đơn Vị</label>
                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success" name="name"
                                placeholder="Tên Đơn Vị.." value="{{ isset($unit) ? $unit->name : old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Mô Tả -->
                        <div class="col-12 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-3">Mô Tả</label>
                            <textarea name="description" cols="30" rows="5"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Mô tả chi tiết về đơn vị...">{{ isset($unit) ? $unit->description : old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-sm w-100 py-2">{{ $button_text }}</button>
                </div>
        </form>
    </div>
@endsection
