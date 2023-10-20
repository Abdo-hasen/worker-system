<?php
namespace App\Interfaces;

interface ClientOrderInterface{

    public function addOrder($request);
    public function workerOrder();
    public function updateStatus($id, $request);
    public function approvedOrders();

}