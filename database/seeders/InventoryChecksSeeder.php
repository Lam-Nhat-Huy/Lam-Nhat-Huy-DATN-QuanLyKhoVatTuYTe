<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryChecksSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_checks')->insert([]);
    }
}
