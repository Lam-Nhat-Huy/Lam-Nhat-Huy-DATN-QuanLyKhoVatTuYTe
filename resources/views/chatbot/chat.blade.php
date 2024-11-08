<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Kiểm tra Tồn kho</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }

        .chat-container {
            width: 750px;
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
            font-size: 20px;
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

        .suggestions {
            padding: 10px;
        }

        .suggestion {
            background-color: #4CAF50;
            /* Màu xanh lá cho gợi ý */
            color: white;
            padding: 10px 15px;
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
    </style>
</head>

<body>
    <!-- Chat Container -->
    <div id="chatContainer" class="chat-container" style="display: none;">
        <div class="chat-header">Chatbot Kiểm tra Tồn kho</div>
        <div class="chat-messages" id="chatMessages">
            <div class="chat-bubble bot">Bạn cần tra cứu tồn kho của thiết bị nào ạ?</div>
        </div>

        <div class="suggestions container text-center">
            <div class="row">
                <div class="col">
                    <div class="suggestion" onclick="sendPredefinedMessage('Tồn kho của cân điện tử?')">Tồn kho của cân
                        điện tử?</div>
                </div>
                <div class="col">
                    <div class="suggestion" onclick="sendPredefinedMessage('Số lượng của tủ y tế?')">Số lượng của tủ y
                        tế?</div>
                </div>
                <div class="col">
                    <div class="suggestion" onclick="sendPredefinedMessage('Thiết bị nào gần hết hàng?')">Thiết bị nào
                        gần hết hàng?</div>
                </div>
            </div>
        </div>

        <div class="chat-footer">
            <input type="text" id="promptInput" placeholder="Hỏi về tồn kho..." class="form-control">
            <button class="btn btn-primary" onclick="sendMessage()">Gửi</button>
        </div>
    </div>


    <script>
        function addMessage(content, sender = 'bot') {
            const chatMessages = document.getElementById('chatMessages');
            const messageBubble = document.createElement('div');
            messageBubble.classList.add('chat-bubble', sender);
            chatMessages.appendChild(messageBubble);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            if (sender === 'bot') {
                let index = 0;
                const typingSpeed = Math.max(5, 30 - content.length * 0.15); // Tăng độ mượt mà với tốc độ điều chỉnh

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

            fetch(`http://localhost:5000/api/inventory-chatbot?prompt=${encodeURIComponent(userMessage)}`)
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
                            `Chi tiết thiết bị:<br><br><strong>Mã thiết bị</strong>: ${data.equipment_code}<br><strong>Tên thiết bị</strong>: ${data.equipment_name}<br><strong>Số lượng còn lại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô sản xuất</strong>: ${data.batch_number}`,
                            `Chi tiết thiết bị:<br><br><strong>Mã thiết bị</strong>: ${data.equipment_code}<br><strong>Tên thiết bị</strong>: ${data.equipment_name}<br><strong>Số lượng tồn kho hiện tại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô</strong>: ${data.batch_number}`,
                            `Thông tin thiết bị:<br><br><strong>Mã</strong>: ${data.equipment_code}<br><strong>Tên</strong>: ${data.equipment_name}<br><strong>Số lượng hiện tại trong kho</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô sản xuất</strong>: ${data.batch_number}`,
                            `Dữ liệu thiết bị:<br><br><strong>Mã thiết bị</strong>: ${data.equipment_code}<br><strong>Tên thiết bị</strong>: ${data.equipment_name}<br><strong>Tồn kho hiện tại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô</strong>: ${data.batch_number}`,
                            `Thông tin tồn kho thiết bị:<br><br><strong>Mã</strong>: ${data.equipment_code}<br><strong>Tên</strong>: ${data.equipment_name}<br><strong>Số lượng tồn kho</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô</strong>: ${data.batch_number}`,
                            `Thông tin thiết bị:<br><br><strong>Mã thiết bị</strong>: ${data.equipment_code}<br><strong>Tên thiết bị</strong>: ${data.equipment_name}<br><strong>Số lượng trong kho</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô sản xuất</strong>: ${data.batch_number}`,
                            `Thông tin thiết bị:<br><br><strong>Mã</strong>: ${data.equipment_code}<br><strong>Tên</strong>: ${data.equipment_name}<br><strong>Số lượng còn lại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô</strong>: ${data.batch_number}`,
                            `Thông tin chi tiết thiết bị:<br><br><strong>Mã thiết bị</strong>: ${data.equipment_code}<br><strong>Tên thiết bị</strong>: ${data.equipment_name}<br><strong>Tồn kho hiện tại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô sản xuất</strong>: ${data.batch_number}`,
                            `Thông tin thiết bị:<br><br><strong>Mã</strong>: ${data.equipment_code}<br><strong>Tên</strong>: ${data.equipment_name}<br><strong>Số lượng tồn kho hiện tại</strong>: ${data.current_quantity} đơn vị<br><strong>Số lô</strong>: ${data.batch_number}`
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
</body>

</html>
