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

    <style>
        body,
        input,
        select,
        textarea,
        button {
            font-family: 'Roboto', 'Montserrat', sans-serif;
            font-weight: 400;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
    </style>
</head>

<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative"
                style="background-color: #F2C98A">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px">
                    <!--begin::Content-->
                    <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                        <!--begin::Logo-->
                        <a href="#" class="py-9 mb-5 d-flex justify-content-center">
                            <img alt="Logo" src="{{ asset('image/logo_warehouse.png') }}" class="h-100px" />
                        </a>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder fs-2qx" style="color: #000000;">Chào Mừng Đến Với</h1>
                        <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #128833;">BeeSoft</h1>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <p class="fw-bold fs-2" style="color: #000000;">Kho thiết bị y tế - Nơi lưu trữ và cung cấp các
                            thiết bị chất lượng, đảm bảo an toàn, chính xác, giúp nâng cao hiệu quả chăm sóc sức khỏe và
                            sự tin cậy cho mọi bệnh viện.
                        </p>
                        <!--end::Description-->
                    </div>
                </div>
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto w-100">
                        <form method="POST" class="form w-100" action="{{ route('home.processForgot') }}">
                            @csrf
                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-4">Quên Mật Khẩu</h1>
                            </div>

                            <div class="fv-row mb-3">
                                <label class="required form-label fs-6 fw-bolder text-dark">Số Điện Thoại</label>
                                <input class="form-control form-control-lg" type="text"
                                    name="phone_forgot" autocomplete="off" value="{{ old('phone_forgot') }}"
                                    placeholder="Nhập số điện thoại của tài khoản.." />
                                @error('phone_forgot')
                                    <div class="message_error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" id="kt_sign_in_submit"
                                    class="btn btn-lg btn-twitter w-100 mt-3 load_animation">
                                    <span class="indicator-label">Gửi</span>
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-lg btn-dark w-100 mt-3">
                                    <span>Trở Lại</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0 text-center">
                    Một Sản Phẩm Của Nhóm BeeSoft • Hotline: 09455670xx - Phát Huy
                </div>
            </div>
        </div>
    </div>

    <div id="loading">
        <div aria-live="assertive" role="alert" class="loader"></div>
    </div>

    <div id="loading-overlay" class="loading-overlay"></div>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('js/fullcalender.bundle.js') }}"></script>
    <script src="{{ asset('js/widgets.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
    <script src="{{ asset('js/create-app.js') }}"></script>
    <script src="{{ asset('js/upgrade-plan.js') }}"></script>
</body>

</html>
