<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipments')->insert([
            [
                'code' => 'E001',
                'name' => 'Dao mổ',
                'equipment_type_code' => 'ET001',
                'price' => 1500.00,
                'country' => 'USA',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E002',
                'name' => 'Băng gạc',
                'equipment_type_code' => 'ET002',
                'price' => 200.00,
                'country' => 'Vietnam',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E003',
                'name' => 'Ống tiêm',
                'equipment_type_code' => 'ET003',
                'price' => 50.00,
                'country' => 'China',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E004',
                'name' => 'Máy đo huyết áp',
                'equipment_type_code' => 'ET004',
                'price' => 2500.00,
                'country' => 'Germany',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E005',
                'name' => 'Nhiệt kế điện tử',
                'equipment_type_code' => 'ET005',
                'price' => 300.00,
                'country' => 'Japan',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
