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
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('supplier.add') }}?{{ request()->getQueryString() }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Thêm nhà cung cấp
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 me-6">
            <form action="{{ route('supplier.list') }}" method="GET" class="d-flex align-items-center">
                <div class="me-2 w-75">
                    <input type="search" name="keyword"
                        placeholder="Tìm Kiếm Tên Nhà Cung Cấp, Số Điện Thoại, Địa Chỉ, Email, Mã Số Thuế, Người Liên Hệ.."
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                        value="{{ request()->keyword }}">
                </div>
                <div>
                    <span class="me-2"><a class="btn btn-info btn-sm mt-2 mb-2"
                        href="{{ route('supplier.list') }}">Bỏ Lọc</a></span>
                    <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
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
                            @forelse ($allSupplier as $item)
                                <tr class="text-center hover-table pointer">
                                    <td><input type="checkbox" class="row-checkbox" name="supplier_codes[]"
                                            value="{{ $item->code }}" /></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->tax_code }}</td>
                                    <td>{{ $item->contact_name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h me-2"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{{ route('supplier.edit', $item->code) }}?{{ request()->getQueryString() }}"
                                                        class="dropdown-item"><i class="fa fa-edit me-1"></i>Sửa</a></li>
                                                <li><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal_{{ $item->code }}"
                                                        class="dropdown-item"><i class="fa fa-trash me-1"></i>Xóa</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                {{-- Xóa --}}
                                <div class="modal fade" id="deleteModal_{{ $item->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
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
                            @empty
                                <tr id="noDataAlert">
                                    <td colspan="12" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-search" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không có kết
                                                    quả tìm kiếm</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Không tìm thấy kết quả phù hợp với yêu cầu tìm kiếm của bạn. Vui lòng
                                                    thử lại với từ khóa khác.
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
