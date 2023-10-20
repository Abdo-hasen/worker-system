<?php
namespace App\Services;

use App\Models\WorkerReview;
use App\Http\Resources\WorkerReviewResource;
use App\Http\traits\ApiTrait;

class WorkerPostRateService{

    use ApiTrait;
        
    public function postReviews($id)
    {
        $reviews = WorkerReview::where("post_id",$id);
        return $reviews;

    }
    
    public function average($id)
    {
        $reviews = $this->postReviews($id);
        $average = $reviews->sum("rate") / $reviews->count();
        return $average;
    }

    public function data($average, $id)
    {
        $reviews = $this->postReviews($id);
        $data = [
            "total_price" => round($average,1),
            "data" =>  WorkerReviewResource::collection($reviews->get()) 
        ];
        
        return $data;
    } 

    public function postRate($id)
    {
        $average = $this->average($id);
        $data = $this->data($average,$id);

        return $this->apiResponse(200,"done","null",$data);     

   
    } 
}