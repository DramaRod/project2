<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => "required|string|max:255",
            'phone'     => "required|numeric|regex:/^09[0-9]{8}/|unique:users,phone",
            'email'     => "required|email:rfc,dns|max:255|unique:users,email",
            'password'  => "required|string|min:6|max:255",
            'c_password'  => "required|string|min:6|max:255|same:password",
            'gender'    => "required|numeric|min:0|max:1",
            ];
    }
}
