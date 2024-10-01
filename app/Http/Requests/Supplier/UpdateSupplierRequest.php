<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            "name" => "required|string|max:100",
            "contact_name" => "required|string|max:100",
            "tax_code" => "required|digits_between:1,13",
            'email' => 'required|email|unique:suppliers,email,' . session('supplier_code') . ',code',
            "phone" => "required|digits_between:10,11",
            "address" => "required|string|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Tên không được bỏ trống.",
            "name.string" => "Tên phải là kiểu chữ.",
            "name.max" => "Tên không được vượt quá 100 ký tự.",

            "contact_name.required" => "Tên liên hệ không được bỏ trống.",
            "contact_name.string" => "Tên liên hệ không đúng định dạng.",
            "contact_name.max" => "Tên liên hệ không được vượt quá 100 ký tự.",

            "tax_code.required" => "Mã số thuế không được bỏ trống.",
            "tax_code.digits_between" => "Mã số thuế phải có độ dài từ 1 đến 13 ký tự.",

            "email.required" => "Email không được bỏ trống.",
            "email.email" => "Email không đúng định dạng.",
            "email.max" => "Email không được vượt quá 150 ký tự.",
            "email.unique" => "Email này đã tồn tại.",

            "phone.required" => "Số điện thoại không được bỏ trống.",
            "phone.digits_between" => "Số điện thoại phải có độ dài từ 10 đến 11 số.",

            "address.required" => "Địa chỉ không được bỏ trống.",
            "address.string" => "Địa chỉ không đúng định dạng.",
            "address.max" => "Địa chỉ không được vượt quá 255 ký tự.",
        ];
    }
}
