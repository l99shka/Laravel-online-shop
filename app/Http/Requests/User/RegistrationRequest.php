<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => ['required', 'string', 'min:6', 'max:24'],
            'email' => ['required', 'string', 'email', 'unique:users', 'min:6', 'max:24'],
            'phone' => ['required', 'string', 'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/i', 'unique:users'],
            'password' => ['required', 'string', 'confirmed' , 'min:8', 'max:24'],
            'password_confirmation' => ['required']
        ];
    }
}
