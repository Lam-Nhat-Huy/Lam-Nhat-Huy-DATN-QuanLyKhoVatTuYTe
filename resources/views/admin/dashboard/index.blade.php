@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Báo Cáo</span>
                <span class="text-muted mt-1 fw-bold fs-7">2 Báo Cáo Mới Nhất</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('report.index') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        Xem Tất Cả Báo Cáo
                        <i class="fa fa-arrow-right ms-2"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 text-right">
            <select name="" id="" class="mt-2 mb-2">
                <option value="0" selected>Theo Loại Báo Cáo</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Báo Cáo</th>
                            <th class="">Người Báo Cáo</th>
                            <th class="">Nội Dung Báo Cáo</th>
                            <th class="">Loại Báo Cáo</th>
                            <th class="pe-3">File Báo Cáo</th>
                            {{-- <th class="rounded-end">Hành Động</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>
                                #123
                            </td>
                            <td>
                                Lữ Phát Huy - Kế Toán
                            </td>
                            <td>
                                Báo Cáo Chi Phí Hóa Đơn Nhập Kho
                            </td>
                            <td>
                                Hóa Đơn Nhập Kho
                            </td>
                            <td>
                                <strong style="cursor: pointer; color: rgb(33, 64, 178);"
                                    download="file:///C:/Users/admin/Documents/Zalo%20Received%20Files/cv-pc05334.pdf">Tải
                                    Xuống</strong>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>
                                #343
                            </td>
                            <td>
                                Lâm Nhật Huy - Nhân Viên Mua Hàng
                            </td>
                            <td>
                                Báo Cáo Chi Phí Hóa Đơn Xuất Kho
                            </td>
                            <td>
                                Hóa Đơn Xuất Kho
                            </td>
                            <td>
                                <strong style="cursor: pointer; color: rgb(33, 64, 178);"
                                    download="file:///C:/Users/admin/Documents/Zalo%20Received%20Files/cv-pc05334.pdf">Tải
                                    Xuống</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Tồn Kho</span>
                <span class="text-muted mt-1 fw-bold fs-7">2 Vật Tư Mới Nhất</span>
            </h3>
            <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <span class="align-items-center d-flex">
                            Xem Tất Cả Kho
                            <i class="fa fa-arrow-right ms-2"></i>
                        </span>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 text-center">
            @php
                use Carbon\Carbon;
            @endphp

            <input type="date" name="date_first" class="me-3 mt-2 mb-2"
                value="{{ Carbon::now()->subMonth()->format('Y-m-d') }}">

            <span class="me-3 mt-2 mb-2">Đến</span>

            <input type="date" name="date_last" class="me-3 mt-2 mb-2" value="{{ Carbon::now()->format('Y-m-d') }}">

            <select name="" id="" class="me-3 mt-2 mb-2">
                <option value="0" selected>Theo Nhóm Vật Tư</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>

            <select name="" id="" class="me-3 mt-2 mb-2">
                <option value="0" selected>Theo Nhà Cung Cấp</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>

            <input type="search" name="search" placeholder="Tìm Kiếm..." class="me-3 mt-2 mb-2">

            <button class="btn btn-dark btn-sm me-3 mt-2 mb-2">In Phiếu</button>

            <button class="btn btn-success btn-sm">Xuất Excel</button>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã VT</th>
                            <th class="">Tên VT</th>
                            <th class="">ĐVT</th>
                            <th class="">Số Lô</th>
                            <th class="">Hạn Dùng</th>
                            <th class="">Giá Nhập</th>
                            <th class="">Tồn Đầu</th>
                            <th class="">TT Tồn Đầu</th>
                            <th class="">Tổng Nhập</th>
                            <th class="">Tổng Xuất</th>
                            <th class="">Tồn Cuối</th>
                            <th class="pe-3">TT Tồn Cuối</th>
                            {{-- <th class="rounded-end">Hành Động</th> --}}
                        </tr>
                    </thead>
                    <thead id="thead_2">
                        <tr>
                            <th colspan="6" class="ps-4 fw-bold" id="thead_th_1">Số Lượng Vật Tư:
                                2
                            </th>
                            <th>2</th>
                            <th>2</th>
                            <th>2</th>
                            <th>1</th>
                            <th>1</th>
                            <th>1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            {{-- <td class="">
                                <a href="#"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                fill="black" />
                                            <path
                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="#"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                fill="black" />
                                            <path opacity="0.5"
                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                fill="black" />
                                            <path opacity="0.5"
                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </td> --}}
                        </tr>
                        <tr>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            <td>
                                #03941384
                            </td>
                            {{-- <td class="">
                                <a href="#"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                fill="black" />
                                            <path
                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="#"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                fill="black" />
                                            <path opacity="0.5"
                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                fill="black" />
                                            <path opacity="0.5"
                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
