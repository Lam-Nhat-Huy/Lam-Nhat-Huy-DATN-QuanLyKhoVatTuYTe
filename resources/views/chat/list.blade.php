@extends('master_layout.layout')

@section('styles')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="d-flex flex-column flex-lg-row">

        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">

            <div class="card card-flush">

                <div class="card-header pt-7" id="kt_chat_contacts_header">

                    <form class="w-100 position-relative" autocomplete="off">

                        <span
                            class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black" />
                            </svg>
                        </span>

                        <input type="text" class="form-control form-control-solid px-15" name="search" value=""
                            placeholder="Tìm kiếm tên hoặc email.." />

                    </form>

                </div>

                <div class="card-body pt-5" id="kt_chat_contacts_body">

                    <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">

                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>

                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Melody
                                        Macy</a>
                                    <div class="fw-bold text-muted">melody@altbox.com</div>
                                </div>

                            </div>

                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">1 day</span>
                            </div>

                        </div>

                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                </div>

                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Max
                                        Smith</a>
                                    <div class="fw-bold text-muted">max@kt.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">1 week</span>
                                <span class="badge badge-sm badge-circle badge-light-danger">5</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Sean
                                        Bean</a>
                                    <div class="fw-bold text-muted">sean@dellito.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">20 hrs</span>
                                <span class="badge badge-sm badge-circle badge-light-warning">9</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Brian
                                        Cox</a>
                                    <div class="fw-bold text-muted">brian@exchange.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">20 hrs</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Mikaela
                                        Collins</a>
                                    <div class="fw-bold text-muted">mikaela@pexcom.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">3 hrs</span>
                                <span class="badge badge-sm badge-circle badge-light-danger">5</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Francis
                                        Mitcham</a>
                                    <div class="fw-bold text-muted">f.mitcham@kpmg.com.au</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">2 weeks</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Olivia
                                        Wild</a>
                                    <div class="fw-bold text-muted">olivia@corpmail.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">1 week</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Neil
                                        Owen</a>
                                    <div class="fw-bold text-muted">owen.neil@gmail.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">1 week</span>
                                <span class="badge badge-sm badge-circle badge-light-warning">9</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Dan
                                        Wilson</a>
                                    <div class="fw-bold text-muted">dam@consilting.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">5 hrs</span>
                            </div>

                        </div>


                        <div class="separator separator-dashed d-none"></div>


                        <div class="d-flex flex-stack py-4">

                            <div class="d-flex align-items-center">

                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic"
                                        src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    <div
                                        class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2">
                                    </div>
                                </div>


                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma
                                        Bold</a>
                                    <div class="fw-bold text-muted">emma@intenso.com</div>
                                </div>

                            </div>


                            <div class="d-flex flex-column align-items-end ms-2">
                                <span class="text-muted fs-7 mb-1">5 hrs</span>
                                <span class="badge badge-sm badge-circle badge-light-danger">5</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">

            <div class="card" id="kt_chat_messenger">

                <div class="card-header" id="kt_chat_messenger_header">

                    <div class="card-title">

                        <div class="d-flex justify-content-center flex-column me-3">
                            <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">Brian
                                Cox</a>

                            <div class="mb-0 lh-1">
                                <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                <span class="fs-7 fw-bold text-muted">Active</span>
                            </div>

                        </div>

                    </div>

                </div>


                <div class="card-body" id="kt_chat_messenger_body">

                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px">

                        <div class="d-flex justify-content-start mb-10">

                            <div class="d-flex flex-column align-items-start">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>


                                    <div class="ms-3">
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                        <span class="text-muted fs-7 mb-1">2 mins</span>
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                    data-kt-element="message-text">How likely are you to recommend our company to your
                                    friends and family ?</div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-end mb-10">

                            <div class="d-flex flex-column align-items-end">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="me-3">
                                        <span class="text-muted fs-7 mb-1">5 mins</span>
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                    </div>


                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                    data-kt-element="message-text">Hey there, we’re just writing to let you know that
                                    you’ve been subscribed to a repository on GitHub.</div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-start mb-10">

                            <div class="d-flex flex-column align-items-start">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>


                                    <div class="ms-3">
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                        <span class="text-muted fs-7 mb-1">1 Hour</span>
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                    data-kt-element="message-text">Ok, Understood!</div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-end mb-10">

                            <div class="d-flex flex-column align-items-end">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="me-3">
                                        <span class="text-muted fs-7 mb-1">2 Hours</span>
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                    </div>


                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                    data-kt-element="message-text">You’ll receive notifications for all issues, pull
                                    requests!</div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-start mb-10">

                            <div class="d-flex flex-column align-items-start">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>


                                    <div class="ms-3">
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                        <span class="text-muted fs-7 mb-1">3 Hours</span>
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                    data-kt-element="message-text">You can unwatch this repository immediately by clicking
                                    here:
                                    <a href="https://keenthemes.com">Keenthemes.com</a>
                                </div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-end mb-10">

                            <div class="d-flex flex-column align-items-end">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="me-3">
                                        <span class="text-muted fs-7 mb-1">4 Hours</span>
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                    </div>


                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                    data-kt-element="message-text">Most purchased Business courses during this sale!</div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-start mb-10">

                            <div class="d-flex flex-column align-items-start">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>


                                    <div class="ms-3">
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                        <span class="text-muted fs-7 mb-1">5 Hours</span>
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                    data-kt-element="message-text">Company BBQ to celebrate the last quater achievements
                                    and goals. Food and drinks provided</div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">

                            <div class="d-flex flex-column align-items-end">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="me-3">
                                        <span class="text-muted fs-7 mb-1">Just now</span>
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                    </div>


                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end"
                                    data-kt-element="message-text"></div>

                            </div>

                        </div>


                        <div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">

                            <div class="d-flex flex-column align-items-start">

                                <div class="d-flex align-items-center mb-2">

                                    <div class="symbol symbol-35px symbol-circle">
                                        <img alt="Pic"
                                            src="https://img1.kienthucvui.vn/uploads/2021/01/09/anh-dai-dien-anime-girl_043115928.jpg" />
                                    </div>


                                    <div class="ms-3">
                                        <a href="#"
                                            class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                        <span class="text-muted fs-7 mb-1">Just now</span>
                                    </div>

                                </div>


                                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start"
                                    data-kt-element="message-text">Right before vacation season we have the next Big Deal
                                    for you.</div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card-footer pt-4" id="kt_chat_messenger_footer">

                    <div class="d-flex">
                        <input class="form-control form-control-flush form-control-sm border me-3 rounded" rows="1" data-kt-element="input"
                            placeholder="Phản hồi của bạn">

                        <button class="btn btn-primary btn-sm" type="button">Gửi</button>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
