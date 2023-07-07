<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\DatetimeResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Utils\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Order $resource
 *
 *@OA\Schema(
 *     schema="OrderResource",
 *     type="object",
 *     title="Order",
 *     @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="The order's id",
 *     example="1"
 *    ),
 *     @OA\Property(
 *     property="invoiceNumber",
 *     type="string",
 *     description="The order's invoice number",
 *     example="INV-20230001"
 *   ),
 *     @OA\Property(
 *     property="status",
 *     type="string",
 *     description="The order's status",
 *     example="paid"
 *  ),
 *     @OA\Property(
 *     property="total",
 *     type="object",
 *     description="The order's total amount",
 *     ref="#/components/schemas/CurrencyResource"
 * ),
 *     @OA\Property(
 *     property="estimatedShippingDate",
 *     type="object",
 *     description="The order's estimated shipping date",
 *     ref="#/components/schemas/DatetimeResource"
 * ),
 *     @OA\Property(
 *     property="addresses",
 *     type="object",
 *     description="The order's addresses",
 *     @OA\Property(
 *     property="shipping",
 *     type="object",
 *     description="The order's shipping address",
 *     ref="#/components/schemas/AddressResource"
 * ),
 *     @OA\Property(
 *     property="billing",
 *     type="object",
 *     description="The order's billing address",
 *     ref="#/components/schemas/AddressResource"
 * )
 * ),
 *     @OA\Property(
 *     property="items",
 *     type="array",
 *     description="The order's items",
 *     @OA\Items(ref="#/components/schemas/OrderItemResource")
 * )
 * )
 *
 *
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'invoiceNumber' => $this->resource->invoice_number,
            'status' => $this->status,
            'total' => CurrencyResource::make(
                app(OrderService::class)->getTotalAmountForResource($this->resource)
            ),
            'estimatedShippingDate' => DatetimeResource::make(
                app(OrderService::class)->getEstimatedShippingDate($this->resource)
            ),
            'addresses' => $this->when($this->areBothAddressesLoaded(), [
                'shipping' => $this->whenLoaded(
                    'shippingAddress',
                    fn() => AddressResource::make($this->resource->shippingAddress)
                ),
                'billing' => $this->whenLoaded(
                    'billingAddress',
                    fn() => AddressResource::make($this->resource->billingAddress)
                ),
            ]),
            'items' => $this->whenLoaded(
                'items',
                fn() => OrderItemResource::collection($this->resource->items)
            ),
            'payments' => $this->whenLoaded(
                'payments',
                fn() => $this->when(
                    !is_null($this->resource->payments),
                    fn() => PaymentResource::collection($this->resource->payments)
                )
            ),
            'packs' => $this->whenLoaded(
                'packs',
                fn() => $this->when(
                    !is_null($this->resource->packs),
                    fn() => PackResource::collection($this->resource->packs)
                )
            ),
            'createdAt' => DatetimeResource::make($this->resource->created_at),
        ];
    }

    private function areBothAddressesLoaded()
    {
        return $this->resource->relationLoaded('shippingAddress') && $this->resource->relationLoaded('billingAddress');
    }
}
