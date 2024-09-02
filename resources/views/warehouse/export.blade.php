@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh sách phiếu xuất</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.create_export') }}" class="btn btn-sm btn-success">Tạo Phiếu Xuất</a>
            </div>
        </div>

        <div class="card-body py-1">
            <form action="" class="row">
                <div class="col-3">
                    <select name="ur" id="ur"
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
                        <option value="" selected="">--Theo Người Tạo--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="rt" id="rt"
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
                        <option value="" selected="">--Theo Loại Xuất--</option>
                        <option value="1">
                            Type 1</option>
                        <option value="2">
                            Type 2</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="stt" id="stt"
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
                        <option value="" selected="">--Theo Trạng Thái--</option>
                        <option value="1">Chưa Duyệt</option>
                        <option value="2">Đã Duyệt</option>
                    </select>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã Phiếu Xuất.."
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="">
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
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="ps-4 rounded-start">STT</th>
                            <th class="">Mã Phiếu Xuất</th>
                            <th class="">Tạo Bởi</th>
                            <th class="">Ngày Xuất</th>
                            <th class="">Lý Do Xuất</th>
                            <th class="">Trạng Thái</th>
                            <th class="rounded-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td>PX199001</td>
                            <td>Nhật Huy</td>
                            <td>26/08/2024</td>
                            <td>Xuất Bán Lẻ</td>
                            <td><span class="text-success">Đã hoàn tất</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="" type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                                        data-bs-auto-close="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h me-2"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">Chi tiết</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Duyệt đơn</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editExportReceiptModal">Chỉnh sửa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>1</td>
                            <td>PX199001</td>
                            <td>Nhật Huy</td>
                            <td>26/08/2024</td>
                            <td>Xuất Bán Lẻ</td>
                            <td><span class="text-success">Đã hoàn tất</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="" type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                                        data-bs-auto-close="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h me-2"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">Chi tiết</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Duyệt đơn</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editExportReceiptModal">Chỉnh sửa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>1</td>
                            <td>PX199001</td>
                            <td>Nhật Huy</td>
                            <td>26/08/2024</td>
                            <td>Xuất Bán Lẻ</td>
                            <td><span class="text-success">Đã hoàn tất</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="" type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                                        data-bs-auto-close="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h me-2"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">Chi tiết</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Duyệt đơn</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editExportReceiptModal">Chỉnh sửa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>1</td>
                            <td>PX199001</td>
                            <td>Nhật Huy</td>
                            <td>26/08/2024</td>
                            <td>Xuất Bán Lẻ</td>
                            <td><span class="text-success">Đã hoàn tất</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="" type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                                        data-bs-auto-close="" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h me-2"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">Chi tiết</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Duyệt đơn</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editExportReceiptModal">Chỉnh sửa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>1</td>
                            <td>PX199001</td>
                            <td>Nhật Huy</td>
                            <td>26/08/2024</td>
                            <td>Xuất Bán Lẻ</td>
                            <td><span class="text-success">Đã hoàn tất</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="" type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                                        data-bs-auto-close="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h me-2"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">Chi tiết</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Duyệt đơn</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editExportReceiptModal">Chỉnh sửa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <!-- Repeat rows as needed -->
                    </tbody>
                </table>
            </div>

            <div class="dataTables_paginate paging_simple_numbers" id="kt_customers_table_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item previous disabled" id="kt_customers_table_previous"><a
                            href="#" aria-controls="kt_customers_table" data-dt-idx="0" tabindex="0"
                            class="page-link"><i class="previous"></i></a></li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="kt_customers_table"
                            data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                    <li class="paginate_button page-item "><a href="#" aria-controls="kt_customers_table"
                            data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                    <li class="paginate_button page-item "><a href="#" aria-controls="kt_customers_table"
                            data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                    <li class="paginate_button page-item "><a href="#" aria-controls="kt_customers_table"
                            data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                    <li class="paginate_button page-item next" id="kt_customers_table_next"><a href="#"
                            aria-controls="kt_customers_table" data-dt-idx="5" tabindex="0" class="page-link"><i
                                class="next"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
                                <h1 class="mb-3">Chi Tiết Thông Tin Phiếu Xuất</h1>
                                <div class="text-muted fw-bold fs-5">Tất cả thông tin của phiếu xuất kho có hết tại đây
                                    <a href="#" class="link-primary fw-bolder">BEESOFT</a>.
                                </div>
                            </div>
                            <div class="mb-15">
                                <!-- Begin::Export Info -->
                                <div class="mb-4">
                                    <h5 class="text-primary">Thông tin phiếu xuất</h5>
                                    <div class="row">
                                        <div class="col-md-4">
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
                                    <h5 class="text-primary">Danh sách vật tư</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Mã vật tư</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Số lô</th>
                                                    <th>Chiết khấu (%)</th>
                                                    <th>VAT (%)</th>
                                                    <th>Tổng giá</th>
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
                                <div class="card p-3" style="background: #e1e9f4">
                                    <h5 class="card-title">Tổng kết</h5>
                                    <hr>
                                    <p class="mb-1">Tổng tiền hàng:
                                        <span class="fw-bold" id="modalSubtotal">12.000.000 VND</span>
                                    </p>
                                    <p class="mb-1">Tổng chiết khấu:
                                        <span class="fw-bold" id="modalTotalDiscount">0 VND</span>
                                    </p>
                                    <p class="mb-1">Tổng VAT:
                                        <span class="fw-bold" id="modalTotalVat">0 VND</span>
                                    </p>
                                    <p class="mb-1">Chi phí vận chuyển:
                                        <span class="fw-bold" id="modalShippingCost">0 VND</span>
                                    </p>
                                    <p class="mb-1">Phí khác:
                                        <span class="fw-bold" id="modalOtherFees">0 VND</span>
                                    </p>
                                    <hr>
                                    <p class="fs-4 fw-bold text-success">Tổng giá:
                                        <span id="modalFinalTotal">12.000.000 VND</span>
                                    </p>
                                    <hr>
                                    <button type="button" id="printPdfBtn" class="btn btn-danger btn-sm w-100 mt-3">In
                                        Phiếu</button>
                                </div>
                                <!-- End::Summary -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Export Receipt Modal -->
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
                                <table class="table table-bordered">
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
        document.getElementById('printPdfBtn').addEventListener('click', function() {
            var printArea = document.getElementById('printArea').innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printArea;
            window.print();
            document.body.innerHTML = originalContent;
        });

        function openEditModal(code, number, customer, date, createdBy, note) {
            document.getElementById('editExportCode').value = code;
            document.getElementById('editExportNumber').value = number;
            document.getElementById('editCustomer').value = customer;
            document.getElementById('editExportDate').value = date;
            document.getElementById('editCreatedBy').value = createdBy;
            document.getElementById('editNote').value = note;

            var editExportReceiptModal = new bootstrap.Modal(document.getElementById('editExportReceiptModal'));
            editExportReceiptModal.show();
        }
    </script>
@endsection
