<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    use ApiTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is("api/*")) {
                return $this->apiResponse(404, "Object Not Found");
            }
        });


        $this->renderable(function (RouteNotFoundException $e, Request $request) {
            if ($request->is("api/*")) {
                return $this->apiResponse(401, "Unauthorized");
            }
        });
        

    }

    

  
}
