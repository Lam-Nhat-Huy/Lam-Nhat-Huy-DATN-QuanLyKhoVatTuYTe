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

        return view("{$this->route}.index", compact('title', 'AllMaterial'));
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
