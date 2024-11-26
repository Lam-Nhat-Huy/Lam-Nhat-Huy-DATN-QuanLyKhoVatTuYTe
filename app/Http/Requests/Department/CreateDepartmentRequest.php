<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
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
            "name" => "required|string|max:150",
            "description" => "required|string",
            "location" => "required|string|max:150",
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên phòng ban không được bỏ trống',
            'name.string' => 'Tên phòng ban không đúng định dạng',
            'name.max' => 'Tên phòng ban không được vượt quá 150 ký tự',

            'description.required' => 'Mô tả không được bỏ trống',
            'description.string' => 'Mô tả không đúng định dạng',

            'location.required' => 'Vị trí không được bỏ trống',
            'location.string' => 'Vị trí không đúng định dạng',
            'location.max' => 'Vị trí không được vượt quá 150 ký tự.',
        ];
    }
}