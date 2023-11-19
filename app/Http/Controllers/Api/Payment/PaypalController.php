<?php

namespace App\Http\Controllers\Api\Payment;

use Exception;
use App\Models\Post;
use App\Models\AdminCash;
use App\Models\WorkerCash;
use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    use ApiTrait;

    public function payment($serviceId)
    {

        $post = Post::findOrfail($serviceId);

        $data = [];
        $data['items'] = [
            [
                'name' => $post->content,
                'price' => $post->price + $post->admin_percent,
            ],

        ];
        $data['invoice_id'] = $post->id;
        $data['invoice_description'] = $post->content;
        $data['return_url'] = route('paypal.success', $serviceId);
        $data['cancel_url'] = route('paypal.cancel');
        $data['total'] = $post->price + $post->admin_percent; 

        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data); 

        return $this->apiResponse(200, "null", "null", $response['paypal_link']);

    }

    public function success(Request $request, $serviceId)
    {
        $post = Post::findOrfail($serviceId);
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            try {
                DB::beginTransaction();
                WorkerCash::create([
                    // "client_id" => Worker::first()->id, to test on web
                    "client_id" => auth("client")->id(),
                    "post_id" => $post->id,
                    "total" => $post->price,
                ]);

                AdminCash::create([
                    "worker_id" => auth("worker")->id(),
                    "post_id" => $post->id,
                    "percent" => $post->admin_percent,
                ]);
                DB::commit();
                return $this->apiResponse(200, "Your payment was successfully");

            } catch (Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }

        }

        return redirect()->route("paypal.cancel");
    }

    public function cancel()
    {
        return $this->apiResponse(500, "Your payment is canceled");

    }
}
