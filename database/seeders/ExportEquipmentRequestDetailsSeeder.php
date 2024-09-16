<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportEquipmentRequestDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('export_equipment_request_details')->insert([
            [
                'export_request_code' => 'EXREQ001',
                'equipment_code' => 'E001',
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
