<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptsSeeder extends Seeder
{
    public function run()
    {
        DB::table('receipts')->insert([
            [
                'code' => 'REC001',
                'note' => 'First receipt',
                'status' => true,
                'receipt_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
