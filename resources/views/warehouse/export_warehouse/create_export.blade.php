@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('title')
    Xuất Kho
@endsection

@php
    if ($action === 'create') {
        $action = route('warehouse.store_export');

        $d_none_save = '';

        $d_none_update = 'd-none';

        $d_none_temp = '';
    } elseif ($action === 'update') {
        $action = route('warehouse.update_export', request('code'));

        $d_none_save = 'd-none';

        $d_none_update = '';

        $d_none_temp = 'd-none';
    }
@endphp

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Thông Tin Phiếu Xuất</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark rounded-pill">
                    <i class="fa fa-arrow-left me-1" style="margin-bottom: 2px;"></i>Trở Lại
                </a>
            </div>
        </div>

        <div class="container">
            <div class="card border-0 px-8 mb-4 rounded-3 mt-3">
                <div class="row">
                    <div class="col-md-6 mb-3 fv-row d-none" id="supplier_show">
                        <label for="supplier_code" class="required form-label fw-semibold">Nhà Cung Cấp</label>
                        <div class="d-flex align-items-center">
                            <select name="supplier_code" id="supplier_code"
                                class="form-select form-select-sm border border-success rounded-pill">
                                <option value="0">Chọn Nhà Cung Cấp...</option>
                                <option value="1" class="d-none">Chọn Nhà Cung Cấp...</option>
                                @foreach ($allSupplier as $item)
                                    <option value="{{ $item->code }}"
                                        {{ !empty($editExport) && $editExport->supplier_code == $item->code ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>

                            <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_supplier"
                                title="Thêm Nhà Cung Cấp">
                                <i class="fa fa-plus bg-primary rounded-circle p-2 text-white"
                                    style="width: 25px; height: 25px;"></i>
                            </span>
                        </div>
                        <div class="message_error" id="supplier_code_error"></div>
                    </div>

                    <div class="col-md-6 mb-3 fv-row" id="department_show">
                        <label for="department_code" class="required form-label fw-semibold">Phòng Ban</label>
                        <div class="d-flex align-items-center">
                            <select name="department_code" id="department_code"
                                class="form-select form-select-sm border border-success rounded-pill">
                                <option value="0">Chọn Phòng Ban...</option>
                                <option value="1" class="d-none">Chọn Phòng Ban...</option>
                                @foreach ($allDepartment as $item)
                                    <option value="{{ $item->code }}"
                                        {{ !empty($editExport) && $editExport->department_code == $item->code ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>

                            <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_department"
                                title="Thêm Phòng Ban">
                                <i class="fa fa-plus bg-primary rounded-circle p-2 text-white"
                                    style="width: 25px; height: 25px;"></i>
                            </span>
                        </div>
                        <div class="message_error" id="department_code_error"></div>
                    </div>

                    <div class="col-md-6 mb-3 fv-row d-none" id="cancel_reason">
                        <label for="reason" class="required form-label fw-semibold">Lý Do Hủy</label>
                        <select name="reason" id="reason"
                            class="form-select form-select-sm border border-success rounded-pill">
                            <option value="0">Chọn Lý Do...</option>
                            <option value="1" class="d-none">Chọn Lý Do...</option>
                            <option value="Hư Hỏng">Hư Hỏng</option>
                            <option value="Hết Hạn Sử Dụng">Hết Hạn Sử Dụng</option>
                            <option value="Lỗi Sản Xuất">Lỗi Sản Xuất</option>
                            <option value="Thừa Hoặc Không Cần Thiết">Thừa Hoặc Không Cần Thiết</option>
                            <option value="Hàng Bị Trả Về">Hàng Bị Trả Về</option>
                            <option value="Lỗi Kỹ Thuật">Lỗi Kỹ Thuật</option>
                            <option value="Quyết Định Tiêu Hủy">Quyết Định Tiêu Hủy</option>
                        </select>
                        <div class="message_error" id="reason_error"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="export_type" class="required form-label fw-semibold">Loại Xuất</label>
                        <div class="d-flex align-items-center">
                            <select name="export_type" id="export_type"
                                class="form-select form-select-sm border border-success rounded-pill">
                                <option value="Xuất Sử Dụng"
                                    {{ !empty($editExport) && $editExport->export_type === 'Xuất Sử Dụng' ? 'selected' : '' }}>
                                    Xuất Sử Dụng</option>
                                <option value="Xuất Trả"
                                    {{ !empty($editExport) && $editExport->export_type === 'Xuất Trả' ? 'selected' : '' }}>
                                    Xuất Trả</option>
                                <option value="Xuất Hủy"
                                    {{ !empty($editExport) && $editExport->export_type === 'Xuất Hủy' ? 'selected' : '' }}>
                                    Xuất Hủy</option>
                            </select>
                        </div>
                        <div class="message_error" id="export_type_error"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="" class="form-label fw-semibold">Ngày Xuất Kho</label>
                        <input type="date" name="export_date" id="export_date" disabled
                            class="form-control form-control-sm border-success rounded-pill"
                            value="{{ !empty($editExport) && $editExport->export_date ? \Carbon\Carbon::parse($editExport->export_date)->format('Y-m-d') : \Carbon\Carbon::parse(now())->format('Y-m-d') }}">
                        <div class="message_error"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="" class="form-label fw-semibold">Ghi Chú</label>
                        <input type="text" name="note" id="note"
                            value="{{ !empty($editExport) && $editExport->note ? $editExport->note : old('note') }}"
                            class="form-control form-control-sm border-success rounded-pill" placeholder="Ghi Chú..">
                        <div class="message_error"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 pt-5 pb-10 mb-xl-8 shadow">
        <div class="card-header border-0">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Thiết Bị Xuất</span>
            </h3>
        </div>
        <div class="container">
            <div class="card border-0 px-8 mb-4 rounded-3">
                <div class="row">
                    <div class="col-6">
                        <label for="equipment_code" class="required form-label fw-semibold">Thiết
                            bị</label>
                        <select name="equipment" id="equipment" onchange="cEquipment()"
                            class="form-select form-select-sm border border-success rounded-pill">
                            <option value="" selected>Chọn Thiết Bị...</option>
                            @foreach ($equipmentsWithStock as $item)
                                <option value="{{ $item->code }}"
                                    class="{{ $item->inventories->sum('current_quantity') <= 25 ? 'text-danger' : '' }}">
                                    {{ $item->name }} - (Tổng Tồn:
                                    {{ $item->inventories->sum('current_quantity') ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                        <div class="message_error" id="equipment_error"></div>
                    </div>

                    <div class="col-3">
                        <label for="batch_number" class="required form-label fw-semibold" id="batch_number_label">Số
                            lô</label>
                        <select class="form-select form-select-sm border-success rounded-pill" name="batch_number"
                            onchange="cBatchNumber()" id="batch_number">
                            <option value="" id="choose_batch_number">Chọn Số Lô...</option>
                        </select>
                        <div class="message_error" id="batch_number_error"></div>
                    </div>

                    <div class="col-3">
                        <label for="quantity" class="required form-label fw-semibold" id="quantity_label">Số
                            lượng</label>
                        <input type="number" class="form-control form-control-sm border border-success rounded-pill"
                            oninput="cQuantity()" min="0" id="quantity" name="quantity"
                            placeholder="Nhập số lượng">
                        <div class="message_error" id="quantity_error"></div>
                    </div>
                </div>

                <div class="mb-3 text-end">
                    <button style="font-size: 11px;" type="button" class="btn btn-sm btn-danger rounded-pill"
                        id="add_equipment_to_list">
                        <i class="fa fa-plus" style="margin-bottom: 2px;"></i> Thêm
                    </button>
                </div>
            </div>
        </div>

        <div class="row container">
            <div class="col-md-12 ps-10">
                <div class="card border-0 shadow bg-white rounded-3">
                    <div class="table-responsive rounded bg-white shadow">
                        <table class="table align-middle mb-0 table-striped gs-0 gy-4" id="table_list_equipment">
                            <thead class="table-dark">
                                <tr class="">
                                    <th style="width: 50%;" class="ps-5">Thiết bị</th>
                                    <th style="width: 25%;">Số lô</th>
                                    <th style="width: 15%;">Số Lượng</th>
                                    <th style="width: 10%;" class="pe-5">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="equipmentList">
                                @if (!empty($editExport))
                                    @foreach ($editExport->exportDetail as $item)
                                        <tr id="equipment-row-{{ $item->batch_number }}-{{ $item->equipment_code }}">
                                            <td class="ps-5">{{ $item->equipments->name }}</td>
                                            <td class="">
                                                <div class="d-flex align-items-center"
                                                    id="batch_number_change_{{ $item->batch_number }}">
                                                    {{ $item->batch_number }} - (Tồn Kho:
                                                    {{ $item->equipments->inventories->sum('current_quantity') }}
                                                    {{ $item->equipments->units->name }})
                                                </div>
                                                <input type="hidden" id="current_quantity_{{ $item->batch_number }}"
                                                    value="{{ $item->equipments->inventories->sum('current_quantity') }}" />
                                            </td>
                                            <td class="">
                                                <div class="d-flex align-items-center">
                                                    <input type="number" id="quantity_change_{{ $item->batch_number }}"
                                                        value="{{ $item->quantity }}"
                                                        class="form-control form-control-sm border border-success rounded-pill">
                                                    <div class="message_error d-none ms-2 m-0 p-0 pointer"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Số Lượng Phải Lớn Hơn 0 Và Nhỏ Hơn {{ $item->equipments->inventories->sum('current_quantity') }}"
                                                        id="quantity_list_{{ $item->batch_number }}">
                                                        <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    onclick="removeEquipment('{{ $item->equipment_code }}', '{{ $item->batch_number }}')"
                                                    class="pointer">
                                                    <i class="fas fa-trash text-danger p-0"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr id="noDataAlert" class="{{ !empty($editExport) ? 'd-none' : '' }}">
                                    <td colspan="12" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-file-invoice"
                                                    style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">
                                                    Danh Sách Thiết Bị Xuất Trống</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Hiện Chưa Có Thiết Bị Nào Được Thêm Vào
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center mt-10">
                    <button type="button"
                        class="btn btn-sm btn-twitter d-flex align-items-center justify-content-center rounded-pill {{ $d_none_update }}"
                        id="export_update">
                        <i class="fas fa-save me-1"></i>Cập Nhật
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-info me-2 d-flex align-items-center justify-content-center rounded-pill {{ $d_none_temp }}"
                        id="export_temp">
                        <i class="fas fa-cloud-arrow-down me-1"></i>Lưu Tạm
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-twitter d-flex align-items-center justify-content-center rounded-pill {{ $d_none_save }}"
                        id="export_save">
                        <i class="fas fa-save me-1"></i>Tạo Phiếu
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let addedEquipmentBatchs = [];

        // Chuyển đổi select option
        document.getElementById('export_type').addEventListener('change', function() {
            var exportType = this.value;
            var supplierShow = document.getElementById('supplier_show');
            var departmentShow = document.getElementById('department_show');
            var cancelReason = document.getElementById('cancel_reason');
            var supplierSelect = document.getElementById('supplier_code');
            var departmentSelect = document.getElementById('department_code');
            var reasonSelect = document.getElementById('reason');

            var supplierSelectErr = document.getElementById('supplier_code_error');
            var departmentSelectErr = document.getElementById('department_code_error');
            var reasonSelectErr = document.getElementById('reason_error');

            if (exportType === 'Xuất Sử Dụng') {
                supplierShow.classList.add('d-none');
                departmentShow.classList.remove('d-none');
                cancelReason.classList.add('d-none');

                supplierSelect.value = '1';
                departmentSelect.value = '0';
                reasonSelect.value = '1';

                supplierSelectErr.innerText = '';
                reasonSelectErr.innerText = '';
            } else if (exportType === 'Xuất Trả') {
                departmentShow.classList.add('d-none');
                supplierShow.classList.remove('d-none');
                cancelReason.classList.add('d-none');

                supplierSelect.value = '0';
                departmentSelect.value = '1';
                reasonSelect.value = '1';

                departmentSelectErr.innerText = '';
                reasonSelectErr.innerText = '';
            } else if (exportType === 'Xuất Hủy') {
                supplierShow.classList.add('d-none');
                departmentShow.classList.add('d-none');
                cancelReason.classList.remove('d-none');

                supplierSelect.value = '1';
                departmentSelect.value = '1';
                reasonSelect.value = '0';

                supplierSelectErr.innerText = '';
                departmentSelectErr.innerText = '';
            }
        });

        // Đảm bảo thiết lập đúng trạng thái ban đầu dựa trên giá trị đã chọn (nếu có)
        window.addEventListener('DOMContentLoaded', function() {
            var event = new Event('change');
            document.getElementById('export_type').dispatchEvent(event);
        });

        // Đảm bảo thiết lập đúng trạng thái ban đầu dựa trên giá trị đã chọn (nếu có)
        window.addEventListener('DOMContentLoaded', function() {
            var event = new Event('change');
            document.getElementById('export_type').dispatchEvent(event);
        });

        // Chuyển đổi mảng PHP thành JavaScript
        const equipmentBatches = {!! $jsonEquipmentBatches !!};

        // Lấy mảng số lô đã thêm từ controller
        let checkList = {!! $checkList !!};

        // Lấy danh sách và hiển thị vào option số lô theo mã thiết bị
        document.getElementById('equipment').addEventListener('change', function() {
            const selectedEquipment = this.value;
            const batchSelect = document.getElementById('batch_number');

            // Xóa tất cả các option hiện tại
            batchSelect.innerHTML = '<option value="" id="choose_batch_number">Chọn Số Lô...</option>';

            // Kiểm tra xem thiết bị đã chọn có số lô tương ứng hay không
            if (equipmentBatches[selectedEquipment] && equipmentBatches[selectedEquipment].length > 0) {
                let allHidden = true; // Biến để kiểm tra nếu tất cả các lô đã bị ẩn

                equipmentBatches[selectedEquipment].forEach(function(batch) {
                    const option = document.createElement('option');
                    option.value = batch.batch_number;
                    option.textContent = `${batch.batch_number} - Số lượng: ${batch.total_quantity}`;
                    batchSelect.appendChild(option);
                });

                // Kiểm tra và ẩn các lô đã được thêm trong addedEquipmentBatchs
                let equipmentOptions = document.querySelectorAll('#batch_number option');
                equipmentOptions.forEach(option => {
                    if (addedEquipmentBatchs.includes(option.value)) {
                        option.classList.add('d-none');
                    } else if (checkList.includes(option.value)) {
                        option.classList.add('d-none');
                    } else if (option.value !== '') {
                        allHidden = false; // Nếu có ít nhất một lô không bị ẩn, đặt allHidden thành false
                    }
                });

                // Nếu tất cả các lô đều bị ẩn, hiển thị thông báo
                if (allHidden) {
                    batchSelect.innerHTML = ''; // Xóa tất cả các option
                    const noBatchOption = document.createElement('option');
                    noBatchOption.value = '';
                    noBatchOption.textContent = 'Đã Thêm Toàn Bộ Số Lô';
                    batchSelect.appendChild(noBatchOption);
                }

            } else {
                // Nếu không có lô nào, thêm option "Không Có Số Lô Nào"
                batchSelect.innerHTML = '';
                const noBatchOption = document.createElement('option');
                noBatchOption.value = '';
                noBatchOption.textContent = 'Không Có Số Lô Nào';
                batchSelect.appendChild(noBatchOption);
            }
        });

        // Set attribute số lượng max của số lô
        document.getElementById('batch_number').addEventListener('change', function() {
            const selectedBatch = this.value;
            const selectedEquipment = document.getElementById('equipment').value;

            if (selectedBatch && selectedEquipment) {
                // Find the total quantity for the selected batch
                const batchInfo = equipmentBatches[selectedEquipment].find(batch => batch.batch_number ===
                    selectedBatch);
                if (batchInfo) {
                    const totalQuantity = batchInfo.total_quantity;

                    // Update the quantity input field
                    const quantityInput = document.getElementById('quantity');
                    quantityInput.setAttribute('max', totalQuantity); // Set the max attribute
                    quantityInput.value = totalQuantity; // Set the default value to max
                }
            }
        });

        // Lấy dữ liệu từ danh sách thiết bị
        function getEquipmentList() {
            equipmentList = [];
            let rows = document.querySelectorAll('#table_list_equipment tbody tr');

            rows.forEach((row) => {
                if (row.id === "noDataAlert") return;

                let batchNumber = row.id.split('-')[2]; // Lấy số lô thiết bị từ ID của hàng
                let equipmentCode = row.id.split('-')[3]; // Lấy mã thiết bị từ ID của hàng
                let quantityIp = document.getElementById(`quantity_change_${batchNumber}`);
                let quantityValue = parseInt(quantityIp.value.trim(), 10);

                // Đưa dữ liệu vào mảng
                equipmentList.push({
                    equipment_code: equipmentCode,
                    quantity: quantityValue,
                    batch_number: batchNumber,
                });

            });

            return equipmentList;
        }

        // Tạo hoặc lưu tạm phiếu xuất

        // Lấy sự kiện click
        document.getElementById('export_save').addEventListener('click', function(event) {
            event.preventDefault();
            handleImportEquipmentRequest(4);
        });

        document.getElementById('export_update').addEventListener('click', function(event) {
            event.preventDefault();
            handleImportEquipmentRequest(4);
        });

        document.getElementById('export_temp').addEventListener('click', function(event) {
            event.preventDefault();
            handleImportEquipmentRequest(3);
        });

        function handleImportEquipmentRequest(exportStatus) {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(async () => {
                let department_code = document.getElementById('department_code').value.trim();
                let supplier_code = document.getElementById('supplier_code').value.trim();
                let reason = document.getElementById('reason').value.trim();
                let export_type = document.getElementById('export_type').value.trim();
                let export_date = document.getElementById('export_date').value.trim();
                let note = document.getElementById('note').value.trim();

                let department_code_error = document.getElementById('department_code_error');
                let supplier_code_error = document.getElementById('supplier_code_error');
                let reason_error = document.getElementById('reason_error');
                let equipment_error = document.getElementById('equipment_error');
                let equipmentList = getEquipmentList();

                department_code_error.innerText = '';
                equipment_error.innerText = '';

                let hasError = false;

                if (department_code == 0) {
                    department_code_error.innerText = "Vui lòng chọn phòng ban";
                    hasError = true;
                }

                if (supplier_code == 0) {
                    supplier_code_error.innerText = "Vui lòng chọn nhà cung cấp";
                    hasError = true;
                }

                if (reason == 0) {
                    reason_error.innerText = "Vui lòng chọn lý do hủy";
                    hasError = true;
                }

                if (equipmentList.length === 0) {
                    equipment_error.innerText = "Vui lòng chọn thiết bị cần xuất";
                    hasError = true;
                }

                equipmentList.forEach((item) => {
                    let currentQuantity = parseInt(document.getElementById(
                        `current_quantity_${item.batch_number}`).value.trim(), 10);

                    if (!item.quantity || item.quantity <= 0 || item.quantity > currentQuantity) {
                        document.getElementById(`quantity_list_${item.batch_number}`).classList.remove(
                            'd-none');
                        hasError = true;
                    } else {
                        document.getElementById(`quantity_list_${item.batch_number}`).classList.add(
                            'd-none');
                    }
                });

                if (hasError) {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    return;
                }

                let formData = new FormData();
                formData.append('department_code', department_code);
                formData.append('supplier_code', supplier_code);
                formData.append('reason', reason);
                formData.append(
                    'export_type', export_type);
                formData.append('export_date', export_date);
                formData.append('note',
                    note);
                formData.append('exportStatus', exportStatus);
                formData.append('equipment_list', JSON
                    .stringify(equipmentList));

                fetch('{{ $action }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message);
                            window.location.href = "{{ route('warehouse.export') }}";
                        } else {
                            toastr.error(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('loading-overlay').style.display = 'none';
                        this.disabled = false;
                    });

            }, 500);
        }

        // Thêm thiết bị vào danh sách xuất
        document.getElementById('add_equipment_to_list').addEventListener('click', async function(event) {
            event.preventDefault();

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(async () => {
                let noDataAlert = document.getElementById('noDataAlert');
                let equipment = document.getElementById('equipment').value.trim();
                let batch_number = document.getElementById('batch_number').value.trim();
                let quantity = parseInt(document.getElementById('quantity').value, 10);

                let equipment_error = document.getElementById('equipment_error');
                let batch_number_error = document.getElementById('batch_number_error');
                let quantity_error = document.getElementById('quantity_error');

                // Reset lỗi
                equipment_error.innerText = '';
                batch_number_error.innerText = '';
                quantity_error.innerText = '';

                let hasError = false;

                // Validation
                if (!equipment) {
                    equipment_error.innerText = "Vui lòng chọn thiết bị cần xuất";
                    hasError = true;
                } else {
                    if (!batch_number) {
                        batch_number_error.innerText = "Vui lòng chọn số lô cần xuất";
                        hasError = true;
                    }

                    if (!quantity || quantity <= 0) {
                        quantity_error.innerText = "Vui lòng nhập số lượng và phải lớn hơn 0";
                        hasError = true;
                    }

                    // Kiểm tra số lượng nhập vào có lớn hơn số lượng tồn kho hay không
                    if (equipment && batch_number) {
                        const batchInfo = equipmentBatches[equipment].find(batch => batch
                            .batch_number === batch_number);
                        if (batchInfo && quantity > batchInfo.total_quantity) {
                            quantity_error.innerText =
                                `Số lượng không thể lớn hơn ${batchInfo.total_quantity}`;
                            hasError = true;
                        }
                    }
                }

                // If any validation errors, stop execution and hide loading
                if (hasError) {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    return;
                }

                // Prepare and send data if no errors
                let formData = new FormData();
                formData.append('equipment', equipment);
                formData.append('batch_number', batch_number);
                formData.append('quantity', quantity);

                fetch('{{ route('warehouse.create_export') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Kiểm tra xem thiết bị đã được thêm chưa
                            if (!addedEquipmentBatchs.includes(data.batch_number)) {
                                addedEquipmentBatchs.push(data.batch_number);
                            }

                            noDataAlert.classList.add('d-none');

                            // Thêm thiết bị vào danh sách trong bảng mà không cần tải lại trang
                            let tableBody = document.getElementById('equipmentList');

                            let newRow = document.createElement('tr');

                            newRow.id =
                                `equipment-row-${data.batch_number}-${data.equipment_code}`;

                            newRow.innerHTML = `
                                <td class="ps-5">${data.equipment_name}</td>
                                <td class="">
                                    <div class="d-flex align-items-center" id="batch_number_change_${data.batch_number}">
                                        ${data.batch_number} - (Tồn Kho: ${data.equipment_current_quantity} ${data.unit_name})
                                    </div>
                                    <input type="hidden" id="current_quantity_${data.batch_number}" value="${data.equipment_current_quantity}" />
                                </td>
                                <td class="">
                                    <div class="d-flex align-items-center">
                                        <input type="number" id="quantity_change_${data.batch_number}"
                                            value="${parseInt(data.quantity, 10)}"
                                            class="form-control form-control-sm border border-success rounded-pill">
                                        <div class="message_error d-none ms-2 m-0 p-0 pointer"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Số Lượng Phải Lớn Hơn 0 Và Nhỏ Hơn ${data.equipment_current_quantity}"
                                            id="quantity_list_${data.batch_number}">
                                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span onclick="removeEquipment('${data.equipment_code}', '${data.batch_number}')" class="pointer">
                                        <i class="fas fa-trash text-danger p-0"></i>
                                    </span>
                                </td>
                                `;

                            tableBody.appendChild(newRow);

                            // Reset form sau khi thêm thành công
                            document.getElementById('quantity').value = "";

                            // Ẩn các tùy chọn đã thêm trong danh sách thiết bị
                            let equipmentOptions = document.querySelectorAll(
                                '#batch_number option');
                            equipmentOptions.forEach(option => {
                                // Kiểm tra nếu giá trị option có trong danh sách addedEquipmentBatchs
                                if (addedEquipmentBatchs.includes(option.value)) {
                                    option.classList.add('d-none'); // Ẩn option
                                }
                            });

                            // Tìm option có giá trị rỗng và đánh dấu là selected
                            let emptyOption = Array.from(equipmentOptions).find(option => option
                                .value === '');
                            if (emptyOption) {
                                emptyOption.selected =
                                    true; // Đánh dấu option có giá trị rỗng là selected
                            }

                            toastr.success("Đã thêm thiết bị vào danh sách");
                        } else {
                            alert('Có lỗi xảy ra');
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('loading-overlay').style.display = 'none';
                        this.disabled = false;
                    });
            }, 500);
        });

        // Xóa thiết bị trong danh sách xuất
        function removeEquipment(equipmentCode, batchNumber) {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                // Tìm hàng trong bảng dựa trên mã thiết bị
                let row = document.getElementById(`equipment-row-${batchNumber}-${equipmentCode}`);
                if (row) {
                    row.remove();
                }

                // Kiểm tra xem bảng có còn hàng nào không và hiển thị thông báo "Không Có Dữ Liệu"
                let tableBody = document.querySelector('#table_list_equipment tbody');
                if (tableBody.rows.length === 1) {
                    document.getElementById('noDataAlert').classList.remove('d-none');
                }

                // Bỏ ẩn các tùy chọn thiết bị đã thêm trong danh sách
                let equipmentOptions = document.querySelectorAll('#batch_number option');
                equipmentOptions.forEach(option => {
                    if (option.value === equipmentCode) {
                        option.classList.remove('d-none');
                    }
                });

                // Cập nhật lại mảng thiết bị đã thêm
                addedEquipmentBatchs = addedEquipmentBatchs.filter(batch_number => batch_number !== batchNumber);
                checkList = checkList.filter(batch_number => batch_number !== batchNumber);

                toastr.success("Đã xóa thiết bị khỏi danh sách");

                document.getElementById('loading').style.display = 'none';
                document.getElementById('loading-overlay').style.display = 'none';
                this.disabled = false;
            }, 500);
        }

        function cEquipment() {
            const cEquipment = document.getElementById('equipment').value;
            const cEquipmentErr = document.getElementById('equipment_error');

            if (cEquipment !== '') {
                cEquipmentErr.innerText = '';
            }
        }

        function cBatchNumber() {
            const cBatchNumber = document.getElementById('batch_number').value;
            const cBatchNumberErr = document.getElementById('batch_number_error');

            if (cBatchNumber !== '') {
                cBatchNumberErr.innerText = '';
            }
        }

        function cQuantity() {
            const cQuantity = document.getElementById('quantity').value;
            const cQuantityErr = document.getElementById('quantity_error');

            if (cQuantity !== '') {
                cQuantityErr.innerText = '';
            }
        }
    </script>
@endsection
