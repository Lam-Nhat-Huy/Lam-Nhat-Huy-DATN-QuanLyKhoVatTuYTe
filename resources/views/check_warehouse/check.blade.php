@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table:hover {
            background: #ccc;
        }

        .btn-group button {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .selected-row {
            background: #ddd;
        }

        .active-row {
            background: #d1c4e9;
            /* Màu nền khi hàng được nhấp vào */
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Kiểm Kho</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('check_warehouse.create') }}" class="btn btn-sm btn-twitter me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Kiểm Kho
                    </span>
                </a>
            </div>
        </div>

        {{-- Danh sách phiếu kiểm kho  --}}
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-4">Mã kiểm kho</th>
                            <th>Thời gian</th>
                            <th>Ngày cân bằng</th>
                            <th>Người cân bằng</th>
                            <th>SL thực tế</th>
                            <th>Tổng thực tế</th>
                            <th>Tổng chênh lệch</th>
                            <th>SL tăng</th>
                            <th>SL Giảm</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center hover-table" aria-expanded="false" data-bs-toggle="collapse"
                            data-bs-target="#show-collapse" aria-controls="show-collapse">
                            <td>
                                <input type="checkbox" class="row-checkbox" />
                            </td>
                            <td>
                                PD199001
                            </td>
                            <td>
                                09/08/2024
                            </td>
                            <td>
                                09/08/2024
                            </td>
                            <td>
                                Nhật Huy
                            </td>
                            <td>
                                35
                            </td>
                            <td>
                                100,000 VNĐ
                            </td>
                            <td>
                                -1
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                -1
                            </td>
                            <td>
                                Kiểm kê định kỳ
                            </td>
                        </tr>

                        <tr class="collapse multi-collapse" id="show-collapse">
                            <td colspan="12"
                                style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                <div class="flex-lg-row-fluid order-2 order-lg-1">
                                    <div class="card card-flush p-2 mb-3"
                                        style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                        <div class="card-header d-flex justify-content-between align-items-center p-2"
                                            style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                            <h4 class="fw-bold m-0">Chi tiết phiếu kiểm kho</h4>
                                            <div class="card-toolbar">
                                                <h6><span class="badge bg-success">Đã cân bằng kho</span></h6>
                                            </div>
                                        </div>
                                        <div class="card-body p-2" style="padding-top: 0px !important">
                                            <div class="row py-5" style="padding-top: 0px !important">
                                                <!-- Begin::Receipt Info (Left column) -->
                                                <div class="col-md-4">
                                                    <table class="table table-flush gy-1">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Mã phiếu kiểm</strong></td>
                                                                <td class="text-gray-800">PKK00019</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Ngày kiểm kê</strong></td>
                                                                <td class="text-gray-800">01/09/2024</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Ngày cân bằng</strong></td>
                                                                <td class="text-gray-800">01/09/2024</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Ghi chú</strong></td>
                                                                <td class="text-gray-800">Kiểm kho định kỳ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-4">
                                                    <table class="table table-flush gy-1">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Người tạo</strong></td>
                                                                <td class="text-gray-800">Nhật Huy</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Người cân bằng</strong></td>
                                                                <td class="text-gray-800">Nhật Huy</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tổng số lượng vật tư</strong></td>
                                                                <td class="text-gray-800">150 đơn vị</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tổng giá trị</strong></td>
                                                                <td class="text-gray-800">3,500,000 VNĐ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-4">
                                                    <table class="table table-flush gy-1">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Tổng thực tế (35)</strong></td>
                                                                <td class="text-gray-800">100,000VNĐ</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tổng lệch tăng (1)</strong></td>
                                                                <td class="text-gray-800">2,500 VNĐ</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tổng lệch giảm (0)</strong></td>
                                                                <td class="text-gray-800">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tổng trên lệch (1)</strong></td>
                                                                <td class="text-gray-800">2,500 VNĐ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-sm table-hover">
                                                        <thead class="fw-bolder bg-warning">
                                                            <tr>
                                                                <th class="ps-4">Mã vật tư</th>
                                                                <th>Tên vật tư</th>
                                                                <th>Tồn kho</th>
                                                                <th>Thực tế</th>
                                                                <th>SL Chênh lệch</th>
                                                                <th>Giá trị lệch</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="text-center hover-table" aria-expanded="false"
                                                                data-bs-toggle="collapse" data-bs-target="#show-collapse"
                                                                aria-controls="show-collapse">
                                                                <td>
                                                                    PD199001
                                                                </td>
                                                                <td>
                                                                    09/08/2024
                                                                </td>
                                                                <td>
                                                                    Nhật Huy
                                                                </td>
                                                                <td>
                                                                    25
                                                                </td>
                                                                <td>
                                                                    100,000 VNĐ
                                                                </td>
                                                                <td>
                                                                    -1
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body py-3 text-end">
                                    <div class="button-group">
                                        <!-- Nút In Phiếu -->
                                        <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal"
                                            data-bs-target="#detailsModal" type="button">In Phiếu</button>

                                        <!-- Nút In Phiếu -->
                                        <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal"
                                            data-bs-target="#detailsModal" type="button">Xuất file</button>

                                        <!-- Nút Xóa đơn -->
                                        <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirm" type="button">Xóa phiếu</button>
                                    </div>
                                </div>
                            </td>


                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
