@extends('master_layout.layout')

@section('styles')
    <style>
        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .width-90 {
            width: 90px !important;
        }

        .rounded-3 {
            border-radius: 0.5rem !important;
        }

        .card .card-body {
            padding: 2rem 2.25rem;
        }

        a {
            text-decoration: none;
        }

        .panel-title a {
            display: block;
            position: relative;
            padding: 10px 60px 10px 15px;
            font-weight: 400;
            font-size: 18px;
            line-height: 1.6;
            color: #6d7194;
        }

        a:hover {
            text-decoration: none;
        }

        .drop-accordion .panel-default {
            overflow: hidden;
            border: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .drop-accordion .panel-heading {
            overflow: hidden;
            margin-bottom: 5px;
            padding: 0;
            border: 1px solid #d9d7d7;
            background: #fafafa;
            border-radius: 0;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        {{-- Phần nút thêm vật tư --}}
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Danh Sách Thiết Bị</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('equipments.equipments_trash') }}" class="btn btn-sm btn-danger me-2">
                    <span class="align-items-center d-flex" style="font-size: 10px">
                        <i style="font-size: 10px" class="fa fa-trash me-1"></i>
                        Thùng Rác
                    </span>
                </a>
                <a href="{{ route('equipments.insert_equipments') }}" class="btn btn-sm btn-success">
                    <span class="align-items-center d-flex" style="font-size: 10px">
                        <i style="font-size: 10px" class="fa fa-plus"></i>
                        Thêm Thiết Bị
                    </span>
                </a>
            </div>
        </div>

        {{-- Bộ lọc vật tư --}}
        <div class="card-body py-1 me-6">
            <form action="{{ route('equipments.index') }}" method="GET" class="row align-items-center">
                <div class="col-4">
                    <select name="equipment_type_code" class="mt-2 mb-2 form-select form-select-sm setupSelect2">
                        <option value="" selected>--Theo Nhóm Thiết Bị--</option>
                        @foreach ($equipmentTypes as $type)
                            <option value="{{ $type->code }}"
                                {{ request()->equipment_type_code == $type->code ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <select name="unit_code" class="mt-2 mb-2 form-select form-select-sm setupSelect2">
                        <option value="" selected>--Theo Đơn Vị Tính--</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->code }}" {{ request()->unit_code == $unit->code ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
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


        {{-- Danh sách vật tư --}}
        <div class="card-body py-3">
            @if ($AllMaterial->isEmpty() && request()->has('kw'))
            {{-- Thông báo khi không tìm thấy kết quả tìm kiếm --}}
            <tr>
                <td colspan="4" class="text-center">
                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4" role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                        <div class="mb-3">
                            <i class="fas fa-search" style="font-size: 36px; color: #6c757d;"></i>
                        </div>
                        <div class="text-center">
                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không tìm thấy kết quả phù hợp</h5>
                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                Vui lòng thử lại với từ khóa khác hoặc thay đổi bộ lọc tìm kiếm.
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        @elseif ($AllMaterial->isEmpty())
            {{-- Thông báo khi danh sách trống mà không có tìm kiếm --}}
            <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4" role="alert" style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                <div class="mb-3">
                    <i class="fas fa-clipboard-check" style="font-size: 36px; color: #6c757d;"></i>
                </div>
                <div class="text-center">
                    <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Danh sách thiết bị trống</h5>
                    <p style="font-size: 14px; color: #6c757d; margin: 0;">
                        Hiện tại chưa có thiết bị nào được tạo. Vui lòng kiểm tra lại hoặc thêm mới thiết bị để bắt đầu.
                    </p>
                </div>
            </div>
        @else
                @foreach ($AllMaterial as $item)
                    <div class="col-xl-12 mb-2">
                        <!-- Nội dung của từng thiết bị -->
                        <!-- Card hiển thị thiết bị -->
                        <div class="card mb-1 card-body p-2 pointer" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $item->code }}" aria-expanded="false"
                            aria-controls="collapse{{ $item->code }}">
                            <div class="row align-items-center g-1">
                                <div class="col-auto">
                                    <a href="#">
                                        <img src="{{ $item->image ? asset('images/equipments/' . $item->image) : 'https://inhoangkien.vn/wp-content/uploads/2020/04/Logo-B%E1%BB%99-Y-t%E1%BA%BF-01-e1585994422207-300x213.png' }}"
                                            class="width-90 rounded-3 mr-2" alt="Medical Supply Image">
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="overflow-hidden flex-nowrap">
                                        <h6 class="mb-1">
                                            <a href="#" class="text-reset">{{ $item->name }}</a>
                                        </h6>
                                        <span class="text-muted d-block mb-1 small">
                                            Danh mục: {{ $item->equipmentType->name ?? 'Không có dữ liệu' }}
                                        </span>
                                        <div class="row align-items-center g-1">
                                            <div class="col">
                                                <p class="mb-1 small text-muted">Mã vật tư: {{ $item->code }}</p>
                                                <p class="mb-1 small text-muted">
                                                    Hạn sử dụng:
                                                    {{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('d/m/Y') : 'Không Có' }}
                                                    - {{ $item->time_remaining }}
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <span class="fw-bold text-success">Còn Hàng</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Collapsible Content -->
                        <div class="collapse multi-collapse" id="collapse{{ $item->code }}">
                            <div class="card card-body p-2" style="border: 1px solid #dcdcdc; background-color: #f8f9fa;">
                                <div class="row gy-3">
                                    <div class="col-md-4">
                                        <img src="{{ $item->image ? asset('images/equipments/' . $item->image) : 'https://st4.depositphotos.com/14953852/24787/v/380/depositphotos_247872612-stock-illustration-no-image-available-icon-vector.jpg' }}"
                                            alt="Medical Supply Image" width="100%" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card card-body border-0">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="card-title fw-bold">Chi tiết vật tư</h4>
                                                <span class="badge bg-success">Còn hàng</span>
                                            </div>
                                            <!-- Chi tiết vật tư -->
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Mã vật tư:</strong></td>
                                                                <td class="text-gray-800">{{ $item->code }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Nhóm hàng:</strong></td>
                                                                <td class="text-gray-800">{{ $item->equipmentType->name ?? 'Không có dữ liệu' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Nhà cung cấp:</strong></td>
                                                                <td class="text-gray-800">{{ $item->supplier->name ?? 'Không có dữ liệu' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Ngày hết hạn:</strong></td>
                                                                <td class="text-gray-800">{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') : 'Không Có' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Giá nhập:</strong></td>
                                                                <td class="text-gray-800">{{ number_format($item->price) }} VNĐ</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Ghi chú:</strong></td>
                                                                <td class="text-gray-800">{{ $item->description }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tồn kho:</strong></td>
                                                                <td class="text-gray-800">{{ $item->inventories->sum('current_quantity') }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="text-end mt-4">
                                                <div class="button-group">
                                                    <a href="{{ route('equipments.update_equipments', $item->code) }}" class="btn btn-sm btn-success me-2" style="font-size: 10px">
                                                        <i class="fa fa-edit" style="font-size: 10px"></i>Cập Nhật
                                                    </a>
                                                    <button class="btn btn-sm btn-danger me-2" data-bs-toggle="modal"
                                                        data-bs-target="#deleteConfirm{{ $item->code }}">
                                                        <i style="font-size: 10px" class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
    </div>

    @foreach ($AllMaterial as $item)
        <div class="col-xl-12 mb-2">
            <!-- Nội dung sử dụng biến $item -->
        </div>

        <!-- Modal Xác Nhận Xóa -->
        <div class="modal fade" id="deleteConfirm{{ $item->code }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white" id="deleteConfirmLabel">Xác Nhận Xóa Thiết Bị</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" style="padding-bottom: 0px;">
                        <form action="{{ route('equipments.delete_equipments', $item->code) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <p class="text-danger mb-4">Bạn có chắc chắn muốn xóa vật tư này?</p>
                            <div class="modal-footer justify-content-center border-0">
                                <button type="button" class="btn btn-sm btn-secondary px-4"
                                    data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-sm btn-danger px-4"> Xóa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
@endsection
