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

@section('scripts')
    <script>
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
                toggleDeleteAction();
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
                    toggleDeleteAction(); // Gọi hàm kiểm tra nút xóa tất cả
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#restoreAll').addEventListener('show.bs.modal', function() {
                document.getElementById('action_type').value = 'restore';
            });
            document.querySelector('#deleteAll').addEventListener('show.bs.modal', function() {
                document.getElementById('action_type').value = 'delete';
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            toggleDeleteAction();
        });
    </script>
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Thùng Rác</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('supplier.list') }}" class="btn btn-sm btn-dark me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form action="{{ route('supplier.trash') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder bg-success">
                                <th class="ps-4">
                                    <input type="checkbox" id="selectAll" />
                                </th>
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
                            @forelse ($allSupplierTrash as $item)
                                <tr class="hover-table pointer">
                                    <td>
                                        <input type="checkbox" name="supplier_codes[]" value="{{ $item->code }}"
                                            class="row-checkbox" />
                                    </td>
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
                                                <li>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#restoreModal_{{ $item->code }}"
                                                        class="dropdown-item"><i class="fa fa-rotate-right me-1">
                                                        </i>Khôi Phục
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal_{{ $item->code }}"
                                                        class="dropdown-item"><i class="fa fa-trash me-1">
                                                        </i>Xóa Vĩnh Viễn
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                {{-- Khôi Phục --}}
                                <div class="modal fade" id="restoreModal_{{ $item->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="restoreModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('supplier.trash') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="restoreModalLabel">Khôi Phục Nhà cung cấp
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="supplier_code_restore"
                                                        value="{{ $item->code }}">
                                                    <h4 class="text-primary text-center">Khôi Phục Nhà cung cấp Này?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-sm btn-twitter">Khôi
                                                        Phục</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Xóa --}}
                                <div class="modal fade" id="deleteModal_{{ $item->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('supplier.trash') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Vĩnh Viễn Nhà cung cấp
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="supplier_code_delete"
                                                        value="{{ $item->code }}">
                                                    <h4 class="text-danger text-center">Xóa Vĩnh Viễn Nhà cung cấp Này?</h4>
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
                                <div>
                                    <tr>
                                        <th colspan="10" class="text-danger text-center py-5">Không Có Dữ Liệu</th>
                                    </tr>
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($allSupplierTrash->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown" id="action_delete_all">
                        <span class="btn btn-info btn-sm dropdown-toggle" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#restoreAll">
                                    <i class="fas fa-rotate-right me-2 text-primary"></i>Khôi Phục
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>Xóa Vĩnh Viễn
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <ul class="pagination">
                        {{ $allSupplierTrash->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif

            {{-- Modal Xác Nhận Khôi Phục Tất Cả --}}
            <div class="modal fade" id="restoreAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="restoreAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="restoreAllLabel">Xác Nhận khôi phục Nhà cung cấp</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn khôi phục Nhà cung cấp đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-twitter px-4">Xóa</button>
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
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Xóa Nhà cung cấp</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa tất cả Nhà cung cấp đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-danger px-4">Khôi phục</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
