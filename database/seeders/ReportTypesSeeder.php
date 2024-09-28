<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('report_types')->insert([
            [
                'name' => 'Thiết Bị Nhập Kho',
            ],
        ]);
    }
}
