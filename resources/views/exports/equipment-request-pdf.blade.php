<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Yêu Cầu Báo Giá</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header .title {
            font-size: 16px;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 14px;
        }

        .header .country {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header .motto {
            font-size: 13px;
            font-style: italic;
        }

        .content {
            margin-top: 20px;
        }

        .content h3 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .content p {
            margin: 0 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="country">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
        <div class="motto">Độc lập - Tự do - Hạnh phúc</div>
        <div class="subtitle">--------</div>
        <div class="subtitle" style="margin-top: 10px;">BỆNH VIỆN ĐA KHOA</div>
        <div class="subtitle">THÀNH PHỐ CẦN THƠ</div>
        <div class="title">BEESOFT</div>
    </div>

    <div class="content">
        <h3>BẢNG YÊU CẦU BÁO GIÁ</h3>
        <p><strong>Kính gửi:</strong> Quý Công Ty</p>
        <p><strong>Tôi là:</strong> {{ $user_create }}</p>
        <p><strong>Đại diện cho:</strong> Bệnh viện đa khoa Beesoft Cần Thơ</p>
        <p>
            Hiện tại, chúng tôi đang có nhu cầu mua sắm thiết bị sử dùng trong chuyên môn, nay thông báo đến
            Công ty có đủ năng lực và kinh nghiệm đáp ứng yêu cầu tham gia gửi báo giá thiết bị, cụ thể như sau:
        </p>

        <p><strong>Chi tiết hàng hóa cần báo giá:</strong></p>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên thiết bị</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach ($equipmentRequestList as $item)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $item->equipments->name }}</td>
                        <td>{{ $item->equipments->units->name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a href="{{ route('equipment_request.exportExcelEquipmentRequestList', $code) }}" class="btn btn-primary">
                Tải mẫu báo giá Excel
            </a>
        </div>
    </div>

    <div class="content">
        <p>
            Vui lòng cung cấp cho tôi báo giá chi tiết của từng thiết bị trong vòng 7 ngày kể từ ngày nhận thông báo
            này,
            bao gồm các chi tiết sau:
        </p>

        <p>
            - Giá chi tiết cho từng loại thiết bị và đơn vị tính. Nếu có giá khuyến mại hoặc chiết khấu, vui lòng cung
            cấp thêm.
        </p>

        <p>
            - Chi phí vận chuyển, thông tin về cách thức vận chuyển mà nhà cung cấp sử dụng để giao hàng đến địa điểm
            nhận hàng của chúng tôi.
        </p>

        <p>- Thời gian nhà cung cấp dự kiến giao hàng.</p>

        <p>Thông tin chi tiết về các điều khoản thanh toán: phương thức thanh toán, thời gian thanh toán và các khoản
            thanh toán trước.</p>

        <p>Điều khoản và điều kiện thỏa thuận: Nếu có, vui lòng cung cấp cho tôi thông tin chi tiết về điều khoản và
            điều kiện thỏa thuận liên quan đến việc mua các thiết bị.</p>

        <p>Nếu cần thêm thông tin hoặc có bất kỳ câu hỏi nào về yêu cầu báo giá này, vui lòng liên hệ với tôi qua thông
            tin liên lạc dưới đây:</p>

        <p>Điện thoại: 0945567048.</p>

        <p>Email: lphdev04@gmail.com.</p>

        <p>Tên công ty: Bệnh viện đa khoa Beesoft.</p>

        <p>Địa chỉ: 307C Nguyễn Văn Linh, An Khánh, Ninh Kiều, Cần Thơ.</p>

        <p>Xin cảm ơn!</p>
    </div>
</body>

</html>
