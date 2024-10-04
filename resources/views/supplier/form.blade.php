@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@php
    if ($config == 'create') {
        $config = route('supplier.create');
        $button_text = 'Thêm';
        $hidden = '';
        $required = 'required';
    } else {
        $config = route('supplier.update');
        $button_text = 'Cập nhật';
        $hidden = 'd-none';
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
                <a href="{{ route('supplier.list') }}?{{ request()->getQueryString() }}"
                    class="btn rounded-pill btn-sm btn-dark">
                    <span class="align-items-center d-flex" style="font-size: 10px;">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" method="post" action="{{ $config }}" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row mb-5">
                        <div class="mb-5 col-6">

                            <label class="required fs-6 fw-bold mb-3">Tên Nhà Cung Cấp</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success rounded-pill"
                                placeholder="Tên nhà cung cấp.." name="name"
                                value="{{ !empty($firstSupplier->name) ? $firstSupplier->name : old('name') }}" />
                            @error('name')
                                <div class="message_error">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-6 fw-bold mb-3">Người Đại Diện</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success rounded-pill"
                                placeholder="Tên người đại diện.." name="contact_name"
                                value="{{ !empty($firstSupplier->contact_name) ? $firstSupplier->contact_name : old('contact_name') }}" />
                            @error('contact_name')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-6 fw-bold mb-3">Mã Số Thuế</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success rounded-pill"
                                placeholder="Mã số thuế.." name="tax_code"
                                value="{{ !empty($firstSupplier->tax_code) ? $firstSupplier->tax_code : old('tax_code') }}" />
                            @error('tax_code')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-6 fw-bold mb-3">Số Điện Thoại</label>

                            <input type="number"
                                class="form-control form-control-sm form-control-solid border border-success rounded-pill"
                                placeholder="Số điện thoại.." name="phone"
                                value="{{ !empty($firstSupplier->phone) ? $firstSupplier->phone : old('phone') }}" />
                            @error('phone')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-6 fw-bold mb-3">Email</label>

                            <input type="email"
                                class="form-control form-control-sm form-control-solid border border-success rounded-pill"
                                placeholder="Email.." name="email"
                                value="{{ !empty($firstSupplier->email) ? $firstSupplier->email : old('email') }}" />
                            @error('email')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-6 fw-bold mb-3">Địa Chỉ</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success rounded-pill"
                                placeholder="Địa chỉ.." name="address"
                                value="{{ !empty($firstSupplier->address) ? $firstSupplier->address : old('address   ') }}" />
                            @error('address')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer pe-0">
                    <button type="submit" class="btn rounded-pill btn-twitter btn-sm load_animation">
                        {{ $button_text }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
