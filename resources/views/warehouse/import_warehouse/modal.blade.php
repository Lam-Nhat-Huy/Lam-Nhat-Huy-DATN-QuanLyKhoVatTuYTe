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
                    <button type="button" class="btn btn-sm btn-secondary px-4"
                        data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-danger px-4"> Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết phiếu nhập -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel"
        aria-hidden="true">
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
                                            <p><strong>Mã Hóa Đơn:</strong> <span id="modalInvoiceCode">HD00019</span>
                                            </p>
                                            <p><strong>Số Hóa Đơn:</strong> <span id="modalContractNumber">025</span>
                                            </p>
                                            <p><strong>Nhà Cung Cấp:</strong> <span id="modalSupplier">Trung Sơn</span>
                                            </p>
                                            <p><strong>Ngày Nhập:</strong> <span
                                                    id="modalReceiptDate">26/08/2024</span>
                                            </p>
                                            <p><strong>Người Tạo:</strong> <span id="modalCreatedBy">Nhật Huy</span>
                                            </p>
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
                                    <p class="mb-1">Tổng tiền hàng: <span class="fw-bold"
                                            id="modalSubtotal">12.000.000
                                            VND</span></p>
                                    <p class="mb-1">Tổng chiết khấu: <span class="fw-bold"
                                            id="modalTotalDiscount">0
                                            VND</span></p>
                                    <p class="mb-1">Tổng VAT: <span class="fw-bold" id="modalTotalVat">0 VND</span>
                                    </p>
                                    <p class="mb-1">Chi phí vận chuyển: <span class="fw-bold"
                                            id="modalShippingCost">0
                                            VND</span></p>
                                    <p class="mb-1">Phí khác: <span class="fw-bold" id="modalOtherFees">0
                                            VND</span>
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

    <!-- Modal nhập excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-primary" id="importExcelModalLabel">Nhập Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Notice Section -->
                    <div class="alert alert-warning rounded-3 p-3 mb-4">
                        <p class="mb-1">
                            Tải về file mẫu: <a href="#" class="text-decoration-none text-primary">Excel
                                2003</a>
                            hoặc
                            <a href="#" class="text-decoration-none text-primary">phiên bản khác cao hơn</a>
                        </p>
                        <p class="fw-bold text-danger mb-2">Lưu ý:</p>
                        <ul class="mb-0 text-muted">
                            <li>Hệ thống chỉ hỗ trợ tối đa <strong>500</strong> hàng hóa cho mỗi lần nhập dữ liệu từ
                                file
                                excel.</li>
                            <li>Trong trường hợp file Excel có hàng hóa chưa hợp lệ, bạn vui lòng chỉnh sửa các dòng bị
                                lỗi
                                theo hướng dẫn và thực hiện lại.</li>
                            <li>Đối với hàng hóa không quản lý Serial, số lượng phải lớn hơn 0. Đối với hàng hóa quản lý
                                Serial, Serial phải có định dạng cho phép (a-z, 0-9, ",", " ").</li>
                            <li>Giá nhập, giá bán đều phải lớn hơn hoặc bằng 0.</li>
                            <li>Mỗi hàng hóa chỉ được liệt kê ở 1 dòng duy nhất và Serial phải là duy nhất, không trùng
                                lặp
                                và chưa tồn tại trong hệ thống.</li>
                            <li>Để nhập kho cho hàng sản xuất định lượng, vui lòng vào menu Sản xuất -> tạo phiếu sản
                                xuất
                                để hệ thống ghi nhận tồn kho chính xác hơn.</li>
                        </ul>
                    </div>

                    <!-- File Upload Section -->
                    <div class="border border-2 rounded-3 p-4 text-center bg-light" style="border-style: dashed;">
                        <label for="excelFile" class="form-label fw-semibold pointer">
                            <i class="fa-solid fa-file-excel fa-2x text-success mb-3"></i><br>
                            <span class="text-dark">Kéo thả hoặc click vào để chọn file Excel</span>
                        </label>
                        <input type="file" id="excelFile" class="form-control d-none" accept=".xls,.xlsx">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Tải lên</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thêm nhà cung cấp -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 shadow-sm border-0">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold text-dark" id="addSupplierModalLabel">Tạo Nhà Cung Cấp</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label for="supplier_codeInput" class="form-label fw-semibold">Tên nhà cung
                                    cấp*</label>
                                <input type="text" id="supplier_codeInput"
                                    class="form-control form-control-sm border border-success"
                                    placeholder="Nhập tên nhà cung cấp">
                            </div>
                            <div class="col-6 mb-4">
                                <label for="supplierPhone" class="form-label fw-semibold">Số điện
                                    thoại</label>
                                <input type="text" id="supplierPhone"
                                    class="form-control form-control-sm border border-success"
                                    placeholder="Số điện thoại">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label for="supplierAddress" class="form-label fw-semibold">Địa chỉ</label>
                                <input type="text" id="supplierAddress"
                                    class="form-control form-control-sm border border-success" placeholder="Địa chỉ">
                            </div>
                            <div class="col-6 mb-4">
                                <label for="contactPerson" class="form-label fw-semibold">Người liên
                                    hệ</label>
                                <input type="text" id="contactPerson"
                                    class="form-control form-control-sm border border-success"
                                    placeholder="Người liên hệ">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">Ghi chú</label>
                            <textarea id="notes" class="form-control form-control-sm border border-success" placeholder="Ghi chú"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-sm btn-twitter px-4" form="supplierForm">Lưu</button>
                </div>
            </div>
        </div>
    </div>
