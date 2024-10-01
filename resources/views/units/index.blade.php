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

        .form-control:focus {
            border-color: #6c757d;
        }

        /* Styling for action buttons */
        .btn-success, .btn-primary, .btn-danger {
            border-radius: 25px;
            padding: 6px 12px;
            font-size: 14px;
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
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Đơn Vị</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('units.create') }}" class="btn btn-sm btn-success" style="font-size: 10px;">
                    <i class="fa fa-plus"></i> Thêm Đơn Vị
                </a>
            </div>
        </div>

        {{-- Search bar --}}
        <div class="card-body py-1 me-6">
            <form action="{{ route('units.index') }}" class="row align-items-center">
                <div class="col-4">
                    <input type="search" name="kw" placeholder="Tìm Kiếm Theo Mã, Tên.." class="form-control form-control-sm form-control-solid border-success" value="{{ request()->kw }}">
                </div>
                <div class="col-4">
                    <button class="btn btn-dark btn-sm" type="submit">Tìm</button>
                </div>
            </form>
        </div>

        {{-- Table for displaying units --}}
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4 table-hover">
                    <thead>
                        <tr class="text-center bg-success">
                            <th class="ps-4">Mã Đơn Vị</th>
                            <th>Tên Đơn Vị</th>
                            <th>Mô Tả</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($allUnits->isEmpty())
                            @if (request()->has('kw'))
                                {{-- Thông báo khi không tìm thấy kết quả tìm kiếm --}}
                                <tr>
                                    <td colspan="4" class="text-center">
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
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4" role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                            <div class="mb-3">
                                                <i class="fas fa-clipboard-check" style="font-size: 36px; color: #6c757d;"></i>
                                            </div>
                                            <div class="text-center">
                                                <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin đơn vị trống</h5>
                                                <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                    Hiện tại chưa có đơn vị nào được tạo. Vui lòng kiểm tra lại hoặc tạo mới đơn vị để bắt đầu.
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @else
                            @foreach ($allUnits as $unit)
                                <tr class="text-center hover-table">
                                    <td>{{ $unit->code }}</td>
                                    <td>{{ $unit->name }}</td>
                                    <td>{{ $unit->description ?? 'Không có mô tả' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('units.edit', $unit->code) }}" class="btn btn-sm btn-info" style="font-size: 10px;">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal{{ $unit->code }}" style="font-size: 10px;">
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

            {{-- Pagination --}}
            <div class="pagination-container">
                {{ $allUnits->links() }}
            </div>
        </div>
    </div>

    {{-- Modal for delete confirmation --}}
    @foreach ($allUnits as $unit)
        <div class="modal fade" id="deleteConfirmModal{{ $unit->code }}" tabindex="-1" aria-labelledby="deleteConfirmLabel{{ $unit->code }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteConfirmLabel{{ $unit->code }}">Xác Nhận Xóa Đơn Vị</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">Bạn có chắc chắn muốn xóa đơn vị này?</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form action="{{ route('units.destroy', $unit->code) }}" method="POST">
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
@endsection

@section('scripts')
@endsection
