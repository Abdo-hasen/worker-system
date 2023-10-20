<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\ClientOrderInterface;
use App\Http\Requests\Api\Orders\ClientOrderRequest;

class ClientOrderController extends Controller
{
    use ApiTrait;


    protected $clientOrderInterface;

    public function __construct(ClientOrderInterface $clientOrderInterface)
    {
        $this->clientOrderInterface = $clientOrderInterface;
    }


    public function addOrder(ClientOrderRequest $request)
    {
        return $this->clientOrderInterface->addOrder($request);
    }

    public function workerOrder()
    {
        return $this->clientOrderInterface->workerOrder();
    }


    public function updateStatus($id, Request $request)
    {
        return $this->clientOrderInterface->updateStatus($id, $request);   
    }

    public function approvedOrders()
    {
        return $this->clientOrderInterface->approvedOrders();
    }


}


