@extends('master_layout.layout')

@section('styles')
    <style>
        .custom-w {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 350px;
        }
    </style>
@endsection

@section('title')
    Xuất Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Xuất Kho</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('warehouse.trash_export') }}" class="btn btn-sm btn-danger rounded-pill me-2">
                    <i class="fas fa-trash" style="margin-bottom: 2px;"></i> Thùng Rác
                </a>
                <a href="{{ route('warehouse.create_export') }}" class="btn btn-success btn-sm rounded-pill">
                    <i class="fa fa-plus me-1" style="margin-bottom: 2px;"></i>Tạo Phiếu
                </a>
            </div>
        </div>
        @include('warehouse.export_warehouse.filter')

        <form action="{{ route('warehouse.export') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive rounded">
                    <table class="table align-middle gs-0 gy-4">
                        <thead class="{{ $exports->count() == 0 ? 'd-none' : '' }}">
                            <tr class="bg-success">
                                <th class="ps-3">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th style="width: 15%;">Mã</th>
                                <th class="" style="width: 17%;">Loại xuất</th>
                                <th class="" style="width: 16%;">Tạo bởi</th>
                                <th class="" style="width: 12%;">Ngày tạo</th>
                                <th class="" style="width: 15%;">Ngày cần thiết</th>
                                <th class="text-center" style="width: 10%;">Trạng thái</th>
                                <th class="pe-3 text-center" style="width: 15%;">Hành động</th>
                            </tr>
                        </thead>

                        <!-- Trong phần <tbody> của bảng -->
                        <tbody>
                            @forelse ($exports as $item)
                                <tr class="hover-table pointer">
                                    <td>
                                        @if ($item->status == 0 && $item->created_by == session('user_code'))
                                            <input type="checkbox" name="import_codes[]" value="{{ $item->code }}"
                                                class="row-checkbox" />
                                        @elseif ($item->status == 3)
                                            <i class="fa fa-clock text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Lưu Tạm"></i>
                                        @elseif ($item->status == 1 && $item->export_type === 'Xuất Sử Dụng')
                                            <i class="fas fa-building text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Xuất sử dụng"></i>
                                        @elseif ($item->status == 1 && $item->export_type === 'Xuất Trả')
                                            <i class="fa fa-truck text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Xuất trả"></i>
                                        @elseif ($item->status == 1 && $item->export_type === 'Xuất Hủy')
                                            <i class="fa fa-trash text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Xuất hủy"></i>
                                        @elseif ($item->status == 1 && $item->export_type === 'Xuất cân bằng kho')
                                            <i class="fa-solid fa-scale-balanced text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Xuất cân bằng kho"></i>
                                        @endif
                                    </td>
                                    <td>
                                        #{{ $item->code }}
                                    </td>
                                    <td>
                                        {{ $item->export_type ?? 'Không có' }}
                                    </td>
                                    <td>
                                        {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->export_date)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ !empty($item->required_date) ? \Carbon\Carbon::parse($item->required_date)->format('d/m/Y H:i:s') : 'Không xó' }}
                                    </td>
                                    <td class="text-center">
                                        @if (($item->status == 0 || $item->status == 3) && now()->gt(\Carbon\Carbon::parse($item->required_date)))
                                            <div class="label label-temp bg-warning rounded-pill text-dark px-2 py-1">
                                                Hết hạn
                                            </div>
                                        @elseif ($item->status == 3)
                                            <div class="label label-temp bg-info rounded-pill text-white px-2 py-1">
                                                Lưu tạm
                                            </div>
                                        @elseif ($item->status == 0)
                                            <div class="label label-temp bg-danger rounded-pill text-white px-2 py-1">
                                                Chờ duyệt
                                            </div>
                                        @elseif ($item->status == 1)
                                            <div class="label label-final bg-success rounded-pill text-white px-2 py-1">
                                                Đã duyệt
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $item->code }}" aria-expanded="false"
                                        aria-controls="collapse_{{ $item->code }}">
                                        Chi Tiết<i class="fa fa-caret-right pointer ms-2"></i>
                                    </td>
                                </tr>

                                <!-- Collapse content -->
                                <tr>
                                    <td class="p-0" colspan="12"
                                        style="background-color: #fafafa; padding-top: 0 !important;">
                                        <div class="flex-lg-row-fluid border-2 border-lg-1 collapse multi-collapse"
                                            id="collapse_{{ $item->code }}">
                                            <div class="card card-flush p-2"
                                                style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                                <div class="card-header d-flex justify-content-between align-items-center p-3 pb-0"
                                                    style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                    <h4 class="fw-bold m-0 text-uppercase fw-bolder">
                                                        Chi tiết phiếu xuất kho
                                                    </h4>
                                                    <div class="card-toolbar">
                                                        @if (($item->status == 0 || $item->status == 3) && now()->gt(\Carbon\Carbon::parse($item->required_date)))
                                                            <div class="rounded-pill px-2 py-1 text-dark bg-warning">
                                                                Hết hạn
                                                            </div>
                                                        @elseif ($item->status == 3)
                                                            <div class="rounded-pill px-2 py-1 text-white bg-info">
                                                                Lưu tạm
                                                            </div>
                                                        @elseif($item->status == 0)
                                                            <div class="rounded-pill px-2 py-1 text-white bg-danger">
                                                                Chờ
                                                                duyệt
                                                            </div>
                                                        @elseif($item->status == 1)
                                                            <!--@if (session('isAdmin') == 1)
    -->
                                                            <!--    <button type="button"-->
                                                            <!--        class="btn btn-danger px-2 py-1 btn-sm rounded-pill me-2"-->
                                                            <!--        data-bs-toggle="modal"-->
                                                            <!--        data-bs-target="#delete-{{ $item->code }}"-->
                                                            <!--        {{ $item->no_action == 1 || str_contains($item->code, 'PX-KK') ? 'disabled' : '' }}>-->
                                                            <!--        <i class="fa fa-trash"-->
                                                            <!--            style="margin-bottom: 2px;"></i>Xóa phiếu-->
                                                            <!--    </button>-->
                                                            <!--
    @endif-->

                                                            @if (session('isAdmin') == 1)
                                                                <button type="button"
                                                                    class="btn btn-danger px-2 py-1 btn-sm rounded-pill me-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete-{{ $item->code }}"
                                                                    {{ $item->no_action == 1 || str_contains($item->code, 'PX-KK') ? 'disabled' : '' }}>
                                                                    <i class="fa fa-trash"
                                                                        style="margin-bottom: 2px;"></i>
                                                                    Xóa phiếu
                                                                </button>
                                                            @endif

                                                            <div class="rounded-pill px-2 py-1 text-white bg-success me-2">
                                                                <i class="fa fa-check text-white"
                                                                    style="margin-bottom: 4px; margin-right: 3px; font-size: 10px;"></i>
                                                                Đã
                                                                duyệt
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-body p-3 pt-0">
                                                    <div class="row" style="padding-top: 0px !important">
                                                        <div class="col-md-7">
                                                            <table class="table table-flush gy-1">
                                                                <tbody>
                                                                    @if ($item->export_type === 'Xuất Sử Dụng')
                                                                        <tr>
                                                                            <td class=""><strong>Phòng ban</strong>
                                                                            </td>
                                                                            <td class="text-dark">
                                                                                {{ $item->departments->name ?? 'Không có' }}
                                                                            </td>
                                                                        </tr>
                                                                    @elseif($item->export_type === 'Xuất Trả')
                                                                        <tr>
                                                                            <td class=""><strong>Nhà cung
                                                                                    cấp</strong>
                                                                            </td>
                                                                            <td class="text-dark">
                                                                                {{ $item->suppliers->name ?? 'Không có' }}
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td class=""><strong>Lý do hủy</strong>
                                                                            </td>
                                                                            <td class="text-dark">
                                                                                {{ $item->reason ?? 'Không có' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $canApprove = true;
                                                    @endphp
                                                    <!-- Begin::Receipt Items (Right column) -->
                                                    <div class="col-md-12">
                                                        <div class="table-responsive rounded">
                                                            <table class="table table-striped table-sm table-hover">
                                                                <thead class="fw-bolder bg-dark">
                                                                    <tr class="text-center">
                                                                        <th class="ps-5 text-left" style="width: 50%;">
                                                                            Tên thiết bị
                                                                        </th>
                                                                        <th style="width: 25%;">Số lô</th>
                                                                        <th class="pe-3" style="width: 25%;">Số lượng
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->exportDetail as $detail)
                                                                        @php
                                                                            $totalBatchQuantity = 0;
                                                                            foreach (
                                                                                $detail->equipments->inventories
                                                                                as $inventory
                                                                            ) {
                                                                                if (
                                                                                    $inventory->batch_number ==
                                                                                    $detail->batch_number
                                                                                ) {
                                                                                    $totalBatchQuantity +=
                                                                                        $inventory->current_quantity;
                                                                                }
                                                                            }

                                                                            if (
                                                                                $detail->quantity > $totalBatchQuantity
                                                                            ) {
                                                                                $canApprove = false;
                                                                            }
                                                                        @endphp

                                                                        <tr class="text-center">
                                                                            <td class="ps-5 text-left">
                                                                                {{ $detail->equipments->name }}
                                                                            </td>
                                                                            <td>{{ $detail->batch_number }}</td>
                                                                            <td>
                                                                                <span data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Số Lượng Xuất Kho">{{ $detail->quantity }}</span>
                                                                                @if ($item->status == 3 || $item->status == 0)
                                                                                    @foreach ($detail->equipments->inventories as $inventory)
                                                                                        @if ($inventory->batch_number == $detail->batch_number)
                                                                                            / <span
                                                                                                data-bs-toggle="tooltip"
                                                                                                data-bs-placement="top"
                                                                                                title="Số Lượng Tồn Kho">
                                                                                                {{ $inventory->current_quantity }}
                                                                                            </span>
                                                                                            @if ($detail->quantity > $inventory->current_quantity)
                                                                                                <i data-bs-toggle="tooltip"
                                                                                                    data-bs-placement="top"
                                                                                                    title="Vượt Quá Số Lượng Tồn Kho"
                                                                                                    class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- End::Receipt Items -->
                                                </div>
                                            </div>

                                            <div class="card-body py-1 text-end bg-white pb-5">
                                                <div class="button-group">
                                                    <!-- Nút Duyệt đơn, chỉ hiển thị khi là Phiếu Tạm -->
                                                    @if ($item->status == 0 && now()->lt(\Carbon\Carbon::parse($item->required_date)))
                                                        @if (session('isAdmin') == 1)
                                                            @if ($canApprove)
                                                                <button class="btn btn-sm btn-twitter rounded-pill me-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#browse-{{ $item->code }}"
                                                                    type="button">
                                                                    <i class="fas fa-clipboard-check"
                                                                        style="margin-bottom: 2px;"></i> Duyệt phiếu
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-secondary rounded-pill me-2"
                                                                    type="button" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="Trong danh sách có thiết bị chứa số
                                                                    lượng xuất vượt quá số lượng tồn">
                                                                    <i class="fas fa-save"
                                                                        style="margin-bottom: 2px;"></i> Không thể duyệt
                                                                </button>
                                                            @endif
                                                        @endif

                                                        @if ($item->created_by == session('user_code') || session('isAdmin') == 1)
                                                            <a href="{{ route('warehouse.edit_export', $item->code) }}"
                                                                class="btn btn-dark btn-sm me-2 rounded-pill">
                                                                <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                                phiếu
                                                            </a>

                                                            <button type="button"
                                                                class="btn btn-danger btn-sm rounded-pill"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-{{ $item->code }}">
                                                                <i class="fa fa-trash" style="margin-bottom: 2px;"></i>Hủy
                                                                phiếu
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @if (($item->status == 0 || $item->status == 3) && now()->gt(\Carbon\Carbon::parse($item->required_date)))
                                                        {{-- Quá ngày cần thiết --}}
                                                        <!-- Nút Hủy đơn -->
                                                        <button class="btn btn-sm rounded-pill btn-danger me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal_{{ $item->code }}"
                                                            type="button">
                                                            <i class="fa fa-trash" style="margin-bottom: 2px;"></i>Hủy
                                                            phiếu
                                                        </button>
                                                    @endif

                                                    @if ($item->status == 3 && $item->created_by == session('user_code'))
                                                        @if ($canApprove)
                                                            <button class="btn btn-sm btn-twitter rounded-pill me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#create-{{ $item->code }}"
                                                                type="button">
                                                                <i class="fas fa-save" style="margin-bottom: 2px;"></i>Tạo
                                                                Phiếu
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-secondary rounded-pill me-2"
                                                                type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Trong danh sách có thiết bị chứa số
                                                                lượng xuất vượt quá số lượng tồn">
                                                                <i class="fas fa-save" style="margin-bottom: 2px;"></i>
                                                                Không thể tạo
                                                            </button>
                                                        @endif

                                                        <a href="{{ route('warehouse.edit_export', $item->code) }}"
                                                            class="btn btn-dark btn-sm me-2 rounded-pill">
                                                            <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                            phiếu
                                                        </a>

                                                        <button type="button" class="btn btn-danger btn-sm rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-{{ $item->code }}">
                                                            <i class="fa fa-trash" style="margin-bottom: 2px;"></i>Hủy
                                                            phiếu
                                                        </button>
                                                    @endif

                                                    @if ($item->status == 1)
                                                        <!-- Nút In Phiếu -->
                                                        <button class="btn btn-sm btn-dark me-2 rounded-pill"
                                                            type="button" onclick="printInvoice('{{ $item->code }}')">
                                                            <i class="fa fa-print" style="margin-bottom: 2px;"></i>
                                                            In phiếu
                                                        </button>

                                                        {{-- In --}}
                                                        <div class="fade modal" id="printArea_{{ $item->code }}">
                                                            <span class="link-primary position-absolute"
                                                                style="top: 5%; right: 4%;">
                                                                <strong class="text-danger">
                                                                    Mã:
                                                                </strong>
                                                                {{ $item->code }}
                                                            </span>
                                                            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                                <div class="d-flex mb-5">
                                                                    <img src="{{ asset('image/logo_warehouse.png') }}"
                                                                        width="100" alt="">
                                                                    <div class="text-left mt-3">
                                                                        <h6 class="mb-0 pb-0">BỆNH VIỆN ĐA KHOA BEESOFT
                                                                        </h6>
                                                                        <div>307C Nguyễn Văn Linh, An Khánh, Ninh Kiều,
                                                                            Cần Thơ
                                                                        </div>
                                                                        <div>Hotline: 0900900999</div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-center mb-7">
                                                                    <h1 class="mb-3 text-uppercase text-primary">
                                                                        THÔNG TIN PHIẾU XUẤT
                                                                    </h1>
                                                                    <div class="text-muted fs-30">
                                                                        Ngày Tạo
                                                                        {{ \Carbon\Carbon::parse($item->request_date)->format('d-m-Y') }}
                                                                    </div>
                                                                </div>
                                                                <div class="mb-15 text-left">
                                                                    <div class="card card-flush p-2"
                                                                        style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                                                        <div class="card-body p-3 pt-0">
                                                                            <div class="row"
                                                                                style="padding-top: 0px !important">
                                                                                <table class="table table-flush gy-1">
                                                                                    <tbody>
                                                                                        @if ($item->export_type === 'Xuất Sử Dụng')
                                                                                            <tr>
                                                                                                <td class="w-25">
                                                                                                    <strong>Phòng
                                                                                                        ban:</strong>
                                                                                                </td>
                                                                                                <td class="text-dark">
                                                                                                    {{ $item->departments->name ?? 'Không có' }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        @elseif($item->export_type === 'Xuất Hủy')
                                                                                            <tr>
                                                                                                <td class="w-25">
                                                                                                    <strong>Nhà cung
                                                                                                        cấp:</strong>
                                                                                                </td>
                                                                                                <td class="text-dark">
                                                                                                    {{ $item->supplier->name ?? 'Không có' }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        @else
                                                                                            <tr>
                                                                                                <td class="w-25">
                                                                                                    <strong>Lý Do
                                                                                                        Hủy:</strong>
                                                                                                </td>
                                                                                                <td class="text-dark">
                                                                                                    {{ $item->reason ?? 'Không có' }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                                                                        <tr>
                                                                                            <td class="w-25">
                                                                                                <strong>Ngày
                                                                                                    xuất: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ \Carbon\Carbon::parse($item->receipt_date)->format('d/m/Y') }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="w-25">
                                                                                                <strong>Người
                                                                                                    tạo: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="w-25">
                                                                                                <strong>Ghi chú:
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ $item->note }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                            <!-- Begin::Receipt Items (Right column) -->
                                                                            <div class="col-md-12">
                                                                                <h6 class="mb-5">Danh sách thiết bị
                                                                                </h6>
                                                                                <div class="table-responsive">
                                                                                    <table
                                                                                        class="table table-striped table-sm table-hover border border-dark">
                                                                                        <thead
                                                                                            class="fw-bolder bg-dark border border-dark">
                                                                                            <tr class="text-center">
                                                                                                <th class="ps-5 text-left text-dark"
                                                                                                    style="width: 70%;">
                                                                                                    Tên thiết bị
                                                                                                </th>
                                                                                                <th style="width: 15%;"
                                                                                                    class="text-dark">
                                                                                                    Số
                                                                                                    lô</th>
                                                                                                <th class="text-dark pe-3"
                                                                                                    style="width: 15%;">
                                                                                                    Số
                                                                                                    lượng</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($item->exportDetail as $detail)
                                                                                                <tr
                                                                                                    class="text-center border border-dark">
                                                                                                    <td
                                                                                                        class="ps-5 text-left">
                                                                                                        {{ $detail->equipments->name }}
                                                                                                    </td>
                                                                                                    <td>{{ $detail->batch_number }}
                                                                                                    </td>
                                                                                                    <td><span
                                                                                                            data-bs-toggle="tooltip"
                                                                                                            data-bs-placement="top"
                                                                                                            title="Số Lượng Xuất Kho">{{ $detail->quantity }}</span>
                                                                                                        @if ($item->status == 3 || $item->status == 0)
                                                                                                            /
                                                                                                            <span
                                                                                                                data-bs-toggle="tooltip"
                                                                                                                data-bs-placement="top"
                                                                                                                title="Số Lượng Tồn Kho">
                                                                                                                {{ $detail->equipments->inventories->sum('current_quantity') }}
                                                                                                            </span>
                                                                                                            @if ($detail->quantity > $detail->equipments->inventories->sum('current_quantity'))
                                                                                                                <i data-bs-toggle="tooltip"
                                                                                                                    data-bs-placement="top"
                                                                                                                    title="Vượt Quá Số Lượng Tồn Kho"
                                                                                                                    class="fa-solid fa-triangle-exclamation text-danger"></i>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="noDataAlert">
                                    <td colspan="12" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-arrow-up" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Chưa có
                                                    phiếu xuất nào</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Hiện tại chưa có phiếu xuất nào được tạo. Vui lòng kiểm tra lại hoặc tạo
                                                    phiếu xuất mới.
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

            @if ($allExportCount > 0)
                <div class="card-body py-3">
                    <div class="filter-bar">
                        <ul class="nav nav-pills">
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: #0064ff;">Tất cả
                                    <span>({{ $allExportCount }})</span>
                                </p>
                            </li>
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: green;">Đã duyệt
                                    <span>({{ $approvedExportsCount }})</span>
                                </p>
                            </li>
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: red;">Chờ duyệt
                                    <span>({{ $draftExportsCount }})</span>
                                </p>
                            </li>
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: rgb(123, 0, 255);">
                                    Lưu Tạm
                                    <span>({{ $tempExportsCount }})</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            @if ($exports->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown d-none" id="action_delete_all">
                        <button class="btn btn-info btn-sm dropdown-toggle rounded-pill" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item pointer d-flex align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>
                                    <span class="text-danger">Hủy phiếu</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <ul class="pagination">
                        {{ $exports->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif

            {{-- Modal Xác Nhận Hủy Tất Cả --}}
            <div class="modal fade" id="deleteAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="deleteAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Hủy Phiếu Xuất</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn hủy phiếu xuất đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit"
                                class="btn rounded-pill btn-sm btn-danger px-4 load_animation">Hủy</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach ($exports as $item)
        <!-- Modal Duyệt Phiếu -->
        <div class="modal fade" id="browse-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="browseLabel-{{ $item->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="browseLabel-{{ $item->code }}">
                            Duyệt
                            Phiếu Xuất Kho</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('warehouse.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="browse_code" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn duyệt phiếu xuất kho
                                này?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4 rounded-pill"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-twitter px-4 rounded-pill load_animation">
                                Duyệt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Tạo Phiếu -->
        <div class="modal fade" id="create-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="createLabel-{{ $item->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="createLabel-{{ $item->code }}">
                            Tạo Phiếu Xuất Kho
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('warehouse.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="create_code" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn tạo phiếu xuất kho
                                này?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4 rounded-pill"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-twitter px-4 rounded-pill load_animation">
                                Tạo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hủy Phiếu -->
        <div class="modal fade" id="delete-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="deleteLabel-{{ $item->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white" id="deleteLabel-{{ $item->code }}">
                            Xác
                            Nhận Hủy Phiếu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('warehouse.delete') }}" method="POST" id="deleteForm-{{ $item->code }}">
                        @csrf
                        <input type="hidden" name="delete_code" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn hủy phiếu này?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4 rounded-pill"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-danger px-4 rounded-pill load_animation">
                                Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
@endsection
