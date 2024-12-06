@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('title')
    Xuất Kho
@endsection

@php
    if (!empty($getExportRequest)) {
        $d_none_save = 'd-none';

        $d_none_save_request = '';

        $d_none_update = 'd-none';

        $d_none_temp = 'd-none';
    } elseif ($action === 'create') {
        $action = route('warehouse.store_export');

        $d_none_save_request = 'd-none';

        $d_none_save = '';

        $d_none_update = 'd-none';

        $d_none_temp = '';
    } elseif ($action === 'update') {
        $action = route('warehouse.update_export', request('code'));

        $d_none_save = 'd-none';

        $d_none_save_request = 'd-none';

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
                    <div class="mb-3 col-md-6">
                        <label for="export_type" class="required form-label fw-semibold">Loại xuất</label>
                        <div class="d-flex align-items-center">
                            <select name="export_type" id="export_type" {{ !empty($getExportRequest) ? 'disabled' : '' }}
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

                    <div class="col-md-6 mb-3 fv-row" id="department_show">
                        <label for="department_code" class="required form-label fw-semibold">Phòng ban</label>
                        <div class="d-flex align-items-center">
                            <select name="department_code" id="department_code"
                                {{ !empty($getExportRequest) ? 'disabled' : '' }}
                                class="form-select form-select-sm border border-success rounded-pill">
                                <option value="0">Chọn Phòng Ban...</option>
                                <option value="1" class="d-none">Chọn Phòng Ban...</option>
                                @foreach ($allDepartment as $item)
                                    <option value="{{ $item->code }}"
                                        {{ (!empty($getExportRequest) && $getExportRequest->department_code == $item->code) ||
                                        (!empty($editExport) && $editExport->department_code == $item->code)
                                            ? 'selected'
                                            : '' }}>
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

                    <div class="col-md-6 mb-3 fv-row d-none" id="supplier_show">
                        <label for="supplier_code" class="required form-label fw-semibold">Nhà cung cấp</label>
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

                    <div class="col-md-6 mb-3 fv-row d-none" id="cancel_reason">
                        <label for="reason" class="required form-label fw-semibold">Lý do hủy</label>
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

                    <div class="mb-3 col-md-6 d-none" id="export_date_div">
                        <label for="" class="form-label fw-semibold">Ngày tạo</label>
                        <input type="date" name="export_date" id="export_date" disabled
                            class="form-control form-control-sm border-success rounded-pill"
                            value="{{ !empty($editExport) && $editExport->export_date ? \Carbon\Carbon::parse($editExport->export_date)->format('Y-m-d') : \Carbon\Carbon::parse(now())->format('Y-m-d') }}">
                        <div class="message_error"></div>
                    </div>

                    @if (
                        !empty($getExportRequest) ||
                            $action == route('warehouse.store_export') ||
                            $action == route('warehouse.update_export', request('code')))
                        <div class="mb-3 col-md-6" id="required_date_div">
                            <label for="" class="form-label fw-semibold">Ngày cần thiết</label>
                            <input type="date" name="required_date" id="required_date"
                                {{ !empty($getExportRequest) ? 'disabled' : '' }}
                                class="form-control form-control-sm border-success rounded-pill"
                                value="{{ !empty($getExportRequest) && $getExportRequest->required_date ? \Carbon\Carbon::parse($getExportRequest->required_date)->format('Y-m-d') : (!empty($editExport->required_date) ? \Carbon\Carbon::parse($editExport->required_date)->format('Y-m-d') : '') }}">
                            <div class="message_error" id="required_date_error"></div>
                        </div>
                    @endif

                    <div class="mb-3 col-md-6">
                        <label for="" class="form-label fw-semibold">Ghi chú</label>
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
                <span class="card-label fw-bolder fs-3 mb-1">Thiết bị xuất</span>
            </h3>
        </div>
        <div class="container {{ !empty($getExportRequest) ? 'd-none' : '' }}">
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
                                    <th style="width: 15%;">Số lượng</th>
                                    <th style="width: 10%;" class="pe-5 {{ !empty($getExportRequest) ? 'd-none' : '' }}">
                                        Hành động
                                    </th>
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
                                                    {{ $item->batch_number }} - (Tồn kho:
                                                    {{ $item->equipments->inventories->where('batch_number', $item->batch_number)->where('equipment_code', $item->equipment_code)->first()->current_quantity ?? 0 }}
                                                    {{ $item->equipments->units->name }})
                                                </div>
                                                <input type="hidden"
                                                    id="current_quantity_{{ $item->batch_number }}_{{ $item->equipment_code }}"
                                                    value="{{ $item->equipments->inventories->where('batch_number', $item->batch_number)->where('equipment_code', $item->equipment_code)->first()->current_quantity ?? 0 }}" />
                                            </td>
                                            <td class="">
                                                <div class="d-flex align-items-center">
                                                    <input type="number" id="quantity_change_{{ $item->batch_number }}"
                                                        value="{{ $item->quantity }}"
                                                        class="form-control form-control-sm border border-success rounded-pill">
                                                    <div class="message_error d-none ms-2 m-0 p-0 pointer"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Số lượng không được vượt quá {{ $item->equipments->inventories->where('batch_number', $item->batch_number)->where('equipment_code', $item->equipment_code)->first()->current_quantity ?? 0 }}"
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
                                @elseif(!empty($getExportRequest))
                                    @foreach ($getExportRequest->export_equipment_request_details as $er)
                                        @php
                                            $batches = $er->equipments->inventories;
                                        @endphp

                                        @php
                                            $singleBatch = null;

                                            if ($batches->count() === 1) {
                                                $singleBatch = $batches->first();
                                            }
                                        @endphp

                                        <tr>
                                            <td colspan="2">
                                                {{ $er->equipments->name }}
                                            </td>
                                            <td class="pe-5">
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Tổng số lượng xuất" class="pointer"
                                                    id="quantity_total_input_{{ $er->equipments->code }}">{{ isset($singleBatch) ? $er->quantity : 0 }}</span>
                                                /
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Số lượng yêu cầu" class="pointer"
                                                    id="quantity_current_by_batch_{{ $er->equipments->code }}">
                                                    {{ $er->quantity }}
                                                </span>
                                                <span class="pointer ms-1 d-none"
                                                    id="quantity_export_request_error_{{ $er->equipments->code }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Tổng số lượng phải bằng với số lượng yêu cầu là {{ $er->quantity }}">
                                                    <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                </span>
                                            </td>
                                        </tr>

                                        @foreach ($batches as $batchNumber)
                                            <tr class="list_batch_export_detail"
                                                id="equipment-row-export-request-{{ $batchNumber->batch_number }}-{{ $batchNumber->equipment_code }}">
                                                <td></td>
                                                <td>
                                                    <div class="d-flex align-ers-center"
                                                        id="batch_number_change_{{ $batchNumber->batch_number }}_{{ $batchNumber->equipment_code }}">
                                                        {{ $batchNumber->batch_number }} - (Tồn kho:
                                                        {{ $batchNumber->current_quantity }}
                                                        {{ $batchNumber->units->name }})
                                                    </div>
                                                    <input type="hidden"
                                                        id="current_quantity_{{ $batchNumber->batch_number }}_{{ $batchNumber->equipment_code }}"
                                                        value="{{ $batchNumber->current_quantity }}" />
                                                </td>
                                                <td class="pe-5">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number"
                                                            id="quantity_change_{{ $batchNumber->batch_number }}_{{ $batchNumber->equipment_code }}"
                                                            value="{{ isset($singleBatch) ? $er->quantity : 0 }}"
                                                            min="0" max="{{ $batchNumber->current_quantity }}"
                                                            class="form-control form-control-sm border border-success rounded-pill"
                                                            data-er-code="{{ $er->equipments->code }}" />
                                                        <div class="message_error d-none ms-2 m-0 p-0 pointer"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Số lượng không được vượt quá {{ $batchNumber->current_quantity }}"
                                                            id="quantity_list_{{ $batchNumber->batch_number }}_{{ $batchNumber->equipment_code }}">
                                                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <script>
                                        document.querySelectorAll('input[type="number"]').forEach(input => {
                                            input.addEventListener('input', function() {
                                                let erCode = this.getAttribute('data-er-code');
                                                let total = 0;

                                                document.querySelectorAll(`input[data-er-code="${erCode}"]`).forEach(item => {
                                                    let value = parseInt(item.value) || 0;
                                                    total += value;
                                                });

                                                document.getElementById(`quantity_total_input_${erCode}`).textContent = total;
                                            });
                                        });
                                    </script>
                                @endif
                                <tr id="noDataAlert"
                                    class="{{ !empty($editExport) || !empty($getExportRequest) ? 'd-none' : '' }}">
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
                        class="btn btn-sm btn-twitter d-flex align-items-center justify-content-center rounded-pill {{ $d_none_save_request }}"
                        id="export_browse">
                        <i class="fas fa-save me-1"></i>Tạo phiếu
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-twitter d-flex align-items-center justify-content-center rounded-pill {{ $d_none_update }}"
                        id="export_update">
                        <i class="fas fa-save me-1"></i>Cập nhật
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-info me-2 d-flex align-items-center justify-content-center rounded-pill {{ $d_none_temp }}"
                        id="export_temp">
                        <i class="fas fa-cloud-arrow-down me-1"></i>Lưu tạm
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-twitter d-flex align-items-center justify-content-center rounded-pill {{ $d_none_save }}"
                        id="export_save">
                        <i class="fas fa-save me-1"></i>Tạo phiếu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form thêm phòng ban -->
    <div class="modal fade" id="add_department" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="add_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="add_modalLabel">Thêm Phòng Ban</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    <div>
                        <label class="required fs-5 er mb-2">Tên phòng ban</label>
                        <input type="text" class="form-control form-control-sm border border-success rounded-pill"
                            placeholder="Tên phòng ban.." name="name" id="department_type_name" />
                        <div class="message_error" id="show-err-department-type"></div>
                    </div>
                    <div class="mb-3">
                        <label class="required fs-5 er mb-2">Vị trí phòng ban</label>
                        <input type="text" class="form-control form-control-sm border border-success rounded-pill"
                            placeholder="Vị trí phòng ban.." name="location" id="department_type_location" />
                        <div class="message_error" id="show-err-department-type-location"></div>
                    </div>
                </div>
                <div class="modal-body pt-0">
                    <div class="overflow-auto" style="max-height: 300px;">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr class="erer bg-success">
                                    <th class="ps-3" style="width: 40%;">Tên phòng ban</th>
                                    <th class="ps-3" style="width: 30%;">Vị trí</th>
                                    <th class="pe-3 text-center" style="width: 30%;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="department-list">
                                @foreach ($allDepartment as $item)
                                    <tr class="hover-table pointer" id="department-{{ $item->code }}">
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->location }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm rounded-pill"
                                                data-bs-toggle="modal" data-bs-target="#delete_modal_department_type"
                                                onclick="setDeleteForm('{{ route('equipment_request.delete_department', $item->code) }}', '{{ $item->name }}')">
                                                <i class="fa fa-trash p-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill"
                        data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-twitter rounded-pill"
                        id="submit_department_type">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Form xóa phòng ban --}}
    <div class="modal fade" id="delete_modal_department_type" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="deleteModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteModalLabel1">Xóa phòng ban</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h6 class="text-danger" id="delete-department-message"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#add_modal_pb">Trở lại</button>
                    <button type="button" class="btn btn-sm btn-danger rounded-pill"
                        id="confirm-delete-department">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form thêm nhà cung cấp -->
    <div class="modal fade" id="add_supplier" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="add_modalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="add_modalLabel2">Thêm Nhà Cung Cấp</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    <div class="mb-3">
                        <label class="required fs-5 er mb-2">Tên nhà cung cấp</label>
                        <input type="text" class="form-control form-control-sm border border-success rounded-pill"
                            placeholder="Tên nhà cung cấp.." name="name" id="supplier_type_name" />
                        <div class="message_error" id="show-err-supplier-type"></div>
                    </div>
                </div>
                <div class="modal-body pt-0">
                    <div class="overflow-auto" style="max-height: 300px;">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr class="erer bg-success">
                                    <th class="ps-3" style="width: 70%;">Tên nhà cung cấp</th>
                                    <th class="pe-3 text-center" style="width: 30%;">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="supplier-list">
                                @foreach ($allSupplier as $item)
                                    <tr class="hover-table pointer" id="supplier-{{ $item->code }}">
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm rounded-pill"
                                                data-bs-toggle="modal" data-bs-target="#delete_modal_supplier_type"
                                                onclick="setDeleteFormSupplier('{{ route('equipment_request.delete_supplier', $item->code) }}', '{{ $item->name }}')">
                                                <i class="fa fa-trash p-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill"
                        data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-twitter rounded-pill"
                        id="submit_supplier_type">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Form xóa nhà cung cấp --}}
    <div class="modal fade" id="delete_modal_supplier_type" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="deleteModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteModalLabel2">Xóa nhà cung cấp</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h6 class="text-danger" id="delete-supplier-message"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#add_modal_ncc">Trở Lại</button>
                    <button type="button" class="btn btn-sm btn-danger rounded-pill"
                        id="confirm-delete-supplier">Xóa</button>
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
            var export_dateSelect = document.getElementById('export_date_div');
            var required_date = document.getElementById('required_date');
            var required_date_div = document.getElementById('required_date_div');

            var supplierSelectErr = document.getElementById('supplier_code_error');
            var departmentSelectErr = document.getElementById('department_code_error');
            var reasonSelectErr = document.getElementById('reason_error');

            if (exportType === 'Xuất Sử Dụng') {
                let firstDepartment = {!! json_encode($editExport ?? []) !!};
                let firstDepartmentByRequestExport = {!! json_encode($getExportRequest ?? []) !!};

                supplierShow.classList.add('d-none');
                departmentShow.classList.remove('d-none');
                cancelReason.classList.add('d-none');
                export_dateSelect.classList.add('d-none');
                required_date_div.classList.remove('d-none');

                if ((firstDepartment && firstDepartment.department_code) || (firstDepartmentByRequestExport &&
                        firstDepartmentByRequestExport.department_code)) {
                    departmentSelect.value = firstDepartment.department_code ?? firstDepartmentByRequestExport
                        .department_code;
                } else {
                    departmentSelect.value = '0';
                }

                supplierSelect.value = '1';
                reasonSelect.value = '1';

                if ("{{ $action }}" === "{{ route('warehouse.store_export') }}") {
                    required_date.value = '';
                }

                supplierSelectErr.innerText = '';
                reasonSelectErr.innerText = '';
            } else if (exportType === 'Xuất Trả') {
                let firstSupplier = {!! json_encode($editExport ?? []) !!};

                departmentShow.classList.add('d-none');
                supplierShow.classList.remove('d-none');
                cancelReason.classList.add('d-none');
                export_dateSelect.classList.remove('d-none');
                required_date_div.classList.add('d-none');

                if (firstSupplier && firstSupplier.supplier_code) {
                    supplierSelect.value = firstSupplier.supplier_code;
                } else {
                    supplierSelect.value = '0';
                }

                departmentSelect.value = '1';
                reasonSelect.value = '1';
                required_date.value = '2090-01-01T12:00:00';

                // Xóa lỗi hiển thị
                departmentSelectErr.innerText = '';
                reasonSelectErr.innerText = '';
            } else if (exportType === 'Xuất Hủy') {
                let firstReason = {!! json_encode($editExport ?? []) !!};

                supplierShow.classList.add('d-none');
                departmentShow.classList.add('d-none');
                cancelReason.classList.remove('d-none');
                export_dateSelect.classList.remove('d-none');
                required_date_div.classList.add('d-none');

                if (firstReason && firstReason.reason) {
                    reasonSelect.value = firstReason.reason;
                } else {
                    reasonSelect.value = '0';
                }

                supplierSelect.value = '1';
                departmentSelect.value = '1';
                required_date.value = '2090-01-01T12:00:00';

                supplierSelectErr.innerText = '';
                departmentSelectErr.innerText = '';
            }
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

        // Xử lý khi chọn thiết bị
        document.getElementById('equipment').addEventListener('change', function() {
            const selectedEquipment = this.value;
            const batchSelect = document.getElementById('batch_number');

            // Xóa các option hiện tại
            batchSelect.innerHTML = '<option value="" id="choose_batch_number">Chọn Số Lô...</option>';

            // Lọc các số lô theo mã thiết bị đã chọn
            const filteredBatches = equipmentBatches.filter(batch => batch.equipment_code === selectedEquipment);

            if (filteredBatches.length > 0) {

                filteredBatches.forEach(function(batch) {
                    const option = document.createElement('option');
                    option.value = batch.batch_number;
                    option.textContent = `${batch.batch_number} - Số lượng: ${batch.total_quantity}`;
                    batchSelect.appendChild(option);
                });

                // Kiểm tra các số lô đã thêm trước đó
                let equipmentOptions = document.querySelectorAll('#batch_number option');
                equipmentOptions.forEach(option => {
                    const batchExistsInAdded = addedEquipmentBatchs.some(item =>
                        item.equipment_code === selectedEquipment && item.batch_number === option.value
                    );

                    const batchExistsInCheckList = checkList.some(item =>
                        item.equipment_code === selectedEquipment && item.batch_number === option.value
                    );

                    if (batchExistsInAdded || batchExistsInCheckList) {
                        option.classList.add('d-none');
                    }
                });

            } else {
                batchSelect.innerHTML = ''; // Nếu không có số lô nào cho thiết bị này
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
                // Tìm thông tin số lượng cho số lô đã chọn
                const batchInfo = equipmentBatches.find(batch =>
                    batch.batch_number === selectedBatch &&
                    batch.equipment_code === selectedEquipment
                );

                if (batchInfo) {
                    const totalQuantity = batchInfo.total_quantity;

                    // Cập nhật trường nhập liệu số lượng
                    const quantityInput = document.getElementById('quantity');
                    quantityInput.setAttribute('max', totalQuantity); // Đặt thuộc tính max
                    quantityInput.value = totalQuantity; // Đặt giá trị mặc định là max
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

        function getEquipmentListExportRequest() {
            let equipmentListExportRequest = [];
            let rowsExportRequest = document.querySelectorAll('.list_batch_export_detail');

            rowsExportRequest.forEach((row) => {
                if (row.id === "noDataAlert") return;

                let parts = row.id.split('-');
                let batchNumberExportRequest = parts[4];
                let equipmentCodeExportRequest = parts[5];

                let quantityIpExportRequest = document.getElementById(
                    `quantity_change_${batchNumberExportRequest}_${equipmentCodeExportRequest}`
                );

                let quantityValueExportRequest = parseInt(quantityIpExportRequest.value.trim(), 10);

                equipmentListExportRequest.push({
                    equipment_code: equipmentCodeExportRequest,
                    quantity: quantityValueExportRequest,
                    batch_number: batchNumberExportRequest,
                });
            });


            return equipmentListExportRequest;
        }

        // Tạo hoặc lưu tạm phiếu xuất
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
                let required_date_create = document.getElementById('required_date').value.trim();
                let note = document.getElementById('note').value.trim();

                let department_code_error = document.getElementById('department_code_error');
                let required_date_error = document.getElementById('required_date_error');
                let supplier_code_error = document.getElementById('supplier_code_error');
                let reason_error = document.getElementById('reason_error');
                let equipment_error = document.getElementById('equipment_error');
                let equipmentList = getEquipmentList();

                department_code_error.innerText = '';
                supplier_code_error.innerText = '';
                reason_error.innerText = '';
                required_date_error.innerText = '';
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

                let requiredDateCreate = new Date(required_date_create);
                let currentDate = new Date();

                if (!required_date_create) {
                    required_date_error.innerText = "Vui lòng thêm ngày cần thiết";
                    hasError = true;
                } else {
                    let timeDifference = requiredDateCreate.getTime() - currentDate.getTime();

                    let differenceInHours = timeDifference / (1000 * 60 * 60);

                    if (differenceInHours < 1) {
                        required_date_error.innerText =
                            "Ngày cần thiết phải lớn hơn thời gian hiện tại ít nhất 1 giờ";
                        hasError = true;
                    } else {
                        required_date_error.innerText = "";
                    }
                }


                if (equipmentList.length === 0) {
                    equipment_error.innerText = "Vui lòng chọn thiết bị cần xuất";
                    hasError = true;
                }

                equipmentList.forEach((item) => {
                    let currentQuantity = parseInt(document.getElementById(
                            `current_quantity_${item.batch_number}_${item.equipment_code}`).value
                        .trim(),
                        10);

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
                formData.append('required_date', required_date_create);
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

        // Lấy sự kiện click
        document.getElementById('export_browse').addEventListener('click', function(event) {
            event.preventDefault();
            handleImportEquipmentRequestBrowse();
        });

        function handleImportEquipmentRequestBrowse() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(async () => {
                let department_code_export_request = document.getElementById('department_code').value.trim();
                let export_type_export_request = document.getElementById('export_type').value.trim();
                let required_date_export_request = document.getElementById('required_date').value.trim();
                let note_export_request = document.getElementById('note').value.trim();

                let equipmentListExportRequest = getEquipmentListExportRequest();

                let hasError = false;

                let equipmentTotals = {};

                equipmentListExportRequest.forEach((item) => {
                    let currentQuantityExportRequest = parseInt(document.getElementById(
                            `current_quantity_${item.batch_number}_${item.equipment_code}`)
                        .value
                        .trim(), 10);

                    if (item.quantity < 0 || item.quantity >
                        currentQuantityExportRequest) {
                        document.getElementById(
                                `quantity_list_${item.batch_number}_${item.equipment_code}`)
                            .classList
                            .remove(
                                'd-none');
                        hasError = true;
                    } else {
                        document.getElementById(
                                `quantity_list_${item.batch_number}_${item.equipment_code}`)
                            .classList
                            .add(
                                'd-none');
                    }

                    if (!equipmentTotals[item.equipment_code]) {
                        equipmentTotals[item.equipment_code] = 0;
                    }

                    equipmentTotals[item.equipment_code] += parseInt(item.quantity, 10);
                });

                Object.keys(equipmentTotals).forEach((equipmentCode) => {
                    let totalQuantity = equipmentTotals[equipmentCode];
                    let requestedQuantity = parseInt(document.getElementById(
                            `quantity_current_by_batch_${equipmentCode}`).innerText
                        .trim(), 10);

                    if (totalQuantity !== requestedQuantity) {
                        document.getElementById(
                                `quantity_export_request_error_${equipmentCode}`).classList
                            .remove('d-none');
                        hasError = true;
                    } else {
                        document.getElementById(
                                `quantity_export_request_error_${equipmentCode}`).classList
                            .add('d-none');
                    }
                });

                if (hasError) {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    return;
                }

                let formDataExportRequest = new FormData();
                formDataExportRequest.append('department_code',
                    department_code_export_request);
                formDataExportRequest.append('export_type',
                    export_type_export_request);
                formDataExportRequest.append('required_date',
                    required_date_export_request);
                formDataExportRequest.append('note',
                    note_export_request);
                formDataExportRequest.append('export_request_code',
                    '{{ request('cd') }}');
                formDataExportRequest.append('equipment_list_export_request', JSON.stringify(
                    equipmentListExportRequest));

                fetch('{{ route('warehouse.export_equipment_request') }}', {
                        method: 'POST',
                        body: formDataExportRequest,
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
                        const batchInfo = equipmentBatches.find(batch =>
                            batch.equipment_code === equipment && batch.batch_number ===
                            batch_number
                        );

                        if (batchInfo && quantity > batchInfo.total_quantity) {
                            quantity_error.innerText =
                                `Số lượng không thể lớn hơn ${batchInfo.total_quantity}`;
                            hasError = true;
                        } else {
                            quantity_error.innerText = '';
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
                            if (!addedEquipmentBatchs.some(item => item.equipment_code === data
                                    .equipment_code && item.batch_number === data.batch_number
                                )) {
                                addedEquipmentBatchs.push({
                                    equipment_code: data.equipment_code,
                                    batch_number: data.batch_number
                                });
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
                                    <input type="hidden" id="current_quantity_${data.batch_number}_${data.equipment_code}" value="${data.equipment_current_quantity}" />
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
                            const selectedEquipment2 = document.getElementById('equipment')
                                .value;
                            equipmentOptions.forEach(option => {
                                // Kiểm tra nếu option có batch_number và equipment_code đã tồn tại trong addedEquipmentBatchs
                                const batchExistsInAdded = addedEquipmentBatchs.some(
                                    item =>
                                    item.equipment_code === selectedEquipment2 &&
                                    // Sửa để dùng đúng selectedEquipment
                                    item.batch_number === option.value
                                );

                                if (batchExistsInAdded) {
                                    option.classList.add(
                                        'd-none'); // Ẩn option nếu đã tồn tại
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

                // Cập nhật lại mảng thiết bị đã thêm
                addedEquipmentBatchs = addedEquipmentBatchs.filter(item =>
                    !(item.equipment_code === equipmentCode && item.batch_number === batchNumber)
                );

                // Lọc checkList để loại bỏ phần tử có cả equipment_code và batch_number
                checkList = checkList.filter(item =>
                    !(item.equipment_code === equipmentCode && item.batch_number === batchNumber)
                );

                // Bỏ ẩn các tùy chọn thiết bị đã thêm trong danh sách
                let equipmentOptions = document.querySelectorAll('#batch_number option');
                equipmentOptions.forEach(option => {
                    // Kiểm tra xem tùy chọn có còn trong mảng addedEquipmentBatchs hay không
                    const batchExistsInAdded = addedEquipmentBatchs.some(item =>
                        item.equipment_code === equipmentCode && item.batch_number === option.value
                    );

                    // Nếu không tồn tại trong mảng thì bỏ lớp 'd-none' để hiện lại
                    if (!batchExistsInAdded) {
                        option.classList.remove('d-none');
                    }
                });

                toastr.success("Đã xóa thiết bị khỏi danh sách");

                document.getElementById('loading').style.display = 'none';
                document.getElementById('loading-overlay').style.display = 'none';
                this.disabled = false;
            }, 500);
        }


        // Thêm phòng ban
        document.getElementById('submit_department_type').addEventListener('click', function(event) {
            event.preventDefault();

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                let departmentTypeName1 = document.getElementById('department_type_name').value.trim();
                let departmentTypeName2 = document.getElementById('department_type_location').value.trim();
                let equipment_error1 = document.getElementById('show-err-department-type');
                let equipment_error2 = document.getElementById('show-err-department-type-location');
                let existingSuppliers = Array.from(document.querySelectorAll(
                    '#department-list tr td:first-child')).map(td => td.textContent.trim());

                equipment_error1.innerText = '';
                equipment_error2.innerText = '';

                if (departmentTypeName1 === '') {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error1.innerText = 'Vui lòng nhập tên phòng ban';
                    departmentTypeName1.focus();
                }

                if (departmentTypeName2 === '') {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error2.innerText = 'Vui lòng nhập vị trí phòng ban';
                    departmentTypeName2.focus();
                }

                if (existingSuppliers.includes(departmentTypeName1)) {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error1.innerText = 'Phòng ban đã tồn tại';
                    departmentTypeName1.focus();
                }

                let formData = new FormData();
                formData.append('name', departmentTypeName1);
                formData.append('location', departmentTypeName2);

                fetch('{{ route('equipment_request.create_export') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Thêm thiết bị vào danh sách trong bảng mà không cần tải lại trang
                            let tableBodySupplier = document.getElementById('department-list');
                            let newRowSupplier = document.createElement('tr');
                            newRowSupplier.id = `department-${data.code}`;
                            newRowSupplier.className = `pointer`;

                            newRowSupplier.innerHTML =
                                `
                            <td>${data.name}</td>
                            <td>${data.location}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#delete_modal_department_type"
                                    onclick="setDeleteForm('{{ route('equipment_request.delete_department', '') }}/` +
                                data.code + `', '` + data.name + `')">
                                    <i class="fa fa-trash p-0"></i>
                                </button>
                            </td>
                            `;

                            tableBodySupplier.prepend(newRowSupplier);

                            let selectOptionSupplier = document.getElementById('department_code');
                            let newOption = document.createElement('option');
                            newOption.value = data.code;
                            newOption.textContent = `${data.name} - ${data.location}`;
                            newOption.id = `option_department_${data.code}`;

                            let defaultOption = selectOptionSupplier.querySelector('option[value="0"]');
                            selectOptionSupplier.insertBefore(newOption, defaultOption
                                .nextSibling);

                            toastr.success("Đã thêm phòng ban");

                            document.getElementById('department_type_name').value = "";
                            document.getElementById('department_type_location').value = "";
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('loading-overlay').style.display = 'none';
                        this.disabled = false;
                    });

                document.getElementById('loading').style.display = 'none';
                document.getElementById('loading-overlay').style.display = 'none';
                this.disabled = false;
            }, 500);
        });

        // Xóa phòng ban
        let deleteActionUrl = '';

        function setDeleteForm(actionUrlDpm, departmentNameDpm) {
            deleteActionUrl = actionUrlDpm;
            document.getElementById('delete-department-message').innerText =
                `Bạn có chắc chắn muốn xóa phòng ban "${departmentNameDpm}" này?`;
        }

        // Xác nhận xóa phòng ban
        document.getElementById('confirm-delete-department').addEventListener('click', function() {

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                fetch(deleteActionUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`department-${data.department.code}`).remove();
                            $('#delete_modal_department_type').modal('hide');
                            $('#add_modal_pb').modal('show');
                            document.getElementById(`option_department_${data.department.code}`)
                                .classList
                                .add(
                                    'd-none');
                            toastr.success("Đã xóa phòng ban");
                        } else {
                            toastr.error(
                                "Không thể xóa phòng ban này vì đã có giao dịch trong hệ thống");
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

        // Thêm nhà cung cấp
        document.getElementById('submit_supplier_type').addEventListener('click', function(event) {
            event.preventDefault();

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                let supplierTypeName = document.getElementById('supplier_type_name').value.trim();
                let equipment_error = document.getElementById('show-err-supplier-type');
                let existingSuppliers = Array.from(document.querySelectorAll(
                    '#supplier-list tr td:first-child')).map(td => td.textContent.trim());

                if (supplierTypeName === '') {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error.innerText = 'Vui lòng nhập tên nhà cung cấp';
                    supplierTypeName.focus();
                }

                if (existingSuppliers.includes(supplierTypeName)) {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                    equipment_error.innerText = 'Nhà cung cấp đã tồn tại';
                    supplierTypeName.focus();
                }

                equipment_error.innerText = '';

                let formData = new FormData();
                formData.append('name', supplierTypeName);

                fetch('{{ route('equipment_request.create_import') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Thêm thiết bị vào danh sách trong bảng mà không cần tải lại trang
                            let tableBodySupplier = document.getElementById('supplier-list');
                            let newRowSupplier = document.createElement('tr');
                            newRowSupplier.id = `supplier-${data.code}`;
                            newRowSupplier.className = `pointer`;

                            newRowSupplier.innerHTML =
                                `
                            <td>${data.name}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#delete_modal_supplier_type"
                                    onclick="setDeleteForm('{{ route('equipment_request.delete_supplier', '') }}/` +
                                data.code + `', '` + data.name + `')">
                                    <i class="fa fa-trash p-0"></i>
                                </button>
                            </td>
                            `;

                            tableBodySupplier.prepend(newRowSupplier);

                            let selectOptionSupplier = document.getElementById('supplier_code');
                            let newOption = document.createElement('option');
                            newOption.value = data.code;
                            newOption.textContent = data.name;
                            newOption.id = `option_supplier_${data.code}`;

                            let defaultOption = selectOptionSupplier.querySelector('option[value="0"]');
                            selectOptionSupplier.insertBefore(newOption, defaultOption
                                .nextSibling);

                            toastr.success("Đã thêm nhà cung cấp");

                            document.getElementById('supplier_type_name').value = "";
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('loading-overlay').style.display = 'none';
                        this.disabled = false;
                    });

                document.getElementById('loading').style.display = 'none';
                document.getElementById('loading-overlay').style.display = 'none';
                this.disabled = false;
            }, 500);
        });

        // Xóa nhà cung cấp
        let deleteActionUrlSpl = '';

        function setDeleteFormSupplier(actionUrlSpl, supplierNameSpl) {
            deleteActionUrlSpl = actionUrlSpl;
            document.getElementById('delete-supplier-message').innerText =
                `Bạn có chắc chắn muốn xóa nhà cung cấp "${supplierNameSpl}" này?`;
        }

        // Xác nhận xóa nhà cung cấp
        document.getElementById('confirm-delete-supplier').addEventListener('click', function() {

            document.getElementById('loading').style.display = 'block';
            document.getElementById('loading-overlay').style.display = 'block';
            this.disabled = true;

            setTimeout(() => {
                fetch(deleteActionUrlSpl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`supplier-${data.supplier.code}`).remove();
                            $('#delete_modal_supplier_type').modal('hide');
                            $('#add_modal_ncc').modal('show');
                            document.getElementById(`option_supplier_${data.supplier.code}`).classList
                                .add(
                                    'd-none');
                            toastr.success("Đã xóa nhà cung cấp");
                        } else {
                            toastr.error(
                                "Không thể xóa nhà cung cấp này vì đã có giao dịch trong hệ thống");
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
