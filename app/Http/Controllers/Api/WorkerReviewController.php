<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewPostRequest;
use App\Http\traits\ApiTrait;
use App\Models\WorkerReview;
use App\Services\WorkerPostRateService;

class WorkerReviewController extends Controller
{

    use ApiTrait;

    public function reviewPost(ReviewPostRequest $request)
    {
        WorkerReview::create([
            "post_id"=>$request->post_id,
            "client_id"=>auth("client")->id(),
            "comment"=>$request->comment,
            "rate"=>$request->rate
        ]);

        return $this->apiResponse(201,"Review Done successfully");
    }

    public function postRate(WorkerPostRateService $workerRateService, $id)//b
    {
        return $workerRateService->postRate($id);   
    }
}



