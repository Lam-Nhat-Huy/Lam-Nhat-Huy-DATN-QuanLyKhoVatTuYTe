<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class CreateUnitRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:units,name'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên đơn vị không được để trống',
            'name.string' => 'Tên đơn vị phải là chuỗi',
            'name.max' => 'Tên đơn vị không vượt quá 50 ký tự',
            'name.unique' => 'Tên đơn vị đã tồn tại',
        ];
    }
}
