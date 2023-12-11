<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'phone' => ['required', 'string', 'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/i'],
            'email' => ['required', 'string', 'email', 'min:6', 'max:24']
        ];
    }
}
