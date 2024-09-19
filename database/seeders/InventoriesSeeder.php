<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventories')->insert([
            [
                'code' => 'INV001',
                'equipment_code' => 'E001',
                'batch_number' => 'B001',
                'current_quantity' => 52,
                'import_code' => 'REC0001',
                'export_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'INV002',
                'equipment_code' => 'E002',
                'batch_number' => 'V001',
                'current_quantity' => 123,
                'import_code' => 'REC0001',
                'export_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'INV003',
                'equipment_code' => 'E005',
                'batch_number' => 'P001',
                'current_quantity' => 115,
                'import_code' => 'REC0001',
                'export_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'INV004',
                'equipment_code' => 'E003',
                'batch_number' => 'B002',
                'current_quantity' => 51,
                'import_code' => 'REC0002',
                'export_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'INV005',
                'equipment_code' => 'E004',
                'batch_number' => 'B003',
                'current_quantity' => 57,
                'import_code' => 'REC0002',
                'export_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
