@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8">
        <div class="card-header border-0 pt-5 d-flex justify-content-between align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Đơn Vị</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('units.create') }}" class="btn btn-sm btn-success" style="font-size: 10px;">
                    <i style="font-size: 10px;" class="fa fa-plus"></i> Thêm Đơn Vị
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card-body py-1 me-6">
            <form class="row align-items-center" id="searchForm">
                <div class="col-3">
                    <input type="search" name="kw" id="kw" placeholder="Tìm Kiếm Theo Mã, Tên, Mô Tả"
                        class="form-control form-control-sm form-control-solid border-success">
                </div>
                <div class="col-3">
                    <input type="text" name="created_by" id="created_by" placeholder="Người tạo"
                        class="form-control form-control-sm form-control-solid border-success">
                </div>
                <div class="col-2">
                    <input type="date" name="start_date" id="start_date" class="form-control form-control-sm form-control-solid border-success">
                </div>
                <div class="col-2">
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm form-control-solid border-success">
                </div>
            </form>
        </div>

        <!-- Table for displaying units -->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4 table-hover">
                    <thead>
                        <tr class="text-center bg-success">
                            <th class="ps-4">Mã Đơn Vị</th>
                            <th>Tên Đơn Vị</th>
                            <th>Mô Tả</th>
                            <th>Người tạo</th>
                            <th>Ngày tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="unitTableBody">
                        @foreach ($allUnits as $unit)
                            <tr class="text-center hover-table">
                                <td>{{ $unit->code }}</td>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->description ?? 'Không có mô tả' }}</td>
                                <td>{{ $unit->created_by }}</td>
                                <td>{{ $unit->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('units.edit', $unit->code) }}" class="btn btn-sm btn-info" style="font-size: 10px;">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal{{ $unit->code }}" style="font-size: 10px;">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="deleteConfirmModal{{ $unit->code }}" tabindex="-1" aria-labelledby="deleteConfirmLabel{{ $unit->code }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteConfirmLabel{{ $unit->code }}">Xác Nhận Xóa Đơn Vị</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p class="text-danger">Bạn có chắc chắn muốn xóa đơn vị này?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <form action="{{ route('units.destroy', $unit->code) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('searchForm');
            const unitTableBody = document.getElementById('unitTableBody');

            // Thêm sự kiện khi nhập liệu vào form
            searchForm.addEventListener('input', function () {
                let kw = document.getElementById('kw').value;
                let createdBy = document.getElementById('created_by').value;
                let startDate = document.getElementById('start_date').value;
                let endDate = document.getElementById('end_date').value;

                // Gửi request AJAX
                fetch(`{{ route('units.ajax.search') }}?kw=${kw}&created_by=${createdBy}&start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        // Xóa nội dung cũ
                        unitTableBody.innerHTML = '';

                        if (data.length > 0) {
                            // Tạo nội dung mới dựa trên kết quả tìm kiếm
                            data.forEach(unit => {
                                unitTableBody.innerHTML += `
                                    <tr class="text-center hover-table">
                                        <td>${unit.code}</td>
                                        <td>${unit.name}</td>
                                        <td>${unit.description ?? 'Không có mô tả'}</td>
                                        <td>${unit.created_by}</td>
                                        <td>${new Date(unit.created_at).toLocaleDateString('vi-VN')}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ url('units/edit') }}/${unit.code}" class="btn btn-sm btn-info" style="font-size: 10px;">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal${unit.code}" style="font-size: 10px;">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            // Hiển thị thông báo khi không có kết quả
                            unitTableBody.innerHTML = `
                                <tr>
                                    <td colspan="6" class="text-center">Không tìm thấy kết quả.</td>
                                </tr>
                            `;
                        }
                    });
            });
        });
    </script>
@endsection
