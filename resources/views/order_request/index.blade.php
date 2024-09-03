@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Yêu Cầu Đặt Hàng</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('order_request.order_request_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('order_request.insert_order_request') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-1"></i>
                        Tạo Yêu Cầu
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 me-6">
            <form action="" class="row align-items-center">
                <div class="col-3">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Nhà Cung Cấp--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Người Tạo--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="stt" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                        <option value="" selected>--Theo Trạng Thái--</option>
                        <option value="1" {{ request()->stt == 1 ? 'selected' : '' }}>Chưa Duyệt</option>
                        <option value="2" {{ request()->stt == 2 ? 'selected' : '' }}>Đã Duyệt</option>
                    </select>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-10">
                            <input type="search" name="kw" placeholder="Tìm Kiếm Mã Yêu Cầu.."
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
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Yêu Cầu</th>
                            <th class="">Nhà Cung Cấp</th>
                            <th class="">Người Tạo</th>
                            <th class="">Ngày Tạo</th>
                            <th class="" style="width: 120px !important;">Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllOrderRequest as $item)
                            <tr class="text-center">
                                <td>
                                    #{{ $item['order_request_code'] }}
                                </td>
                                <td>
                                    {{ $item['supplier_id'] }}
                                </td>
                                <td>
                                    {{ $item['user_create'] }}
                                </td>
                                <td>
                                    {{ $item['date_of_entry'] }}
                                </td>
                                <td>
                                    @if ($item['status'] == 1)
                                        <div class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</div>
                                    @else
                                        <div class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h me-2"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                            @if ($item['status'] == 1)
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#browse_{{ $item['id'] }}">
                                                        <i class="fa fa-clipboard-check me-1"></i>Duyệt
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('order_request.update_order_request') }}">
                                                    <i class="fa fa-edit me-1"></i>Sửa
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item pointer" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal_{{ $item['id'] }}">
                                                    <i class="fa fa-eye me-1"></i>Chi Tiết
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item pointer" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal_{{ $item['id'] }}">
                                                    <i class="fa fa-trash me-1"></i>Xóa
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- Duyệt --}}
                                    <div class="modal fade" id="browse_{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="checkModalLabel">Duyệt Yêu Cầu Đặt
                                                        Hàng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Duyệt Yêu Cầu Đặt Hàng Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-twitter">Duyệt</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Chi Tiết --}}
                                    <div class="modal fade" id="detailModal_{{ $item['id'] }}" tabindex="-1"
                                        aria-labelledby="detailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content rounded shadow-sm border-0">
                                                <!-- Modal header -->
                                                <div class="modal-header pb-0 border-0 justify-content-end">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div id="printArea">
                                                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                        <div class="d-flex mb-5">
                                                            <img src="https://i.pinimg.com/originals/36/b0/a0/36b0a084544360c807d7c778358f762d.png" width="100" alt="">
                                                            <div class="text-left mt-3">
                                                                <h6 class="mb-0 pb-0">PHÒNG KHÁM ĐA KHOA BEESOFT</h6>
                                                                <div>307C Nguyễn Văn Linh, An Khánh, Ninh Kiều, Cần Thơ</div>
                                                                <div>Hotline: 0900900999</div>
                                                            </div>
                                                        </div>
                                                        <form action="" method="post">
                                                            <div class="text-center mb-13">
                                                                <h1 class="mb-3 text-uppercase text-primary">Phiếu Yêu Cầu
                                                                    Đặt Hàng
                                                                </h1>
                                                                <div class="text-muted fw-bold fs-6">Thông Tin Chi Tiết Về
                                                                    Phiếu Yêu Cầu Đặt Hàng
                                                                    <span
                                                                        class="link-primary fw-bolder">#MaYeuCauMuaHang</span>.
                                                                </div>
                                                                <div class="text-muted fs-30">
                                                                    Ngày Lập 2-9-2024
                                                                </div>
                                                            </div>
                                                            <div class="mb-15 text-left">
                                                                <!-- Begin::Receipt Info -->
                                                                <div class="mb-4">
                                                                    <h4
                                                                        class="text-primary border-bottom border-dark pb-4">
                                                                        Thông Tin Đặt Hàng</h4>
                                                                    <div class="pt-2">
                                                                        <p><strong>Người Yêu Cầu:</strong> <span
                                                                                id="modalSupplier">Lữ Phát Huy</span>
                                                                        </p>
                                                                        <p><strong>Địa Chỉ:</strong> <span
                                                                                id="modalSupplier">24, Trần Chiên, Lê Bình,
                                                                                Cái Răng, Cần Thơ</span>
                                                                        </p>
                                                                        <p><strong>Số Điện Thoại:</strong> <span
                                                                                id="modalSupplier">0945 567 048</span>
                                                                        </p>
                                                                        <h6><span id="modalSupplier">Công Ty <span class="text-success">BeeSoft</span> Có Nhu
                                                                                Cầu Đặt Hàng Tại
                                                                                <span class="text-danger">#TenNhaCungCap</span> theo mẫu yêu
                                                                                cầu như sau:</span>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                                <!-- End::Receipt Info -->

                                                                <!-- Begin::Receipt Items -->
                                                                <div class="mb-4">
                                                                    <h4
                                                                        class="text-primary border-bottom border-dark pb-4 mb-4">
                                                                        Danh Sách Vật Tư</h4>
                                                                    <div class="table-responsive">
                                                                        <table
                                                                            class="table table-striped align-middle gs-0 gy-4">
                                                                            <thead>
                                                                                <tr class="fw-bolder bg-success">
                                                                                    <th style="width: 33%;">Vật Tư</th>
                                                                                    <th style="width: 33%;">Đơn Vị</th>
                                                                                    <th style="width: 33%;">Số Lượng
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="text-center">
                                                                                    <td>
                                                                                        Bình Oxy Y Tế - (Bình 5 Lít)
                                                                                    </td>
                                                                                    <td>
                                                                                        Bình
                                                                                    </td>
                                                                                    <td>
                                                                                        100
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div>
                                                                        <p><strong>Ghi Chú: </strong><span>Giao Lẹ</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-7"></div>
                                                                        <div class="col-5 text-center">
                                                                            <p class="m-0 p-0">
                                                                                Cần Thơ, ngày
                                                                                {{ \Carbon\Carbon::now()->day }}
                                                                                tháng
                                                                                {{ \Carbon\Carbon::now()->month }} năm
                                                                                {{ \Carbon\Carbon::now()->year }}
                                                                            </p>
                                                                            <p class="m-0 p-0">
                                                                                <strong>Người Lập</strong>
                                                                            </p>
                                                                            <p style="margin-top: 70px !important;">
                                                                                Lữ Phát Huy
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                @if ($item['status'] == 2)
                                                                    <div class="d-flex justify-content-between mt-5">
                                                                        <!-- Print Button -->
                                                                        <button type="button" id="printPdfBtn"
                                                                            class="btn btn-twitter btn-sm me-2">
                                                                            <i class="fa fa-print me-2"></i>In Phiếu
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Xóa --}}
                                    <div class="modal fade" id="deleteModal_{{ $item['id'] }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Yêu Cầu
                                                        Đặt Hàng
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Xóa Yêu Cầu Đặt Hàng Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-twitter">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('printPdfBtn').addEventListener('click', function() {
            // Chọn phần tử chứa nội dung phiếu nhập mà bạn muốn in
            var printContents = document.getElementById('printArea').innerHTML;

            // Tạo một cửa sổ mới
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            // Thực hiện lệnh in
            window.print();

            // Đặt lại nội dung của trang
            document.body.innerHTML = originalContents;
        });
    </script>
@endsection
