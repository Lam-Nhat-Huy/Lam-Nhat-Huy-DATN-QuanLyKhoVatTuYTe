<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|unique:users,phone',
            'password' => 'required|min:6',
            'birth_day' => 'required|date',
            'gender' => 'required|in:Nam,Nữ',
            'address' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg, gif.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',

            'last_name.required' => 'Họ không được để trống.',
            'last_name.string' => 'Họ phải là chuỗi ký tự.',
            'last_name.max' => 'Họ không được vượt quá 50 ký tự.',

            'first_name.required' => 'Tên không được để trống.',
            'first_name.string' => 'Tên phải là chuỗi ký tự.',
            'first_name.max' => 'Tên không được vượt quá 50 ký tự.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'birth_day.required' => 'Ngày sinh không được để trống.',
            'birth_day.date' => 'Ngày sinh phải là định dạng ngày hợp lệ.',

            'gender.required' => 'Giới tính không được để trống.',
            'gender.in' => 'Giới tính phải là Nam hoặc Nữ.',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ];
    }
}
