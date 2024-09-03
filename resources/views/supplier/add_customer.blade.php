@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@section('content')
    @php
        $url = $config['method'] == 'create'
            ? route('supplier.store')
            : route('supplier.update', session('supplier_id_session'));
        $title = $config['method'] == 'create' ? 'Thêm nhà cung cấp' : 'Chỉnh sửa nhà cung cấp';
    @endphp
    <form action="{{ $url }}" method="POST" autocomplete="on">
        @csrf
        @method('POST')
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-light shadow-sm">
                        <div class="d-flex bg-secondary align-items-center justify-content-between p-4 bg-secondary">
                            <div class="">
                                <h4 class="mb-0">{{ $title }}</h4>
                            </div>
                            <div class="text-end  text-white">
                                <a class="btn btn-primary" href="{{route('supplier.list')}}"> Quay lại</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name" class="form-label">Tên nhà cung cấp</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Tên nhà cung cấp"
                                            value="{{ isset($getEdit) ? $getEdit->company_name : old('company_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại"
                                            value="{{ isset($getEdit) ? $getEdit->phone : old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ"
                                            value="{{ isset($getEdit) ? $getEdit->address : old('address') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                            value="{{ isset($getEdit) ? $getEdit->email : old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tax_code" class="form-label">Mã số thuế</label>
                                        <input type="text" class="form-control" id="tax_code" name="tax_code" placeholder="Mã số thuế"
                                            value="{{ isset($getEdit) ? $getEdit->tax_code : old('tax_code') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_person" class="form-label">Người đại diện</label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Người đại diện"
                                            value="{{ isset($getEdit) ? $getEdit->contact_person : old('contact_person') }}">
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
