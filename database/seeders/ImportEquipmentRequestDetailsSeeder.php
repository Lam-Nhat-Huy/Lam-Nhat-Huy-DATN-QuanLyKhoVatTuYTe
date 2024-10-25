<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportEquipmentRequestDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('import_equipment_request_details')->insert([]);
    }
}
