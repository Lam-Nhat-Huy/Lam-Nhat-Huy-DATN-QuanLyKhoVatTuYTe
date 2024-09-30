@extends('master_layout.layout')

@section('styles')
    <style>
        /* Tùy chỉnh bảng */
        .table thead th {
            text-align: center;
            vertical-align: middle;
            background-color: #28a745;
            color: #fff;
            padding: 15px;
        }

        .table tbody tr {
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            padding: 15px;
        }

        .table img {
            max-width: 50px;
            border-radius: 5px;
        }

        /* Tùy chỉnh nút */
        .btn-restore {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-restore:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Tùy chỉnh modal */
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .modal-footer button {
            border-radius: 0.25rem;
            padding: 8px 16px;
        }

        /* Hiệu ứng hover cho các hàng trong bảng */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Tạo khoảng cách giữa các nút */
        .action-btns button {
            margin-right: 8px;
        }

        /* Tùy chỉnh tiêu đề thẻ */
        .card-title {
            font-size: 24px;
            font-weight: 700;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5 d-flex justify-content-between">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Thùng Rác</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.equipments_group') }}" class="btn btn-sm btn-dark me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>

        <div class="card-body py-5 me-3 col-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-white">
                            <th class="ps-4">Mã Nhóm Vật Tư</th>
                            <th class="">Tên</th>
                            <th class="">Mô Tả</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllMaterialGroupTrash as $item)
                            <tr>
                                <td>#{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="action-btns">
                                    <!-- Button Khôi Phục -->
                                    <button class="btn btn-sm btn-restore mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#restoreModal{{ $item->id }}">
                                        <i class="fa fa-rotate-left"></i> Khôi Phục
                                    </button>

                                    <!-- Modal Khôi Phục -->
                                    <div class="modal fade" id="restoreModal{{ $item->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="restoreModalLabel{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="restoreModalLabel{{ $item->id }}">Xác Nhận Khôi Phục</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class="text-success">Bạn có chắc chắn muốn khôi phục nhóm vật tư này?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <form action="{{ route('equipments.restore_material_group', $item->code) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Khôi Phục</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button Xóa Vĩnh Viễn -->
                                    <button class="btn btn-sm btn-delete mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal_{{ $item->id }}">
                                        <i class="fa fa-trash"></i> Xóa Vĩnh Viễn
                                    </button>

                                    <!-- Modal Xóa Vĩnh Viễn -->
                                    <div class="modal fade" id="deleteModal_{{ $item->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Xác Nhận Xóa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class="text-danger">Bạn có chắc chắn muốn xóa vĩnh viễn nhóm vật tư này?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <form action="{{ route('equipments.delete_permanently_group', $item->code) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
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
