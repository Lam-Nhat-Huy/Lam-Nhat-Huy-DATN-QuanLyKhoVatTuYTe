@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_export.css') }}">
@endsection

@section('title')
    Tạo Phiếu Xuất Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        {{-- Tiêu đề  --}}
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Xuất Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark" style="font-size: 12px;">
                    <i class="fa fa-arrow-left me-1"></i>Trở Lại
                </a>
            </div>
        </div>

        <form action="{{ route('warehouse.store_export') }}" method="POST" id="export-form">
            @csrf
            <div class="container mt-4">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-3">
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <label for="material_code" class="required form-label mb-2">Tên vật tư</label>
                                    <select class="form-select form-select-sm " id="material_code" name="material_code"
                                        style="width: 100%;" required>
                                        <option value="" selected disabled>Chọn vật tư</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material['code'] }}">{{ $material['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mt-3">
                                    <h6 class="mb-3">Danh sách lô:</h6>
                                    <div id="batch_info" class="list-group">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3 mt-3">
                            <h6 class="mb-3 fw-bold text-primary">Thông tin phiếu xuất</h6>

                            <div class="mb-3">
                                <label for="department_code" class="form-label fw-semibold">Mã phòng ban</label>
                                <select name="department_code" class="form-control form-control-sm" id="department_code"
                                    required>
                                    <option value="">-- Chọn phòng ban --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department['code'] }}">{{ $department['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="created_by" class="form-label fw-semibold">Người tạo</label>
                                <select name="created_by" class="form-control form-control-sm" id="created_by" required>
                                    <option value="">-- Chọn người tạo --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="export_at" class="form-label fw-semibold">Ngày xuất</label>
                                <input type="date" name="export_at" class="form-control form-control-sm" id="export_at"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label fw-semibold">Ghi chú</label>
                                <textarea name="note" class="form-control form-control-sm" id="note" rows="3"
                                    placeholder="Nhập ghi chú..."></textarea>
                            </div>

                            <hr class="my-4">

                            <button type="button" id="add-material" class="btn btn-sm btn-primary w-100">Thêm vật
                                tư</button>
                            <button type="submit" class="btn btn-sm btn-success w-100 mt-3">Tạo Phiếu Xuất</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <h6 class="mb-3">Danh sách vật tư đã thêm:</h6>
                    <div id="added_materials" class="list-group">
                        <!-- Vật tư đã thêm sẽ được thêm vào đây -->
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const inventories = @json($inventories);

        document.getElementById('material_code').addEventListener('change', function() {
            const selectedMaterial = this.value;
            const batchDetailsContainer = document.getElementById('batch_info');

            batchDetailsContainer.innerHTML = '';

            const filteredInventories = inventories.filter(inv => inv.material_code === selectedMaterial);

            if (filteredInventories.length > 0) {
                filteredInventories.forEach(inventory => {
                    let inputField = '';
                    let textColor = '';

                    const quantity = Number(inventory.current_quantity);

                    if (quantity === 0) {
                        textColor = 'color: red;';
                        inputField = `
                            <input type="text" class="form-control form-control-sm"
                                   value="Hết Hàng" readonly style="max-width: 100px; background-color: #f8d7da;">
                        `;
                    } else if (quantity < 10) {
                        textColor = 'color: orange;';
                        inputField = `
                            <input type="number" class="form-control form-control-sm"
                                   name="batches[${inventory.batch_code}]"
                                   id="batch_${inventory.batch_code}"
                                   min="0" max="${quantity}"
                                   placeholder="Số Lượng" style="max-width: 100px;">
                        `;
                    } else {
                        textColor = 'color: green;';
                        inputField = `
                            <input type="number" class="form-control form-control-sm"
                                   name="batches[${inventory.batch_code}]"
                                   id="batch_${inventory.batch_code}"
                                   min="0" max="${quantity}"
                                   placeholder="Số Lượng" style="max-width: 100px;">
                        `;
                    }

                    const batchElement = document.createElement('div');
                    batchElement.classList.add('list-group-item', 'd-flex', 'align-items-center',
                        'justify-content-between');
                    batchElement.innerHTML = `
                        <div style="${textColor}">
                            <strong>Số Lô: ${inventory.batch_code}</strong>
                            <span class="text-muted">(Tồn: ${quantity})</span>
                            <span class="text-muted">(HSD: ${inventory.expiry_date})</span>
                        </div>
                        <div class="ms-2" style="width: 100px;">
                            ${inputField}
                        </div>
                    `;
                    batchDetailsContainer.appendChild(batchElement);
                });
            }
        });

        document.getElementById('add-material').addEventListener('click', function() {
            const materialCode = document.getElementById('material_code').value;
            const departmentCode = document.getElementById('department_code').value;
            const createdBy = document.getElementById('created_by').value;
            const exportAt = document.getElementById('export_at').value;
            const note = document.getElementById('note').value;

            const batchInputs = Array.from(document.querySelectorAll('[id^="batch_"]'));
            const batches = batchInputs.map(input => ({
                batchCode: input.id.split('_')[1],
                quantity: input.value
            }));

            if (materialCode && departmentCode && createdBy && exportAt) {
                const addedBatches = batches.filter(batch => Number(batch.quantity) > 0);

                if (addedBatches.length > 0) {
                    const addedMaterialsContainer = document.getElementById('added_materials');
                    const materialItem = document.createElement('div');
                    materialItem.classList.add('list-group-item', 'd-flex', 'align-items-center',
                        'justify-content-between');
                    materialItem.innerHTML = `
                <div>
                    <strong>Vật tư: ${document.querySelector('#material_code option:checked').textContent}</strong>
                    <br>Mã phòng ban: ${departmentCode}
                    <br>Người tạo: ${createdBy}
                    <br>Ngày xuất: ${exportAt}
                    <br>Ghi chú: ${note}
                </div>
                <div>
                    <strong>Danh sách lô:</strong>
                    <ul>
                        ${addedBatches.map(batch => `<li>Số lô: ${batch.batchCode}, Số lượng: ${batch.quantity}</li>`).join('')}
                    </ul>
                </div>
            `;
                    addedMaterialsContainer.appendChild(materialItem);

                    // Xóa các giá trị nhập vào form sau khi thêm
                    document.getElementById('batch_info').innerHTML = '';
                } else {
                    alert('Vui lòng nhập số lượng cho ít nhất một lô.');
                }
            } else {
                alert('Vui lòng điền đầy đủ thông tin.');
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            // event.preventDefault(); // Ngăn gửi form

            const materialCode = document.getElementById('material_code').value;
            const departmentCode = document.getElementById('department_code').value;
            const createdBy = document.getElementById('created_by').value;
            const exportAt = document.getElementById('export_at').value;
            const note = document.getElementById('note').value;
            const batches = Array.from(document.querySelectorAll('[id^="batch_"]')).map(input => ({
                batchCode: input.id.split('_')[1],
                quantity: input.value
            }));

            if (materialCode && departmentCode && createdBy && exportAt) {
                // Thêm vào danh sách vật tư đã thêm
                const addedMaterialsContainer = document.getElementById('added_materials');
                const materialItem = document.createElement('div');
                materialItem.classList.add('list-group-item', 'd-flex', 'align-items-center',
                    'justify-content-between');
                materialItem.innerHTML = `
            <div>
                <strong>Vật tư: ${document.querySelector('#material_code option:checked').textContent}</strong>
                <br>Mã phòng ban: ${departmentCode}
                <br>Người tạo: ${createdBy}
                <br>Ngày xuất: ${exportAt}
                <br>Ghi chú: ${note}
            </div>
            <div>
                <strong>Danh sách lô:</strong>
                <ul>
                    ${batches.map(batch => `<li>Số lô: ${batch.batchCode}, Số lượng: ${batch.quantity}</li>`).join('')}
                </ul>
            </div>
        `;
                addedMaterialsContainer.appendChild(materialItem);

                // Xóa các giá trị nhập vào form sau khi thêm
                document.querySelector('form').reset();
                document.getElementById('batch_info').innerHTML = '';
            } else {
                alert('Vui lòng điền đầy đủ thông tin.');
            }
        });
    </script>
@endsection
