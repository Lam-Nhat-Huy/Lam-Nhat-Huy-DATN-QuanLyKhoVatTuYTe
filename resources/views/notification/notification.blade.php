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

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#browseAll').addEventListener('show.bs.modal', function() {
                document.getElementById('action_type').value = 'browse';
            });

            document.querySelector('#deleteAll').addEventListener('show.bs.modal', function() {
                document.getElementById('action_type').value = 'delete';
            });
        });

        // Kiểm tra trạng thái ban đầu khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            toggleDeleteAction();
        });

        document.getElementById('form-1').addEventListener('submit', function(event) {
            submitAnimation(event);
        });

        document.getElementById('form-2').addEventListener('submit', function(event) {
            submitAnimation(event);
        });

        document.getElementById('form-3').addEventListener('submit', function(event) {
            submitAnimation(event);
        });

        document.getElementById('form-4').addEventListener('submit', function(event) {
            submitAnimation(event);
        });
    </script>
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Thông Báo</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('notification.notification_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('notification.notification_add') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Thêm Thông Báo
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1">
            <form action="{{ route('notification.index') }}" id="form-1" method="GET" class="row align-items-center">
                <div class="col-3">
                    <select name="ur" id="ur"
                        class="mt-2 mb-2 form-select form-select-sm border border-success setupSelect2">
                        <option value="" selected>--Theo Người Báo Cáo--</option>
                        @foreach ($AllUser as $item)
                            <option value={{ $item->code }} {{ request()->rt == $item->code ? 'selected' : '' }}>
                                {{ $item->last_name }} {{ $item->first_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <select name="rt" id="rt"
                        class="mt-2 mb-2 form-select form-select-sm border border-success setupSelect2">
                        <option value="" selected>--Theo Loại Báo Cáo--</option>
                        @foreach ($AllNotificationType as $item)
                            <option value={{ $item->id }} {{ request()->rt == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <select name="st" class="mt-2 mb-2 form-select form-select-sm setupSelect2">
                        <option value="" {{ request()->st == '' ? 'selected' : '' }}>--Theo Trạng Thái--</option>
                        <option value="0" {{ request()->st == '0' ? 'selected' : '' }}>Chưa Duyệt</option>
                        <option value="1" {{ request()->st == '1' ? 'selected' : '' }}>Đã Duyệt</option>
                    </select>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-8">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã, Tên, Email Người Dùng.."
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ request()->kw }}">
                        </div>
                        <div class="col-4">
                            <span class="me-2">
                                <a class="btn btn-info btn-sm mt-2 mb-2" href="{{ route('notification.index') }}">Bỏ
                                    Lọc</a>
                            </span>
                            <span>
                                <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <form action="{{ route('notification.index') }}" id="form-2" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder bg-success text-center">
                                <th class="ps-4" style="width: 5%">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th class="" style="width: 10%">Mã Thông Báo</th>
                                <th class="" style="width: 10%">Người Tạo</th>
                                <th class="" style="width: 16%">Nội Dung</th>
                                <th class="" style="width: 16%">Loại Thông Báo</th>
                                <th class="" style="width: 10%">Ngày Tạo</th>
                                <th class="" style="width: 10%">Trạng Thái</th>
                                <th class="" style="width: 10%">Quan Trọng</th>
                                <th class="pe-3 text-center" style="width: 10%">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($AllNotification as $item)
                                <tr class="hover-table pointer text-center">
                                    <td>
                                        <input type="checkbox" name="notification_codes[]" value="{{ $item->code }}"
                                            class="row-checkbox" />
                                    </td>
                                    <td>
                                        #{{ $item->code }}
                                    </td>
                                    <td>
                                        {{ !empty($item->users->last_name && $item->users->first_name) ? $item->users->last_name . ' ' . $item->users->first_name : 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="text-primary pointer" data-bs-toggle="modal"
                                            data-bs-target="#detail_{{ $item->code }}">Xem Nội Dung
                                        </span>
                                    </td>
                                    <td>
                                        {{ $item->notification_types->name }}
                                    </td>
                                    <td>
                                        {{ $item->created_at->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <span class="rounded px-2 py-1 text-white bg-danger text-center"
                                                style="font-size: 10px;">Chưa duyệt</span>
                                        @else
                                            <span class="rounded px-2 py-1 text-white bg-success text-center"
                                                style="font-size: 10px;">Đã duyệt</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->important == 1)
                                            <span class="rounded px-2 py-1 text-white bg-warning text-center"
                                                style="font-size: 10px;"> Có</span>
                                        @else
                                            <span class="rounded px-2 py-1 text-white bg-danger text-center"
                                                style="font-size: 10px;"> Không</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h me-2"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                                @if ($item->status == 0)
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#browse_{{ $item->code }}"><i
                                                                class="fa fa-clipboard-check me-1"></i>Duyệt</a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('notification.notification_edit', $item->code) }}">
                                                        <i class="fa fa-edit me-1"></i>Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item pointer" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal_{{ $item->code }}">
                                                        <i class="fa fa-trash me-1"></i>Xóa
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        {{-- Chi Tiết --}}
                                        <div class="modal fade" id="detail_{{ $item->code }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="DetailModal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="DetailModal">Nội Dung Thông Báo
                                                            #{{ $item->code }}
                                                        </h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <strong>
                                                            {!! $item->content !!}
                                                        </strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Duyệt Thông Báo -->
                                        <div class="modal fade" id="browse_{{ $item->code }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="checkModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-success text-white">
                                                        <h3 class="modal-title text-white" id="checkModalLabel">Duyệt
                                                            Thông Báo</h3>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('notification.index') }}" id="form-3"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="browse_notification"
                                                            value="{{ $item->code }}">
                                                        <div class="modal-body text-center pb-0">
                                                            <p class="text-dark mb-4">Bạn có chắc chắn muốn duyệt phiếu
                                                                nhập kho này?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center border-0 pt-0">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success">Duyệt</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- Xóa --}}
                                        <div class="modal fade" id="deleteModal_{{ $item->code }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="deleteModalLabel">Xóa Thông Báo
                                                        </h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('notification.index') }}" id="form-4"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="delete_notification"
                                                            value="{{ $item->code }}">
                                                        <div class="modal-body">
                                                            <h4 class="text-danger">Xóa Thông Báo Này?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Xóa</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr id="noDataAlert">
                                    <td colspan="10" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-ban" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không Có Dữ
                                                    Liệu</h5>
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
            @if ($AllNotification->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown" id="action_delete_all">
                        <span class="btn btn-info btn-sm dropdown-toggle" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#browseAll">
                                    <i class="fas fa-clipboard-check me-2 text-success"></i>Duyệt
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>Xóa
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <ul class="pagination">
                        {{ $AllNotification->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif
            {{-- Modal Duyệt Tất Cả --}}
            <div class="modal fade" id="browseAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="browseAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title text-white" id="browseAllLabel">Duyệt Tất Cả thông báo</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn duyệt tất cả thông báo đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary btn-sm px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-success px-4">
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
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa tất cả thông báo đã chọn?</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-success px-4"> Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
