@extends('master_layout.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <link rel="stylesheet" href="{{ asset('css/add_import.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <style>
        input[type="text"],
        select,
        textarea {
            height: 35px;
            line-height: 35px;
            width: 100%;
            box-sizing: border-box;
            margin: 0;
            padding: 0 10px;
        }

        /* Tùy chỉnh Select2 */
        .select2-container--default .select2-selection--single {
            height: 35px;
            width: 100%;
            /* Chiều cao của dropdown */
            line-height: 35px;
            /* Căn giữa nội dung */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
            /* Căn giữa văn bản */
        }

        /* Adjust the Select2 dropdown arrow */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
            /* Match the height of the select box */
            top: 50%;
            /* Vertically center the icon */
            transform: translateY(-50%);
            /* Adjust to fully center */
            right: 10px;
            /* Adjust the position from the right */
        }

        /* Adjust icon inside the arrow if necessary */
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-top: 0px;
            /* Reset any margin to align properly */
            border-width: 5px;
            /* Adjust the size of the dropdown arrow if needed */
        }
    </style>
@endsection

@section('title')
    Nhập Kho
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Nhập Kho</span>
            </h3>

            <div class="card-toolbar">
                <a href="{{ route('warehouse.import') }}" class="btn btn-sm btn-dark" style="font-size: 10px;">
                    <i class="fa fa-arrow-left me-1" style="font-size: 10px;"></i>Trở Lại
                </a>
            </div>
        </div>

        {{-- FORM 1 - Thêm vật tư --}}
        <form action="{{ route('warehouse.store_import') }}" method="post">
            @csrf
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3 mt-3">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="supplier_code" class="form-label fw-semibold"
                                        style="white-space: nowrap;">Nhà cung cấp</label>
                                    <div class="d-flex align-items-center">
                                        <select
                                            class="mySelect form-control form-control-sm form-control-solid border border-success"
                                            id="supplier_code">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->code }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="date" class="form-label fw-semibold">Ngày nhập</label>

                                    <input type="date" id="receipt_date"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        placeholder="Chọn ngày nhập">
                                </div>

                                {{-- Để dữ liệu tạm thời như vậy có đăng nhập thì đổi lại auth->id  --}}
                                <input type="hidden" id="created_by" value="U001">

                                <div class="mb-3 col-6">
                                    <label for="receipt_no" class="required form-label mb-2">Số hóa đơn</label>
                                    <input type="number"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="receipt_no" name="receipt_no" placeholder="Nhập số hóa đơn">
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="invoice_symbol" class="required form-label mb-2">Kí hiệu hóa đơn</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="invoice_symbol" name="invoice_symbol" placeholder="Nhập kí hiệu hóa đơn">
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="note" class="form-label fw-semibold">Ghi chú</label>
                                    <textarea id="note" class="form-control form-control-sm form-control-solid border border-success"
                                        placeholder="Nhập ghi chú..." rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow p-4 bg-white rounded-3">
                            <div class="row mb-3">
                                <div class="mb-4 col-6">
                                    <label for="equipment_code" class="form-label fw-semibold"
                                        style="white-space: nowrap;">Tên
                                        vật tư</label>
                                    <div class="d-flex align-items-center">
                                        <select id="equipment_code"
                                            class="form-control form-control-sm form-control-solid border border-success mySelect">
                                            @foreach ($inventories as $inventory)
                                                <option value="{{ $inventory->code ?? null }}">
                                                    {{ $inventory->name ?? null }}
                                                    ({{ $inventory->units->name ?? null }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="batch_number" class="required form-label mb-2">Số lô</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="batch_number" name="batch_number" placeholder="Nhập số lô">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="product_date" class="required form-label mb-2">Ngày sản xuất</label>
                                    <input type="date"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="product_date" name="product_date">
                                </div>

                                <div class="col-6 mb-4">
                                    <label for="expiry_date" class="form-label mb-2">Hạn sử dụng</label>
                                    <input type="date"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="expiry_date" name="expiry_date">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="price" class="required form-label mb-2">Giá nhập</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="price" name="price" placeholder="Nhập đơn giá"
                                        oninput="formatCurrency(this)">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="quantity" class="required form-label mb-2">Số lượng</label>
                                    <input type="number"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="quantity" name="quantity" placeholder="Nhập số lượng">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="discount_rate" class="required form-label mb-2">Chiết khấu (%)</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="discount_rate" name="discount_rate" placeholder="Nhập chiết khấu (%)">
                                </div>

                                <div class="col-3 mb-4">
                                    <label for="VAT" class="required form-label mb-2">VAT (%)</label>
                                    <input type="text"
                                        class="form-control form-control-sm form-control-solid border border-success"
                                        id="VAT" name="VAT" placeholder="Nhập VAT (%)">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#importExcelModal" style="font-size: 11px;">Nhập Excel</button>
                                    <button type="button" class="btn btn-sm btn-danger" style="font-size: 11px;"
                                        onclick="addMaterial()">Thêm vật tư</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="container">
            <div id="errorMessages" class="alert alert-danger alert-dismissible fade show shadow-sm rounded-lg"
                style="display: none;">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-2"></i>
                    <strong class="me-auto">Thông báo lỗi</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <hr>
                <ul id="errorList" class="list-unstyled ps-3 mb-0">
                    <!-- Error messages will appear here -->
                </ul>
            </div>
        </div>

        {{-- FORM 2 - Danh sách vật tư đã thêm --}}
        <form action="{{ route('warehouse.store_import') }}" method="post" class="mt-2">
            @csrf
            <div class="row container">
                <div class="col-9">
                    <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3 ">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="font-size: 11px;" class="ps-4">Tên vật tư</th>
                                        <th style="font-size: 11px;">Nhà cung cấp</th>
                                        <th style="font-size: 11px;">Số lượng</th>
                                        <th style="font-size: 11px;">Giá nhập</th>
                                        <th style="font-size: 11px;">Số lô</th>
                                        <th style="font-size: 11px;">Hạn dùng</th>
                                        <th style="font-size: 11px;">CK(%)</th>
                                        <th style="font-size: 11px;">VAT(%)</th>
                                        <th style="font-size: 11px;" class="pe-3">Thành tiền</th>
                                        <th style="font-size: 11px;" class="pe-3"></th>
                                    </tr>
                                </thead>
                                <tbody id="materialList">
                                    {{-- Thông tin sau khi được thêm vật tư từ FORM 1 sẽ được hiển thị ở đây --}}
                                    <input type="hidden" id="materialData" name="materialData">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-3 pe-0">
                    <div class="card border-0 shadow p-4 mb-4 bg-white rounded-3">
                        <h6 class="mb-3 fw-bold text-primary">THÔNG TIN CHI TIẾT</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Tổng chiết khấu</span>
                            <span id="totalDiscount" class="fw-semibold text-danger">0₫</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Tổng VAT</span>
                            <span id="totalVAT" class="fw-semibold text-danger">0₫</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Tổng cộng</span>
                            <span id="totalAmount" class="fw-semibold text-danger">0₫</span>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-sm btn-success w-100" onclick="submitMaterials()">Tạo phiếu
                            nhập</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('warehouse.import_warehouse.modal')
@endsection

@section('scripts')
    <script src="{{ asset('js/warehouse/add_import.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.mySelect').select2();
        });
    </script>
@endsection
