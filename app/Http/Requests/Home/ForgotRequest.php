<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class ForgotRequest extends FormRequest
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
            'phone_forgot' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
        ];
    }
    public function messages(): array{
        return [
            'phone_forgot.required' => 'Số điện thoại không được để trống.',
            'phone_forgot.regex' => 'Số điện thoại không hợp lệ.',
            'phone_forgot.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
        ];
    }
}
