<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Carrier $resource
 *
 * @OA\Schema(
 *     schema="CarrierResource",
 *     type="object",
 *     title="Carrier",
 *     @OA\Property(
 *     property="name",
 *     type="string",
 *     description="The carrier's name",
 *     example="DHL"
 * ),
 *     @OA\Property(
 *     property="deliveryBuffer",
 *     type="string",
 *     description="The carrier's delivery buffer",
 *     example="3 days"
 * )
 * )
 *
 *
 */
class CarrierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'deliveryBuffer' => sprintf('%s days', $this->resource->delivery_buffer),
        ];
    }
}
