@extends('master_layout.layout')

@section('styles')
    <style>
        /* Ẩn nhãn khi có hình ảnh */
        .image-preview-wrapper img[style*="display: block;"]+.custom-file-input-label {
            display: none;
        }

        .image-preview-wrapper {
            display: inline-block;
        }

        .custom-file-input {
            opacity: 0;
            z-index: 2;
            cursor: pointer;
        }

        .custom-file-input-label {
            border-radius: 10px;
            display: flex;
            border: 2px dashed #28a745;
            padding: 5px;
            width: 250px;
            text-align: center;
            height: 250px;
            cursor: pointer;
            z-index: 1;
            justify-content: center;
            align-items: center;
        }

        .custom-file-input-label:hover {
            background-color: #e9ecef;
            border-color: #28a745;
        }

        .custom-file-input-text {
            color: #28a745;
            font-weight: bold;
        }

        .image-preview {
            width: 250px;
            height: 250px;
            display: block;
            border-radius: 10px;
            border: 1px solid #28a745;
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
    <script>
        document.getElementById('random-btn').addEventListener('click', function() {
            // Hàm tạo dữ liệu ngẫu nhiên
            function generateRandomData() {
                const randomNames = ["Công Ty TNHH ABC", "Công Ty CP XYZ", "Doanh Nghiệp DEF", "Cửa Hàng GHI"];
                const randomContacts = ["Nguyễn Văn A", "Trần Thị B", "Lê Văn C", "Phạm Thị D"];
                const randomTaxCodes = Array.from({
                    length: 5
                }, () => Math.floor(100000000 + Math.random() * 900000000).toString());
                const randomPhones = Array.from({
                    length: 5
                }, () => "0" + Math.floor(100000000 + Math.random() * 900000000).toString());
                const randomEmails = ["example@abc.com", "info@xyz.com", "contact@def.vn", "support@ghi.vn"];
                const randomAddresses = [
                    "123 Đường Lê Lợi, Quận 1, TP.HCM",
                    "456 Đường Nguyễn Huệ, Quận 3, TP.HCM",
                    "789 Đường Trần Hưng Đạo, Quận 5, TP.HCM",
                    "101 Đường Phạm Ngũ Lão, Quận 10, TP.HCM"
                ];

                return {
                    name: randomNames[Math.floor(Math.random() * randomNames.length)],
                    contact_name: randomContacts[Math.floor(Math.random() * randomContacts.length)],
                    tax_code: randomTaxCodes[Math.floor(Math.random() * randomTaxCodes.length)],
                    phone: randomPhones[Math.floor(Math.random() * randomPhones.length)],
                    email: randomEmails[Math.floor(Math.random() * randomEmails.length)],
                    address: randomAddresses[Math.floor(Math.random() * randomAddresses.length)],
                };
            }

            // Sinh dữ liệu ngẫu nhiên
            const randomData = generateRandomData();

            // Điền dữ liệu vào các trường trong form
            document.querySelector('input[name="name"]').value = randomData.name;
            document.querySelector('input[name="contact_name"]').value = randomData.contact_name;
            document.querySelector('input[name="tax_code"]').value = randomData.tax_code;
            document.querySelector('input[name="phone"]').value = randomData.phone;
            document.querySelector('input[name="email"]').value = randomData.email;
            document.querySelector('input[name="address"]').value = randomData.address;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const inputFile = document.getElementById('supplier_logo');
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
    </script>
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
                <button type="button" id="random-btn" class="btn rounded-pill btn-sm btn-info me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-random me-1"></i>
                        Dữ Liệu Mẫu
                    </span>
                </button>
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
                        <!-- Ảnh thiết bị -->
                        <div class="col-md-3 mb-5">
                            <div class="required">Logo</div>
                            <div class="image-preview-wrapper mt-3">
                                <img id="preview-image"
                                    src="{{ old('current_image') ? asset('storage/' . old('current_image')) : (!empty($firstSupplier) && $firstSupplier->image ? asset('storage/' . $firstSupplier->image) : '') }}"
                                    alt="Hình ảnh thiết bị" class="image-preview"
                                    style="display: {{ !empty($firstSupplier->image) || old('current_image') ? 'block' : 'none' }}; cursor: pointer;" />
                                <!-- Thêm cursor: pointer để hiển thị con trỏ khi hover -->

                                <label for="supplier_logo" class="custom-file-input-label">
                                    <span class="custom-file-input-text"><i class="fa fa-upload mb-1 me-2"
                                            style="color: #28a745;"></i>Tải ảnh lên</span>
                                </label>

                                <input type="file" id="supplier_logo" name="supplier_logo" onchange="changeImage()"
                                    class="custom-file-input" value="{{ old('current_image') }}" accept="image/*"
                                    style="display: none;">
                            </div>
                            @error('supplier_logo')
                                <div class="message_error" id="supplier_logo_error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-9">

                            <div class="row mb-5">
                                <div class="mb-5 col-6">

                                    <label class="required fs-6 fw-bold mb-3">Tên Nhà Cung Cấp</label>

                                    <input type="text"
                                        class="form-control form-control-sm border border-success rounded-pill"
                                        placeholder="Tên nhà cung cấp.." name="name"
                                        value="{{ !empty($firstSupplier->name) ? $firstSupplier->name : old('name') }}" />
                                    @error('name')
                                        <div class="message_error">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="mb-5 col-6">

                                    <label class="required fs-6 fw-bold mb-3">Người Đại Diện</label>

                                    <input type="text"
                                        class="form-control form-control-sm border border-success rounded-pill"
                                        placeholder="Tên người đại diện.." name="contact_name"
                                        value="{{ !empty($firstSupplier->contact_name) ? $firstSupplier->contact_name : old('contact_name') }}" />
                                    @error('contact_name')
                                        <div class="message_error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5 col-6">

                                    <label class="required fs-6 fw-bold mb-3">Mã Số Thuế</label>

                                    <input type="text"
                                        class="form-control form-control-sm border border-success rounded-pill"
                                        placeholder="Mã số thuế.." name="tax_code"
                                        value="{{ !empty($firstSupplier->tax_code) ? $firstSupplier->tax_code : old('tax_code') }}" />
                                    @error('tax_code')
                                        <div class="message_error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5 col-6">

                                    <label class="required fs-6 fw-bold mb-3">Số Điện Thoại</label>

                                    <input type="number"
                                        class="form-control form-control-sm border border-success rounded-pill"
                                        placeholder="Số điện thoại.." name="phone"
                                        value="{{ !empty($firstSupplier->phone) ? $firstSupplier->phone : old('phone') }}" />
                                    @error('phone')
                                        <div class="message_error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5 col-6">

                                    <label class="required fs-6 fw-bold mb-3">Email</label>

                                    <input type="email"
                                        class="form-control form-control-sm border border-success rounded-pill"
                                        placeholder="Email.." name="email"
                                        value="{{ !empty($firstSupplier->email) ? $firstSupplier->email : old('email') }}" />
                                    @error('email')
                                        <div class="message_error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5 col-6">

                                    <label class="required fs-6 fw-bold mb-3">Địa Chỉ</label>

                                    <input type="text"
                                        class="form-control form-control-sm border border-success rounded-pill"
                                        placeholder="Địa chỉ.." name="address"
                                        value="{{ !empty($firstSupplier->address) ? $firstSupplier->address : old('address   ') }}" />
                                    @error('address')
                                        <div class="message_error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
