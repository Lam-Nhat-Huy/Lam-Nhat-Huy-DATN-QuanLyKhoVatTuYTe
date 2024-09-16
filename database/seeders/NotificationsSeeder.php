<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        DB::table('notifications')->insert([
            [
                'code' => 'N001',
                'user_code' => 'U001',
                'notification_type' => 'System',
                'content' => 'Welcome to the system!',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
