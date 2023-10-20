<?php
namespace App\Services\WorkerServices;

use App\Models\Worker;
use App\Http\traits\ApiTrait;
use App\Http\traits\FileTrait;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WorkerRegisterService
{
    use ApiTrait;
    use FileTrait;
    

    public function store($request)
    {

        $image_name = $this->uploadImage(Worker::PATH,$request->image);

        $worker = Worker::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "location" => $request->location,
            "image" => $image_name,
            'password' => bcrypt($request->password)
        ]);

        return $worker->email;
    }

    public function generateToken($email)
    {
        $token = substr(md5(rand(0,9).$email.time()),0,32); 
        $worker = Worker::whereEmail($email)->first();

        $worker->verification_token = $token;
        $worker->save();

        return $worker;
    }

    public function sendEmail($worker)
    {
        Mail::to($worker->email)->send(new VerificationEmail($worker));
    }

    public function register($request)
    {

        DB::transaction(function () use($request) {
            $email = $this->store($request);
            $worker = $this->generateToken($email);
            $this->sendEmail($worker);
        });


        return $this->apiResponse(200,"your Account has Been Created Successfully Please Check Your Email","null","null");
      
    }

}




