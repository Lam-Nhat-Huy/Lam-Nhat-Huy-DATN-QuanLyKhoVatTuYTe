@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hover-table:hover {
            background-color: #e9ecef;
        }

        .collapse {
            display: none;
        }

        .collapse.show {
            display: table-row;
        }

        .collapse-content {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .detail-box {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        .detail-box h5 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 5px;
        }

        .detail-box p {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 8px;
        }

        .btn-close-detail {
            margin-top: 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }

        .btn-close-detail:hover {
            background-color: #c82333;
        }

        .card-header {
            border-bottom: 1px solid #dee2e6;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .form-control-sm {
            height: 2rem;
            padding: 0.25rem 0.5rem;
        }

        .table-search {
            width: 100%;
            margin-top: 15px;
        }

        .table-search input {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }

        .table-search input:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh sách thiết bị</span>
            </h3>
        </div>

        @include('warehouse.card_warehouse.filter')

        <div class="card-body py-3">
            <div class="table-responsive rounded">
                <table class="table align-middle table-striped table-hover gs-0 gy-4"
                    style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <thead class="bg-success text-white" style="position: sticky; top: 0; z-index: 10;">
                        <tr class="fw-bolder">
                            <th class="ps-4" style="width: 10%; text-align: left;">Mã</th>
                            <th style="width: 15%; text-align: left;">Thời gian</th>
                            <th style="width: 15%; text-align: left;">Loại giao dịch</th>
                            <th style="width: 35%; text-align: left; white-space: nowrap;">NCC/Phòng ban</th>
                            <th style="width: 10%; text-align: center;">Tồn đầu kỳ</th>
                            <th class="text-center" style="width: 7%; white-space: nowrap;">Số lượng</th>
                            <th class="text-center pe-4" style="width: 7%; white-space: nowrap;">Tồn cuối kỳ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr class="hover-table">
                                <td class="ps-4"><a href="" data-bs-toggle="modal"
                                        class="text-decoration-underline""
                                        data-bs-target="#modal{{ $transaction['code'] }}">{{ $transaction['code'] }}</a>
                                </td>
                                <td>{{ $transaction['date'] }}</td>
                                <td>{{ $transaction['transaction_type'] }}</td>
                                <td style="white-space: nowrap;">
                                    {{ $transaction['type'] === 'import' ? $transaction['supplier'] : $transaction['department'] }}
                                </td>
                                <td class="text-center">{{ $transaction['begin_stock'] }}</td>
                                <td class="text-center">
                                    {{ $transaction['type'] === 'export' ? -$transaction['quantity'] : $transaction['quantity'] }}
                                </td>
                                <td class="text-center pe-4">{{ $transaction['end_stock'] }}</td>
                            </tr>
                        @empty
                            <tr id="noDataAlert">
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-clipboard-check" style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin thiết
                                                bị trống</h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Không có phiếu nào cho thiết bị này trong khoảng thời gian đã chọn.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @php
                    $totalPrice = 0;
                    $totalDiscount = 0;
                    $totalVAT = 0;
                @endphp

                @foreach ($transactions as $item)
                    @if ($item['type'] === 'import')
                        <div class="modal fade" id="modal{{ $item['code'] }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="add_modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="add_modalLabel">
                                            {{ $item['type'] === 'import' ? 'Phiếu nhập' : 'Phiếu xuất' }}</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <!-- Thông tin chung -->
                                        <div class="row">
                                            <!-- Thông tin chung -->
                                            <div class="col-lg-6">
                                                <table class="table table-flush gy-1">
                                                    <tbody>
                                                        <tr>
                                                            <td>Mã phiếu nhập:</td>
                                                            <td class="text-dark"><strong>{{ $item['code'] }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Số hóa đơn:</td>
                                                            <td class="text-dark">
                                                                <strong>{{ $item['receipt_no'] ?? '' }}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nhà cung cấp:</td>
                                                            <td><a style="color: #0070f4"
                                                                    href="">{{ $item['supplier'] }}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ngày nhập:</td>
                                                            <td class="text-dark">{{ $item['date'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <table class="table table-flush gy-1">
                                                    <tbody>
                                                        <tr>
                                                            <td>Trạng thái:</td>
                                                            <td class="text-dark">
                                                                {{ $item['status'] == 1 ? 'Đã nhập hàng' : 'Chưa hoàn thành' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Người tạo:</td>
                                                            <td class="text-dark">{{ $item['create_by'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Chi tiết phiếu nhập -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive rounded">
                                                    <table class="table table-striped table-sm table-hover">
                                                        <thead class="fw-bolder bg-dark">
                                                            <tr class="text-center">
                                                                <th class="ps-3">Tên thiết bị</th>
                                                                <th>SLYC</th>
                                                                <th>SL nhập</th>
                                                                <th>Lệch</th>
                                                                <th>Giá nhập</th>
                                                                <th>Số lô</th>
                                                                <th>Chiết khấu(%)</th>
                                                                <th>VAT(%)</th>
                                                                <th class="pe-3">Tổng</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item['details'] as $detail)
                                                                @php
                                                                    $price = $detail->price ?? 0;
                                                                    $quantity = $detail->quantity;
                                                                    $discount = $detail->discount ?? 0;
                                                                    $vat = $detail->VAT ?? 0;

                                                                    // Giá trước chiết khấu
                                                                    $itemPrice = $quantity * $price;

                                                                    // Tổng chiết khấu
                                                                    $itemDiscount = $itemPrice * ($discount / 100);

                                                                    // Giá sau chiết khấu
                                                                    $itemPriceAfterDiscount =
                                                                        $itemPrice - $itemDiscount;

                                                                    // Tính VAT
                                                                    $itemVAT = $itemPriceAfterDiscount * ($vat / 100);

                                                                    // Tổng cộng cho mặt hàng
                                                                    $totalAmount = $itemPriceAfterDiscount + $itemVAT;

                                                                    // Cộng vào tổng các giá trị
                                                                    $totalPrice += $itemPrice;
                                                                    $totalDiscount += $itemDiscount;
                                                                    $totalVAT += $itemVAT;
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td>{{ $detail->equipments->name }}</td>
                                                                    <td>{{ $detail->quantity_quote ?? 'Không có' }}</td>
                                                                    <td>{{ $detail->quantity }}</td>
                                                                    <td>{{ $detail->deviation_quote ?? 'Không có' }}</td>
                                                                    <td>{{ number_format($price, 0, ',', '.') }} VND</td>
                                                                    <td>{{ $detail->batch_number ?? 'Không có' }}</td>
                                                                    <td>{{ $discount . '%' ?? 'Không có' }}</td>
                                                                    <td>{{ $vat . '%' ?? 'Không có' }}</td>
                                                                    <td>{{ number_format($totalAmount, 0, ',', '.') }} VND
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="fw-bold">
                                                                <td colspan="7"></td>
                                                                <td><strong>Tổng đầu:</strong></td>
                                                                <td>
                                                                    {{ number_format($totalPrice, 0, ',', '.') }} VND</td>
                                                            </tr>
                                                            <tr class="fw-bold">
                                                                <td colspan="7"></td>
                                                                <td><strong>Tổng chiết khấu:</strong></td>
                                                                <td>
                                                                    {{ number_format($totalDiscount, 0, ',', '.') }} VND
                                                                </td>
                                                            </tr>
                                                            <tr class="fw-bold">
                                                                <td colspan="7"></td>
                                                                <td><strong>Tổng VAT:</strong></td>
                                                                <td>
                                                                    {{ number_format($totalVAT, 0, ',', '.') }} VND</td>
                                                            </tr>
                                                            <tr class="fw-bold">
                                                                <td colspan="7"></td>
                                                                <td><strong>Tổng cộng:</strong></td>
                                                                <td>
                                                                    {{ number_format($totalPrice - $totalDiscount + $totalVAT, 0, ',', '.') }}
                                                                    VND</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary rounded-pill"
                                            data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="modal fade" id="modal{{ $item['code'] }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="add_modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="add_modalLabel">
                                            {{ $item['type'] === 'import' ? 'Phiếu nhập' : 'Phiếu xuất' }}</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <!-- Thông tin chung -->
                                        <div class="row">
                                            <!-- Thông tin chung -->
                                            <div class="col-lg-6">
                                                <table class="table table-flush gy-1">
                                                    <tbody>
                                                        <tr>
                                                            <td>Mã phiếu xuất:</td>
                                                            <td class="text-dark"><strong>{{ $item['code'] }}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phòng ban:</td>
                                                            <td><a style="color: #0070f4"
                                                                    href="">{{ $item['department'] }}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ngày xuất:</td>
                                                            <td class="text-dark">{{ $item['date'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <table class="table table-flush gy-1">
                                                    <tbody>
                                                        <tr>
                                                            <td>Trạng thái:</td>
                                                            <td class="text-dark">
                                                                {{ $item['status'] == 1 ? 'Đã xuất' : 'Chưa hoàn thành' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Người tạo:</td>
                                                            <td class="text-dark">{{ $item['create_by'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Chi tiết phiếu xuất -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive rounded">
                                                    <table class="table table-striped table-sm table-hover">
                                                        <thead class="fw-bolder bg-dark">
                                                            <tr class="text-center">
                                                                <th class="ps-5 text-left" style="width: 50%;">
                                                                    Tên thiết bị
                                                                </th>
                                                                <th style="width: 25%;">Số Lô</th>
                                                                <th class="pe-3" style="width: 25%;">Số Lượng</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item['details'] as $detail)
                                                            <tr class="text-center">
                                                                <td class="ps-5 text-left">
                                                                    {{$detail->equipments->name}}</td>
                                                                <td>{{$detail->batch_number}}</td>
                                                                <td><span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title=""
                                                                        data-bs-original-title="Số Lượng Xuất Kho">{{$detail->quantity}}</span>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary rounded-pill"
                                            data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach



            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('loading').style.display = 'none';
        document.getElementById('loading-overlay').style.display = 'none';
        this.disabled = true;
    </script>
@endsection
