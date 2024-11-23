<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class CreateEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Xác định xem người dùng có quyền thực hiện request này không.
     */
    public function authorize()
    {
        return true; // Trả về true để cho phép tất cả người dùng
    }

    /**
     * Get the validation rules that apply to the request.
     * Các quy tắc validate sẽ áp dụng cho request này.
     */
    public function rules()
    {
        return [
            'equipment_image' => 'required|mimes:jpg,png,pdf,docx|max:2048',
            'name' => 'required|string|max:255',
            'equipment_type_code' => 'not_in:0|string|max:255',
            'unit_code' => 'not_in:0|string|max:255',
            'vat' => 'required|integer|min:1|max:100',
            'country' => 'not_in:0|string|max:255',
            'description' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * Các thông báo lỗi cho từng quy tắc đã định nghĩa.
     */
    public function messages()
    {
        return [
            'equipment_image.required' => 'Vui lòng thêm ảnh cho thiết bị',
            'equipment_image.mimes' => 'Ảnh không đúng định dạng',
            'equipment_image.max' => 'Ảnh không được quá 2MB',

            'name.required' => 'Tên thiết bị là bắt buộc.',
            'name.string' => 'Tên thiết bị phải là chuỗi ký tự.',
            'name.max' => 'Tên thiết bị không được vượt quá 255 ký tự.',

            'equipment_image.image' => 'Tệp tải lên phải là hình ảnh.',
            'equipment_image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif hoặc svg.',
            'equipment_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'equipment_type_code.not_in' => 'Nhóm thiết bị là bắt buộc.',
            'equipment_type_code.string' => 'Nhóm thiết bị phải là chuỗi ký tự.',
            'equipment_type_code.max' => 'Nhóm thiết bị không được vượt quá 255 ký tự.',

            'unit_code.not_in' => 'Đơn vị tính là bắt buộc.',
            'unit_code.string' => 'Đơn vị tính phải là chuỗi ký tự.',
            'unit_code.max' => 'Đơn vị tính không được vượt quá 255 ký tự.',

            'vat.required' => 'VAT là bắt buộc.',
            'vat.integer' => 'VAT phải là số.',
            'vat.min' => 'VAT phải lớn hơn 0.',
            'vat.max' => 'VAT phải bé hơn hoặc bằng 100.',

            'country.not_in' => 'Nước sản xuất là bắt buộc.',
            'country.string' => 'Nước sản xuất phải là chuỗi ký tự.',
            'country.max' => 'Nước sản xuất không được vượt quá 255 ký tự.',

            'description.required' => 'Mô tả là bắt buộc',
        ];
    }
}
