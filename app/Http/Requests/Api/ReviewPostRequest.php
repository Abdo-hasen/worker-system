<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;

class ReviewPostRequest extends FormRequest
{
 
    public function rules(): array
    {
        return [
            "post_id"=>"required|integer|exists:posts,id",
            "comment"=>"nullable|string|min:3|max:255",
            "rate"=>"required|integer|max:5"
        ];
    }
}

