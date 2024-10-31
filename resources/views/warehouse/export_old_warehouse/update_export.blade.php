@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_export.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .batch-row:hover {
            background: green !important;
        }

        .expired>td {
            color: red;
        }

        .is-invalid {
            border-color: red !important;
            background-color: #f8d7da;
            box-shadow: none;
            /* Loại bỏ hiệu ứng đổ bóng nếu có */
        }
    </style>
@endsection

@section('title')
    Xuất Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        {{-- Tiêu đề --}}
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1 text-uppercase">Cập Nhật Phiếu Xuất</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark rounded-pill" style="font-size: 10px;">
                    <i class="fa fa-arrow-left me-1" style="font-size: 10px;"></i>Trở Lại
                </a>
            </div>
        </div>

        <!-- Form thêm thiết bị -->
        <form action="{{ route('warehouse.update_export', $export->code) }}" id="warehouse-export-form" method="POST">
            @csrf
            <div class="container mt-4">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-3">
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <label for="material_code" class="required form-label mb-2">Tên thiết bị</label>
                                    <div class="d-flex align-items-center">
                                        <select class="form-select setupSelect2 bg-white form-select-sm rounded-pill"
                                            id="material_code" name="equipment_code" style="width: 100%;">
                                            <option value="" selected>Chọn thiết bị</option>
                                            @foreach ($equipments as $equipment)
                                                <option value="{{ $equipment->code }}"
                                                    data-total-inventory="{{ $equipment->total_inventory }}">
                                                    {{ $equipment->name }} - (Tổng tồn: {{ $equipment->total_inventory }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <h6 class="mb-3">Danh sách lô:</h6>
                                    <div id="batch_info" class="list-group">
                                        <table class="table table-hover table-striped align-middle text-center">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th class="text-center">Số lô</th>
                                                    <th class="text-center">Tồn kho</th>
                                                    <th class="text-center">Hạn dùng</th>
                                                    <th class="text-center">Số lượng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="noDataAlert">
                                                    <td colspan="5" class="text-center">
                                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                                            role="alert"
                                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                                            <div class="mb-3">
                                                                <i class="fas fa-file-invoice"
                                                                    style="font-size: 36px; color: #6c757d;"></i>
                                                            </div>
                                                            <div class="text-center">
                                                                <h5
                                                                    style="font-size: 16px; font-weight: 600; color: #495057;">
                                                                    Thông tin tồn kho trống</h5>
                                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                                    Hiện tại chưa có thiết bị nào được thêm vào. Vui lòng
                                                                    kiểm
                                                                    tra lại hoặc tạo mới thiết bị để bắt đầu.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle text-center" id="material-list">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Mã thiết bị</th>
                                        <th class="">Tên thiết bị</th>
                                        <th class="">Số lô</th>
                                        <th class="">Số lượng</th>
                                        <th class="">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="material-list-body">
                                    @foreach ($export->exportDetail as $detail)
                                        <tr data-batch-number="{{ $detail->batch_number }}"
                                            data-equipment-code="{{ $detail->equipment_code }}">
                                            <td>{{ $detail->equipments->code }}</td>
                                            <td>{{ $detail->equipments->name }}</td>
                                            <td>{{ $detail->batch_number }}</td>

                                            @php
                                                $inventory = $detail->equipments->inventories
                                                    ->where('batch_number', $detail->batch_number)
                                                    ->first();
                                                $maxQuantity = $inventory ? $inventory->current_quantity : 0;
                                            @endphp

                                            <td class="text-center d-flex justify-content-center">
                                                <input type="number"
                                                    class="form-control form-control-sm border border-success rounded-pill quantity-input-add"
                                                    style="max-width: 100px; " value="{{ $detail->quantity }}"
                                                    max="{{ $maxQuantity }}" placeholder="Số lượng"
                                                    style="text-align: left; width: 100px;">

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-material"
                                                    style="font-size:10px">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>

                        </div>

                    </div>

                    <div class="col-4">
                        <div class="card border-0 shadow-sm p-4 mb-4 bg-white rounded-4 mt-3">
                            <h6 class="mb-4 fw-bold text-dark text-uppercase"><i
                                    class="fas fa-info-circle me-2 text-primary"></i>Thông tin phiếu xuất</h6>
                            <div class="mb-4">
                                <label for="department_code_{{ $export->code }}"
                                    class="form-label fw-semibold text-muted">Mã phòng ban</label>
                                <div class="d-flex" style="width: 100%;">
                                    <select name="department_code"
                                        class="form-select form-select-sm setupSelect2 rounded-pill"
                                        id="department_code_{{ $export->code }}" style="width: calc(10  0% - 40px);"
                                        required>
                                        <option value="">-- Chọn phòng ban --</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department['code'] }}"
                                                @if (isset($export->department_code) && $export->department_code == $department['code']) selected @endif>
                                                {{ $department['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="ms-2 pointer d-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#add_modal_pb" title="Thêm phòng ban">
                                        <i class="fa fa-plus bg-primary rounded-circle p-2 text-white"
                                            style="width: 25px; height: 25px;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="created_by" class="form-label fw-semibold text-muted">Người tạo</label>
                                <input type="text" name="created_by"
                                    value="{{ $export->user->last_name . ' ' . $export->user->first_name }}"
                                    class="form-control form-control-sm bg-white rounded-pill py-2 px-3" id="export_at"
                                    disabled>
                            </div>

                            <div class="mb-4">
                                <label for="export_at" class="form-label fw-semibold text-muted">Ngày xuất</label>
                                <input type="date" name="export_at"
                                    class="form-control form-control-sm rounded-pill py-2 px-3" id="export_at"
                                    value="{{ $export->export_date }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="note" class="form-label fw-semibold text-muted">Ghi chú</label>
                                <textarea name="note" class="form-control form-control-sm rounded-3 py-2 px-3" id="note" rows="5"
                                    placeholder="Nhập ghi chú..."></textarea>
                            </div>

                            <hr class="my-4">
                            <input type="hidden" name="material_list" id="material_list_input">
                            <button type="submit" name="status" value="2"
                                class="btn btn-sm btn-info w-100 mb-2 d-flex align-items-center justify-content-center rounded-pill">
                                <i class="fas fa-cloud-arrow-down me-1"></i>Cập nhật
                            </button>
                            <button type="submit" name="status" value="0"
                                class="btn btn-twitter btn-sm rounded-pill w-100">
                                <i class="fas fa-save me-1"></i>Tạo phiếu
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    @include('warehouse.export_warehouse.modal')
@endsection

@section('scripts')
    <script>
        const postExportUrl = '{{ route('warehouse.post_export') }}';
        const csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/warehouse/export_store.js') }}"></script>

    <script>
        document.querySelectorAll('.quantity-input-add').forEach(input => {
            input.addEventListener('input', function() {
                const max = parseInt(this.getAttribute('max')) || 0;
                const value = parseInt(this.value) || 0;

                if (value > max) {
                    this.classList.add('is-invalid'); // Thêm class báo lỗi
                } else {
                    this.classList.remove('is-invalid'); // Xóa class báo lỗi
                }
            });
        });
    </script>
@endsection
