@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Tồn Kho</span>
            </h3>
        </div>

        @include('inventory.filter')

        <div class="card-body py-3">
            <div class="table-responsive rounded">
                <table class="table align-middle text-center" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr class="bg-success text-white fw-bolder">
                            <th style="width: 5%;">
                                STT
                            </th>
                            <th style="width: 10%;">Mã thiết bị</th>
                            <th style="width: 40%;" class="text-left">Tên thiết bị</th>
                            <th style="width: 20%;" class="text-left">Nhóm thiết bị</th>
                            <th style="width: 10%;">Tổng tồn</th>
                            <th style="width: 15%;">Đơn vị tính</th>
                        </tr>
                    </thead>
                    <tbody id="equipment-list">
                        @include('inventory.index')
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <div class="filter-bar">
                <ul class="nav nav-pills">
                    <li class="nav-item" style="font-size: 11px;">
                        <p class="nav-link text-white rounded-pill" style="background-color: #0064ff;">
                            Tất cả <span>({{ $totalEquipments }})</span>
                        </p>
                    </li>
                    <li class="nav-item" style="font-size: 11px;">
                        <p class="nav-link text-white rounded-pill" style="background-color: #10a100;">
                            Còn hàng <span>({{ $inStockCount }})</span>
                        </p>
                    </li>
                    <li class="nav-item" style="font-size: 11px;">
                        <p class="nav-link text-white rounded-pill" style="background-color: #dc3545;">
                            Hết hàng <span>({{ $outOfStockCount }})</span>
                        </p>
                    </li>
                    <li class="nav-item" style="font-size: 11px;">
                        <p class="nav-link text-white rounded-pill" style="background-color: #ffc107;">
                            Sắp hết hàng <span>({{ $lowStockCount }})</span>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="DayNganCach"></div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center my-3">
                <ul class="pagination pagination-sm custom-pagination">
                    {{ $equipments->links('pagination::bootstrap-5') }}
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/warehouse/export.js') }}"></script>
@endsection
