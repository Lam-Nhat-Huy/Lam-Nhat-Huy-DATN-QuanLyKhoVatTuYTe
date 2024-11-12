@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/warehouse/import.css') }}">

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
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        @include('warehouse.import_warehouse.filter')

        <form action="{{ route('warehouse.import') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive rounded">
                    <table class="table align-middle gs-0 gy-4">
                        <!-- Trong phần <thead> của bảng -->
                        <thead class="{{ $receipts->count() == 0 ? 'd-none' : '' }}">
                            <tr class="bg-success">
                                <th class="ps-3">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th style="width: 10%;">Mã</th>
                                <th class="" style="width: 10%;">Số ĐĐH</th>
                                <th class="" style="width: 10%;">Số Hóa Đơn</th>
                                <th class="" style="width: 20%;">Loại Nhập</th>
                                <th class="" style="width: 15%;">Tạo Bởi</th>
                                <th class="" style="width: 10%;">Ngày Nhập</th>
                                <th class="text-center" style="width: 10%;">Trạng Thái</th>
                                <th class="pe-3 text-center" style="width: 15%;">Hành Động</th>
                            </tr>
                        </thead>

                        <!-- Trong phần <tbody> của bảng -->
                        <tbody>
                            @forelse ($receipts as $item)
                                <tr class="hover-table pointer">
                                    <td>
                                        @if ($item->status == 0 && $item->created_by == session('user_code'))
                                            <input type="checkbox" name="import_codes[]" value="{{ $item->code }}"
                                                class="row-checkbox" />
                                        @elseif ($item->status == 3)
                                            <i class="fa fa-clock text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Lưu Tạm"></i>
                                        @elseif ($item->status == 1 && $item->receipt_type === 'Nhập Từ Nhà Cung Cấp')
                                            <i class="fa fa-truck text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Nhập từ nhà cung cấp"></i>
                                        @elseif ($item->status == 1 && $item->receipt_type === 'Nhập cân bằng kho')
                                            <i class="fa-solid fa-scale-balanced text-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Nhập cân bằng kho"></i>
                                        @endif
                                    </td>
                                    <td>
                                        #{{ $item->code }}
                                    </td>
                                    <td>
                                        {{ $item->order_number ?? 'Không Có' }}
                                    </td>
                                    <td>
                                        {{ $item->receipt_no }}
                                    </td>
                                    <td class="custom-w">
                                        {{ $item->receipt_type ?? 'Không có' }}
                                    </td>
                                    <td>
                                        {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->receipt_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($item['status'] == 3)
                                            <div class="label label-temp bg-info rounded-pill text-white px-2 py-1">
                                                Lưu Tạm
                                            </div>
                                        @elseif ($item->status == 0)
                                            <div class="label label-temp bg-danger rounded-pill text-white px-2 py-1">
                                                Chờ Duyệt
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
                                                        Chi tiết phiếu nhập kho
                                                    </h4>
                                                    <div class="card-toolbar">
                                                        @if ($item->status == 3)
                                                            <div class="rounded-pill px-2 py-1 text-white bg-info">
                                                                Lưu Tạm
                                                            </div>
                                                        @elseif ($item->status == 0)
                                                            <div class="rounded-pill px-2 py-1 text-white bg-danger">
                                                                Chờ
                                                                Duyệt
                                                            </div>
                                                        @elseif ($item->status == 1)
                                                            @if (session('isAdmin') == 1)
                                                                <button type="button"
                                                                    class="btn btn-danger px-2 py-1 btn-sm rounded-pill me-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete-{{ $item->code }}"
                                                                    {{ $item->no_action == 1 || str_contains($item->code, 'PN-KK') ? 'disabled' : '' }}>
                                                                    <i class="fa fa-trash"
                                                                        style="margin-bottom: 2px;"></i>Xóa phiếu
                                                                </button>
                                                            @endif

                                                            <div class="rounded-pill px-2 py-1 text-white bg-success">
                                                                Đã Duyệt
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-body p-3 pt-0">
                                                    <div class="row" style="padding-top: 0px !important">
                                                        <div class="col-md-7">
                                                            <table class="table table-flush gy-1">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><strong>Mã phiếu nhập</strong>
                                                                        </td>
                                                                        <td style="" class="text-dark">
                                                                            {{ $item->code }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Số đơn đặt
                                                                                hàng</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ $item->order_number ?? 'Không Có' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Số hóa đơn</strong>
                                                                        </td>
                                                                        <td class="text-dark">{{ $item->receipt_no }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 250px;"><strong>Nhà cung
                                                                                cấp</strong>
                                                                        </td>
                                                                        <td class="text-dark" style="width: 550px;">
                                                                            {{ $item->supplier->name ?? 'Không có' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Ngày nhập</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ \Carbon\Carbon::parse($item->receipt_date)->format('d/m/Y') }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Người tạo</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @php
                                                            $totalPrice = 0;
                                                            $totalDiscount = 0;
                                                            $totalVAT = 0;

                                                            foreach ($item->details as $detail) {
                                                                $price = $detail->price ?? 0;
                                                                $quantity = $detail->quantity;
                                                                $discount = $detail->discount ?? 0;
                                                                $vat = $detail->VAT ?? 0;

                                                                // Tính giá trước chiết khấu
                                                                $itemPrice = $quantity * $price;

                                                                // Tính tổng giá trị chiết khấu cho từng mặt hàng
                                                                $itemDiscount = $itemPrice * ($discount / 100);

                                                                // Tính giá sau chiết khấu
                                                                $itemPriceAfterDiscount = $itemPrice - $itemDiscount;

                                                                // Tính VAT dựa trên giá sau chiết khấu
                                                                $itemVAT = $itemPriceAfterDiscount * ($vat / 100);

                                                                // Cộng dồn tổng giá trị, chiết khấu và VAT
                                                                $totalPrice += $itemPrice;
                                                                $totalDiscount += $itemDiscount;
                                                                $totalVAT += $itemVAT;
                                                            }

                                                            $totalAmount = $totalPrice - $totalDiscount + $totalVAT;
                                                        @endphp

                                                        <div class="col-md-5">
                                                            <table class="table table-flush gy-1">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class=""><strong>Tổng đầu</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ number_format($totalPrice, 0) }} VND
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Tổng chiết
                                                                                khấu</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ number_format($totalDiscount, 0) }} VND
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Tổng VAT</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ number_format($totalVAT, 0) }} VND</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Tổng cộng</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ number_format($totalAmount, 0) }} VND
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Ghi chú</td>
                                                                        <td class="text-dark">
                                                                            {{ $item->note }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Begin::Receipt Items (Right column) -->
                                                    <div class="col-md-12">
                                                        <div class="table-responsive rounded">
                                                            <table class="table table-striped table-sm table-hover">
                                                                <thead class="fw-bolder bg-dark">
                                                                    <tr class="text-center">
                                                                        <th class="ps-3" style="width: 15%;">
                                                                            Tên thiết bị
                                                                        </th>
                                                                        <th style="width: 10%;" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="Số Lượng Yêu Cầu">SLYC</th>
                                                                        <th style="width: 10%;" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Số Lượng Nhập">
                                                                            SL nhập</th>
                                                                        <th style="width: 10%;">Lệch</th>
                                                                        <th style="width: 10%;">Giá nhập</th>
                                                                        <th style="width: 10%;">Số lô</th>
                                                                        <th style="width: 10%;">Chiết khấu(%)</th>
                                                                        <th style="width: 10%;">VAT(%)</th>
                                                                        <th class="pe-3" style="width: 15%;">
                                                                            Tổng
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->details as $detail)
                                                                        @php
                                                                            $price = $detail->price ?? 0;
                                                                            $quantity = $detail->quantity;
                                                                            $discount = $detail->discount ?? 0;
                                                                            $vat = $detail->VAT ?? 0;

                                                                            $itemPrice = $quantity * $price;
                                                                            $itemDiscount =
                                                                                $itemPrice * ($discount / 100);
                                                                            $totalPrice = $itemPrice - $itemDiscount;
                                                                            $totalPriceWithVAT =
                                                                                $totalPrice * (1 + $vat / 100);
                                                                        @endphp
                                                                        <tr class="text-center">
                                                                            <td>{{ $detail->equipments->name }}</td>
                                                                            <td>{{ $detail->quantity_quote ?? 'Không Có' }}
                                                                            </td>
                                                                            <td>{{ $detail->quantity }}</td>
                                                                            <td>{{ $detail->deviation_quote ?? 'Không Có' }}
                                                                            </td>
                                                                            <td>{{ number_format($detail->price) }} VND
                                                                            </td>
                                                                            <td>{{ $detail->batch_number }}</td>
                                                                            <td>{{ $detail->discount }}%</td>
                                                                            <td>{{ $detail->VAT }}%</td>
                                                                            <td>{{ number_format($totalPriceWithVAT) }}
                                                                                VND
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
                                                    @if ($item->status == 0)
                                                        @if (session('isAdmin') == 1)
                                                            <button class="btn btn-sm btn-twitter rounded-pill me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#browse-{{ $item->code }}"
                                                                type="button">
                                                                <i class="fas fa-clipboard-check"
                                                                    style="margin-bottom: 2px;"></i>Duyệt Phiếu
                                                            </button>
                                                        @endif

                                                        @if ($item->created_by == session('user_code') || session('isAdmin') == 1)
                                                            <a href="{{ route('warehouse.edit_import', $item->code) }}"
                                                                class="btn btn-dark btn-sm me-2 rounded-pill">
                                                                <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                                Phiếu
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

                                                    @if ($item->status == 3 && $item->created_by == session('user_code'))
                                                        <button class="btn btn-sm btn-twitter rounded-pill me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#create-{{ $item->code }}" type="button">
                                                            <i class="fas fa-save" style="margin-bottom: 2px;"></i>Tạo
                                                            Phiếu
                                                        </button>

                                                        <a href="{{ route('warehouse.edit_import', $item->code) }}"
                                                            class="btn btn-dark btn-sm me-2 rounded-pill">
                                                            <i class="fa fa-edit" style="margin-bottom: 2px;"></i>Sửa
                                                            Phiếu
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
                                                            In Phiếu
                                                        </button>

                                                        {{-- In --}}
                                                        <div class="fade modal" id="printArea_{{ $item->code }}">
                                                            <span class="link-primary position-absolute"
                                                                style="top: 5%; right: 4%;">
                                                                <strong class="text-danger">
                                                                    Số Đơn Đặt Hàng:
                                                                </strong>
                                                                {{ $item->order_number }}
                                                            </span>
                                                            <span class="link-primary position-absolute"
                                                                style="top: 7%; right: 10.5%;">
                                                                <strong class="text-danger">
                                                                    Số Hóa Đơn:
                                                                </strong>
                                                                {{ $item->receipt_no }}
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
                                                                        THÔNG TIN PHIẾU NHẬP
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
                                                                                @php
                                                                                    $totalPrice = 0;
                                                                                    $totalDiscount = 0;
                                                                                    $totalVAT = 0;

                                                                                    foreach (
                                                                                        $item->details
                                                                                        as $detail
                                                                                    ) {
                                                                                        $price = $detail->price ?? 0;
                                                                                        $quantity = $detail->quantity;
                                                                                        $discount =
                                                                                            $detail->discount ?? 0;
                                                                                        $vat = $detail->VAT ?? 0;

                                                                                        // Tính giá trước chiết khấu
                                                                                        $itemPrice = $quantity * $price;

                                                                                        // Tính tổng giá trị chiết khấu cho từng mặt hàng
                                                                                        $itemDiscount =
                                                                                            $itemPrice *
                                                                                            ($discount / 100);

                                                                                        // Tính giá sau chiết khấu
                                                                                        $itemPriceAfterDiscount =
                                                                                            $itemPrice - $itemDiscount;

                                                                                        // Tính VAT dựa trên giá sau chiết khấu
                                                                                        $itemVAT =
                                                                                            $itemPriceAfterDiscount *
                                                                                            ($vat / 100);

                                                                                        // Cộng dồn tổng giá trị, chiết khấu và VAT
                                                                                        $totalPrice += $itemPrice;
                                                                                        $totalDiscount += $itemDiscount;
                                                                                        $totalVAT += $itemVAT;
                                                                                    }

                                                                                    $totalAmount =
                                                                                        $totalPrice -
                                                                                        $totalDiscount +
                                                                                        $totalVAT;
                                                                                @endphp
                                                                                <table class="table table-flush gy-1">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <strong>Nhà cung
                                                                                                    cấp:</strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ $item->supplier->name ?? 'Không có' }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
                                                                                                <strong>Ngày
                                                                                                    nhập: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ \Carbon\Carbon::parse($item->receipt_date)->format('d/m/Y') }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
                                                                                                <strong>Người
                                                                                                    tạo: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
                                                                                                <strong>
                                                                                                    Tổng tiền hàng:
                                                                                                </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ number_format($totalPrice, 0) }}
                                                                                                VND
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
                                                                                                <strong>
                                                                                                    Tổng chiết
                                                                                                    khấu: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ number_format($totalDiscount, 0) }}
                                                                                                VND
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
                                                                                                <strong>Tổng
                                                                                                    VAT: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ number_format($totalVAT, 0) }}
                                                                                                VND</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
                                                                                                <strong>Tổng
                                                                                                    cộng: </strong>
                                                                                            </td>
                                                                                            <td class="text-dark">
                                                                                                {{ number_format($totalAmount, 0) }}
                                                                                                VND
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="">
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
                                                                                        class="table border border-dark align-middle">
                                                                                        <thead
                                                                                            class="bg-success border border-dark text-center">
                                                                                            <tr class="text-center">
                                                                                                <th class="text-dark ps-3">
                                                                                                    Thiết Bị
                                                                                                </th>
                                                                                                <th class="text-dark">
                                                                                                    SLYC</th>
                                                                                                <th class="text-dark">
                                                                                                    SLN</th>
                                                                                                <th class="text-dark">
                                                                                                    Lệch</th>
                                                                                                <th class="text-dark">
                                                                                                    Giá</th>
                                                                                                <th class="text-dark">
                                                                                                    S.Lô</th>
                                                                                                <th class="text-dark">
                                                                                                    CK(%)
                                                                                                </th>
                                                                                                <th class="text-dark">
                                                                                                    VAT(%)</th>
                                                                                                <th class="text-dark pe-3">
                                                                                                    Tổng
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($item->details as $detail)
                                                                                                @php
                                                                                                    $price =
                                                                                                        $detail->price ??
                                                                                                        0;
                                                                                                    $quantity =
                                                                                                        $detail->quantity;
                                                                                                    $discount =
                                                                                                        $detail->discount ??
                                                                                                        0;
                                                                                                    $vat =
                                                                                                        $detail->VAT ??
                                                                                                        0;

                                                                                                    $itemPrice =
                                                                                                        $quantity *
                                                                                                        $price;
                                                                                                    $itemDiscount =
                                                                                                        $itemPrice *
                                                                                                        ($discount /
                                                                                                            100);
                                                                                                    $totalPrice =
                                                                                                        $itemPrice -
                                                                                                        $itemDiscount;
                                                                                                    $totalPriceWithVAT =
                                                                                                        $totalPrice *
                                                                                                        (1 +
                                                                                                            $vat / 100);
                                                                                                @endphp
                                                                                                <tr
                                                                                                    class="border border-dark">
                                                                                                    <td>{{ $detail->equipments->name }}
                                                                                                    </td>
                                                                                                    <td>{{ $detail->quantity_quote ?? 'Không Có' }}
                                                                                                    </td>
                                                                                                    <td>{{ $detail->quantity }}
                                                                                                    </td>
                                                                                                    <td>{{ $detail->deviation_quote ?? 'Không Có' }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        {{ number_format($detail->price) }}
                                                                                                        VND
                                                                                                    </td>
                                                                                                    <td>{{ $detail->batch_number }}
                                                                                                    </td>
                                                                                                    <td>{{ $detail->discount }}%
                                                                                                    </td>
                                                                                                    <td>{{ $detail->VAT }}%
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        {{ number_format($totalPriceWithVAT) }}
                                                                                                        VND
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
                                                <i class="fas fa-arrow-down" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Chưa có
                                                    phiếu nhập nào</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Hiện tại chưa có phiếu nhập nào được tạo. Vui lòng kiểm tra lại hoặc tạo
                                                    phiếu nhập mới.
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

            @if ($allReceiptCount > 0)
                <div class="card-body py-3">
                    <div class="filter-bar">
                        <ul class="nav nav-pills">
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: #0064ff;">Tất cả
                                    <span>({{ $allReceiptCount }})</span>
                                </p>
                            </li>
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: green;">Đã duyệt
                                    <span>({{ $approvedReceiptsCount }})</span>
                                </p>
                            </li>
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: red;">Chờ duyệt
                                    <span>({{ $draftReceiptsCount }})</span>
                                </p>
                            </li>
                            <li class="nav-item" style="font-size: 11px;">
                                <p class="nav-link text-white rounded-pill" style="background-color: rgb(123, 0, 255);">
                                    Lưu Tạm
                                    <span>({{ $tempReceiptsCount }})</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            @if ($receipts->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown d-none" id="action_delete_all">
                        <button class="btn btn-info btn-sm dropdown-toggle rounded-pill" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item pointer d-flex align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#browseAll">
                                    <i class="fas fa-clipboard-check me-2 text-twitter"></i>
                                    <span>Duyệt phiếu</span>
                                </a>
                            </li>
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
                        {{ $receipts->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif

            {{-- Modal Duyệt Tất Cả --}}
            <div class="modal fade" id="browseAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="browseAllModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="browseAllModal">Duyệt Phiếu Nhập</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn duyệt phiếu nhập đã chọn?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary btn-sm px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-twitter px-4 load_animation">
                                Duyệt</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Xác Nhận Hủy Tất Cả --}}
            <div class="modal fade" id="deleteAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="deleteAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Hủy Phiếu Nhập</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn hủy phiếu nhập đã chọn?</p>
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

    @foreach ($receipts as $item)
        <!-- Modal Duyệt Phiếu -->
        <div class="modal fade" id="browse-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="browseLabel-{{ $item->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="browseLabel-{{ $item->code }}">
                            Duyệt
                            Phiếu Nhập Kho</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('receipts.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="browse_code" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn duyệt phiếu nhập kho
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
                            Tạo Phiếu Nhập Kho
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('receipts.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="create_code" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn tạo phiếu nhập kho
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
                    <form action="{{ route('receipts.delete') }}" method="POST" id="deleteForm-{{ $item->code }}">
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
