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

        .form-control,
        .form-select {
            border-radius: 0.375rem;
            border-color: #ddd;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-sm,
        .form-select-sm {
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
        .btn:hover,
        .fa:hover {
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

        .image-preview-wrapper {
            position: relative;
            display: inline-block;
        }

        /* Tùy chỉnh kiểu của input */
        .custom-file-input {
            opacity: 0;
            position: absolute;
            z-index: 2;
            cursor: pointer;
        }

        /* Tùy chỉnh nhãn của input */
        .custom-file-input-label {
            position: relative;
            display: inline-block;
            background-color: #f8f9fa;
            border: 2px dashed #28a745;
            padding: 10px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            z-index: 1;
        }

        .custom-file-input-label:hover {
            background-color: #e9ecef;
            border-color: #218838;
        }

        .custom-file-input-text {
            color: #28a745;
            font-weight: bold;
        }

        .image-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            display: block;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 2px solid #28a745;
        }

        /* Ẩn nhãn khi có hình ảnh */
        .image-preview-wrapper img[style*="display: block;"]+.custom-file-input-label {
            display: none;
        }

        .image-preview-wrapper {
            position: relative;
            display: inline-block;
        }

        .custom-file-input {
            opacity: 0;
            position: absolute;
            z-index: 2;
            cursor: pointer;
        }

        .custom-file-input-label {
            position: relative;
            display: inline-block;
            background-color: #f8f9fa;
            border: 2px dashed #28a745;
            padding: 10px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            z-index: 1;
        }

        .custom-file-input-label:hover {
            background-color: #e9ecef;
            border-color: #218838;
        }

        .custom-file-input-text {
            color: #28a745;
            font-weight: bold;
        }

        .image-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            display: block;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 2px solid #28a745;
        }

        /* Ẩn nhãn khi có hình ảnh */
        .image-preview-wrapper img[style*="display: block;"]+.custom-file-input-label {
            display: none;
        }

        .image-preview-wrapper {
            position: relative;
            display: inline-block;
        }

        .custom-file-input {
            opacity: 0;
            position: absolute;
            z-index: 2;
            cursor: pointer;
        }

        .custom-file-input-label {
            position: relative;
            display: inline-block;
            background-color: #f8f9fa;
            border: 2px dashed #28a745;
            padding: 10px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            z-index: 1;
        }

        .custom-file-input-label:hover {
            background-color: #e9ecef;
            border-color: #218838;
        }

        .custom-file-input-text {
            color: #28a745;
            font-weight: bold;
        }

        .image-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            display: block;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 2px solid #28a745;
        }

        /* Ẩn nhãn khi có hình ảnh */
        .image-preview-wrapper img[style*="display: block;"]+.custom-file-input-label {
            display: none;
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
        $button_text = 'Thêm thiết bị';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.index') }}" class="btn btn-sm btn-dark rounded-pill ">
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
                            <!-- Ảnh thiết bị -->
                            <div class="col-12 mb-5 text-center">
                                <div class="image-preview-wrapper">
                                    <img id="preview-image"
                                        src="{{ old('current_image') ? asset('images/equipments/' . old('current_image')) : (isset($equipment) && $equipment->image ? asset('images/equipments/' . $equipment->image) : '') }}"
                                        alt="Hình ảnh thiết bị" class="image-preview"
                                        style="display: {{ isset($equipment->image) || old('current_image') ? 'block' : 'none' }}; cursor: pointer;" />
                                    <!-- Thêm cursor: pointer để hiển thị con trỏ khi hover -->

                                    <label for="material_image" class="custom-file-input-label">
                                        <span class="custom-file-input-text">Chọn ảnh</span>
                                    </label>
                                    <input type="file" id="material_image" name="material_image"
                                        class="custom-file-input" accept="image/*" style="display:none;">
                                    <input type="hidden" name="current_image"
                                        value="{{ old('current_image', isset($equipment->image) ? $equipment->image : '') }}">
                                </div>
                                @error('material_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tên thiết bị -->
                            <div class="col-12 fv-row mb-5">
                                <label class="required fw-bold mb-3">Tên thiết bị</label>
                                <input type="text"
                                    class="form-control form-control-sm rounded-pill border border-success" name="name"
                                    placeholder="Tên thiết bị.."
                                    value="{{ isset($currentEquipment) ? $currentEquipment->name : old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nhóm thiết bị -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fw-bold mb-3">Nhóm thiết bị</label>
                                <div class="d-flex align-items-center">
                                    <select name="equipment_type_code"
                                        class="form-select form-select-sm rounded-pill setupSelect2">
                                        <option value="">Chọn Nhóm thiết bị...</option>
                                        @foreach ($equipmentTypes as $type)
                                            <option value="{{ $type->code }}"
                                                {{ isset($currentEquipment) && $currentEquipment->equipment_type_code == $type->code ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_nvt_"
                                        title="Thêm Nhóm thiết bị">
                                        <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                    </span>
                                </div>
                                @error('equipment_type_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Đơn Vị Tính -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fw-bold mb-3">Đơn Vị Tính</label>
                                <div class="d-flex align-items-center">
                                    <select name="unit_code" class="form-select form-select-sm rounded-pill setupSelect2">
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
                                <label class="required fw-bold mb-3">Giá</label>
                                <input type="number"
                                    class="form-control form-control-sm rounded-pill border border-success" name="price"
                                    value="{{ old('price', isset($currentEquipment) ? $currentEquipment->price : '') }}"
                                    placeholder="Vui lòng nhập giá">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Ngày Hết Hạn -->
                            <div class="col-6 fv-row mb-5">
                                <label class=fw-bold mb-3">Ngày Hết Hạn (Nếu Có)</label>
                                <input type="date"
                                    class="form-control form-control-sm rounded-pill border border-success"
                                    name="expiry_date"
                                    value="{{ old('expiry_date', isset($currentEquipment) ? $currentEquipment->expiry_date : '') }}">
                                @error('expiry_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nhà Cung Cấp -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fw-bold mb-3">Nhà Cung Cấp</label>
                                <div class="d-flex align-items-center">
                                    <select name="supplier_code"
                                        class="form-select form-select-sm rounded-pill setupSelect2">
                                        <option value="">Chọn Nhà Cung Cấp...</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->code }}"
                                                {{ old('supplier_code', isset($currentEquipment) ? $currentEquipment->supplier_code : '') == $supplier->code ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_ncc"
                                        title="Thêm Nhà Cung Cấp">
                                        <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                    </span>

                                </div>
                                @error('supplier_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nước Sản Xuất -->
                            <div class="col-6 fv-row mb-5">
                                <label class="required fw-bold mb-3">Nước Sản Xuất</label>
                                <select name="country" class="form-select form-select-sm rounded-pill setupSelect2">
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
                                <label class="required fw-bold mb-3">Mô Tả</label>
                                <textarea name="description" cols="30" rows="10"
                                    class="form-control form-control-sm rounded-3 border border-success" placeholder="Thêm Mô Tả Cho thiết bị..">{{ old('description', isset($currentEquipment) ? $currentEquipment->description : '') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success btn-sm py-2 rounded-pill"
                            style="width: 120px; background-color: rgba(46, 204, 113, 0.8);">
                            <!-- Thay đổi màu và độ trong suốt tại đây -->
                            {{ $button_text }}
                        </button>
                    </div>

            </form>
        </div>
    </div>

    <!-- Modal Thêm Nhóm thiết bị -->
    <div class="modal fade" id="add_modal_nvt_" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Nhóm Thiết Bị</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('equipments.create_material_group_modal') }}" method="POST"
                    id="add-material-group-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="code" class="form-label">Mã Nhóm Thiết Bị</label>
                            <input type="text" class="form-control form-control-sm border-success rounded-pill"
                                id="code" disabled name="code" placeholder="Mã nhóm thiết bị được tạo tự động"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Tên Nhóm Thiết bị</label>
                            <input type="text" class="form-control form-control-sm border-success rounded-pill"
                                id="name" name="name" placeholder="Nhập tên nhóm thiết bị" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Mô Tả</label>
                            <textarea class="form-control form-control-sm border-success rounded-3" id="description" name="description"
                                rows="3" placeholder="Nhập mô tả"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Trạng Thái</label>
                            <select class="form-select form-select-sm border-success rounded-pill" id="status"
                                name="status" required>
                                <option value="1">Kích Hoạt</option>
                                <option value="0">Không Kích Hoạt</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm rounded-pill"
                            data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success btn-sm rounded-pill">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Đơn Vị Tính -->
    <div class="modal fade" id="add_modal_dvt_" tabindex="-1" aria-labelledby="addModalDVTLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                            <input type="text" class="form-control form-control-sm border-success rounded-pill"
                                id="unit_code" name="code" placeholder="Mã đơn vị tính được tạo tự động" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="unit_name" class="form-label">Tên Đơn Vị Tính</label>
                            <input type="text" class="form-control form-control-sm border-success rounded-pill"
                                id="unit_name" name="name" placeholder="Nhập tên đơn vị tính" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Mô Tả</label>
                            <textarea class="form-control form-control-sm border-success rounded-3" id="description" name="description"
                                rows="3" placeholder="Nhập mô tả"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" style="font-size: 10px"
                            data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success rounded-pill" style="font-size: 10px">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Thêm Nhà Cung Cấp -->
    <div class="modal fade" id="add_modal_ncc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="add_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="add_modalLabel">Thêm Nhà Cung Cấp</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    <div class="mb-3">
                        <label class="required er mb-2">Tên Nhà Cung Cấp</label>
                        <input type="text" class="form-control form-control-sm border border-success rounded-pill"
                            placeholder="Tên nhà cung cấp.." name="name" id="supplier_type_name" />
                        <div class="message_error" id="show-err-supplier-type"></div>
                    </div>
                </div>
                <div class="modal-body pt-0">
                    <div class="overflow-auto" style="max-height: 300px;">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr class="erer bg-success">
                                    <th class="ps-3" style="width: 70%;">Tên Nhà Cung Cấp</th>
                                    <th class="pe-3 text-center" style="width: 30%;">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="supplier-list">
                                @foreach ($AllSuppiler as $item)
                                    <tr class="hover-table pointer" id="supplier-{{ $item->code }}">
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal_supplier_type"
                                                onclick="setDeleteForm('{{ route('equipment_request.delete_supplier', $item->code) }}', '{{ $item->name }}')">
                                                <i class="fa fa-trash p-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-twitter" id="submit_supplier_type">Thêm</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Form xóa nhà cung cấp --}}
    <div class="modal fade" id="delete_modal_supplier_type" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Xóa Nhà Cung Cấp</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <h6 class="text-danger mb-4" id="delete-supplier-message">Bạn có chắc chắn muốn xóa nhà cung cấp này?
                    </h6>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-toggle="modal"
                        data-bs-target="#add_modal_ncc">Trở Lại</button>
                    <button type="button" class="btn btn-sm btn-danger px-4" id="confirm-delete-supplier">Xóa</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputFile = document.getElementById('material_image');
            const previewImage = document.getElementById('preview-image');

            // Khi click vào ảnh, kích hoạt input file
            previewImage.addEventListener('click', function() {
                inputFile.click(); // Mở cửa sổ chọn file
            });

            // Xử lý sự kiện thay đổi file
            inputFile.addEventListener('change', function(event) {
                const file = event.target.files[0]; // Lấy file đã chọn

                if (file) {
                    const reader = new FileReader(); // Tạo FileReader để đọc file
                    reader.onload = function(e) {
                        previewImage.src = e.target.result; // Đặt src cho thẻ img
                        previewImage.style.display = 'block'; // Hiển thị thẻ img
                    }
                    reader.readAsDataURL(file); // Đọc file dưới dạng URL
                }
            });
        });




        // Thêm nhà cung cấp
        document.getElementById('submit_supplier_type').addEventListener('click', function(event) {
            event.preventDefault();

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                let supplierTypeName = document.getElementById('supplier_type_name').value.trim();
                let equipment_error = document.getElementById('show-err-supplier-type');
                let existingSuppliers = Array.from(document.querySelectorAll(
                    '#supplier-list tr td:first-child')).map(td => td.textContent.trim());

                if (supplierTypeName === '') {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error.innerText = 'Vui lòng nhập tên nhà cung cấp';
                    supplierTypeName.focus();
                }

                if (existingSuppliers.includes(supplierTypeName)) {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error.innerText = 'Tên nhà cung cấp đã tồn tại';
                    supplierTypeName.focus();
                }

                equipment_error.innerText = '';

                let formData = new FormData();
                formData.append('name', supplierTypeName);

                fetch('{{ route('equipment_request.create_import') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Thêm thiết bị vào danh sách trong bảng mà không cần tải lại trang
                            let tableBodySupplier = document.getElementById('supplier-list');
                            let newRowSupplier = document.createElement('tr');
                            newRowSupplier.id = `supplier-${data.code}`;
                            newRowSupplier.className = `pointer`;

                            newRowSupplier.innerHTML =
                                `
                            <td>${data.name}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#delete_modal_supplier_type"
                                    onclick="setDeleteForm('{{ route('equipment_request.delete_supplier', '') }}/` +
                                data.code + `', '` + data.name + `')">
                                    <i class="fa fa-trash p-0"></i>
                                </button>
                            </td>
                            `;

                            tableBodySupplier.prepend(newRowSupplier);

                            let selectOptionSupplier = document.getElementById('supplier_code');
                            let newOption = document.createElement('option');
                            newOption.value = data.code;
                            newOption.textContent = data.name;
                            newOption.id = `option_supplier_${data.code}`;

                            let defaultOption = selectOptionSupplier.querySelector('option[value="0"]');
                            selectOptionSupplier.insertBefore(newOption, defaultOption
                                .nextSibling);

                            toastr.success("Đã thêm nhà cung cấp");

                            document.getElementById('supplier_type_name').value = "";
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('loading-overlay').style.display = 'none';
                        this.disabled = false;
                    });

                document.getElementById('loading').style.display = 'none';
                document.getElementById('loading-overlay').style.display = 'none';
                this.disabled = false;
            }, 1000);
        });

        // Xóa nhà cung cấp
        let deleteActionUrl = '';

        function setDeleteForm(actionUrl, supplierName) {
            deleteActionUrl = actionUrl;
            document.getElementById('delete-supplier-message').innerText =
                `Bạn có chắc chắn muốn xóa nhà cung cấp "${supplierName}" này?`;
        }

        // Xác nhận xóa nhà cung cấp
        document.getElementById('confirm-delete-supplier').addEventListener('click', function() {

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                fetch(deleteActionUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`supplier-${data.supplier.code}`).remove();
                            // Đảm bảo đóng modal sau khi xóa thành công
                            $('#delete_modal_supplier_type').modal('hide');
                            // Đảm bảo modal thêm nhà cung cấp được ẩn
                            $('#add_modal_ncc').modal('hide');
                            document.getElementById(`option_supplier_${data.supplier.code}`).classList
                                .add('d-none');
                            toastr.success("Đã xóa nhà cung cấp");
                        } else {
                            toastr.error(
                                "Không thể xóa nhà cung cấp này vì đã có giao dịch trong hệ thống");
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('loading-overlay').style.display = 'none';
                        this.disabled = false;
                    });
            }, 1000);
        });


        function changeEquipment() {
            const selectedValue = document.getElementById('equipment').value;
            const errorMessage = document.getElementById('equipment_error');

            if (selectedValue !== "") {
                errorMessage.innerText = '';
            }
        }

        function changeEquipmentQuantity() {
            const quantityValue = document.getElementById('quantity').value;
            const errorMessageQuantity = document.getElementById('quantity_error');

            if (quantityValue > 0) {
                errorMessageQuantity.innerText = '';
            }
        }

        function changeSupplier() {
            const selectedValue2 = document.getElementById('supplier_code').value;
            const errorMessage2 = document.getElementById('supplier_code_error');

            if (selectedValue2 !== "") {
                errorMessage2.innerText = '';
            }
        }
    </script>
@endsection
