<div class="card-body py-1">
    <form action="{{ route('card_warehouse.search') }}" method="GET"
        class="row align-items-center d-flex justify-content-between">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="row align-items-center">
                <div class="col-5 pe-0">
                    <input type="datetime-local" name="start_date"
                        class="form-control form-control-sm border-success rounded-pill"
                        value="{{ request()->start_date ? \Carbon\Carbon::parse(request()->start_date)->format('Y-m-d\TH:i') : \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d\TH:i') }}">
                </div>
                <div class="col-2 text-center">
                    Đến
                </div>
                <div class="col-5 ps-0">
                    <input type="datetime-local" name="end_date"
                        class="form-control form-control-sm border-success rounded-pill"
                        value="{{ request()->end_date ? \Carbon\Carbon::parse(request()->end_date)->format('Y-m-d\TH:i') : \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-4 col-sm-12">
            <select name="equipment_code" class="mt-2 mb-2 form-select form-select-sm rounded-pill setupSelect2 w-100">
                <option value="">-- Chọn thiết bị --</option>
                @foreach ($equipments as $equipment)
                    <option value="{{ $equipment->code }}"
                        {{ old('equipment_code') == $equipment->code || request('equipment_code') == $equipment->code ? 'selected' : '' }}>
                        {{ $equipment->name }} - (Tồn Kho: {{ $equipment->inventories->sum('current_quantity') }}
                        {{ $equipment->units->name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="d-flex">
                <a class="btn rounded-pill btn-info btn-sm mt-2 mb-2 w-100 me-2"
                    href="{{ route('card_warehouse.index') }}"><i class="fas fa-times-circle"
                        style="margin-bottom: 2px;"></i> Bỏ
                    Lọc</a>
                <button class="btn rounded-pill btn-dark btn-sm mt-2 mb-2 w-100 load_animation" type="submit"><i
                        class="fa fa-search" style="margin-bottom: 2px;"></i>Tìm</button>
            </div>
        </div>
    </form>
</div>
