@extends('master_layout.layout')

@section('styles')
    <style>
        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        function openExcel(url, previewId) {
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.blob();
                })
                .then(blob => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const data = new Uint8Array(e.target.result);
                        const workbook = XLSX.read(data, {
                            type: 'array'
                        });
                        const firstSheetName = workbook.SheetNames[0];
                        const worksheet = workbook.Sheets[firstSheetName];

                        // Bỏ 2 cột cuối
                        removeLastTwoColumns(worksheet);

                        // Chuyển đổi worksheet thành HTML
                        const html = XLSX.utils.sheet_to_html(worksheet);

                        // Cập nhật nội dung vào modal với ID duy nhất
                        const excelPreviewElement = document.getElementById(previewId);
                        excelPreviewElement.innerHTML = html;
                        excelPreviewElement.style.display = 'block';
                    };
                    reader.readAsArrayBuffer(blob);
                })
                .catch(error => console.error('Error fetching the Excel file:', error));
        }

        // Hàm để loại bỏ 2 cột cuối cùng
        function removeLastTwoColumns(worksheet) {
            const range = XLSX.utils.decode_range(worksheet['!ref']); // Lấy phạm vi của dữ liệu trong sheet
            const maxCol = range.e.c; // Cột cuối cùng

            // Duyệt qua tất cả các hàng
            for (let row = range.s.r; row <= range.e.r; row++) {
                // Xóa hai cột cuối cùng bằng cách xóa ô từ worksheet
                delete worksheet[XLSX.utils.encode_cell({
                    r: row,
                    c: maxCol
                })]; // Cột cuối cùng
                delete worksheet[XLSX.utils.encode_cell({
                    r: row,
                    c: maxCol - 1
                })]; // Cột kế cuối
            }

            // Cập nhật phạm vi của worksheet để không bao gồm hai cột cuối cùng
            range.e.c = maxCol - 2; // Giảm số cột cuối đi 2
            worksheet['!ref'] = XLSX.utils.encode_range(range); // Cập nhật phạm vi (range) mới
        }
    </script>
@endsection

@section('content')
    <div class="card mb-5 pb-5 mb-xl-8 shadow">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Lịch Sử Báo Giá</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('supplier.list') }}" class="btn rounded-pill btn-sm btn-dark me-2">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive rounded">
                <table class="table align-middle gs-0 gy-4">
                    <thead class="{{ $allQuoteHistory->count() == 0 ? 'd-none' : '' }}">
                        <tr class="fw-bolder bg-success">
                            <th style="width: 50% !important;" class="ps-3">Nhà Cung Cấp</th>
                            <th style="width: 20% !important;">Danh Sách Thiết Bị</th>
                            <th style="width: 15% !important;">Người Gửi</th>
                            <th style="width: 15% !important;">Ngày Gửi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allQuoteHistory as $item)
                            <tr class="text-center hover-table pointer">
                                <td class="text-xl-start text-truncate" style="max-width: 150px;">
                                    {{ $item->suppliers->name }}
                                </td>
                                <td class="text-xl-start text-truncate" style="max-width: 150px;">
                                    <a href="#" class="pointer" style="color: rgb(33, 64, 178);"
                                        data-bs-toggle="modal" data-bs-target="#openExcel_{{ $item->id }}"
                                        onclick="openExcel('{{ asset($item->file_excel) }}', 'excelPreview_{{ $item->id }}'); return false;">
                                        <i class="fa fa-eye me-1"></i>Xem
                                    </a>
                                </td>
                                <td class="text-xl-start text-truncate" style="max-width: 150px;">
                                    {{ !empty($item->users->last_name && $item->users->first_name) ? $item->users->last_name . ' ' . $item->users->first_name : 'N/A' }}
                                </td>
                                <td class="text-xl-start text-truncate" style="max-width: 150px;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataAlert">
                                <td colspan="12" class="text-center">
                                    <div class="alert alert-secondary d-flex flex-column align-items-center justify-content-center p-4"
                                        role="alert"
                                        style="border: 2px dashed #6c757d; background-color: #f8f9fa; color: #495057;">
                                        <div class="mb-3">
                                            <i class="fa-regular fa-clock-rotate-left"
                                                style="font-size: 36px; color: #6c757d;"></i>
                                        </div>
                                        <div class="text-center">
                                            <h5 style="font-size: 16px; font-weight: 600; color: #495057;">
                                                Không Có Yêu Cầu Báo Giá Nào
                                            </h5>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($allQuoteHistory as $item)
            <div class="modal fade" id="openExcel_{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="openExcelLabel_{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="openExcelLabel_{{ $item->id }}">Danh Sách</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="padding-bottom: 0px;">
                            <div id="excelPreview_{{ $item->id }}" style="display:none;"></div>
                            <!-- Unique ID for each modal -->
                        </div>
                        <div class="modal-footer justify-content-center border-0">
                            <button type="button" class="btn rounded-pill btn-sm btn-secondary px-4"
                                data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($allQuoteHistory->count() > 0)
            <div class="card-body py-3 d-flex justify-content-between align-items-center">
                <div class="DayNganCach"></div>
                <ul class="pagination">
                    {{ $allQuoteHistory->links('pagination::bootstrap-5') }}
                </ul>
            </div>
        @endif
    </div>
@endsection
