@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    // Xác định URL action dựa trên giá trị của $action
    if ($action == 'edit') {
        $action = route('equipments.edit_equipments_group', $equipmentGroup->code);
        $button_text = 'Cập Nhật';
        $required = '';
    } else {
        $action = route('equipments.create_equipments_group');
        $button_text = 'Thêm';
        $required = 'required';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $button_text }} Nhóm Thiết Bị</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.equipments_group') }}" class="btn rounded-pill btn-sm btn-dark">
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

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Tên Nhóm Thiết Bị</label>

                        <div class="d-flex align-items-center">

                            <input name="name" class="form-control form-control-sm border-success rounded-pill"
                                value="{{ old('name', $equipmentGroup->name ?? '') }}" placeholder="Tên nhóm thiết bị..">
                        </div>

                        @error('name')
                            <div class="message_error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Mô Tả</label>

                        <textarea name="description" id="description" class="form-control form-control-sm border-success" rows="5" placeholder="Mô tả nhóm thiết bị..">{{ old('description', $equipmentGroup->description ?? '') }}</textarea>

                    </div>

                    <div class="mb-5 {{ $linkedEquipments > 0 ? 'd-none' : '' }}">
                        <label class="fs-5 fw-bold mb-2">Trạng Thái Nhóm Thiết Bị</label>
                        <div class="checkbox-wrapper-6">
                            <input class="tgl tgl-light" id="cb1-6" type="checkbox" value="1" name="status"
                                {{ (!empty($equipmentGroup->status) && $equipmentGroup->status == 1) || old('status') == 1 ? 'checked' : '' }} />
                            <label class="tgl-btn" for="cb1-6"></label>
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
@endsection
