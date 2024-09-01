@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@php
    if ($action == 'create') {
        $action = route('report.create');

        $button_text = 'Tạo';
    } else {
        $action = route('report.edit');

        $button_text = 'Cập Nhật';
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
        <form class="form" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">

                    <div class="row mb-5">

                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-3">Loại Báo Cáo</label>

                            <select name="" class="form-select form-select-sm form-select-solid">
                                <option value="0">Chọn Loại Báo Cáo...</option>
                                @foreach ($AllReportType as $item)
                                    <option value="{{ $item['id'] }}"
                                        {{ !empty($FirstReport['report_type_id']) ? ($item['id'] == $FirstReport['report_type_id'] ? 'selected' : '') : '' }}>
                                        {{ $item['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 fv-row">

                            <label class="required fs-5 fw-bold mb-2">File Báo Cáo</label>


                            <input type="file" class="form-control form-control-sm form-control-solid" placeholder=""
                                name="last-name" />

                        </div>

                    </div>


                    <div class="d-flex flex-column mb-5 fv-row">
                        <label class="required fs-5 fw-bold mb-2">Nội Dung Báo Cáo</label>

                        <textarea name="content" class="form-control form-control-sm form-control-solid" cols="30" rows="10"
                            placeholder="Nhập Nội Dung Báo Cáo..">{{ !empty($FirstReport['content']) ? $FirstReport['content'] : old('content') }}</textarea>
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
@endsection

@section('scripts')
@endsection
