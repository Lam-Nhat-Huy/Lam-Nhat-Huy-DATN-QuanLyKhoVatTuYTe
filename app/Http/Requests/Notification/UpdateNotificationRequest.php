<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
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
            'notification_type' => 'not_in:0',
            'content' => 'required',
        ];
    }
    
    public function messages(): array
    {
        return [
            'notification_type.not_in' => 'Vui lòng chọn loại thông báo',
            'content.required' => 'Nội dung thông báo không được để trống',
        ];
    }
}
