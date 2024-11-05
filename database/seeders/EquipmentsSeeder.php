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
                'code' => 'EQ88899944',
                'name' => 'Máy đo tim thai Jumper - JPD-100S',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'vat' => 10,
                'country' => 'Mỹ',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737527',
                'name' => 'Máy đo nồng độ oxy và nhịp tim Jumper - JPD-500E',
                'equipment_type_code' => 'ET002',
                'unit_code' => 'UNIT010',
                'country' => 'Việt Nam',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ84729474',
                'name' => 'Máy đo huyết áp bắp tay Jumper - JPD-HA200',
                'equipment_type_code' => 'ET003',
                'unit_code' => 'UNIT007',
                'country' => 'Trung Quốc',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737521',
                'name' => 'Nhiệt kế hồng ngoại Jumper - FR202',
                'equipment_type_code' => 'ET004',
                'unit_code' => 'UNIT001',
                'country' => 'Đức',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737522',
                'name' => 'Cân điện tử Beurer - GS10',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'country' => 'Nhật Bản',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737512',
                'name' => 'Máy đo huyết áp cổ tay Omron - HEM-6161',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'country' => 'Nhật Bản',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737542',
                'name' => 'Máy đo huyết áp Omron - HEM-8712',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'country' => 'Nhật Bản',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737528',
                'name' => 'Giường y tế đa chức năng Newrer- D01-S',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'country' => 'Nhật Bản',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737059',
                'name' => 'Tủ y tế đầu giường Rawfea - D25',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'country' => 'Nhật Bản',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'EQ85737868',
                'name' => 'Máy hiệu ứng từ Berdwe - YF-T08A',
                'equipment_type_code' => 'ET001',
                'unit_code' => 'UNIT001',
                'country' => 'Trung Quốc',
                'vat' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}