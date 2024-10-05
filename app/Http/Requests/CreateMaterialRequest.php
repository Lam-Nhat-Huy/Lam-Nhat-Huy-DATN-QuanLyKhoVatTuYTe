<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMaterialRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'material_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'equipment_type_code' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'supplier_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * Các thông báo lỗi cho từng quy tắc đã định nghĩa.
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên vật tư là bắt buộc.',
            'name.string' => 'Tên vật tư phải là chuỗi ký tự.',
            'name.max' => 'Tên vật tư không được vượt quá 255 ký tự.',

            'material_image.image' => 'Tệp tải lên phải là hình ảnh.',
            'material_image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif hoặc svg.',
            'material_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'equipment_type_code.required' => 'Nhóm vật tư là bắt buộc.',
            'equipment_type_code.string' => 'Nhóm vật tư phải là chuỗi ký tự.',
            'equipment_type_code.max' => 'Nhóm vật tư không được vượt quá 255 ký tự.',

            'unit_code.required' => 'Đơn vị tính là bắt buộc.',
            'unit_code.string' => 'Đơn vị tính phải là chuỗi ký tự.',
            'unit_code.max' => 'Đơn vị tính không được vượt quá 255 ký tự.',

            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',

            'expiry_date.date' => 'Ngày hết hạn không hợp lệ.',

            'supplier_code.required' => 'Nhà cung cấp là bắt buộc.',
            'supplier_code.string' => 'Nhà cung cấp phải là chuỗi ký tự.',
            'supplier_code.max' => 'Nhà cung cấp không được vượt quá 255 ký tự.',

            'country.required' => 'Nước sản xuất là bắt buộc.',
            'country.string' => 'Nước sản xuất phải là chuỗi ký tự.',
            'country.max' => 'Nước sản xuất không được vượt quá 255 ký tự.',
        ];
    }
}