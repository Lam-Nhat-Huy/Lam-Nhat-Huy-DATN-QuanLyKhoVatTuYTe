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
                        @for ($i = 0; $i < 3; $i++)
                            <tr class="text-center hover-table">
                                <td><input type="checkbox" class="row-checkbox" /></td>
                                <td>Công Ty Dược Phẩm TP.HCM</td>
                                <td>0209194501</td>
                                <td>TP - Hồ Chí Minh</td>
                                <td>duochcm@gmail.com</td>
                                <td>19051969</td>
                                <td>Bác Sỹ Huy</td>
                                <td>
                                    <button class="btn btn-sm btn-success mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#restoreModal"><i
                                            class="fa fa-rotate-left"></i>Khôi Phục</button>

                                    <div class="modal fade" id="restoreModal" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="restoreModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="restoreModalLabel">Khôi Phục Nhà Cung Cấp
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-success">Khôi Phục Nhà Cung Cấp Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-twitter">Khôi Phục</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal_"><i
                                            class="fa fa-trash"></i>Xóa Vĩnh Viễn</button>

                                    <div class="modal fade" id="deleteModal_" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Vĩnh Viễn Nhà Cung Cấp
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Xóa Vĩnh Viễn Nhà Cung Cấp Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-twitter">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
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
