@extends('master_layout.layout')

@section('styles')
    <style>
        /* Styles của bạn nếu cần */
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
                <a href="{{ route('equipments.equipments_group_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>

                <!-- Nút Thêm Nhóm Vật Tư -->
                <a href="{{ route('equipments.add_equipments_group') }}" class="btn btn-sm btn-success">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-plus"></i>
                        Thêm Nhóm Vật Tư
                    </span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="card-body py-8 me-7 col-12">
                        <form action="" class="row align-items-center">
                            <div class="col-6">
                                <select name="ur" id="ur" class="mt-2 mb-2 form-select form-select-sm form-select-solid setupSelect2">
                                    <option value="" selected>--Theo Trạng Thái--</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-10">
                                        <input type="search" name="kw" placeholder="Tìm Kiếm Theo Mã, Tên.." class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success" value="{{ request()->kw }}">
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
                                            <td>#{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description ?? 'Không có mô tả' }}</td>
                                            <td>
                                                @if ($item->status)
                                                    <span class="rounded px-2 py-1 text-white bg-success">Có</span>
                                                @else
                                                    <span class="rounded px-2 py-1 text-white bg-danger">Không</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Nút Chỉnh sửa -->
                                                <a href="{{ route('equipments.update_equipments_group', $item->code) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i> Chỉnh sửa
                                                </a>
                                                <!-- Nút Xóa -->
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" onclick="setDeleteAction('{{ route('equipments.delete_equipments_group', $item->code) }}')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
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

    {{-- Modal Xác Nhận Xóa --}}
    <div class="modal fade" id="deleteConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px;">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa nhóm vật tư này?</p>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-danger px-4" onclick="document.getElementById('deleteForm').submit();">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function setDeleteAction(action) {
            document.getElementById('deleteForm').setAttribute('action', action);
        }
    </script>
@endsection
