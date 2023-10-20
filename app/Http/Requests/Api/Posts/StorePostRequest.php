<?php

namespace App\Http\Requests\Api\Posts;

use App\Http\Requests\Api\FormRequest;


class StorePostRequest extends FormRequest
{



    public function rules(): array
    {
        return [
            "content" =>"required|string|min:3",
            "price" =>"required|numeric",
            "images" =>"nullable|image|mimes:jpg,jpeg,png",
        ];
    }
}
