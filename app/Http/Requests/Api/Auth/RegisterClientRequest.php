<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\FormRequest;


class RegisterClientRequest extends FormRequest
{
 
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:3,100',
            'email' => 'required|email|max:100|unique:clients',
            'password' => 'required|string|min:6',
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
