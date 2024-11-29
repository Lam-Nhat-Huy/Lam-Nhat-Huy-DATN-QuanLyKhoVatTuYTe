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
    Xuất Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Thùng Rác</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark rounded-pill">
                    <i class="fas fa-arrow-left" style="margin-bottom: 2px;"></i> Trở Lại
                </a>
            </div>
        </div>
        <form action="{{ route('warehouse.trash_export') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive rounded">
                    <table class="table align-middle gs-0 gy-4">
                        <thead class="{{ $exportTrash->count() == 0 ? 'd-none' : '' }}">
                            <tr class="bg-success">
                                <th class="ps-3">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th style="width: 15%;">Mã</th>
                                <th class="" style="width: 25%;">Loại Xuất</th>
                                <th class="" style="width: 20%;">Xóa Bởi</th>
                                <th class="" style="width: 15%;">Ngày Xuất</th>
                                <th class="text-center" style="width: 10%;">Trạng Thái</th>
                                <th class="pe-3 text-center" style="width: 15%;">Hành Động</th>
                            </tr>
                        </thead>

                        <!-- Trong phần <tbody> của bảng -->
                        <tbody>
                            @forelse ($exportTrash as $item)
                                <tr class="hover-table pointer">
                                    <td>
                                        @if (($item->status == 3 || $item->status == 0) && $item->created_by == session('user_code'))
                                            <input type="checkbox" name="import_codes[]" value="{{ $item->code }}"
                                                class="row-checkbox" />
                                        @endif
                                    </td>
                                    <td>
                                        #{{ $item->code }}
                                    </td>
                                    <td>
                                        {{ $item->export_type ?? 'Không Có' }}
                                    </td>
                                    <td>
                                        {{ $item->deletedByUser ? $item->deletedByUser->last_name . ' ' . $item->deletedByUser->first_name : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->export_date)->format('d/m/Y') }}
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
                                                        Chi tiết phiếu xuất kho
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
                                                                    @if ($item->export_type == 'Xuất Sử Dụng')
                                                                        <tr>
                                                                            <td class=""><strong>Phòng Ban</strong>
                                                                            </td>
                                                                            <td class="text-dark">
                                                                                {{ $item->departments->name ?? 'Không Có' }}
                                                                            </td>
                                                                        </tr>
                                                                    @elseif($item->export_type == 'Xuất Trả')
                                                                        <tr>
                                                                            <td class=""><strong>Nhà Cung Cấp</strong>
                                                                            </td>
                                                                            <td class="text-dark">
                                                                                {{ $item->suppliers->name ?? 'Không Có' }}
                                                                            </td>
                                                                        </tr>
                                                                    @elseif ($item->export_type === 'Xuất Hủy')
                                                                        <tr>
                                                                            <td class=""><strong>Lý do hủy</strong>
                                                                            </td>
                                                                            <td class="text-dark fw-bolder">
                                                                                {{ $item->reason ?? 'Không có' }}
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td class=""><strong>Phiếu xuất cân bằng
                                                                                    kho</strong>
                                                                            </td>
                                                                            <td class="text-dark">
                                                                                Phiếu này chỉ có khi cân bằng kho
                                                                            </td>
                                                                        </tr>
                                                                    @endif

                                                                    <tr>
                                                                        <td class=""><strong>Ghi chú</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ $item->note ? $item->note : 'Không có ghi chú' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Người sửa</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ $item->updatedByUser ? $item->updatedByUser->last_name . ' ' . $item->updatedByUser->first_name : 'N/A' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Người duyệt</strong>
                                                                        </td>
                                                                        <td class="text-dark">
                                                                            {{ $item->browseByUser ? $item->browseByUser->last_name . ' ' . $item->browseByUser->first_name : 'N/A' }}
                                                                        </td>
                                                                    </tr>
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
                                                                        <th style="width: 25%;">Số Lô</th>
                                                                        <th class="pe-3" style="width: 25%;">Số Lượng</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->exportDetail as $detail)
                                                                        @php
                                                                            // Tính tổng số lượng tồn kho của thiết bị
                                                                            $totalStock = $detail->equipments->inventories->sum(
                                                                                'current_quantity',
                                                                            );

                                                                            // Kiểm tra nếu số lượng xuất lớn hơn số lượng tồn kho
                                                                            if ($detail->quantity > $totalStock) {
                                                                                $canApprove = false; // Không thể duyệt nếu có ít nhất một thiết bị vượt quá số lượng tồn
                                                                            }
                                                                        @endphp
                                                                        <tr class="text-center">
                                                                            <td class="ps-5 text-left">
                                                                                {{ $detail->equipments->name }}</td>
                                                                            <td>{{ $detail->batch_number }}</td>
                                                                            <td><span data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="Số Lượng Xuất Kho">{{ $detail->quantity }}</span>
                                                                                @if ($item->status == 3 || $item->status == 0)
                                                                                    /
                                                                                    <span data-bs-toggle="tooltip"
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
                                                    <!-- End::Receipt Items -->
                                                </div>
                                            </div>

                                            <div class="card-body py-1 text-end bg-white pb-5">
                                                <div class="button-group">
                                                    <button class="btn btn-sm btn-twitter rounded-pill me-2"
                                                        data-bs-toggle="modal"
                                                        {{ $item->no_action == 1 ? 'disabled' : '' }}
                                                        data-bs-target="#restore-{{ $item->code }}" type="button">
                                                        <i class="fas fa-rotate-right"
                                                            style="margin-bottom: 2px;"></i>Khôi Phục
                                                    </button>

                                                    <button class="btn btn-sm btn-danger rounded-pill me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#delete-{{ $item->code }}" type="button">
                                                        <i class="fas fa-trash" style="margin-bottom: 2px;"></i>Xóa
                                                    </button>
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
                                                <i class="fas fa-file-invoice"
                                                    style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không Có Dữ
                                                    Liệu
                                                </h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Không Tìm Thấy Dữ Liệu Nào Về Phiếu Nhập
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

            @if ($exportTrash->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown d-none" id="action_delete_all">
                        <button class="btn btn-info btn-sm dropdown-toggle rounded-pill" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item pointer d-flex align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#restoreAll">
                                    <i class="fas fa-rotate-right me-2 text-twitter"></i>
                                    <span>Khôi Phục</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item pointer d-flex align-items-center" data-bs-toggle="modal"
                                    data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>
                                    <span class="text-danger">Xóa Vĩnh Viễn</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <ul class="pagination">
                        {{ $exportTrash->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif

            {{-- Modal Khôi Phục Tất Cả --}}
            <div class="modal fade" id="restoreAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="restoreAllModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="restoreAllModal">Khôi Phục Phiếu Nhập</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn khôi phục phiếu nhập đã chọn?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary btn-sm px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-twitter px-4 load_animation">
                                Khôi Phục</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Xác Nhận Xóa Vĩnh Viễn Tất Cả --}}
            <div class="modal fade" id="deleteAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="deleteAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Xóa Vĩnh Viễn Phiếu Nhập</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn hủy phiếu nhập đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-danger px-4 load_animation">Xóa Vĩnh
                                Viễn</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach ($exportTrash as $item)
        <!-- Modal Khôi Phục Phiếu -->
        <div class="modal fade" id="restore-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="restoreLabel-{{ $item->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="restoreLabel-{{ $item->code }}">
                            Khôi Phục Phiếu Nhập Kho</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('warehouse.trash_export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="restore_value" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn khôi phục phiếu nhập kho
                                này?
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4 rounded-pill"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-twitter px-4 rounded-pill load_animation">
                                Khôi Phục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Xóa Vĩnh Viễn Phiếu -->
        <div class="modal fade" id="delete-{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="deleteLabel-{{ $item->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white" id="deleteLabel-{{ $item->code }}">
                            Xác Nhận Xóa Vĩnh Viễn Phiếu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('warehouse.trash_export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="delete_value" value="{{ $item->code }}">
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa vĩnh viễn phiếu này?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4 rounded-pill"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-danger px-4 rounded-pill load_animation">
                                Xóa Vĩnh Viễn
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
