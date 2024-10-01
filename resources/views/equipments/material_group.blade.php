@extends('master_layout.layout')

@section('styles')
    <style>
        /* Style for hover effect on table rows */
        .hover-table:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        /* Style for selected and active rows */
        .selected-row {
            background-color: #dfe6e9;
        }

        .active-row {
            background-color: #d1c4e9;
        }

        /* Style for modal delete confirmation */
        .modal-header {
            background-color: #e74c3c;
            color: #fff;
        }

        .modal-footer button {
            border-radius: 4px;
        }

        /* Custom pagination styles */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        /* Styling for action buttons */
        .btn-success,
        .btn-primary,
        .btn-danger {
            border-radius: 25px;
            padding: 6px 12px;
            font-size: 10px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Card title styling */
        .card-title {
            font-size: 22px;
        }

        /* Table row hover effect */
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        {{-- Header with add unit button --}}
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhóm Thiết Bị</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.equipments_group_trash') }}" class="btn btn-sm btn-danger" style="font-size: 10px;">
                    <i class="fa fa-trash me-1"></i> Thùng Rác
                </a>
                <a href="{{ route('equipments.add_equipments_group') }}" class="btn btn-sm btn-success" style="font-size: 10px;">
                    <i class="fa fa-plus"></i> Thêm Nhóm Thiết Bị
                </a>
            </div>
        </div>

        {{-- Search and filter form --}}
        <div class="card-body py-1">
            <form action="{{ route('equipments.equipments_group') }}" method="GET" class="row align-items-center g-3">
                <div class="col-md-4">
                    <input type="text" name="kw" placeholder="Tìm theo mã, tên..." 
                        class="form-control form-control-sm form-control-solid border border-success"
                        value="{{ request()->kw }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select form-select-sm form-control-solid border border-success">
                        <option value="">--Chọn Trạng Thái--</option>
                        <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-dark btn-sm" type="submit">Tìm</button>
                </div>
            </form>
        </div>

        {{-- Table content --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4 table-hover">
                    <thead>
                        <tr class="text-center bg-success">
                            <th class="ps-4">Mã Nhóm Thiết Bị</th>
                            <th class="">Tên</th>
                            <th class="">Mô Tả</th>
                            <th class="text-center" style="width: 120px;">Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($AllMaterialGroup->isEmpty())
                            @if(request()->has('kw') || request()->has('status'))
                                {{-- Thông báo không tìm thấy kết quả phù hợp --}}
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4" role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-search" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không tìm thấy kết quả phù hợp</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Vui lòng thử lại với từ khóa khác hoặc thay đổi bộ lọc tìm kiếm.
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                {{-- Thông báo khi không có dữ liệu --}}
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4" role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-clipboard-check" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin nhóm thiết bị trống</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Hiện tại chưa có nhóm thiết bị nào được tạo. Vui lòng kiểm tra lại hoặc tạo mới nhóm thiết bị để bắt đầu.
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @else
                            @foreach ($AllMaterialGroup as $item)
                                <tr class="text-center hover-table">
                                    <td>#{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description ?? 'Không có mô tả' }}</td>
                                    <td>
                                        @if ($item->status)
                                            <span class="bg-success text-white rounded" style="padding: 5px 12px; display: inline-block; min-width: 110px;">Hoạt động</span>
                                        @else
                                            <span class="bg-danger text-white rounded" style="padding: 5px 12px; display: inline-block; min-width: 110px;">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('equipments.update_equipments_group', $item->code) }}" class="btn btn-sm btn-info" style="font-size: 10px;">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal{{ $item->code }}" style="font-size: 10px;">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        

        {{-- Modal for delete confirmation --}}
        @foreach ($AllMaterialGroup as $item)
            <div class="modal fade" id="deleteConfirmModal{{ $item->code }}" tabindex="-1" aria-labelledby="deleteConfirmLabel{{ $item->code }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteConfirmLabel{{ $item->code }}">Xác Nhận Xóa Nhóm Vật Tư</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="text-danger">Bạn có chắc chắn muốn xóa nhóm vật tư này?</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form action="{{ route('equipments.delete_equipments_group', $item->code) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
@endsection
