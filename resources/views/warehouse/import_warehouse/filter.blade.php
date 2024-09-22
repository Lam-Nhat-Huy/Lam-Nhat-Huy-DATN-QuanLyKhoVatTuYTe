<div class="card-header border-0 pt-5">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhập Kho</span>
    </h3>
    <div class="card-toolbar">
        <a href="{{ route('warehouse.create_import') }}" class="btn btn-sm btn-success" style="font-size: 12px;">
            <i class="fas fa-plus"></i> Tạo Phiếu Nhập
        </a>
    </div>
</div>

{{-- Bộ lọc --}}
<div class="card-body py-1">
    <form id="filterForm" class="row g-3 align-items-center">
        <div class="col-md-4">
            <div class="row align-items-center">
                <div class="col-5 pe-0">
                    <input type="date" name="start_date"
                        class="form-control form-control-sm form-control-solid border-success"
                        value="{{ \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
                </div>
                <div class="col-2 text-center">Đến</div>
                <div class="col-5 ps-0">
                    <input type="date" name="end_date"
                        class="form-control form-control-sm form-control-solid border-success"
                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <select name="supplier_code" id="supplier_code" class="form-select form-select-sm border-success">
                <option value="" selected>--Theo NCC--</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->code }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="created_by" id="created_by" class="form-select form-select-sm border-success">
                <option value="" selected>--Theo Người Tạo--</option>
                @foreach ($users as $user)
                    <option value="{{ $user->code }}">{{ $user->last_name }} {{ $user->first_name }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4">
            <div class="input-group">
                <input type="search" id="search" name="search" placeholder="Tìm Kiếm Mã, Số Hóa Đơn.."
                    class="form-control form-control-sm form-control-solid border-success">
            </div>
        </div>

        <div id="searchResults"></div>
    </form>

</div>
