@forelse ($equipments as $equipment)
    <tr class="hover-table pointer" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $equipment->code }}"
        aria-expanded="false" aria-controls="collapse_{{ $equipment->code }}">
        <td>
            {{ $loop->iteration }}
        </td>
        <td>{{ $equipment->code }}</td>
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
                                </tr>
                            </thead>
                            <tbody id="modalItemsTableBody">
                                @forelse ($inventories[$equipment->code]['inventories'] as $index => $inventory)
                                    @php
                                        $last_import_date = App\Models\Receipt_details::orderBy('created_at', 'DESC')
                                            ->where('equipment_code', $inventory->equipment_code)
                                            ->where('batch_number', $inventory->batch_number)
                                            ->first();
                                        $last_export_date = App\Models\Export_details::orderBy('created_at', 'DESC')
                                            ->where('equipment_code', $inventory->equipment_code)
                                            ->where('batch_number', $inventory->batch_number)
                                            ->first();
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
                                            {{ !empty($last_import_date->created_at) ? \Carbon\Carbon::parse($last_import_date->created_at)->format('d-m-Y H:i:s') : 'Chưa Nhập' }}
                                        </td>
                                        <td>
                                            {{ !empty($last_export_date->created_at) ? \Carbon\Carbon::parse($last_export_date->created_at)->format('d-m-Y H:i:s') : 'Chưa Xuất' }}
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
