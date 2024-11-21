@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    if ($action == 'create') {
        $action = route('report.create');

        $button_text = 'Thêm';

        $required = 'required';

        $title_filed = 'File Đã Tải Lên';
    } else {
        $action = route('report.edit', request('code'));

        $button_text = 'Cập Nhật';

        $required = '';

        $title_filed = 'File Trước Đó';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('report.index') }}" class="btn rounded-pill btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="py-5 px-lg-17 row">

                <div class="col-3">
                    <label class="fs-5 fw-bold mb-3">{{ $title_filed }}</label>
                    <iframe id="preview-pdf" src="{{ !empty($FirstReport->file) ? asset($FirstReport->file) : '' }}"
                        width="100%" height="400px"
                        style="border: none; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); {{ empty($FirstReport->file) ? 'display: none;' : '' }}"></iframe>
                    <div id="no-report-alert" class="alert alert-light text-center rounded shadow-sm p-4"
                        style="background-color: #f8f9fa; {{ !empty($FirstReport->file) ? 'display: none;' : '' }}">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-file-pdf fs-3 me-3 text-warning"></i>
                            <span class="fs-5 fw-bold text-muted">Hiện tại chưa có báo cáo</span>
                        </div>
                        <small class="text-muted d-block mt-2">Báo cáo sẽ được cập nhật sau khi có dữ liệu.</small>
                    </div>
                </div>


                <div class="me-n7 pe-7 col-9">

                    <div class="row mb-5">

                        <div class="col-md-6 fv-row">
                            <label class="{{ $required }} fs-5 fw-bold mb-2">File báo cáo (PDF)</label>

                            <input type="file" class="form-control form-control-sm rounded-pill border border-success"
                                id="pdf-input" name="file" accept="application/pdf" />

                            @error('file')
                                <div class="message_error">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="{{ $required }} fs-5 fw-bold mb-2">Loại báo cáo</label>

                            <div class="d-flex align-items-center">
                                <input type="text" name="report_type"
                                    value="{{ !empty($FirstReport->report_type) ? $FirstReport->report_type : old('report_type') }}"
                                    class="form-control form-control-sm border-success rounded-pill"
                                    placeholder="Loại thông báo..">
                            </div>

                            @error('report_type')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="d-flex flex-column mb-5 fv-row">
                        <label class="{{ $required }} fs-5 fw-bold mb-2">Nội dung báo cáo</label>

                        <textarea name="content" class="form-control form-control-sm border border-success" cols="30" rows="5"
                            placeholder="Nhập Nội Dung Báo Cáo..">{{ !empty($FirstReport['content']) ? $FirstReport['content'] : old('content') }}</textarea>

                        @error('content')
                            <div class="message_error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="modal-footer flex-right">
                <button type="submit" id="kt_modal_new_address_submit"
                    class="btn rounded-pill btn-twitter btn-sm load_animation">
                    {{ $button_text }}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('pdf-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview-pdf');
            const noReportAlert = document.getElementById('no-report-alert');

            if (file && file.type === 'application/pdf') {
                // Hiển thị file PDF
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                noReportAlert.style.display = 'none';
            } else {
                // Hiển thị cảnh báo nếu file không hợp lệ
                preview.style.display = 'none';
                noReportAlert.style.display = 'block';
            }
        });
    </script>
@endsection
