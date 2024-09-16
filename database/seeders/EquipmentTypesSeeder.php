<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_types')->insert([
            [
                'code' => 'ET001',
                'name' => 'Electronics',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
