@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table:hover {
            background: #ccc;
        }

        .selected-row {
            background: #ddd;
        }

        .active-row {
            background: #d1c4e9;
            /* Màu nền khi hàng được nhấp vào */
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Yêu Cầu Đặt Hàng</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('order_request.order_request_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('order_request.insert_order_request') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Tạo Yêu Cầu
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 me-6">
            <form action="" class="row align-items-center">
                <div class="col-3">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Nhà Cung Cấp--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Người Tạo--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="stt" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Trạng Thái--</option>
                        <option value="1" {{ request()->stt == 1 ? 'selected' : '' }}>Chưa Duyệt</option>
                        <option value="2" {{ request()->stt == 2 ? 'selected' : '' }}>Đã Duyệt</option>
                    </select>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã Yêu Cầu.."
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
                            <th class="">Mã Yêu Cầu</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Người Tạo</th>
                            <th class="">Ngày Tạo</th>
                            <th class="" style="width: 120px !important;">Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllOrderRequest as $item)
                            <tr class="text-center hover-table pointer">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>
                                    #{{ $item['order_request_code'] }}
                                </td>
                                <td>
                                    {{ $item['supplier_id'] }}
                                </td>
                                <td>
                                    {{ $item['user_create'] }}
                                </td>
                                <td>
                                    {{ $item['date_of_entry'] }}
                                </td>
                                <td>
                                    @if ($item['status'] == 1)
                                        <div class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</div>
                                    @else
                                        <div class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h me-2"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow" aria-labelledby="defaultDropdown">
                                            @if ($item['status'] == 1)
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#browse_{{ $item['id'] }}">
                                                        <i class="fa fa-clipboard-check me-1"></i>Duyệt
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('order_request.update_order_request') }}">
                                                        <i class="fa fa-edit me-1"></i>Sửa
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item pointer" id="printPdfBtn">
                                                        <i class="fa fa-print me-1"></i>In
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item pointer" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal_{{ $item['id'] }}">
                                                        <i class="fa fa-trash me-1"></i>Xóa
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    {{-- Duyệt --}}
                                    <div class="modal fade" id="browse_{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="checkModalLabel">Duyệt Yêu Cầu Đặt
                                                        Hàng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Duyệt Yêu Cầu Đặt Hàng Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-twitter">Duyệt</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- In --}}
                                    <div id="printArea" class="fade modal">
                                        <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                            <div class="d-flex mb-5">
                                                <img src="https://i.pinimg.com/originals/36/b0/a0/36b0a084544360c807d7c778358f762d.png"
                                                    width="100" alt="">
                                                <div class="text-left mt-3">
                                                    <h6 class="mb-0 pb-0">PHÒNG KHÁM ĐA KHOA BEESOFT</h6>
                                                    <div>307C Nguyễn Văn Linh, An Khánh, Ninh Kiều, Cần Thơ
                                                    </div>
                                                    <div>Hotline: 0900900999</div>
                                                </div>
                                            </div>
                                            <form action="" method="post">
                                                <div class="text-center mb-13">
                                                    <h1 class="mb-3 text-uppercase text-primary">Phiếu Yêu Cầu
                                                        Đặt Hàng
                                                    </h1>
                                                    <div class="text-muted fw-bold fs-6">Thông Tin Chi Tiết Về
                                                        Phiếu Yêu Cầu Đặt Hàng
                                                        <span class="link-primary fw-bolder">#MaYeuCauMuaHang</span>.
                                                    </div>
                                                    <div class="text-muted fs-30">
                                                        Ngày Lập 2-9-2024
                                                    </div>
                                                </div>
                                                <div class="mb-15 text-left">
                                                    <!-- Begin::Receipt Info -->
                                                    <div class="mb-4">
                                                        <h4 class="text-primary border-bottom border-dark pb-4">
                                                            Thông Tin Đặt Hàng</h4>
                                                        <div class="pt-2">
                                                            <p><strong>Người Yêu Cầu:</strong> <span id="modalSupplier">Lữ
                                                                    Phát Huy</span>
                                                            </p>
                                                            <p><strong>Địa Chỉ:</strong> <span id="modalSupplier">24, Trần
                                                                    Chiên, Lê Bình,
                                                                    Cái Răng, Cần Thơ</span>
                                                            </p>
                                                            <p><strong>Số Điện Thoại:</strong> <span
                                                                    id="modalSupplier">0945 567 048</span>
                                                            </p>
                                                            <h6><span id="modalSupplier">Công Ty <span
                                                                        class="text-success">BeeSoft</span> Có
                                                                    Nhu
                                                                    Cầu Đặt Hàng Tại
                                                                    <span class="text-danger">#TenNhaCungCap</span>
                                                                    theo mẫu yêu
                                                                    cầu như sau:</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <!-- End::Receipt Info -->

                                                    <!-- Begin::Receipt Items -->
                                                    <div class="mb-4">
                                                        <h4 class="text-primary border-bottom border-dark pb-4 mb-4">
                                                            Danh Sách Vật Tư</h4>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped align-middle gs-0 gy-4">
                                                                <thead>
                                                                    <tr class="fw-bolder bg-success">
                                                                        <th style="width: 33%;">Vật Tư</th>
                                                                        <th style="width: 33%;">Đơn Vị</th>
                                                                        <th style="width: 33%;">Số Lượng
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="text-center">
                                                                        <td>
                                                                            Bình Oxy Y Tế - (Bình 5 Lít)
                                                                        </td>
                                                                        <td>
                                                                            Bình
                                                                        </td>
                                                                        <td>
                                                                            100
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div>
                                                            <p><strong>Ghi Chú: </strong><span>Giao Lẹ</span>
                                                            </p>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-7"></div>
                                                            <div class="col-5 text-center">
                                                                <p class="m-0 p-0">
                                                                    Cần Thơ, ngày
                                                                    {{ \Carbon\Carbon::now()->day }}
                                                                    tháng
                                                                    {{ \Carbon\Carbon::now()->month }} năm
                                                                    {{ \Carbon\Carbon::now()->year }}
                                                                </p>
                                                                <p class="m-0 p-0">
                                                                    <strong>Người Lập</strong>
                                                                </p>
                                                                <p style="margin-top: 70px !important;">
                                                                    Lữ Phát Huy
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Xóa --}}
                                    <div class="modal fade" id="deleteModal_{{ $item['id'] }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Yêu Cầu
                                                        Đặt Hàng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Xóa Yêu Cầu Đặt Hàng Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-danger">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body py-3">
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
                    <h5 class="modal-title text-white" id="confirmAll">Duyệt Tất Cả thông báo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt tất cả thông báo đã chọn?</p>
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
                    <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Xóa Tất Cả thông báo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa tất cả thông báo đã chọn?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-success px-4"> Xóa</button>
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
