<div class="card-header border-0 pt-5">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Kiểm Kho</span>
    </h3>
    <div class="card-toolbar">
        @if (session('isAdmin') == 1)
            <div class="checkbox-wrapper-6 d-flex me-2 btn btn-sm btn-dark rounded-pill">
                <span class="me-3 fw-bolder text-uppercase">Khóa Kho</span>
                <input class="tgl tgl-light" id="lock_warehouse" type="checkbox" value="1" name="lock_warehouse"
                    {{ !empty($checkLockWarehouse) && $checkLockWarehouse == 1 ? 'checked' : '' }} />
                <label class="tgl-btn" for="lock_warehouse"></label>
            </div>
        @endif
        <a href="{{ route('check_warehouse.create') }}" class="btn btn-success btn-sm rounded-pill">
            <i class="fa fa-plus me-1" style="margin-bottom: 2px;"></i>Tạo Phiếu
        </a>
    </div>
</div>

<style>
    .checkbox-wrapper-6 .tgl+.tgl-btn {
        width: 30px !important;
        height: 18px !important;
    }
</style>

{{-- Bộ lọc --}}
<div class="card-body py-1">
    <form method="GET" class="row g-3 align-items-center">
        <!-- Bộ lọc thời gian -->
        <div class="col-lg-3 col-md-4 col-sm-12">
        <div class="row align-items-center">
                <div class="col-5 pe-0">
                    <input type="date" name="startDate" class="form-control form-control-sm border-success rounded-pill"
                        value="{{ request()->input('startDate', optional($minCreatedAt)->format('Y-m-d')) }}">
                </div>
                <div class="col-2 text-center">Đến</div>
                <div class="col-5 ps-0">
                    <input type="date" name="endDate" class="form-control form-control-sm border-success rounded-pill"
                        value="{{ request()->input('endDate', optional($maxCreatedAt)->format('Y-m-d')) }}">
                </div>
            </div>
        </div>

        <!-- Bộ lọc người tạo -->
        <div class="col-lg-2 col-md-4 col-sm-12">
            <select name="us" class="form-select form-select-sm border-success setupSelect2 rounded-pill">
                <option value="" selected>--Người Tạo--</option>
                @foreach ($users as $user)
                    <option value="{{ $user->code }}" {{ request()->us == $user->code ? 'selected' : '' }}>
                        {{ $user->last_name }} {{ $user->first_name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Bộ lọc người kiểm lại -->
        <div class="col-lg-2 col-md-4 col-sm-12">
            <select name="recheck_us" class="form-select form-select-sm border-success setupSelect2 rounded-pill">
                <option value="" selected>--Người Kiểm Lại--</option>
                @foreach ($users as $user)
                    <option value="{{ $user->code }}" {{ request()->recheck_us == $user->code ? 'selected' : '' }}>
                        {{ $user->last_name }} {{ $user->first_name }}
                    </option>
                @endforeach
            </select>
        </div>


        <!-- Tìm kiếm mã kiểm kho -->
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6 pe-0">
                    <input type="search" name="kw" placeholder="Tìm kiếm mã phiếu kiểm.."
                        class="form-control form-control-sm rounded-pill border border-success w-100"
                        value="{{ request()->kw }}">
                </div>
                <div class="col-md-6 d-flex">
                    <a class="btn rounded-pill btn-info btn-sm w-100 me-2"
                        href="{{ route('check_warehouse.index') }}">
                        <i class="fas fa-times-circle"></i> Bỏ Lọc
                    </a>
                    <button class="btn rounded-pill btn-dark btn-sm w-100" type="submit">
                        <i class="fa fa-search"></i> Tìm
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    document.getElementById('lock_warehouse').addEventListener('change', function(event) {
        event.preventDefault();

        document.getElementById('loading').style.display = 'block';
        document.getElementById('loading-overlay').style.display = 'block';
        this.disabled = true;

        setTimeout(() => {
            const lock_warehouse = document.getElementById('lock_warehouse').checked ? 1 : 2;

            let formData = new FormData();
            formData.append('lock_warehouse', lock_warehouse);

            fetch('{{ route('check_warehouse.createNotification') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                    }
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('loading-overlay').style.display = 'none';
                    this.disabled = false;
                });
        }, 500);
    });
</script>
