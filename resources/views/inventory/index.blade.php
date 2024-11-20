@forelse ($equipments as $equipment)
    <tr class="hover-table pointer" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $equipment->code }}"
        aria-expanded="false" aria-controls="collapse_{{ $equipment->code }}">
        <td>
            {{ $loop->iteration }}
        </td>
        <td>#{{ $equipment->code }}</td>
        <td style="text-align: left;">{{ $equipment->name }}</td>
        <td class="text-left">{{ $equipment->equipmentType->name }}</td>
        <td>
            <div style="display: flex; justify-content: space-evenly; align-items: center;">
                @php
                    $totalQuantity = $inventories[$equipment->code]['total_quantity'] ?? 0;
                    $quantityColor = '';
                    $icon = '';
                    $bgColor = '';

                    if ($totalQuantity < 1) {
                        $quantityColor = 'color: red; font-weight: bold;';
                        $icon =
                            '<i class="fa-solid fa-exclamation-triangle" style="color:red; font-size:18px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hết hàng"></i>';
                        $bgColor = 'background-color: rgba(255, 0, 0, 0.1);';
                    } elseif ($totalQuantity <= 10) {
                        $quantityColor = 'color: orange; font-weight: bold;';
                        $icon =
                            '<i class="fa-solid fa-exclamation-triangle" style="color:orange; font-size:18px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Cảnh báo: Số lượng thấp"></i>';
                        $bgColor = 'background-color: rgba(255, 165, 0, 0.1);';
                    } else {
                        $quantityColor = 'color: #28a745; font-weight: bold;';
                        $icon =
                            '<i class="fa-solid fa-check" style="color:#28a745; font-size:18px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Còn hàng"></i>';
                        $bgColor = 'background-color: rgba(40, 167, 69, 0.1);';
                    }
                @endphp

                <span style="{{ $quantityColor }}">
                    {{ $totalQuantity }}
                </span>

                {!! $icon !!}
            </div>
        </td>
        <td>{{ $equipment->units->name }}</td>
    </tr>

    <tr class="" style="{{ $bgColor }}">
        <td colspan="6" class="p-0">
            <div class="card card-flush collapse multi-collapse" id="collapse_{{ $equipment->code }}"
                style="border: none; margin: 0;">
                <div class="card-body p-2 mt-2">
                    <div class="table-responsive rounded">
                        <table class="table table-sm mb-0">
                            <thead class="fw-bolder bg-danger text-white">
                                <tr>
                                    <th class="ps-4">STT</th>
                                    <th>Số lô</th>
                                    <th>Số lượng</th>
                                    <th>Ngày nhập gần nhất</th>
                                    <th>Ngày xuất gần nhất</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="modalItemsTableBody">
                                @forelse ($inventories[$equipment->code]['inventories'] as $index => $inventory)
                                    @php
                                        $getReceiptDetail = App\Models\Receipt_details::orderBy('created_at', 'DESC')
                                            ->where('equipment_code', $inventory->equipment_code)
                                            ->where('batch_number', $inventory->batch_number)
                                            ->whereHas('receipt', function ($subReceipt) {
                                                $subReceipt->whereNull('deleted_at')->where('status', 1);
                                            })
                                            ->get();

                                        $getExportDetail = App\Models\Export_details::orderBy('created_at', 'DESC')
                                            ->where('equipment_code', $inventory->equipment_code)
                                            ->where('batch_number', $inventory->batch_number)
                                            ->whereHas('export', function ($subReceipt) {
                                                $subReceipt->whereNull('deleted_at')->where('status', 1);
                                            })
                                            ->get();
                                    @endphp
                                    <tr class="text-center"
                                        style="background-color: {{ $inventory->current_quantity < 1 ? 'rgba(255, 0, 0, 0.1)' : ($inventory->current_quantity <= 10 ? 'rgba(255, 165, 0, 0.1)' : 'rgba(40, 167, 69, 0.1)') }};">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $inventory->batch_number }}</td>
                                        <td>
                                            @if ($inventory->current_quantity > 0)
                                                {{ $inventory->current_quantity }}
                                            @else
                                                <span class="text-danger">Hết hàng</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ !empty($getReceiptDetail[0]['created_at']) ? \Carbon\Carbon::parse($getReceiptDetail[0]['created_at'])->format('d-m-Y H:i:s') : 'Chưa Nhập' }}
                                        </td>
                                        <td>
                                            {{ !empty($getExportDetail[0]['created_at']) ? \Carbon\Carbon::parse($getExportDetail[0]['created_at'])->format('d-m-Y H:i:s') : 'Chưa Xuất' }}
                                        </td>
                                        <td class="text-center pointer" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $inventory->code }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $inventory->code }}">
                                            Chi Tiết<i class="fa fa-caret-right pointer ms-2"></i>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="p-0" colspan="12"
                                            style="background-color: #fafafa; padding-top: 0 !important;">
                                            <div class="flex-lg-row-fluid border-2 border-lg-1 border-bottom-0 collapse multi-collapse"
                                                id="collapse_{{ $inventory->code }}">
                                                <div class="card card-flush p-2"
                                                    style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                                    <div class="card-header d-flex justify-content-between align-items-center p-3 pb-0"
                                                        style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                        <h4 class="fw-bold m-0 text-uppercase fw-bolder">
                                                            phiếu nhập
                                                        </h4>
                                                    </div>
                                                    <div class="card-body p-3 pt-0">
                                                        <div class="table-responsive rounded">
                                                            <table class="table table-striped table-sm table-hover">
                                                                <thead class=" bg-dark">
                                                                    <tr class="text-center">
                                                                        <th class="ps-3" style="width: 10%;">Mã Phiếu
                                                                        </th>
                                                                        <th style="width: 10%;">Giá</th>
                                                                        <th style="width: 9%;">Chiết Khấu(%)</th>
                                                                        <th style="width: 9%;">VAT(%)</th>
                                                                        <th style="width: 15%;">Ngày Nhập</th>
                                                                        <th style="width: 10%;">Số Lô</th>
                                                                        <th style="width: 10%;">Số Lượng</th>
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
                                                                    @forelse ($getReceiptDetail as $item)
                                                                        @php
                                                                            $price = $item->price ?? 0;
                                                                            $quantity = $item->quantity;
                                                                            $discount = $item->discount ?? 0;
                                                                            $vat = $item->VAT ?? 0;

                                                                            $itemQuantity += $quantity;
                                                                            $itemPrice = $quantity * $price;
                                                                            $itemDiscount =
                                                                                $itemPrice * ($discount / 100);
                                                                            $totalPrice = $itemPrice - $itemDiscount;
                                                                            $totalPriceWithVAT =
                                                                                $totalPrice * (1 + $vat / 100);
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
                                                                            <td>{{ $item->created_at->format('d-m-Y H:i:s') }}
                                                                            </td>
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
                                                                                            Không Có Dữ Liệu Nhập Kho
                                                                                            Của Lô Thiết Bị Này
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                    @if ($getReceiptDetail->count() > 1)
                                                                        <tr class="text-center"
                                                                            style="font-weight: bold; background-color: #f8f9fa;">
                                                                            <td colspan="6" class="text-left ps-7">
                                                                                Tổng Cộng</td>
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

                                    <tr>
                                        <td class="p-0" colspan="12"
                                            style="background-color: #fafafa; padding-top: 0 !important;">
                                            <div class="flex-lg-row-fluid border-2 border-lg-1 border-top-0 collapse multi-collapse"
                                                id="collapse_{{ $inventory->code }}">
                                                <div class="card card-flush p-2"
                                                    style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                                    <div class="card-header d-flex justify-content-between align-items-center p-3 pb-0"
                                                        style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                        <h4 class="fw-bold m-0 text-uppercase fw-bolder">
                                                            phiếu xuất
                                                        </h4>
                                                    </div>
                                                    <div class="card-body p-3 pt-0">
                                                        <div class="table-responsive rounded">
                                                            <table class="table table-striped table-sm table-hover">
                                                                <thead class="bg-dark">
                                                                    <tr class="text-center">
                                                                        <th class="ps-3" style="width: 10%;">Mã Phiếu
                                                                        </th>
                                                                        <th style="width: 15%;">Loại Xuất</th>
                                                                        <th style="width: 40%;">
                                                                            Nhà Cung Cấp / Phòng Ban / Lý Do Hủy
                                                                        </th>
                                                                        <th style="width: 10%;">Số Lô</th>
                                                                        <th style="width: 10%;">Số Lượng</th>
                                                                        <th class="pe-3" style="width: 15%;">Ngày Xuất
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                @php
                                                                    $totalQuantityExport = 0;
                                                                @endphp
                                                                <tbody>
                                                                    @forelse ($getExportDetail as $item)
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
                                                                            <td>{{ $item->created_at->format('d-m-Y H:i:s') }}
                                                                            </td>
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
                                                                                            Không Có Dữ Liệu Xuất Kho
                                                                                            Của Lô Thiết Bị Này
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                    @if ($getExportDetail->count() > 1)
                                                                        <tr class="text-center"
                                                                            style="font-weight: bold; background-color: #f8f9fa;">
                                                                            <td colspan="4" class="text-left ps-5">
                                                                                Tổng Cộng
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
                                @empty
                                    <tr id="noDataAlert">
                                        <td colspan="12" class="text-center pb-0">
                                            <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                                role="alert"
                                                style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                                <div class="mb-3">
                                                    <i class="fas fa-file-invoice"
                                                        style="font-size: 36px; color: #6c757d;"></i>
                                                </div>
                                                <div class="text-center">
                                                    <h5 style="font-size: 16px; font-weight: 600; color: #495057;">
                                                        Thông tin tồn kho trống</h5>
                                                    <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                        Hiện tại chưa có thiết bị nào được thêm vào.
                                                        Vui lòng kiểm tra lại hoặc
                                                        tạo mới thiết bị để bắt đầu.
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
        </td>
    </tr>
@empty
    <tr id="noDataAlert">
        <td colspan="12" class="text-center pb-0">
            <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                <div class="mb-3">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 36px; color: #6c757d;"></i>
                </div>
                <div class="text-center">
                    <h5 style="font-size: 16px; font-weight: 600; color: #495057;">
                        Không Tìm Thấy</h5>
                    <p style="font-size: 14px; color: #6c757d; margin: 0;">
                        Hiện Không Có Dữ Liệu Nào Phù Hợp Với Bộ Lọc Của Bạn.
                    </p>
                </div>
            </div>
        </td>
    </tr>
@endforelse

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
