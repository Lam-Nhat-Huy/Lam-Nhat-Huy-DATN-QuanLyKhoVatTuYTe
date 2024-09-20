<div class="card-header border-0 pt-5">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhập Kho</span>
    </h3>

    <div class="card-toolbar">
        <a href="{{ route('warehouse.create_import') }}" style="font-size: 10px;" class="btn btn-sm btn-success">
            Tạo Phiếu Nhập</a>
    </div>
</div>
{{-- Bộ lọc --}}
<div class="card-body py-1">
    <form action="" class="row  align-items-center">
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
        <div class="col-2">
            <select name="stt" id="stt"
                class="mt-2 mb-2 form-select form-select-sm form-select-solid border border-success setupSelect2">
                <option value="" selected>--Theo NCC--</option>
                <option value="1" {{ request()->stt == 1 ? 'selected' : '' }}>Chưa Duyệt</option>
                <option value="2" {{ request()->stt == 2 ? 'selected' : '' }}>Đã Duyệt</option>
            </select>
        </div>
        <div class="col-2">
            <select name="ur" id="ur"
                class="mt-2 mb-2 form-select form-select-sm form-select-solid border border-success setupSelect2">
                <option value="" selected>--Theo Người Tạo--</option>
                <option value="a">A</option>
                <option value="b">B</option>
            </select>
        </div>
        <div class="col-4 pe-8">
            <div class="row">
                <div class="col-10">
                    <input type="search" name="kw" placeholder="Tìm Kiếm Mã, Số Hóa Đơn.."
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                        value="{{ request()->kw }}">
                </div>
                <div class="col-2">
                    <button class="btn btn-dark btn-sm mt-2 mb-2" type="submit">Tìm</button>
                </div>
            </div>
        </div>
    </form>
</div>
