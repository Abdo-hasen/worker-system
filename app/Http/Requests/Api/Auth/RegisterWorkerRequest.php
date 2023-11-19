<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\FormRequest;


class RegisterWorkerRequest extends FormRequest
{
  
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:3,100',
            'email' => 'required|email|max:100|unique:workers',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|min:5',
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
