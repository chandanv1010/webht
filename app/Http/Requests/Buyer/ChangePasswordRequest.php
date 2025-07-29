<?php

namespace App\Http\Requests\Buyer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|different:old_password',
            're_new_password' => 'required|string|same:new_password',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ.',
            'old_password.string' => 'Mật khẩu cũ phải là dạng chuỗi.',
            'old_password.min' => 'Mật khẩu cũ phải có ít nhất 6 ký tự.',
            'old_password.match' => 'Mật khẩu cũ không chính xác.',

            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.string' => 'Mật khẩu mới phải là dạng chuỗi.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu cũ.',

            're_new_password.required' => 'Vui lòng nhập lại mật khẩu mới.',
            're_new_password.string' => 'Mật khẩu nhập lại phải là dạng chuỗi.',
            're_new_password.same' => 'Mật khẩu nhập lại không khớp với mật khẩu mới.',
        ];
    }

    /**
     * Add additional validation logic after basic validation.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::guard('customer')->user();

            if (!Hash::check($this->input('old_password'), $user->password)) {
                $validator->errors()->add('old_password', 'Mật khẩu cũ không chính xác.');
            }
        });
    }
}
