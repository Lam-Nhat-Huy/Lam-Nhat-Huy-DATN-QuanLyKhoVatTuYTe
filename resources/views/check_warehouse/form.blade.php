@extends('master_layout.layout')

@section('title')
    {{ $title }}
@endsection

@section('styles')
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
                <div class="align-items-center mb-5">
                    <label for="" class="form-label mb-3">Ghi Chú Của Phiếu Kiểm</label>
                    <textarea type="text" name="" id=""
                        class="form-control form-control-sm form-control-solid border border-success" placeholder="Ghi Chú.." cols="30"
                        rows="5"></textarea>
                </div>
            </div>
        </div>

        <div class="card mb-5 mb-xl-8">
            <div class="card-body py-5 px-lg-17">
                <div class="row align-items-center mb-5">
                    <div class="col-6">
                        <label for="" class="form-label mb-3">Vật Tư</label>
                        <select name="" id=""
                            class="form-select form-select-sm form-select-solid setupSelect2">
                            <option value="">--Chọn Vật Tư--</option>
                            <option value="">Vật Tư 1</option>
                            <option value="">Vật Tư 2</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label mb-3">Nhóm Vật Tư</label>
                        <div><i class="fa-solid fa-rectangle-list pointer" style="font-size: 30px;" data-bs-toggle="modal"
                                data-bs-target="#material_group_"></i></div>
                    </div>
                </div>

                <div class="card-footer text-end pe-0">
                    <button type="submit" class="btn btn-success btn-sm">Thêm</button>
                </div>
            </div>
        </div>

        <div class="card pt-5 mb-xl-8">
            <div class="card-body py-5 px-lg-17">
                <div class="table-responsive">
                    <table id="selected_table" class="table table-striped align-middle gs-0 gy-4">
                        <thead class="bg-success text-white">
                            <tr class="fw-bolder">
                                <th class="ps-4">Vật Tư</th>
                                <th>Vật Tư</th>
                                <th>Số Lô</th>
                                <th>Hạn Sử Dụng</th>
                                <th>Tồn Kho</th>
                                <th>Thực Kiểm</th>
                                <th>Chênh Lệch</th>
                                <th class="pe-3">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>#KK001</td>
                                <td>Tên Vật Tư 1</td>
                                <td>LH256</td>
                                <td>4-5-2025</td>
                                <td>100</td>
                                <td>98</td>
                                <td>-2</td>
                                <td>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Xóa</button>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td>#KK002</td>
                                <td>Tên Vật Tư 2</td>
                                <td>LH257</td>
                                <td>14-3-2025</td>
                                <td>58</td>
                                <td>58</td>
                                <td>0</td>
                                <td>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-end pe-0">
                    <button type="submit" class="btn btn-twitter btn-sm">Lưu</button>
                </div>
            </div>
        </div>
    </form>

    {{-- Form Thêm Nhóm Vật Tư --}}
    <div class="modal fade" id="material_group_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="checkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="checkModalLabel">Thêm Vật Tư Từ Nhóm Vật Tư
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        @csrf
                        <label for="" class="form-label mb-3">Nhóm Vật Tư</label>
                        <select name="" id="" class="form-select form-select-sm form-select-solid">
                            <option value="">--Chọn Nhóm Vật Tư--</option>
                            <option value="">Nhóm Vật Tư 1</option>
                            <option value="">Nhóm Vật Tư 2</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-twitter">Thêm</button>
                </div>
            </div>
        </div>
    </div>
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
                valueDifferenceInput.value = valueDifference.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
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
