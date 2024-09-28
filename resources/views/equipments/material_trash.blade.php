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
                <span class="card-label fw-bolder fs-3 mb-1">Thùng Rác</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('material.index') }}" class="btn btn-sm btn-dark me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Thiết Bị</th>
                            <th class="">Hình Ảnh</th>
                            <th class="">Tên</th>
                            <th class="">Nhóm</th>
                            <th class="">Đơn Vị Tính</th>
                            <th class="">Hạn Sử Dụng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllMaterialTrash as $item)
                            <tr class="text-center">
                                <td>
                                    #{{ $item['material_code'] }}
                                </td>
                                <td>
                                    <img src="{{ $item['material_image'] }}" width="50" alt="">
                                </td>
                                <td>
                                    {{ $item['material_name'] }}
                                </td>
                                <td>
                                    {{ $item['material_type_id'] }}
                                </td>
                                <td>
                                    {{ $item['unit_id'] }}
                                </td>
                                <td>
                                    {{ $item['expiry'] > 0 ? $item['expiry'] . ' Tháng' : 'Không Có' }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#restoreModal{{ $item['id'] }}"><i
                                            class="fa fa-rotate-left"></i>Khôi Phục</button>

                                    <div class="modal fade" id="restoreModal{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="restoreModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="restoreModalLabel">Khôi Phục Nhóm Vật
                                                        Tư
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-success">Khôi Phục Nhóm Thiết Bị Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-twitter">Khôi Phục</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal_{{ $item['id'] }}"><i class="fa fa-trash"></i>Xóa
                                        Vĩnh Viễn</button>

                                    <div class="modal fade" id="deleteModal_{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Vĩnh Viễn Nhóm Vật
                                                        Tư
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Xóa Vĩnh Viễn Nhóm Thiết Bị Này?</h4>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-sm btn-danger">Xóa</button>
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
@endsection
