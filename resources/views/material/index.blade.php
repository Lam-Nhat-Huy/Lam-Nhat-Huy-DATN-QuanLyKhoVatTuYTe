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
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder bg-success">
                            <th class="ps-4">Mã Vật Tư</th>
                            <th class="">Hình Ảnh</th>
                            <th class="">Tên</th>
                            <th class="">Nhóm</th>
                            <th class="">Đơn Vị Tính</th>
                            <th class="">Mã Vạch</th>
                            <th class="">Hạn Sử Dụng</th>
                            <th class="" style="width: 120px !important;">Trạng Thái</th>
                            <th class="pe-3">Hành Động</th>
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
                                    {{ $item['material_name'] }} - <span class="text-blue-500 fw-bold pointer"
                                        data-bs-toggle="modal" data-bs-target="#detail_vt_{{ $item['id'] }}">Mô Tả</span>
                                </td>
                                <td>
                                    {{ $item['material_type_id'] }}
                                </td>
                                <td>
                                    {{ $item['unit_id'] }}
                                </td>
                                <td>
                                    <img src="https://png.pngtree.com/png-clipart/20220604/original/pngtree-barcode-image-black-png-image_7947265.png"
                                        width="125" alt="">
                                </td>
                                <td>
                                    {{ $item['expiry'] > 0 ? $item['expiry'] . ' Tháng' : 'Không Có' }}
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
                                                        data-bs-target="#browse_{{ $item['id'] }}"><i
                                                            class="fa fa-clipboard-check me-1"></i>Duyệt</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{ route('material.update_material') }}">
                                                    <i class="fa fa-edit me-1"></i>Sửa
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

                                    {{-- Mô Tả --}}
                                    <div class="modal fade" id="detail_vt_{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="checkModalLabel">Mô Tả
                                                        "{{ $item['material_name'] }}"
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $item['description'] }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Duyệt --}}
                                    <div class="modal fade" id="browse_{{ $item['id'] }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="checkModalLabel">Duyệt Vật Tư
                                                    </h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="">
                                                        @csrf
                                                        <h4 class="text-danger">Duyệt Vật Tư Này?</h4>
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

                                    {{-- Modal Xóa --}}
                                    <div class="modal fade" id="deleteModal_{{ $item['id'] }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
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
