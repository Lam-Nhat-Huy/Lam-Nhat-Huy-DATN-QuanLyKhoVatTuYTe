<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    public function run()
    {
        DB::table('units')->insert([
            [
                'code' => 'UNIT001',
                'name' => 'Cái',
                'description' => 'Đơn vị đo số lượng các thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT002',
                'name' => 'Hộp',
                'description' => 'Đơn vị đo số lượng hộp thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT003',
                'name' => 'Bộ',
                'description' => 'Đơn vị đo số lượng bộ thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT004',
                'name' => 'Lít',
                'description' => 'Đơn vị đo thể tích các thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT005',
                'name' => 'Kilogram',
                'description' => 'Đơn vị đo trọng lượng các thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT006',
                'name' => 'Hộp x 10 viên',
                'description' => 'Đơn vị đo các loại thuốc đóng hộp 10 viên',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT007',
                'name' => 'Ống',
                'description' => 'Đơn vị đo số lượng ống tiêm hoặc ống thuốc',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT008',
                'name' => 'Chai',
                'description' => 'Đơn vị đo số lượng chai dung dịch y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT009',
                'name' => 'Gói',
                'description' => 'Đơn vị đo số lượng các thiết bị, thiết bị đóng gói',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT010',
                'name' => 'Cuộn',
                'description' => 'Đơn vị đo các thiết bị cuộn như băng gạc, băng keo',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT011',
                'name' => 'Thùng',
                'description' => 'Đơn vị đo số lượng thùng chứa thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT012',
                'name' => 'Túi',
                'description' => 'Đơn vị đo số lượng túi thiết bị y tế',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT013',
                'name' => 'Viên',
                'description' => 'Đơn vị đo các viên thuốc hoặc viên nén',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT014',
                'name' => 'Set',
                'description' => 'Đơn vị đo số lượng set thiết bị y tế (ví dụ như dụng cụ phẫu thuật)',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'UNIT015',
                'name' => 'Lọ',
                'description' => 'Đơn vị đo số lượng lọ dung dịch, thuốc, hóa chất',
                'created_by' => 'U001',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
