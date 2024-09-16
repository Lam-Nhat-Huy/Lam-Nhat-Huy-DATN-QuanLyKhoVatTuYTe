<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryChecksSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_checks')->insert([
            [
                'code' => 'IC001',
                'user_code' => 'U001',
                'check_date' => now(),
                'note' => 'Inventory audit completed',
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
