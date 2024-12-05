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
                'code' => 'USER121204',
                'first_name' => 'Huy',
                'last_name' => 'Lu Phat',
                'email' => 'lphdev04@gmail.com',
                'phone' => '0945567048',
                'password' => bcrypt('0945567048'),
                'birth_day' => '2004-12-12',
                'gender' => 'Nam',
                'address' => 'Kiên Giang',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'USER121205',
                'first_name' => 'Củ',
                'last_name' => 'Jack 5',
                'email' => 'huylppc05334@fpt.edu.vn',
                'phone' => '0945567049',
                'password' => bcrypt('0945567049'),
                'birth_day' => '2004-12-12',
                'gender' => 'Nam',
                'address' => 'Kiên Giang',
                'isAdmin' => false,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'USER010104',
                'first_name' => 'Huy',
                'last_name' => 'Lam Nhat',
                'email' => 'lamnhathuy0393418721@gmail.com',
                'phone' => '0393379824',
                'password' => bcrypt('0393379824'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => 'Sóc Trăng',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'USER020204',
                'first_name' => 'Huy',
                'last_name' => 'Nguyen Quoc',
                'email' => 'nguyenquochuy9602@gmail.com',
                'phone' => '0869119602',
                'password' => bcrypt('0869119602'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => 'Sóc Trăng',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'USER030304',
                'first_name' => 'Hoài',
                'last_name' => 'Phạm Anh',
                'email' => 'phamanhhoaipl@gmail.com',
                'phone' => '0375527037',
                'password' => bcrypt('0375527037'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => 'Sóc Trăng',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'USER040404',
                'first_name' => 'Thái',
                'last_name' => 'Lê Nhựt',
                'email' => 'nhutthai2018@gmail.com',
                'phone' => '0969245242',
                'password' => bcrypt('0969245242'),
                'birth_day' => '2024-01-01',
                'gender' => 'Nam',
                'address' => 'Sóc Trăng',
                'isAdmin' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
