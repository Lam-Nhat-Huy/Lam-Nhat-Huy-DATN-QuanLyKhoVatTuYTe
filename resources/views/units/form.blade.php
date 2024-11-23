@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@php
    if ($action == 'edit') {
        $action = route('units.update', $unit->code);
        $button_text = 'Cập Nhật';
        $required = '';
    } else {
        $action = route('units.store');
        $button_text = 'Thêm';
        $required = 'required';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $button_text }} Đơn Vị</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('units.index') }}" class="btn rounded-pill btn-sm btn-dark">
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

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Tên Đơn Vị</label>

                        <div class="d-flex align-items-center">

                            <input name="name" class="form-control form-control-sm border-success rounded-pill"
                                value="{{ old('name', $unit->name ?? '') }}" placeholder="Tên đơn vị..">
                        </div>

                        @error('name')
                            <div class="message_error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">

                        <label class="{{ $required }} fs-5 fw-bold mb-3">Mô Tả</label>

                        <textarea name="description" id="description" class="form-control form-control-sm border-success" rows="5" placeholder="Mô tả đơn vị..">{{ old('description', $unit->description ?? '') }}</textarea>

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
