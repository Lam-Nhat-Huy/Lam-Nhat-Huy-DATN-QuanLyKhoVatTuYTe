@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="card mb-5 shadow-lg border-0 rounded-lg">
        <div class="card-body pt-4 pb-0">
            <div class="d-flex flex-wrap align-items-center mb-4">
                <!-- User Avatar -->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="https://1.bp.blogspot.com/-CsImmR4DBCI/Xh_fvrHfMrI/AAAAAAAAU2U/OSVSFbuvLDoAKadvyAkRhl4Y2aDGjzqIgCLcBGAsYHQ/s1600/hinh-anh-trai-dep%253Ddau-nam-hot-boy-2k-Wap102%2B%252825%2529.jpg"
                            alt="User Avatar" class="rounded-circle shadow-sm" />
                        <!-- Status Indicator -->
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                        <!-- User Name and Role -->
                        <div class="d-flex align-items-center">
                            <h2 class="text-dark fw-bold mb-0 me-3">
                                {{ session('fullname') }}
                            </h2>
                            <span
                                class="badge {{ session('isAdmin') == 1 ? 'bg-success' : 'bg-primary' }} text-white fs-8 py-1 px-3">
                                {{ session('isAdmin') == 1 ? 'Admin' : 'Nhân viên' }}
                            </span>
                        </div>
                        <!-- Edit button -->
                        <a href="#" class="btn btn-light btn-sm text-primary">
                            <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                        </a>
                    </div>

                    <!-- User Details -->
                    <div class="text-muted fs-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ session('address') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope me-2"></i>
                            {{ session('email') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h4 class="fw-bolder m-0">Chi Tiết Hồ Sơ</h4>
            </div>
        </div>

        <div class="card-body p-9">
            <!-- Section 1: Thông tin cá nhân -->
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Họ Và Tên</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ session('fullname', 'Max Smith') }}</span>
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Vị Trí Công Việc</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bolder text-gray-800 fs-6">{{ session('position', 'Quản Trị Viên') }}</span>
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Số Điện Thoại
                </label>
                <div class="col-lg-8 d-flex align-items-center">
                    <span class="fw-bolder fs-6 text-gray-800 me-2">{{ session('phone', '0945567048') }}</span>
                </div>
            </div>

            <!-- Section 2: Thông tin bổ sung -->
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Địa Chỉ</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ session('address', '123 Đường ABC, TP. HCM') }}</span>
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Email</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ session('email', 'maxsmith@example.com') }}</span>
                </div>
            </div>

            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Ngày Sinh</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ session('dob', '01/01/1990') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
