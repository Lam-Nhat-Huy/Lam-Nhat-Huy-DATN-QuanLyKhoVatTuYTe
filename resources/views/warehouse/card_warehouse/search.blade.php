@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh sách lô</span>
            </h3>
        </div>

        @include('warehouse.card_warehouse.filter')

        <div class="card-body py-3 pb-10">
            <div class="table-responsive rounded">
                <table class="table align-middle gs-0 gy-4">
                    <thead class="bg-success">
                        <tr class="fw-bolder">
                            <th class="ps-5" style="width: 10%;">Mã thiết bị</th>
                            <th style="width: 30%;">Thiết bị</th>
                            <th style="width: 20%;" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Tổng số lượng nhập, xuất trước ngày {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }}">
                                Tồn đầu
                            </th>
                            <th style="width: 20%; white-space: nowrap;" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Tổng số lượng nhập, xuất trong khoảng từ ngày {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }} đến ngày {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}">
                                Tồn cuối</th>
                            <th class="pe-5 text-center" style="width: 20%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($nameEquipment->name))
                            <tr class="hover-table">
                                <td class="ps-5">#{{ $nameEquipment->code }}</td>
                                <td>{{ $nameEquipment->name }}</td>
                                <td>{{ $beginning_balance_total }} {{ $nameEquipment->units->name }}</td>
                                <td>{{ $ending_balance_total }} {{ $nameEquipment->units->name }}</td>
                                <td class="text-center pointer" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{ $nameEquipment->code }}" aria-expanded="false"
                                    aria-controls="collapse_{{ $nameEquipment->code }}">
                                    Chi Tiết<i class="fa fa-caret-right pointer ms-2"></i>
                                </td>
                            </tr>

                            <!-- Collapse content -->
                            <tr>
                                <td class="p-0" colspan="12"
                                    style="background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid border-2 border-lg-1 border-bottom-0 collapse multi-collapse"
                                        id="collapse_{{ $nameEquipment->code }}">
                                        <div class="card card-flush p-2"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-3 pb-0"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h4 class="fw-bold m-0 text-uppercase fw-bolder">
                                                    Chi tiết phiếu nhập
                                                </h4>
                                            </div>
                                            <div class="card-body p-3 pt-0">
                                                <div class="table-responsive rounded">
                                                    <table class="table table-striped table-sm table-hover">
                                                        <thead class=" bg-dark">
                                                            <tr class="text-center">
                                                                <th class="ps-3" style="width: 10%;">Mã phiếu</th>
                                                                <th style="width: 10%;">Giá</th>
                                                                <th style="width: 9%;">Chiết khấu(%)</th>
                                                                <th style="width: 9%;">VAT(%)</th>
                                                                <th style="width: 15%;">Ngày nhập</th>
                                                                <th style="width: 10%;">Số lô</th>
                                                                <th style="width: 10%;">Số lượng</th>
                                                                <th class="pe-3" style="width: 12%;">
                                                                    Tổng
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @php
                                                            $totalPrice2 = 0;
                                                            $itemQuantity = 0;
                                                        @endphp
                                                        <tbody>
                                                            @forelse ($getImportBetweenDate as $item)
                                                                @php
                                                                    $price = $item->price ?? 0;
                                                                    $quantity = $item->quantity;
                                                                    $discount = $item->discount ?? 0;
                                                                    $vat = $item->VAT ?? 0;

                                                                    $itemQuantity += $quantity;
                                                                    $itemPrice = $quantity * $price;
                                                                    $itemDiscount = $itemPrice * ($discount / 100);
                                                                    $totalPrice = $itemPrice - $itemDiscount;
                                                                    $totalPriceWithVAT = $totalPrice * (1 + $vat / 100);
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <a class="text-decoration-underline"
                                                                            href="{{ route('warehouse.import') }}?kw={{ $item->receipt_code }}"
                                                                            target="_blank">
                                                                            #{{ $item->receipt_code }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ number_format($item->price, '0', ',', '.') }}
                                                                        VND
                                                                    </td>
                                                                    <td>{{ number_format($item->discount, '0', ',', '.') }}%
                                                                    </td>
                                                                    <td>{{ number_format($item->VAT, '0', ',', '.') }}%
                                                                    </td>
                                                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                                    <td>{{ $item->batch_number }}</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>{{ number_format($totalPriceWithVAT, '0', ',', '.') }}
                                                                        VND</td>
                                                                </tr>
                                                                @php
                                                                    $totalPrice2 += $totalPriceWithVAT;
                                                                @endphp
                                                            @empty
                                                                <tr id="noDataAlert">
                                                                    <td colspan="12" class="text-center">
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
                                                                                    Không Có Dữ Liệu</h5>
                                                                                <p
                                                                                    style="font-size: 14px; color: #6c757d; margin: 0;">
                                                                                    Không Có Dữ Liệu Nhập Kho Của
                                                                                    Thiết Bị Này
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            @if ($getImportBetweenDate->count() > 1)
                                                                <tr class="text-center"
                                                                    style="font-weight: bold; background-color: #f8f9fa;">
                                                                    <td colspan="6" class="text-left ps-7">Tổng Cộng</td>
                                                                    <td>{{ $itemQuantity }}</td>
                                                                    <td>{{ number_format($totalPrice2, '0', ',', '.') }}
                                                                        VND</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Collapse content -->
                            <tr>
                                <td class="p-0" colspan="12"
                                    style="background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid border-2 border-lg-1 border-top-0 collapse multi-collapse"
                                        id="collapse_{{ $nameEquipment->code }}">
                                        <div class="card card-flush p-2"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-3 pb-0"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h4 class="fw-bold m-0 text-uppercase fw-bolder">
                                                    Chi tiết phiếu xuất
                                                </h4>
                                            </div>
                                            <div class="card-body p-3 pt-0">
                                                <div class="table-responsive rounded">
                                                    <table class="table table-striped table-sm table-hover">
                                                        <thead class="bg-dark">
                                                            <tr class="text-center">
                                                                <th class="ps-3" style="width: 10%;">Mã phiếu</th>
                                                                <th style="width: 15%;">Loại xuất</th>
                                                                <th style="width: 40%;">
                                                                    Nhà cung cấp / Phòng ban / Lý do hủy
                                                                </th>
                                                                <th style="width: 10%;">Số lô</th>
                                                                <th style="width: 10%;">Số lượng</th>
                                                                <th class="pe-3" style="width: 15%;">Ngày xuất</th>
                                                            </tr>
                                                        </thead>
                                                        @php
                                                            $totalQuantityExport = 0;
                                                        @endphp
                                                        <tbody>
                                                            @forelse ($getExportBetweenDate as $item)
                                                                @php
                                                                    $totalQuantityExport += $item->quantity;
                                                                @endphp
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <a class="text-decoration-underline"
                                                                            href="{{ route('warehouse.export') }}?kw={{ $item->export_code }}"
                                                                            target="_blank">
                                                                            #{{ $item->export_code }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $item->export->export_type }}</td>
                                                                    <td>
                                                                        {{ $item->export->department_code ? $item->export->departments->name : ($item->export->supplier_code ? $item->export->suppliers->name : $item->export->reason ?? '') }}
                                                                    </td>
                                                                    <td>{{ $item->batch_number }}</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr id="noDataAlert">
                                                                    <td colspan="12" class="text-center">
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
                                                                                    Không Có Dữ Liệu</h5>
                                                                                <p
                                                                                    style="font-size: 14px; color: #6c757d; margin: 0;">
                                                                                    Không Có Dữ Liệu Xuất Kho Của
                                                                                    Thiết Bị Này
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            @if ($getExportBetweenDate->count() > 1)
                                                                <tr class="text-center"
                                                                    style="font-weight: bold; background-color: #f8f9fa;">
                                                                    <td colspan="4" class="text-left ps-5">Tổng Cộng
                                                                    </td>
                                                                    <td>{{ $totalQuantityExport }}</td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr id="noDataAlert">
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-clipboard-check"
                                                style="font-size: 36px; color: #6c757d;"></i>
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
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
