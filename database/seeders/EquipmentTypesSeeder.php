<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_types')->insert([
            [
                'code' => 'ET001',
                'name' => 'Điện tử',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET002',
                'name' => 'Dụng cụ phẫu thuật',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET003',
                'name' => 'Thiết bị tiêu hao',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET004',
                'name' => 'Thiết bị theo dõi',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET005',
                'name' => 'Thiết bị chẩn đoán',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
