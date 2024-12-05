<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class CreateReportRequest extends FormRequest
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
            'file' => 'required|max:2048',
            'content' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File báo cáo không được để trống',
            'file.max' => 'File báo cáo không vượt quá 2MB',
            'content.required' => 'Nội dung báo cáo không được để trống',
        ];
    }
}
