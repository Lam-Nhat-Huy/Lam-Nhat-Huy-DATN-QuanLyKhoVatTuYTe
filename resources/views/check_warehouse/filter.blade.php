<div class="card-header border-0 pt-5">
    <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Kiểm Kho</span>
    </h3>
    <div class="card-toolbar">
        @if (session('isAdmin') == 1)
            <div class="checkbox-wrapper-6 d-flex me-2 btn btn-sm btn-dark rounded-pill">
                <span class="me-3 fw-bolder">Khóa Kho</span>
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
