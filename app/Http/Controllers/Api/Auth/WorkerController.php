<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\{LoginWorkerRequest,RegisterWorkerRequest};
use App\Http\traits\FileTrait;
use App\Models\Worker;
use App\Services\WorkerServices\WorkerLoginService;
use App\Services\WorkerServices\WorkerRegisterService;

class WorkerController extends Controller
{
    use ApiTrait;
    use FileTrait;

    
    public function __construct()
    {
        $this->middleware('auth:worker', ['except' => ['login', 'register','verify']]);
    }

    public function register(RegisterWorkerRequest $request, WorkerRegisterService $workerRegisterService)
    {
        return $workerRegisterService->register($request);
    }

    public function verify($token)
    {
        $worker = Worker::whereVerificationToken($token)->first();
        
        if(!$worker)
        {
            return $this->apiResponse(422,"Your Token Has Been Invalid","null","null");
        }
        
        $worker->verification_token = null;
        $worker->verified_at = now();
        $worker->save();

        return $this->apiResponse(200,"Your Account Has Been Verified","null","null");
        
    }



    public function login(LoginWorkerRequest $request, WorkerLoginService $workerLoginService)
    {
        return $workerLoginService->login($request);
    }

  
    public function refresh()
    {
        return $this->apiResponse(200,'Worker successfully Refresh Token ',"null",auth("worker")->refresh());
    }

 

    public function logout()
    {
        auth("worker")->logout();
        return $this->apiResponse(200,'Worker successfully signed out',"null","null");
    }


}

