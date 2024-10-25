<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportEquipmentRequestsSeeder extends Seeder
{
    public function run()
    {
        DB::table('import_equipment_requests')->insert([]);
    }
}
