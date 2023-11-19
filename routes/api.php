<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AdminDashboard\{AdminNotificationController, PostStatusController};
use App\Http\Controllers\Api\Auth\{AdminController,ClientController,WorkerController};
use App\Http\Controllers\Api\ClientOrderController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\Payment\PaypalController;
use App\Http\Controllers\Api\Worker\WorkerProfileController;
use App\Http\Controllers\Api\WorkerReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Authentication
Route::group([
    "prefix" => "auth", ],function(){
    Route::group([
        'prefix' => 'admin',
        "controller"=> AdminController::class 
    ], function () {
        Route::post('/login', 'login');//b
        Route::post('/register', 'register');
        Route::get('/user_profile', 'userProfile');  
        Route::post('/refresh', 'refresh');
        Route::post('/logout', 'logout');
    });
    
    Route::group([
        'prefix' => 'worker',
        "controller"=> WorkerController::class
    ], function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::get('/verify/{token}', 'verify');        
        Route::post('/refresh', 'refresh');
        Route::post('/logout', 'logout');
    });
    
    Route::group([
        'prefix' => 'clients',
        "controller"=> ClientController::class
    ], function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::get('/user_profile', 'userProfile');    
        Route::post('/refresh', 'refresh');
        Route::post('/logout', 'logout');
    });
});

//posts
Route::prefix("worker/post")->controller(PostController::class)->group(function(){
    Route::post("add","store")->middleware("auth:worker");
    Route::get("all","index")->middleware("auth:admin");
    Route::get("approved","approved");
});


//admin
Route::prefix("admin")
->middleware("auth:admin")
->group(function () {
    
    Route::prefix("notifications")
    ->controller(AdminNotificationController::class)
    ->group(function(){
        Route::get("all","index");
        Route::get("unread","unread");
        Route::post("mark/{id}","mark");
        Route::post("mark-all","markAll");
        Route::delete("delete/{id}","destroy");
        Route::delete("delete-all","destroyAll");
    });

    Route::prefix("post")
    ->controller(PostStatusController::class)
    ->group(function(){
       Route::post("status", "changeStatus");
    });

});

//client
Route::prefix("client")
->group(function(){
    
    Route::prefix("orders")->middleware("auth:client")->controller(ClientOrderController::class)
    ->group(function () {
        Route::post("request-order", "addOrder");
        Route::get('approved-orders', 'approvedOrders');
    });
    
    Route::prefix("paypal")
    ->controller(PaypalController::class)
    ->as("paypal.")
    ->group(function () {
        Route::get('payment/{serviceId}', 'payment')->name('payment');
        Route::get('success/{serviceId}', 'success')->name('success');
        Route::get('cancel', 'cancel')->name('cancel');
    });

});


//client-review
Route::post("client/review-post",[WorkerReviewController::class,"reviewPost"])->middleware("auth:client");

//worker
Route::prefix("worker")->middleware("auth:worker")->group(function(){
    Route::get("pending-posts",[ClientOrderController::class,"workerOrder"]);
    Route::post("update-order-status/{id}",[ClientOrderController::class,"updateStatus"]);
    Route::get("post-rate/{postId}",[WorkerReviewController::class,"postRate"]); 
    Route::get('profile', [WorkerProfileController::class,"profile"]);
    Route::get('edit-profile', [WorkerProfileController::class,"editProfile"]);
    Route::post('update-profile', [WorkerProfileController::class,"updateProfile"]);
    Route::delete('delete-all-posts', [WorkerProfileController::class, 'deleteAll']);
    Route::get('export', [FileController::class, 'export']);
    Route::post('import', [FileController::class, 'import']);
});

//fallback
Route::fallback(function(){
    return response()->json([
        "status" => 404,
        "message" => "Page Not Found. If Error Persists, Please Contact Us",
        "error" => "null",
        "data" => "null"
    ]);
});

