<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\OrderItem $resource
 *
 * @OA\Schema(
 *     schema="OrderItemResource",
 *     type="object",
 *     title="Order Item",
 *     @OA\Property(
 *     property="product",
 *      type="object",
 *     description="The order item's product",
 *     ref="#/components/schemas/ProductResource"
 * ),
 *     @OA\Property(
 *     property="quantity",
 *     type="integer",
 *     description="The order item's quantity",
 *     example="1"
 * ),
 *     @OA\Property(
 *     property="subtotal",
 *     type="object",
 *     description="The order item's subtotal",
 *     ref="#/components/schemas/CurrencyResource"
 * ),
 *     @OA\Property(
 *     property="status",
 *     type="string",
 *     description="The order item's status",
 *     example="paid"
 * ),
 *     @OA\Property(
 *     property="packs",
 *     type="object",
 *     description="The order item's pack",
 *     ref="#/components/schemas/PackResource"
 * )
 * )
 *
 */
class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => $this->whenLoaded('product', fn() => ProductResource::make($this->resource->product)),
            'quantity' => $this->resource->quantity,
            'subtotal' => CurrencyResource::make($this->resource->unit_amount->multiply($this->resource->quantity)),
            'status' => $this->resource->status,
            'packs' => $this->whenLoaded('packs', fn() => PackResource::make($this->resource->pack)),
        ];
    }
}
