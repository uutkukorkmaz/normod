<?php

namespace App\Http\Resources;

use App\Contracts\Utils\AbstractCurrency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property AbstractCurrency $resource
 *
 * @OA\Schema(
 *     schema="CurrencyResource",
 *     type="object",
 *     title="Currency",
 *     @OA\Property(
 *     property="amount",
 *     type="integer",
 *     description="The currency's amount",
 *     example="1000"
 *   ),
 *     @OA\Property(
 *     property="currency",
 *     type="object",
 *     description="The currency's information",
 *     @OA\Property(
 *     property="symbol",
 *     type="string",
 *     description="The currency's symbol",
 *     example="$"
 *  ),
 *     @OA\Property(
 *     property="shortname",
 *     type="string",
 *     description="The currency's shortname",
 *     example="USD"
 * ),
 *     @OA\Property(
 *     property="name",
 *     type="string",
 *     description="The currency's name",
 *     example="US Dollar"
 * )
 * ),
 *     @OA\Property(
 *     property="formatted",
 *     type="string",
 *     description="The currency's formatted value",
 *     example="$10.00"
 * )
 * )
 */
class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => (int) $this->resource->getAmount(),
            'currency' => [
                'symbol' => $this->resource->getSymbol(),
                'shortname' => $this->resource->getShortName(),
                'name' => $this->resource->getName()
                ],
            'formatted' => $this->resource->format()
        ];
    }
}
