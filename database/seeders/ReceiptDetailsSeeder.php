<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('receipt_details')->insert([
            [
                'receipt_code' => 'REC001',
                'equipment_code' => 'E001',
                'batch_number' => 'B001',
                'expiry_date' => now()->addYear(),
                'quantity' => 5,
                'unit_price' => 1500.00,
                'discount' => 0.00,
            ],
        ]);
    }
}
