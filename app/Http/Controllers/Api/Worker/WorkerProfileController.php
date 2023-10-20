<?php

namespace App\Http\Controllers\Api\Worker;

use App\Models\Post;
use App\Models\Worker;
use App\Models\WorkerReview;
use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Worker\WorkerUpdatePost;
use App\Services\WorkerServices\WorkerUpdateService;

class WorkerProfileController extends Controller
{
    use ApiTrait;

    public function profile()
    {
        $workerId = auth("worker")->id();//b
        $worker = Worker::with("posts.reviews")->find($workerId)->makeHidden(["status","verification_token","verified_at"]);
        $reviews = WorkerReview::whereIn("post_id",$worker->posts->pluck("id"))->get();//b
        $average = round($reviews->sum("rate") / $reviews->count(),1);
        $data = array_merge($worker->toArray(), ["total_rate"=>$average]);//b

        return $this->apiResponse(200,'Worker Profile',"null",$data);
    }

    public function editProfile()
    {
        return $this->apiResponse(200,"null","null",auth("worker")->user()->makeHidden(["status","verification_token","verified_at"]));
    }

    public function updateProfile(WorkerUpdatePost $request, WorkerUpdateService $worker_service)
    {
      return $worker_service->update($request);
    }

    public function deleteAll()
    {
        Post::where('worker_id', auth()->guard('worker')->id())->delete();
       
        return $this->apiResponse(200,"All Post Deleted Successfully");

    }
  
}

############################
/*
-        $workerId = auth("worker")->id();//b : 

يبقي لما اعوز اجيب حاجه بعلاقتها يعني ب وذ 
ودي ستاتيك فانكشن بتيجي مع موديل نفسه 
فبجيب اي دي 
وبفايند باي دي مع وذ عن طريق فايند (ستاتيك فانكشن)


2- - ليه معملتش علاقه بين ريفيوز و وركر وخليتها مع البوستات ؟
عشان ريفيوز بتبقي مخصصه لكل بوست وليس للوركر عموما 

طب ازاي اجيب ريفيوز بوستس بتاعه وركر ؟ 
مهو ف علاقه بين بوستات ووركر 
فهستغل العلاقه دي وخوصل لريفيوهات بوسستات الوركر 
وبكده يبقي جبت الوركر ببوستاته 
وجبت الريفيوز بتاعاته من خلال بوستات

3-- Worker with : posts.reviews 
بيرجع بوستات بريفيوهات بتاعتها 
يبقي وركر ع علاقه بالبوستس والبوستس ع علاقه بالريفيوز 
vs : 
        ->post with("worker:id,name") : 
هاتلي البوست بالوركر اللي عمله 
وهات من وركر اي دي ونيم 

vs 
           parmeter in filter :  "worker.name", : 
            ادخل ع علاقه وركر وهات نيم 

"يبقي دوت بتاكسيس بيها ع العلاقع كلها او ع بروبيرتي جوا العلاقه "


- يبقي بتعرف لارفيل بالعلاقه لما تكون محتاج تستخدمها 
واللي محتتااج العلاقه بتكتب عنده 


############
-        $reviews = WorkerReview::whereIn("post_id",$worker->posts->pluck("id"))->get();//b  :
wherein: بماتش كولم فاليو باراي اوف فايوز
pluck: بجيب كولم معين من جوا كوليشكن وبرجع كوليكشن بالفليوز دي
للمزيد سنتاكس
############
-        $data = array_merge($worker->toArray(), ["total_rate"=>$average]);//b : 
vs
        // $data = [
        //     "total_rate" => round($average,1),
        //     "date" => $worker
        // ];

- يبقي عايز اخلي الريت مش كي لوحده عايز اخليه تبع الاراي داتا  فهمل اراي ميرج  : 
فهحول اوبجيكت الاراي 
وهخلي الريت الفلوت فاليو ف اراي 
############

############



*/