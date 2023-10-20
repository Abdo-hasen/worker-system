<?php
namespace App\Repository;

use App\Models\ClientOrder;
use App\Http\traits\ApiTrait;
use App\Interfaces\ClientOrderInterface;
use Illuminate\Support\Facades\Validator;

class ClientOrderRepo implements ClientOrderInterface{

    use ApiTrait;
    
    public function addOrder($request)
    {
        $clientId = auth("client")->id();
        if(ClientOrder::where("client_id",$clientId)->where("post_id", $request->post_id)->exists()){
            return $this->apiResponse(406,"Duplicate Order");
        }
        $post = ClientOrder::create([
            "post_id" => $request->post_id,
            "client_id" => auth("client")->id(),
        ]);

        return $this->apiResponse(200,"Order Has Been Done Successfully","null",$post);
    }

    //list of workers orders
    public function workerOrder()
    {
        $orders = ClientOrder::with("post","client")->whereStatus("pending")->s("post", function ($query)  {
            $query->where("worker_id", auth("worker")->id());
        })->get();


        return $this->apiResponse(200,"Orders has been returned Successfully","null",$orders);
    }

    public function updateStatus($id, $request)
    {
        $validator = Validator::make($request->all(),
        [
            "status" => "required|string|in:approved,rejected"
        ]);

        if($validator->fails()){
            return $this->apiResponse(422,"Validation Error",$validator->errors());
        }

        $order = ClientOrder::findOrfail($id);
        $order->setAttribute("status", $request->status)->save();

        return $this->apiResponse(200,"Status Has Been Updated Successfully","null","null");
    }

    public function approvedOrders()
    {
        $orders = ClientOrder::with('post')->whereStatus('approved')->where('client_id', auth()->guard('client')->id())->get()->makeHidden("status");
        return $this->apiResponse(200,"approved Orders Has Been Returned Successfully","null",$orders);

    }






}

