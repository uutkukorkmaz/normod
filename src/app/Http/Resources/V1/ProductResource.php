<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Product $resource
 *
 * @OA\Schema(
 *     schema="ProductResource",
 *     type="object",
 *     title="Product",
 *     @OA\Property(
 *     property="name",
 *     type="string",
 *     description="The product's name",
 *     example="Demo Product 1"
 * ),
 *     @OA\Property(
 *     property="price",
 *     type="object",
 *     description="The product's price",
 *     ref="#/components/schemas/CurrencyResource"
 * )
 * )
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => 'Demo Product '.$this->resource->id,
            'price' => CurrencyResource::make($this->resource->price)
        ];
    }
}
