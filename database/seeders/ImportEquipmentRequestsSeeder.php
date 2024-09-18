<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportEquipmentRequestsSeeder extends Seeder
{
    public function run()
    {
        DB::table('import_equipment_requests')->insert([
            [
                'code' => 'IMREQ001',
                'supplier_code' => 'SUP001',
                'note' => 'Initial order of laptops',
                'status' => true,
                'request_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
