<?php

namespace App\Http\Resources\V1;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Address $resource
 *
 * @OA\Schema(
 *     schema="AddressResource",
 *     type="object",
 *     title="Address",
 *     @OA\Property(
 *     property="name",
 *     type="string",
 *     description="The address's name",
 *     example="John Doe"
 *  ),
 *     @OA\Property(
 *     property="address",
 *     type="string",
 *     description="The address's address",
 *     example="123 Main St"
 * ),
 *     @OA\Property(
 *     property="city",
 *     type="string",
 *     description="The address's city",
 *     example="New York"
 * ),
 *     @OA\Property(
 *     property="zipCode",
 *     type="string",
 *     description="The address's zip code",
 *     example="10001"
 * ),
 *     @OA\Property(
 *     property="state",
 *     type="string",
 *     description="The address's state",
 *     example="NY"
 * )
 * )
 *
 */
class AddressResource extends JsonResource
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
            'address' => $this->resource->address_line_one.' '.$this->resource->address_line_two,
            'city' => $this->resource->city,
            'zipCode' => $this->resource->zip_code,
            'state' => $this->resource->state
        ];
    }
}
