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
            padding: 8px 12px;
            margin: 5px 0;
            max-width: 80%;
            animation: fadeIn 0.3s ease-in-out;
        }

        .chat-bubble.user {
            align-self: flex-end;
            background-color: #4CAF50;
            /* Màu xanh lá cho tin nhắn người dùng */
            color: #fff;
            font-size: 12px;
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

        .custom-pagination .page-item {
            margin: 0 4px;
            /* Giảm khoảng cách giữa các nút để tạo cảm giác gọn gàng hơn */
        }

        .custom-pagination .page-item .page-link {
            border: 1px solid #ddd;
            /* Thêm viền nhẹ để phân biệt rõ nút */
            border-radius: 4px;
            /* Giảm bo tròn để trông hiện đại hơn */
            padding: 6px 10px;
            /* Kích thước nhỏ gọn hơn */
            color: #6c757d;
            background-color: #ffffff;
            transition: all 0.3s ease-in-out;
            font-size: 14px;
            /* Cỡ chữ vừa phải, dễ đọc */
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #007bff;
            /* Màu xanh chủ đạo cho nút đang chọn */
            color: #ffffff;
            border-color: #007bff;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.4);
            /* Hiệu ứng bóng nhẹ */
        }

        .custom-pagination .page-item .page-link:hover {
            background-color: #0056b3;
            /* Màu hover đậm hơn để dễ nhận biết */
            color: #ffffff;
            text-decoration: none;
            border-color: #0056b3;
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
            /* Màu nền xám nhạt cho trạng thái vô hiệu hóa */
            color: #6c757d;
            border-color: #ddd;
            cursor: not-allowed;
            /* Thay đổi con trỏ để biểu thị không thể bấm */
        }

        .autocompleteSuggestions {
            position: absolute;
            background-color: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            /* Bo góc để giao diện mềm mại hơn */
            max-height: 200px;
            /* Tăng chiều cao tối đa để hiển thị thêm dữ liệu */
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Thêm hiệu ứng đổ bóng */
            font-family: Arial, sans-serif;
            /* Đặt font chữ chuyên nghiệp hơn */
            font-size: 14px;
        }

        .autocompleteSuggestions div {
            padding: 10px 15px;
            /* Tăng khoảng cách padding để dễ nhìn */
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Thêm hiệu ứng hover */
        }

        .autocompleteSuggestions div:hover {
            background-color: #f1f3f5;
            /* Màu nền khi hover nhẹ nhàng */
            transform: translateX(4px);
            /* Hiệu ứng di chuyển nhẹ */
            cursor: pointer;
            /* Thêm con trỏ chuột dạng pointer */
        }

        .autocompleteSuggestions div:active {
            background-color: #e0e0e0;
            /* Thêm hiệu ứng khi nhấn chuột */
        }

        .result-chat {
            list-style: none;
            padding: 4px 6px;
            font-size: 12px;
            background-color: #4CAF50;
            margin-top: 5px;
            color: #fff;
            border-radius: 4px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .result-chat:hover {
            transform: scale(1.02);
        }


        .send-mess:hover {
            color: #fff;
            opacity: 0.8;
        }

        /* Animation khi trang tải */
        /* Animation phóng to - thu nhỏ */
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
                /* Phóng to 10% */
            }
        }

        .open-chatbox-btn {
            animation: pulse 1.5s infinite;
            /* Hiệu ứng phóng to - thu nhỏ lặp lại */
            transition: transform 0.3s ease, filter 0.3s ease;
            /* Hiệu ứng mượt khi hover */
        }

        /* Hiệu ứng hover */
        .open-chatbox-btn:hover {
            transform: scale(1.2);
            /* Phóng to lớn hơn khi hover */
            filter: brightness(1.4);
            /* Tăng độ sáng */
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.7);
            /* Thêm ánh sáng */
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

    <!-- Modal Chatbot -->
    <div class="modal fade" id="browse" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="browseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <!-- Chat Container -->
                <div id="chatContainer" class="chat-container" style="display: block; border: 4px solid #fff;">
                    <div class="chat-header text-uppercase fs-5">Chatbot kiểm tra tồn kho</div>
                    <div class="chat-messages" id="chatMessages">
                        <div class="chat-bubble bot">Bạn cần tra cứu tồn kho của thiết bị nào ạ?</div>
                    </div>

                    <div class="suggestions container text-center">
                        <div class="row">
                            <div class="col">
                                <div class="suggestion" style="font-size: 12px;"
                                            onclick="sendPredefinedMessage('Cồn 70 độ Bidophar chai 1000ml')">
                                    Cồn 70 độ Bidophar chai 1000ml
                                </div>
                            </div>
                            <div class="col">
                                <div class="suggestion" style="font-size: 12px;"
                                            onclick="sendPredefinedMessage('Kim lấy máu Lencet BL-28')">
                                    Kim lấy máu Lencet BL-28
                                </div>
                            </div>
                            <div class="col">
                                <div class="suggestion" style="font-size: 12px;"
                                            onclick="sendPredefinedMessage('Thiết bị nào gần hết hàng?')">
                                    Thiết bị nào gần hết hàng?
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chat-footer">
                        <!-- Input với giá trị mặc định -->
                        <input type="text" style="font-size: 12px;" id="promptInput" value=""
                                    placeholder="Vui lòng chỉ nhập tên thiết bị" class="form-control rounded-pill"
                                    onfocus="moveCursorToEnd(event)">
                        <button class="btn btn-primary rounded-pill send-mess" style="font-size: 12px;"
                                    onclick="sendMessage()">Gửi</button>
                    </div>


                </div>

                <div class="modal-footer pt-0" style="width: 100%; display: inline-block;">
                    <div class="d-flex" id="titleSuggestion">

                    </div>
                    <div id="autocompleteSuggestions" style="cursor: pointer;" class="autocomplete-suggestions">
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>

    <script>
        const api = 'https://b625-2402-800-6343-ed71-141d-6c90-ff0f-3a09.ngrok-free.app'
        const promptInput = document.getElementById('promptInput');

        const autocompleteSuggestions = document.getElementById('autocompleteSuggestions');
        const titleSuggestion = document.getElementById('titleSuggestion')

        let currentSuggestions = [];

        let selectedIndex = -1;

        // Lấy danh sách tên thiết bị từ API
        async function fetchEquipmentNames() {
            try {
                const response = await fetch(`${api}/api/equipment-names`, {
                    headers: {
                        'ngrok-skip-browser-warning': 'true' // Bỏ qua cảnh báo của ngrok
                    }
                });

                if (!response.ok) {
                    throw new Error(`Lỗi HTTP! Trạng thái: ${response.status}`);
                }

                const jsonResponse = await response.json();
                return jsonResponse.equipment_names || [];
            } catch (error) {
                console.error('Lỗi khi lấy tên thiết bị:', error);
                return []; // Trả về mảng rỗng trong trường hợp lỗi
            }
        }

        // Lọc và hiển thị gợi ý
        async function handleInput(event) {
            const query = event.target.value.trim();
            const lastCharacter = query.slice(-1);


            if (!query) {
                autocompleteSuggestions.innerHTML = ''
                titleSuggestion.innerHTML = ''
                currentSuggestions.innerHTML = ''
                return;
            }

            if (!query || (lastCharacter !== ' ' && !event.inputType?.includes('insertText'))) {
                autocompleteSuggestions.innerHTML = '';
                currentSuggestions = [];
                return;
            }

            const names = await fetchEquipmentNames();

            // Chuẩn hóa chuỗi nhập
            const normalizedQuery = query
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .toLowerCase();


            // Lọc tên thiết bị nếu khớp toàn bộ từ
            currentSuggestions = names.filter(name => {
                const normalizedName = name.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
                return normalizedName.includes(normalizedQuery);
            });

            renderSuggestions();
        }


        function renderSuggestions() {
            console.log('Đang hiển thị các gợi ý:', currentSuggestions);
            autocompleteSuggestions.innerHTML = currentSuggestions
                .map((suggestion, index) => `<li class="result-chat rounded-pill" data-index="${index}">${suggestion}</li>`)
                .join('');

            titleSuggestion.innerHTML = `Gợi ý <img style="width: 16px; vertical-align: middle; margin-left: 5px;"
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThr7qrIazsvZwJuw-uZCtLzIjaAyVW_ZrlEQ&s"
                                    alt="">`;
        }

        function selectSuggestion(index) {
            console.log('Gợi ý được chọn - Vị trí:', index, 'Giá trị:', currentSuggestions[index]);
            promptInput.value = currentSuggestions[index];
            autocompleteSuggestions.innerHTML = ''
            titleSuggestion.innerHTML = ''
            promptInput.focus()
            currentSuggestions = [];
            selectedIndex = -1;
        }

        autocompleteSuggestions.addEventListener('click', event => {
            const index = event.target.dataset.index;
            if (index !== undefined) selectSuggestion(index);
        });

        promptInput.addEventListener('input', handleInput);
        promptInput.addEventListener('keydown', handleKeyDown);

        function handleKeyDown(event) {
            if (event.key === 'Enter') {
                console.log('Phím Enter được nhấn, gửi tin nhắn.');
                sendMessage();
            }
        }





        // Hàm xử lí kết quả trả về từ api 
        document.addEventListener("DOMContentLoaded", function () {
            const sliderContent = document.getElementById("sliderContent");
            const originalContent = sliderContent.innerHTML;

            sliderContent.innerHTML += originalContent;

            sliderContent.style.transform = `translateX(${sliderContent.offsetWidth}px)`;

            function startScrolling() {
                const contentWidth = sliderContent.offsetWidth / 1;

                let position = contentWidth;

                function scroll() {
                    position -= 2;

                    if (position <= -contentWidth) {
                        position = contentWidth;
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
    let userMessage = promptInput.value.trim();

    const defaultPrompt = "Tồn kho của ";
    if (!userMessage.startsWith(defaultPrompt)) {
        userMessage = defaultPrompt + userMessage;
    }

    if (userMessage.trim() === defaultPrompt.trim()) return;

    addMessage(userMessage, 'user');
    promptInput.value = "";

    fetch(`${api}/api/inventory-chatbot?prompt=${encodeURIComponent(userMessage)}`, {
        headers: {
            'ngrok-skip-browser-warning': 'true'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                addMessage(data.error, 'bot');
            } else if (Array.isArray(data)) { // Kiểm tra nếu dữ liệu là danh sách thiết bị gần hết hàng
                let messageContent = `<strong>Danh sách thiết bị gần hết hàng:</strong><br>`;
                data.forEach(item => {
                    messageContent += `
                        - <strong>Tên thiết bị:</strong> ${item.equipment_name}<br>
                        - <strong>Mã thiết bị:</strong> ${item.equipment_code}<br>
                        - <strong>Số lượng:</strong> ${item.current_quantity} đơn vị<br>
                        - <strong>Số lô:</strong> ${item.batch_number}<br><br>`;
                });
                addMessage(messageContent, 'bot');
            } else {
                let messageContent = `<strong>Tên thiết bị:</strong> ${data.equipment_name}<br>
                <strong>Mã thiết bị:</strong> ${data.equipment_code}<br>
                <strong>Tổng số lượng:</strong> ${data.total_quantity} đơn vị<br><br>
                <strong>Danh sách số lô:</strong><br>`;
                data.batches.forEach(batch => {
                    messageContent += `
                    - <strong>Số lô:</strong> ${batch.batch_number}<br>
                    - <strong>Số lượng:</strong> ${batch.current_quantity} đơn vị<br><br>`;
                });
                addMessage(messageContent, 'bot');
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

        function moveCursorToEnd(event) {
            const input = event.target;
            setTimeout(() => {
                input.setSelectionRange(input.value.length, input.value.length);
            }, 0);
        }

    </script>

    {{--
    <script src="{{ asset('js/app.js') }}"></script> --}}

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