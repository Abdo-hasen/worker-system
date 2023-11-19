<?php
namespace App\Services\PostServices;

use App\Http\traits\ApiTrait;
use App\Http\traits\FileTrait;
use App\Models\Admin;
use App\Models\Post;
use App\Models\PostImage;
use App\Notifications\AdminPost;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PostStoreService
{
    use FileTrait;
    use ApiTrait;

    public function adminPercent($price){
        $discount = $price * 0.05 ;
        $priceAfterDiscount = $price - $discount;
        return $priceAfterDiscount;
    }


       public function discount($price){
        $discount = $price * 0.05 ;
        return $discount;
    }

    public function storePost($request)
    {
        $post = Post::create([//b
            "content" => $request->content,
            "price" => $this->adminPercent($request->price),
            "admin_percent" => $this->discount($request->price), 
            "worker_id" => auth("worker")->id(),
        ]);

        return $post;
    }
    
    public function storePostImages($request, $postID)
    {
        $image_name = $this->uploadImage(PostImage::PATH, $request->images);

        PostImage::create([
            "post_id" => $postID,
            "images" => $image_name,
        ]);

    }


    public function sendAdminNotification($post)
    {
        $admins = Admin::get();
        Notification::send($admins, new AdminPost($post, auth("worker")->user()));-facade

    }

    public function store($request)
    {

        try {
            DB::beginTransaction();

                $post = $this->storePost($request);

                if ($request->hasFile("images")){
                    $postImages = $this->storePostImages($request, $post->id);
                }

                $this->sendAdminNotification($post);

            DB::commit();

            return $this->apiResponse(200,"Post Has Been Created Successfully , your Price After Discount is {$post->price}"
            ,"null","null");
                
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

    }

}

