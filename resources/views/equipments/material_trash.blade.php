@extends('master_layout.layout')

@section('styles')
    <style>
        /* Bố cục bảng */
        .table thead th {
            text-align: center;
            vertical-align: middle;
            background-color: #28a745;
            color: #fff;
            padding: 12px;
            font-size: 14px;
        }

        .table tbody tr {
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            padding: 12px;
            font-size: 14px;
        }

        .table img {
            max-width: 50px;
            border-radius: 5px;
        }

        /* Nút hành động */
        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 4px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Modal */
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .modal-footer {
            padding: 10px;
        }

        .modal-footer button {
            border-radius: 4px;
            padding: 8px 16px;
        }

        .modal-footer .btn-twitter {
            background-color: #1da1f2;
            color: #fff;
        }

        .modal-footer .btn-twitter:hover {
            background-color: #0d95e8;
            color: #fff;
        }

        .modal-body h4 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Hiệu ứng hover cho các hàng trong bảng */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
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
                <a href="{{ route('equipments.index') }}" class="btn btn-sm btn-dark me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Vật Tư</th>
                            <th>Hình Ảnh</th>
                            <th>Tên</th>
                            <th>Nhóm</th>
                            <th>Đơn Vị Tính</th>
                            <th>Hạn Sử Dụng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllMaterialTrash as $item)
                            <tr class="text-center">
                                <td>#{{ $item->code }}</td>
                                <td><img src="{{ asset('images/equipments/' . $item->image) }}" width="50" alt="Image"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->equipmentType->name ?? 'Không có' }}</td>
                                <td>{{ $item->units->name ?? 'Không có' }}</td>
                                <td>{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') : 'Không Có' }}</td>
                                <td>
                                    <!-- Khôi phục -->
                                    <button class="btn btn-sm btn-success mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#restoreModal{{ $item->id }}">
                                        <i class="fa fa-rotate-left"></i> Khôi Phục
                                    </button>

                                    <div class="modal fade" id="restoreModal{{ $item->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="restoreModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="restoreModalLabel">Khôi Phục Vật Tư</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('equipments.restore_material', $item->code) }}" method="POST">
                                                        @csrf
                                                        <h4 class="text-success">Bạn có chắc chắn muốn khôi phục vật tư này?</h4>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-sm btn-twitter">Khôi Phục</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Xóa vĩnh viễn -->
                                    <button class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal_{{ $item->id }}">
                                        <i class="fa fa-trash"></i> Xóa Vĩnh Viễn
                                    </button>

                                    <div class="modal fade" id="deleteModal_{{ $item->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Xóa Vĩnh Viễn Vật Tư</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('equipments.delete_permanently', $item->code) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <h4 class="text-danger">Bạn có chắc chắn muốn xóa vĩnh viễn vật tư này?</h4>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                        </div>
                                                    </form>
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
@endsection

@section('scripts')
@endsection
