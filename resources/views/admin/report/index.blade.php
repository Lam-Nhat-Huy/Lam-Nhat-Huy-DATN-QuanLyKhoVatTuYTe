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
                <span class="text-muted mt-1 fw-bold fs-7">Đang Hiển Thị 10 Báo Cáo Trên 240 Báo Cáo</span>
            </h3>
            <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-light-primary">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus me-2"></i>
                        Thêm Báo Cáo Mới
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
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="ps-4 rounded-start">Mã Báo Cáo</th>
                            <th class="">Người Báo Cáo</th>
                            <th class="">Nội Dung Báo Cáo</th>
                            <th class="">Loại Báo Cáo</th>
                            <th class="rounded-end">File Báo Cáo</th>
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
@endsection

@section('scripts')
@endsection
