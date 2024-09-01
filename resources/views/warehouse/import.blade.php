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
                <span class="card-label fw-bolder fs-3 mb-1">Danh sách nhập kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.create_import') }}" class="btn btn-sm btn-success">Tạo Phiếu Nhập</a>
            </div>
        </div>

        <div class="card-body py-1 ">

            <input type="date" name="date_first" class="me-3 mt-2 mb-2" value="2024-07-29">

            <span class="me-3 mt-2 mb-2">Đến</span>

            <input type="date" name="date_last" class="me-3 mt-2 mb-2" value="2024-08-29">

            <select name="" id="" class="me-3 mt-2 mb-2">
                <option value="0" selected="">Theo Nhóm Vật Tư</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>

            <select name="" id="" class="me-3 mt-2 mb-2">
                <option value="0" selected="">Theo Nhà Cung Cấp</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>

            <input type="search" name="search" placeholder="Tìm Kiếm..." class="me-3 mt-2 mb-2">
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="ps-4 rounded-start">STT</th>
                            <th class="">Mã Hóa Đơn</th>
                            <th class="">Số Hóa Đơn</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Tạo Bởi</th>
                            <th class="">Ngày Nhập</th>
                            <th class="">Trạng Thái</th>
                            <th class="">Tổng Cộng</th>
                            <th class="rounded-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table">
                                <td>
                                    1
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
                                    <span class="text-success">
                                        Đã hoàn tất</span>
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
                                                    tiết</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Duyệt đơn</a></li>
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

    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded shadow-sm border-0">
                <!-- Modal header -->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- Modal body -->
                <div id="printArea">
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <form action="" method="post">
                            <div class="text-center mb-13">
                                <h1 class="mb-3 text-uppercase text-primary">Chi Tiết Phiếu Nhập</h1>
                                <div class="text-muted fw-bold fs-6">Tất cả thông tin chi tiết về phiếu nhập kho
                                    <span class="link-primary fw-bolder">BEESOFT</span>.
                                </div>
                            </div>
                            <div class="mb-15">
                                <!-- Begin::Receipt Info -->
                                <div class="mb-4">
                                    <h5 class="text-primary border-bottom pb-2">Thông tin phiếu nhập</h5>
                                    <div class="row">
                                        <div class="col-md-4">
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
                                    <h5 class="text-primary border-bottom pb-2">Danh sách vật tư</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Mã vật tư</th>
                                                    <th>Tên vật tư</th>
                                                    <th>Số lượng</th>
                                                    <th>Số lô</th>
                                                    <th>Chiết khấu (%)</th>
                                                    <th>VAT (%)</th>
                                                    <th>Thành tiền</th>
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
                                    <h5 class="card-title text-primary">Tổng kết</h5>
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
                                    <p class="fs-4 fw-bold text-danger">Tổng giá: <span id="modalFinalTotal">12.000.000
                                            VND</span></p>


                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <!-- Print Button -->
                                    <button type="button" id="printPdfBtn" class="btn btn-primary btn-sm me-2"
                                        style="border-radius: 30px; font-size: 1rem; padding: 10px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                                        <i class="fa fa-print me-2"></i>In Phiếu
                                    </button>

                                    <!-- Approve Button -->
                                    <button type="button" id="approveOrderBtn" class="btn btn-success btn-sm"
                                        style="border-radius: 30px; font-size: 1rem; padding: 10px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                                        <i class="fa fa-check me-2"></i>Duyệt Đơn
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
