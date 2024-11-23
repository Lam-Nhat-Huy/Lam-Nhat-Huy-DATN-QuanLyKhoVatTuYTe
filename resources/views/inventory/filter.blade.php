<div class="card-body py-1">
    <form action="" class="row align-items-center">
        <div class="col-lg-2 col-md-4 col-sm-12 pe-0">
            <select name="category" id="category"
                class="mt-2 mb-2 form-select form-select-sm border border-success setupSelect2 rounded-pill">
                <option value="" selected>--Theo Nhóm--</option>
                @forelse ($equipmentType as $equipment)
                    <option value="{{ $equipment->code }}"
                        {{ request('category') == $equipment->code ? 'selected' : '' }}>
                        {{ $equipment->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-12 pe-0">
            <select class="mt-2 mb-2 form-select form-select-sm border border-success setupSelect2 rounded-pill"
                name="quantity">
                <option value="" selected>--Theo Số Lượng--</option>
                <option value="enough" {{ request('quantity') === 'enough' ? 'selected' : '' }}>Còn hàng</option>
                <option value="low" {{ request('quantity') === 'low' ? 'selected' : '' }}>Sắp hết</option>
                <option value="out_stock" {{ request('quantity') === 'out_stock' ? 'selected' : '' }}>Hết hàng</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-12 pe-0">
            <select class="mt-2 mb-2 form-select form-select-sm border border-success setupSelect2 rounded-pill"
                name="unit">
                <option value="" selected>--Theo Đơn Vị--</option>
                @forelse ($units as $unit)
                    <option value="{{ $unit->code }}" {{ request('unit') == $unit->code ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 pe-0">
            <input type="text" id="search" name="search" autocapitalize="off" style="text-transform: none;"
                placeholder="Tìm kiếm.." value="{{ request('search') }}"
                class="mt-2 mb-2 form-control bg-white form-control-sm form-control-solid border border-success rounded-pill">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="d-flex">
                <a class="btn rounded-pill btn-info btn-sm mt-2 mb-2 w-100 me-2"
                    href="{{ route('inventory.index') }}"><i class="fas fa-times-circle"
                        style="margin-bottom: 2px;"></i> Bỏ
                    Lọc</a>
                <button class="btn rounded-pill btn-dark btn-sm mt-2 mb-2 w-100 load_animation" type="submit"><i
                        class="fa fa-search" style="margin-bottom: 2px;"></i>Tìm</button>
            </div>
        </div>
    </form>
</div>
