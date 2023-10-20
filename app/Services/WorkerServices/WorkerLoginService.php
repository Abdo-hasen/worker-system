<?php
namespace App\Services\WorkerServices;

use App\Http\traits\ApiTrait;
use App\Models\Worker;

class WorkerLoginService
{
    use ApiTrait;
    

    public function isAuthenticate($request)
    {
        $credentials = $request->only("email", "password");
        $token = auth("worker")->attempt($credentials);
        return $token;        
    }


    public function isVerified($email)
    {
        $worker = Worker::whereEmail($email)->first();
        $verified = $worker->verified_at;
        return $verified;
    }

    public function getStatus($email)
    {
        $worker = Worker::whereEmail($email)->first();
        $status = $worker->status;
        return $status;

    }


    public function createNewToken($token)
    {
       return $this->apiResponse(200,"Your Login is Successfully","null",$token);
    }






    public function login($request)
    {
     
        if(!$token = $this->isAuthenticate($request))
        {
            return $this->apiResponse(401, "Unauthorized", "null", "null");
        }
        elseif($this->isVerified($request->email) == null)
        {
            return $this->apiResponse(422,"Your Account is Not Verified","null","null");

        }elseif($this->getStatus($request->email) == 0)
       {
         return $this->apiResponse(422,"Your Account is Pending","null","null");
       }

        return $this->createNewToken($token);
    }




}



