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

        .checkbox-wrapper-6 .tgl {
            display: none;
        }

        .checkbox-wrapper-6 .tgl,
        .checkbox-wrapper-6 .tgl:after,
        .checkbox-wrapper-6 .tgl:before,
        .checkbox-wrapper-6 .tgl *,
        .checkbox-wrapper-6 .tgl *:after,
        .checkbox-wrapper-6 .tgl *:before,
        .checkbox-wrapper-6 .tgl+.tgl-btn {
            box-sizing: border-box;
        }

        .checkbox-wrapper-6 .tgl::-moz-selection,
        .checkbox-wrapper-6 .tgl:after::-moz-selection,
        .checkbox-wrapper-6 .tgl:before::-moz-selection,
        .checkbox-wrapper-6 .tgl *::-moz-selection,
        .checkbox-wrapper-6 .tgl *:after::-moz-selection,
        .checkbox-wrapper-6 .tgl *:before::-moz-selection,
        .checkbox-wrapper-6 .tgl+.tgl-btn::-moz-selection,
        .checkbox-wrapper-6 .tgl::selection,
        .checkbox-wrapper-6 .tgl:after::selection,
        .checkbox-wrapper-6 .tgl:before::selection,
        .checkbox-wrapper-6 .tgl *::selection,
        .checkbox-wrapper-6 .tgl *:after::selection,
        .checkbox-wrapper-6 .tgl *:before::selection,
        .checkbox-wrapper-6 .tgl+.tgl-btn::selection {
            background: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn {
            outline: 0;
            display: block;
            width: 40px;
            height: 22px;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after,
        .checkbox-wrapper-6 .tgl+.tgl-btn:before {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after {
            left: 0;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:before {
            display: none;
        }

        .checkbox-wrapper-6 .tgl:checked+.tgl-btn:after {
            left: 50%;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn {
            background: #b5b5b5;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn:after {
            border-radius: 50%;
            background: #fff;
            transition: all 0.2s ease;
        }

        .checkbox-wrapper-6 .tgl-light:checked+.tgl-btn {
            background: #1fb948;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
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

        document.addEventListener('DOMContentLoaded', function() {
            // Khi nhấn nút "Khôi Phục Tất Cả"
            document.querySelector('#restoreAll').addEventListener('show.bs.modal', function() {
                document.getElementById('action_type').value = 'restore';
            });

            // Khi nhấn nút "Xóa Tất Cả"
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
    </script>
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Thùng Rác</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('user.index') }}" class="btn btn-sm btn-dark me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form id="form-1" action="{{ route('user.user_trash') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="">
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder bg-success">
                                <th class="ps-3">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th class="" style="width: 5% !important;">Mã ND</th>
                                <th class="" style="width: 10% !important;">Ảnh</th>
                                <th class="" style="width: 10% !important;">Họ Tên</th>
                                <th class="" style="width: 15% !important;">Email</th>
                                <th class="" style="width: 10% !important;">SĐT</th>
                                <th class="" style="width: 10% !important;">Giới Tính</th>
                                <th class="" style="width: 10% !important;">Chức Vụ</th>
                                <th class="" style="width: 10% !important;">Trạng Thái</th>
                                <th class="" style="width: 10% !important;">Ngày Xóa</th>
                                <th class="pe-3" style="width: 5% !important;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allUserTrash as $item)
                                <tr class="hover-table pointer">
                                    <td>
                                        <input type="checkbox" name="user_codes[]" value="{{ $item->code }}"
                                            class="row-checkbox" />
                                    </td>
                                    <td>
                                        #{{ $item->code }}
                                    </td>
                                    <td>
                                        <img class="rounded-circle border border-dark"
                                            src="{{ $item->avatar ? asset('storage/' . $item->avatar) : 'https://static-00.iconduck.com/assets.00/avatar-default-symbolic-icon-2048x1949-pq9uiebg.png' }}"
                                            style="width: 70px !important; height: 70px !important;" alt="">
                                    </td>
                                    <td>
                                        {{ $item->last_name . ' ' . $item->first_name }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                    <td>
                                        {{ $item->phone }}
                                    </td>
                                    <td>
                                        {{ $item->gender }}
                                    </td>
                                    <td>
                                        @if ($item->position == 'Nhân Viên')
                                            <span class="text-primary">{{ $item->position }}</span>
                                        @else
                                            <span class="text-danger">{{ $item->position }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="checkbox-wrapper-6">
                                            <input class="tgl tgl-light" id="cb1-6" type="checkbox" value="1"
                                                name="status" {{ !empty($item->status) == 1 ? 'checked' : '' }}
                                                disabled />
                                            <label class="tgl-btn" for="cb1-6"></label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->deleted_at->format('d-m-Y') }}
                                    </td>
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
                                            <form id="form-2" action="{{ route('user.user_trash') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="restoreModalLabel">Khôi Phục Người Dùng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="user_code_restore"
                                                        value="{{ $item->code }}">
                                                    <h4 class="text-primary text-center">Khôi Phục Người Dùng Này?</h4>
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
                                            <form id="form-3" action="{{ route('user.user_trash') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Vĩnh Viễn Người Dùng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="user_code_delete"
                                                        value="{{ $item->code }}">
                                                    <h4 class="text-danger text-center">Xóa Vĩnh Viễn Người Dùng Này?</h4>
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
                                    <td colspan="11" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                            role="alert"
                                            style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-ban" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không có dữ
                                                    liệu</h5>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($allUserTrash->count() > 0)
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
                        {{ $allUserTrash->links('pagination::bootstrap-5') }}
                    </ul>
                </div>
            @endif

            {{-- Modal Xác Nhận Khôi Phục Tất Cả --}}
            <div class="modal fade" id="restoreAll" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="restoreAllLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="restoreAllLabel">Xác Nhận khôi phục người dùng</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <p class="text-primary mb-4">Bạn có chắc chắn muốn khôi phục người dùng đã chọn?</p>
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
                            <h5 class="modal-title text-white" id="deleteAllLabel">Xác Nhận Xóa người dùng</h5>
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
