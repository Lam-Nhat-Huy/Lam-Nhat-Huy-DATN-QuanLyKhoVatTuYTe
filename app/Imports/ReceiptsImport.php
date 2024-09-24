<?php

namespace App\Imports;

use App\Models\Receipts;
use App\Models\Receipt_details;
use App\Models\Supplier; // Thêm để kiểm tra nhà cung cấp
use App\Models\Suppliers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReceiptsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Kiểm tra sự tồn tại của nhà cung cấp
        $supplier = Suppliers::where('code', $row['supplier_code'])->first();

        if (!$supplier) {
            // Handle trường hợp nhà cung cấp không tồn tại
            throw new \Exception("Nhà cung cấp không tồn tại: " . $row['supplier_code']);
        }

        // Tạo phiếu nhập
        $receipt = Receipts::create([
            'code' => uniqid('REC-'), // Tạo mã phiếu nhập duy nhất
            'supplier_code' => $row['supplier_code'],
            'receipt_no' => $row['receipt_no'],
            'receipt_date' => \Carbon\Carbon::parse($row['receipt_date']),
            'created_by' => 'U001',
            'status' => 'active',
        ]);

        // Lưu chi tiết phiếu nhập
        return new Receipt_details([
            'receipt_code' => $receipt->code,
            'equipment_code' => $row['equipment_code'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'batch_number' => $row['batch_number'],
            'expiry_date' => \Carbon\Carbon::parse($row['expiry_date']), // Đồng bộ với export
            'discount' => $row['discount'],
            'VAT' => $row['VAT'],
        ]);
    }
}
