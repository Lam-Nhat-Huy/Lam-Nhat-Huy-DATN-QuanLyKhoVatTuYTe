@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection

@php
    if ($action == 'create') {
        $action = route('notification.notification_create');

        $button_text = 'Thêm';

        $required = 'required';
    } else {
        $action = route('notification.notification_update', request('code'));

        $button_text = 'Cập Nhật';

        $required = '';
    }
@endphp

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $title_form }}</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('notification.index') }}" class="btn rounded-pill btn-sm btn-dark">
                    <span class="align-items-center d-flex">
                        <i class="fa fa-arrow-left me-1"></i>
                        Trở Lại
                    </span>
                </a>
            </div>
        </div>
        <form class="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="py-5 px-lg-17">

                <div class="me-n7 pe-7">
                    <div class="mb-5">
                        <label class="{{ $required }} fs-5 fw-bold mb-3">Nội Dung Thông Báo</label>
                        <textarea name="content" id="content">
                            {{ !empty($firstNotification) && !empty($firstNotification->content) ? $firstNotification->content : old('content') }}
                        </textarea>
                        @error('content')
                            <div class="message_error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
            </div>

            <div class="modal-footer flex-right">
                <button type="submit" class="btn rounded-pill btn-twitter btn-sm load_animation">
                    {{ $button_text }}
                </button>
            </div>
        </form>
    </div>
@endsection
