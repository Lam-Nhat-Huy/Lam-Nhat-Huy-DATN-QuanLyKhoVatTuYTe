<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->insert([
            [
                'code' => 'DEP001',
                'name' => 'HR Department',
                'description' => 'Handles human resources',
                'location' => 'Building A',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
