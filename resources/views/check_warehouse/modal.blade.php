    <!-- Modal chọn nhóm hàng -->
    <div class="modal fade" id="displayCategory" tabindex="-1" aria-labelledby="displayCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="displayCategoryLabel">Chọn nhóm thiết bị</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Search bar -->
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Tìm kiếm nhóm hàng">
                    </div>

                    <!-- Checkbox Group Selection -->
                    <div class="mb-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="checkAllGroups">
                            <label class="form-check-label" for="checkAllGroups">Tất cả nhóm thiết bị</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="checkGroupAA">
                            <label class="form-check-label" for="checkGroupAA">aa</label>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <!-- Option Filters -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary mb-3">Tùy chọn</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="checkInStock" checked>
                            <label class="form-check-label" for="checkInStock">Chỉ kiểm hàng còn tồn kho</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="checkOnBusiness">
                            <label class="form-check-label" for="checkOnBusiness">Chỉ kiểm hàng đang kinh doanh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkBasicUnit">
                            <label class="form-check-label" for="checkBasicUnit">Chỉ kiểm hàng là đơn vị tính cơ
                                bản</label>
                        </div>
                    </div>

                    <!-- Location Input -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary mb-3">Vị trí</h6>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" class="form-control" placeholder="Chọn vị trí">
                        </div>
                    </div>

                    <!-- Reset Selection -->
                    <div class="d-flex justify-content-end">
                        <a href="#" class="text-decoration-none text-danger fw-bold">Xóa chọn tất cả</a>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bỏ qua</button>
                    <button type="button" class="btn btn-primary">Xong</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal nhập excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="displayCatagoryLabel"
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
                        <label for="excelFile" class="form-label fw-semibold text-secondary">
                            <i class="fa-solid fa-file-excel fa-2x text-success mb-3"></i><br>
                            <span>Kéo thả hoặc click vào để chọn file Excel</span>
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
