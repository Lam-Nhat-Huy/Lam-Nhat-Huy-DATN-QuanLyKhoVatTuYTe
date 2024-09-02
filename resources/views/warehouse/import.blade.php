@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table:hover {
            background: #ccc;
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
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhập Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.create_import') }}" class="btn btn-sm btn-twitter"><i class="fa fa-plus"></i>Tạo
                    Phiếu Nhập</a>
            </div>
        </div>

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

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Hóa Đơn</th>
                            <th class="">Số Hóa Đơn</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Tạo Bởi</th>
                            <th class="">Ngày Nhập</th>
                            <th class="">Trạng Thái</th>
                            <th class="">Tổng Cộng</th>
                            <th class="pe-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table">
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
                                    @if ($i > 2)
                                        <span class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</span>
                                    @else
                                        <span class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</span>
                                    @endif
                                </td>
                                <td>
                                    12.000.000VNĐ
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h me-2"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#detailsModal">Chi
                                                    tiết
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#browse">Duyệt đơn</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Chỉnh sửa</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Duyệt Phiếu --}}
    <div class="modal fade" id="browse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="browseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="browseLabel">Duyệt Phiếu Nhập Kho
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        @csrf
                        <h4 class="text-danger text-center">Duyệt Phiếu Nhập Kho Này?</h4>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-twitter">Duyệt</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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

                                <div class="d-flex justify-content-between mt-5">
                                    <!-- Print Button -->
                                    <button type="button" id="printPdfBtn" class="btn btn-twitter btn-sm me-2">
                                        <i class="fa fa-print me-2"></i>In Phiếu
                                    </button>
                                </div>
                                <!-- End::Summary -->
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
        document.getElementById('printPdfBtn').addEventListener('click', function() {
            // Chọn phần tử chứa nội dung phiếu nhập mà bạn muốn in
            var printContents = document.getElementById('printArea').innerHTML;

            // Tạo một cửa sổ mới
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            // Thực hiện lệnh in
            window.print();

            // Đặt lại nội dung của trang
            document.body.innerHTML = originalContents;
        });
    </script>
@endsection
