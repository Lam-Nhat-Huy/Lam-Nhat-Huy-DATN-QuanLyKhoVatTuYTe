@extends('master_layout.layout')

@section('styles')
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .nav-link {
            padding: 2px 7px;
            /* Giảm padding */
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">

        @include('check_warehouse.filter')

        <div class="card-body py-3">
            <div class="table-responsive rounded">
                <table class="table align-middle gs-0 gy-4">
                    <!-- Trong phần <thead> của bảng -->
                    <thead>
                        <tr class="bg-success text-center fw-bolder">
                            <th style="width: 5%;" class="ps-3">Mã </th>
                            <th style="width: 5%;">Ngày tạo</th>
                            <th style="width: 10%;" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Tổng lệch dương và tổng lệch âm">Tổng chênh lệch</th>
                            <th style="width: 10%;">Lệch giảm</th>
                            <th style="width: 10%;">Lệch tăng</th>
                            <th style="width: 10%;">Lần kiểm</th>
                            <th style="width: 15%;">Ghi chú</th>
                            <th style="width: 10%;">Trạng thái</th>
                            <th class="pe-3" style="width: 10%;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($inventoryChecks as $item)
                            @php
                                $checkRound = collect($item['details'])->contains('check_round', 2) ? 2 : 1;

                                $totalUnequal = collect($item['details'])
                                    ->where('check_round', $checkRound)
                                    ->sum(fn($detail) => abs($detail['unequal']));

                                $unequalPositive = collect($item['details'])
                                    ->where('check_round', $checkRound)
                                    ->sum(
                                        fn($detail) => max(0, $detail['current_quantity'] - $detail['actual_quantity']),
                                    );

                                $unequalNegative = abs(
                                    collect($item['details'])
                                        ->where('check_round', $checkRound)
                                        ->sum(
                                            fn($detail) => min(
                                                0,
                                                $detail['current_quantity'] - $detail['actual_quantity'],
                                            ),
                                        ),
                                );
                            @endphp

                            <tr class="text-center hover-table pointer">
                                <td class="fw-bolder">#{{ $item['code'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y') }}</td>
                                <td style="text-align: center;">
                                    @if ($totalUnequal == 0)
                                        <span style="color: #6c757d; font-weight: 500;">
                                            <i class="fa fa-balance-scale" style="color: #6c757d;" title="Cân bằng"></i>
                                            Không lệch
                                        </span>
                                    @else
                                        <span style="color: #dc3545; font-weight: 500; font-size: 14px;">
                                            Tổng lệch {{ $totalUnequal }}
                                        </span>
                                    @endif
                                </td>

                                <td style="text-align: center;">
                                    @if ($unequalPositive > 0)
                                        <span style="color: #dc3545; font-weight: 500; font-size: 14px;">Lệch
                                            {{ $unequalPositive }}</span>
                                        <i class="fa fa-arrow-down" style="color: #dc3545;" title="Giảm"></i>
                                    @else
                                        <span style="color: #6c757d; font-weight: 500;">
                                            <i class="fa fa-balance-scale" style="color: #6c757d;" title="Cân bằng"></i>
                                            Không lệch
                                        </span>
                                    @endif
                                </td>

                                <td style="text-align: center;">
                                    @if ($unequalNegative > 0)
                                        <span style="color: #28a745; font-weight: 500; font-size: 14px;">Lệch
                                            {{ $unequalNegative }}</span>
                                        <i class="fa fa-arrow-up" style="color: #28a745;" title="Tăng"></i>
                                    @else
                                        <span style="color: #6c757d; font-weight: 500;">
                                            <i class="fa fa-balance-scale" style="color: #6c757d;" title="Cân bằng"></i>
                                            Không lệch
                                        </span>
                                    @endif
                                </td>

                                <td style="text-align: center;">
                                    @if ($item['check_count'] == 1)
                                        <span class="rounded-pill"
                                            style="display: inline-block; background-color: #ff4f5e; color: #fff; font-weight: 500; border: 1px solid #f5c6cb; border-radius: 3px; padding: 3px 8px;">
                                            Lần kiểm đầu
                                        </span>
                                    @elseif ($item['check_count'] == 2)
                                        <span class="rounded-pill"
                                            style="display: inline-block; background-color: rgba( 80, 205, 137, 1 ) !important; color: #fff; font-weight: 500; border: 1px solid #bee5eb; border-radius: 3px; padding: 3px 8px;">
                                            Lần kiểm cuối
                                        </span>
                                    @endif
                                </td>

                                <td title="{{ $item['note'] }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                    style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    @if (!empty($item['note']))
                                        <span class="text-start">
                                            {{ $item['note'] }}
                                        </span>
                                    @else
                                        <span class="text-center">
                                            Ghi chú trống
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($item->status == 0)
                                        @if ($item->check_count == 1)
                                            <div class="label label-final bg-primary rounded-pill text-white px-2 py-1">
                                                Chờ kiểm lại
                                            </div>
                                        @else
                                            <div class="label label-final bg-danger rounded-pill text-white px-2 py-1">
                                                Chờ duyệt
                                            </div>
                                        @endif
                                    @elseif ($item->status == 1)
                                        <div class="label label-final bg-success rounded-pill text-white px-2 py-1">
                                            Đã duyệt
                                        </div>
                                    @else
                                        <div class="label label-final bg-danger rounded-pill text-white px-2 py-1">
                                            Phiếu hủy
                                        </div>
                                    @endif
                                </td>
                                <td data-bs-toggle="collapse" data-bs-target="#collapse_{{ $item->code }}"
                                    aria-expanded="false" aria-controls="collapse_{{ $item->code }}">
                                    Chi tiết<i class="fa fa-caret-right pointer ms-2"></i>
                                </td>
                            </tr>

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
                                                    Chi tiết phiếu kiểm kho
                                                </h4>
                                            </div>
                                            <div class="card-body mb-0 pb-0 mx-3 px-3" style="padding-top: 0px !important">
                                                <div class="row py-5" style="padding-top: 0px !important">
                                                    <!-- Begin::Receipt Info (Left column) -->
                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="" style="width: 150px;"><strong>Mã kiểm
                                                                            kho</strong></td>
                                                                    <td class="text-gray-800">#{{ $item['code'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Thời gian</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ \Carbon\Carbon::parse($item['created_by'])->format('d/m/Y H:i:s') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ngày cân bằng</strong></td>
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
                                                                    <td class=""><strong>Ghi chú</strong></td>
                                                                    <td class="text-gray-800">{{ $item['note'] }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class=""><strong>Trạng thái</strong></td>
                                                                    <td class="text-gray-800">
                                                                        @if ($item->status == 0)
                                                                            @if ($item->check_count == 1)
                                                                                <span class="text-danger">Chờ kiểm lần
                                                                                    cuối</span>
                                                                            @else
                                                                                <span class="text-danger">Chờ duyệt</span>
                                                                            @endif
                                                                        @elseif($item->status == 1)
                                                                            <span class="text-success">Đã duyệt</span>
                                                                        @else
                                                                            <span class="text-danger">Phiếu đã hủy</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class=""><strong>Người tạo phiếu (Kiểm
                                                                            đầu)</strong></td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->user->last_name . ' ' . $item->user->first_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Người kiểm lại (Kiểm
                                                                            cuối)</strong></td>
                                                                    <td class="text-gray-800">
                                                                        @if ($item->recheckUser)
                                                                            {{ $item->recheckUser->last_name . ' ' . $item->recheckUser->first_name }}
                                                                        @else
                                                                            <span class="text-muted">Chưa kiểm cuối</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="">
                                                                        <strong>Người duyệt phiếu
                                                                            (Admin)
                                                                        </strong>
                                                                    </td>
                                                                    <td class="text-gray-800">
                                                                        {{ $item->approvedBy ? $item->approvedBy->last_name . ' ' . $item->approvedBy->first_name : 'Chưa duyệt' }}
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Lần kiểm 1 -->
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="fw-bold m-0 text-uppercase fw-bolder mb-3">Lần kiểm đầu
                                                        </h6>

                                                        @if ($item['check_count'] == 1 && session('user_code') === $item['user_code'])
                                                            <a class="text-dark mb-3"
                                                                href="{{ route('inventory_check.editByCheckround', ['code' => $item->code, 'check_round' => 1]) }}">
                                                                <i class="fa fa-edit"></i> Chỉnh sửa phiếu 1
                                                            </a>
                                                        @endif
                                                    </div>


                                                    <div class="rounded">
                                                        <table class="table table-striped table-sm table-hover">
                                                            <thead style="background-color: #000000;">
                                                                <tr class="fw-bolder">
                                                                    <th style="width: 10%;" class="ps-5">Mã thiết bị
                                                                    </th>
                                                                    <th style="width: 25%;">Tên thiết bị</th>
                                                                    <th style="width: 10%;" class="text-center">Số lô</th>
                                                                    <th style="width: 10%;" class="text-center">Tồn kho
                                                                    </th>
                                                                    <th style="width: 15%;" class="text-center">Số lượng
                                                                        thực tế</th>
                                                                    <th style="width: 10%;">Số lượng lệch</th>
                                                                    <th style="width: 15%;" class="text-center pe-5">Ghi
                                                                        chú
                                                                        thiết bị</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item['details'] as $detail)
                                                                    @if ($detail['check_round'] == 1)
                                                                        <tr class="hover-table pointer">
                                                                            <td class="ps-4 text-left">
                                                                                #{{ $detail['equipment_code'] }}
                                                                            </td>
                                                                            <td data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="{{ $detail->equipment->name }}"
                                                                                style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                                {{ $detail->equipment->name }}
                                                                            </td>
                                                                            <td class="text-center fw-bolder">
                                                                                {{ $detail['batch_number'] }}
                                                                            </td>
                                                                            <td class="text-center fw-bolder">
                                                                                {{ $detail['current_quantity'] }}
                                                                            </td>
                                                                            <td class="text-center fw-bolder">
                                                                                {{ $detail['actual_quantity'] }}
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                    $unequal =
                                                                                        $detail['current_quantity'] -
                                                                                        $detail['actual_quantity'];
                                                                                @endphp

                                                                                @if ($unequal > 0)
                                                                                    <span class="text-danger">
                                                                                        Tổng lệch {{ $unequal }}
                                                                                    </span>
                                                                                    <i class="fa fa-arrow-down"
                                                                                        style="color: #dc3545;"
                                                                                        title="Giảm"></i>
                                                                                @elseif($unequal < 0)
                                                                                    <span class="text-success">
                                                                                        Tổng lệch {{ abs($unequal) }}
                                                                                    </span>
                                                                                    <i class="fa fa-arrow-up"
                                                                                        style="color: #28a745;"
                                                                                        title="Tăng"></i>
                                                                                @else
                                                                                    <span
                                                                                        style="color: #6c757d; font-weight: bold;">
                                                                                        <i class="fa fa-balance-scale"
                                                                                            style="color: #6c757d;"
                                                                                            title="Cân bằng"></i>
                                                                                        Không lệch
                                                                                    </span>
                                                                                @endif


                                                                            </td>
                                                                            <td class="text-center">
                                                                                <span class="text-gray">
                                                                                    @if (!empty($detail['equipment_note']))
                                                                                        {{ $detail['equipment_note'] }}
                                                                                    @else
                                                                                        không có ghi chú
                                                                                    @endif
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Lần kiểm 2 -->
                                                <div class="col-md-12 mt-10">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="fw-bold m-0 text-uppercase fw-bolder mb-3">Lần kiểm cuối
                                                        </h6>

                                                        @if ($item['check_count'] == 2 && $item->status == 0 && session('user_code') == $item['recheck_user_code'])
                                                            <a class="text-dark mb-3"
                                                                href="{{ route('inventory_check.editByCheckround', ['code' => $item->code, 'check_round' => 2]) }}">
                                                                <i class="fa fa-edit"></i> Chỉnh sửa phiếu 2
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="rounded">
                                                        @php
                                                            $hasSecondCheck = false;
                                                            foreach ($item['details'] as $detail) {
                                                                if ($detail['check_round'] == 2) {
                                                                    $hasSecondCheck = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp

                                                        <table class="table table-striped table-sm table-hover">
                                                            <thead style="background-color: #000000;">
                                                                <tr class="fw-bolder">
                                                                    <th style="width: 10%;" class="ps-5">Mã thiết bị
                                                                    </th>
                                                                    <th style="width: 25%;">Tên thiết bị</th>
                                                                    <th style="width: 10%;" class="text-center">Số lô</th>
                                                                    <th style="width: 10%;" class="text-center">Tồn kho
                                                                    </th>
                                                                    <th style="width: 15%;" class="text-center">Số lượng
                                                                        thực tế</th>
                                                                    <th style="width: 10%;">Số lượng lệch</th>
                                                                    <th style="width: 15%;" class="text-center pe-5">Ghi
                                                                        chú
                                                                        thiết bị</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (!$hasSecondCheck)
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
                                                                                    <h5 style=font-weight: 600; color:
                                                                                        #495057;">
                                                                                        Phiếu Chưa Được Kiểm Lại
                                                                                    </h5>
                                                                                    <p
                                                                                        style="font-size: 14px; color: #6c757d; margin: 0;">
                                                                                        Hiện Phiếu Kiểm Này Chưa Được Kiểm
                                                                                        Lần 2
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    @foreach ($item['details'] as $detail)
                                                                        @if ($detail['check_round'] == 2)
                                                                            <tr class=" hover-table pointer"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapse{{ $detail['equipment_code'] }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapse{{ $detail['equipment_code'] }}">
                                                                                <td class="ps-4 text-left">
                                                                                    #{{ $detail['equipment_code'] }}
                                                                                </td>
                                                                                <td data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="{{ $detail->equipment->name }}"
                                                                                    style="max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                                    {{ $detail->equipment->name }}
                                                                                </td>
                                                                                <td class="text-center fw-bolder">
                                                                                    {{ $detail['batch_number'] }}
                                                                                </td>
                                                                                <td class="text-center fw-bolder">
                                                                                    {{ $detail['current_quantity'] }}
                                                                                </td>
                                                                                <td class="text-center fw-bolder">
                                                                                    {{ $detail['actual_quantity'] }}
                                                                                </td>
                                                                                <td>
                                                                                    @php
                                                                                        $unequal =
                                                                                            $detail[
                                                                                                'current_quantity'
                                                                                            ] -
                                                                                            $detail['actual_quantity'];
                                                                                    @endphp

                                                                                    @if ($unequal > 0)
                                                                                        <span class="text-danger">
                                                                                            Tổng lệch {{ $unequal }}
                                                                                            <i class="fa fa-arrow-down"
                                                                                                style="color: #dc3545;"
                                                                                                title="Giảm"></i>
                                                                                        </span>
                                                                                    @elseif($unequal < 0)
                                                                                        <span class="text-success">
                                                                                            Tổng lệch {{ abs($unequal) }}
                                                                                            <i class="fa fa-arrow-up"
                                                                                                style="color: #28a745;"
                                                                                                title="Tăng"></i>
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            style="color: #6c757d; font-weight: bold;">
                                                                                            <i class="fa fa-balance-scale"
                                                                                                style="color: #6c757d;"
                                                                                                title="Cân bằng"></i>
                                                                                            Không lệch
                                                                                        </span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <span class="text-gray">
                                                                                        @if (!empty($detail['equipment_note']))
                                                                                            {{ $detail['equipment_note'] }}
                                                                                        @else
                                                                                            không có ghi chú
                                                                                        @endif
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> <!-- End card-body -->

                                            <div class="card-body py-3 mb-3 text-end">
                                                <div class="button-group">
                                                    @if ($item->status == 0)
                                                        @if (session('isAdmin') == true)
                                                            @if ($item->check_count == 2)
                                                                <button class="btn btn-sm rounded-pill me-2"
                                                                    style="background: linear-gradient(45deg, #4CAF50, #76FF03); color: white;"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#browse-{{ $item->code }}"
                                                                    type="button">
                                                                    <i class="fas fa-clipboard-check"
                                                                        style="color: white;"></i>
                                                                    Duyệt phiếu
                                                                </button>
                                                            @endif
                                                        @endif

                                                        @if (session('isAdmin') == true || ($item['check_count'] != 2 && $item['user_code'] == session('user_code')))
                                                            <button class="btn btn-sm rounded-pill me-2"
                                                                style="background: linear-gradient(45deg, #FF5252, #FF1744); color: white;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-{{ $item->code }}">
                                                                <i class="fa fa-trash" style="color: white;"></i> Xóa
                                                                Phiếu
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @if ($item['check_count'] == 1 && $item['user_code'] != session('user_code'))
                                                        <a href="{{ route('inventory_check.check', $item->code) }}"
                                                            class="btn btn-sm rounded-pill me-2"
                                                            style="background: linear-gradient(45deg, #00B0FF, #0091EA); color: white;">
                                                            <i class="fa fa-check" style="color: white;"></i> Kiểm phiếu
                                                            lại
                                                        </a>
                                                    @endif

                                                    @if (session('isAdmin') == true && $item->status == 1)
                                                        <a class="btn btn-sm rounded-pill me-2"
                                                            style="background: linear-gradient(45deg, #FF4081, #F50057); color: white;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#cancel-{{ $item['code'] }}">
                                                            <i class="fa fa-times" style="color: white;"></i>
                                                            Hủy phiếu kiểm kho
                                                        </a>
                                                    @endif

                                                    @if (session('isAdmin') == true && $item->status == 1)
                                                        <button class="btn btn-sm btn-dark me-2 rounded-pill"
                                                            type="button" onclick="printInvoice('{{ $item->code }}')">
                                                            <i class="fa fa-print" style="margin-bottom: 2px;"></i>
                                                            In Phiếu
                                                        </button>

                                                        @include('check_warehouse.print')
                                                    @endif

                                                    <!-- Modal Duyệt Phiếu -->
                                                    <div class="modal fade" id="browse-{{ $item['code'] }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="browseLabel-{{ $item['code'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                                            <div class="modal-content border-0 shadow">
                                                                <div class="modal-header bg-success text-white">
                                                                    <h5 class="modal-title text-white"
                                                                        id="browseLabel-{{ $item['code'] }}">
                                                                        Duyệt phiếu kiểm kho
                                                                    </h5>
                                                                    <button type="button"
                                                                        class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center pb-0">
                                                                    <form
                                                                        action="{{ route('check_warehouse.approve', $item['code']) }}"
                                                                        method="POST"
                                                                        id="approveForm-{{ $item['code'] }}">
                                                                        @csrf
                                                                        <p class="text-dark mb-4">Bạn có chắc chắn muốn
                                                                            duyệt
                                                                            phiếu kiểm kho này?</p>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer justify-content-center border-0">
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm rounded-pill"
                                                                        data-bs-dismiss="modal">
                                                                        Đóng
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-success btn-sm rounded-pill load_animation"
                                                                        onclick="event.preventDefault(); document.getElementById('approveForm-{{ $item['code'] }}').submit();">
                                                                        Duyệt phiếu
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Hủy phiếu -->
                                                    <div class="modal fade" id="cancel-{{ $item['code'] }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="cancelLabel-{{ $item['code'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                                            <div class="modal-content border-0 shadow">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title text-white"
                                                                        id="cancelLabel-{{ $item['code'] }}">
                                                                        Hủy phiếu Kiểm Kho
                                                                    </h5>
                                                                    <button type="button"
                                                                        class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center pb-0">
                                                                    <form
                                                                        action="{{ route('check_warehouse.cancel', $item['code']) }}"
                                                                        method="POST"
                                                                        id="cancelForm-{{ $item['code'] }}">
                                                                        @csrf
                                                                        <p class="text-danger mb-4">
                                                                            Bạn có chắc chắn muốn hủy phiếu kiểm kho này?
                                                                            Số lượng vật tư sẽ được trả về trạng thái trước
                                                                            khi
                                                                            kiểm.
                                                                        </p>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer justify-content-center border-0">
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm rounded-pill"
                                                                        data-bs-dismiss="modal">Đóng</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm rounded-pill load_animation"
                                                                        onclick="event.preventDefault(); document.getElementById('cancelForm-{{ $item['code'] }}').submit();">
                                                                        Hủy phiếu
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Xóa phiếu -->
                                                    <div class="modal fade" id="delete-{{ $item['code'] }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="deleteLabel-{{ $item['code'] }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                                            <div class="modal-content border-0 shadow">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title text-white"
                                                                        id="deleteLabel-{{ $item['code'] }}">
                                                                        Xóa phiếu kiểm kho
                                                                    </h5>
                                                                    <button type="button"
                                                                        class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center pb-0">
                                                                    <form
                                                                        action="{{ route('check_warehouse.delete', $item['code']) }}"
                                                                        method="POST"
                                                                        id="deleteForm-{{ $item['code'] }}">
                                                                        @csrf
                                                                        <p class="text-danger mb-4">Bạn có chắc chắn muốn
                                                                            xóa
                                                                            phiếu kiểm kho này?</p>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer justify-content-center border-0">
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm rounded-pill load_animation"
                                                                        data-bs-dismiss="modal">Đóng</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm rounded-pill"
                                                                        onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $item['code'] }}').submit();">
                                                                        Xóa phiếu
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                            <i class="fas fa-clipboard-check"
                                                style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style=font-weight: 600; color: #495057;">Thông tin phiếu
                                                kiểm kho trống</h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Hiện tại chưa có phiếu kiểm kho nào được tạo. Vui lòng kiểm tra lại hoặc tạo
                                                mới phiếu kiểm kho để bắt đầu.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> <!-- End table-responsive -->
        </div> <!-- End card-body -->

        @if ($inventoryChecks->count() > 0)
            <div class="card-body py-3 mt-0 pt-0 d-flex justify-content-between align-items-center">
                <div class="filter-bar">
                    <ul class="nav nav-pills">
                        <li class="nav-item" style="font-size: 11px;">
                            <p class="nav-link text-white bg-primary rounded-pill">
                                Tất cả <span>({{ $countAll }})</span>
                            </p>
                        </li>
                        <li class="nav-item" style="font-size: 11px;">
                            <p class="nav-link text-white bg-success rounded-pill">
                                Đã duyệt <span>({{ $countBalanced }})</span>
                            </p>
                        </li>
                        <li class="nav-item" style="font-size: 11px;">
                            <p class="nav-link text-white bg-danger rounded-pill">
                                Chờ duyệt <span>({{ $countDraft }})</span>
                            </p>
                        </li>
                    </ul>

                </div>

                <div class="DayNganCach"></div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center my-3">
                    <ul class="pagination pagination-sm custom-pagination">
                        {{ $inventoryChecks->links('pagination::bootstrap-5') }}
                    </ul>
                </div>

            </div>
        @endif
    </div> <!-- End card -->
@endsection


@section('scripts')
    <script>
        // Lắng nghe sự kiện click
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(element) {
            let targetId = element.getAttribute('data-bs-target');
            let icon = element.querySelector('.row-icon');
            let target = document.querySelector(targetId);

            // Thay đổi biểu tượng ngay lập tức khi click
            element.addEventListener('click', function() {
                if (icon.classList.contains('fa-chevron-right')) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            });

            // Đảm bảo trạng thái của icon khi collapse hoàn thành
            target.addEventListener('shown.bs.collapse', function() {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-down');
            });

            target.addEventListener('hidden.bs.collapse', function() {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-right');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();

                let startDate = $('input[name="start_date"]').val();
                let endDate = $('input[name="end_date"]').val();
                let userCode = $('select[name="user_code"]')
                    .val();
                let status = $('select[name="status"]').val();

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('check_warehouse.search') }}",
                        type: "GET",
                        data: {
                            'search': query,
                            'start_date': startDate,
                            'end_date': endDate,
                            'user_code': userCode,
                            'status': status
                        },
                        success: function(data) {
                            $('tbody').html(data);
                        },
                        error: function(xhr) {
                            console.error("Error occurred: ", xhr);
                        }
                    });
                } else {
                    location.reload();
                }
            });

            $('input[name="start_date"], input[name="end_date"], select[name="user_code"], input[name="note"], select[name="status"]')
                .on('change', function() {
                    let query = $('#search').val();

                    let startDate = $('input[name="start_date"]').val();
                    let endDate = $('input[name="end_date"]').val();
                    let userCode = $('select[name="user_code"]').val();
                    let status = $('select[name="status"]').val();

                    $.ajax({
                        url: "{{ route('check_warehouse.search') }}",
                        type: "GET",
                        data: {
                            'search': query,
                            'start_date': startDate,
                            'end_date': endDate,
                            'user_code': userCode,
                            'status': status
                        },
                        success: function(data) {
                            $('tbody').html(data);
                        },
                        error: function(xhr) {
                            console.error("Error occurred: ", xhr);
                        }
                    });
                });
        });

        function printInvoice(code) {
            const printContents = document.getElementById(`printArea_${code}`).innerHTML;
            const originalContents = document.body.innerHTML;

            // Thay đổi nội dung trang thành nội dung cần in
            document.body.innerHTML = printContents;

            // Gọi lệnh in của trình duyệt
            window.print();

            // Khôi phục lại trạng thái của trang
            window.location.reload();
        }
    </script>
@endsection
