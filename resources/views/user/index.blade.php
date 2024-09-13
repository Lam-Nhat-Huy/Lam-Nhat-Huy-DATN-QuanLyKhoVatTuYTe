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
    </script>
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Người Dùng</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('user.user_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('user.add') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Thêm Người Dùng
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 me-6">
            <form action="" class="row align-items-center">
                <div class="col-4">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Vai Trò--</option>
                        <option value="">Admin</option>
                        <option value="">Nhân Viên</option>
                    </select>
                </div>
                <div class="col-4">
                    <select name="stt" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Trạng Thái--</option>
                        <option value="1" {{ request()->stt == 1 ? 'selected' : '' }}>Không</option>
                        <option value="2" {{ request()->stt == 2 ? 'selected' : '' }}>Có</option>
                    </select>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã, Tên, Email Người Dùng.."
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
                            <th class="" style="width: 20% !important;">Mã Người Dùng</th>
                            <th class="" style="width: 25% !important;">Email</th>
                            <th class="" style="width: 25% !important;">Số Điện Thoại</th>
                            <th class="" style="width: 15% !important;">Trạng Thái</th>
                            <th class="pe-3" style="width: 15% !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i <= 2; $i++)
                            <tr class="text-center hover-table pointer">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>
                                    #ND007
                                </td>
                                <td>
                                    lphdev04@gmail.com
                                </td>
                                <td>
                                    0945567048
                                </td>
                                <td>
                                    @if ($i > 2)
                                        <div class="rounded px-2 py-1 text-white bg-danger">Không</div>
                                    @else
                                        <div class="rounded px-2 py-1 text-white bg-success">Có</div>
                                    @endif
                                </td>
                                <td class="text-center" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $i }}" id="toggleIcon{{ $i }}">
                                    <i class="fa fa-chevron-right pointer">
                                    </i>
                                </td>
                            </tr>

                            <tr class="collapse multi-collapse" id="collapse{{ $i }}">
                                <td class="p-0" colspan="12"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid border-2 border-lg-1">
                                        <div class="card card-flush p-2"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h4 class="fw-bold m-0">Thông Tin Nhân Viên</h4>
                                                <div class="card-toolbar">
                                                    @if ($i > 1)
                                                        <div class="rounded px-2 py-1 text-white bg-danger">
                                                            Nhân Viên Kho
                                                        </div>
                                                    @else
                                                        <div class="rounded px-2 py-1 text-white bg-success">
                                                            Nhân Viên Mua Hàng
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body p-2" style="padding-top: 0px !important">
                                                <div class="row py-5" style="padding-top: 0px !important">
                                                    <!-- Begin::Receipt Info (Left column) -->
                                                    <div class="col-2">
                                                        <img src="https://i.pinimg.com/736x/64/30/1c/64301c42f058143fbc4a313e05aa0bbe.jpg"
                                                            width="100%" alt="">
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="row px-3">
                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <strong>Họ:</strong> Lữ
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <strong>Tên:</strong> Phát Huy
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <strong>Giới Tính:</strong> Nam
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <strong>Ngày Sinh:</strong> 12-12-2004
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="mb-3">
                                                                    <strong>Địa Chỉ:</strong> Lê Bình, Cái Răng, Cần Thơ
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nút hành động đưa xuống dưới -->
                                    <div class="text-end my-4">
                                        <div class="button-group">
                                            <!-- Nút Cập nhật -->
                                            <a class="btn btn-sm btn-success me-2" href="{{ route('user.edit') }}"><i
                                                    class="fa fa-edit"></i>Sửa</a>
                                            <!-- Nút Xóa đơn -->
                                            <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal_{{ $i }}"><i
                                                    class="fa fa-trash"></i>Xóa</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            {{-- Xóa --}}
                            <div class="modal fade" id="deleteModal_{{ $i }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="deleteModalLabel">Xóa Người Dùng
                                            </h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="">
                                                @csrf
                                                <h4 class="text-danger text-center">Xóa Người Dùng Này?</h4>
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
        <div class="card-body py-3">
            <div class="dropdown">
                <span class="btn btn-info btn-sm dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span>Chọn Thao Tác</span>
                </span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item pointer" data-bs-toggle="modal" data-bs-target="#deleteAll">
                            <i class="fas fa-trash me-2 text-danger"></i>Xóa Tất Cả</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

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
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa tất cả người dùng đã chọn?</p>
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
