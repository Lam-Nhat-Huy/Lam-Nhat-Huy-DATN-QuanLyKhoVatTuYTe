{{-- Bộ lọc của Zy --}}
<div class="card-body py-1">
    <form action="{{ route('warehouse.export') }}" class="row align-items-center">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-5 col-sm-5 pe-0">
                    <input type="date" name="start_date"
                        class="form-control form-control-sm border-success rounded-pill"
                        value="{{ request('start_date', \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d')) }}">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 text-center"><span>-</span></div>
                <div class="col-lg-5 col-md-5 col-sm-5 ps-0">
                    <input type="date" name="end_date"
                        class="form-control form-control-sm border-success rounded-pill"
                        value="{{ request('end_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="spl" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                <option value="" selected>--Theo Nhà Cung Cấp--</option>
                @foreach ($allSupplier as $supplier)
                    <option value="{{ $supplier->code }}" {{ request()->spl == $supplier->code ? 'selected' : '' }}>
                        {{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="dpm" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                <option value="" selected>--Theo Phòng Ban--</option>
                @foreach ($allDepartment as $department)
                    <option value="{{ $department->code }}" {{ request()->dpm == $department->code ? 'selected' : '' }}>
                        {{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="rs" id="rs"
                class="form-select form-select-sm border border-success setupSelect2 rounded-pill">
                <option value="" {{ request()->rs == '' ? 'selected' : '' }}>--Theo Lý Do Hủy--</option>
                <option value="Hư Hỏng" {{ request()->rs == 'Hư Hỏng' ? 'selected' : '' }}>Hư Hỏng</option>
                <option value="Hết Hạn Sử Dụng" {{ request()->rs == 'Hết Hạn Sử Dụng' ? 'selected' : '' }}>Hết Hạn Sử
                    Dụng</option>
                <option value="Lỗi Sản Xuất" {{ request()->rs == 'Lỗi Sản Xuất' ? 'selected' : '' }}>Lỗi Sản Xuất
                </option>
                <option value="Thừa Hoặc Không Cần Thiết"
                    {{ request()->rs == 'Thừa Hoặc Không Cần Thiết' ? 'selected' : '' }}>Thừa Hoặc Không Cần Thiết
                </option>
                <option value="Hàng Bị Trả Về" {{ request()->rs == 'Hàng Bị Trả Về' ? 'selected' : '' }}>Hàng Bị Trả Về
                </option>
                <option value="Lỗi Kỹ Thuật" {{ request()->rs == 'Lỗi Kỹ Thuật' ? 'selected' : '' }}>Lỗi Kỹ Thuật
                </option>
                <option value="Quyết Định Tiêu Hủy" {{ request()->rs == 'Quyết Định Tiêu Hủy' ? 'selected' : '' }}>
                    Quyết Định Tiêu Hủy</option>
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="us" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                <option value="" selected>--Theo Người Tạo--</option>
                @foreach ($users as $user)
                    <option value="{{ $user->code }}" {{ request()->us == $user->code ? 'selected' : '' }}>
                        {{ $user->last_name . ' ' . $user->first_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="stt" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                <option value="" {{ request()->stt == '' ? 'selected' : '' }}>--Theo Trạng Thái--</option>
                <option value="0" {{ request()->stt == '0' ? 'selected' : '' }}>Chờ Duyệt</option>
                <option value="1" {{ request()->stt == '1' ? 'selected' : '' }}>Đã Duyệt</option>
                <option value="2" {{ request()->stt == '2' ? 'selected' : '' }}>Bị Từ Chối</option>
                <option value="3" {{ request()->stt == '3' ? 'selected' : '' }}>Lưu Tạm</option>
            </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="ept" id="ept"
                class="form-select form-select-sm border border-success setupSelect2 rounded-pill">
                <option value="" {{ request()->ept == '' ? 'selected' : '' }}>--Theo Loại Xuất--</option>
                <option value="Xuất Sử Dụng" {{ request()->ept == 'Xuất Sử Dụng' ? 'selected' : '' }}>
                    Xuất Sử Dụng</option>
                <option value="Xuất Trả" {{ request()->ept == 'Xuất Trả' ? 'selected' : '' }}>
                    Xuất Trả</option>
                <option value="Xuất Hủy" {{ request()->ept == 'Xuất Hủy' ? 'selected' : '' }}>
                    Xuất Hủy</option>
            </select>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <input type="search" name="kw" placeholder="Tìm kiếm mã phiếu xuất.."
                        class="mt-2 mb-2 form-control form-control-sm rounded-pill border border-success w-100"
                        value="{{ request()->kw }}">
                </div>
                <div class="col-md-6 d-flex">
                    <a class="btn rounded-pill btn-info btn-sm mt-2 mb-2 w-100 me-2"
                        href="{{ route('warehouse.export') }}"><i class="fas fa-times-circle"
                            style="margin-bottom: 2px;"></i> Bỏ
                        Lọc</a>
                    <button class="btn rounded-pill btn-dark btn-sm mt-2 mb-2 w-100 load_animation" type="submit"><i
                            class="fa fa-search" style="margin-bottom: 2px;"></i>Tìm</button>
                </div>
            </div>
        </div>
    </form>
</div>
