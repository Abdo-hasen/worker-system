<?php

namespace App\Http\Controllers\Api;

use App\Filters\PostFilter;
use App\Models\Post;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Services\PostServices\PostStoreService;
use App\Http\Requests\Api\Posts\StorePostRequest;

class PostController extends Controller
{
    use ApiTrait;

    public function store(StorePostRequest $request, PostStoreService $postStoreService)
    {
        return $postStoreService->store($request);
    }

    public function index()
    {
        $post= Post::get();

        return $this->apiResponse(200,"All posts Returned Successfully","null", $post);
    }

    public function approved()
    {
        $post =  QueryBuilder::for(Post::class)
        ->allowedFilters((new PostFilter)->filters())
        ->with("worker:id,name")
        ->where("status","approved")
        ->get()
        ->makeHidden(["status","rejected_reason"]);

        return $this->apiResponse(200,"All approved posts Returned Successfully","null", $post);
    }
}

