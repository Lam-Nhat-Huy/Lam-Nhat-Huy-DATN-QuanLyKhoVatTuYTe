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
                'code' => 'REC0001',
                'supplier_code' => 'SUP001',
                'note' => 'Đơn hàng dễ vỡ',
                'status' => true,
                'receipt_no' => rand(11111111, 99999999),
                'receipt_date' => now(),
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'REC0002',
                'supplier_code' => 'SUP001',
                'note' => 'Đơn hàng dễ vỡ',
                'status' => true,
                'receipt_no' => rand(11111111, 99999999),
                'receipt_date' => now(),
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
