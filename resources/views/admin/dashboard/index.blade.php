@extends('master_layout.layout')

@section('styles')
    <style>
      .container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .chart-container {
            width: 100%;
            margin-top: 20px;
        }

        .alert-wrapper {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 20px;
        }

        .alert-container {
            width: 48%;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
        }

        .high-alert-container {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
        }

        .alert-list li {
            font-weight: bold;
        }

        .forecast-container {
            margin-top: 40px;
        }

        .forecast-container canvas,
        .chart-container canvas {
            width: 100%;
            height: 400px;
        }

        .card-body {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card-body input[type="date"],
        .card-body select,
        .card-body input[type="search"],
        .card-body button {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="card mb-5 mb-xl-12">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Tồn Kho</span>
                <span class="text-muted mt-1 fw-bold fs-7">2 Vật Tư Mới Nhất</span>
            </h3>
            <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-light-primary">
                    <span class="align-items-center d-flex">
                        Xem Tất Cả Kho
                        <i class="fa fa-arrow-right ms-2"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-1 text-center">
            @php
                use Carbon\Carbon;
            @endphp

            <input type="date" name="date_first" class="me-3 mt-2 mb-2"
                value="{{ Carbon::now()->subMonth()->format('Y-m-d') }}">

            <span class="me-3 mt-2 mb-2">Đến</span>

            <input type="date" name="date_last" class="me-3 mt-2 mb-2" value="{{ Carbon::now()->format('Y-m-d') }}">

            <select name="" id="" class="me-3 mt-2 mb-2">
                <option value="0" selected>Theo Nhóm Vật Tư</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>

            <select name="" id="" class="me-3 mt-2 mb-2">
                <option value="0" selected>Theo Nhà Cung Cấp</option>
                <option value="">A</option>
                <option value="">B</option>
                <option value="">C</option>
            </select>

            <input type="search" name="search" placeholder="Tìm Kiếm..." class="me-3 mt-2 mb-2">

            <button class="btn btn-dark btn-sm me-3 mt-2 mb-2">In Phiếu</button>

            <button class="btn btn-success btn-sm">Xuất Excel</button>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="ps-4 rounded-start">Mã VT</th>
                            <th class="">Tên VT</th>
                            <th class="">ĐVT</th>
                            <th class="">Số Lô</th>
                            <th class="">Hạn Dùng</th>
                            <th class="">Giá Nhập</th>
                            <th class="">Tồn Đầu</th>
                            <th class="">TT Tồn Đầu</th>
                            <th class="">Tổng Nhập</th>
                            <th class="">Tổng Xuất</th>
                            <th class="">Tồn Cuối</th>
                            <th class="rounded-end">TT Tồn Cuối</th>
                        </tr>
                    </thead>
                    <thead id="thead_2">
                        <tr>
                            <th colspan="6" class="ps-4 fw-bold" id="thead_th_1">Số Lượng Vật Tư: 2</th>
                            <th>2</th>
                            <th>2</th>
                            <th>2</th>
                            <th>1</th>
                            <th>1</th>
                            <th>1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                            <td>#03941384</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="chart-container">
            <h2>Biểu đồ tồn kho theo thời gian</h2>
            <canvas id="inventoryChart"></canvas>
        </div>

        <div class="alert-wrapper">
            <div class="alert-container">
                <h2>Cảnh báo tồn kho thấp</h2>
                <ul id="lowAlertList" class="alert-list">
                    <!-- Low stock alerts will be dynamically inserted here -->
                </ul>
            </div>

            <div class="alert-container high-alert-container">
                <h2>Cảnh báo tồn kho cao</h2>
                <ul id="highAlertList" class="alert-list">
                    <!-- High stock alerts will be dynamically inserted here -->
                </ul>
            </div>
        </div>
    </div>
    <div class="forecast-container">
        <h2>Dự Báo Tồn Kho Tương Lai</h2>
        <canvas id="forecastChart"></canvas>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
            // Inventory Chart data and configuration
            const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Tồn Kho',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const ctx = document.getElementById('inventoryChart').getContext('2d');
            new Chart(ctx, config);

            // Low Stock Alerts
            const lowAlerts = [
                { text: 'Vật tư A đã đạt ngưỡng thấp', quantity: 5 },
                { text: 'Vật tư B sắp hết hàng', quantity: 2 }
            ];

            const lowAlertList = document.getElementById('lowAlertList');
            lowAlerts.forEach(alert => {
                const li = document.createElement('li');
                li.textContent = `${alert.text} (${alert.quantity} items)`;
                li.style.color = '#721c24';
                lowAlertList.appendChild(li);
            });

            // High Stock Alerts
            const highAlerts = [
                { text: 'Vật tư C vượt mức tồn kho tối đa', quantity: 100 },
                { text: 'Vật tư D tồn kho cao bất thường', quantity: 150 }
            ];

            const highAlertList = document.getElementById('highAlertList');
            highAlerts.forEach(alert => {
                const li = document.createElement('li');
                li.textContent = `${alert.text} (${alert.quantity} items)`;
                li.style.color = '#856404';
                highAlertList.appendChild(li);
            });
        });

        const forecastLabels = @json(array_column($forecastData, 'month'));
        const forecastValues = @json(array_column($forecastData, 'inventory'));

        const forecastData = {
            labels: forecastLabels,
            datasets: [{
                label: 'Dự Báo Tồn Kho',
                data: forecastValues,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        };

        const forecastConfig = {
            type: 'line',
            data: forecastData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const forecastCtx = document.getElementById('forecastChart').getContext('2d');
        new Chart(forecastCtx, forecastConfig);
    </script>
@endsection

@section('scripts')
@endsection
