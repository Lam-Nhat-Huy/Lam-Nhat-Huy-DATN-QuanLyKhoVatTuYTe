@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">

        <div id="kt_content_container" class="container-xxl">

            <div class="d-flex flex-wrap flex-stack mb-6">

                <div class="row g-6 g-xl-9">

                    <div class="col-md-6 col-xxl-4">

                        <div class="card">

                            <div class="card-body d-flex flex-center flex-column p-9">

                                <div class="mb-5">

                                    <div class="symbol symbol-75px symbol-circle">
                                        <img alt="Pic"
                                            src="https://freenice.net/wp-content/uploads/2021/10/hinh-anh-avatar-che-mat.jpg" />
                                    </div>

                                </div>


                                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Lữ Phát
                                    Huy</a>


                                <div class="fw-bold text-gray-400 mb-6">Kế Toán</div>


                                <div class="d-flex flex-center mb-5">

                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-1 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Số Điện Thoại</div>
                                        <div class="fw-bold text-gray-400">0945567048</div>
                                    </div>


                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 mx-1 px-4 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Email</div>
                                        <div class="fw-bold text-gray-400">lphdev04@gmail.com</div>
                                    </div>

                                </div>


                                <button class="btn btn-sm btn-light-primary fw-bolder" data-kt-drawer-show="true"
                                    data-kt-drawer-target="#kt_drawer_chat">Nhắn Tin</button>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-xxl-4">

                        <div class="card">

                            <div class="card-body d-flex flex-center flex-column p-9">

                                <div class="mb-5">

                                    <div class="symbol symbol-75px symbol-circle">
                                        <img alt="Pic"
                                            src="https://freenice.net/wp-content/uploads/2021/10/hinh-anh-avatar-che-mat.jpg" />
                                    </div>

                                </div>


                                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Lâm Nhật
                                    Huy</a>


                                <div class="fw-bold text-gray-400 mb-6">Nhân Viên Mua Hàng</div>


                                <div class="d-flex flex-center mb-5">

                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-1 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Số Điện Thoại</div>
                                        <div class="fw-bold text-gray-400">0945567048</div>
                                    </div>


                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 mx-1 px-4 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Email</div>
                                        <div class="fw-bold text-gray-400">lphdev04@gmail.com</div>
                                    </div>

                                </div>


                                <button class="btn btn-sm btn-light-primary fw-bolder" data-kt-drawer-show="true"
                                    data-kt-drawer-target="#kt_drawer_chat">Nhắn Tin</button>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-xxl-4">

                        <div class="card">

                            <div class="card-body d-flex flex-center flex-column p-9">

                                <div class="mb-5">

                                    <div class="symbol symbol-75px symbol-circle">
                                        <img alt="Pic"
                                            src="https://freenice.net/wp-content/uploads/2021/10/hinh-anh-avatar-che-mat.jpg" />
                                    </div>

                                </div>


                                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Nguyễn Quốc
                                    Huy</a>


                                <div class="fw-bold text-gray-400 mb-6">Nhân Viên Kho</div>


                                <div class="d-flex flex-center mb-5">

                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-1 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Số Điện Thoại</div>
                                        <div class="fw-bold text-gray-400">0945567048</div>
                                    </div>


                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 mx-1 px-4 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Email</div>
                                        <div class="fw-bold text-gray-400">lphdev04@gmail.com</div>
                                    </div>

                                </div>


                                <button class="btn btn-sm btn-light-primary fw-bolder" data-kt-drawer-show="true"
                                    data-kt-drawer-target="#kt_drawer_chat">Nhắn Tin</button>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-xxl-4">

                        <div class="card">

                            <div class="card-body d-flex flex-center flex-column p-9">

                                <div class="mb-5">

                                    <div class="symbol symbol-75px symbol-circle">
                                        <img alt="Pic"
                                            src="https://freenice.net/wp-content/uploads/2021/10/hinh-anh-avatar-che-mat.jpg" />
                                    </div>

                                </div>


                                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Phạm Anh
                                    Hoài</a>


                                <div class="fw-bold text-gray-400 mb-6">Nhân Viên Kho</div>


                                <div class="d-flex flex-center mb-5">

                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-1 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Số Điện Thoại</div>
                                        <div class="fw-bold text-gray-400">0945567048</div>
                                    </div>


                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 mx-1 px-4 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Email</div>
                                        <div class="fw-bold text-gray-400">lphdev04@gmail.com</div>
                                    </div>

                                </div>


                                <button class="btn btn-sm btn-light-primary fw-bolder" data-kt-drawer-show="true"
                                    data-kt-drawer-target="#kt_drawer_chat">Nhắn Tin</button>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-xxl-4">

                        <div class="card">

                            <div class="card-body d-flex flex-center flex-column p-9">

                                <div class="mb-5">

                                    <div class="symbol symbol-75px symbol-circle">
                                        <img alt="Pic"
                                            src="https://freenice.net/wp-content/uploads/2021/10/hinh-anh-avatar-che-mat.jpg" />
                                    </div>

                                </div>


                                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Lê Nhựt
                                    Thái</a>


                                <div class="fw-bold text-gray-400 mb-6">Nhân Viên Kho</div>


                                <div class="d-flex flex-center mb-5">

                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mx-1 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Số Điện Thoại</div>
                                        <div class="fw-bold text-gray-400">0945567048</div>
                                    </div>


                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 mx-1 px-4 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700">Email</div>
                                        <div class="fw-bold text-gray-400">lphdev04@gmail.com</div>
                                    </div>

                                </div>


                                <button class="btn btn-sm btn-light-primary fw-bolder" data-kt-drawer-show="true"
                                    data-kt-drawer-target="#kt_drawer_chat">Nhắn Tin</button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- <div class="d-flex justify-content-between flex-wrap pt-10">
                <div class="fs-6 fw-bold text-gray-700">Showing 1 to 10 of 50 entries</div>

                <ul class="pagination">
                    <li class="page-item previous">
                        <a href="#" class="page-link">
                            <i class="previous"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a href="#" class="page-link">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">2</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">3</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">4</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">5</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">6</a>
                    </li>
                    <li class="page-item next">
                        <a href="#" class="page-link">
                            <i class="next"></i>
                        </a>
                    </li>
                </ul>

            </div> --}}

            </div>

        </div>
    @endsection
