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

        {{-- Danh sách --}}
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <!-- Trong phần <thead> của bảng -->
                    <thead>
                        <tr class="bg-success text-center">
                            <th class="ps-3">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-4" style="width: 150px;">Mã Phiếu Nhập</th>
                            <th class="" style="width: 150px;">Số Hóa Đơn</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Tạo Bởi</th>
                            <th class="">Ngày Nhập</th>
                            <th class="" style="width: 150px;">Trạng Thái</th>
                        </tr>
                    </thead>

                    <!-- Trong phần <tbody> của bảng -->
                    <tbody>
                        @forelse ($receipts as $item)
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
                                <td class="custom-w">
                                    {{ $item->supplier->name }}
                                </td>
                                <td>
                                    {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                </td>
                                <td>
                                    {{ $item->receipt_date }}
                                </td>
                                <td>
                                    @if ($item['status'] == 0)
                                        <span class="label label-temp text-warning">Phiếu Tạm</span>
                                    @else
                                        <span class="label label-final text-success">Đã duyệt</span>
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
                                                <h4 class="fw-bold m-0 text-uppercase fw-bolder">Chi tiết phiếu nhập kho
                                                </h4>
                                                <div class="card-toolbar">
                                                    @if ($item['status'] == 0)
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
                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width: 450px;"><strong>Mã phiếu nhập</strong>
                                                                    </td>
                                                                    <td style="" class="text-gray-800">
                                                                        {{ $item->code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Số hóa đơn</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">{{ $item->receipt_no }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 250px;"><strong>Nhà cung cấp</strong>
                                                                    </td>
                                                                    <td class="text-gray-800" style="width: 550px;">
                                                                        {{ $item->supplier->name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ngày nhập</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ \Carbon\Carbon::parse($item->receipt_date)->format('d/m/Y') }}
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

                                                    <div class="col-md-4" style="margin-left: 200px">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class=""><strong>Tổng tiền hàng</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalPrice, 0) }}đ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng chiết khấu</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalDiscount, 0) }}đ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng VAT</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalVAT, 0) }}đ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng cộng</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ number_format($totalAmount, 0) }}đ</td>
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
                                                                <tr class="text-center">
                                                                    <th class="ps-3">Mã thiết bị</th>
                                                                    <th>Tên thiết bị</th>
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
                                                                        <td>{{ number_format($detail->price) }}đ</td>
                                                                        <td>{{ $detail->batch_number }}</td>
                                                                        <td>{{ $detail->discount }}%</td>
                                                                        <td>{{ $detail->VAT }}%</td>
                                                                        <td>{{ number_format($totalPriceWithVAT) }}đ
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
                                                <!-- Nút Duyệt đơn, chỉ hiển thị khi là Phiếu Tạm -->
                                                @if ($item->status == 0)
                                                    <button style="font-size: 10px;"
                                                        class="btn btn-sm btn-success rounded-pill me-2 rounded-pill"
                                                        data-bs-toggle="modal" data-bs-target="#browse-{{ $item->code }}"
                                                        type="button">
                                                        <i style="font-size: 10px;" class="fas fa-clipboard-check"></i>Duyệt
                                                        Phiếu
                                                    </button>
                                                @endif

                                                <!-- Nút Sửa đơn -->
                                                @if ($item->status == 0)
                                                    <a style="font-size: 10px;" href=""
                                                        class="btn btn-dark btn-sm me-2 rounded-pill"><i
                                                            style="font-size: 10px;" class="fa fa-edit"></i>Sửa Phiếu</a>
                                                @endif
                                                @if ($item->status == 1)
                                                    <!-- Nút In Phiếu -->
                                                    <button style="font-size: 10px;"
                                                        class="btn btn-sm btn-dark me-2 rounded-pill" id="printPdfBtn"
                                                        type="button">
                                                        <i style="font-size: 10px;" class="fa fa-print"></i>In Phiếu
                                                    </button>
                                                @endif

                                                @if ($item->status == 0)
                                                    <!-- Nút xóa, có thể nằm trong danh sách hoặc bảng -->
                                                    <button style="font-size: 10px;"
                                                        class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                                        data-bs-target="#delete-{{ $item->code }}">
                                                        <i style="font-size: 10px;" class="fa fa-trash"></i>Xóa phiếu
                                                    </button>
                                                @endif


                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Duyệt Phiếu -->
                            <div class="modal fade" id="browse-{{ $item->code }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="browseLabel-{{ $item->code }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title text-white" id="browseLabel-{{ $item->code }}">Duyệt
                                                Phiếu Nhập Kho</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                                            <form action="{{ route('receipts.approve', $item->code) }}" method="POST"
                                                id="approveForm-{{ $item->code }}">
                                                @csrf
                                                <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt phiếu nhập kho này?
                                                </p>
                                            </form>
                                        </div>
                                        <div class="modal-footer justify-content-center border-0 pt-0">
                                            <button type="button" class="btn btn-sm btn-secondary px-4"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-sm btn-success px-4"
                                                onclick="event.preventDefault(); document.getElementById('approveForm-{{ $item->code }}').submit();">
                                                Duyệt
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Xóa Phiếu -->
                            <div class="modal fade" id="delete-{{ $item->code }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="deleteLabel-{{ $item->code }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title text-white" id="deleteLabel-{{ $item->code }}">Xác
                                                Nhận Xóa Phiếu</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                                            <form action="{{ route('receipts.delete', $item->code) }}" method="POST"
                                                id="deleteForm-{{ $item->code }}">
                                                @csrf
                                                <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa phiếu này?</p>
                                            </form>
                                        </div>
                                        <div class="modal-footer justify-content-center border-0">
                                            <button type="button" class="btn btn-sm btn-secondary px-4"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-sm btn-danger px-4"
                                                onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $item->code }}').submit();">
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


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
                                                nhập trống</h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Hiện tại chưa có phiếu nhập nào được thêm vào. Vui lòng kiểm tra lại hoặc
                                                tạo mới phiếu nhập để bắt đầu.
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

        <div class="card-body py-3 mb-3 d-flex justify-between flex-row-reverse">

            <div class="action-bar">
                {{ $receipts->links('pagination::bootstrap-4') }}
            </div>

            <div class="filter-bar">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <p class="nav-link text-dark">Tất cả <span class="badge bg-info">({{ $allReceiptCount }})</span>
                        </p>
                    </li>
                    <li class="nav-item">
                        <p class="nav-link text-dark">Đã duyệt <span
                                class="badge bg-success">({{ $approvedReceiptsCount }})</span>
                        </p>
                    </li>
                    <li class="nav-item">
                        <p class="nav-link text-dark">Chưa duyệt <span
                                class="badge bg-danger">({{ $draftReceiptsCount }})</span>
                        </p>
                    </li>

                </ul>
            </div>

        </div>



    </div>
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
