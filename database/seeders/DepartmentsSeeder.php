<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->insert([
            [
                'code' => 'DEP001',
                'name' => 'Phòng Nội trú - Lầu 1',
                'description' => 'Chăm sóc và điều trị bệnh nhân nội trú.',
                'location' => 'Tòa nhà A, Lầu 1',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP002',
                'name' => 'Phòng Ngoại trú - Lầu 2',
                'description' => 'Phục vụ bệnh nhân ngoại trú và các phẫu thuật nhỏ.',
                'location' => 'Tòa nhà B, Lầu 2',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP003',
                'name' => 'Phòng Cấp cứu - Tầng Trệt',
                'description' => 'Xử lý nhanh các trường hợp khẩn cấp.',
                'location' => 'Gần lối vào chính của bệnh viện',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP004',
                'name' => 'Phòng Phục hồi chức năng - Lầu 3',
                'description' => 'Hỗ trợ phục hồi chức năng cho bệnh nhân sau điều trị.',
                'location' => 'Tòa nhà D, Lầu 3',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP005',
                'name' => 'Phòng Xét nghiệm - Tầng Trệt',
                'description' => 'Thực hiện xét nghiệm và phân tích mẫu bệnh phẩm.',
                'location' => 'Tòa nhà E, Tầng Trệt',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP006',
                'name' => 'Phòng Chẩn đoán hình ảnh - Lầu 1',
                'description' => 'Cung cấp dịch vụ chụp X-quang, CT, và MRI.',
                'location' => 'Tòa nhà F, Lầu 1',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP007',
                'name' => 'Phòng Thận - Tiết niệu - Lầu 2',
                'description' => 'Điều trị các bệnh lý về thận và tiết niệu.',
                'location' => 'Tòa nhà G, Lầu 2',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP008',
                'name' => 'Phòng Tim mạch - Lầu 1',
                'description' => 'Điều trị các bệnh về tim mạch.',
                'location' => 'Tòa nhà H, Lầu 1',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP009',
                'name' => 'Phòng Nhi - Lầu 3',
                'description' => 'Điều trị cho trẻ em từ sơ sinh đến vị thành niên.',
                'location' => 'Tòa nhà I, Lầu 3',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'DEP010',
                'name' => 'Phòng Dược - Tầng Trệt',
                'description' => 'Quản lý và cung cấp thuốc cho bệnh viện.',
                'location' => 'Tòa nhà J, Tầng Trệt',
                'created_by' => 'USER121204',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}