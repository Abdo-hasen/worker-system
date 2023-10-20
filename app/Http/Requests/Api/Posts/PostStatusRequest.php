<?php

namespace App\Http\Requests\Api\Posts;

use App\Http\Requests\Api\FormRequest;


class PostStatusRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            
            "post_id" =>"required|integer|exists:posts,id",
            "status" =>"required|in:approved,rejected", 
            "rejected_reason" =>"required_if:status,rejected|string|min:3", 
        ];
    }
}

