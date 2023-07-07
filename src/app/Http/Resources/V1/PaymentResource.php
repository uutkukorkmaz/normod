<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\DatetimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount' => CurrencyResource::make($this->resource->total_amount),
            'method' => $this->resource->method,
            'createdAt' => DatetimeResource::make($this->resource->created_at)
        ];
    }
}
