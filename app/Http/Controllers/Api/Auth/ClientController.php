<?php
namespace App\Http\Controllers\Api\Auth;

use App\Models\Client;
use App\Http\traits\ApiTrait;
use App\Http\traits\FileTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginClientRequest;
use App\Http\Requests\Api\Auth\RegisterClientRequest;

class ClientController extends Controller
{
    use ApiTrait;
    use FileTrait;

    
    public function __construct()
    {
        $this->middleware('auth:client', ['except' => ['login', 'register']]);
    }

    public function login(LoginClientRequest $request)
    {

        $credentials = $request->only("email", "password");
        if (!$token = auth("client")->attempt($credentials)) { 
            return $this->apiResponse(401, "Unauthorized", "null", "null"); 
        }

        return $this->apiResponse(200,"Client login successfully","null",$token);        
    }

    public function register(RegisterClientRequest $request)
    {

        $image_name = $this->uploadImage(Client::PATH,$request->image);

        $client = Client::create([
            "name" => $request->name,
            "email" => $request->email,
            "image" => $image_name,
            'password' => bcrypt($request->password)]);
            

        return $this->apiResponse(201,'Client successfully registered',"null",$client);

    }


    public function userProfile()
    {
        return $this->apiResponse(200,'Client Profile',"null",auth("client")->user());
    }
  

    public function refresh()
    {
        return $this->apiResponse(200,'Client successfully Refresh Token ',"null",auth("client")->refresh());
    }

 

    public function logout()
    {
        auth("client")->logout();
        return $this->apiResponse(200,'Client successfully signed out',"null","null");
    }


}
