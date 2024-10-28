@extends('master_layout.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .hover-table:hover {
            background: #ccc;
        }

        .btn-group button {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .active-row {
            background: #d1c4e9;
            /* Màu nền khi hàng được nhấp vào */
        }

        .select2-selection__rendered {
            color: #000 !important;
        }

        .selected-row {
            background: #ccc;
        }

        .batch-row:hover {
            background: green !important;
        }

        .expired>td {
            color: red;
        }

        .new-item {
            background-color: #e6f7ff;
            animation: fadeHighlight 3s ease-out forwards;
        }

        @keyframes fadeHighlight {
            from {
                background-color: #e6f7ff;
            }

            to {
                background-color: transparent;
            }
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Xuất Kho</span>
            </h3>

            <div class="card-toolbar">

                <a href="{{ route('warehouse.create_export') }}" style="font-size: 10px;"
                    class="btn btn-sm btn-success rounded-pill">
                    <i style="font-size: 10px;" class="fas fa-plus"></i>Tạo Phiếu Xuất</a>
            </div>
        </div>

        {{-- Bộ lọc --}}
        <div class="card-body py-1">
            <form id="filterForm" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="row align-items-center">
                        <div class="col-5 pe-0">
                            <input type="date" name="start_date"
                                class="form-control form-control-sm form-control-solid bg-white border-success rounded-pill"
                                value="{{ \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
                        </div>
                        <div class="col-2 text-center">Đến</div>
                        <div class="col-5 ps-0">
                            <input type="date" name="end_date"
                                class="form-control form-control-sm form-control-solid bg-white border-success rounded-pill"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-2">

                </div>

                <div class="col-md-2">

                </div>


                <div class="col-md-4">
                    <div class="input-group">
                        <input type="search" id="search" name="search" placeholder="Tìm Kiếm Mã, Số Hóa Đơn.."
                            class="form-control form-control-sm form-control-solid border-success bg-white rounded-pill">
                    </div>
                </div>

                <div id="searchResults"></div>
            </form>

        </div>

        {{-- Danh sách phiếu  --}}
        <div class="card-body py-3">
            <div class="table-responsive rounded">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr class="bg-success text-white text-center    ">
                            <th class="ps-3">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-3">Mã Phiếu Xuất</th>
                            <th class="">Ngày Xuất</th>
                            <th class="">Tạo bởi</th>
                            <th class="pe-3">Lý Do Xuất</th>
                            <th class="" style="width:10%">Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($exports as $export)
                            <tr class="text-center hover-table pointer bg-white" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $export->code }}" aria-expanded="false"
                                aria-controls="collapse{{ $export->code }}">
                                <td class="text-center">
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td class="text-center">{{ $export->code }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($export->export_date)->format('d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    {{ $export->user->last_name . ' ' . $export->user->first_name }}
                                </td>
                                <td class="text-center">{{ $export->note ?? 'Không có' }}</td>
                                <td class="text-center">
                                    @if ($export->status == 0)
                                        <div class="label label-final bg-danger rounded-pill text-white px-2 py-1">Chờ duyệt
                                        </div>
                                    @elseif($export->status == 1)
                                        <div class="label label-final bg-success rounded-pill text-white px-2 py-1">Đã duyệt
                                        </div>
                                    @elseif($export->status == 2)
                                        <div class="label label-final bg-info rounded-pill text-white px-2 py-1">Lưu tạm
                                        </div>
                                    @endif
                                </td>
                                <td>Chi Tiết<i class="fa fa-caret-right pointer ms-2"></i></td>
                            </tr>
                            <tr class="collapse multi-collapse" id="collapse{{ $export->code }}">
                                <td class="p-0" colspan="12"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa;">
                                    <div class="flex-lg-row-fluid border-2 border-lg-1">
                                        <div class="card card-flush p-2 mb-3">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2">
                                                <h4 class="fw-bold m-0 text-uppercase fw-bolder">Chi tiết phiếu xuất kho
                                                </h4>
                                                @if ($export->status == 0)
                                                    <div
                                                        class="label label-final bg-danger rounded-pill text-white px-2 py-1">
                                                        Chờ duyệt
                                                    </div>
                                                @elseif($export->status == 1)
                                                    <div
                                                        class="label label-final bg-success rounded-pill text-white px-2 py-1">
                                                        Đã duyệt
                                                    </div>
                                                @elseif($export->status == 2)
                                                    <div
                                                        class="label label-final bg-info rounded-pill text-white px-2 py-1">
                                                        Lưu tạm
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="card-body p-2 pt-0">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <table class="table gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-start w-50"><strong>Mã phiếu
                                                                            xuất</strong></td>
                                                                    <td class="text-start text-dark">{{ $export->code }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start w-50"><strong>Phòng ban</strong></td>
                                                                    <td class="text-start text-dark">{{ $export->departments->name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start w-50"><strong>Ngày xuất</strong>
                                                                    </td>
                                                                    <td class="text-start text-dark">
                                                                        {{ $export->export_date }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start w-50"><strong>Người tạo</strong>
                                                                    </td>
                                                                    <td class="text-start text-dark">
                                                                        {{ $export->user->last_name . ' ' . $export->user->first_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start w-50"><strong>Ghi chú</strong>
                                                                    </td>
                                                                    <td class="text-start text-dark">{{ $export->note }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered">
                                                            <thead class="fw-bolder bg-danger text-white">
                                                                <tr class="text-center">
                                                                    <th class="px-5">STT</th>
                                                                    <th class="">Mã vật tư</th>
                                                                    <th class="">Tên vật tư</th>
                                                                    <th class="">Số lô</th>
                                                                    <th class="">Số lượng</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($export->exportDetail as $detail)
                                                                    <tr class="text-center">
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $detail->equipment_code }}</td>
                                                                        <td>{{ $detail->equipments->name ?? 'Không có' }}
                                                                        </td>
                                                                        <td>{{ $detail->batch_number }}</td>
                                                                        <td>{{ $detail->quantity }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body py-3 text-end">
                                            <div class="button-group">
                                                @if ($export->status == 0 || $export->status == 2)
                                                    <button class="btn btn-sm btn-success me-2" data-bs-toggle="modal"
                                                        data-bs-target="#browse{{ $export->code }}" type="button">
                                                        <i class="fas fa-clipboard-check"></i> Duyệt Phiếu
                                                    </button>
                                                    <a class="btn btn-sm btn-dark me-2"
                                                        href="{{ route('warehouse.edit_export', $export->code) }}">
                                                        <i class="fa fa-edit"></i> Sửa Phiếu
                                                    </a>
                                                    <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                        data-bs-target="#deleteConfirm{{ $export->code }}"
                                                        type="button">
                                                        <i class="fa fa-trash"></i> Xóa Phiếu
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-twitter me-2" type="button"
                                                    onclick="printInvoice('{{ $export->code }}')">
                                                    <i class="fa fa-print"></i> In Phiếu
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="printArea_{{ $export->code }}">
                                            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                <div class="d-flex mb-5">
                                                    <img src="{{ asset('image/logo_warehouse.png') }}" width="100"
                                                        alt="">
                                                    <div class="text-left mt-3 ms-3">
                                                        <h6 class="mb-0 pb-0">BỆNH VIỆN ĐA KHOA BEESOFT</h6>
                                                        <div>307C Nguyễn Văn Linh, An Khánh, Ninh Kiều, Cần Thơ</div>
                                                        <div>Hotline: 0900900999</div>
                                                    </div>
                                                </div>
                                                <form action="" method="post">
                                                    <div class="text-center mb-4">
                                                        <h1 class="mb-3 text-uppercase text-primary">Phiếu xuất kho</h1>
                                                        <div class="text-muted fs-30">
                                                            Ngày lập:
                                                            {{ \Carbon\Carbon::parse($export->export_date)->format('d-m-Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-start" style="width: 40%;"><strong>Mã
                                                                            phiếu xuất:</strong><span
                                                                            class="ms-2">{{ $export->code }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start" style="width: 40%;"><strong>Phòng ban:</strong><span
                                                                            class="ms-2">{{ $export->departments->name }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start"><strong>Ngày xuất:</strong><span
                                                                            class="ms-2">{{ $export->export_date }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-start"><strong>Người tạo:</strong><span
                                                                            class="ms-2">{{ $export->user->last_name . ' ' . $export->user->first_name }}</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mb-4 text-left">
                                                        <h4 class="text-primary mb-3">Danh sách thiết bị</h4>
                                                        <div class="table-responsive">
                                                            <table class="table border border-dark align-middle gs-0 gy-4">
                                                                <thead class="bg-danger border border-dark text-center">
                                                                    <tr>
                                                                        <th class="ps-3 text-dark">STT</th>
                                                                        <th class="text-dark">Mã vật tư</th>
                                                                        <th class="text-dark">Tên vật tư</th>
                                                                        <th class="text-dark">Số lô</th>
                                                                        <th class="text-dark">Số lượng</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($export->exportDetail as $details)
                                                                        <tr class="text-center border border-dark">
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $details->equipment_code }}</td>
                                                                            <td>{{ $details->equipments->name ?? 'Không có' }}
                                                                            </td>
                                                                            <td>{{ $details->batch_number }}</td>
                                                                            <td>{{ $details->quantity }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div>
                                                            <p><strong>Ghi Chú:</strong> <span>{{ $export->note }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-8"></div>
                                                        <div class="col-4 text-right">
                                                            <p class="m-0 p-0">
                                                                Cần Thơ, ngày {{ \Carbon\Carbon::now()->day }} tháng
                                                                {{ \Carbon\Carbon::now()->month }} năm
                                                                {{ \Carbon\Carbon::now()->year }} <br>
                                                                Người lập phiếu <br>
                                                                <strong
                                                                    class="text-primary">{{ $export->user->last_name . ' ' . $export->user->first_name }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                            {{-- Kiểm tra trạng thái của phiếu --}}
                            @if ($export->status !== 1)
                                {{-- Modal Duyệt Phiếu --}}
                                <div class="modal fade" id="browse{{ $export->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="browseLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title text-white" id="browseLabel">Duyệt Phiếu</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center" style="padding-bottom: 0px;">
                                                <form action="{{ route('warehouse.approve_export', $export->code) }}"
                                                    method="POST">
                                                    @csrf
                                                    <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt phiếu này?</p>
                                                    <div class="modal-footer justify-content-center border-0">
                                                        <button type="button"
                                                            class="btn btn-sm btn-secondary btn-sm px-4"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success px-4">Duyệt</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Xác Nhận Xóa --}}
                                <div class="modal fade" id="deleteConfirm{{ $export->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteConfirmLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa
                                                    Phiếu</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center" style="padding-bottom: 0px;">
                                                <form id="deleteForm{{ $export->code }}"
                                                    action="{{ route('warehouse.delete_export', $export->code) }}"
                                                    method="POST">
                                                    @csrf
                                                    <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa phiếu này?</p>
                                                    <input type="hidden" name="export_code"
                                                        value="{{ $export->code }}">
                                                </form>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0">
                                                <button type="button" class="btn btn-sm btn-secondary px-4"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <button type="button" class="btn btn-sm btn-danger px-4"
                                                    onclick="document.getElementById('deleteForm{{ $export->code }}').submit();">Xóa</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr id="noDataAlert">
                                <td colspan="12" class="text-center">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin phiếu
                                                xuất trống</h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Hiện tại chưa có phiếu xuất nào được thêm vào. Vui lòng kiểm tra lại hoặc
                                                tạo mới phiếu xuất để bắt đầu.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/warehouse/export.js') }}"></script>
@endsection
