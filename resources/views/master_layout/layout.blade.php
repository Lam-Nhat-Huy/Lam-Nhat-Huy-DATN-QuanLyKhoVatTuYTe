<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'BeeSoft')</title>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/fullcalendar.bundle.css') }}">

    <link rel="stylesheet" href="{{ asset('css/plugins.bundle.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="shortcut icon" href="{{ asset('image/logo_warehouse.png') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">

    {{-- Link css riêng cho mỗi view blade --}}
    @yield('styles')

    <style>
        body,
        input,
        select,
        textarea,
        button {
            font-family: 'Noto Sans', sans-serif;
        }

        .chat-container {
            /* Dài thêm chiều ngang */
            max-width: 100%;
            background-color: #ffffff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background-color: #4CAF50;
            /* Màu xanh lá cây */
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 16px;
            /* Kích thước font lớn hơn */
            border-bottom: 2px solid #ddd;
        }

        .chat-messages {
            padding: 15px;
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            height: 420px;
        }

        .chat-bubble {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 10px;
            margin: 5px 0;
            max-width: 80%;
            animation: fadeIn 0.3s ease-in-out;
        }

        .chat-bubble.user {
            align-self: flex-end;
            background-color: #4CAF50;
            /* Màu xanh lá cho tin nhắn người dùng */
            color: #fff;
        }

        .chat-bubble.bot {
            align-self: flex-start;
            background-color: #f1f1f1;
            color: #333;
        }

        .suggestion {
            background-color: #4CAF50;
            /* Màu xanh lá cho gợi ý */
            color: white;
            padding: 4px;
            /* Thay đổi padding để gợi ý lớn hơn */
            margin: 5px;
            border-radius: 20px;
            /* Gợi ý có hình tròn hơn */
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
            /* Kích thước font lớn hơn */
        }

        .suggestion:hover {
            background-color: #45a049;
            /* Màu tối hơn khi hover */
        }

        .chat-footer {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-footer input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            /* Hình tròn cho ô nhập */
            outline: none;
            font-size: 16px;
            margin-right: 10px;
        }

        .chat-footer button {
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Màu xanh lá cho nút gửi */
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 20px;
            /* Hình tròn cho nút */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        /* Existing styles for the notification slider */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .slider-container {
            width: 100%;
            overflow: hidden;
            background: #f9fafb;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .slider-content {
            display: flex;
            white-space: nowrap;
            position: relative;
        }

        .notification-item {
            margin-right: 40px;
            padding: 8px 12px;
            display: inline-block;
            color: #333;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .align-items-stretch {
                display: none;
            }
        }
    </style>
</head>

<body id="kt_body" data-is-admin="{{ session('isAdmin', false) ? 'true' : 'false' }}"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    <div class="modal fade" id="createImport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="DetailModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="background-color: rgb(255, 45, 45);">
                    <h3 class="modal-title text-white" id="DetailModal">BEESOFT THÔNG BÁO</h3>
                </div>
                <div class="modal-body text-center pt-0">
                    <div class="d-flex justify-content-center">
                        <img src="https://cdnl.iconscout.com/lottie/premium/thumb/rotate-phone-9207016-7517787.gif"
                            width="150" height="150" class="d-flex justify-content-center" alt="">
                    </div>
                    <h6>Vui lòng xoay ngang màn hình</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-root">

        <div class="page d-flex flex-row flex-column-fluid">

            <navbar>
                @include('master_layout.components.navbar')
            </navbar>

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                @if (request()->is('system'))
                    <div id="kt_header" class="align-items-stretch">
                        <div class="container-fluid d-flex align-items-stretch justify-content-between p-0">
                            <div class="slider-container">
                                <div id="sliderContent" class="slider-content">
                                    @foreach ($getNotification as $notification)
                                        <div class="notification-item">
                                            <strong>{!! $notification->content !!}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                @endif



                <sidebar>
                    @include('master_layout.components.sidebar')
                </sidebar>

                <main>
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <div class="toolbar" id="kt_toolbar">
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                                        @yield('title', 'BeeSoft')
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div id="kt_content_container" class="container-xxl">
                                <div class="row gy-5 g-xl-8">
                                    <div class="col-xxl-12">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer>
                    @include('master_layout.components.footer')
                </footer>

                <notification>
                    @include('master_layout.components.notification_modal')
                </notification>

                <scrolltop>
                    @include('master_layout.components.scroll_top')
                </scrolltop>
            </div>
        </div>
    </div>

    <div id="loading">
        <div aria-live="assertive" role="alert" class="loader"></div>
    </div>

    <div id="loading-overlay" class="loading-overlay"></div>

    <img class="open-chatbox-btn rounded-circle shadow" style="width: 50px; height: 50px; z-index: 9999;"
        id="open-chatbox-btn" data-bs-toggle="modal" data-bs-target="#browse"
        src="https://images.g2crowd.com/uploads/product/image/large_detail/large_detail_b541e326e0acd44b1ef931c92154c6b9/ai-chat.png"
        alt="">

    <!-- Modal Duyệt Phiếu -->
    <div class="modal fade" id="browse" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="browseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <!-- Chat Container -->
                <div id="chatContainer" class="chat-container" style="display: block;">
                    <div class="chat-header">Chatbot kiểm tra tồn kho</div>
                    <div class="chat-messages" id="chatMessages">
                        <div class="chat-bubble bot">Bạn cần tra cứu tồn kho của thiết bị nào ạ?</div>
                    </div>

                    <div class="suggestions container text-center">
                        <div class="row">
                            <div class="col">
                                <div class="suggestion" style="font-size: 12px;"
                                    onclick="sendPredefinedMessage('Tồn kho của cân điện tử?')">
                                    Tồn kho của cân
                                    điện tử?</div>
                            </div>
                            <div class="col">
                                <div class="suggestion" style="font-size: 12px;"
                                    onclick="sendPredefinedMessage('Số lượng của tủ y tế?')">
                                    Số lượng của tủ y
                                    tế?</div>
                            </div>
                            <div class="col">
                                <div class="suggestion" style="font-size: 12px;"
                                    onclick="sendPredefinedMessage('Thiết bị nào gần hết hàng?')">
                                    Thiết bị nào
                                    gần hết hàng?</div>
                            </div>
                        </div>
                    </div>

                    <div class="chat-footer">
                        <input type="text" style="font-size: 12px;" id="promptInput"
                            placeholder="Hỏi về tồn kho..." class="form-control">
                        <button class="btn btn-primary" style="font-size: 12px;" onclick="sendMessage()">Gửi</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sliderContent = document.getElementById("sliderContent");
            const originalContent = sliderContent.innerHTML;

            // Duplicate content to create infinite loop effect
            sliderContent.innerHTML += originalContent;

            // Initial position of the slider (start from right outside the view)
            sliderContent.style.transform = `translateX(${sliderContent.offsetWidth}px)`;

            function startScrolling() {
                const contentWidth = sliderContent.offsetWidth / 1; // Half because content is duplicated

                let position = contentWidth; // Start from the right of the first half

                function scroll() {
                    position -= 2; // Move left by 1 pixel per frame

                    if (position <= -contentWidth) {
                        position = contentWidth; // Reset to right position
                    }

                    sliderContent.style.transform = `translateX(${position}px)`;
                    requestAnimationFrame(scroll);
                }

                scroll();
            }

            startScrolling();
        });



        function checkOrientation() {
            if (window.innerHeight > window.innerWidth) {
                $("#createImport").modal("show");
            } else {
                $("#createImport").modal("hide");
            }
        }

        window.addEventListener('resize', checkOrientation);
        window.addEventListener('load', checkOrientation);

        function addMessage(content, sender = 'bot') {
            const chatMessages = document.getElementById('chatMessages');
            const messageBubble = document.createElement('div');
            messageBubble.classList.add('chat-bubble', sender);
            chatMessages.appendChild(messageBubble);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            if (sender === 'bot') {
                let index = 0;
                const typingSpeed = Math.max(5, 20 - content.length * 0.15); // Tăng độ mượt mà với tốc độ điều chỉnh

                function typeEffect() {
                    if (index < content.length) {
                        if (content[index] === '<') {
                            const tagEnd = content.indexOf('>', index);
                            if (tagEnd !== -1) {
                                messageBubble.innerHTML += content.slice(index, tagEnd + 1);
                                index = tagEnd + 1;
                            }
                        } else {
                            messageBubble.innerHTML += content.charAt(index);
                            index++;
                        }
                        setTimeout(typeEffect, typingSpeed); // Điều chỉnh tốc độ typing ở đây
                    } else {
                        messageBubble.innerHTML += content.substring(index);
                    }
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                typeEffect();
            } else {
                messageBubble.textContent = content;
            }
        }


        function sendMessage() {
            const promptInput = document.getElementById('promptInput');
            const userMessage = promptInput.value.trim();
            if (!userMessage) return;

            addMessage(userMessage, 'user');
            promptInput.value = '';

            const api = 'https://6af9-2402-800-6343-b657-e52c-dbad-e572-4c03.ngrok-free.app'

            fetch(`${api}/api/inventory-chatbot?prompt=${encodeURIComponent(userMessage)}`, {
                    headers: {
                        'ngrok-skip-browser-warning': 'true'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        addMessage(data.error, 'bot');
                    } else if (Array.isArray(data)) {
                        const warnings = [
                            "<strong>Cảnh báo:</strong> Cần nhập thêm hàng!",
                            "<strong>Chú ý:</strong> Hàng sắp hết, vui lòng nhập thêm!",
                            "<strong>Thông báo:</strong> Tồn kho dưới mức tối thiểu, cần bổ sung!",
                            "<strong>Lưu ý:</strong> Thiết bị này sắp hết, hãy đặt hàng mới!",
                            "<strong>Khuyến cáo:</strong> Nên nhập thêm hàng trước khi hết!"
                        ];

                        const lowStockResponse = data.map(item => {
                            const randomWarning = warnings[Math.floor(Math.random() * warnings.length)];
                            return `
                                <strong>Mã thiết bị</strong>: ${item.equipment_code}<br>
                                <strong>Tên thiết bị</strong>: ${item.equipment_name}<br>
                                <strong>Số lượng tồn kho</strong>: ${item.current_quantity} đơn vị<br>
                                <strong>Số lô</strong>: ${item.batch_number}<br>
                                ${randomWarning}
                            `;
                        }).join('<br><br>');

                        addMessage("Danh sách thiết bị gần hết:<br><br>" + lowStockResponse, 'bot');
                    } else {
                        const botResponses = [
                            `Thông tin về thiết bị:<br><br><strong>Mã thiết bị</strong>: ${data.equipment_code}<br><strong>Tên thiết bị</strong>: ${data.equipment_name}<br><strong>Số lượng hiện tại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô sản xuất</strong>: ${data.batch_number}`,
                            `Thông tin thiết bị:<br><br><strong>Mã</strong>: ${data.equipment_code}<br><strong>Tên</strong>: ${data.equipment_name}<br><strong>Số lượng tồn kho</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô</strong>: ${data.batch_number}`,
                            // Các phản hồi khác...
                        ];

                        const randomResponse = botResponses[Math.floor(Math.random() * botResponses.length)];
                        addMessage(randomResponse, 'bot');
                    }
                })
                .catch(error => {
                    addMessage("Lỗi khi lấy dữ liệu từ server.", 'bot');
                    console.error("Error:", error);
                });
        }

        function sendPredefinedMessage(message) {
            document.getElementById('promptInput').value = message;
            sendMessage();
        }
    </script>

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <script src="{{ asset('js/cancelVoice.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('js/plugins.bundle.js') }}"></script>

    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    <script src="{{ asset('js/fullcalender.bundle.js') }}"></script>

    <script src="{{ asset('js/widgets.js') }}"></script>

    <script src="{{ asset('js/chat.js') }}"></script>

    <script src="{{ asset('js/create-app.js') }}"></script>

    <script src="{{ asset('js/upgrade-plan.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('lib/library.js') }}"></script>

    {{-- Link js riêng cho mỗi view blade --}}
    @yield('scripts')
</body>

</html>
