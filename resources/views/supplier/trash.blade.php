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
                        <tbody>
                            @forelse ($allSupplierTrash as $item)
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
                                {{-- Khôi Phục --}}
                                <div class="modal fade" id="restoreModal_{{ $item->code }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="restoreModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
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
                                    <div class="modal-dialog modal-dialog-centered">
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
                                                    <h4 class="text-danger text-center">Xóa Vĩnh Viễn Nhà cung cấp Này?
                                                    </h4>
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
                                                <!-- Khôi phục -->
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#restoreModal_{{ $item->code }}"
                                                    class="btn btn-sm btn-twitter me-2 printPdfBtn" type="button"><i
                                                        class="fa fa-rotate-right me-1">
                                                    </i>Khôi Phục
                                                </a>
                                                <!-- Xóa vĩnh viễn -->
                                                <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal_{{ $item['code'] }}" type="button">
                                                    <i class="fa fa-trash"></i>Xóa
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                            <button type="submit" class="btn btn-sm btn-twitter px-4">Khôi Phục</button>
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
                            <button type="submit" class="btn btn-sm btn-danger px-4">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
