<div class="card-header border-0 pt-5">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Kiểm Kho</span>
    </h3>
    <div class="card-toolbar">
        <a href="{{ route('check_warehouse.create') }}" class="btn btn-sm rounded-pill"
            style="background: linear-gradient(45deg, #4caf50, #81c784); color: white; border: none; transition: background 0.3s;"
            onmouseover="this.style.background='linear-gradient(45deg, #388e3c, #66bb6a)';"
            onmouseout="this.style.background='linear-gradient(45deg, #4caf50, #81c784)';">
            Kiểm Kho
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
                        class="form-control form-control-sm border-success rounded-pill"
                        value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                </div>
                <div class="col-2 text-center">Đến</div>
                <div class="col-5 ps-0">
                    <input type="date" name="end_date"
                        class="form-control form-control-sm border-success rounded-pill"
                        value="{{ \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}">
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <select name="status" id="status"
                class="form-select form-select-sm border-success setupSelect2 rounded-pill">
                <option value="" selected>--Theo Trạng Thái--</option>
                <option value="0">Chưa duyệt</option>
                <option value="1">Đã duyệt</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="user_code" id="user_code"
                class="form-select form-select-sm border-success setupSelect2 rounded-pill">
                <option value="" selected>--Theo Người Tạo--</option>
                @foreach ($users as $user)
                    <option value="{{ $user->code }}">{{ $user->last_name }} {{ $user->first_name }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4">
            <div class="input-group">
                <input type="search" id="search" name="search" placeholder="Tìm Kiếm Mã Kiểm Kho"
                    class="form-control form-control-sm border-success rounded-pill">
            </div>
        </div>

        <div id="searchResults"></div>
    </form>

</div>
