<?php

namespace App\Http\Controllers\Material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    protected $route = 'material';

    public function index()
    {
        $title = 'Vật Tư';

        $AllMaterial = [
            [
                'id' => 1,
                'material_code' => 'VT001',
                'material_image' => 'https://shopmebauembe.com/wp-content/uploads/2022/07/thucphamsachonline-gon-vien-bach-tuyet-1.jpg', // Placeholder image
                'material_name' => 'Bông y tế',
                'material_type_id' => 'Vật tư tiêu hao',
                'unit_id' => 'Gói',
                'description' => 'Dùng lau rửa vết thương, thấm máu và thấm dịch vùng phẫu thuật',
                'status' => 1,
                'expiry' => 24,
            ],
            [
                'id' => 2,
                'material_code' => 'VT002',
                'material_image' => 'https://duocphamotc.com/wp-content/uploads/2021/09/su-dung-may-do-duong-huyet.jpg', // Placeholder image
                'material_name' => 'Máy đo đường huyết',
                'material_type_id' => 'Thiết bị y tế nhỏ',
                'unit_id' => 'Cái',
                'description' => 'Dùng để đo lường lượng glucose trong máu, giúp bệnh nhân tiểu đường kiểm soát lượng đường huyết của họ',
                'status' => 2,
                'expiry' => 0,
            ],
            [
                'id' => 3,
                'material_code' => 'VT003',
                'material_image' => 'https://inoxnamviet.vn/wp-content/uploads/2019/08/ban-tit.jpg', // Placeholder image
                'material_name' => 'Găng tay y tế',
                'material_type_id' => 'Vật tư tiêu hao',
                'unit_id' => 'Hộp',
                'description' => 'Bảo vệ tay khỏi tiếp xúc trực tiếp với các chất lây nhiễm trong quá trình khám và điều trị.',
                'status' => 1,
                'expiry' => 12,
            ],
            [
                'id' => 4,
                'material_code' => 'VT004',
                'material_image' => 'https://product.hstatic.net/1000236744/product/noi-hap-dung-cu-18-lit_cb3ebf2c37674c8fa85fddf4c83fc183_master.jpg', // Placeholder image
                'material_name' => 'Hộp cứu thương',
                'material_type_id' => 'Dụng cụ y tế',
                'unit_id' => 'Bộ',
                'description' => 'Bao gồm các dụng cụ cần thiết để sơ cứu như bông, băng, kéo, thuốc sát trùng.',
                'status' => 1,
                'expiry' => 0,
            ],
            [
                'id' => 5,
                'material_code' => 'VT005',
                'material_image' => 'https://kimhoangkim.com/wp-content/uploads/Hop-Dung-dung-cu-y-te-7.jpg', // Placeholder image
                'material_name' => 'Nhiệt kế điện tử',
                'material_type_id' => 'Thiết bị y tế nhỏ',
                'unit_id' => 'Cái',
                'description' => 'Dùng để đo nhiệt độ cơ thể nhanh chóng và chính xác.',
                'status' => 1,
                'expiry' => 0,
            ],
            [
                'id' => 6,
                'material_code' => 'VT006',
                'material_image' => 'https://www.hha-smart.com.vn/sites/default/files/1_3.jpg', // Placeholder image
                'material_name' => 'Mặt nạ thở oxy',
                'material_type_id' => 'Thiết bị y tế nhỏ',
                'unit_id' => 'Cái',
                'description' => 'Giúp cung cấp oxy cho bệnh nhân trong trường hợp cấp cứu hoặc điều trị bệnh.',
                'status' => 2,
                'expiry' => 0,
            ],
        ];



        return view("{$this->route}.list", compact('title', 'AllMaterial'));
    }

    public function material_trash()
    {
        $title = 'Vật Tư';

        $AllMaterialTrash = [
            [
                'id' => 1,
                'material_code' => 'VT001',
                'material_image' => 'https://shopmebauembe.com/wp-content/uploads/2022/07/thucphamsachonline-gon-vien-bach-tuyet-1.jpg',
                'material_name' => 'Bông y tế',
                'material_type_id' => 'Vật tư tiêu hao',
                'unit_id' => 'Gói',
                'description' => 'Dùng lau rửa vết thương, thấm máu và thấm dịch vùng phẫu thuật',
                'expiry' => 24,
            ],
            [
                'id' => 2,
                'material_code' => 'VT002',
                'material_image' => 'https://duocphamotc.com/wp-content/uploads/2021/09/su-dung-may-do-duong-huyet.jpg',
                'material_name' => 'Máy đo đường huyết',
                'material_type_id' => 'Thiết bị y tế nhỏ',
                'unit_id' => 'Cái',
                'description' => 'Dùng để đo lường lượng glucose trong máu, giúp bệnh nhân tiểu đường kiểm soát lượng đường huyết của họ',
                'expiry' => 0,
            ],
        ];

        return view("{$this->route}.material_trash", compact('title', 'AllMaterialTrash'));
    }



    public function insert_material()
    {
        $title = 'Vật Tư';

        $title_form = 'Thêm Vật Tư';

        $action = 'create';

        return view("{$this->route}.form_material", compact('title', 'action', 'title_form'));
    }

    public function create_material() {}

    public function update_material()
    {
        $title = 'Vật Tư';

        $title_form = 'Cập Nhật Vật Tư';

        $action = 'update';

        return view("{$this->route}.form_material", compact('title', 'action', 'title_form'));
    }

    public function edit_material() {}

    public function material_group()
    {
        $title = 'Nhóm Vật Tư';

        $AllMaterialGroup = [
            [
                'id' => 1,
                'material_type_code' => 'VT001',
                'material_type_name' => 'Vật tư tiêu hao',
                'description' => 'ABCDEF',
                'status' => 2,
            ],
            [
                'id' => 2,
                'material_type_code' => 'VT002',
                'material_type_name' => 'Thiết bị y tế nhỏ',
                'description' => '123456',
                'status' => 1,
            ],
        ];

        return view("{$this->route}.material_group", compact('title', 'AllMaterialGroup'));
    }

    public function material_group_trash()
    {
        $title = 'Nhóm Vật Tư';

        $AllMaterialGroupTrash = [
            [
                'id' => 1,
                'material_type_code' => 'VT001',
                'material_type_name' => 'Vật tư tiêu hao',
                'description' => 'ABCDEF',
                'status' => 2,
            ],
            [
                'id' => 2,
                'material_type_code' => 'VT002',
                'material_type_name' => 'Thiết bị y tế nhỏ',
                'description' => '123456',
                'status' => 1,
            ],
        ];

        return view("{$this->route}.material_group_trash", compact('title', 'AllMaterialGroupTrash'));
    }

    public function create_material_group() {}

    public function update_material_group()
    {
        $title = 'Nhóm Vật Tư';

        $title_form = 'Cập Nhật Vật Tư';

        $action = 'update';

        return view("{$this->route}.form_material_group", compact('title', 'title_form', 'action'));
    }

    public function edit_material_group() {}
}
