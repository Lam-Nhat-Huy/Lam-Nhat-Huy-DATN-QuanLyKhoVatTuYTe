<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Kho Y Tế Nhà Bee')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/fullcalendar.bundle.css') }}">

    <link rel="stylesheet" href="{{ asset('css/plugins.bundle.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="shortcut icon" href="{{ asset('image/logo_warehouse.png') }}" />
</head>

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed w-100" style="background-image: url({{ asset('banner_forgot.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100vh; width: 100vw;">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <a href="../../demo1/dist/index.html" class="mb-12">
                <img alt="Logo" src="{{ asset('image/logo_warehouse.png') }}" class="h-40px" />
            </a>
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">Quên Mật Khẩu ?</h1>
                        <div class="text-gray-400 fw-bold fs-4">Nhập email hoặc số điện thoại của bạn để đặt lại mật khẩu.</div>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fw-bolder text-gray-900 fs-6">Email - số điện thoại</label>
                        <input class="form-control form-control-solid" type="email" placeholder="" name="email" autocomplete="off" />
                    </div>
                    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                        <button type="button" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                            <span class="indicator-label">Gửi</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <a href="#" class="btn btn-lg btn-light-primary fw-bolder">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</html>
