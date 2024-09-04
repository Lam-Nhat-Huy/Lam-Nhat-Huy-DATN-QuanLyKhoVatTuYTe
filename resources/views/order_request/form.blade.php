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

                    <div class="row align-items-center mb-5">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Nhà Cung Cấp</label>

                            <div class="d-flex align-items-center">
                                <select name="" class="form-select form-select-sm form-select-solid setupSelect2">
                                    <option value="0">Chọn Nhà Cung Cấp...</option>
                                    @foreach ($AllSuppiler as $item)
                                        <option value="{{ $item['id'] }}"
                                            {{ !empty($FirstOrderReqeust['supplier_id']) ? ($item['id'] == $FirstOrderReqeust['supplier_id'] ? 'selected' : '') : '' }}>
                                            {{ $item['name'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_ncc_"
                                    title="Thêm Nhà Cung Cấp"><i
                                        class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i></span>

                                <div class="modal fade" id="add_modal_ncc_" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="deleteModalLabel">Thêm Nhà Cung Cấp</h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="required fs-5 fw-bold mb-2">Tên Nhà Cung Cấp</label>
                                                        <input type="text"
                                                            class="form-control form-control-sm form-control-solid border border-success"
                                                            placeholder="Tên Nhà Cung Cấp.." name="" />
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <button type="button" class="btn btn-sm btn-twitter">Thêm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">Ghi Chú</label>


                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
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

                        <div class="row align-items-center mb-5">

                            <div class="col-md-6 fv-row">

                                <label class="required fs-5 fw-bold mb-3">Vật Tư</label>

                                <select name="material" class="form-select form-select-sm form-select-solid setupSelect2">
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


                                <input type="number"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    value="0" name="quantity" />

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer flex-right border-0 pe-0">
                        <button type="submit" class="btn btn-success btn-sm">
                            Thêm Vật Tư
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card mb-5 mb-xl-8 pt-5">
            <div class="card-body py-3 px-17">
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

                <div class="modal-footer flex-right pe-0">
                    <button type="submit" class="btn btn-twitter btn-sm">
                        {{ $button_text }}
                    </button>
                </div>
            </div>

        </div>
    </form>
@endsection

@section('scripts')
@endsection
