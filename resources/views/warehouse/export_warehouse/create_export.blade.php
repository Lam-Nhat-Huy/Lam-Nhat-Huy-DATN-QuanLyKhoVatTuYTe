@extends('master_layout.layout')

@section('styles')
    <style>
        .autocomplete-items {
            position: absolute;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 0.375rem;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            background-color: #ffffff;
            border-bottom: 1px solid #f1f3f5;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .autocomplete-items div:hover {
            background-color: #5b6a7b;
            color: #ffffff;
        }

        .autocomplete-items .autocomplete-active {
            background-color: #5b6a7b;
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('warehouse.store_export') }}" method="POST">
        @csrf
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Tạo Phiếu Xuất Kho</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('warehouse.export') }}" class="btn btn-sm btn-dark">
                        <span class="align-items-center d-flex">
                            <i class="fa fa-arrow-left me-1"></i>
                            Trở Lại
                        </span>
                    </a>
                </div>
            </div>

            <div class="py-5 px-lg-17">
                <div class="me-n7 pe-7">
                    <div class="row align-items-center mb-5">
                        <div class="col-6 mb-5">
                            <label for="export_type_id" class="form-label mb-2">Loại Xuất</label>
                            <select class="form-select form-select-sm setupSelect2" id="export_type_id"
                                name="export_type_id">
                                <option value="">--Chọn loại xuất--</option>
                                <option value="noi_tru">Phiếu xuất kho cho điều trị nội trú</option>
                                <option value="ngoai_tru">Phiếu xuất kho cho phòng khám ngoại trú</option>
                                <option value="cap_cuu">Phiếu xuất kho cho cấp cứu</option>
                                <option value="dieu_chuyen_noi_bo">Phiếu xuất kho để điều chuyển nội bộ</option>
                                <option value="huy_vat_tu">Phiếu xuất kho hủy vật tư</option>
                                <option value="nghien_cuu">Phiếu xuất kho cho nghiên cứu hoặc thử nghiệm lâm sàng</option>
                                <option value="muon_tra">Phiếu xuất kho cho mượn hoặc trả</option>
                            </select>
                        </div>

                        <div class="col-6 mb-5">
                            <label for="export_date" class="form-label mb-2">Ngày xuất</label>
                            <input type="date"
                                class="form-control form-control-sm form-control-solid border border-success"
                                id="export_date" name="export_date">
                        </div>

                        <div class="col-12 mb-5">
                            <label for="note" class="form-label mb-2">Ghi chú</label>
                            <textarea name="" class="form-control form-control-sm form-control-solid border border-success" id=""
                                cols="30" rows="5" placeholder="Thêm ghi chú (nếu có)"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card py-5 mb-xl-8">
            <div class="py-5 px-lg-17">
                <div class="me-n7 pe-7">
                    <div class="mb-5">
                        <div class="row align-items-center mb-3">
                            <div class="col-6 mb-5">
                                <label for="material" class="form-label mb-2">Vật Tư</label>
                                <select class="form-select setupSelect2" id="material" name="material">
                                    <option value="">--Chọn Vật Tư--</option>
                                    <option value="user1">Bình Oxy Y Tế - (Bình 5 Lít) - (Tổng Tồn: 35)</option>
                                </select>
                            </div>
                            <div class="col-6 mb-5">
                                <label for="export_quantity" class="form-label mb-2">Số Lượng Xuất</label>
                                <input type="number" id="export_quantity" name="export_quantity"
                                    class="form-control form-control-sm form-control-solid border border-success"
                                    min="1" placeholder="Nhập số lượng xuất">
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" id="add-material" class="btn btn-success btn-sm">Thêm Vật Tư</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card py-5 mb-xl-8">
            <div class="py-5 px-lg-17">
                <div class="me-n7 pe-7">
                    <div class="mb-5">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bolder bg-success">
                                        <th class="ps-4">Tên sản phẩm</th>
                                        <th>Số lô</th>
                                        <th>Số lượng</th>
                                        <th>Hạn sử dụng</th>
                                        <th>Ngày xuất</th>
                                        <th>Loại Xuất</th>
                                        <th>Ghi chú</th>
                                        <th class="pe-3">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>
                                            Bình Oxy Y Tế - (Bình 5 Lít)
                                        </td>
                                        <td>
                                            56733456
                                        </td>
                                        <td>
                                            50
                                        </td>
                                        <td>
                                            12-12-2024
                                        </td>
                                        <td>
                                            {{ now()->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            Xuất cho kho điều trị nội trú
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Xóa</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer flex-right pe-0 me-0">
                        <button type="submit" class="btn btn-twitter btn-sm">
                            Tạo Phiếu Nhập
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection
