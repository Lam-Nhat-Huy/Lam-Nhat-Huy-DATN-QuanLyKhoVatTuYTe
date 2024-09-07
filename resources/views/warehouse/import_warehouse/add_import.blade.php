@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <!-- Phần form để form thêm vật tư -->
    <form action="{{ route('warehouse.store_import') }}" method="post">
        @csrf
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control me-3" placeholder="Nhập tên hoặc mã hàng hoá (F2)"
                            aria-label="Search">

                        <button type="button" class="btn btn-sm btn-success me-3" data-bs-toggle="modal"
                            data-bs-target="#importExcelModal">Nhập Excel</button>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="bg-white p-3 rounded border shadow-sm">
                        @if (true)
                            <div class="row mb-3">

                                <div class="col-6 mb-4">
                                    <label for="unit_price" class="required form-label mb-2">Tên vật tư</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="material_name" name="material_name" placeholder="Nhập tên vật tư">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="unit_price" class="required form-label mb-2">Giá nhập</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="unit_price" name="unit_price" placeholder="Nhập đơn giá">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="quantity" class="required form-label mb-2">Số lượng</label>
                                    <input type="number"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="quantity" name="quantity" placeholder="Nhập số lượng">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="discount_rate" class="required form-label mb-2">Chiết khấu
                                        (%)</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="discount_rate" name="discount_rate" placeholder="Nhập chiết khấu (%)">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="invoice_number" class="required form-label mb-2">Số hóa đơn</label>
                                    <input type="number"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="invoice_number" name="invoice_number" placeholder="Nhập số hóa đơn">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="invoice_symbol" class="required form-label mb-2">Kí hiệu hóa đơn
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="invoice_symbol" name="invoice_symbol" placeholder="Nhập kí hiệu hóa đơn">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="vat_rate" class="required form-label mb-2">VAT (%)</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="vat_rate" name="vat_rate" placeholder="Nhập VAT (%)">
                                </div>


                                <div class="col-6 mb-4">
                                    <label for="batch_number" class="required form-label mb-2">Số lô</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="batch_number" name="batch_number" placeholder="Nhập số lô">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="product_date" class="required form-label mb-2">Ngày sản
                                        xuất</label>
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
                            </div>
                        @else
                            <div id="alertMessage" class="alert alert-warning text-center mb-3" role="alert">
                                Chưa có hàng hoá nào! Hãy nhập tên hoặc mã hàng vào ô tìm kiếm để tìm hàng cần nhập
                            </div>
                        @endif
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                        <h6 class="mb-3 fw-bold text-primary">Thông tin phiếu nhập</h6>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="supplierName" class="form-label fw-semibold me-2 mb-0"
                                style="white-space: nowrap;">Nhà cung cấp</label>
                            <select id="supplierName" class="form-select setupSelect2 flex-grow-1"
                                style="max-width: 70%; height: 40px;">
                                <option value="">Chọn nhà cung cấp</option>
                                <option value="supplier1">Nhà cung cấp 1</option>
                                <option value="supplier2">Nhà cung cấp 2</option>
                            </select>

                            <button type="button"
                                class="btn btn-primary ms-2 d-flex justify-content-center align-items-center"
                                data-bs-toggle="modal" data-bs-target="#addSupplierModal"
                                style="width: 40px; height: 28px; background-color: #007bff; border-color: #007bff; padding: 0;">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>



                        <div class="mb-3">
                            <label for="date" class="form-label fw-semibold">Ngày nhập</label>
                            <input type="date" id="date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label fw-semibold">Ghi chú</label>
                            <textarea id="notes" class="form-control" placeholder="Nhập ghi chú..." rows="3"></textarea>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-sm btn-danger w-100">Thêm vật tư</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Danh sách vật tư đã thêm -->
    <form action="/home" method="post">
        <div class="row mt-1">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4 header-container">
                    <h3 class="mb-0 header-text">Danh sách vật tư y tế</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Tên vật tư</th>
                                <th>Số lượng</th>
                                <th>Giá nhập</th>
                                <th>Số lô</th>
                                <th>Hạn dùng</th>
                                <th>CK(%)</th>
                                <th>VAT(%)</th>
                                <th>Trước VAT</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Khẩu trang y tế</td>
                                <td>500</td>
                                <td>1,000</td>
                                <td>KT001</td>
                                <td>2025-06-30</td>
                                <td>0</td>
                                <td>5</td>
                                <td>500,000</td>
                                <td>525,000</td>
                            </tr>
                            <tr>
                                <td>Găng tay phẫu thuật</td>
                                <td>300</td>
                                <td>3,500</td>
                                <td>GT123</td>
                                <td>2024-08-15</td>
                                <td>2</td>
                                <td>10</td>
                                <td>1,029,000</td>
                                <td>1,131,900</td>
                            </tr>
                            <tr>
                                <td>Bộ dụng cụ phẫu thuật</td>
                                <td>50</td>
                                <td>20,000</td>
                                <td>BD456</td>
                                <td>2026-01-20</td>
                                <td>1</td>
                                <td>8</td>
                                <td>990,000</td>
                                <td>1,069,200</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                    <h6 class="mb-3 fw-bold text-primary">Thông tin thanh toán</h6>
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
                        <h6 class="mb-2 fw-bold text-primary">Phương thức thanh toán</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cashPayment"
                                    value="cash">
                                <label class="form-check-label" for="cashPayment">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>Tiền mặt
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer"
                                    value="transfer">
                                <label class="form-check-label" for="bankTransfer">
                                    <i class="fas fa-university text-primary me-2"></i>Chuyển khoản
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button type="submit" class="btn btn-sm btn-success w-100">Tạo phiếu nhập</button>
                </div>
            </div>
        </div>
    </form>


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
                        <label for="excelFile" class="form-label fw-semibold text-secondary">
                            <i class="fa-solid fa-file-excel fa-2x text-success mb-3"></i><br>
                            <span>Kéo thả hoặc click vào để chọn file Excel</span>
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
                    <!-- Supplier Form -->
                    <form id="supplierForm">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="supplierNameInput" class="form-label fw-semibold text-secondary">Tên nhà cung
                                    cấp*</label>
                                <input type="text" id="supplierNameInput" class="form-control border rounded-3"
                                    placeholder="Nhập tên nhà cung cấp" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="supplierPhone" class="form-label fw-semibold text-secondary">Số điện
                                    thoại</label>
                                <input type="text" id="supplierPhone" class="form-control border rounded-3"
                                    placeholder="Số điện thoại">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="supplierAddress" class="form-label fw-semibold text-secondary">Địa chỉ</label>
                                <input type="text" id="supplierAddress" class="form-control border rounded-3"
                                    placeholder="Địa chỉ">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="contactPerson" class="form-label fw-semibold text-secondary">Người liên
                                    hệ</label>
                                <input type="text" id="contactPerson" class="form-control border rounded-3"
                                    placeholder="Người liên hệ">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold text-secondary">Ghi chú</label>
                            <textarea id="notes" class="form-control border rounded-3" placeholder="Ghi chú"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" form="supplierForm">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
@endsection
