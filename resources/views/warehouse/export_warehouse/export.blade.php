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

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Xuất Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.create_export') }}" class="button">Tạo
                    Phiếu Xuất</a>
            </div>
        </div>

        <div class="card-body py-1">
            <form action="" class="row align-items-center">
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
                <div class="col-4">
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
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã Phiếu Xuất.."
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

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-4">Mã Phiếu Xuất</th>
                            <th class="">Người Tạo</th>
                            <th class="">Ngày Xuất</th>
                            <th class="">Lý Do Xuất</th>
                            <th class="" style="width: 120px !important;">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $i }}" aria-expanded="false"
                                aria-controls="collapse{{ $i }}">
                                <td>
                                    <input type="checkbox" class="row-checkbox" data-checkbox />
                                </td>
                                <td>PX199001</td>
                                <td>Nhật Huy</td>
                                <td>26/08/2024</td>
                                <td>Xuất Bán Lẻ</td>
                                <td>
                                    @if ($i < 1)
                                        <div class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</div>
                                    @else
                                        <div class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</div>
                                    @endif
                                </td>

                            </tr>

                            <!-- Dropdown menu -->
                            <tr class="collapse multi-collapse" id="collapse{{ $i }}">
                                <td colspan="12"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid order-2 order-lg-1">
                                        <div class="card card-flush p-2 mb-3"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h4 class="fw-bold m-0">Chi tiết phiếu xuất kho</h4>
                                                <div class="card-toolbar">
                                                    <h6><span class="badge bg-success">Đã xuất kho</span></h6>
                                                </div>
                                            </div>
                                            <div class="card-body p-2" style="padding-top: 0px !important">
                                                <div class="row py-5" style="padding-top: 0px !important">
                                                    <!-- Begin::Receipt Info (Left column) -->
                                                    <div class="col-md-4">
                                                        <table class="table table-flush gy-1">
                                                            <tbody>
                                                                <tr>
                                                                    <td class=""><strong>Mã phiếu xuất</strong></td>
                                                                    <td class="text-gray-800">PX00019</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Số phiếu xuất</strong></td>
                                                                    <td class="text-gray-800">025</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Khách hàng</strong></td>
                                                                    <td class="text-gray-800">Công ty ABC</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Ngày xuất</strong></td>
                                                                    <td class="text-gray-800">26/08/2024</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Người tạo</strong></td>
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
                                                                    <td class=""><strong>Tổng giá trị hàng</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">1,200,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng chiết khấu</strong>
                                                                    </td>
                                                                    <td class="text-gray-800">25,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng VAT</strong></td>
                                                                    <td class="text-gray-800">12,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class=""><strong>Tổng cộng</strong></td>
                                                                    <td class="text-gray-800">1,237,000 VNĐ</td>
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
                                                                    <td>55,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>VT002</td>
                                                                    <td>Thuốc đỏ</td>
                                                                    <td>10 lọ</td>
                                                                    <td>BG001</td>
                                                                    <td>1</td>
                                                                    <td>1.2</td>
                                                                    <td>55,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>VT003</td>
                                                                    <td>Nước muối</td>
                                                                    <td>10 chai</td>
                                                                    <td>BG001</td>
                                                                    <td>1</td>
                                                                    <td>1.2</td>
                                                                    <td>550,000 VNĐ</td>
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
                                            <button class="button me-2" data-bs-toggle="modal" data-bs-target="#browse"
                                                type="button">Duyệt đơn
                                            </button>

                                            <!-- Nút In Phiếu -->
                                            <button class="button-primary me-2" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" type="button">In Phiếu
                                            </button>

                                            <!-- Nút Xóa đơn -->
                                            <button class="button-delete" me-2" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirm" type="button">Xóa đơn
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

        <div class="card-body py-3 text-end">
            <div class="button-group">
                <!-- Nút Duyệt đơn -->
                <button class="button" data-bs-toggle="modal" data-bs-target="#browse" type="button">Duyệt
                    đơn</button>

                <!-- Nút Xóa đơn -->
                <button class="button-delete" data-bs-toggle="modal" data-bs-target="#deleteConfirm" type="button">Xóa
                    đơn</button>
            </div>
        </div>
    </div>


    {{-- Modal Duyệt Phiếu --}}
    <div class="modal fade" id="browse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="browseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="browseLabel">Duyệt Phiếu nhập Kho</h5>
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
                    <button type="button" class="button-delete btn-sm px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="button px-4">
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
                    <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa Đơn</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa đơn này?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="button px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="button-delete px-4"> Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết  -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded">
                <!-- Modal header -->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        X
                    </button>
                </div>
                <!-- Modal body -->
                <div id="printArea">
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <form action="" method="post">
                            <div class="text-center mb-13">
                                <h1 class="mb-3">Phiếu Xuất</h1>
                                <div class="text-muted fw-bold fs-6">Thông Tin Chi Tiết Về Phiếu Xuất Kho
                                    <span class="link-primary fw-bolder">#MaXuatKho</span>.
                                </div>
                            </div>
                            <div class="mb-15">
                                <!-- Begin::Export Info -->
                                <div class="mb-4">
                                    <h4 class="text-primary border-bottom border-dark pb-4">Thông tin phiếu xuất</h4>
                                    <div class="row pt-3">
                                        <div class="col-4">
                                            <p><strong>Mã Phiếu Xuất:</strong> <span id="modalExportCode">PX00019</span>
                                            </p>
                                            <p><strong>Số Phiếu Xuất:</strong> <span id="modalExportNumber">025</span></p>
                                            <p><strong>Khách Hàng:</strong> <span id="modalCustomer">Nguyễn Văn A</span>
                                            </p>
                                            <p><strong>Ngày Xuất:</strong> <span id="modalExportDate">26/08/2024</span></p>
                                            <p><strong>Người Tạo:</strong> <span id="modalCreatedBy">Nhật Huy</span></p>
                                            <p><strong>Ghi Chú:</strong> <span id="modalNote">Hàng dễ vỡ</span></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End::Export Info -->

                                <!-- Begin::Export Items -->
                                <div class="mb-4">
                                    <h4 class="text-primary border-bottom border-dark pb-4 mb-4">Danh sách vật tư</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover">
                                            <thead class="fw-bolder bg-success">
                                                <tr>
                                                    <th class="ps-4">
                                                        <input type="checkbox" id="selectAll" />
                                                    </th>
                                                    <th class="ps-4">Mã vật tư</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Số lô</th>
                                                    <th>Chiết khấu (%)</th>
                                                    <th>VAT (%)</th>
                                                    <th class="pe-3">Tổng giá</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modalItemsTableBody">
                                                <tr>
                                                    <td>VT001</td>
                                                    <td>10</td>
                                                    <td>50,000 VND</td>
                                                    <td>L001</td>
                                                    <td>5</td>
                                                    <td>10</td>
                                                    <td>55,000 VND</td>
                                                </tr>
                                                <tr>
                                                    <td>VT002</td>
                                                    <td>20</td>
                                                    <td>30,000 VND</td>
                                                    <td>L002</td>
                                                    <td>0</td>
                                                    <td>10</td>
                                                    <td>33,000 VND</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End::Export Items -->

                                <!-- Begin::Summary -->
                                <div class="card p-4" style="background-color: #e1e9f4; border: 1px solid #e3e3e3;">
                                    <h5 class="card-title">Tổng Cộng</h5>
                                    <hr>
                                    <p class="mb-1">Tổng Tiền Hàng:
                                        <span class="fw-bold" id="modalSubtotal">12.000.000 VND</span>
                                    </p>
                                    <p class="mb-1">Tổng Chiết Khấu:
                                        <span class="fw-bold" id="modalTotalDiscount">0 VND</span>
                                    </p>
                                    <p class="mb-1">Tổng VAT:
                                        <span class="fw-bold" id="modalTotalVat">0 VND</span>
                                    </p>
                                    <p class="mb-1">Chi Phí Vận Chuyển:
                                        <span class="fw-bold" id="modalShippingCost">0 VND</span>
                                    </p>
                                    <p class="mb-1">Phí Khác:
                                        <span class="fw-bold" id="modalOtherFees">0 VND</span>
                                    </p>
                                    <hr>
                                    <p class="fs-4 fw-bold text-success">Tổng:
                                        <span id="modalFinalTotal">12.000.000 VND</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between mt-5">
                                    <!-- Print Button -->
                                    <button type="button" id="printPdfBtn" class="btn btn-twitter btn-sm me-2">
                                        <i class="fa fa-print me-2"></i>In Phiếu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chỉnh sửa -->
    <div class="modal fade" id="editExportReceiptModal" tabindex="-1" aria-labelledby="editExportReceiptModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded">
                <!-- Modal Header -->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <h5 class="modal-title" id="editExportReceiptModalLabel">Chỉnh Sửa Phiếu Xuất</h5>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        X
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <form action="" method="post">
                        <!-- Export Receipt Info -->
                        <div class="mb-5">
                            <h5 class="text-primary">Thông tin phiếu xuất</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editExportCode" class="form-label">Mã Phiếu Xuất:</label>
                                        <input type="text" class="form-control" id="editExportCode" value="PX00019">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editExportNumber" class="form-label">Số Phiếu Xuất:</label>
                                        <input type="text" class="form-control" id="editExportNumber" value="025">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editCustomer" class="form-label">Khách Hàng:</label>
                                        <input type="text" class="form-control" id="editCustomer"
                                            value="Nguyễn Văn A">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editExportDate" class="form-label">Ngày Xuất:</label>
                                        <input type="date" class="form-control" id="editExportDate"
                                            value="2024-08-26">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editCreatedBy" class="form-label">Người Tạo:</label>
                                        <input type="text" class="form-control" id="editCreatedBy" value="Nhật Huy">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editNote" class="form-label">Ghi Chú:</label>
                                        <textarea class="form-control" id="editNote" rows="2">Hàng dễ vỡ</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Receipt Items -->
                        <div class="mb-5">
                            <h5 class="text-primary">Danh sách vật tư</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mã vật tư</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Số lô</th>
                                            <th>Chiết khấu (%)</th>
                                            <th>VAT (%)</th>
                                            <th>Tổng giá</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="editItemsTableBody">
                                        <tr>
                                            <td><input type="text" class="form-control" value="VT001"></td>
                                            <td><input type="number" class="form-control" value="10"></td>
                                            <td><input type="text" class="form-control" value="50,000 VND"></td>
                                            <td><input type="text" class="form-control" value="L001"></td>
                                            <td><input type="number" class="form-control" value="5"></td>
                                            <td><input type="number" class="form-control" value="10"></td>
                                            <td><input type="text" class="form-control" value="55,000 VND" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                                            </td>
                                        </tr>
                                        <!-- More rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm">Thêm vật tư</button>
                        </div>

                        <!-- Summary -->
                        <div class="card p-3" style="background: #e1e9f4">
                            <h5 class="card-title">Tổng kết</h5>
                            <hr>
                            <p class="mb-1">Tổng tiền hàng:
                                <span class="fw-bold" id="editSubtotal">12.000.000 VND</span>
                            </p>
                            <p class="mb-1">Tổng chiết khấu:
                                <span class="fw-bold" id="editTotalDiscount">0 VND</span>
                            </p>
                            <p class="mb-1">Tổng VAT:
                                <span class="fw-bold" id="editTotalVat">0 VND</span>
                            </p>
                            <p class="mb-1">Chi phí vận chuyển:
                                <span class="fw-bold" id="editShippingCost">0 VND</span>
                            </p>
                            <p class="mb-1">Phí khác:
                                <span class="fw-bold" id="editOtherFees">0 VND</span>
                            </p>
                            <hr>
                            <p class="fs-4 fw-bold text-success">Tổng giá:
                                <span id="editFinalTotal">12.000.000 VND</span>
                            </p>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-success">Lưu Thay Đổi</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        </div>
                    </form>
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

        // Add click event to rows
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
