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
                'name' => 'Dao phẫu thuật',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'price' => 15000,
                'country' => 'Mỹ',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E002',
                'name' => 'Băng gạc vô trùng',
                'equipment_type_code' => 'ET002',
                'unit_code' => 'UNIT010',
                'price' => 2000,
                'country' => 'Việt Nam',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E003',
                'name' => 'Ống tiêm dùng một lần',
                'equipment_type_code' => 'ET003',
                'unit_code' => 'UNIT007',
                'price' => 5000,
                'country' => 'Trung Quốc',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E004',
                'name' => 'Máy đo huyết áp tự động',
                'equipment_type_code' => 'ET004',
                'unit_code' => 'UNIT001',
                'price' => 2500000,
                'country' => 'Đức',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E005',
                'name' => 'Nhiệt kế hồng ngoại',
                'equipment_type_code' => 'ET005',
                'unit_code' => 'UNIT001',
                'price' => 30000,
                'country' => 'Nhật Bản',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
