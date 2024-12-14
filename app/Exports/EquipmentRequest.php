<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EquipmentRequest implements FromCollection, WithStyles, WithDrawings
{
    protected $equipmentRequestList;

    public function __construct($equipmentRequestList)
    {
        $this->equipmentRequestList = $equipmentRequestList;
    }

    public function collection()
    {
        $data = [];
        $data[] = ["", "", "CÔNG TY ..."]; // Thêm khoảng trống để tránh logo
        $data[] = ["", "", "Địa chỉ: ..."];
        $data[] = ["", "", "Hotline: ..."];
        $data[] = ["", "", "MST: ..."];
        $data[] = ["BẢNG BÁO GIÁ THIẾT BỊ"];
        $data[] = ["Ngày:"];
        $data[] = ["Kính gửi:"];

        $data[] = [
            "Lời đầu tiên, xin trân trọng cảm ơn quý khách hàng đã quan tâm đến sản phẩm của công ty chúng tôi. ... xin gửi đến quý khách bảng báo giá thiết bị với chi tiết như sau:"
        ];

        // Header của bảng chính
        $data[] = ["STT", "Mã thiết bị", "Tên thiết bị", "ĐVT", "Số lượng yêu cầu", "Số lượng đáp ứng*", "Đơn giá*", "Chiết Khấu (%)", "VAT (%)", "Thành tiền"];

        // Thêm dữ liệu chi tiết thiết bị
        $count = 1;
        foreach ($this->equipmentRequestList as $item) {
            $data[] = [
                $count++, // STT
                $item->equipments->code, // Mã thiết bị
                $item->equipments->name, // Tên thiết bị
                $item->equipments->units->name, // Đơn vị tính
                $item->quantity, // Số lượng yêu cầu
                $item->quantity, // Số lượng đáp ứng
                '0', // Đơn giá (để trống, sẽ nhập công thức trong Excel)
                '0', // Chiết khấu (cũng để trống)
                $item->equipments->vat, // Vat
                '=F' . ($count + 8) . '*G' . ($count + 8) . '*(1-H' . ($count + 8) . '/100)' . '*(1+I' . ($count + 8) . '/100)', // Thành tiền: công thức tính số lượng * đơn giá (Cột D * Cột E)
            ];
        }

        // Tổng cộng
        $data[] = ["", "", "", "", "", "", "", "", "", "=SUM(J10:J" . (9 + count($this->equipmentRequestList)) . ")", ""]; // Công thức tính tổng cộng từ cột J

        // Ghi chú
        $data[] = ["Trường cần nhập:"];
        $data[] = ["", "*Số lượng đáp ứng."];
        $data[] = ["", "*Đơn giá."];
        $data[] = ["", "Chiết khấu (nếu có)."];

        $data[] = ["Ghi chú:"];

        return new Collection($data);
    }

    public function styles(Worksheet $sheet)
    {
        // Merge và căn chỉnh các ô cho thông tin công ty (Cột C đến I)
        $sheet->mergeCells('C1:J1');
        $sheet->mergeCells('C2:J2');
        $sheet->mergeCells('C3:J3');
        $sheet->mergeCells('C4:J4');
        $sheet->mergeCells('A5:J5');
        $sheet->mergeCells('B6:J6');
        $sheet->mergeCells('B7:J7');
        $sheet->mergeCells('A8:J8');
        $row = (9 + count($this->equipmentRequestList) + 1);
        $row2 = (9 + count($this->equipmentRequestList) + 2);
        $row3 = (9 + count($this->equipmentRequestList) + 3);
        $row4 = (9 + count($this->equipmentRequestList) + 4);
        $row5 = (9 + count($this->equipmentRequestList) + 5);
        $row6 = (9 + count($this->equipmentRequestList) + 6);
        $sheet->mergeCells("A$row:I$row");
        $sheet->mergeCells("A$row2:J$row2");
        $sheet->mergeCells("B$row3:J$row3");
        $sheet->mergeCells("B$row4:J$row4");
        $sheet->mergeCells("B$row5:J$row5");
        $sheet->mergeCells("B$row6:J$row6");
        $sheet->setCellValue("A$row", "TỔNG CỘNG");

        // Xác định các ô cần khóa (ví dụ: STT, Mã thiết bị, Tên thiết bị, ĐVT, Số lượng yêu cầu, VAT)
        $lockedColumns = ['A', 'B', 'C', 'D', 'E', 'I', 'J']; // Các cột sẽ khóa
        $rowCount = 9 + count($this->equipmentRequestList);

        foreach ($lockedColumns as $col) {
            $sheet->getStyle($col . '10:' . $col . $rowCount)
                ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
        }

        $sheet->getStyle('A1:J4')
            ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        $sheet->getStyle('B6:J7')
            ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        $sheet->getStyle("B$row6:J$row6")
            ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        // Mở khóa các ô khác (để có thể chỉnh sửa nếu cần, ví dụ cột "Đơn giá", "Chiết khấu")
        $sheet->getStyle('F10:H' . $rowCount)
            ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        // Bật bảo vệ cho toàn bộ sheet
        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setPassword('khongcomatkhau'); // Đặt mật khẩu để bảo vệ sheet

        $sheet->getStyle('A5')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12, // Kích thước chữ
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Gộp cột A và B cho Logo
        $sheet->mergeCells('A1:B4');

        // Căn chỉnh tiêu đề công ty và bảng báo giá
        $sheet->getStyle('C1:C5')->applyFromArray([
            'font' => ['bold' => true, 'size' => 10],
            'alignment' => ['horizontal' => 'center']
        ]);

        // Thiết lập border cho toàn bộ bảng báo giá
        $sheet->getStyle('A1:J' . (9 + count($this->equipmentRequestList) + 6)) // 6 dòng header + dữ liệu + dòng tổng cộng
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000']
                    ]
                ]
            ]);

        // Căn chỉnh header của bảng
        $sheet->getStyle("A$row:J$row")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'right'],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['argb' => 'FFD9E1F2']
            ]
        ]);

        // Căn chỉnh header của bảng
        $sheet->getStyle('A5:J5')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['argb' => 'FFD9E1F2']
            ]
        ]);

        // Căn chỉnh header của bảng
        $sheet->getStyle('A9:J9')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['argb' => 'FFD9E1F2']
            ]
        ]);

        // Định dạng ghi chú
        $sheet->getStyle('A20:A24')->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => 'left']
        ]);

        // Thiết lập độ rộng cột
        $sheet->getColumnDimension('A')->setWidth(10); // Độ rộng cho cột Logo
        foreach (range('B', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true); // Auto-size các cột khác
        }
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath('https://i.ytimg.com/vi/PhYXIuG0jZY/maxresdefault.jpg');
        $drawing->setHeight(60); // Chiều cao của logo
        $drawing->setCoordinates('A1'); // Vị trí của logo trong file Excel
        $drawing->setOffsetX(40); // Căn chỉnh logo theo chiều ngang
        $drawing->setOffsetY(8); // Căn chỉnh logo theo chiều dọc

        return $drawing;
    }
}
