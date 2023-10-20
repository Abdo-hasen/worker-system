<?php
namespace App\Http\Controllers\Api\Auth;

use App\Models\Admin;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginAdminRequest;
use App\Http\Requests\Api\Auth\RegisterAdminRequest;

class AdminController extends Controller
{
    use ApiTrait;

    
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);
    }

    public function login(LoginAdminRequest $request)
    {

        $credentials = $request->only("email", "password");

        if (!$token = auth()->attempt($credentials)) { 
            return $this->apiResponse(401, "Unauthorized", "null", "null");
        }

        return $this->apiResponse(200,"Admin login successfully","null",$token);        
    }

    public function register(RegisterAdminRequest $request)
    {
        $admin = Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            'password' => bcrypt($request->password)]);

        return $this->apiResponse(201,'Admin successfully registered',"null",$admin);

    }

  
    public function logout()
    {
        auth()->logout(); 
        return $this->apiResponse(200,'Admin successfully signed out',"null","null");
    }


    public function refresh()
    {
        return $this->apiResponse(200,'Admin successfully Refresh Token ',"null",auth()->refresh());
    }

 
    public function userProfile()
    {
        return $this->apiResponse(200,'Admin Profile',"null",auth()->user());
    }


}


#######################################
/*
- auth()->user() : بيجبلك اللي عامل تسجيل دخول دلوقتي حتي لو في جدول الادمن مش يوزر 

- bec of except added here instead of group parameter

   public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);
    }


    -     to make Token structure - extra
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    - token generated automatically when user authorized successfully = $token = auth()->attempt($credentials) = login
    so logout delete token

       $credentials = $request->only("email", "password");
        if (!$token = auth()->attempt($credentials)) { 
            return $this->apiResponse(401, "Unauthorized", "null", "null");

        }

    - 

*/