<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportEquipmentRequestsSeeder extends Seeder
{
    public function run()
    {
        DB::table('export_equipment_requests')->insert([
            [
                'code' => 'EXREQ001',
                'user_code' => 'U001',
                'department_code' => 'DEP001',
                'reason_export' => 'Office relocation',
                'note' => 'Urgent export required for new office setup',
                'status' => false,
                'request_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
