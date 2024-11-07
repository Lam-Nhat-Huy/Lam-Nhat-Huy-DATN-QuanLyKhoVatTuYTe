<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment_types')->insert([
            [
                'code' => 'ET001',
                'name' => 'Thiết bị điện tử y tế',
                'description' => 'Các thiết bị điện tử dùng trong y tế, bao gồm máy đo điện tim, máy theo dõi, máy siêu âm, và các thiết bị điện tử khác hỗ trợ chẩn đoán và điều trị.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET002',
                'name' => 'Dụng cụ phẫu thuật',
                'description' => 'Các dụng cụ chuyên dụng trong phẫu thuật và can thiệp y tế như dao mổ, kéo, kim, và các dụng cụ cắt, khâu trong quá trình phẫu thuật.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET003',
                'name' => 'Vật tư tiêu hao y tế',
                'description' => 'Bao gồm các vật tư dùng một lần trong y tế, như kim tiêm, bông băng, găng tay, khẩu trang, và các vật liệu tiêu hao khác.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET004',
                'name' => 'Thiết bị theo dõi sức khỏe',
                'description' => 'Các thiết bị dùng để theo dõi và giám sát tình trạng sức khỏe của bệnh nhân, bao gồm máy đo huyết áp, máy đo đường huyết, máy ECG, v.v.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET005',
                'name' => 'Thiết bị chẩn đoán y tế chuyên sâu',
                'description' => 'Thiết bị chuyên dụng dùng trong các quá trình chẩn đoán y tế như máy MRI, máy CT Scan, máy siêu âm, và các thiết bị hình ảnh học.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET006',
                'name' => 'Thiết bị hỗ trợ điều trị',
                'description' => 'Các thiết bị hỗ trợ quá trình điều trị bệnh nhân, bao gồm máy thở, máy lọc máu, máy trợ tim, và các thiết bị tương tự.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET007',
                'name' => 'Thiết bị y tế di động',
                'description' => 'Thiết bị y tế có thể di động và sử dụng ngoài bệnh viện, như máy siêu âm di động, máy xét nghiệm di động, máy theo dõi bệnh nhân di động.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET008',
                'name' => 'Thiết bị phòng khám',
                'description' => 'Các thiết bị sử dụng trong phòng khám nhỏ, bao gồm máy đo huyết áp, máy siêu âm, máy xét nghiệm, và các thiết bị phục vụ việc khám bệnh cơ bản.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET009',
                'name' => 'Thiết bị chăm sóc sức khỏe tại nhà',
                'description' => 'Các thiết bị giúp theo dõi và chăm sóc sức khỏe tại nhà, ví dụ như máy đo huyết áp, máy đo đường huyết, và máy xông khí dung.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET010',
                'name' => 'Thiết bị phẫu thuật thẩm mỹ',
                'description' => 'Các thiết bị chuyên dụng trong phẫu thuật thẩm mỹ như máy laser, thiết bị hút mỡ, máy nâng cơ và các công cụ làm đẹp y tế.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET011',
                'name' => 'Thiết bị phục hồi chức năng',
                'description' => 'Thiết bị hỗ trợ phục hồi chức năng cho bệnh nhân sau phẫu thuật hoặc chấn thương, như máy tập phục hồi, ghế massage, thiết bị hỗ trợ vận động.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET012',
                'name' => 'Thiết bị xét nghiệm',
                'description' => 'Các thiết bị dùng để thực hiện xét nghiệm y tế, bao gồm máy xét nghiệm máu, máy xét nghiệm nước tiểu, máy phân tích sinh hóa.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET013',
                'name' => 'Thiết bị hỗ trợ vận chuyển bệnh nhân',
                'description' => 'Thiết bị giúp di chuyển bệnh nhân một cách an toàn, bao gồm cáng cứu thương, xe lăn, xe cứu thương.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET014',
                'name' => 'Thiết bị bảo vệ y tế',
                'description' => 'Các thiết bị bảo vệ cho nhân viên y tế trong quá trình làm việc, bao gồm khẩu trang, găng tay, áo bảo hộ, kính bảo vệ.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET015',
                'name' => 'Thiết bị hỗ trợ thở',
                'description' => 'Các thiết bị giúp bệnh nhân hô hấp, như máy thở, máy oxy, máy hô hấp nhân tạo.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET016',
                'name' => 'Thiết bị xét nghiệm di động',
                'description' => 'Thiết bị xét nghiệm có thể sử dụng tại các cơ sở ngoài bệnh viện, như máy xét nghiệm nhanh, máy xét nghiệm di động cho bệnh viện lưu động.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'code' => 'ET017',
                'name' => 'Thiết bị kiểm tra và phát hiện bệnh',
                'description' => 'Thiết bị hỗ trợ phát hiện các bệnh lý, ví dụ như máy siêu âm, máy ECG, máy phát hiện ung thư, máy kiểm tra tuyến giáp.',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}