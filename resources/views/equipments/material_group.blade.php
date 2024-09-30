@extends('master_layout.layout')

@section('styles')
    <style>
        /* Style for card title */
        .card-title {
            font-size: 24px;
            font-weight: bold;
        }

        /* Style for the action buttons */
        .btn-success, .btn-info, .btn-danger {
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #28a745;
        }

        .btn-info:hover {
            background-color: #17a2b8;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Style for search input */
        .form-control-solid {
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 10px;
            transition: border-color 0.3s ease;
        }

        .form-control-solid:focus {
            border-color: #1e7e34;
        }

        /* Style for table header */
        .table th {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-bottom: 2px solid #ccc;
        }

        /* Style for table rows */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #e9ecef;
        }

        /* Hover effect for table rows */
        .table-hover tbody tr:hover {
            background-color: #d4edda;
            transition: background-color 0.3s ease;
        }

        /* Style for status labels */
        .bg-success, .bg-danger {
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 15px;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        /* Modal customization */
        .modal-header {
            background-color: #dc3545;
            color: white;
        }

        .modal-footer .btn {
            border-radius: 20px;
            padding: 8px 16px;
        }

        /* Customize modal buttons */
        .btn-close {
            background-color: white;
        }

        .btn-close:hover {
            background-color: #ccc;
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .modal-footer .btn-danger {
            background-color: #c82333;
            color: white;
        }

        .modal-footer .btn-danger:hover {
            background-color: #bd2130;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card shadow-sm mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Danh Sách Nhóm Vật Tư</h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.equipments_group_trash') }}" class="btn btn-sm btn-danger me-2">
                    <i class="fa fa-trash me-1"></i> Thùng Rác
                </a>
                <a href="{{ route('equipments.add_equipments_group') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Thêm Nhóm Vật Tư
                </a>
            </div>
        </div>

        {{-- Search and filter form --}}
        <div class="card-body py-4">
            <form action="{{ route('equipments.equipments_group') }}" method="GET" class="row align-items-center">
                <div class="col-md-4 mb-2">
                    <input type="text" name="kw" placeholder="Tìm theo mã, tên..." class="form-control form-control-sm form-control-solid" value="{{ request()->kw }}">
                </div>
                <div class="col-md-4 mb-2">
                    <select name="status" class="form-select form-select-sm form-control-solid">
                        <option value="" selected>--Chọn Trạng Thái--</option>
                        <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Có</option>
                        <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Không</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-sm btn-dark">Tìm kiếm</button>
                </div>
            </form>
        </div>

        {{-- Table content --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr>
                            <th class="ps-4">Mã Nhóm Vật Tư</th>
                            <th class="">Tên</th>
                            <th class="">Mô Tả</th>
                            <th class="text-center" style="width: 120px;">Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($AllMaterialGroup->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Không tìm thấy kết quả phù hợp</td>
                            </tr>
                        @else
                            @foreach ($AllMaterialGroup as $item)
                                <tr class="text-center">
                                    <td>#{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description ?? 'Không có mô tả' }}</td>
                                    <td>
                                        @if ($item->status)
                                            <span class="rounded bg-success text-white">Có</span>
                                        @else
                                            <span class="rounded bg-danger text-white">Không</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('equipments.update_equipments_group', $item->code) }}" class="btn btn-sm btn-info me-2">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" onclick="setDeleteAction('{{ route('equipments.delete_equipments_group', $item->code) }}')">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal for delete confirmation --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmLabel">Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa nhóm vật tư này?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="document.getElementById('deleteForm').submit();">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function setDeleteAction(action) {
            document.getElementById('deleteForm').setAttribute('action', action);
        }
    </script>
@endsection
