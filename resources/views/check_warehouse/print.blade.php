{{-- In --}}
<div class="fade modal" id="printArea_{{ $item->code }}">
    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
        <div class="d-flex mb-5">
            <img src="{{ asset('image/logo_warehouse.png') }}" width="100" alt="">
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
                THÔNG TIN PHIẾU KIỂM KHO
            </h1>
            <div class="text-muted fs-30">
                Ngày Tạo
                {{ \Carbon\Carbon::parse($item->request_date)->format('d-m-Y') }}
            </div>
        </div>
        <div class="mb-15 text-left">
            <div class="card card-flush p-2" style="padding-top: 0px !important; padding-bottom: 0px !important;">
                <div class="card-body p-3 pt-0">
                    <div class="row py-5" style="padding-top: 0px !important">
                        <!-- Begin::Receipt Info (Left column) -->
                        <div class="col-md-4 pb-0">
                            <table class="table table-dark gy-1">
                                <tbody>
                                    <tr>
                                        <td class="" style="width: 150px;">
                                            <strong>Mã kiểm
                                                kho</strong>
                                        </td>
                                        <td class="text-gray-800">
                                            {{ $item['code'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class=""><strong>Thời
                                                gian</strong></td>
                                        <td class="text-gray-800">
                                            {{ \Carbon\Carbon::parse($item['created_by'])->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=""><strong>Ngày
                                                cân bằng</strong></td>
                                        @if ($item['check_date'])
                                            <td class="text-gray-800">
                                                {{ \Carbon\Carbon::parse($item['check_date'])->format('d/m/Y') }}
                                            </td>
                                        @else
                                            <td class="text-gray-800">
                                                Không có
                                            </td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td class="">
                                            <strong>Người
                                                kiểm đầu
                                            </strong>
                                        </td>
                                        <td class="text-gray-800">
                                            {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            <strong>Người kiểm
                                                cuối</strong>
                                        </td>
                                        <td class="text-gray-800">
                                            @if ($item->recheckUser)
                                                {{ $item->recheckUser->last_name . ' ' . $item->recheckUser->first_name }}
                                            @else
                                                <span class="text-muted">Chưa
                                                    kiểm cuối</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=""><strong>Ghi
                                                chú</strong></td>
                                        <td class="text-gray-800">
                                            {{ $item['note'] }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Lần kiểm 2 -->
                    <div class="col-md-12">
                        <div class="table-responsive rounded">
                            @php
                                $hasSecondCheck = false;
                                foreach ($item['details'] as $detail) {
                                    if ($detail['check_round'] == 2) {
                                        $hasSecondCheck = true;
                                        break;
                                    }
                                }
                            @endphp

                            @if (!$hasSecondCheck)
                                <div class="alert alert-warning d-flex align-items-center shadow-sm border border-warning rounded-3"
                                    role="alert">
                                    <i class="fas fa-exclamation-triangle me-3"
                                        style="font-size: 1.75rem; color: #856404;"></i>
                                    <div>
                                        <h6 class="alert-heading fw-bold m-0">
                                            Thông báo!</h6>
                                        <p class="small text-muted mb-1">
                                            Vui lòng tiến hành kiểm kho
                                            lần 2.</p>
                                    </div>
                                </div>
                            @else
                                <table class="table table-bordered table-striped table-sm table-hover mt-2">
                                    <thead class="bg-warning text-center">
                                        <tr>
                                            <th style="width: 15%;">Mã
                                                thiết bị</th>
                                            <th style="width: 15%;">Tên
                                                thiết bị</th>
                                            <th style="width: 15%;">Số
                                                lô</th>
                                            <th style="width: 10%;">TK
                                            </th>
                                            <th style="width: 10%;">
                                                SLTT</th>
                                            <th style="width: 10%;">SL
                                                lệch</th>
                                            <th style="width: 25%;">Ghi
                                                chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item['details'] as $detail)
                                            @if ($detail['check_round'] == 2)
                                                <tr class="text-center align-middle">
                                                    <td class="text-start ps-4">
                                                        {{ $detail['equipment_code'] }}
                                                    </td>
                                                    <td data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ $detail->equipment->name }}"
                                                        style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $detail->equipment->name }}
                                                    </td>
                                                    <td>{{ $detail['batch_number'] }}
                                                    </td>
                                                    <td>{{ $detail['current_quantity'] }}
                                                    </td>
                                                    <td>{{ $detail['actual_quantity'] }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $unequal =
                                                                $detail['current_quantity'] -
                                                                $detail['actual_quantity'];
                                                        @endphp
                                                        @if ($unequal > 0)
                                                            <span class="badge bg-danger">-{{ $unequal }}</span>
                                                        @elseif($unequal < 0)
                                                            <span class="badge bg-success">+{{ abs($unequal) }}</span>
                                                        @else
                                                            <span class="text-muted">Không
                                                                lệch</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-gray">{{ $detail['equipment_note'] ?? 'Không có ghi chú' }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
