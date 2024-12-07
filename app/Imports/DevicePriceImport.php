<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class DevicePriceImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // $data = [];
        // foreach ($rows as $index => $row) {
        //     if ($index < 10) continue; // Bỏ qua header (các dòng trước dữ liệu chính)

        //     if (empty($row[1])) break; // Dừng khi gặp dòng trống

        //     $data[] = [
        //         'stt' => $row[0],
        //         'code' => $row[1], // Mã thiết bị
        //         'name' => $row[2], // Tên thiết bị
        //         'unit' => $row[3], // Đơn vị tính
        //         'required_quantity' => $row[4], // Số lượng yêu cầu
        //         'supplied_quantity' => $row[5], // Số lượng đáp ứng
        //         'price' => $row[6], // Đơn giá
        //         'discount' => $row[7], // Chiết khấu
        //         'vat' => $row[8], // VAT
        //         'total' => $row[9], // Thành tiền
        //     ];
        // }

        // return $data;
    }
}
