<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Admin Documentation",
     *      description="Admin OpenApi description",
     *      @OA\Contact(
     *          email="antonio@gmail.com"
     *      ),
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Admin API Server"
     * )
     *
     * @OA\SecurityScheme(
     *   securityScheme="bearerAuth",
     *   type="http",
     *   scheme="bearer"
     * )
     */
}
