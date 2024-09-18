<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'current_quantity' => 10,
                'import_code' => 'IM001',
                'export_code' => null,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
