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
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Tồn Kho</span>
            </h3>
        </div>

        <div class="card-body py-1">
            <form action="" class="row align-items-center">
                <div class="col-4">
                    <div class="row align-items-center">
                        <div class="col-5 pe-0">
                            <input type="date"
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
                        </div>
                        <div class="col-2 text-center">
                            Đến
                        </div>
                        <div class="col-5 ps-0">
                            <input type="date"
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <select name="ur" id="ur"
                        class="mt-2 mb-2 form-select form-select-sm border border-success setupSelect2">
                        <option value="" selected>--Theo Nhóm Sản Phẩm--</option>
                        @forelse ($equipments as $equipment)
                        <option value="{{$equipment->equipmentType->code}}">{{$equipment->equipmentType->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4 pe-8">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã Phiếu Xuất.."
                                class="mt-2 mb-2 form-control bg-white form-control-sm form-control-solid border border-success"
                                value="{{ request()->kw }}">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr class="fw-bolder bg-success text-white" style="background-color: #28a745;">
                            <th class="ps-4" style="width: 5%;">
                                <input type="checkbox" id="selectAll" />
                            </th>
                            <th class="ps-4">Tên sản phẩm</th>
                            <th>Nhóm sản phẩm</th>
                            <th>Tổng tồn</th>
                            <th class="pe-3">Đơn vị tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipments as $equipment)
                            <tr class="hover-table" style="cursor: pointer;" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $equipment->code }}" aria-expanded="false">
                                <td>
                                    <input type="checkbox" class="row-checkbox" />
                                </td>
                                <td>{{ $equipment->name }}</td>
                                <td>{{ $equipment->equipmentType->name }}</td>
                                <td>{{ $inventories[$equipment->code]['total_quantity'] ?? 0 }}</td>
                                <td>{{ $equipment->units->name }}</td>
                            </tr>
                            <tr class="collapse multi-collapse" id="collapse{{ $equipment->code }}">
                                <td colspan="6" class="p-0"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa;">
                                    <div class="card card-flush p-2" style="border: none; margin: 0;">
                                        <div class="card-body p-2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover">
                                                    <thead class="fw-bolder bg-danger text-white">
                                                        <tr>
                                                            <th class="ps-4">STT</th>
                                                            <th>Số lô</th>
                                                            <th>Số lượng</th>
                                                            <th>Ngày sản xuất</th>
                                                            <th>Hạn sử dụng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="modalItemsTableBody">
                                                        @foreach ($inventories[$equipment->code]['inventories'] as $index => $inventory)
                                                            <tr class="text-center">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $inventory->batch_number }}</td>
                                                                <td>{{ $inventory->current_quantity }}</td>
                                                                <td>{{ $inventory->manufacture_date }}</td>
                                                                <td>{{ $inventory->expiry_date }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không có thiết bị nào.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/warehouse/export.js') }}"></script>
@endsection
