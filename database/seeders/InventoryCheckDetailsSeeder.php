<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryCheckDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_check_details')->insert([
            [
                'inventory_check_code' => 'KK000001',
                'equipment_code' => 'E001',
                'current_quantity' => 100,
                'actual_quantity' => 90,
                'unequal' => 10,
                'batch_number' => 'C102',
                'created_at' => '2024-09-24 12:00:00',
                'updated_at' => '2024-09-24 12:30:00',
                'deleted_at' => null,
            ],
            [
                'inventory_check_code' => 'KK000001',
                'equipment_code' => 'E002',
                'current_quantity' => 50,
                'actual_quantity' => 48,
                'unequal' => 2,
                'batch_number' => 'C101',
                'created_at' => '2024-09-24 12:00:00',
                'updated_at' => '2024-09-24 12:30:00',
                'deleted_at' => null,
            ],
            [
                'inventory_check_code' => 'KK000002',
                'equipment_code' => 'E003',
                'current_quantity' => 200,
                'actual_quantity' => 195,
                'unequal' => 5,
                'batch_number' => 'C100',
                'created_at' => '2024-09-23 14:00:00',
                'updated_at' => '2024-09-23 15:00:00',
                'deleted_at' => null,
            ],
        ]);
    }
}
