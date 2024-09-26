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
                'name' => 'Surgical Scalpel (Dao phẫu thuật)',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'price' => 15000,
                'country' => 'USA',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E002',
                'name' => 'Sterile Dressing (Băng gạc vô trùng)',
                'equipment_type_code' => 'ET002',
                'unit_code' => 'UNIT010',
                'price' => 2000,
                'country' => 'Vietnam',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E003',
                'name' => 'Disposable Syringe (Ống tiêm dùng một lần)',
                'equipment_type_code' => 'ET003',
                'unit_code' => 'UNIT007',
                'price' => 5000,
                'country' => 'China',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E004',
                'name' => 'Automatic Blood Pressure Monitor (Máy đo huyết áp tự động)',
                'equipment_type_code' => 'ET004',
                'unit_code' => 'UNIT001',
                'price' => 2500000,
                'country' => 'Germany',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'E005',
                'name' => 'Infrared Thermometer (Nhiệt kế hồng ngoại)',
                'equipment_type_code' => 'ET005',
                'unit_code' => 'UNIT001',
                'price' => 30000,
                'country' => 'Japan',
                'supplier_code' => 'SUP001',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
