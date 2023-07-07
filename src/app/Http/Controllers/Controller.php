<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 *Normod Coding Case Documentation
 *
 * @OA\Info(
 *     version="1.0.0",
 *     title="Documentation",
 *     description="An example study of a order service",
 *     @OA\Contact(
 *     email="uutkukorkmaz@gmail.com",
 *     name="Utku Korkmaz"
 *    )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
