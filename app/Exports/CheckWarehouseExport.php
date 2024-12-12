<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class CheckWarehouseExport implements FromCollection, WithStyles, WithHeadings
{
    protected $equipments;

    public function __construct($equipments)
    {
        $this->equipments = $equipments;
    }

    public function collection()
    {
        $data = [];
        $count = 1;

        foreach ($this->equipments as $equipment) {
            foreach ($equipment->inventories as $inventory) {
                $data[] = [
                    $count++, // STT
                    $inventory->equipment_code, // Mã thiết bị
                    $equipment->name, // Tên thiết bị
                    $inventory->batch_number, // Số lô
                    $inventory->current_quantity, // Tồn kho
                    '', // Thực tế
                    '', // Ghi chú
                ];
            }
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return [
            ['Phiếu Kiểm Kho'],
            ['Ngày kiểm: ' . date('d/m/Y')],
            ['STT', 'Mã thiết bị', 'Tên thiết bị', 'Số lô', 'Tồn kho', 'Thực tế', 'Ghi chú']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Số dòng thực tế cần áp dụng (dữ liệu bắt đầu từ dòng 4)
        $totalRows = 3 + $this->collection()->count();

        // Merge tiêu đề "Phiếu Kiểm Kho" và căn giữa
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => 'center']
        ]);

        // Merge và căn giữa dòng "Ngày kiểm"
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center']
        ]);

        // Căn giữa tiêu đề cột
        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['argb' => 'FFD9E1F2']
            ]
        ]);

        // Border cho tất cả các ô dữ liệu
        $sheet->getStyle('A3:G' . $totalRows)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ]);

        // Tự động điều chỉnh độ rộng cột
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
