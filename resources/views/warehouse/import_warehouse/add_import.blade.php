@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .d-flex.align-items-center>* {
            flex-shrink: 0;
        }

        .setupSelect2 {
            max-width: 70%;
        }

        .btn-outline-primary {
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .material-form-container {
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }

        .form-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        .material-input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            color: #333;
            transition: border-color 0.3s;
        }

        .material-input:focus {
            border-color: #007bff;
            background-color: #fff;
            outline: none;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn {
            padding: 5px 15px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cancel-btn {
            color: #333;
            background: none;
            margin-right: 10px;
        }

        .save-continue-btn {
            color: #007bff;
            background: none;
            margin-right: 10px;
        }

        .save-btn {
            color: #007bff;
            background: none;
        }

        .btn:hover {
            opacity: 0.7;
        }
    </style>
@endsection

@section('title')
    Nhập Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Nhập Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark" style="font-size: 10px;">
                    <i class="fa fa-arrow-left me-1" style="font-size: 10px;"></i>Trở Lại
                </a>
            </div>
        </div>

        {{-- FORM 1 - Thêm vật tư --}}
        <form action="" method="post">
            @csrf
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3 mt-3">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="supplier_code" class="form-label fw-semibold"
                                        style="white-space: nowrap;">Nhà cung cấp</label>
                                    <div class="d-flex align-items-center">
                                        <select id="supplier_code"
                                            class="form-control form-control-sm form-control-solid border border-success">
                                            <option value="">Chọn nhà cung cấp</option>
                                            <option value="1">Nhà cung cấp 1</option>
                                            <option value="2">Nhà cung cấp 2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="date" class="form-label fw-semibold">Ngày nhập</label>
                                    <input type="date" id="receipt_at"
                                        class="form-control form-control-sm form-control-solid border border-success">
                                </div>

                                <input type="hidden" id="created_by" value="1">

                                <div class="mb-3 col-6">
                                    <label for="invoice_number" class="required form-label mb-2">Số hóa đơn</label>
                                    <input type="number"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="invoice_number" name="invoice_number" placeholder="Nhập số hóa đơn">
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="invoice_symbol" class="required form-label mb-2">Kí hiệu hóa đơn</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="invoice_symbol" name="invoice_symbol" placeholder="Nhập kí hiệu hóa đơn">
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="note" class="form-label fw-semibold">Ghi chú</label>
                                    <textarea id="note" class="form-control form-control-sm form-control-solid border border-success"
                                        placeholder="Nhập ghi chú..." rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                            <div class="row mb-3">
                                <div class="mb-4 col-6">
                                    <label for="material_code" class="form-label fw-semibold"
                                        style="white-space: nowrap;">Tên vật tư</label>
                                    <div class="d-flex align-items-center">
                                        <select id="material_code"
                                            class="form-control form-control-sm form-control-solid border border-success">
                                            <option value="">Chọn vật tư</option>
                                            <option value="1">Canxium</option>
                                            <option value="2">Panadol</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="batch_code" class="required form-label mb-2">Số lô</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="batch_code" name="batch_code" placeholder="Nhập số lô">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="product_date" class="required form-label mb-2">Ngày sản xuất</label>
                                    <input type="date"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="product_date" name="product_date">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="expiry_date" class="form-label mb-2">Hạn sử dụng</label>
                                    <input type="date"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="expiry_date" name="expiry_date">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="price" class="required form-label mb-2">Giá nhập</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="price" name="price" placeholder="Nhập đơn giá">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="quantity" class="required form-label mb-2">Số lượng</label>
                                    <input type="number"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="quantity" name="quantity" placeholder="Nhập số lượng">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="discount_rate" class="required form-label mb-2">Chiết khấu (%)</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="discount_rate" name="discount_rate" placeholder="Nhập chiết khấu (%)">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="VAT" class="required form-label mb-2">VAT (%)</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="VAT" name="VAT" placeholder="Nhập VAT (%)">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#importExcelModal" style="font-size: 10px;">Nhập Excel</button>
                                    <button type="button" class="btn btn-sm btn-danger" style="font-size: 10px;"
                                        onclick="addMaterial()">Thêm vật tư</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- FORM 2 - Danh sách vật tư đã thêm --}}
        <form action="{{ route('warehouse.store_import') }}" method="post" class="mt-2">
            @csrf
            <div class="row container">
                <div class="col-9">
                    <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3 ">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="font-size: 10px;" class="ps-4">Tên vật tư</th>
                                            <th style="font-size: 10px;">Nhà cung cấp</th>
                                            <th style="font-size: 10px;">Số lượng</th>
                                            <th style="font-size: 10px;">Giá nhập</th>
                                            <th style="font-size: 10px;">Số lô</th>
                                            <th style="font-size: 10px;">Hạn dùng</th>
                                            <th style="font-size: 10px;">CK(%)</th>
                                            <th style="font-size: 10px;">VAT(%)</th>
                                            <th style="font-size: 10px;" class="pe-3">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody id="materialList">
                                        {{-- Thông tin sau khi được thêm vật tư từ FORM 1 sẽ được hiển thị ở đây --}}
                                        <input type="hidden" id="materialData" name="materialData">

                                        <tr id="no-material-alert">
                                            <td colspan="12" class="text-center pe-0 px-0"
                                                style="box-shadow: none !important;">
                                                <div class="alert alert-warning" role="alert">
                                                    Chưa có vật tư nào được thêm vào danh sách.
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 pe-0">
                    <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                        <h6 class="mb-3 fw-bold text-primary">THÔNG TIN CHI TIẾT</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Tổng chiết khấu</span>
                            <span class="fw-semibold text-danger">0₫</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Tổng VAT</span>
                            <span class="fw-semibold text-danger">0₫</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Tổng cộng</span>
                            <span class="fw-semibold text-danger">0₫</span>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <h6 class="mb-3 fw-bold text-primary">THANH TOÁN</h6>
                            <div class="form-check my-3">
                                <input class="form-check-input mt-1" type="radio" name="paymentMethod"
                                    id="cashPayment" value="cash">
                                <label class="form-check-label" for="cashPayment">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>Tiền mặt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio" name="paymentMethod"
                                    id="bankTransfer" value="transfer">
                                <label class="form-check-label" for="bankTransfer">
                                    <i class="fas fa-university text-primary me-2"></i>Chuyển khoản
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-sm btn-success w-100" onclick="submitMaterials()">Tạo phiếu
                            nhập</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal nhập excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-primary" id="importExcelModalLabel">Nhập Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Notice Section -->
                    <div class="alert alert-warning rounded-3 p-3 mb-4">
                        <p class="mb-1">
                            Tải về file mẫu: <a href="#" class="text-decoration-none text-primary">Excel
                                2003</a>
                            hoặc
                            <a href="#" class="text-decoration-none text-primary">phiên bản khác cao hơn</a>
                        </p>
                        <p class="fw-bold text-danger mb-2">Lưu ý:</p>
                        <ul class="mb-0 text-muted">
                            <li>Hệ thống chỉ hỗ trợ tối đa <strong>500</strong> hàng hóa cho mỗi lần nhập dữ liệu từ
                                file
                                excel.</li>
                            <li>Trong trường hợp file Excel có hàng hóa chưa hợp lệ, bạn vui lòng chỉnh sửa các dòng bị
                                lỗi
                                theo hướng dẫn và thực hiện lại.</li>
                            <li>Đối với hàng hóa không quản lý Serial, số lượng phải lớn hơn 0. Đối với hàng hóa quản lý
                                Serial, Serial phải có định dạng cho phép (a-z, 0-9, ",", " ").</li>
                            <li>Giá nhập, giá bán đều phải lớn hơn hoặc bằng 0.</li>
                            <li>Mỗi hàng hóa chỉ được liệt kê ở 1 dòng duy nhất và Serial phải là duy nhất, không trùng
                                lặp
                                và chưa tồn tại trong hệ thống.</li>
                            <li>Để nhập kho cho hàng sản xuất định lượng, vui lòng vào menu Sản xuất -> tạo phiếu sản
                                xuất
                                để hệ thống ghi nhận tồn kho chính xác hơn.</li>
                        </ul>
                    </div>

                    <!-- File Upload Section -->
                    <div class="border border-2 rounded-3 p-4 text-center bg-light" style="border-style: dashed;">
                        <label for="excelFile" class="form-label fw-semibold pointer">
                            <i class="fa-solid fa-file-excel fa-2x text-success mb-3"></i><br>
                            <span class="text-dark">Kéo thả hoặc click vào để chọn file Excel</span>
                        </label>
                        <input type="file" id="excelFile" class="form-control d-none" accept=".xls,.xlsx">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Tải lên</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm nhà cung cấp -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 shadow-sm border-0">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold text-dark" id="addSupplierModalLabel">Tạo Nhà Cung Cấp</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label for="supplier_codeInput" class="form-label fw-semibold">Tên nhà cung
                                    cấp*</label>
                                <input type="text" id="supplier_codeInput"
                                    class="form-control form-control-sm border border-success"
                                    placeholder="Nhập tên nhà cung cấp">
                            </div>
                            <div class="col-6 mb-4">
                                <label for="supplierPhone" class="form-label fw-semibold">Số điện
                                    thoại</label>
                                <input type="text" id="supplierPhone"
                                    class="form-control form-control-sm border border-success"
                                    placeholder="Số điện thoại">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label for="supplierAddress" class="form-label fw-semibold">Địa chỉ</label>
                                <input type="text" id="supplierAddress"
                                    class="form-control form-control-sm border border-success" placeholder="Địa chỉ">
                            </div>
                            <div class="col-6 mb-4">
                                <label for="contactPerson" class="form-label fw-semibold">Người liên
                                    hệ</label>
                                <input type="text" id="contactPerson"
                                    class="form-control form-control-sm border border-success"
                                    placeholder="Người liên hệ">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">Ghi chú</label>
                            <textarea id="notes" class="form-control form-control-sm border border-success" placeholder="Ghi chú"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-sm btn-twitter px-4" form="supplierForm">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let materialData = [];

        function addMaterial() {
            const material_code = document.getElementById('material_code').value;
            const supplier_code = document.getElementById('supplier_code').value;
            const note = document.getElementById('note').value; // Sẽ không hiển thị nhưng vẫn lưu
            const receipt_at = document.getElementById('receipt_at').value; // Sẽ không hiển thị nhưng vẫn lưu
            const created_by = document.getElementById('created_by').value;
            const batch_code = document.getElementById('batch_code').value;
            const product_date = document.getElementById('product_date').value;
            const expiry_date = document.getElementById('expiry_date').value;
            const price = document.getElementById('price').value;
            const quantity = document.getElementById('quantity').value;
            const discount = document.getElementById('discount_rate').value;
            const VAT = document.getElementById('VAT').value;

            if (!material_code || !batch_code || !product_date || !price || !quantity) {
                alert('Vui lòng nhập đầy đủ thông tin.');
                return;
            }

            const totalPrice = price * quantity * (1 - discount / 100) * (1 + VAT / 100);

            // Lưu dữ liệu vào mảng
            materialData.push({
                material_code,
                supplier_code,
                note,
                receipt_at,
                created_by,
                quantity,
                price,
                batch_code,
                expiry_date,
                quantity,
                discount,
                VAT,
                totalPrice: totalPrice.toFixed(2)
            });

            // Chỉ hiển thị những trường cần thiết trong bảng
            const tableBody = document.getElementById('materialList');
            if (tableBody) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${material_code}</td>
                    <td>${supplier_code}</td>
                    <td>${quantity}</td>
                    <td>${price}</td>
                    <td>${batch_code}</td>
                    <td>${expiry_date}</td>
                    <td>${discount}</td>
                    <td>${VAT}</td>
                    <td>${totalPrice.toFixed(2)}₫</td>
                `;
                tableBody.appendChild(row);
            } else {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${material_code}</td>
                    <td>${supplier_code}</td>
                    <td>${quantity}</td>
                    <td>${price}</td>
                    <td>${batch_code}</td>
                    <td>${expiry_date}</td>
                    <td>${discount}</td>
                    <td>${VAT}</td>
                    <td>${totalPrice.toFixed(2)}₫</td>
                `;
                tableBody.appendChild(row);
            }

            // Reset các trường input sau khi thêm
            document.getElementById('material_code').value = '';
            document.getElementById('supplier_code').value = '';
            document.getElementById('note').value = '';
            document.getElementById('receipt_at').value = '';
            document.getElementById('created_by').value = '';
            document.getElementById('batch_code').value = '';
            document.getElementById('product_date').value = '';
            document.getElementById('expiry_date').value = '';
            document.getElementById('price').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('discount_rate').value = '';
            document.getElementById('VAT').value = '';
        }

        function submitMaterials() {
            // Chuyển dữ liệu sang JSON và gán vào input ẩn để submit
            document.getElementById('materialData').value = JSON.stringify(materialData);
        }
    </script>
@endsection
