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
                'name' => 'ArtCare Medical - Công Ty Cổ Phần Thương Mại Và Dịch Vụ ArtCare',
                'contact_name' => 'Lâm Nhật Huy',
                'email' => 'ac.hailevan@gmail.com',
                'phone' => '0797291986',
                'address' => 'Tòa Vinhomes Gardenia, Hàm Nghi, Q. Nam Từ Liêm, Hà Nội HOTLINE: 0911 455 379',
                'tax_code'=> '9045392332',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SUP002',
                'name' => 'Thiết Bị Y Tế An Phú Khang - Công Ty TNHH Thương Mại An Phú Khang',
                'contact_name' => 'Lê Văn Vương',
                'email' => 'ac.hailevan@gmail.com',
                'phone' => '0974427022',
                'address' => 'Số 2 Quách Đình Bảo, P. Tiền Phong, TP. Thái Bình, Thái Bình, Việt Nam',
                'tax_code'=> '9045392332',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SUP003',
                'name' => 'Y Tế Minh Phát - Công Ty Cổ Phần Thương Mại Minh Phát',
                'contact_name' => 'Lữ Phát Huy',
                'email' => 'contact.minhphat@gmail.com',
                'phone' => '0903123456',
                'address' => 'Số 15, đường Hoàng Hoa Thám, P. Ngọc Hà, Q. Ba Đình, Hà Nội',
                'tax_code'=> '9045392332',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SUP004',
                'name' => 'Công ty TNHH MTV Điện Lạnh Vạn Thành',
                'contact_name' => 'Nguyễn Quốc Huy',
                'email' => 'info@vanthanh.com',
                'phone' => '0987654321',
                'address' => 'Số 10, đường Nguyễn Chí Thanh, TP. Hồ Chí Minh',
                'tax_code'=> '9045392332',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SUP005',
                'name' => 'Công ty TNHH Thiết Bị Y Tế Phúc Tín',
                'contact_name' => 'Lê Nhựt Thái',
                'email' => 'contact@phuctin.com',
                'phone' => '0912345678',
                'address' => 'Số 20, đường Lê Lợi, TP. Đà Nẵng',
                'tax_code'=> '9045392332',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SUP006',
                'name' => 'Công ty TNHH Dịch Vụ Y Tế Phương Nam',
                'contact_name' => 'Lữ Phát Huy',
                'email' => 'info@phuongnam.com',
                'phone' => '0911122233',
                'address' => 'Số 30, đường Trần Hưng Đạo, Quận 1, TP. Hồ Chí Minh',
                'tax_code'=> '9045392332',
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}
