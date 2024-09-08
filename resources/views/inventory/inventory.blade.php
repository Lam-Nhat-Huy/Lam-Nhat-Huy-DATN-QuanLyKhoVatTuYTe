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
                        class="mt-2 mb-2 form-select form-select-sm form-select-solid border border-success setupSelect2">
                        <option value="" selected>--Theo Nhóm Sản Phẩm--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-4 pe-8">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã Phiếu Xuất.."
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

        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Tên sản phẩm</th>
                            <th class="">Nhóm sản phẩm</th>
                            <th class="">Nhóm thuốc</th>
                            <th class="">Tổng tồn</th>
                            <th class="pe-3">Đơn vị tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 6; $i++)
                            <tr class="text-center hover-table pointer" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $i }}" aria-expanded="false"
                                aria-controls="collapse{{ $i }}">
                                <td>Caxium (Hộp 6 vỉ x 30 viên)</td>
                                <td>Dược phẩm</td>
                                <td>Vitamin - khoáng chất</td>
                                <td>2</td>
                                <td>Hộp</td>
                            </tr>
                            <!-- Dropdown menu -->
                            <tr class="collapse multi-collapse" id="collapse{{ $i }}">
                                <td class="p-0" colspan="12"
                                    style="border: 1px solid #dcdcdc; background-color: #fafafa; padding-top: 0 !important;">
                                    <div class="flex-lg-row-fluid order-2 order-lg-1">
                                        <div class="card card-flush p-2"
                                            style="padding-top: 0px !important; padding-bottom: 0px !important;">
                                            <div class="card-header d-flex justify-content-between align-items-center p-2"
                                                style="padding-top: 0 !important; padding-bottom: 0px !important;">
                                                <h5 class="fw-bold m-0">Danh sách vật tư</h5>
                                            </div>
                                            <div class="card-body p-2" style="padding-top: 0px !important">
                                                <!-- Begin::Receipt Items (Right column) -->
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-sm table-hover">
                                                            <thead class="fw-bolder bg-success">
                                                                <tr>
                                                                    <th class="ps-4">STT</th>
                                                                    <th>Số lô</th>
                                                                    <th>Số lượng</th>
                                                                    <th>Ngày sản xuất</th>
                                                                    <th>Hạn sử dụng</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="modalItemsTableBody">
                                                                <tr class="text-center">
                                                                    <td>1</td>
                                                                    <td>C1</td>
                                                                    <td>50</td>
                                                                    <td>20-08-2024</td>
                                                                    <td>20-08-2027</td>
                                                                </tr>
                                                                <tr class="text-center">
                                                                    <td>2</td>
                                                                    <td>C2</td>
                                                                    <td>30</td>
                                                                    <td>20-08-2024</td>
                                                                    <td>20-08-2027</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- End::Receipt Items -->
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var isChecked = this.checked;
            var checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var allChecked = true;
                document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                    if (!cb.checked) {
                        allChecked = false;
                    }
                });
                document.getElementById('selectAll').checked = allChecked;
            });
        });

        document.getElementById('printPdfBtn').addEventListener('click', function() {
            var printArea = document.getElementById('printArea').innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printArea;
            window.print();
            document.body.innerHTML = originalContent;
        });

        function openEditModal(code, number, customer, date, createdBy, note) {
            document.getElementById('editExportCode').value = code;
            document.getElementById('editExportNumber').value = number;
            document.getElementById('editCustomer').value = customer;
            document.getElementById('editExportDate').value = date;
            document.getElementById('editCreatedBy').value = createdBy;
            document.getElementById('editNote').value = note;

            var editExportReceiptModal = new bootstrap.Modal(document.getElementById('editExportReceiptModal'));
            editExportReceiptModal.show();
        }
    </script>
@endsection
