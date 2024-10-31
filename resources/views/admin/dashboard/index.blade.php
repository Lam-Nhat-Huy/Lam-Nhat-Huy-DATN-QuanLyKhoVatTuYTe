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
        <div class="row gy-5 g-xl-8">
            <!--begin::Col-->
            <div class="col-xxl-12">
                <!--begin::Mixed Widget 2-->
                <div class="card card-xxl-stretch">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-5">
                        <h3 class="card-title fw-bolder text-white">Thông Tin Thống Kê</h3>
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
                                <div class="bg-light-warning px-6 py-8 rounded-2 me-7 mb-7 flex-fill col-md-3">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
                                            <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5"
                                                fill="black" />
                                            <rect x="18" y="11" width="3" height="8" rx="1.5"
                                                fill="black" />
                                            <rect x="3" y="13" width="3" height="6" rx="1.5"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <a href="#" class="text-warning fw-bold fs-6">Số lượng nhập tháng
                                        {{ now()->format('m') }}: <span>{{ $importTotal }} thiết bị</span></a>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="bg-light-danger px-6 py-8 rounded-2 me-7 mb-7 flex-fill col-md-3">
                                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                    <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                                                fill="black" />
                                            <path
                                                d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <a href="#" class="text-danger fw-bold fs-6">Số lượng xuất tháng
                                        {{ now()->format('m') }}: <span>{{ $exportTotal }}</span></a>
                                </div>

                                <!--end::Col-->
                                <div class="bg-light-success  px-6 py-8 rounded-2 me-7 mb-7 flex-fill col-md-3">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z"
                                                fill="black"></path>
                                            <path opacity="0.3"
                                                d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z"
                                                fill="black"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <a href="#" class="text-success fw-bold fs-6">Tổng chi tháng
                                        {{ now()->format('m') }}: {{ number_format($expenseTotal, 0, ',', '.') }} VNĐ</a>
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
            <!--end::Col-->
            <!-- Cảnh Báo Tồn Kho Thấp Column -->
            <div class="mb-5">

            </div>
            <div class="mb-5">

            </div>
  
            <div class="col-xxl-6 mb-5">
                <div class="card card-xxl-stretch h-100 shadow-sm">
                    <!-- Header -->
                    <div class="card-header align-items-center bg-warning border-0 rounded d-flex justify-content-between">
                        <h3 class="card-title fw-bolder text-dark fs-4 d-flex align-items-center">
                            <i class="fa fa-exclamation-circle me-2 text-danger"></i>
                            Cảnh Báo Tồn Kho Thấp
                        </h3>
                        <span class="text-danger fw-bold fs-6">{{ $warnings->total() }} sản phẩm</span>
                    </div>
                    <!-- Body -->
                    <div class="card-body pt-5 d-flex flex-column justify-content-between">
                        <div class="timeline-label flex-grow-1">
                            @foreach ($warnings as $warning)
                                <div class="timeline-item mb-3 border-bottom pb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <!-- Icon đồng hồ và giờ -->
                                        <i class="fa fa-clock text-muted fs-5 me-2"></i>
                                        <span class="fw-bolder text-gray-800 fs-6">{{ now()->format('H:i') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <!-- Icon cảnh báo và nội dung -->
                                        <div class="timeline-badge d-flex align-items-center">
                                            <i class="fa fa-exclamation-triangle text-warning fs-3"></i>
                                        </div>
                                        <div class="fw-normal timeline-content text-muted ps-3">
                                            Sản phẩm {{ $warning->equipments->name }} (Mã SP: {{ $warning->code }}) chỉ
                                            còn
                                            {{ $warning->current_quantity }} đơn vị trong kho.
                                            @if ($warning->current_quantity <= 0)
                                                <span class="text-danger">Hết hàng</span>.
                                            @else
                                                <span class="text-warning">Gần hết hàng</span>.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <ul class="pagination pagination-lg tk">
                                {{ $warnings->appends(['export_log_page' => request('export_log_page')])->links('pagination::bootstrap-4') }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!--end::Col-->
            <!-- Nhật ký xuất kho Column -->
            <div class="col-xxl-6 mb-5">
                <div class="card card-xxl-stretch h-100 shadow-sm">
                    <!-- Header -->
                    <div class="card-header bg-primary text-white border-0 rounded align-items-center">
                        <h3 class="card-title fw-bolder fs-4 d-flex align-items-center">
                            <i class="fa fa-box-open me-2"></i> Nhật Ký Xuất Kho
                        </h3>
                    </div>
                    <!-- Body -->
                    <div class="card-body pt-2 d-flex flex-column justify-content-between">
                        @if ($exportLog->isEmpty())
                            <div class="text-center text-muted">Không có nhật ký xuất kho</div>
                        @else
                            <div class="flex-grow-1">
                                @foreach ($exportLog as $export)
                                    <div
                                        class="d-flex align-items-center mb-4 border-bottom pb-3 {{ $loop->index % 2 == 0 ? 'bg-light' : '' }}">
                                        <span
                                            class="bullet bullet-vertical h-40px bg-{{ $loop->index % 2 == 0 ? 'warning' : 'primary' }}"></span>
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <i class="fa fa-check-circle text-success fs-3"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Xuất
                                                hàng theo đơn {{ $export->code }}</a>
                                            <span
                                                class="text-muted fw-bold d-block">{{ \Carbon\Carbon::parse($export->export_date)->format('d/m/Y H:i') }}</span>
                                            @foreach ($export->exportDetail as $detail)
                                                <span>Sản phẩm: {{ $detail->equipments->name }} - Số lượng:
                                                    {{ $detail->quantity }}</span><br>
                                            @endforeach
                                        </div>
                                        <span
                                            class="badge badge-light-{{ $loop->index % 2 == 0 ? 'warning' : 'primary' }} fs-8 fw-bolder">Mới</span>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                <ul class="pagination pagination-lg nk">
                                    {{ $exportLog->appends(['low_inventory_page' => request('low_inventory_page')])->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-5">

            </div>
            <div class="col-xxl-6 mb-5">
                <div class="card card-xxl-stretch h-100 shadow-lg">
                    <!-- Header -->
                    <div class="card-header bg-success text-white border-0 rounded align-items-center">
                        <h3 class="card-title fw-bolder fs-4 d-flex align-items-center">
                            <i class="fa fa-arrow-circle-down me-2"></i> Thống Kê Nhập Kho Chi Tiết
                        </h3>
                    </div>
                    <!-- Body -->
                    <div class="card-body pt-2">
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-light-success px-6 py-8 rounded-2 shadow-sm text-center">
                                    <i class="fa fa-box fs-2 text-success mb-3"></i>
                                    <h4 class="fw-bold text-success">Số lượng nhập tháng {{ now()->format('m') }}</h4>
                                    <span class="fs-5">{{ $importTotal }} thiết bị</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light-info px-6 py-8 rounded-2 shadow-sm text-center">
                                    <i class="fa fa-dollar-sign fs-2 text-info mb-3"></i>
                                    <h4 class="fw-bold text-info">Giá trị nhập tháng {{ now()->format('m') }}</h4>
                                    <span class="fs-5">{{ number_format($expenseTotal, 0, ',', '.') }} VNĐ</span>
                                </div>
                            </div>
                        </div>
                        <!-- Data Table -->
                        @if($importStatistics->isEmpty())
                            <div class="text-center text-muted">Không có dữ liệu nhập kho</div>
                        @else
                            <table class="table table-striped table-hover border shadow-sm">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th>Tháng</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-end">Giá trị tổng (VNĐ)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($importStatistics as $stat)
                                        <tr>
                                            <td>{{ str_pad($stat->month, 2, '0', STR_PAD_LEFT) }}</td>
                                            <td class="text-center">{{ $stat->total_quantity }} thiết bị</td>
                                            <td class="text-end">{{ number_format($stat->total_value, 2, ',', '.') }} VNĐ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 mb-5">
                <div class="card card-xxl-stretch h-100 shadow-sm">
                    <!-- Header -->
                    <div class="card-header bg-light-warning text-white border-0 rounded align-items-center">
                        <h3 class="card-title fw-bolder fs-4 d-flex align-items-center">
                            <i class="fa fa-clipboard-check me-2"></i> Nhật Ký Kiểm Kho
                        </h3>
                    </div>
                    <!-- Body -->
                    <div class="card-body pt-2 d-flex flex-column justify-content-between">
                        @if($inventoryCheckLog->isEmpty())
                            <div class="text-center text-muted">Không có nhật ký kiểm kho</div>
                        @else
                            @foreach($inventoryCheckLog as $check)
                                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                                    <span class="bullet bullet-vertical h-40px"></span>
                                    <div class="form-check form-check-custom form-check-solid mx-5">
                                        <i class="fa fa-check-circle text-success fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">
                                            Mã Kiểm Kho: {{ $check->code }}
                                        </a>
                                        <span class="text-muted fw-bold d-block">
                                            Ngày Kiểm: {{ $check->created_at }}
                                        </span>
                                        <span>Người Kiểm: {{ $check->user->last_name ?? '' }} {{ $check->user->first_name ?? 'Không xác định' }} </span><br>

                                    </div>
                                    <span class="badge fs-8 fw-bolder">{{ $check->status }}</span>
                                </div>
                            @endforeach
                        @endif
            
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $inventoryCheckLog->appends(['low_inventory_page' => request('low_inventory_page')])->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5 mt-5 mb-xl-8" style="padding: 0 25px">
            <!--begin::Col-->
            <div class="col-xxl-6">
                <div class="card mb-5 mb-xl-8 shadow-sm border-0">
                    <div class="chart-container p-4">
                        <h2 class="chart-title text-center mb-4">Biểu đồ tồn kho theo thời gian</h2>
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-xxl-6 mx-auto">
                <div class="card mb-5 mb-xl-8 shadow-sm border-0">
                    <div class="forecast-container p-4">
                        <h2 class="forecast-title text-center mb-4">Dự Báo Tồn Kho Tương Lai</h2>
                        <canvas id="forecastChart" width="400" height="200"></canvas>
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
                        "{{ date('F', mktime(0, 0, 0, $data->month, 10)) }}",
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
                                return `Số lượng: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
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
            var forecastData = @json($forecastTrendData);
            var ctx = document.getElementById('forecastChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: forecastData.map(item => item.month),
                    datasets: [{
                        label: 'Dự báo tồn kho',
                        data: forecastData.map(item => item.inventory),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
