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
            <form action="" class="row">
                <div class="col-3">
                    <select name="ur" id="ur" class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
                        <option value="" selected>--Theo Nhà Cung Cấp--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="ur" id="ur" class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
                        <option value="" selected>--Theo Người Tạo--</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="stt" id="stt" class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success">
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
                            <th class="">Trạng Thái</th>
                            <th class="pe-3">Hành Động</th>
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
                                        <span class="rounded px-2 py-1 text-white bg-danger">Chưa Duyệt</span>
                                    @else
                                        <span class="rounded px-2 py-1 text-white bg-success">Đã Duyệt</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item['status'] == 1)
                                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#checkModal_{{ $item['id'] }}"><i
                                                class="fa fa-clipboard-check"></i>Duyệt</button>

                                        <div class="modal fade" id="checkModal_{{ $item['id'] }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="checkModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="checkModalLabel">Duyệt Yêu Cầu Đặt Hàng</h3>
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

                                        <a class="btn btn-sm btn-twitter" href="{{ route('order_request.update_order_request') }}">
                                            <i class="fa fa-edit"></i>Sửa
                                        </a>
                                    @endif

                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal_{{ $item['id'] }}"><i
                                            class="fa fa-trash"></i>Xóa</button>

                                    <div class="modal fade" id="deleteModal_{{ $item['id'] }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="deleteModalLabel">Xóa Yêu Cầu Đặt Hàng</h3>
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
@endsection
