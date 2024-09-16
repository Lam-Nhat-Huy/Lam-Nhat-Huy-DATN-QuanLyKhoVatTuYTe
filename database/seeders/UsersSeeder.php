<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'code' => 'U001',
                'first_name' => 'Huy',
                'last_name' => 'Lu Phat',
                'email' => 'lphdev04@gmail.com',
                'phone' => '0945567048',
                'password' => bcrypt('lphdev04@gmail.com'),
                'birth_day' => '2004-12-12',
                'gender' => 'Nam',
                'address' => 'Kiên Giang',
                'position' => 'Admin',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'U002',
                'first_name' => 'Huy',
                'last_name' => 'Lam Nhat',
                'email' => 'U002@gmail.com',
                'phone' => '0123456781',
                'password' => bcrypt('@gmail.com'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => '',
                'position' => 'Admin',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'U003',
                'first_name' => 'Huy',
                'last_name' => 'Nguyen Quoc',
                'email' => 'U003@gmail.com',
                'phone' => '0123456782',
                'password' => bcrypt('@gmail.com'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => '',
                'position' => 'Admin',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'U004',
                'first_name' => 'Hoài',
                'last_name' => 'Phạm Anh',
                'email' => 'U004@gmail.com',
                'phone' => '0123456783',
                'password' => bcrypt('@gmail.com'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => '',
                'position' => 'Admin',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'U005',
                'first_name' => 'Thái',
                'last_name' => 'Lê Nhựt',
                'email' => 'U005@gmail.com',
                'phone' => '0123456784',
                'password' => bcrypt('@gmail.com'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => '',
                'position' => 'Admin',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
