<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptsSeeder extends Seeder
{
    public function run()
    {
        DB::table('receipts')->insert([]);
    }
}
