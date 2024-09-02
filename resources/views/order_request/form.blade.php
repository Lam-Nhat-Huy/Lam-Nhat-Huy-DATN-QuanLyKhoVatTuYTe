@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    if ($action == 'create') {
        $action = route('order_request.create');

        $button_text = 'Tạo';
    } else {
        $action = route('order_request.edit');

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
                    <a href="{{ route('order_request.index') }}" class="btn btn-sm btn-dark">
                        <span class="align-items-center d-flex">
                            <i class="fa fa-arrow-left me-1"></i>
                            Trở Lại
                        </span>
                    </a>
                </div>
            </div>
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row mb-5">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Nhà Cung Cấp</label>

                            <select name="" class="form-select form-select-sm form-select-solid">
                                <option value="0">Chọn Nhà Cung Cấp...</option>
                                @foreach ($AllSuppiler as $item)
                                    <option value="{{ $item['id'] }}"
                                        {{ !empty($FirstOrderReqeust['supplier_id']) ? ($item['id'] == $FirstOrderReqeust['supplier_id'] ? 'selected' : '') : '' }}>
                                        {{ $item['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">Ghi Chú</label>


                            <input type="text" class="form-control form-control-sm form-control-solid border border-primary"
                                placeholder="Nhập Ghi Chú Cho Đơn Đặt Hàng.." name="last-name" />

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-5 mb-xl-8">
            <form class="form pt-5" action="" enctype="multipart/form-data">
                @csrf
                <div class="py-5 px-lg-17">

                    <div class="me-n7 pe-7">

                        <div class="row mb-5">

                            <div class="col-md-6 fv-row">

                                <label class="required fs-5 fw-bold mb-3">Vật Tư</label>

                                <select name="material" class="form-select form-select-sm form-select-solid">
                                    <option value="">Chọn Vật Tư...</option>
                                    @foreach ($AllMaterial as $item)
                                        <option value="{{ $item['id'] }}"
                                            class="{{ $item['quantity'] <= 10 || \Carbon\Carbon::parse($item['expiry'])->diffInDays(now(), true) < 10 ? 'text-danger' : '' }}">
                                            {{ $item['material_name'] }} - ({{ $item['description'] }}) - (Tổng Tồn:
                                            {{ $item['quantity'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6 fv-row">

                                <label class="fs-5 fw-bold mb-2">Số Lượng</label>


                                <input type="number" class="form-control form-control-sm form-control-solid border border-primary" value="0"
                                    name="quantity" />

                            </div>

                        </div>

                    </div>
                </div>

                <div class="modal-footer flex-right border-0 pt-0">
                    <button type="submit" class="btn btn-success btn-sm">
                        Thêm Vật Tư
                    </button>
                </div>
            </form>
        </div>

        <div class="card mb-5 mb-xl-8 pt-5">
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-striped align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder bg-success">
                                <th class="">Vật Tư</th>
                                <th class="">Đơn Vị</th>
                                <th class="">Số Lượng</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>
                                    Bình Oxy Y Tế - (Bình 5 Lít)
                                </td>
                                <td>
                                    Bình
                                </td>
                                <td>
                                    100
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer flex-right">
                <button type="submit" class="btn btn-twitter btn-sm">
                    {{ $button_text }}
                </button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection
