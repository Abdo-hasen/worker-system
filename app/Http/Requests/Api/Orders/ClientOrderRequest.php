<?php

namespace App\Http\Requests\Api\Orders;

use App\Http\Requests\Api\FormRequest;

class ClientOrderRequest extends FormRequest
{
 
    public function rules(): array
    {
        return [
            "post_id" => "required|integer|exists:posts,id"
        ];
    }
}
