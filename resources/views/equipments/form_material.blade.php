@extends('master_layout.layout')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    if ($action == 'edit') {
        $action = route('equipments.edit_equipments', $currentEquipment->code);
        $button_text = 'Cập Nhật';
    } else {
        $action = route('equipments.create_equipments');
        $button_text = 'Thêm';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.index') }}" class="btn btn-sm btn-dark">
                    <span class="align-items-center d-flex" style="font-size: 10px">
                        <i style="font-size: 10px" class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $action }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="py-5 px-lg-17">
                <div class="me-n7 pe-7">
                    <div class="row align-items-center mb-8">
                        <div class="col-12 mb-5">
                            <label class="fs-5 fw-bold mb-3">Ảnh Vật Tư</label>
                            <!-- If there's a current image, display it, otherwise leave the src empty -->
                            <img id="preview-image"
                                src="{{ isset($currentEquipment->image) ? asset('images/equipments/' . $currentEquipment->image) : '' }}"
                                width="200" alt="Chưa có hình ảnh"
                                style="display: {{ isset($currentEquipment->image) ? 'block' : 'none' }};" />
                        </div>

                        <div class="col-6 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-3">Hình Ảnh</label>
                            <input type="file" class="form-control form-control-sm border border-success rounded-pill"
                                name="material_image" accept="image/*">
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Tên Vật Tư</label>
                            <input type="text" class="form-control form-control-sm border border-success rounded-pill"
                                name="name" placeholder="Tên Vật Tư.."
                                value="{{ isset($currentEquipment) ? $currentEquipment->name : old('name') }}">
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Nhóm Vật Tư</label>
                            <div class="d-flex align-items-center">
                                <select name="equipment_type_code"
                                    class="form-select form-select-sm border border-success rounded-pill">
                                    <option value="">Chọn Nhóm Vật Tư...</option>
                                    @foreach ($equipmentTypes as $type)
                                        <option value="{{ $type->code }}"
                                            {{ isset($currentEquipment) && $currentEquipment->equipment_type_code == $type->code ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_nvt_"
                                    title="Thêm Nhóm Vật Tư">
                                    <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Đơn Vị Tính</label>
                            <div class="d-flex align-items-center">
                                <select name="unit_code"
                                    class="form-select form-select-sm border border-success rounded-pill">
                                    <option value="">Chọn Đơn Vị Tính...</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->code }}"
                                            {{ isset($currentEquipment) && $currentEquipment->unit_code == $unit->code ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_dvt_"
                                    title="Thêm Đơn Vị Tính">
                                    <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Giá</label>
                            <input type="number" class="form-control form-control-sm border border-success rounded-pill"
                                name="price"
                                value="{{ old('price', isset($currentEquipment) ? $currentEquipment->price : 0) }}">
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-3">Ngày Hết Hạn (Nếu Có)</label>
                            <input type="date" class="form-control form-control-sm border border-success rounded-pill"
                                name="expiry_date"
                                value="{{ old('expiry_date', isset($currentEquipment) ? $currentEquipment->expiry_date : '') }}">
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Nhà Cung Cấp</label>
                            <div class="d-flex align-items-center">
                                <select name="supplier_code"
                                    class="form-select form-select-sm border border-success rounded-pill">
                                    <option value="">Chọn Nhà Cung Cấp...</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->code }}"
                                            {{ old('supplier_code', isset($currentEquipment) ? $currentEquipment->supplier_code : '') == $supplier->code ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_ncc_"
                                    title="Thêm Nhà Cung Cấp">
                                    <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Nước Sản Xuất</label>
                            <select name="country" class="form-select form-select-sm border border-success rounded-pill">
                                <option value="Vietnam"
                                    {{ old('country', isset($currentEquipment) ? $currentEquipment->country : '') == 'Vietnam' ? 'selected' : '' }}>
                                    Việt Nam
                                </option>
                                <option value="United States"
                                    {{ old('country', isset($currentEquipment) ? $currentEquipment->country : '') == 'United States' ? 'selected' : '' }}>
                                    Hoa Kỳ
                                </option>
                                <option value="China"
                                    {{ old('country', isset($currentEquipment) ? $currentEquipment->country : '') == 'China' ? 'selected' : '' }}>
                                    Trung Quốc
                                </option>
                            </select>
                        </div>

                        <div class="col-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-3">Mô Tả</label>
                            <textarea name="description" cols="30" rows="10" class="form-control border border-success form-control-sm "
                                placeholder="Thêm Mô Tả Cho Vật Tư.."></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-sm py-2">{{ $button_text }}</button>
                </div>
        </form>

    </div>

    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy input file và thẻ img để hiển thị ảnh xem trước
            const inputFile = document.querySelector('input[name="material_image"]');
            const previewImage = document.getElementById('preview-image');

            // Thêm sự kiện change cho input file
            inputFile.addEventListener('change', function(event) {
                const file = event.target.files[0]; // Lấy file đã chọn

                // Kiểm tra nếu người dùng chọn file
                if (file) {
                    const reader = new FileReader(); // Tạo FileReader để đọc file
                    reader.onload = function(e) {
                        previewImage.src = e.target.result; // Đặt src cho thẻ img
                        previewImage.style.display = 'block'; // Hiển thị thẻ img
                    }
                    reader.readAsDataURL(file); // Đọc file dưới dạng URL
                } else {
                    previewImage.style.display = 'none'; // Ẩn thẻ img nếu không có file
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy input file và thẻ img để hiển thị ảnh xem trước
            const inputFile = document.querySelector('input[name="material_image"]');
            const previewImage = document.getElementById('preview-image');

            // Thêm sự kiện change cho input file
            inputFile.addEventListener('change', function(event) {
                const file = event.target.files[0]; // Lấy file đã chọn

                // Kiểm tra nếu người dùng chọn file
                if (file) {
                    const reader = new FileReader(); // Tạo FileReader để đọc file
                    reader.onload = function(e) {
                        previewImage.src = e.target.result; // Đặt src cho thẻ img
                        previewImage.style.display = 'block'; // Hiển thị thẻ img
                    }
                    reader.readAsDataURL(file); // Đọc file dưới dạng URL
                } else {
                    previewImage.style.display = 'none'; // Ẩn thẻ img nếu không có file
                }
            });
        });
    </script>
@endsection
