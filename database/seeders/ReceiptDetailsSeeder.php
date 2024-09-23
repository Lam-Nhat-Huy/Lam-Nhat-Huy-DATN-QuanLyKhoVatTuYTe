<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptDetailsSeeder extends Seeder
{
    public function run()
    {
        DB::table('receipt_details')->insert([
            // [
            //     'receipt_code' => 'REC0001',
            //     'batch_number' => 'B001',
            //     'expiry_date' => now()->addYear(),
            //     'quantity' => 52,
            //     'VAT' => 1.2,
            //     'discount' => 0.00,
            //     'equipment_code' => 'E001',
            //     'price' => 80000,
            // ],
            // [
            //     'receipt_code' => 'REC0001',
            //     'batch_number' => 'V001',
            //     'expiry_date' => now()->addYear(),
            //     'quantity' => 123,
            //     'VAT' => 1.2,
            //     'discount' => 0.00,
            //     'equipment_code' => 'E002',
            //     'price' => 15400,
            // ],
            // [
            //     'receipt_code' => 'REC0001',
            //     'batch_number' => 'P001',
            //     'expiry_date' => now()->addYear(),
            //     'quantity' => 115,
            //     'VAT' => 1.2,
            //     'discount' => 0.00,
            //     'equipment_code' => 'E005',
            //     'price' => 25400,
            // ],
        ]);
    }
}
