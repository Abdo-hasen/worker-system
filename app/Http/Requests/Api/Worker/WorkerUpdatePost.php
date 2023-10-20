<?php

namespace App\Http\Requests\Api\Worker;

use App\Http\Requests\Api\FormRequest;

class WorkerUpdatePost extends FormRequest
{
 
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:3,100',
            'email' => 'required|email|max:100|unique:workers,email,' . auth("worker")->id(),
            'password' => 'nullable|string|min:6',//b
            'phone' => 'required|string|max:20',
            'location' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}

##########################
/*
-            'password' => 'nullable|string|min:6',//b : 

يبقي اميدج وباسورد نلابل عشان غالبا دول مبيتغيروش كتير 
فلو مش حابب خلاص 


*/