<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\FormRequest;


class RegisterAdminRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:3,100',
            'email' => 'required|email|max:100|unique:admins',
            'password' => 'required|string|min:6',
        ];
    }
}
