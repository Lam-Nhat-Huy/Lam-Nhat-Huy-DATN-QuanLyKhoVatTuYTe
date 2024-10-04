<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplierRequest extends FormRequest
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
            "email" => "required|string|email|max:150|unique:suppliers,email",
            "phone" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:10,11",
            "address" => "required|string|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Tên nhà cung cấp không được bỏ trống.",
            "name.string" => "Tên nhà cung cấp phải là kiểu chữ.",
            "name.max" => "Tên nhà cung cấp không được vượt quá 100 ký tự.",

            "contact_name.required" => "Tên người đại diện không được bỏ trống.",
            "contact_name.string" => "Tên người đại diện không đúng định dạng.",
            "contact_name.max" => "Tên người đại diện không được vượt quá 100 ký tự.",

            "tax_code.required" => "Mã số thuế không được bỏ trống.",
            "tax_code.digits_between" => "Mã số thuế phải có độ dài từ 1 đến 13 ký tự.",

            "email.required" => "Email không được bỏ trống.",
            "email.string" => "Email không đúng định dạng.",
            "email.email" => "Email không đúng định dạng.",
            "email.max" => "Email không được vượt quá 150 ký tự.",
            "email.unique" => "Email này đã tồn tại.",

            "phone.required" => "Số điện thoại không được bỏ trống.",
            "phone.regex" => "Số điện thoại phải là số.",
            "phone.digits_between" => "Số điện thoại phải có độ dài từ 10 đến 11 số.",
            
            "address.required" => "Địa chỉ không được bỏ trống.",
            "address.string" => "Địa chỉ không đúng định dạng.",
            "address.max" => "Địa chỉ không được vượt quá 255 ký tự.",
        ];
    }
}
