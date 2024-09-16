<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipments')->insert([
            [
                'code' => 'E001',
                'name' => 'Laptop',
                'equipment_type_code' => 'ET001',
                'price' => 1500.00,
                'country' => 'USA',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
