<?php

namespace App\Http\Controllers\Api\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Posts\PostStatusRequest;
use App\Http\traits\ApiTrait;
use App\Models\Post;
use App\Notifications\AdminPost;
use Illuminate\Support\Facades\Notification;

class PostStatusController extends Controller
{
    use ApiTrait;

    public function changeStatus(PostStatusRequest $request)
    {
        $post = Post::find($request->post_id); 
        $post->update([ 
            "status" => $request->status,
            "rejected_reason" => $request->rejected_reason
        ]);

        Notification::send($post->worker, new AdminPost($post, $post->worker));

        return $this->apiResponse(200,"change Status Done Successfully","null",$post);
    }
}


