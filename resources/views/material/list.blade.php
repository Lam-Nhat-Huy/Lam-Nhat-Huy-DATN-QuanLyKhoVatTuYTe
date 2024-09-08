@extends('master_layout.layout')

@section('styles')
    <style>
        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .width-90 {
            width: 90px !important;
        }

        .rounded-3 {
            border-radius: 0.5rem !important;
        }

        .card .card-body {
            padding: 2rem 2.25rem;
        }

        a {
            text-decoration: none;
        }

        .panel-title a {
            display: block;
            position: relative;
            padding: 10px 60px 10px 15px;
            font-weight: 400;
            font-size: 18px;
            line-height: 1.6;
            color: #6d7194;
        }

        a:hover {
            text-decoration: none;
        }

        .drop-accordion .panel-default {
            overflow: hidden;
            border: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .drop-accordion .panel-heading {
            overflow: hidden;
            margin-bottom: 5px;
            padding: 0;
            border: 1px solid #d9d7d7;
            background: #fafafa;
            border-radius: 0;
        }

        .leaf-ui .drop-accordion .panel-heading,
        .circlus-ui .drop-accordion .panel-heading {
            border-radius: 4px;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        {{-- Phần nút thêm vật tư  --}}
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Vật Tư</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('material.material_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('material.insert_material') }}" class="btn btn-sm btn-success">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus"></i>
                        Thêm Vật Tư
                    </span>
                </a>
            </div>
        </div>

        {{-- Bộ lọc vật tư  --}}
        <div class="card-body py-1 me-6">
            <form action="" class="row align-items-center">

                <div class="col-4">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Nhóm Vật Tư--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>

                <div class="col-4">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Đơn Vị Tính--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>

                <div class="col-4">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Theo Mã, Tên.."
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


        {{-- Danh sách vật tư   --}}
        <div class="card-body py-3">

            @foreach ($AllMaterial as $item)
                <div class="col-xl-12 mb-2">
                    <!-- Card that serves as the clickable trigger -->
                    <div class="card mb-1 card-body p-2"> <!-- Reduced padding for closer look -->
                        <div class="row align-items-center g-1" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $item['id'] }}">
                            <div class="col-auto">
                                <a href="#!.html">
                                    <img src="{{ $item['material_image'] }}" class="width-90 rounded-3 mr-2"
                                        alt="Medical Supply Image">
                                </a>
                            </div>
                            <div class="col">
                                <div class="overflow-hidden flex-nowrap">
                                    <h6 class="mb-1">
                                        <a href="#!" class="text-reset">{{ $item['material_name'] }}</a>
                                    </h6>
                                    <span class="text-muted d-block mb-1 small">
                                        Danh mục: {{ $item['material_type_id'] }}
                                    </span>
                                    <div class="row align-items-center g-1"> <!-- Reduced gutter between columns -->
                                        <div class="col">
                                            <p class="mb-1 small text-muted">Mã vật tư: PD817212</p>
                                            <p class="mb-1 small text-muted">Hạn sử dụng: 12/12/2025</p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="fw-bold text-success">Còn Hàng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collapsible Content -->
                    <div class="collapse multi-collapse" id="collapse{{ $item['id'] }}">
                        <div class="card card-body p-2" style="border: 1px solid #dcdcdc; background-color: #f8f9fa;">
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <img src="{{ $item['material_image'] }}" alt="" class="img-fluid rounded">
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-body border-0">
                                        <h4 class="card-title fw-bold mb-3">Chi tiết vật tư</h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-success">Còn hàng</span>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Mã vật tư:</strong></td>
                                                            <td class="text-gray-800">HD00019</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Nhóm hàng:</strong></td>
                                                            <td class="text-gray-800">Vật Tư Y Tế</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Thương hiệu:</strong></td>
                                                            <td class="text-gray-800">Pharmacy</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Vị trí:</strong></td>
                                                            <td class="text-gray-800">C123</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Ngày hết hạn:</strong></td>
                                                            <td class="text-gray-800">25/12/2024</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Giá nhập:</strong></td>
                                                            <td class="text-gray-800">25,000 VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Ghi chú:</strong></td>
                                                            <td class="text-gray-800">Hàng dễ vỡ</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tồn kho:</strong></td>
                                                            <td class="text-gray-800">100</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Số lượng đã dùng:</strong></td>
                                                            <td class="text-gray-800">50</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tồn cuối:</strong></td>
                                                            <td class="text-gray-800">50</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <strong>Mã vạch:</strong><br>
                                                <img src="https://png.pngtree.com/png-clipart/20220604/original/pngtree-barcode-image-black-png-image_7947265.png"
                                                    width="80" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nút hành động đưa xuống dưới -->
                                    <div class="text-end mt-4">
                                        <div class="button-group">
                                            <!-- Nút Cập nhật -->
                                            <a href="#" class="btn btn-sm btn-success me-2" data-bs-toggle="modal"
                                                data-bs-target="#browse">Cập Nhật</a>
                                            <!-- Nút In Phiếu -->
                                            <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal">In Phiếu</button>
                                            <!-- Nút Xóa đơn -->
                                            <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirm">Xóa đơn</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

    {{-- Modal Xác Nhận Xóa --}}
    <div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa Đơn</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form action="" method="">
                        @csrf
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa đơn này?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-danger px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-success px-4"> Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
