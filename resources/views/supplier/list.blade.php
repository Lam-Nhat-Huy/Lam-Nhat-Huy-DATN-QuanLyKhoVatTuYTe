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
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhà Cung Cấp</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('supplier.trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Thêm Thông Báo
                    </span>
                </a>
            </div>
        </div>


        <div class="card-body py-1 me-6">
            <form action="" class="d-flex align-items-center">
                <div class="me-2 w-100">
                    <input type="search" name="kw" placeholder="Tìm Kiếm Tên Nhà Cung Cấp, Số Điện Thoại, Địa Chỉ, Email, Mã Số Thuế, Người Liên Hệ.."
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                        value="{{ request()->kw }}">
                </div>
                <div>
                    <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                </div>
            </form>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle">
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
                                            <li><a href="{{ route('supplier.edit') }}" class="dropdown-item">Sửa</a></li>
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
