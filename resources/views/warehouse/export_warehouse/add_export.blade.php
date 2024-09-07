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

        .col-6 {
            display: flex;
            flex-direction: column;
        }

        #batch_info .form-control {
            max-width: 100px;
            text-align: right;
        }

        /* Loại bỏ mũi tên trên các trình duyệt WebKit (Chrome, Safari, Edge) */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Loại bỏ mũi tên trên Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('title')
    Tạo Phiếu Xuất Kho
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
                        <div class="row mb-3">
                            <div class="col-12 mb-2">
                                <label for="product_select" class="required form-label mb-2">Tên vật tư</label>
                                <select
                                    class="form-control form-select form-control-sm form-control-solid border border-success"
                                    id="product_select" name="product_select" style="width: 100%;">
                                    <option value="" selected disabled>Chọn vật tư</option>
                                </select>
                            </div>


                            {{-- Hiển thị danh sách vật tư được chọn  --}}
                            <div class="col-md-12 mt-3">
                                <h6>Danh sách lô:</h6>
                                <ul id="batch_info" class="list-group"></ul>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                        <h6 class="mb-3 fw-bold text-primary">Thông tin phiếu xuất</h6>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="supplierName" class="form-label fw-semibold me-2 mb-0"
                                style="white-space: nowrap;">Loại xuất</label>
                            <select id="supplierName" class="form-select setupSelect2 flex-grow-1"
                                style="max-width: 70%; height: 40px;">
                                <option value="">Chọn loại xuất</option>
                                <option value="supplier1">Xuất cho bệnh viện</option>
                                <option value="supplier2">Xuất bán sỉ</option>
                            </select>

                            <button type="button"
                                class="btn btn-primary ms-2 d-flex justify-content-center align-items-center"
                                data-bs-toggle="modal" data-bs-target="#addSupplierModal"
                                style="width: 40px; height: 28px; background-color: #007bff; border-color: #007bff; padding: 0;">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label fw-semibold">Ngày xuất</label>
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
                @if (true)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>MHĐ</th>
                                    <th>Tên vật tư</th>
                                    <th>SL</th>
                                    <th>Ngày xuất</th>
                                    <th>HSD</th>
                                    <th>Loại xuất</th>
                                    <th>Thành tiền</th>
                                    <th>Người xuất</th>
                                    <th>Đơn vị nhận</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ví dụ dữ liệu hiển thị -->
                                <tr>
                                    <td>HD001</td>
                                    <td>Máy đo huyết áp</td>
                                    <td>10</td>
                                    <td>2024-09-05</td>
                                    <td>2026-09-05</td>
                                    <td>Xuất bán</td>
                                    <td>20,000,000 VND</td>
                                    <td>Nguyễn Văn A</td>
                                    <td>Bệnh viện X</td>
                                </tr>
                                <tr>
                                    <td>HD002</td>
                                    <td>Bơm tiêm y tế</td>
                                    <td>1000</td>
                                    <td>2024-09-03</td>
                                    <td>2025-09-03</td>
                                    <td>Xuất viện trợ</td>
                                    <td>5,000,000 VND</td>
                                    <td>Trần Văn B</td>
                                    <td>Trạm Y tế Y</td>
                                </tr>
                                <tr>
                                    <td>HD003</td>
                                    <td>Bông băng y tế</td>
                                    <td>500</td>
                                    <td>2024-08-25</td>
                                    <td>2025-08-25</td>
                                    <td>Xuất bán</td>
                                    <td>2,500,000 VND</td>
                                    <td>Lê Thị C</td>
                                    <td>Bệnh viện Z</td>
                                </tr>
                                <!-- Dữ liệu sẽ được load từ server -->
                            </tbody>
                        </table>
                    </div>
                @else
                    <div id="alertMessage" class="alert alert-warning text-center mb-3" role="alert">
                        Chưa có hàng hoá nào! Hãy nhập tên hoặc mã hàng vào ô tìm kiếm để tìm hàng cần nhập
                    </div>
                @endif


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

                    <button type="submit" class="btn btn-sm btn-success w-100">Tạo phiếu xuất</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

    <script>
        const materials = [{
                name: 'Canxium (Hộp 6 vỉ x 30 viên)',
                batches: [{
                        batch: 'C123',
                        quantity: 10,
                        expiry: '19-12-2023'
                    },
                    {
                        batch: 'C124',
                        quantity: 0,
                        expiry: '20-12-2023'
                    },

                ]
            },
            {
                name: 'Paracetamol (Hộp 10 vỉ x 20 viên)',
                batches: [{
                        batch: 'P125',
                        quantity: 20,
                        expiry: '10-11-2024'
                    },
                    {
                        batch: 'P126',
                        quantity: 15,
                        expiry: '12-11-2024'
                    }
                ]
            }
        ];

        const productSelect = document.getElementById('product_select');
        materials.forEach((material, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = material.name;
            productSelect.appendChild(option);
        });

        productSelect.addEventListener('change', (e) => {
            const selectedIndex = e.target.value;
            const batchInfoContainer = document.getElementById('batch_info');
            batchInfoContainer.innerHTML = ''; // Clear previous batch information

            if (selectedIndex !== '') {
                const selectedMaterial = materials[selectedIndex];

                selectedMaterial.batches.forEach((batch, batchIndex) => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between',
                        'align-items-center', );

                    // Tạo phần tử span để hiển thị số lô, tồn kho, hạn sử dụng bên trái
                    const batchInfo = document.createElement('span');
                    batchInfo.textContent =
                        `Số lô: ${batch.batch} (Tồn: ${batch.quantity}) (HSD: ${batch.expiry})`;

                    // Tạo ô input để nhập số lượng xuất bên phải
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.name = `quantity_${batch.batch}`;
                    quantityInput.placeholder = 'Số lượng';
                    quantityInput.min = 0;
                    quantityInput.max = batch.quantity;
                    quantityInput.classList.add('form-control',
                        'form-control-sm', 'w-100');
                    quantityInput.classList.add('py-2', 'pe-2')

                    // Nếu tồn kho <= 0, đánh dấu đỏ và disable ô input
                    if (batch.quantity <= 0) {
                        batchInfo.classList.add('text-danger');
                        quantityInput.disabled = true;
                        quantityInput.placeholder = 'Hết hàng';
                    }

                    // Thêm batchInfo và quantityInput vào listItem
                    listItem.appendChild(batchInfo);
                    listItem.appendChild(quantityInput);

                    // Thêm listItem vào danh sách batch_info
                    batchInfoContainer.appendChild(listItem);
                });
            }
        });
    </script>
@endsection
