<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\FormRequest;


class LoginClientRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }
}
