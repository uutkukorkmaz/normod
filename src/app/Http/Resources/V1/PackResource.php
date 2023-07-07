<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\DatetimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Pack $resource
 *
 * @OA\Schema(
 *     schema="PackResource",
 *     type="object",
 *     title="Pack",
 *     @OA\Property(
 *     property="status",
 *     type="string",
 *     description="The pack's status",
 *     example="packed"
 * ),
 *     @OA\Property(
 *     property="carrier",
 *     type="object",
 *     description="The pack's carrier",
 *     ref="#/components/schemas/CarrierResource"
 * ),
 *     @OA\Property(
 *     property="packedAt",
 *     type="object",
 *     description="The pack's packed at",
 *     ref="#/components/schemas/DatetimeResource"
 * )
 * )
 *
 */
class PackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->resource->status,
            'carrier' => $this->whenLoaded('carrier', fn() => CarrierResource::make($this->resource->carrier)),
            'packedAt' => DatetimeResource::make($this->resource->created_at)
        ];
    }
}
