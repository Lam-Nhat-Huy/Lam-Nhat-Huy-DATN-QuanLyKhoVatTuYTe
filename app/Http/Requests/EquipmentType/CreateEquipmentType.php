<?php

namespace App\Http\Requests\EquipmentType;

use Illuminate\Foundation\Http\FormRequest;

class CreateEquipmentType extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:equipment_types,name'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nhóm thiết bị không được để trống',
            'name.string' => 'Tên nhóm thiết bị phải là chuỗi',
            'name.max' => 'Tên nhóm thiết bị không vượt quá 50 ký tự',
            'name.unique' => 'Tên nhóm thiết bị đã tồn tại',
        ];
    }
}
