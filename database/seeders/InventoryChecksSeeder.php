<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryChecksSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_checks')->insert([
            [
                'code' => 'KK000001',
                'user_code' => 'U001',
                'check_date' => '2024-09-24 12:53:00',
                'note' => 'Kiểm tra định kỳ tháng 9',
                'status' => 1,
                'created_at' => '2024-09-24 12:00:00',
                'updated_at' => '2024-09-24 12:30:00',
                'deleted_at' => null,
            ],
            [
                'code' => 'KK000002',
                'user_code' => 'U002',
                'check_date' => '2024-09-23 14:20:00',
                'note' => 'Kiểm tra định kỳ tháng 8',
                'status' => 0,
                'created_at' => '2024-09-23 14:00:00',
                'updated_at' => '2024-09-23 15:00:00',
                'deleted_at' => null,
            ],
        ]);
    }
}
