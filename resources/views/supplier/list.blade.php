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
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhà Cung Cấp</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('supplier.trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Thêm Thông Báo
                    </span>
                </a>
            </div>
        </div>


        <div class="card-body py-1 me-6">
            <form action="" class="d-flex align-items-center">
                <div class="me-2 w-100">
                    <input type="search" name="kw"
                        placeholder="Tìm Kiếm Tên Nhà Cung Cấp, Số Điện Thoại, Địa Chỉ, Email, Mã Số Thuế, Người Liên Hệ.."
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                        value="{{ request()->kw }}">
                </div>
                <div>
                    <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                </div>
            </form>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead class="fw-bolder bg-success">
                        <tr>
                            <th class="ps-4"><input type="checkbox" id="selectAll" /></th>
                            <th>Tên Nhà cung cấp</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Mã số thuế</th>
                            <th>Người liên hệ</th>
                            <th class="pe-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table pointer">
                                <td><input type="checkbox" class="row-checkbox" /></td>
                                <td>Công Ty Dược Phẩm TP.HCM</td>
                                <td>0209194501</td>
                                <td>TP - Hồ Chí Minh</td>
                                <td>duochcm@gmail.com</td>
                                <td>19051969</td>
                                <td>Bác Sỹ Huy</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h me-2"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="{{ route('supplier.edit') }}" class="dropdown-item"><i
                                                        class="fa fa-edit me-1"></i>Sửa</a></li>
                                            <li><a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal_{{ $i }}"
                                                    class="dropdown-item"><i class="fa fa-trash me-1"></i>Xóa</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            {{-- Xóa --}}
                            <div class="modal fade" id="deleteModal_{{ $i }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content text-center">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="deleteModalLabel">Xóa Nhà Cung Cấp
                                            </h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="">
                                                @csrf
                                                <h4 class="text-danger">Xóa Nhà Cung Cấp Này?</h4>
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
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-body py-3 mb-3">
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
        // Handle Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            var isChecked = this.checked;
            document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        // Sync Select All with individual checkboxes
        document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var allChecked = document.querySelectorAll('.row-checkbox:checked').length === document
                    .querySelectorAll('.row-checkbox').length;
                document.getElementById('selectAll').checked = allChecked;
            });
        });

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
