@extends('master_layout.layout')

@section('styles')
    <style>
        .text-danger {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            color: #333;
        }

        .card-toolbar a {
            background-color: #343a40;
            border: none;
        }

        .form-control, .form-select {
            border-radius: 0.375rem;
            border-color: #ddd;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-sm, .form-select-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        label {
            font-size: 1rem;
            font-weight: 500;
            color: #495057;
        }

        button[type="submit"] {
            background-color: #28a745;
            border: none;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        .modal-content {
            border-radius: 0.5rem;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .modal-title {
            color: #333;
        }

        .modal-footer button {
            border-radius: 0.25rem;
        }

        .setupSelect2 {
            width: 100%;
        }

        /* Hover effect for interactive elements */
        .btn:hover, .fa:hover {
            background-color: #218838;
            cursor: pointer;
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 0.375rem;
            padding: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Adjustments to preview image */
        #preview-image {
            border: 2px solid #ddd;
            padding: 5px;
            border-radius: 0.375rem;
        }

        /* Custom spacing for input fields */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@php
    if ($action == 'edit') {
        $form_action = route('equipments.edit_equipments', $currentEquipment->code);
        $button_text = 'Cập Nhật';
    } else {
        $form_action = route('equipments.create_equipments');
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
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="form" action="{{ $form_action }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="py-5 px-lg-17">
                    <div class="me-n7 pe-7">
                        <div class="row align-items-center mb-8">
                            <!-- Ảnh Vật Tư -->
                            <div class="col-12 mb-5 text-center">
                                <label class="fs-5 fw-bold mb-3">Ảnh Vật Tư</label>
                                <img id="preview-image"
                                     src="{{ isset($currentEquipment->image) ? asset('images/equipments/' . $currentEquipment->image) : '' }}"
                                     width="200" alt="Chưa có hình ảnh"
                                     style="display: {{ isset($currentEquipment->image) ? 'block' : 'none' }};" class="mb-3" />
                                @error('material_image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Hình Ảnh -->
                            <div class="col-6 fv-row mb-5">
                                <label class="fs-5 fw-bold mb-3">Hình Ảnh</label>
                                <input type="file"
                                       class="form-control form-control-sm form-control-solid border border-success"
                                       name="material_image" accept="image/*">
                                @error('material_image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tên Vật Tư -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Tên Vật Tư</label>
                                <input type="text"
                                       class="form-control form-control-sm form-control-solid border border-success" name="name"
                                       placeholder="Tên Vật Tư.."
                                       value="{{ isset($currentEquipment) ? $currentEquipment->name : old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nhóm Vật Tư -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Nhóm Vật Tư</label>
                                <div class="d-flex align-items-center">
                                    <select name="equipment_type_code"
                                            class="form-select form-select-sm form-select-solid setupSelect2">
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
                                @error('equipment_type_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Đơn Vị Tính -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Đơn Vị Tính</label>
                                <div class="d-flex align-items-center">
                                    <select name="unit_code" class="form-select form-select-sm form-select-solid setupSelect2">
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
                                @error('unit_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Giá -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Giá</label>
                                <input type="number"
                                       class="form-control form-control-sm form-control-solid border border-success" name="price"
                                       value="{{ old('price', isset($currentEquipment) ? $currentEquipment->price : 0) }}">
                                @error('price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Ngày Hết Hạn -->
                            <div class="col-6 fv-row mb-5">
                                <label class="fs-5 fw-bold mb-3">Ngày Hết Hạn (Nếu Có)</label>
                                <input type="date"
                                       class="form-control form-control-sm form-control-solid border border-success"
                                       name="expiry_date"
                                       value="{{ old('expiry_date', isset($currentEquipment) ? $currentEquipment->expiry_date : '') }}">
                                @error('expiry_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nhà Cung Cấp -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Nhà Cung Cấp</label>
                                <div class="d-flex align-items-center">
                                    <select name="supplier_code"
                                            class="form-select form-select-sm form-select-solid setupSelect2">
                                        <option value="">Chọn Nhà Cung Cấp...</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->code }}"
                                                {{ old('supplier_code', isset($currentEquipment) ? $currentEquipment->supplier_code : '') == $supplier->code ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_supplier_" title="Thêm Nhà Cung Cấp">
                                        <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                    </span>

                                </div>
                                @error('supplier_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nước Sản Xuất -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Nước Sản Xuất</label>
                                <select name="country" class="form-select form-select-sm form-select-solid setupSelect2">
                                    <option value="Vietnam"
                                        {{ old('country', isset($currentEquipment) ? $currentEquipment->country : '') == 'Vietnam' ? 'selected' : '' }}>
                                        Việt Nam</option>
                                    <option value="United States"
                                        {{ old('country', isset($currentEquipment) ? $currentEquipment->country : '') == 'United States' ? 'selected' : '' }}>
                                        Hoa Kỳ</option>
                                    <option value="China"
                                        {{ old('country', isset($currentEquipment) ? $currentEquipment->country : '') == 'China' ? 'selected' : '' }}>
                                        Trung Quốc</option>
                                </select>
                                @error('country')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mô Tả -->
                            <div class="col-12 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-3">Mô Tả</label>
                                <textarea name="description" cols="30" rows="10"
                                          class="form-control form-control-sm form-control-solid border border-success"
                                          placeholder="Thêm Mô Tả Cho Vật Tư..">{{ old('description', isset($currentEquipment) ? $currentEquipment->description : '') }}</textarea>
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
    </div>

    <!-- Modal Thêm Nhóm Vật Tư -->
    <div class="modal fade" id="add_modal_nvt_" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Nhóm Vật Tư</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('equipments.create_material_group_modal') }}" method="POST"
                      id="add-material-group-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="code" class="form-label">Mã Nhóm Vật Tư</label>
                            <input type="text" class="form-control" id="code" name="code"
                                   placeholder="Nhập mã nhóm vật tư" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Tên Nhóm Vật Tư</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Nhập tên nhóm vật tư" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Trạng Thái</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1">Kích Hoạt</option>
                                <option value="0">Không Kích Hoạt</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Đơn Vị Tính -->
    <div class="modal fade" id="add_modal_dvt_" tabindex="-1" aria-labelledby="addModalDVTLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalDVTLabel">Thêm Đơn Vị Tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('equipments.create_unit_modal') }}" method="POST" id="add-unit-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="unit_code" class="form-label">Mã Đơn Vị Tính</label>
                            <input type="text" class="form-control" id="unit_code" name="code"
                                   placeholder="Nhập mã đơn vị tính" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="unit_name" class="form-label">Tên Đơn Vị Tính</label>
                            <input type="text" class="form-control" id="unit_name" name="name"
                                   placeholder="Nhập tên đơn vị tính" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Nhà Cung Cấp -->
    <div class="modal fade" id="add_modal_supplier_" tabindex="-1" aria-labelledby="addModalSupplierLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalSupplierLabel">Thêm Nhà Cung Cấp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('equipments.create_supplier_modal') }}" method="POST" id="add-supplier-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="supplier_code" class="form-label">Mã Nhà Cung Cấp</label>
                            <input type="text" class="form-control" id="supplier_code" name="code"
                                   placeholder="Nhập mã nhà cung cấp" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="supplier_name" class="form-label">Tên Nhà Cung Cấp</label>
                            <input type="text" class="form-control" id="supplier_name" name="name"
                                   placeholder="Nhập tên nhà cung cấp" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="contact_name" class="form-label">Tên Liên Hệ</label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name"
                                   placeholder="Nhập tên liên hệ">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tax_code" class="form-label">Mã Số Thuế</label>
                            <input type="text" class="form-control" id="tax_code" name="tax_code"
                                   placeholder="Nhập mã số thuế">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Nhập email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="Nhập số điện thoại">
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Địa Chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Nhập địa chỉ"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
