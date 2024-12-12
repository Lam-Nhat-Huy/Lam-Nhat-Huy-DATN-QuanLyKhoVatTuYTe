<?php

namespace App\Imports;

use App\Models\Inventories;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class CheckWarehouseImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * Process each row of the Excel file and update the Inventory.
     *
     * @param array $row
     * @return void
     */
    public function model(array $row)
    {
        if (empty($row['equipment_code']) || empty($row['batch_number']) || !isset($row['actual_quantity'])) {
            Log::warning('Missing required fields in import row', $row);
            return null;
        }

        $inventory = Inventories::where('equipment_code', $row['equipment_code'])
            ->where('batch_number', $row['batch_number'])
            ->first();

        if ($inventory) {
            $inventory->actual_quantity = $row['actual_quantity'];
            $inventory->save();
        } else {
            Log::warning('Inventory record not found for row', $row);
        }
    }

    /**
     * Optionally define custom heading row.
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 3;
    }
}