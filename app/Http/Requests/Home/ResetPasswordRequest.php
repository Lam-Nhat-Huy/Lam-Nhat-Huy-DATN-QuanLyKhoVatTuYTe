<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'new_password' => 'required|min:6|confirmed',
        ];
    }
    public function messages(): array{
        return [
            'new_password.required' => 'Mật khẩu không được để trống.',
            'new_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Mật khẩu không khớp',
        ];
    }
}
