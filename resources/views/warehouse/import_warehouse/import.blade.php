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

    {{-- <link rel="stylesheet" href="{{ asset('css/main.css') }}"> --}}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhập Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.create_import') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i>Tạo Phiếu Nhập</a>
            </div>
        </div>
        {{-- Bộ lọc --}}
        <div class="card-body py-1">
            <form action="" class="row  align-items-center">
                <div class="col-4">
                    <div class="row align-items-center">
                        <div class="col-5 pe-0">
                            <input type="date"
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
                        </div>
                        <div class="col-2 text-center">
                            Đến
                        </div>
                        <div class="col-5 ps-0">
                            <input type="date"
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <select name="stt" id="stt"
                        class="mt-2 mb-2 form-select form-select-sm form-select-solid border border-success setupSelect2">
                        <option value="" selected>--Theo NCC--</option>
                        <option value="1" {{ request()->stt == 1 ? 'selected' : '' }}>Chưa Duyệt</option>
                        <option value="2" {{ request()->stt == 2 ? 'selected' : '' }}>Đã Duyệt</option>
                    </select>
                </div>
                <div class="col-2">
                    <select name="ur" id="ur"
                        class="mt-2 mb-2 form-select form-select-sm form-select-solid border border-success setupSelect2">
                        <option value="" selected>--Theo Người Tạo--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-4 pe-8">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã, Số Hóa Đơn.."
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ request()->kw }}">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

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
                            <th class="ps-4">Mã Hóa Đơn</th>
                            <th class="">Số Hóa Đơn</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Tạo Bởi</th>
                            <th class="">Ngày Nhập</th>
                            <th class="">Tổng Cộng</th>
                        </tr>
                    </thead>

                    <!-- Trong phần <tbody> của bảng -->
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table pointer" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $i }}" aria-expanded="false"
                                aria-controls="collapse{{ $i }}">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>
                                    PD199001
                                </td>
                                <td>
                                    245
                                </td>
                                <td>
                                    Trung Sơn
                                </td>
                                <td>
                                    Nhật Huy
                                </td>
                                <td>
                                    26/08/2024
                                </td>
                                <td>
                                    12.000.000VNĐ
                                </td>
                            </tr>

                            <!-- Collapse content -->
                            <tr class="collapse multi-collapse" id="collapse{{ $i }}">
                                <td class="p-0" colspan="12"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid border-2 border-lg-1">
                                        <div class="card card-flush p-2 mb-3"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h4 class="fw-bold m-0">Chi tiết phiếu nhập kho</h4>
                                                <div class="card-toolbar">
                                                    @if ($i > 2)
                                                        <div class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</div>
                                                    @else
                                                        <div class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</div>
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
                                                                    <td class=""><strong>Mã hóa đơn</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">HD00019</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Số hóa đơn</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">025</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Nhà cung cấp</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">Trung Sơn</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ngày nhập</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">26/08/2024</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Người tạo</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">Nhật Huy</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ghi chú</td>
                                                                    <td class="text-gray-800">Hàng dễ vỡ</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- End::Receipt Info -->

                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class=""><strong>Tổng tiền hàng</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">1,200,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng chiết khấu</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">25,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng VAT</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">12,00 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng cộng</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">1,237,000</td>
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
                                                                    <th>Số lô</th>
                                                                    <th>Chiết khấu (%)</th>
                                                                    <th>VAT (%)</th>
                                                                    <th class="pe-3">Thành tiền</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>VT001</td>
                                                                    <td>Băng gạc</td>
                                                                    <td>10 Bịch</td>
                                                                    <td>BG001</td>
                                                                    <td>1</td>
                                                                    <td>1.2</td>
                                                                    <td>55,000 VND</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>VT002</td>
                                                                    <td>Thuốc đỏ</td>
                                                                    <td>10 lọ</td>
                                                                    <td>BG001</td>
                                                                    <td>1</td>
                                                                    <td>1.2</td>
                                                                    <td>55,000 VND</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>VT003</td>
                                                                    <td>Nước muối</td>
                                                                    <td>10 chai</td>
                                                                    <td>BG001</td>
                                                                    <td>1</td>
                                                                    <td>1.2</td>
                                                                    <td>550,000 VND</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- End::Receipt Items -->
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body py-3 text-end">
                                        <div class="button-group">
                                            <!-- Nút Duyệt đơn -->
                                            <button class="btn btn-sm btn-success me-2" data-bs-toggle="modal"
                                                data-bs-target="#browse" type="btn btn-sm btn-success">
                                                <i class="fas fa-clipboard-check"></i>Duyệt Phiếu
                                            </button>

                                            <!-- Nút In Phiếu -->
                                            <button class="btn btn-sm btn-twitter me-2" id="printPdfBtn" type="button">
                                                <i class="fa fa-print"></i>In Phiếu
                                            </button>

                                            <!-- Nút Sửa đơn -->
                                            <button class="btn btn-sm btn-dark me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit" type="button">
                                                <i class="fa fa-edit"></i>Sửa Phiếu
                                            </button>

                                            <!-- Nút Xóa đơn -->
                                            <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirm" type="button">
                                                <i class="fa fa-trash"></i>Xóa Phiếu
                                            </button>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
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

    {{-- Modal Duyệt Tất Cả --}}
    <div class="modal fade" id="confirmAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="confirmAll" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="confirmAll">Duyệt Tất Cả Phiếu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt tất cả phiếu đã chọn?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-secondary btn-sm px-4"
                        data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-success px-4">
                        Duyệt</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Xác Nhận Xóa Tất Cả --}}
    <div class="modal fade" id="deleteAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteAllLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Xóa Tất Cả Phiếu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa tất cả phiếu đã chọn?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-success px-4"> Xóa</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Duyệt Phiếu --}}
    <div class="modal fade" id="browse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="browseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="browseLabel">Duyệt Phiếu Nhập Kho</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt phiếu nhập kho này?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-secondary btn-sm px-4"
                        data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-success px-4">
                        Duyệt</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Xác Nhận Xóa --}}
    <div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa Phiếu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa phiếu này?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-danger px-4"> Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết phiếu nhập -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded shadow-sm border-0">
                <!-- Modal header -->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- Modal body -->
                <div id="printArea">
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <form action="" method="post">
                            <div class="text-center mb-13">
                                <h1 class="mb-3 text-uppercase text-primary">Phiếu Nhập</h1>
                                <div class="text-muted fw-bold fs-6">Thông Tin Chi Tiết Về Phiếu Nhập Kho
                                    <span class="link-primary fw-bolder">#MaNhapKho</span>.
                                </div>
                            </div>
                            <div class="mb-15">
                                <!-- Begin::Receipt Info -->
                                <div class="mb-4">
                                    <h4 class="text-primary border-bottom border-dark pb-4">Thông Tin Phiếu Nhập</h4>
                                    <div class="row pt-3">
                                        <div class="col-4">
                                            <p><strong>Mã Hóa Đơn:</strong> <span id="modalInvoiceCode">HD00019</span></p>
                                            <p><strong>Số Hóa Đơn:</strong> <span id="modalContractNumber">025</span></p>
                                            <p><strong>Nhà Cung Cấp:</strong> <span id="modalSupplier">Trung Sơn</span></p>
                                            <p><strong>Ngày Nhập:</strong> <span id="modalReceiptDate">26/08/2024</span>
                                            </p>
                                            <p><strong>Người Tạo:</strong> <span id="modalCreatedBy">Nhật Huy</span></p>
                                            <p><strong>Ghi Chú:</strong> <span id="modalNote">Hàng dễ vỡ</span></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End::Receipt Info -->

                                <!-- Begin::Receipt Items -->
                                <div class="mb-4">
                                    <h4 class="text-primary border-bottom border-dark pb-4 mb-4">Danh sách vật tư</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover">
                                            <thead class="fw-bolder bg-success">
                                                <tr>
                                                    <th class="ps-4">Mã vật tư</th>
                                                    <th>Tên vật tư</th>
                                                    <th>Số lượng</th>
                                                    <th>Số lô</th>
                                                    <th>Chiết khấu (%)</th>
                                                    <th>VAT (%)</th>
                                                    <th class="pe-3">Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modalItemsTableBody">
                                                <tr>
                                                    <td>VT001</td>
                                                    <td>Băng gạc</td>
                                                    <td>10 Bịch</td>
                                                    <td>BG001</td>
                                                    <td>1</td>
                                                    <td>1.2</td>
                                                    <td>55,000 VND</td>
                                                </tr>
                                                <tr>
                                                    <td>VT002</td>
                                                    <td>Thuốc đỏ</td>
                                                    <td>10 lọ</td>
                                                    <td>BG001</td>
                                                    <td>1</td>
                                                    <td>1.2</td>
                                                    <td>55,000 VND</td>
                                                </tr>
                                                <tr>
                                                    <td>VT003</td>
                                                    <td>Nước muối</td>
                                                    <td>10 chai</td>
                                                    <td>BG001</td>
                                                    <td>1</td>
                                                    <td>1.2</td>
                                                    <td>550,000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End::Receipt Items -->

                                <!-- Begin::Summary -->
                                <div class="card p-4" style="background: #f9f9f9; border: 1px solid #e3e3e3;">
                                    <h5 class="card-title text-primary">Tổng Cộng</h5>
                                    <hr>
                                    <p class="mb-1">Tổng tiền hàng: <span class="fw-bold" id="modalSubtotal">12.000.000
                                            VND</span></p>
                                    <p class="mb-1">Tổng chiết khấu: <span class="fw-bold" id="modalTotalDiscount">0
                                            VND</span></p>
                                    <p class="mb-1">Tổng VAT: <span class="fw-bold" id="modalTotalVat">0 VND</span></p>
                                    <p class="mb-1">Chi phí vận chuyển: <span class="fw-bold" id="modalShippingCost">0
                                            VND</span></p>
                                    <p class="mb-1">Phí khác: <span class="fw-bold" id="modalOtherFees">0 VND</span>
                                    </p>
                                    <hr>
                                    <p class="fs-4 fw-bold text-danger">Tổng: <span id="modalFinalTotal">12.000.000
                                            VND</span></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var isChecked = this.checked;
            var checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
                var row = checkbox.closest('tr');
                if (isChecked) {
                    row.classList.add('selected-row');
                } else {
                    row.classList.remove('selected-row');
                }
            });
        });

        document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var row = this.closest('tr');
                if (this.checked) {
                    row.classList.add('selected-row');
                } else {
                    row.classList.remove('selected-row');
                }

                var allChecked = true;
                document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                    if (!cb.checked) {
                        allChecked = false;
                    }
                });
                document.getElementById('selectAll').checked = allChecked;
            });
        });

        document.querySelectorAll('tbody tr').forEach(function(row) {
            row.addEventListener('click', function() {
                var checkbox = this.querySelector('.row-checkbox');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    if (checkbox.checked) {
                        this.classList.add('selected-row');
                    } else {
                        this.classList.remove('selected-row');
                    }

                    var allChecked = true;
                    document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                        if (!cb.checked) {
                            allChecked = false;
                        }
                    });
                    document.getElementById('selectAll').checked = allChecked;
                }
            });
        });

        document.getElementById('printPdfBtn').addEventListener('click', function() {
            var printContents = document.getElementById('printArea').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
    </script>
@endsection
