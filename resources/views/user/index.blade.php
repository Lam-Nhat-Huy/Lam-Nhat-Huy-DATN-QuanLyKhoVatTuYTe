@extends('master_layout.layout')

@section('styles')
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

        // Kiểm tra trạng thái ban đầu khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            toggleDeleteAction();
        });
    </script>
@endsection


@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Người Dùng</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('user.user_trash') }}?{{ request()->getQueryString() }}"
                    class="btn rounded-pill btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('user.add') }}?{{ request()->getQueryString() }}"
                    class="btn rounded-pill btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Thêm Người Dùng
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1">
            <form action="{{ route('user.index') }}" method="GET" class="row align-items-center">
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <select name="gd" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2">
                        <option value="" {{ request()->gd == '' ? 'selected' : '' }}>--Theo Giới Tính--</option>
                        <option value="nam" {{ request()->gd == 'nam' ? 'selected' : '' }}>Nam</option>
                        <option value="nữ" {{ request()->gd == 'nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <select name="ps" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2">
                        <option value="" {{ request()->ps == '' ? 'selected' : '' }}>--Theo Chức Vụ--</option>
                        <option value="1" {{ request()->ps == '1' ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ request()->ps == '0' ? 'selected' : '' }}>Nhân Viên</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <select name="st" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2">
                        <option value="" {{ request()->st == '' ? 'selected' : '' }}>--Theo Trạng Thái--</option>
                        <option value="0" {{ request()->st == '0' ? 'selected' : '' }}>Không</option>
                        <option value="1" {{ request()->st == '1' ? 'selected' : '' }}>Có</option>
                    </select>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="row align-items-center">
                        <div class="col-7">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã, Tên, Email Người Dùng.."
                                class="mt-2 mb-2 form-control form-control-sm rounded-pill border border-success w-100"
                                value="{{ request()->kw }}">
                        </div>
                        <div class="col-5 d-flex justify-content-between">
                            <a class="btn rounded-pill btn-info btn-sm mt-2 mb-2 w-100 me-2"
                                href="{{ route('user.index') }}"><i class="fas fa-times-circle"
                                    style="margin-bottom: 2px;"></i>Bỏ Lọc</a>
                            <button class="btn rounded-pill btn-dark btn-sm mt-2 mb-2 w-100 load_animation"
                                type="submit"><i class="fa fa-search" style="margin-bottom: 2px;"></i>Tìm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <form action="{{ route('user.index') }}" method="POST">
            @csrf
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder bg-success">
                                <th class="ps-3">
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th class="" style="width: 6% !important;">Mã ND</th>
                                <th class="" style="width: 11% !important;">Ảnh</th>
                                <th class="" style="width: 13% !important;">Họ Tên</th>
                                <th class="" style="width: 14% !important;">Email</th>
                                <th class="" style="width: 14% !important;">SĐT</th>
                                <th class="" style="width: 11% !important;">Giới Tính</th>
                                <th class="" style="width: 11% !important;">Chức Vụ</th>
                                <th class="" style="width: 11% !important;">Trạng Thái</th>
                                <th class="pe-3" style="width: 10% !important;">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allUser as $item)
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
                                            <input class="tgl tgl-light" id="cb1-6" type="checkbox"
                                                {{ !empty($item->status) == 1 ? 'checked' : '' }} disabled />
                                            <label class="tgl-btn" for="cb1-6"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h me-2"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{{ route('user.edit', $item->code) }}?{{ request()->getQueryString() }}"
                                                        class="dropdown-item"><i class="fa fa-edit me-1"></i>Sửa</a></li>
                                                <li><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal_{{ $item->code }}"
                                                        class="dropdown-item"><i class="fa fa-trash me-1">
                                                        </i>Xóa
                                                    </a>
                                                </li>
                                            </ul>
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
            @if ($allUser->count() > 0)
                <div class="card-body py-3 d-flex justify-content-between align-items-center">
                    <div class="dropdown" id="action_delete_all">
                        <span class="btn rounded-pill btn-info btn-sm dropdown-toggle" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Chọn Thao Tác</span>
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#deleteAll">
                                    <i class="fas fa-trash me-2 text-danger"></i>Xóa</a>
                            </li>
                        </ul>
                    </div>
                    <div class="DayNganCach"></div>
                    <ul class="pagination">
                        {{ $allUser->links('pagination::bootstrap-5') }}
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
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn rounded-pill btn-sm btn-danger px-4 load_animation">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach ($allUser as $item)
        {{-- Xóa --}}
        <div class="modal fade" id="deleteModal_{{ $item->code }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('user.index') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h3 class="modal-title" id="deleteModalLabel">Xóa Người Dùng
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="user_code_delete" value="{{ $item->code }}">
                            <h4 class="text-danger text-center">Xóa Người Dùng Này?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit"
                                class="btn rounded-pill btn-sm btn-danger load_animation">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
