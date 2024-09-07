@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Custom styles for product search */
        /* Định dạng dropdown cho danh sách sản phẩm */
        #productDropdown {
            position: absolute;
            /* Đặt danh sách xuất hiện ngay dưới ô tìm kiếm */
            z-index: 1000;
            /* Đảm bảo danh sách xuất hiện phía trên các phần tử khác */
            width: calc(100% - 80px);
            /* Đặt chiều rộng của danh sách sản phẩm */
            display: none;
            /* Mặc định ẩn danh sách */
            max-height: 200px;
            /* Giới hạn chiều cao tối đa của danh sách */
            overflow-y: auto;
            /* Cho phép cuộn nếu danh sách quá dài */
            background-color: white;
            /* Đặt màu nền cho danh sách */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Tạo bóng cho danh sách */
        }

        #productDropdown a.dropdown-item:hover {
            background-color: #f0f0f0;
            /* Màu nền khi hover */
        }

        .d-flex.align-items-center>* {
            flex-shrink: 0;
        }

        .setupSelect2 {
            max-width: 70%;
        }

        .btn-outline-primary {
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .material-form-container {
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }

        .form-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        .material-input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            color: #333;
            transition: border-color 0.3s;
        }

        .material-input:focus {
            border-color: #007bff;
            background-color: #fff;
            outline: none;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn {
            padding: 5px 15px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cancel-btn {
            color: #333;
            background: none;
            margin-right: 10px;
        }

        .save-continue-btn {
            color: #007bff;
            background: none;
            margin-right: 10px;
        }

        .save-btn {
            color: #007bff;
            background: none;
        }

        .btn:hover {
            opacity: 0.7;
        }

        /* Căn giữa chiều dọc cho các hàng và ô trong bảng */
        .align-middle>tbody>tr>td,
        .align-middle>tbody>tr>th,
        .align-middle>thead>tr>td,
        .align-middle>thead>tr>th {
            vertical-align: middle;
        }

        /* Căn giữa chiều ngang cho các ô trong bảng */
        .text-center {
            text-align: center;
        }

        /* Tùy chỉnh chiều rộng của ô input */
        .table input[type="number"] {
            width: 50px;
        }
    </style>
@endsection

@section('title')
    Kiểm Kho
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                {{-- Thanh tìm kiếm sản phẩm  --}}
                <div class="container mt-4 position-relative">
                    <!-- Input group for search bar -->
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchProductInput"
                            placeholder="Nhập tên hoặc mã hàng hoá (F2)" aria-label="Search" onkeyup="filterProducts()">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#displayCategory"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-list"></i>
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#importExcelModal"
                            class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <!-- Dropdown list of products -->
                    <div class="dropdown-menu w-100 mt-1" id="productDropdown">
                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="selectProduct(this)">
                            <img src="placeholder.png" alt="Product Image" class="me-2"
                                style="width: 40px; height: 40px;">
                            <div>
                                <div class="fw-bold">Băng gạc</div>
                                <small>SP000003 - Giá: 0</small>
                                <div><small>Tồn: 1 - Khách đặt: 0</small></div>
                            </div>
                        </a>

                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="selectProduct(this)">
                            <img src="placeholder.png" alt="Product Image" class="me-2"
                                style="width: 40px; height: 40px;">
                            <div>
                                <div class="fw-bold">Thuốc đỏ</div>
                                <small>SP000003 - Giá: 0</small>
                                <div><small>Tồn: 1 - Khách đặt: 0</small></div>
                            </div>
                        </a>
                        <!-- Thêm nhiều mục sản phẩm khác tương tự -->
                    </div>
                </div>



                {{-- Hiển thị trạng thái  --}}
                <ul class="d-flex">
                    <li class="me-5 text-dark">Tất cả (0)</li>
                    <li class="me-5 text-success">Khớp (0)</li>
                    <li class="me-5 text-warning">Lệch (0)</li>
                    <li class="me-5 text-danger">Chưa kiểm (0)</li>
                </ul>

                {{-- Danh sách vật tư đã thêm --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <td></td>
                                <th>STT</th>
                                <th>Mã hàng</th>
                                <th>Tên hàng</th>
                                <th>Đơn vị tính</th>
                                <th>Tồn kho</th>
                                <th>Thực tế</th>
                                <th>Giá trị lệch</th>
                            </tr>
                        </thead>
                        <tbody id="materialList">
                            <!-- Các dòng vật tư sẽ được thêm động ở đây -->
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Chi tiết kiểm kho  --}}
            <div class="col-md-4">
                <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                    <h5 class="mb-3 fw-bold text-primary">Thông tin kiểm kho</h5>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Tổng SL thực tế:</span>
                            <span class="text-end">40</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Trạng thái:</span>
                            <span class="text-end">Phiếu tạm</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="code" class="form-label fw-semibold">Mã kiểm kho</label>
                        <input type="code" id="code" class="form-control"
                            placeholder="Mã kiểm kho sẽ được tạo tự động">
                    </div>

                    <div class="mb-4">
                        <label for="code" class="form-label fw-semibold">Ngày nhập</label>
                        <input type="date" id="date" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-semibold">Ghi chú</label>
                        <textarea id="notes" class="form-control" placeholder="Nhập ghi chú..." rows="3"></textarea>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4 d-flex">
                        <div class="col-6 me-3">
                            <button type="submit" class="btn btn-sm btn-danger w-100">Lưu tạm</button>
                        </div>

                        <div class="col-6">
                            <button type="submit" class="btn btn-sm btn-success w-100">Lưu hoàn thành</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chọn nhóm hàng -->
    <div class="modal fade" id="displayCategory" tabindex="-1" aria-labelledby="displayCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="displayCategoryLabel">Chọn nhóm vật tư</h5>
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
                            <label class="form-check-label" for="checkAllGroups">Tất cả nhóm vật tư</label>
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script>
        // Mảng chứa dữ liệu sản phẩm
        var products = [{
                name: 'Băng gạc',
                code: 'SP000003',
                price: 0,
                stock: 1,
                unit: 'Hộp'
            },
            {
                name: 'Thuốc đỏ',
                code: 'SP000004',
                price: 0,
                stock: 2,
                unit: 'Chai'
            }
            // Thêm nhiều sản phẩm khác vào đây
        ];

        function filterProducts() {
            var input = document.getElementById('searchProductInput');
            var filter = input.value.toUpperCase();
            var dropdown = document.getElementById('productDropdown');

            // Hiển thị dropdown khi nhập liệu
            dropdown.style.display = filter ? 'block' : 'none';

            // Xóa nội dung dropdown trước khi thêm mới
            dropdown.innerHTML = '';

            // Lọc sản phẩm theo input
            var filteredProducts = products.filter(function(product) {
                return product.name.toUpperCase().indexOf(filter) > -1;
            });

            // Thêm các sản phẩm vào dropdown
            filteredProducts.forEach(function(product) {
                var item = `
                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="selectProduct(this, '${product.name}', '${product.code}', '${product.unit}', ${product.stock})">
                        <img src="placeholder.png" alt="Product Image" class="me-2" style="width: 40px; height: 40px;">
                        <div>
                            <div class="fw-bold">${product.name}</div>
                            <small>${product.code} - Giá: ${product.price}</small>
                            <div><small>Tồn: ${product.stock} - Khách đặt: 0</small></div>
                        </div>
                    </a>
                `;
                dropdown.insertAdjacentHTML('beforeend', item);
            });
        }

        function selectProduct(element, name, code, unit, stock) {
            // Thêm sản phẩm vào bảng vật tư
            addProductToTable(name, code, unit, stock);

            // Ẩn danh sách dropdown sau khi chọn sản phẩm
            document.getElementById('productDropdown').style.display = 'none';

            // Xóa nội dung trong ô tìm kiếm
            document.getElementById('searchProductInput').value = '';
        }

        function addProductToTable(name, code, unit, stock) {
            var tableBody = document.getElementById('materialList');
            var rowCount = tableBody.rows.length + 1;

            var row = `
                <tr>
                    <td>
                        <a href="#" class="text-dark">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                    <td>${rowCount}</td>
                    <td>${code}</td>
                    <td>${name}</td>
                    <td>${unit}</td>
                    <td>${stock}</td>
                    <td>
                        <input type="number">
                    </td>
                    <td>0</td>
                </tr>
            `;

            tableBody.insertAdjacentHTML('beforeend', row);
        }
    </script>
@endsection
