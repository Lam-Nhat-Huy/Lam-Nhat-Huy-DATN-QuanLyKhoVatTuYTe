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

    <!-- Modal nhập excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <!-- Header Section -->
                <div class="modal-header bg-gradient-primary-to-secondary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="importExcelModalLabel">
                        <i class="fa-solid fa-file-import me-2"></i> Nhập Excel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body Section -->
                <div class="modal-body p-4 bg-light">
                    <!-- Notice Section -->
                    <div class="alert alert-info bg-white border-0 p-4 rounded-3 shadow-sm mb-4">
                        <p class="mb-3">
                            Tải về file mẫu:
                            <a href="{{ route('warehouse.exportExcel') }}"
                                class="text-decoration-underline text-primary fw-semibold">
                                Tải File Excel Mẫu
                            </a>
                            hoặc
                            <a href="#" class="text-decoration-underline text-primary fw-semibold">phiên bản khác
                                cao hơn</a>
                        </p>
                        <p class="fw-bold text-danger mb-2">Lưu ý:</p>
                        <ul class="ps-3 text-dark">
                            <li>Hỗ trợ tối đa <strong>500</strong> hàng hóa mỗi lần nhập.</li>
                            <li>Chỉnh sửa dòng bị lỗi nếu có hàng hóa không hợp lệ.</li>
                            <li>Số lượng hàng hóa không quản lý Serial phải lớn hơn 0.</li>
                            <li>Giá nhập, giá bán phải >= 0.</li>
                            <li>Serial phải là duy nhất, không trùng lặp trong hệ thống.</li>
                            <li>Với hàng sản xuất định lượng, vui lòng tạo phiếu sản xuất để ghi nhận tồn kho chính xác.
                            </li>
                        </ul>
                    </div>

                    <!-- File Upload Section -->
                    <form action="{{ route('warehouse.importExcel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="border rounded-3 p-5 text-center bg-white position-relative shadow-sm"
                            style="border: 2px dashed #007bff;">
                            <label for="excelFile" class="form-label fw-semibold pointer">
                                <i class="fa-solid fa-file-excel fa-3x text-success mb-3"></i><br>
                                <span class="text-muted">Kéo thả hoặc click vào đây để chọn file Excel</span>
                            </label>
                            <input type="file" id="excelFile" name="file" class="form-control d-none"
                                accept=".xls,.xlsx" required>
                            <p class="mt-3 text-dark small">Dung lượng tối đa: 10MB</p>
                        </div>

                        <!-- Footer Section -->
                        <div class="modal-footer bg-light border-0 rounded-bottom-4">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success px-4">Tải lên</button>
                        </div>
                    </form>
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
