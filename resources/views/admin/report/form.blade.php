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

        $hidden = '';

        $required = 'required';

        $title_filed = 'File Đã Tải Lên';
    } else {
        $action = route('report.edit', request('code'));

        $button_text = 'Cập Nhật';

        $hidden = 'd-none';

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
                <a href="{{ route('report.index') }}" class="btn btn-sm btn-dark">
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
                    <iframe id="preview-pdf"
                        src="{{ !empty($FirstReport->file) ? asset('storage/reports/' . $FirstReport->file) : '' }}"
                        width="100%" height="400px">
                    </iframe>
                </div>

                <div class="me-n7 pe-7 col-9">

                    <div class="row mb-5">

                        <div class="col-md-6 fv-row">
                            <label class="{{ $required }} fs-5 fw-bold mb-2">File Báo Cáo (PDF)</label>

                            <input type="file"
                                class="form-control form-control-sm form-control-solid border border-success" id="pdf-input"
                                name="file" accept="application/pdf" />

                            @error('file')
                                <div class="message_error">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="{{ $required }} fs-5 fw-bold mb-2">Loại Báo Cáo</label>

                            <div class="d-flex align-items-center">
                                <select name="report_type"
                                    class="form-select form-select-sm form-select-solid setupSelect2">
                                    <option value="0">Chọn Loại Báo Cáo...</option>
                                    @foreach ($AllReportType as $item)
                                        <option value="{{ $item['id'] }}"
                                            {{ (!empty($FirstReport['report_type']) && $FirstReport['report_type'] == $item['id']) || old('report_type') == $item['id'] ? 'selected' : '' }}>
                                            {{ $item['name'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <span class="ms-4 pointer" data-bs-toggle="modal" data-bs-target="#add_modal_report_type"
                                    title="Thêm Loại Báo Cáo">
                                    <i class="fa fa-plus text-white py-2 px-2 bg-success rounded-circle"></i>
                                </span>

                            </div>

                            @error('report_type')
                                <div class="message_error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="d-flex flex-column mb-5 fv-row">
                        <label class="{{ $required }} fs-5 fw-bold mb-2">Nội Dung Báo Cáo</label>

                        <textarea name="content" class="form-control form-control-sm form-control-solid border border-success" cols="30"
                            rows="5" placeholder="Nhập Nội Dung Báo Cáo..">{{ !empty($FirstReport['content']) ? $FirstReport['content'] : old('content') }}</textarea>

                        @error('content')
                            <div class="message_error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="modal-footer flex-right">
                <button type="submit" id="kt_modal_new_address_submit" class="btn btn-twitter btn-sm">
                    {{ $button_text }}
                </button>
            </div>
        </form>
    </div>

    <!-- Form thêm loại báo cáo -->
    <form action="{{ route('report.create_report_type') }}" method="POST" id="reportTypeForm">
        @csrf
        <div class="modal fade" id="add_modal_report_type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="deleteModalLabel">Thêm Loại Báo Cáo</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="required fs-5 fw-bold mb-2">Tên Loại</label>
                            <input type="text"
                                class="form-control form-control-sm form-control-solid border border-success"
                                placeholder="Tên Loại Báo Cáo.." name="name" id="report_type_name" />
                            <div class="message_error" id="show-err-report-type"></div>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="overflow-auto" style="max-height: 300px;">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr class="fw-bolder bg-success">
                                        <th class="ps-4" style="width: 10%;">STT</th>
                                        <th class="" style="width: 60%;">Tên loại</th>
                                        <th class="pe-3 text-center" style="width: 30%;">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($AllReportType as $key => $item)
                                        <tr class="hover-table pointer">
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal_report_type"
                                                    onclick="setDeleteForm('{{ route('report.delete_report_type', $item->id) }}')">
                                                    <i class="fa fa-trash p-0"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-sm btn-twitter" id="submit_report_type">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Tạo form riêng biệt --}}
    @foreach ($AllReportType as $item)
        <div class="modal fade" id="delete_modal_report_type" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteReportTypeForm" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h3 class="modal-title" id="deleteModalLabel">Xóa Loại Báo Cáo</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <h6 class="text-danger">Bạn có chắc chắn muốn xóa loại báo cáo này?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#add_modal_report_type">Trở Lại</button>
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        function setDeleteForm(actionUrl) {
            document.getElementById('deleteReportTypeForm').action = actionUrl;
        }

        document.getElementById('submit_report_type').addEventListener('click', function(event) {
            var reportTypeName = document.getElementById('report_type_name').value.trim();
            var existingReportTypes = @json($AllReportType->pluck('name')->toArray());

            if (reportTypeName === '') {
                event.preventDefault();
                document.getElementById('show-err-report-type').innerText = 'Vui lòng nhập tên loại';
                document.getElementById('report_type_name').focus();
                return;
            }

            if (existingReportTypes.includes(reportTypeName)) {
                event.preventDefault();
                document.getElementById('show-err-report-type').innerText = 'Tên loại báo cáo đã tồn tại';
                document.getElementById('report_type_name').focus();
                return;
            }

            document.getElementById('show-err-report-type').innerText = '';
        });

        document.getElementById('pdf-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                const preview = document.getElementById('preview-pdf');
                preview.src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
