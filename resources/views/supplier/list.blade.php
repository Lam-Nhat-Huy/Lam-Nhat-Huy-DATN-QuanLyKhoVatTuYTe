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

@section('scripts')
    <script>
        // Đổi biểu tượng khi bấm vào td có chứa chevron
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(td) {
            td.addEventListener('click', function(event) {
                // Tìm phần tử <i> bên trong <td>
                var icon = this.querySelector('i');

                // Kiểm tra nếu có <i> thì thực hiện đổi biểu tượng
                if (icon) {
                    // Đổi icon khi click
                    if (icon.classList.contains('fa-chevron-right')) {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-down');
                    } else {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-right');
                    }
                }

                // Ngăn chặn việc click ảnh hưởng đến hàng (row)
                event.stopPropagation();
            });
        });
        // Hàm kiểm tra và ẩn/hiện nút xóa tất cả
        function toggleDeleteAction() {
            var anyChecked = false;
            document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
                if (checkbox.checked) {
                    anyChecked = true;
                }
            });

            if (anyChecked) {
                document.getElementById('action_delete_all').style.display = 'block';
            } else {
                document.getElementById('action_delete_all').style.display = 'none';
            }
        }

        // Khi click vào checkbox "Select All"
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
            toggleDeleteAction();
        });

        // Khi checkbox của từng hàng thay đổi
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
                toggleDeleteAction(); // Gọi hàm kiểm tra nút xóa tất cả
            });
        });

        // Khi người dùng click vào hàng
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
                    toggleDeleteAction(); // Gọi hàm kiểm tra nút xóa tất cả
                }
            });
        });

        // Kiểm tra trạng thái ban đầu khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            toggleDeleteAction();
        });
    </script>
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
                <a href="{{ route('supplier.trash') }}?{{ request()->getQueryString() }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex" style="font-size: 10px;">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('supplier.add') }}?{{ request()->getQueryString() }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex" style="font-size: 10px;">
                        <i class="fa fa-plus me-1"></i>
                        Thêm nhà cung cấp
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 me-6">
            <form id="search-form" method="GET" class="d-flex align-items-center">
                <div class="me-2" style="width: 88%">
                    <input type="search" id="keyword" name="keyword"
                        placeholder="Tìm Kiếm Tên Nhà Cung Cấp, Số Điện Thoại, Địa Chỉ, Email, Mã Số Thuế, Người Liên Hệ.."
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
                </div>
                <div>
                    <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit" style="font-size: 10px;">Tìm</button>
                </div>
            </form>
        </div>
        <form action="{{ route('supplier.list') }} " method="POST">
            @csrf
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead class="fw-bolder bg-success">
                            <tr>
                                <th class="ps-4"><input type="checkbox" id="selectAll" /></th>
                                <th style="width: 30% !important;">Tên Nhà cung cấp</th>
                                <th style="width: 15% !important;">Số điện thoại</th>
                                <th style="width: 25% !important;">Email</th>
                                <th style="width: 20% !important;">Người liên hệ</th>
                                <th style="width: 10% !important;" class="pe-3">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody id="supplierTableBody">
                            @forelse ($allSupplier as $item)
                                <tr class="text-center hover-table pointer">
                                    <td class="text-xl-start"><input type="checkbox" class="row-checkbox"
                                            name="supplier_codes[]" value="{{ $item->code }}" /></td>
                                    <td class="text-xl-start text-truncate" style="max-width: 150px;">
                                        {{ $item->name }}
                                    </td>
                                    <td class="text-xl-start text-truncate" style="max-width: 150px;">{{ $item->phone }}
                                    </td>
                                    <td class="text-xl-start text-truncate" style="max-width: 150px;">{{ $item->email }}
                                    </td>
                                    <td class="text-xl-start text-truncate" style="max-width: 150px;">
                                        {{ $item->contact_name }}</td>
                                    <td class="text-center" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $item['code'] }}" id="toggleIcon{{ $item['code'] }}">
                                        <i class="fa fa-chevron-right pointer">
                                        </i>
                                    </td>
                                </tr>
                                {{-- Xóa --}}
                                <div class="modal fade" id="deleteModal_{{ $item->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('supplier.list') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Người Dùng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="supplier_code_delete"
                                                        value="{{ $item->code }}">
                                                    <h4 class="text-danger text-center">Xóa Người Dùng Này?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Collapse content -->
                                <tr class="collapse multi-collapse" id="collapse{{ $item['code'] }}">
                                    <td class="p-0" colspan="12"
                                        style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                        <div class="flex-lg-row-fluid border-2 border-lg-1">
                                            <div class="card card-flush p-2"
                                                style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                                <div class="card-header d-flex justify-content-between align-items-center p-2"
                                                    style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                    <div class="row py-5" style="padding-top: 0px !important">
                                                        <h4 class="fw-bold m-3">Chi tiết nhà cung cấp</h4>
                                                        <!-- Begin::Receipt Info (Left column) -->
                                                        <div class="col-md-6">
                                                            <table class="table table-flush gy-1">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class=""><strong>Tên nhà cung
                                                                                cấp</strong></td>
                                                                        <td class="text-gray-800">{{ $item->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Số điện thoại</strong>
                                                                        </td>
                                                                        <td class="text-gray-800">{{ $item->phone }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Địa chỉ</strong></td>
                                                                        <td class="text-gray-800">{{ $item->address }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <table class="table table-flush gy-1">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class=""><strong>Email</strong></td>
                                                                        <td class="text-gray-800">{{ $item->email }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=""><strong>Mã số thuế</strong></td>
                                                                        <td class="text-gray-800">{{ $item->tax_code }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body py-3 text-end">
                                            <div class="button-group">
                                                <!-- Sửa -->
                                                <a href="{{ route('supplier.edit', $item->code) }}?{{ request()->getQueryString() }}" class="btn btn-sm btn-twitter me-2 printPdfBtn" type="button">
                                                    <i class="fa fa-edit"></i>Sửa
                                                </a>
                                                <!-- Xóa -->
                                                <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal_{{ $item['code'] }}" type="button">
                                                    <i class="fa fa-trash"></i>Xóa
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                @empty
                                <tr id="noDataAlert">
                                    <td colspan="12" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-truck" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không có nhà
                                                    cung cấp </h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Chưa có nhà cung cấp nào, vui lòng thêm nhà cung cấp
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($allSupplier->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown" id="action_delete_all">
                        <span class="btn btn-info btn-sm dropdown-toggle" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>Xóa Tất Cả</a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <ul class="pagination">
                        {{ $allSupplier->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif
            {{-- Modal Xác Nhận Xóa Tất Cả --}}
            <div class="modal fade" id="deleteAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="deleteAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Xóa Tất Cả người dùng</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa tất cả người dùng đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-danger px-4">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
