@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/warehouse/import.css') }}">
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        @include('warehouse.import_warehouse.filter')

        {{-- Danh sách --}}
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <!-- Trong phần <thead> của bảng -->
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-4">Mã Phiếu Nhập</th>
                            <th class="">Số Hóa Đơn</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Tạo Bởi</th>
                            <th class="">Ngày Nhập</th>
                            <th class="">Trạng Thái</th>
                        </tr>
                    </thead>

                    <!-- Trong phần <tbody> của bảng -->
                    <tbody>
                        @foreach ($receipts as $item)
                            <tr class="text-center hover-table pointer" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $item['code'] }}" aria-expanded="false"
                                aria-controls="collapse{{ $item['code'] }}">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>
                                    {{ $item->code }}
                                </td>
                                <td>
                                    {{ $item->receipt_no }}
                                </td>
                                <td>
                                    {{ $item->supplier->name }}
                                </td>
                                <td>
                                    {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                </td>
                                <td>
                                    {{ $item->receipt_date }}
                                </td>
                                <td>
                                    @if ($item['status'] == 1)
                                        Phiếu Tạm
                                    @else
                                        Đã nhập
                                    @endif
                                </td>
                            </tr>

                            <!-- Collapse content -->
                            <tr class="collapse multi-collapse" id="collapse{{ $item['code'] }}">
                                <td class="p-0" colspan="12"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid border-2 border-lg-1">
                                        <div class="card card-flush p-2 mb-3"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h4 class="fw-bold m-0">Chi tiết phiếu nhập kho</h4>
                                                <div class="card-toolbar">
                                                    @if ($item['status'] == 1)
                                                        <div style="font-size: 10px;"
                                                            class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</div>
                                                    @else
                                                        <div style="font-size: 10px;"
                                                            class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body p-2" style="padding-top: 0px !important">
                                                <div class="row py-5" style="padding-top: 0px !important">
                                                    <!-- Begin::Receipt Info (Left column) -->
                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class=""><strong>Mã phiếu nhập</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">{{ $item->code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Số hóa đơn</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">{{ $item->receipt_no }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Nhà cung cấp</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->supplier->name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ngày nhập</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->receipt_date }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Người tạo</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ghi chú</td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->note }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- End::Receipt Info -->

                                                    @php
                                                        $totalPrice = 0;
                                                        $totalDiscount = 0;
                                                        $totalVAT = 0;

                                                        foreach ($item->details as $detail) {
                                                            $price = $detail->price ?? 0;
                                                            $quantity = $detail->quantity;
                                                            $discount = $detail->discount ?? 0;
                                                            $vat = $detail->VAT ?? 0;

                                                            $totalPrice += $quantity * $price;

                                                            $totalDiscount += $quantity * $discount;

                                                            $totalVAT +=
                                                                $quantity * ($price - $discount) * ($vat / 100);
                                                        }

                                                        $totalAmount = $totalPrice - $totalDiscount + $totalVAT;
                                                    @endphp

                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class=""><strong>Tổng tiền hàng</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalPrice, 0) }} VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng chiết khấu</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalDiscount, 0) }} VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng VAT</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalVAT, 0) }} VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng cộng</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalAmount, 0) }} VNĐ</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- End::Receipt Info -->
                                                </div>

                                                <!-- Begin::Receipt Items (Right column) -->
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-sm table-hover">
                                                            <thead class="fw-bolder bg-danger">
                                                                <tr>
                                                                    <th class="ps-4">Mã vật tư</th>
                                                                    <th>Tên vật tư</th>
                                                                    <th>Số lượng</th>
                                                                    <th>Giá nhập</th>
                                                                    <th>Số lô</th>
                                                                    <th>Chiết khấu (%)</th>
                                                                    <th>VAT (%)</th>
                                                                    <th class="pe-3">Thành tiền</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item->details as $detail)
                                                                    @php
                                                                        $price = $detail->price ?? 0;
                                                                        $quantity = $detail->quantity;
                                                                        $discount = $detail->discount ?? 0;
                                                                        $vat = $detail->VAT ?? 0;

                                                                        $totalPrice = $quantity * ($price - $discount);
                                                                        $totalPriceWithVAT =
                                                                            $totalPrice * (1 + $vat / 100);
                                                                    @endphp
                                                                    <tr class="text-center">
                                                                        <td>{{ $detail->equipments->code }}</td>
                                                                        <td>{{ $detail->equipments->name }}</td>
                                                                        <td>{{ $detail->quantity }}</td>
                                                                        <td>{{ number_format($detail->price) }} VND</td>
                                                                        <td>{{ $detail->batch_number }}</td>
                                                                        <td>{{ $detail->discount }}</td>
                                                                        <td>{{ $detail->VAT }}%</td>
                                                                        <td>{{ number_format($totalPriceWithVAT) }} VND
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

                                        <div class="card-body py-3 text-end">
                                            <div class="button-group">
                                                <!-- Nút Duyệt đơn -->
                                                <button style="font-size: 10px;" class="btn btn-sm btn-success me-2"
                                                    data-bs-toggle="modal" data-bs-target="#browse"
                                                    type="btn btn-sm btn-success">
                                                    <i style="font-size: 10px;" class="fas fa-clipboard-check"></i>Duyệt
                                                    Phiếu
                                                </button>

                                                <!-- Nút In Phiếu -->
                                                <button style="font-size: 10px;" class="btn btn-sm btn-twitter me-2"
                                                    id="printPdfBtn" type="button">
                                                    <i style="font-size: 10px;" class="fa fa-print"></i>In Phiếu
                                                </button>

                                                <!-- Nút Sửa đơn -->
                                                <button style="font-size: 10px;" class="btn btn-sm btn-dark me-2"
                                                    data-bs-toggle="modal" data-bs-target="#edit" type="button">
                                                    <i style="font-size: 10px;" class="fa fa-edit"></i>Sửa Phiếu
                                                </button>

                                                <!-- Nút Xóa đơn -->
                                                <button style="font-size: 10px;" class="btn btn-sm btn-danger me-2"
                                                    data-bs-toggle="modal" data-bs-target="#deleteConfirm" type="button">
                                                    <i style="font-size: 10px;" class="fa fa-trash"></i>Xóa Phiếu
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body py-3 mb-3">
            <div class="dropdown">
                <span class="btn btn-info btn-sm dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span>Chọn Thao Tác</span>
                </span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#confirmAll">
                            <i class="fas fa-clipboard-check me-2 text-success"></i>Duyệt Tất Cả</a>
                    </li>
                    <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#deleteAll">
                            <i class="fas fa-trash me-2 text-danger"></i>Xóa Tất Cả</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    @include('warehouse.import_warehouse.modal')
@endsection

@section('scripts')
    <script src="{{ asset('js/warehouse/import.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();

                // Lấy dữ liệu từ các trường bộ lọc
                let startDate = $('input[name="start_date"]').val();
                let endDate = $('input[name="end_date"]').val();
                let supplierCode = $('select[name="supplier_code"]').val();
                let createdBy = $('select[name="created_by"]').val();

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('warehouse.search_import') }}",
                        type: "GET",
                        data: {
                            'search': query,
                            'start_date': startDate,
                            'end_date': endDate,
                            'supplier_code': supplierCode,
                            'created_by': createdBy
                        },
                        success: function(data) {
                            // Hiển thị kết quả tìm kiếm
                            $('tbody').html(data);
                        }
                    });
                } else {
                    location.reload(); // Tải lại trang khi không có kết quả tìm kiếm
                }
            });

            // Thêm sự kiện cho các trường lọc
            $('input[name="start_date"], input[name="end_date"], select[name="supplier_code"], select[name="created_by"]')
                .on('change', function() {
                    let query = $('#search').val();

                    // Lấy dữ liệu từ các trường bộ lọc
                    let startDate = $('input[name="start_date"]').val();
                    let endDate = $('input[name="end_date"]').val();
                    let supplierCode = $('select[name="supplier_code"]').val();
                    let createdBy = $('select[name="created_by"]').val();

                    $.ajax({
                        url: "{{ route('warehouse.search_import') }}",
                        type: "GET",
                        data: {
                            'search': query,
                            'start_date': startDate,
                            'end_date': endDate,
                            'supplier_code': supplierCode,
                            'created_by': createdBy
                        },
                        success: function(data) {
                            $('tbody').html(data);
                        }
                    });
                });
        });
    </script>
@endsection
