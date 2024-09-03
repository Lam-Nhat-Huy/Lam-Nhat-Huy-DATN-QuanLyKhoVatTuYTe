@extends('master_layout.layout')

@section('title')
    Tạo Phiếu Kiểm Kho
@endsection

@section('styles')
    <style>
        .autocomplete-items {
            position: absolute;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 0.375rem;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f3f5;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .autocomplete-items div:hover {
            background-color: #5b6a7b;
            color: #ffffff;
        }

        .autocomplete-items .autocomplete-active {
            background-color: #5b6a7b;
            color: #ffffff;
        }

        .card-header .card-title {
            font-size: 1.875rem;
            font-weight: 700;
        }

        .card-toolbar .btn {
            font-size: 0.875rem;
        }

        .form-control-sm {
            font-size: 0.875rem;
        }

        .btn-sm {
            font-size: 0.75rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table thead {
            background-color: #007bff;
            color: #ffffff;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('check_warehouse.store') }}" method="POST">
        @csrf
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Kiểm Kho</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('check_warehouse.index') }}" class="btn btn-sm btn-dark">
                        <span class="align-items-center d-flex">
                            <i class="fa fa-arrow-left me-1"></i>
                            Quay Lại
                        </span>
                    </a>
                </div>
            </div>

            <div class="card-body py-5 px-lg-17">
                <div class="row align-items-center mb-5">
                    <div class="col-md-6 mb-5">
                        <label for="code" class="form-label mb-2">Mã Kiểm Kho</label>
                        <input type="text" name="code" id="code"
                            class="form-control form-control-sm form-control-solid border border-success" required>
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="time" class="form-label mb-2">Thời Gian</label>
                        <input type="datetime-local" name="time" id="time"
                            class="form-control form-control-sm form-control-solid border border-success" required>
                    </div>


                    <div class="col-md-6 mb-5">
                        <label for="product_search" class="form-label mb-2">Tìm Kiếm Sản Phẩm</label>
                        <input type="text" id="product_search"
                            class="form-control form-control-sm form-control-solid border border-success"
                            placeholder="Nhập mã hàng hoặc tên hàng" onkeyup="searchProducts()">
                    </div>
                </div>
            </div>
        </div>

        <div class="card py-5 mb-xl-8">
            <div class="card-body py-5 px-lg-17">
                <div class="table-responsive">
                    <table id="search_table" class="table table-striped align-middle gs-0 gy-4">
                        <thead class="bg-success text-white">
                            <tr class="fw-bolder">
                                <th>SST</th>
                                <th>Mã Hàng</th>
                                <th>Tên Hàng</th>
                                <th>DVT</th>
                                <th>Tồn Kho</th>
                                <th>Giá Đơn Vị</th>
                                <th>Thêm</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sản phẩm tìm kiếm sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card py-5 mb-xl-8">
            <div class="card-body py-5 px-lg-17">
                <div class="table-responsive">
                    <table id="selected_table" class="table table-striped align-middle gs-0 gy-4">
                        <thead class="bg-success text-white">
                            <tr class="fw-bolder">
                                <th>SST</th>
                                <th>Mã Hàng</th>
                                <th>Tên Hàng</th>
                                <th>DVT</th>
                                <th>Tồn Kho</th>
                                <th>Giá Đơn Vị</th>
                                <th>Thực Tế</th>
                                <th>Số Lượng Lệch</th>
                                <th>Giá Trị Lệch</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sản phẩm đã chọn sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        const sampleProducts = [{
                id: 1,
                sst: 'SST001',
                code: 'P001',
                name: 'Sản Phẩm A',
                unit: 'Cái',
                stock: 100,
                unitPrice: 50000
            },
            {
                id: 2,
                sst: 'SST002',
                code: 'P002',
                name: 'Sản Phẩm B',
                unit: 'Hộp',
                stock: 50,
                unitPrice: 75000
            },
        ];

        function searchProducts() {
            let input = document.getElementById('product_search').value.toLowerCase();
            let searchTable = document.getElementById('search_table').getElementsByTagName('tbody')[0];

            searchTable.innerHTML = '';

            sampleProducts.forEach(product => {
                if (product.code.toLowerCase().includes(input) || product.name.toLowerCase().includes(input)) {
                    let row = searchTable.insertRow();
                    row.innerHTML = `
                        <td>${product.sst}</td>
                        <td>${product.code}</td>
                        <td>${product.name}</td>
                        <td>${product.unit}</td>
                        <td>${product.stock}</td>
                        <td>${product.unitPrice.toLocaleString()} VND</td>
                        <td><button type="button" class="btn btn-success btn-sm" onclick="addProduct(${product.id})">Thêm</button></td>
                    `;
                }
            });
        }

        function addProduct(productId) {
            let product = sampleProducts.find(p => p.id === productId);
            let selectedTable = document.getElementById('selected_table').getElementsByTagName('tbody')[0];
            let row = selectedTable.insertRow();
            row.innerHTML = `
        <td>${product.sst}</td>
        <td>${product.code}</td>
        <td>${product.name}</td>
        <td>${product.unit}</td>
        <td>${product.stock}</td>
        <td>${product.unitPrice.toLocaleString()} VND</td>
        <td><input type="number" name="actual_quantity[${product.id}]" class="form-control form-control-sm" onchange="updateDifferences(${product.id})" required></td>
        <td><input type="number" name="quantity_difference[${product.id}]" class="form-control form-control-sm" readonly></td>
        <td><input type="number" name="value_difference[${product.id}]" class="form-control form-control-sm" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)"><i class="fas fa-trash"></i></button></td>
    `;
        }

        function updateDifferences(productId) {
    let actualQuantityInput = document.querySelector(`input[name="actual_quantity[${productId}]"]`);
    let quantityDifferenceInput = document.querySelector(`input[name="quantity_difference[${productId}]"]`);
    let valueDifferenceInput = document.querySelector(`input[name="value_difference[${productId}]"]`);

    let actualQuantity = parseFloat(actualQuantityInput.value) || 0;
    let product = sampleProducts.find(p => p.id === productId);

    console.log('Product:', product); // Kiểm tra sản phẩm
    console.log('Actual Quantity:', actualQuantity); // Kiểm tra số lượng thực tế

    if (product) {
        let quantityDifference = actualQuantity - product.stock;
        let valueDifference = quantityDifference * product.unitPrice;

        console.log('Quantity Difference:', quantityDifference); // Kiểm tra số lượng lệch
        console.log('Value Difference:', valueDifference); // Kiểm tra giá trị lệch

        quantityDifferenceInput.value = quantityDifference.toFixed(2);
        valueDifferenceInput.value = valueDifference.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    } else {
        console.error('Product not found.');
    }
}



        function removeProduct(button) {
            let row = button.closest('tr');
            row.remove();
        }
    </script>
@endsection
