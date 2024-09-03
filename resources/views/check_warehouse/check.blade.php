@extends('master_layout.layout')

@section('styles')
<style>
    .autocomplete-items {
        position: absolute;
        border: 1px solid #ced4da;
        background-color: #ffffff;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 0.375rem;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        font-size: 14px;
        background-color: #ffffff;
        border-bottom: 1px solid #f1f3f5;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .autocomplete-items div:hover {
        background-color: #5b6a7b;
        color: #ffffff;
    }

    .autocomplete-items .autocomplete-active {
        background-color: #5b6a7b;
        color: #ffffff;
    }

    .card-toolbar {
        display: flex;
        gap: 0.75rem; /* Increase gap between buttons */
        flex-wrap: wrap; /* Allow buttons to wrap if there's not enough space */
        align-items: center; /* Align items vertically */
        justify-content: flex-end; /* Align buttons to the right */
    }

    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center; /* Center the text and icon */
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 400;
        white-space: nowrap;
        border: 1px solid transparent;
        border-radius: 0.375rem;
        transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        text-decoration: none;
    }

    .btn-custom .fa {
        margin-right: 0.5rem;
    }

    .table {
        table-layout: fixed;
        width: 100%;
    }

    .table td, .table th {
        vertical-align: middle;
        white-space: normal; /* Allow text to wrap */
        text-overflow: unset; /* Remove ellipsis */
        overflow: hidden;
    }

    .table-responsive {
        overflow: hidden; /* Prevent horizontal scrolling */
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        flex: 1;
    }

    .card-toolbar .btn {
        margin: 0;
    }

    .card-toolbar .btn:not(:last-child) {
        margin-right: 0.75rem; /* Add space between buttons */
    }

    .text-center {
        display: flex;
        justify-content: center; /* Center the buttons horizontally */
        gap: 0.5rem; /* Adjust the space between buttons if needed */
    }

    .action-buttons {
        display: flex;
        justify-content: center; /* Center the buttons horizontally */
        gap: 0.5rem; /* Adjust the space between buttons if needed */
    }
</style>
@endsection

@section('title')
    Kiểm Kho
@endsection

@section('content')
    <h1>Trang Kiểm Kho</h1>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Kiểm Kho</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('check_warehouse.create') }}" class="btn btn-sm btn-success btn-custom">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Tạo Phiếu Kiểm Kho
                    </span>
                </a>
                <a href="#" class="btn btn-sm btn-dark btn-custom">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-download me-1"></i>
                        Xuất File
                    </span>
                </a>
            </div>
        </div>

        <div class="card-body py-5 px-lg-17">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Kiểm Kho</th>
                            <th>Thời Gian</th>
                            <th>Ngày Cân Bằng</th>
                            <th>SL Thực Tế</th>
                            <th>Tổng Thực Tế</th>
                            <th>Tổng Chênh Lệch</th>
                            <th>SL Lệch Tăng</th>
                            <th>SL Lệch Giảm</th>
                            <th>Ghi Chú</th>
                            <th class="pe-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventoryChecks as $check)
                            <tr>
                                <td>{{ $check['code'] }}</td>
                                <td>{{ $check['time'] }}</td>
                                <td>{{ $check['balance_date'] }}</td>
                                <td>{{ $check['actual_quantity'] }}</td>
                                <td>{{ number_format($check['total_actual'], 0, ',', '.') }}</td>
                                <td>{{ number_format($check['total_difference'], 0, ',', '.') }}</td>
                                <td>{{ number_format($check['increased_difference'], 0, ',', '.') }}</td>
                                <td>{{ number_format($check['decreased_difference'], 0, ',', '.') }}</td>
                                <td>{{ $check['note'] }}</td>
                                <td >
                                    <a href="#" class=" btn-sm btn-success">
                                        <i class="fa fa-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Không có phiếu kiểm kho nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include any JavaScript you need here -->
@endsection
