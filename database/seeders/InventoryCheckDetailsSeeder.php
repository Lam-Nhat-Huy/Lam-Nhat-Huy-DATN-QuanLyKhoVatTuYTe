<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryCheckDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_check_details')->insert([
            [
                'inventory_check_code' => 'IC001',
                'equipment_code' => 'E001',
                'actual_quantity' => 10,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
