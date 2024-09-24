<?php

namespace App\Exports;

use App\Models\Receipts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReceiptsExport implements FromCollection, WithHeadings
{
    /**
     * Get data for the Excel file.
     */
    public function collection()
    {
        return Receipts::with(['supplier', 'details']) // Chỉ cần gọi chi tiết, không cần gọi 'equipments' riêng
            ->get()
            ->flatMap(function ($receipt) {
                return $receipt->details->map(function ($detail) use ($receipt) {
                    return [
                        'code' => $receipt->code,
                        'receipt_no' => $receipt->receipt_no,
                        'supplier_code' => $receipt->supplier ? $receipt->supplier->code : '',
                        'supplier_name' => $receipt->supplier ? $receipt->supplier->name : '',
                        'equipment_code' => $detail->equipment_code, // Mã thiết bị
                        'quantity' => $detail->quantity, // Số lượng
                        'price' => $detail->price, // Giá
                        'batch_number' => $detail->batch_number, // Số lô
                        'expiry_date' => $detail->expiry_date, // Ngày hết hạn (đồng bộ tên với import)
                        'discount' => $detail->discount, // Giảm giá
                        'VAT' => $detail->VAT, // VAT
                        'receipt_date' => $receipt->receipt_date,
                        'created_by' => $receipt->created_by,
                        'status' => $receipt->status,
                    ];
                });
            });
    }

    /**
     * Add headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Mã Phiếu Nhập',
            'Số Phiếu Nhập',
            'Mã Nhà Cung Cấp',
            'Tên Nhà Cung Cấp',
            'Mã Thiết Bị', // Equipment code
            'Số Lượng', // Quantity
            'Giá', // Price
            'Số Lô', // Batch number
            'Ngày Hết Hạn', // Expiry date (đồng bộ với import)
            'Giảm Giá', // Discount
            'VAT', // VAT
            'Ngày Nhập',
            'Người Tạo',
            'Trạng Thái',
        ];
    }
}
