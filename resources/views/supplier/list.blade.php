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

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-start">
            <h3 class="card-title fw-bolder fs-3">Danh Nhà Cung Cấp</h3>
            <a href="{{ route('supplier.create') }}" class="btn btn-success">Thêm</a>
        </div>

        <div class="card-body py-1">
            <form class="row align-items-center">
                <div class="col-3">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <i class="fa fa-search"></i>
                        </span>
                        <input type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-15" placeholder="Tìm kiếm" />
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <select name="ur" id="ur"
                        class="form-select form-select-sm form-select-solid border border-success me-2">
                        <option value="" selected>--Người liên hệ--</option>
                        <option value="1">Bác sỹ Huy</option>
                        <option value="2">Bác Sỹ Zách</option>
                    </select>
                    <button class="btn btn-dark btn-sm" type="submit">Tìm</button>
                </div>
            </form>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="fw-bolder bg-success">
                        <tr>
                            <th class="ps-4"><input type="checkbox" id="selectAll" /></th>
                            <th class="ps-4">Tên Nhà cung cấp</th>
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
                            <tr class="text-center hover-table">
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
                                            <li><a href="{{ route('supplier.create') }}" class="dropdown-item">Sửa</a></li>
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_delete"
                                                    class="dropdown-item">Xóa</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="kt_modal_delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h2 class="fw-bolder">Bạn có chắc chắn muốn xóa không?</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </form>
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
    </script>
@endsection
