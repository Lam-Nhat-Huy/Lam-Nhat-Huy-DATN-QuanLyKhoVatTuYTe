@extends('master_layout.layout')

@section('styles')
    <style>
        #notification_content p {
            font-size: 14px;
        }

        /* Áp dụng chỉ cho phân trang có class nk (Nhật ký xuất kho) */
        .pagination.nk .page-link {
            color: #fff;
            /* Màu chữ trắng */
            background-color: #28a745;
            /* Màu nền xanh lá */
            border-color: #28a745;
            /* Viền xanh lá */
        }

        .pagination.nk .page-link:hover {
            background-color: #218838;
            /* Màu xanh lá đậm hơn khi hover */
            border-color: #1e7e34;
        }

        .pagination.nk .page-item.active .page-link {
            background-color: #218838;
            /* Màu xanh lá đậm cho nút đang được chọn */
            border-color: #1e7e34;
            color: #fff;
            /* Màu chữ trắng */
        }

        /* Áp dụng chỉ cho phân trang có class nk (Nhật ký xuất kho) */
        .pagination.tk .page-link {
            color: #fff;
            /* Màu chữ trắng */
            background-color: #a79428;
            /* Màu nền xanh lá */
            border-color: #a79428;
            /* Viền xanh lá */
        }

        .pagination.tk .page-link:hover {
            background-color: #a79428;
            /* Màu xanh lá đậm hơn khi hover */
            border-color: #a79428;
        }

        .pagination.tk .page-item.active .page-link {
            background-color: #a79428;
            /* Màu xanh lá đậm cho nút đang được chọn */
            border-color: #a79428;
            color: #fff;
            /* Màu chữ trắng */
        }
    </style>
    <!-- Tải jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tải Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    @if (!empty($getImportantNotification))
        {{-- Modal Thông Báo Quan Trọng --}}
        <div class="modal fade" id="importantNotificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="DetailModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h3 class="modal-title text-danger" id="DetailModal">BEESOFT THÔNG BÁO</h3>
                    </div>
                    <div class="modal-body text-center" id="notification_content">
                        {!! $getImportantNotification->content !!}
                    </div>
                    <div class="modal-footer">
                        <button class="position-absolute btn btn-sm btn-warning m-0 py-2 px-3" style="left: 30px;"
                            title="Đọc Văn Bản">
                            <i id="speaker-icon" class="fa-solid fa-volume-high text-dark" onclick="speak()"
                                style="font-size: 18px;"></i>
                            <img id="speaker-gif" class="d-none" src="{{ asset('image/speaker.gif') }}"
                                style="width: 27px; height: 18px;" alt="" onclick="cancelSpeak()">
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function cancelSpeak() {
                window.speechSynthesis.cancel();
                document.getElementById('speaker-icon').classList.remove('d-none'); // Hiện icon lại
                document.getElementById('speaker-gif').classList.add('d-none'); // Ẩn gif đi
            }

            function speak() {
                window.speechSynthesis.cancel();
                var content = document.getElementById('notification_content').innerText;
                var msg = new SpeechSynthesisUtterance();
                msg.text = content;
                msg.lang = 'vi-VN'; // Chọn ngôn ngữ, ở đây là tiếng Việt
                msg.rate = 0.8; // Tốc độ đọc
                msg.pitch = 1.5; // Cao độ giọng nói

                // Khi bắt đầu nói
                msg.onstart = function() {
                    document.getElementById('speaker-icon').classList.add('d-none'); // Ẩn icon
                    document.getElementById('speaker-gif').classList.remove('d-none'); // Hiện gif
                };

                // Khi kết thúc nói
                msg.onend = function() {
                    document.getElementById('speaker-icon').classList.remove('d-none'); // Hiện icon lại
                    document.getElementById('speaker-gif').classList.add('d-none'); // Ẩn gif đi
                };

                // Bắt đầu đọc giọng nói
                window.speechSynthesis.speak(msg);
            }

            $(document).ready(function() {
                $('#importantNotificationModal').modal('show');
            });
        </script>
    @endif
    <div class="card mb-5 mb-xl-8">
        <div class="gy-5 g-xl-8">

            <div class="col-xxl-12">
                <!--begin::Mixed Widget 2-->
                <div class="card card-xxl-stretch">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-5">
                        <h5 class="card-title fw-bolder text-white">THÔNG TIN THỐNG KÊ</h5>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Chart-->
                        <div class="mixed-widget-2-chart card-rounded-bottom bg-danger" data-kt-color="danger"
                            style="height: 110px"></div>
                        <!--end::Chart-->
                        <!--begin::Stats-->
                        <div class="card-p mt-n20 position-relative" style="padding-bottom: 0px !important">
                            <!--begin::Row-->
                            <div class="d-flex justify-content-between flex-wrap">
                                <!--begin::Col-->
                                <div class="px-6 py-8 rounded-2 mx-2 mb-5 flex-fill col-md-3 shadow"
                                    style="background-image: linear-gradient(-225deg, #FF057C 0%, #8D0B93 50%, #321575 100%);">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block my-3 mb-5">
                                        <i class="fa fa-download text-white" style="font-size: 30px;"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <span class="text-white fw-bold fs-6">SỐ LƯỢNG NHẬP THÁNG
                                        {{ now()->format('m') }}: <span>{{ $importTotal }}</span> THIẾT BỊ</span>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="px-6 py-8 rounded-2 mx-2 mb-5 flex-fill col-md-3 shadow"
                                    style="background-image: linear-gradient(-225deg, #FF057C 0%, #8D0B93 50%, #321575 100%);">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block my-3 mb-5">
                                        <i class="fa fa-upload text-white" style="font-size: 30px;"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <span class="text-white fw-bold fs-6">SỐ LƯỢNG XUẤT THÁNG
                                        {{ now()->format('m') }}: <span>{{ $exportTotal }}</span> THIẾT BỊ</span>
                                </div>

                                <!--end::Col-->
                                <div class="px-6 py-8 rounded-2 mx-2 mb-5 flex-fill col-md-3 shadow"
                                    style="background-image: linear-gradient(-225deg, #FF057C 0%, #8D0B93 50%, #321575 100%);">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block my-3 mb-5">
                                        <i class="fa fa-credit-card text-white" style="font-size: 30px;"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <span class="text-white fw-bold fs-6">TỔNG CHI THÁNG
                                        {{ now()->format('m') }}:
                                        <span>{{ number_format($expenseTotal, 0, ',', '.') }}</span> VND</span>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 2-->
            </div>

            <div class="row align-items-start px-14">
                <div class="col-md-6 col-lg-6 col-sm-12 mb-5">
                    <div class="card card-xxl-stretch h-100 shadow">
                        <!-- Header -->
                        <div class="card-header border-0 rounded align-items-center"
                            style="background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);">
                            <h5 class="card-title fw-bolder text-white fs-5 d-flex align-items-center">
                                NHẬT KÝ KIỂM KHO
                            </h5>
                        </div>
                        <!-- Body -->
                        <div class="card-body pt-3 d-flex flex-column justify-content-between pb-0 px-3">
                            @if ($inventoryCheckLog->isEmpty())
                                <div class="text-center text-muted">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4 mb-0"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không Có Dữ
                                                Liệu
                                            </h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Không Có Lịch Sử Kiểm Kho Nào
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach ($inventoryCheckLog as $check)
                                    <div class="d-flex align-items-center mt-1 mb-1 border-bottom pb-3">
                                        <span
                                            class="bullet bullet-vertical h-40px bg-{{ $loop->index % 2 == 0 ? 'warning' : 'primary' }}"></span>
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <i class="fa fa-check-circle text-success fs-3"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="text-gray-800 text-hover-primary fw-bolder fs-6">
                                                Mã kiểm kho: <a
                                                    class="text-gray-800 text-hover-primary fw-bolder fs-6 mb-1 text-decoration-underline"
                                                    href="{{ route('check_warehouse.index') }}?kw={{ $check->code }}">#{{ $check->code }}</a>
                                            </h6>
                                            <span class="text-muted fw-bold d-block mb-1">
                                                Ngày kiểm: {{ $check->created_at->format('d-m-Y H:i:s') }}
                                            </span>
                                            <span class="text-muted fw-bold mb-1">
                                                Người kiểm lần 1:
                                                <strong>{{ $check->user->last_name ?? '' }}</strong>
                                                <strong>{{ $check->user->first_name ?? 'Chưa kiểm lần 1' }}</strong>
                                            </span>
                                            <span class="text-muted fw-bold">
                                                - Người kiểm lần 2:
                                                <strong>{{ $check->recheckUser->last_name ?? '' }}</strong>
                                                <strong>{{ $check->recheckUser->first_name ?? 'Chưa kiểm lần 2' }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center my-3">
                                <ul class="pagination pagination-lg nk">
                                    {{ $inventoryCheckLog->appends(['low_inventory_page' => request('low_inventory_page')])->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-sm-12 mb-5">
                    <div class="card card-xxl-stretch h-100 shadow">
                        <!-- Header -->
                        <div class="card-header border-0 rounded align-items-center"
                            style="background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);">
                            <h5 class="card-title fw-bolder text-white fs-5 d-flex align-items-center">
                                NHẬT KÝ XUẤT KHO
                            </h5>
                        </div>
                        <!-- Body -->
                        <div class="card-body pt-3 d-flex flex-column justify-content-between pb-0 px-3">
                            @if ($exportLog->isEmpty())
                                <div class="text-center text-muted">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4 mb-0"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không Có Dữ
                                                Liệu
                                            </h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Không Có Lịch Sử Xuất Kho Nào
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach ($exportLog as $export)
                                    <div class="d-flex align-items-center mt-1 mb-1 border-bottom pb-3">
                                        <span
                                            class="bullet bullet-vertical h-40px bg-{{ $loop->index % 2 == 0 ? 'warning' : 'primary' }}"></span>
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <i class="fa fa-check-circle text-success fs-3"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="text-gray-800 fw-bolder fs-6 mb-1">
                                                Xuất hàng theo đơn
                                                <a class="text-gray-800 fw-bolder fs-6 mb-1 text-hover-primary text-decoration-underline"
                                                    href="{{ route('warehouse.export') }}?kw={{ $export->code }}">#{{ $export->code }}
                                                </a>
                                                @if ($export->export_type == 'Xuất Hủy')
                                                    <span class="float-end"
                                                        style="color: #FF4D4D; font-weight: normal; font-size: 12px;">Xuất
                                                        hủy</span>
                                                    {{-- Màu đỏ đậm --}}
                                                @elseif ($export->export_type == 'Xuất Trả')
                                                    <span class="float-end"
                                                        style="color: #4D79FF; font-weight: normal; font-size: 12px;">Xuất
                                                        trả</span>
                                                    {{-- Màu xanh dương nhạt --}}
                                                @elseif ($export->export_type == 'Xuất Sử Dụng')
                                                    <span class="float-end"
                                                        style="color: #4CAF50; font-weight: normal; font-size: 12px;">Xuất
                                                        sử dụng</span>
                                                    {{-- Màu xanh lá --}}
                                                @elseif ($export->export_type == 'Xuất cân bằng kho')
                                                    <span class="float-end"
                                                        style="color: #FF9800; font-weight: normal; font-size: 12px;">Xuất
                                                        cân bằng
                                                    </span> {{-- Màu cam --}}
                                                @endif


                                            </h6>
                                            <span class="text-muted fw-bold d-block mb-1">Ngày xuất:
                                                {{ \Carbon\Carbon::parse($export->created_at)->format('d/m/Y H:i:s') }}</span>
                                            @foreach ($export->exportDetail as $key => $detail)
                                                <span>{{ $key + 1 }}. {{ $detail->equipments->name }} -
                                                    Số lô:
                                                    <strong>{{ $detail->batch_number }}</strong></span> - <span>Số
                                                    lượng:
                                                    <strong>{{ $detail->quantity }}</strong></span><br>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center my-3">
                                <ul class="pagination pagination-lg nk">
                                    {{ $exportLog->appends(['low_inventory_page' => request('low_inventory_page')])->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-start px-14">
                <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                    <div class="card card-xxl-stretch h-100 shadow">
                        <!-- Header -->
                        <div class="card-header align-items-center border-0 rounded d-flex justify-content-between"
                            style="background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);">
                            <h5 class="card-title fw-bolder text-white fs-5 d-flex align-items-center">
                                CẢNH BÁO TỒN KHO THẤP
                            </h5>
                            <span class="text-white fw-bold fs-6"><strong>{{ $warnings->total() }}</strong> Thiết
                                Bị</span>
                        </div>
                        <!-- Body -->
                        <div class="card-body pt-3 d-flex flex-column justify-content-between pb-0 px-5">
                            @forelse ($warnings as $warning)
                                <div class="d-flex align-items-center mt-1 mb-1 border-bottom pb-3">
                                    <div class="d-flex align-items-center mt-2">
                                        <!-- Icon cảnh báo và nội dung -->
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-exclamation-triangle text-danger fs-3 me-1"></i>
                                        </div>
                                        <div class="fw-normal text-muted ps-3">
                                            Thiết bị <strong>{{ $warning->equipments->name }}</strong>
                                            (Mã:
                                            <strong>{{ $warning->code }}</strong>)
                                            số lô <strong>{{ $warning->batch_number }}</strong>
                                            chỉ
                                            còn
                                            <strong>{{ $warning->current_quantity }}</strong> đơn vị trong kho.
                                            @if ($warning->current_quantity <= 0)
                                                <span style="color: red; font-weight: bold;">Đã hết hàng</span>.
                                            @else
                                                <span style="color: rgb(0, 145, 255); font-weight: bold;">Sắp hết
                                                    hàng</span>.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4 mb-0"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fas fa-file-invoice" style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">Không Có Dữ
                                                Liệu
                                            </h5>
                                            <p style="font-size: 14px; color: #6c757d; margin: 0;">
                                                Không Có Thiết Bị Nào Đang Tồn Kho Thấp
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center my-3">
                                <ul class="pagination pagination-lg nk">
                                    {{ $warnings->appends(['export_log_page' => request('export_log_page')])->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                    <div class="card card-xxl-stretch h-100 shadow-lg">
                        <!-- Header -->
                        <div class="card-header text-white border-0 rounded align-items-center"
                            style="background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);">
                            <h5 class="card-title fw-bolder text-white fs-5 d-flex align-items-center">
                                THỐNG KÊ NHẬP KHO CHI TIẾT
                            </h5>
                        </div>
                        <!-- Body -->
                        <div class="card-body py-2 px-4">
                            <!-- Summary Cards -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 my-1">
                                    <div class="px-6 py-8 rounded-2 shadow-sm text-center"
                                        style="background-image: linear-gradient(60deg, #3d3393 0%, #2b76b9 37%, #2cacd1 65%, #35eb93 100%);">
                                        <i class="fa fa-box fs-2 text-white mb-3"></i>
                                        <h4 class="fw-bold text-white">Số lượng nhập tháng {{ now()->format('m') }}</h4>
                                        <span class="fs-5 text-white">{{ $importTotal }} thiết bị <span class="pointer"
                                                data-bs-toggle="modal" data-bs-target="#detail_import"><i
                                                    class="fa fa-eye text-white ms-1"></i></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 my-1">
                                    <div class="px-6 py-8 rounded-2 shadow-sm text-center"
                                        style="background-image: linear-gradient(60deg, #3d3393 0%, #2b76b9 37%, #2cacd1 65%, #35eb93 100%);">
                                        <i class="fa fa-dollar-sign fs-2 text-white mb-3"></i>
                                        <h4 class="fw-bold text-white">Tổng chi tháng {{ now()->format('m') }}</h4>
                                        <span class="fs-5 text-white">{{ number_format($expenseTotal, 0, ',', '.') }}
                                            VND</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal --}}
                            <div class="modal fade" id="detail_import" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="detail_importModal"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header text-white"
                                            style="background-image: linear-gradient(60deg, #3d3393 0%, #2b76b9 37%, #2cacd1 65%, #35eb93 100%);">
                                            <h5 class="modal-title text-white" id="detail_importModal">DANH SÁCH THIẾT BỊ
                                                NHẬP
                                                THÁNG {{ now()->format('m') }}</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center" style="height: 400px; overflow-y: auto;">
                                            <table class="table table-striped table-hover border shadow-sm">
                                                <thead class="bg-dark text-white fw-bolder">
                                                    <tr>
                                                        <th class="ps-5 text-center" style="width: 25%;">Thiết bị</th>
                                                        <th class="text-center">Lô</th>
                                                        <th class="text-center">Giá</th>
                                                        <th class="text-center">SL</th>
                                                        <th class="text-center">CK</th>
                                                        <th class="text-center">VAT</th>
                                                        <th class="text-center pe-5">Tổng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_last = 0;
                                                    @endphp
                                                    @forelse ($getEquipmentImportMonth as $item)
                                                        @php
                                                            $total_before_discount = $item->price * $item->quantity;
                                                            $discount_amount =
                                                                ($total_before_discount * $item->discount) / 100;
                                                            $total_after_discount =
                                                                $total_before_discount - $discount_amount;
                                                            $vat_amount = ($total_after_discount * $item->VAT) / 100;
                                                            $total_after_discount_and_vat =
                                                                $total_after_discount + $vat_amount;

                                                            $total_last += $total_after_discount_and_vat;
                                                        @endphp
                                                        <tr>
                                                            <td class="ps-5 text-center">{{ $item->equipments->name }}
                                                            </td>
                                                            <td class="text-center">{{ $item->batch_number }}</td>
                                                            <td class="text-center">
                                                                {{ number_format($item->price, 0, ',', '.') }} VND</td>
                                                            <td class="text-center">{{ $item->quantity }}</td>
                                                            <td class="text-center">{{ $item->discount }} %</td>
                                                            <td class="text-center">{{ $item->VAT }} %</td>
                                                            <td class="text-center pe-5">
                                                                {{ number_format($total_after_discount_and_vat, 0, ',', '.') }}
                                                                VND</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center">
                                                                <div class="text-center text-muted">
                                                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4 mb-0"
                                                                        role="alert"
                                                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                                                        <div class="mb-3">
                                                                            <i class="fas fa-file-invoice"
                                                                                style="font-size: 36px; color: #6c757d;"></i>
                                                                        </div>
                                                                        <div class="text-center">
                                                                            <h5
                                                                                style="font-size: 16px; font-weight: 600; color: #495057;">
                                                                                Không Có Dữ
                                                                                Liệu
                                                                            </h5>
                                                                            <p
                                                                                style="font-size: 14px; color: #6c757d; margin: 0;">
                                                                                Không Có Thiết Bị Nhập Nào Trong Tháng
                                                                                {{ now()->month }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    @if ($getEquipmentImportMonth)
                                                        <tr class="text-center"
                                                            style="font-weight: bold; background-color: #f8f9fa;">
                                                            <td colspan="1" class="text-left ps-5">Tổng Cộng:</td>
                                                            <td></td>
                                                            <td colspan="4"></td>
                                                            <td colspan="1" class="text-center pe-5">
                                                                {{ number_format($total_last, 0, ',', '.') }} VND
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer justify-content-center border-0">
                                            <button type="button"
                                                class="btn rounded-pill btn-sm btn-secondary btn-sm px-4"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5 mb-xl-8 mx-11">
            <!--begin::Col-->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card mb-5 mb-xl-8 border-0 shadow">
                    <div class="chart-container p-4">
                        <h5 class="chart-title text-center mb-4 fs-5 my-3">BIỂU ĐỒ TỒN KHO THEO THỜI GIAN</h5>
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                <div class="card mb-5 mb-xl-8 border-0 shadow">
                    <div class="forecast-container p-4">
                        <h5 class="forecast-title text-center mb-4 fs-5 my-3">THỐNG KÊ CHI PHÍ NHẬP HÀNG THEO THÁNG</h5>
                        <canvas id="expenseChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!--end::Col-->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($inventoryData as $data)
                        "Tháng {{ $data->month }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Tồn kho (Số lượng)',
                    data: [
                        @foreach ($inventoryData as $data)
                            {{ $data->total_quantity }},
                        @endforeach
                    ],
                    borderWidth: 3,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointRadius: 5,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return ` Số lượng: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Số lượng tồn kho'
                        }
                    }
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var monthlyExpenses = @json($monthlyImportExpenses);

            var months = monthlyExpenses.map(item => {
                return new Date(0, item.month - 1).toLocaleString('vi-VN', {
                    month: 'long'
                });
            });
            var expenses = monthlyExpenses.map(item => item.total_expense);

            var ctx = document.getElementById('expenseChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Chi phí nhập hàng theo tháng',
                        data: expenses,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'VND'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tháng'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
