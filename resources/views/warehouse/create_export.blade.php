@extends('master_layout.layout')

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
    </style>
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8" style="background-color: #e1e9f4">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Xuất</span>
            </h3>

            <a href="{{ route('warehouse.export') }}" class="fw-bold text-dark">Quay về</a>
        </div>

        <div class="card-body">
            <form action="{{ route('warehouse.store_export') }}" method="POST">
                @csrf
                <!-- Thông tin chung của phiếu xuất -->
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="created_by" class="form-label mb-2">Người tạo</label>
                            <select class="form-select setupSelect2" id="created_by" name="created_by">
                                <option value="">Chọn người tạo</option>
                                <option value="user1">Người tạo 1</option>
                                <option value="user2">Người tạo 2</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="export_type_id" class="form-label mb-2">Loại Xuất</label>
                            <select class="form-select setupSelect2" id="export_type_id" name="export_type_id">
                                <option value="">Chọn loại xuất</option>
                                <option value="retail">Xuất bán lẻ</option>
                                <option value="wholesale">Xuất bán sỉ</option>
                            </select>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="export_date" class="form-label mb-2">Ngày xuất</label>
                            <input type="date" class="form-control" id="export_date" name="export_date">
                        </div>

                        <div class="col-md-6">
                            <label for="note" class="form-label mb-2">Ghi chú</label>
                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Nhập ghi chú"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Phần chọn vật tư và số lượng -->
                <div class="card p-4 mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="material" class="form-label mb-2">Vật Tư</label>
                            <input type="text" id="material" name="material_name" class="form-control"
                                placeholder="Nhập tên vật tư">
                            <div id="material-list" class="autocomplete-items"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="export_quantity" class="form-label mb-2">Số Lượng Xuất</label>
                            <input type="number" id="export_quantity" name="export_quantity" class="form-control"
                                min="1" placeholder="Nhập số lượng xuất">
                        </div>
                    </div>
                    <div id="selected-material" class="col-md-12 mt-3"></div>
                    <div class="text-end mt-3">
                        <button type="button" id="add-material" class="btn btn-primary btn-sm">Thêm Vật Tư</button>

                        <button type="submit" class="btn btn-danger btn-sm">Tạo phiếu nhập</button>
                    </div>
                </div>

                <!-- Các input ẩn để lưu dữ liệu vật tư đã chọn -->
                <div id="materials-hidden-inputs"></div>


            </form>

            <!-- Danh sách vật tư đã chọn -->
            <div class="card p-4 mb-4 col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người tạo</th>
                            <th>Ngày xuất</th>
                            <th>Loại Xuất</th>
                            <th>Ghi chú</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lô</th>
                            <th>Số lượng</th>
                            <th>Hạn sử dụng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="materials-list">
                        <!-- Vật tư sẽ được thêm vào đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const materials = [{
                    name: 'Canxium (1 hộp 6 vỉ x 30 viên)',
                    lot: 'C123',
                    stock: 4,
                    expiry: '19-12-2024'
                },
                {
                    name: 'Paracetamol',
                    lot: 'P456',
                    stock: 10,
                    expiry: '20-01-2025'
                },
                {
                    name: 'Ibuprofen',
                    lot: 'I789',
                    stock: 5,
                    expiry: '05-05-2024'
                },
                {
                    name: 'Aspirin',
                    lot: 'A321',
                    stock: 12,
                    expiry: '15-09-2024'
                }
            ];

            const materialInput = document.getElementById('material');
            const materialList = document.getElementById('material-list');
            const selectedMaterialDiv = document.getElementById('selected-material');
            const materialsList = document.getElementById('materials-list');
            const materialsHiddenInputs = document.getElementById('materials-hidden-inputs');
            const quantityInput = document.getElementById('export_quantity');
            let selectedMaterial = null;

            // Tìm kiếm vật tư khi nhập vào
            materialInput.addEventListener('input', function() {
                const value = this.value.toLowerCase();
                materialList.innerHTML = '';

                if (value) {
                    materials.forEach((material, index) => {
                        if (material.name.toLowerCase().includes(value)) {
                            const item = document.createElement('div');
                            item.textContent = material.name;
                            item.addEventListener('click', function() {
                                materialInput.value = material.name;
                                selectedMaterial = material;

                                // Disable input số lượng nếu tồn kho thấp
                                if (selectedMaterial.stock <= 5) {
                                    quantityInput.disabled = true;
                                    quantityInput.placeholder = 'Không được nhập';
                                } else {
                                    quantityInput.disabled = false;
                                    quantityInput.placeholder = 'Nhập số lượng';
                                }

                                // Tạo một đoạn HTML để hiển thị thông tin vật tư đã chọn
                                const infoHTML = `
                        <p>Vật tư đã chọn: ${material.name} - Số lô: ${material.lot}
                        (tồn: ${material.stock})
                        ${material.stock <= 5 ? '<span style="color: red;">(Số lượng tồn kho thấp)</span>' : ''}
                        (HSD: ${material.expiry})</p>
                    `;
                                selectedMaterialDiv.innerHTML = infoHTML;
                                materialList.innerHTML = '';
                            });
                            materialList.appendChild(item);
                        }
                    });
                }
            });


            // Thêm vật tư vào danh sách
            document.getElementById('add-material').addEventListener('click', function() {
                const creator = document.getElementById('created_by').value;
                const exportDate = document.getElementById('export_date').value;
                const exportType = document.getElementById('export_type_id').value;
                const notes = document.getElementById('note').value;
                const quantityInput = document.getElementById('export_quantity');
                const quantity = parseInt(quantityInput.value, 10);

                // Kiểm tra đầu vào
                if (!creator || !exportDate || !exportType) {
                    alert('Vui lòng nhập đầy đủ thông tin người tạo, ngày xuất, và loại xuất.');
                    return;
                }

                if (selectedMaterial && quantity > 0 && quantity <= selectedMaterial.stock) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${materialsList.children.length + 1}</td>
                        <td>${creator}</td>
                        <td>${exportDate}</td>
                        <td>${exportType}</td>
                        <td>${notes}</td>
                        <td>${selectedMaterial.name}</td>
                        <td>${selectedMaterial.lot}</td>
                        <td>${quantity}</td>
                        <td>${selectedMaterial.expiry}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-material">Xóa</button>
                        </td>
                    `;
                    materialsList.appendChild(tr);

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'materials[]';
                    hiddenInput.value = JSON.stringify({
                        name: selectedMaterial.name,
                        lot: selectedMaterial.lot,
                        quantity: quantity,
                        expiry: selectedMaterial.expiry
                    });
                    materialsHiddenInputs.appendChild(hiddenInput);

                    // Xóa các ô nhập liệu sau khi thêm vào danh sách
                    materialInput.value = '';
                    quantityInput.value = '';
                    selectedMaterialDiv.innerHTML = '';

                    // Xóa vật tư khỏi danh sách khi bấm nút xóa
                    tr.querySelector('.remove-material').addEventListener('click', function() {
                        materialsList.removeChild(tr);
                        materialsHiddenInputs.removeChild(hiddenInput);
                    });

                    selectedMaterial = null;
                } else {
                    alert('Vui lòng chọn vật tư và số lượng hợp lệ.');
                }
            });
        });
    </script>
@endsection
