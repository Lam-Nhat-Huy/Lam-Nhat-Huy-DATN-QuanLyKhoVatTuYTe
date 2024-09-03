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
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Tồn Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.inventory') }}" class="btn btn-sm btn-twitter"><i class="fa fa-plus"></i>Tạo
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
                <div class="col-7 pe-8">
                    <div class="row">
                        <div class="col-6">
                            <select name="ur" id="ur"
                                class="mt-2 mb-2 form-select form-select-sm form-select-solid border border-success setupSelect2">
                                <option value="" selected>--Theo vật tư--</option>
                                <option value="1">Dược phẩm</option>
                                <option value="2">Thực phẩm chức năng</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success btn-sm mt-2 mb-2">Màu HSD</button>
                        </div>
                        <div class="col-2 ">
                            <button class="btn btn-success btn-sm mt-2 mb-2">Màu OH</button>
                            
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
                            <th class="ps-4">Tên sản phẩm</th>
                            <th class="">Nhóm sản phẩm</th>
                            <th class="">Nhóm thuốc</th>
                            <th class="">Tổng tồn</th>
                            <th class="">Đơn vị tính</th>
                            <th class="pe-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>Caxium (Hộp 6 vỉ x 30 viên)</td>
                                <td>Dược phẩm</td>
                                <td>Vitamin - khoáng chất</td>
                                <td>2</td>
                                <td>Hộp</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h me-2"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#detailsModal">Chi tiết</a>
                                            </li>
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
                                <h1 class="mb-3">Chi tiết tồn kho</h1>
                            </div>
                            <div class="mb-15">
                                <div class="mb-4">
                                    <h4 class="text-primary border-bottom border-dark pb-4 mb-4">Danh sách chi tiết</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-hover">
                                            <thead class="fw-bolder bg-success">
                                                <tr>
                                                    <th class="ps-4">STT</th>
                                                    <th>Số lô</th>
                                                    <th>Số lượng</th>
                                                    <th>Ngày sản xuất</th>
                                                    <th>Hạn sử dụng</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modalItemsTableBody">
                                                <tr>
                                                    <td>1</td>
                                                    <td>C1</td>
                                                    <td>50</td>
                                                    <td>20-08-2024</td>
                                                    <td>20-08-2027</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>C2</td>
                                                    <td>30</td>
                                                    <td>20-08-2024</td>
                                                    <td>20-08-2027</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
            });
        });

        document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var allChecked = true;
                document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                    if (!cb.checked) {
                        allChecked = false;
                    }
                });
                document.getElementById('selectAll').checked = allChecked;
            });
        });

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
