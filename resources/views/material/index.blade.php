@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table:hover {
            background: #ccc;
        }

        .btn-group button {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        {{-- Phần nút thêm vật tư  --}}
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Vật Tư</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('material.material_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('material.insert_material') }}" class="btn btn-sm btn-success">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus"></i>
                        Thêm Vật Tư
                    </span>
                </a>
            </div>
        </div>

        {{-- Bộ lọc vật tư  --}}
        <div class="card-body py-1 me-6">
            <form action="" class="row align-items-center">

                <div class="col-4">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Nhóm Vật Tư--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>

                <div class="col-4">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Đơn Vị Tính--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>

                <div class="col-4">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Theo Mã, Tên.."
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




        {{-- Danh sách vật tư   --}}
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <!-- Trong phần <thead> của bảng -->
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-4">Mã Vật Tư</th>
                            <th class="">Hình Ảnh</th>
                            <th class="">Nhóm Vật Tư</th>
                            <th class="">Đơn Vị Tính</th>
                            <th class="">Mã Vạch</th>
                            <th class="">Hạn sử dụng</th>
                            <th class="">Trạng Thái</th>
                        </tr>
                    </thead>

                    <!-- Trong phần <tbody> của bảng -->
                    <tbody>
                        @foreach ($AllMaterial as $item)
                            <tr class="text-center hover-table" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $item['id'] }}" aria-expanded="false"
                                aria-controls="collapse{{ $item['id'] }}">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>
                                    PD199001
                                </td>
                                <td>
                                    <img src="{{ $item['material_image'] }}" alt="" width="50">
                                </td>
                                <td>
                                    {{ $item['material_type_id'] }}
                                </td>
                                <td>
                                    {{ $item['unit_id'] }}
                                </td>
                                <td>
                                    <img src="https://png.pngtree.com/png-clipart/20220604/original/pngtree-barcode-image-black-png-image_7947265.png"
                                        width="80" alt="">
                                </td>
                                <td>
                                    {{ $item['expiry'] > 0 ? $item['expiry'] . ' Tháng' : 'Không Có' }}
                                </td>
                                <td>
                                    @if ($item['status'] > 2)
                                        <div class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</div>
                                    @else
                                        <div class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</div>
                                    @endif
                                </td>
                            </tr>

                            <tr class="collapse multi-collapse" id="collapse{{ $item['id'] }}">
                                <td colspan="12" style="border: 1px solid #dcdcdc; background-color: #f8f9fa;">
                                    <div class="row gy-3">
                                        <div class="col-md-4">
                                            <img src="{{ $item['material_image'] }}" alt=""
                                                class="img-fluid rounded">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card card-body border-0">
                                                <h4 class="card-title fw-bold mb-3">Chi tiết vật tư</h4>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-success">Còn hàng</span>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <td><strong>Mã vật tư:</strong></td>
                                                                    <td class="text-gray-800">HD00019</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Nhóm hàng:</strong></td>
                                                                    <td class="text-gray-800">Vật Tư Y Tế</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Thương hiệu:</strong></td>
                                                                    <td class="text-gray-800">Pharmacy</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Vị trí:</strong></td>
                                                                    <td class="text-gray-800">C123</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Ngày hết hạn:</strong></td>
                                                                    <td class="text-gray-800">25/12/2024</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <td><strong>Giá nhập:</strong></td>
                                                                    <td class="text-gray-800">25,000 VNĐ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Ghi chú:</strong></td>
                                                                    <td class="text-gray-800">Hàng dễ vỡ</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Tồn kho:</strong></td>
                                                                    <td class="text-gray-800">100</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Số lượng đã dùng:</strong></td>
                                                                    <td class="text-gray-800">50</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Tồn cuối:</strong></td>
                                                                    <td class="text-gray-800">50</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <strong>Mã vạch:</strong><br>
                                                        <img src="https://png.pngtree.com/png-clipart/20220604/original/pngtree-barcode-image-black-png-image_7947265.png"
                                                            width="80" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nút hành động đưa xuống dưới -->
                                            <div class="text-end mt-4">
                                                <div class="button-group">
                                                    <!-- Nút Cập nhật -->
                                                    <a href="#" class="btn btn-sm btn-success me-2"
                                                        data-bs-toggle="modal" data-bs-target="#browse">Cập Nhật</a>
                                                    <!-- Nút In Phiếu -->
                                                    <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                        data-bs-target="#detailsModal">In Phiếu</button>
                                                    <!-- Nút Xóa đơn -->
                                                    <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                        data-bs-target="#deleteConfirm">Xóa đơn</button>
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
    </div>

    {{-- Modal Xác Nhận Xóa --}}
    <div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa Đơn</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa đơn này?</p>
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
    </script>
@endsection
