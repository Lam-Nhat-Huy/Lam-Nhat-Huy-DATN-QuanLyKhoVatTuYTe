<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportEquipmentRequestDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('import_equipment_request_details')->insert([
            [
                'import_request_code' => 'IMREQ001',
                'equipment_code' => 'E001',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
