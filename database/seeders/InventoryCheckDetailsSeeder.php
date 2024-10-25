<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryCheckDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_check_details')->insert([]);
    }
}
