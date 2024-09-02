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
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Vật Tư</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('material.material_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('material.insert_material') }}" class="btn btn-sm btn-twitter">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus"></i>
                        Thêm Vật Tư
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 me-6">
            <form action="" class="row  align-items-center">
                <div class="col-4">
                    <select name="ur" id="ur" class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success border border-primary">
                        <option value="" selected>--Theo Nhóm Vật Tư--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-4">
                    <select name="ur" id="ur" class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
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
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-primary">
                            <th class="ps-4">Mã Vật Tư</th>
                            <th class="">Hình Ảnh</th>
                            <th class="">Tên</th>
                            <th class="">Nhóm</th>
                            <th class="">Đơn Vị Tính</th>
                            <th class="" style="width: 200px;">Mô Tả</th>
                            <th class="">Hạn Sử Dụng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllMaterial as $item)
                            <tr class="text-center">
                                <td>
                                    #{{ $item['material_code'] }}
                                </td>
                                <td>
                                    <img src="{{ $item['material_image'] }}" width="100" alt="">
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
                                    {{ $item['description'] }}
                                </td>
                                <td>
                                    {{ $item['expiry'] > 0 ? $item['expiry'] . ' Tháng' : 'Không Có' }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-twitter mb-1 mt-1"
                                        href="{{ route('material.update_material') }}">
                                        <i class="fa fa-edit"></i>Sửa
                                    </a>

                                    <button class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal_{{ $item['id'] }}"><i
                                            class="fa fa-trash"></i>Xóa</button>

                                    <div class="modal fade" id="deleteModal_{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Vật Tư
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Xóa Vật Tư Này?</h4>
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
@endsection
