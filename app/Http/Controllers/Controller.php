<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

 /**
   * @OA\Info(
   *      version="1.0.0",
   *      title="SimpleBlog API Documentation",
   *      description="Implementation of Swagger with in Laravel",
   *      @OA\Contact(
   *          email="admin@admin.com"
   *      ),
   *      @OA\License(
   *          name="Apache 2.0",
   *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
   *      )
   * )
   * 
   *
   * @OA\PathItem(path="/api")
   *
   *
   * @OA\Server(
   *      url=L5_SWAGGER_CONST_HOST,
   *      description="Demo API Server"
   * )

    *
    *
    */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
