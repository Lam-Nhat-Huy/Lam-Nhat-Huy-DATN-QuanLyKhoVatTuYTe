@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hover-table:hover {
            background-color: #e9ecef;
        }

        .collapse {
            display: none;
        }

        .collapse.show {
            display: table-row;
        }

        .collapse-content {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .detail-box {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        .detail-box h5 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 5px;
        }

        .detail-box p {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 8px;
        }

        .btn-close-detail {
            margin-top: 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }

        .btn-close-detail:hover {
            background-color: #c82333;
        }

        .card-header {
            border-bottom: 1px solid #dee2e6;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .form-control-sm {
            height: 2rem;
            padding: 0.25rem 0.5rem;
        }

        .table-search {
            width: 100%;
            margin-top: 15px;
        }

        .table-search input {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }

        .table-search input:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .loading-overlay,
        #loading {
            display: none !important;
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
                <span class="card-label fw-bolder fs-3 mb-1">Danh sách thiết bị</span>
            </h3>
        </div>

        @include('warehouse.card_warehouse.filter')

        <div class="card-body py-3">
            <div class="table-responsive rounded">
                <table class="table align-middle table-striped table-hover gs-0 gy-4"
                    style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <thead class="bg-success text-white" style="position: sticky; top: 0; z-index: 10;">
                        <tr class="fw-bolder">
                            <th class="ps-4" style="width: 15%; text-align: left;">Mã</th>
                            <th style="width: 15%; text-align: left;">Thời gian</th>
                            <th style="width: 15%; text-align: left;">Loại giao dịch</th>
                            <th style="width: 15%; text-align: left;">NCC/Phòng ban</th>
                            <th style="width: 15%; text-align: left;">Tồn đầu kì</th>
                            <th class="text-center" style="width: 10%; white-space: nowrap;">Số lượng</th>
                            <th class="text-center pe-4" style="width: 15%; white-space: nowrap;">Tồn cuối kì</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="noDataAlert">
                            <td colspan="12" class="text-center">
                                <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                    role="alert"
                                    style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                    <div class="mb-3">
                                        <i class="fas fa-clipboard-check" style="font-size: 36px; color: #6c757d;"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Thông tin thiết
                                            bị
                                            trống</h5>
                                        <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                            Hãy chọn thiết bị để xem thông tin thẻ kho.
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('loading').style.display = 'none';
        document.getElementById('loading-overlay').style.display = 'none';
        this.disabled = true;
    </script>
@endsection
