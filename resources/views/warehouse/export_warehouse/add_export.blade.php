@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_export.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('title')
    Tạo Phiếu Xuất Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        {{-- Tiêu đề --}}
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Xuất Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark" style="font-size: 10px;">
                    <i class="fa fa-arrow-left me-1" style="font-size: 10px;"></i>Trở Lại
                </a>
            </div>
        </div>

        <!-- Form thêm vật tư -->
        <form action="{{ route('warehouse.store_export') }}" method="POST">
            @csrf
            <div class="container mt-4">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-3">
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <label for="material_code" class="required form-label mb-2">Tên vật tư</label>
                                    <select class="form-select form-select-sm" id="material_code" name="material_code"
                                        style="width: 100%;">
                                        <option value="" selected disabled>Chọn vật tư</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material['code'] }}">{{ $material['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mt-3">
                                    <h6 class="mb-3">Danh sách lô:</h6>
                                    <div id="batch_info" class="list-group">
                                        <div class="alert alert-danger" role="alert">
                                            Bạn chưa chọn vật tư.
                                        </div>
                                    </div>


                                </div>

                                <div class="col-12 mt-3 mb-3 text-end">
                                    <button type="button" class="btn btn-sm"
                                        style="background-color: #FF0000; color: #fff; font-size: 10px;"
                                        id="add-to-list">Thêm</button>
                                </div>
                            </div>
                        </div>


                        <!-- Bảng danh sách vật tư đã thêm -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="material-list">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tên Vật Tư</th>
                                        <th>Số Lô</th>
                                        <th>Số Lượng</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody id="material-list-body">
                                    <tr id="no-material-alert">
                                        <td colspan="4" class="text-center pe-0 px-0"
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

                    <div class="col-4">
                        <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded-4 mt-3">
                            <h6 class="mb-4 fw-bold text-primary text-uppercase">Thông tin phiếu xuất</h6>

                            <div class="mb-4">
                                <label for="department_code" class="form-label fw-semibold text-muted">Mã phòng ban</label>
                                <select name="department_code" class="form-select form-select-sm rounded-pill py-2 px-3"
                                    id="department_code" required>
                                    <option value="">-- Chọn phòng ban --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department['code'] }}">{{ $department['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="created_by" class="form-label fw-semibold text-muted">Người tạo</label>
                                <select name="created_by" class="form-select form-select-sm rounded-pill py-2 px-3"
                                    id="created_by" required>
                                    <option value="">-- Chọn người tạo --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="export_at" class="form-label fw-semibold text-muted">Ngày xuất</label>
                                <input type="date" name="export_at"
                                    class="form-control form-control-sm rounded-pill py-2 px-3" id="export_at" required>
                            </div>

                            <div class="mb-4">
                                <label for="note" class="form-label fw-semibold text-muted">Ghi chú</label>
                                <textarea name="note" class="form-control form-control-sm rounded-3 py-2 px-3" id="note" rows="3"
                                    placeholder="Nhập ghi chú..."></textarea>
                            </div>

                            <hr class="my-4">

                            <input type="hidden" name="material_list" id="material_list_input">

                            <button type="submit" class="btn btn-success btn-sm rounded-pill w-100">Xuất Kho</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const inventories = @json($inventories);

        let materialList = [];

        document.getElementById('material_code').addEventListener('change', function() {
            const selectedMaterial = this.value;
            const batchDetailsContainer = document.getElementById('batch_info');

            batchDetailsContainer.innerHTML = '';

            const filteredInventories = inventories.filter(inv => inv.material_code === selectedMaterial);

            if (filteredInventories.length > 0) {
                const today = new Date();
                const alertThreshold = 30; // Days before expiration to trigger alert

                filteredInventories.forEach(inventory => {
                    let inputField = '';
                    let textColor = '';
                    let alertMessage = '';
                    let icon = '';

                    const quantity = Number(inventory.current_quantity);
                    const expiryDate = new Date(inventory.expiry_date);
                    const daysToExpiry = Math.ceil((expiryDate - today) / (1000 * 60 * 60 * 24));

                    if (quantity === 0) {
                        textColor = 'color: #FF0000;';
                        inputField = `
                            <input type="text" class="form-control form-control-sm"
                                value="Hết Hàng" readonly style="max-width: 100px; background-color: #DD0000; color: #fff; text-align: center;">
                        `;
                    } else if (quantity < 10) {
                        textColor = 'color: #FFCC00;';
                        inputField = `
                            <input type="number" class="form-control form-control-sm"
                                name="batches[${inventory.batch_code}]"
                                id="batch_${inventory.batch_code}"
                                min="0" max="${quantity}"
                                placeholder="Số Lượng" style="max-width: 100px ; text-align: center;">
                        `;
                    } else {
                        textColor = 'color: #66FF00;';
                        inputField = `
                            <input type="number" class="form-control form-control-sm"
                                name="batches[${inventory.batch_code}]"
                                id="batch_${inventory.batch_code}"
                                min="0" max="${quantity}"
                                placeholder="Số Lượng" style="max-width: 100px; text-align: center;">
                        `;
                    }

                    if (daysToExpiry <= alertThreshold && daysToExpiry > 0) {
                        icon =
                            `<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThr7qrIazsvZwJuw-uZCtLzIjaAyVW_ZrlEQ&s"
                    alt="AI Icon" style="width: 20px; height: 20px; display: inline-block; margin-left: 10px;"
                    title="Gợi ý: Nên xuất vật tư này trước khi hết hạn" data-toggle="tooltip" data-placement="right" >`;
                    } else if (daysToExpiry <= 0) {
                        icon =
                            `<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThr7qrIazsvZwJuw-uZCtLzIjaAyVW_ZrlEQ&s"
                    alt="AI Icon" style="width: 20px; height: 20px; display: inline-block; margin-left: 10px;"
                    title="Gợi ý: Nên xuất vật tư này trước khi hết hạn">`;
                    }

                    const batchElement = document.createElement('div');
                    batchElement.classList.add('list-group-item', 'd-flex', 'align-items-center',
                        'justify-content-between');
                    batchElement.innerHTML = `
                        <div style="${textColor}; display: inline-block;">
                            <strong>Số Lô: ${inventory.batch_code}</strong>
                            <span class="text-muted">(Tồn: ${quantity})</span>
                            <span class="text-muted">(HSD: ${inventory.expiry_date})</span>
                            ${icon} ${alertMessage}
                        </div>
                        <div class="ms-2" style="width: 100px;">
                            ${inputField}
                        </div>
                    `;
                    batchDetailsContainer.appendChild(batchElement);
                });
            }
        });

        document.getElementById('add-to-list').addEventListener('click', function() {
            const selectedMaterial = document.getElementById('material_code').value;
            const departmentCode = document.getElementById('department_code').value;
            const createdBy = document.getElementById('created_by').value;
            const exportDate = document.getElementById('export_at').value;
            const note = document.getElementById('note').value;

            const batches = Array.from(document.querySelectorAll('#batch_info input[type="number"]'))
                .filter(input => input.value > 0)
                .map(input => ({
                    batch_code: input.name.replace('batches[', '').replace(']', ''),
                    quantity: parseInt(input.value)
                }));

            if (selectedMaterial && batches.length > 0) {
                materialList.push({
                    material_code: selectedMaterial,
                    batches,
                    department_code: departmentCode,
                    created_by: createdBy,
                    export_at: exportDate,
                    note
                });

                updateMaterialListTable();
                resetForm();
            }
        });

        function updateMaterialListTable() {
            const tbody = document.querySelector('#material-list-body');
            tbody.innerHTML = '';

            if (materialList.length === 0) {
                tbody.innerHTML = `
                <tr id="no-material-alert">
                    <td colspan="4" class="text-center pe-0 px-0">
                        <div class="alert alert-warning" role="alert">
                            Chưa có vật tư nào được thêm vào danh sách. Vui lòng chọn vật tư
                        </div>
                    </td>
                </tr>
            `;
            } else {
                // Hiển thị danh sách vật tư và lô
                materialList.forEach((item, materialIndex) => {
                    item.batches.forEach(batch => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td class="text-center">${item.material_code}</td>
                    <td class="text-center">${batch.batch_code}</td>
                    <td class="text-center">${batch.quantity}</td>
                    <td class="text-center">
                        <button type="button"
                            onclick="removeFromList(${materialIndex}, '${batch.batch_code}')"><i class='fa fa-trash'></i></button>
                    </td>
                `;
                        tbody.appendChild(row);
                    });
                });
            }

            // Cập nhật giá trị của input ẩn để gửi danh sách vật tư tới server
            document.getElementById('material_list_input').value = JSON.stringify(materialList);
        }

        function removeFromList(materialIndex, batchCode) {
            let material = materialList[materialIndex];
            material.batches = material.batches.filter(batch => batch.batch_code !== batchCode);
            if (material.batches.length === 0) {
                materialList.splice(materialIndex, 1);
            }
            updateMaterialListTable();
        }


        function resetForm() {
            document.getElementById('material_code').value = '';
            document.getElementById('batch_info').innerHTML = '';
        }
    </script>
@endsection
