<?php
namespace App\Services\WorkerServices;

use App\Http\traits\ApiTrait;
use App\Http\traits\FileTrait;
use App\Models\Worker;
use Illuminate\Http\UploadedFile;

class WorkerUpdateService{

    use ApiTrait;
    use FileTrait;

    private $model;

    public function __construct()
    {
        $this->model = auth("worker")->user();
    }

    
    public function password($request)
    {
        if(request()->has("password")){
            $password = bcrypt($request->password);
            return $password;
        }

        $password = $this->model->password;
        return $password;
    }

    public function image($request)
    {
        if(request()->file("image") instanceof UploadedFile){
            $image_name = $this->uploadImage(Worker::PATH,$request->image,$this->model->image);
            return $image_name;
        }

        $image_name = $this->model->image;
        return $image_name;
    }


    public function update($request)
    {
      $password = $this->password($request);
      $image_name = $this->image($request);

       $this->model->update([
        "name" => $request->name,
        "email" => $request->email,
        "phone" => $request->phone,
        "location" => $request->location,
        "image" => $image_name,
        'password' => $password,
      ]);

      return $this->apiResponse(200,"ًProfile Has Been Updated Successfully");
    }


}


