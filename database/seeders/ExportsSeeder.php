<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportsSeeder extends Seeder
{
    public function run()
    {
        DB::table('exports')->insert([
            [
                'code' => 'EXP001',
                'note' => 'First export',
                'status' => true,
                'export_date' => now(),
                'department_code' => 'DEP001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
