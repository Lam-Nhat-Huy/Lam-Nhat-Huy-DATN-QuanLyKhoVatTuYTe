@extends('master_layout.layout')

@section('styles')
    <style>
        .hover-table {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hover-table:hover {
            background-color: #e9ecef;
        }

        .collapse {
            display: none;
        }

        .collapse.show {
            display: table-row;
        }

        .collapse-content {
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .btn-close-detail {
            margin-top: 10px;
        }

        .btn-close-detail i {
            margin-right: 5px;
        }

        .card-header {
            border-bottom: 1px solid #dee2e6;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .form-control-sm {
            height: 2rem;
            padding: 0.25rem 0.5rem;
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
                <span class="card-label fw-bolder fs-3 mb-1">Thẻ Kho</span>
            </h3>
        </div>

        <div class="card-body py-1">
            <form action="" class="row align-items-center d-flex justify-content-between">
                <div class="col-4 pe-8">
                    <input type="search" name="kw" placeholder="Tìm kiếm thuốc"
                        class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                        value="{{ request()->kw }}">
                </div>

                <div class="col-4">
                    <div class="row align-items-center">
                        <div class="col-5 pe-0">
                            <input type="date"
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
                        </div>
                        <div class="col-2 text-center">
                            Đến
                        </div>
                        <div class="col-5 ps-0">
                            <input type="date"
                                class="mt-2 mb-2 form-control form-control-sm form-control-solid border border-success"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body py-3">
            @if (true)
                <div class="table-responsive">
                    <table class="table table-striped align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bolder bg-success text-white">
                                <th class="ps-4">STT</th>
                                <th class="">Số lô</th>
                                <th class="">Tồn đầu kì</th>
                                <th class="">Nhập</th>
                                <th class="">Xuất</th>
                                <th class="">Tồn cuối kỳ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 3; $i++)
                                <tr class="text-center hover-table" data-bs-toggle="collapse"
                                    data-bs-target="#collapseDetails{{ $i }}">
                                    <td>1</td>
                                    <td>C123</td>
                                    <td>0</td>
                                    <td>10</td>
                                    <td>5</td>
                                    <td>10</td>
                                </tr>
                                <tr class="collapse" id="collapseDetails{{ $i }}">
                                    <td colspan="6" class="collapse-content">
                                        <!-- Thông tin chi tiết ở đây -->
                                        <p>Thông tin chi tiết về số lô C123.</p>
                                        <button class="btn btn-light btn-sm float-end btn-close-detail">
                                            <i class="fa fa-close"></i> Đóng
                                        </button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            @else
                <div class="col-md-12">
                    <p class="text-danger text-center">Không có dữ liệu để hiển thị, vui lòng chọn thông tin để thống kê</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggleElements = document.querySelectorAll('tr[data-bs-toggle="collapse"]');

            toggleElements.forEach(function(element) {
                element.addEventListener('click', function() {
                    var target = document.querySelector(this.getAttribute('data-bs-target'));

                    if (target.classList.contains('show')) {
                        target.classList.remove('show');
                    } else {
                        document.querySelectorAll('.collapse').forEach(function(item) {
                            item.classList.remove('show');
                        });
                        target.classList.add('show');
                    }
                });
            });

            // Thêm sự kiện cho nút "Đóng"
            var closeButtons = document.querySelectorAll('.btn-close-detail');

            closeButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.stopPropagation(); // Ngăn chặn sự kiện click truyền lên các phần tử cha
                    var target = this.closest('tr.collapse');
                    if (target) {
                        target.classList.remove('show');
                    }
                });
            });
        });
    </script>
@endsection
