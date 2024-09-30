@extends('master_layout.layout')

@section('styles')
    <style>
        /* Style for hover effect on table rows */
        .hover-table:hover {
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        /* Style for buttons in action column */
        .btn-group button {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .pagination .page-link {
            border-radius: 50%;
            color: #6c757d;
        }

        .pagination .page-link:hover {
            background-color: #1fb948;
            color: white;
        }

        .pagination .active .page-link {
            background-color: #1fb948;
            color: white;
        }

        /* Style for the search input */
        .form-control {
            border: 2px solid #1fb948;
            padding: 8px;
            border-radius: 8px;
            transition: border-color 0.3s ease;
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

        .card-header {
            background-color: #1fb948;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .card-title {
            font-size: 22px;
        }

        /* Table header styling */
        .table thead th {
            background-color: #1fb948;
            color: white;
            border-bottom: none;
            padding: 15px;
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
    <div class="card shadow-sm mb-5">
        {{-- Header with add unit button --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-toolbar">
                <a href="{{ route('units.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Thêm Đơn Vị
                </a>
            </div>
        </div>

        {{-- Search bar --}}
        <div class="card-body py-1 me-6">
            <form action="{{ route('units.index') }}" class="row align-items-center">
                <div class="col-6 col-md-4">
                    <input type="search" name="kw" placeholder="Tìm Kiếm Theo Mã, Tên.." class="form-control" value="{{ request()->kw }}">
                </div>
                <div class="col-4">
                    <button class="btn btn-dark btn-sm" type="submit">Tìm</button>
                </div>
            </form>
        </div>

        {{-- Table for displaying units --}}
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder">
                            <th class="ps-4">Mã Đơn Vị</th>
                            <th>Tên Đơn Vị</th>
                            <th>Mô Tả</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allUnits as $unit)
                            <tr class="text-center hover-table">
                                <td>{{ $unit->code }}</td>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->description ?? 'Không có mô tả' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('units.edit', $unit->code) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmModal{{ $unit->code }}">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
                    <div class="modal-header">
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
