@extends('master_layout.layout')

@section('styles')
    <style>
        .checkbox-wrapper-6 .tgl {
            display: none;
        }

        .checkbox-wrapper-6 .tgl,
        .checkbox-wrapper-6 .tgl:after,
        .checkbox-wrapper-6 .tgl:before,
        .checkbox-wrapper-6 .tgl *,
        .checkbox-wrapper-6 .tgl *:after,
        .checkbox-wrapper-6 .tgl *:before,
        .checkbox-wrapper-6 .tgl+.tgl-btn {
            box-sizing: border-box;
        }

        .checkbox-wrapper-6 .tgl::-moz-selection,
        .checkbox-wrapper-6 .tgl:after::-moz-selection,
        .checkbox-wrapper-6 .tgl:before::-moz-selection,
        .checkbox-wrapper-6 .tgl *::-moz-selection,
        .checkbox-wrapper-6 .tgl *:after::-moz-selection,
        .checkbox-wrapper-6 .tgl *:before::-moz-selection,
        .checkbox-wrapper-6 .tgl+.tgl-btn::-moz-selection,
        .checkbox-wrapper-6 .tgl::selection,
        .checkbox-wrapper-6 .tgl:after::selection,
        .checkbox-wrapper-6 .tgl:before::selection,
        .checkbox-wrapper-6 .tgl *::selection,
        .checkbox-wrapper-6 .tgl *:after::selection,
        .checkbox-wrapper-6 .tgl *:before::selection,
        .checkbox-wrapper-6 .tgl+.tgl-btn::selection {
            background: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn {
            outline: 0;
            display: block;
            width: 40px;
            height: 22px;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after,
        .checkbox-wrapper-6 .tgl+.tgl-btn:before {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:after {
            left: 0;
        }

        .checkbox-wrapper-6 .tgl+.tgl-btn:before {
            display: none;
        }

        .checkbox-wrapper-6 .tgl:checked+.tgl-btn:after {
            left: 50%;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn {
            background: #f0f0f0;
            border-radius: 2em;
            padding: 2px;
            transition: all 0.4s ease;
        }

        .checkbox-wrapper-6 .tgl-light+.tgl-btn:after {
            border-radius: 50%;
            background: #fff;
            transition: all 0.2s ease;
        }

        .checkbox-wrapper-6 .tgl-light:checked+.tgl-btn {
            background: #1fb948;
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
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Nhóm Vật Tư</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('material.material_group_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card-body py-1 mb-10 pe-0">
                    <form class="form" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-5">
                            <label class="required fs-5 fw-bold mb-3">Tên Nhóm Vật Tư</label>

                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Nhóm Vật Tư.." name="material_type_name" />
                        </div>

                        <div class="mb-5">
                            <label class="required fs-5 fw-bold mb-2">Mô Tả</label>

                            <textarea name="content" class="form-control form-control-sm form-control-solid border border-success" cols="30"
                                rows="5" placeholder="Mô Tả"></textarea>
                        </div>

                        <div class="mb-5">
                            <label class="required fs-5 fw-bold mb-2">Trạng Thái</label>
                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cb1-6" type="checkbox" value="2" checked />
                                <label class="tgl-btn" for="cb1-6">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-twitter btn-sm w-100">
                            Thêm
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="card-body py-8 me-7 col-12">
                        <form action="" class="row align-items-center">
                            <div class="col-6">
                                <select name="ur" id="ur"
                                    class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                                    <option value="" selected>--Theo Trạng Thái--</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                </select>
                            </div>
                            <div class="col-6">
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
                    <div class="card-body py-1 me-3 col-12">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bolder bg-success">
                                        <th class="ps-4">Mã Nhóm Vật Tư</th>
                                        <th class="">Tên</th>
                                        <th class="">Mô Tả</th>
                                        <th class="" style="width: 120px !important;">Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($AllMaterialGroup as $item)
                                        <tr class="text-center">
                                            <td>
                                                #{{ $item['material_type_code'] }}
                                            </td>
                                            <td>
                                                {{ $item['material_type_name'] }}
                                            </td>
                                            <td>
                                                {{ $item['description'] }}
                                            </td>
                                            <td>
                                                @if ($item['status'] == 1)
                                                    <span class="rounded px-2 py-1 text-white bg-danger">Không</span>
                                                @else
                                                    <span class="rounded px-2 py-1 text-white bg-success">Có</span>
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
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#browse"><i
                                                                        class="fa fa-clipboard-check me-1"></i>Duyệt</a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('material.update_material_group') }}">
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

                                                {{-- Modal Xóa --}}
                                                <div class="modal fade" id="deleteModal_{{ $item['id'] }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title" id="deleteModalLabel">Xóa Nhóm Vật
                                                                    Tư
                                                                </h3>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="" method="">
                                                                    @csrf
                                                                    <h4 class="text-danger">Xóa Nhóm Vật Tư Này?</h4>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary"
                                                                    data-bs-dismiss="modal">Đóng</button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-twitter">Xóa</button>
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
