<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportEquipmentRequestsSeeder extends Seeder
{
    public function run()
    {
        DB::table('export_equipment_requests')->insert([]);
    }
}
