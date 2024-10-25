<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventories')->insert([]);
    }
}
