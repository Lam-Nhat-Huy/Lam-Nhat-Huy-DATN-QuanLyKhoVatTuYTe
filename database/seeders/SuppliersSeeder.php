<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersSeeder extends Seeder
{
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'code' => 'SUP001',
                'name' => 'ABC Suppliers',
                'contact_name' => 'Mr. Smith',
                'email' => 'abc@suppliers.com',
                'phone' => '0987654321',
                'address' => '123 Main Street',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
