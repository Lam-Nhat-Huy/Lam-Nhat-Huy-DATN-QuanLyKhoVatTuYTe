@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@php
    $url =
        $config['method'] == 'create'
            ? route('supplier.store')
            : route('supplier.update', session('supplier_id_session'));
    $title = $config['method'] == 'create' ? 'Thêm Nhà Cung Cấp' : 'Chỉnh sửa Nhà Cung Cấp';
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('supplier.list') }}" class="btn btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $url }}" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row align-items-center">
                        <div class="mb-5 col-6">

                            <label class="required fs-5 fw-bold mb-3">Tên Nhà Cung Cấp</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="" />

                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-5 fw-bold mb-3">Người Đại Diện</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="" />

                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-5 fw-bold mb-3">Mã Số Thuế</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="" />

                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-5 fw-bold mb-3">Số Điện Thoại</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="" />

                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-5 fw-bold mb-3">Email</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="" />

                        </div>

                        <div class="mb-5 col-6">

                            <label class="required fs-5 fw-bold mb-3">Địa Chỉ</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="" />

                        </div>
                    </div>

                </div>
            </div>


            <div class="modal-footer flex-right">
                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-twitter btn-sm">
                    Lưu
                </button>
            </div>
        </form>
    </div>
@endsection
