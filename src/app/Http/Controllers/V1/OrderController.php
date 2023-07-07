<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

class OrderController extends Controller
{

    /**
     *
     * @OA\PathItem(
     *     path="api/v1/customer/orders"
     * )
     *
     * @OA\Get(
     *     path="/api/v1/customer/orders",
     *     tags={"Order"},
     *     summary="Get orders for customer",
     *     description="Get orders for customer",
     *     operationId="getOrdersForCustomer",
     *     @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *       @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/OrderResource")
     *       )
     *   ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              description="The error message",
     *              example="Unauthenticated."
     *          )
     *      )
     *    )
     * )
     *
     * @param Request $request
     * @param OrderService $service
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, OrderService $service)
    {
//        return $service->getOrdersForCustomer($request->user());
        return OrderResource::collection($service->getOrdersForCustomer($request->user()));
    }

    /**
     *
     * @OA\PathItem(
     *     path="api/v1/customer/orders/{order_id}"
     * )
     *
     * @OA\Get(
     *     path="/api/v1/customer/orders/{order_id}",
     *     tags={"Order"},
     *     summary="Get order details for customer",
     *     description="Get order details for customer",
     *     operationId="getOrderDetailsForCustomer",
     *     @OA\Parameter(
     *      name="order_id",
     *     in="path",
     *     description="The order id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer",
     *     format="int64"
     *     ),
     *   ),
     *     @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *          type="object",
     *     @OA\Property(
     *     property="data",
     *     type="object",
     *     ref="#/components/schemas/OrderResource"
     *      )
     *     )
     *    )
     *   )
     * )
     *
     *
     * @param Order $order
     * @param OrderService $service
     * @return OrderResource
     */
    public function show(Order $order, OrderService $service)
    {
        Gate::authorize('view', $order);
        return OrderResource::make($service->getOrderDetails($order));
    }

}
