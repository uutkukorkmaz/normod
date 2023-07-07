<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property Carbon $resource
 *
 * @OA\Schema(
 *     schema="DatetimeResource",
 *      type="object",
 *     title="Datetime",
 *     @OA\Property(
 *     property="asDatetime",
 *     type="string",
 *     description="The datetime as a string",
 *     example="2021-01-01 00:00:00"
 *  ),
 *     @OA\Property(
 *     property="forHumans",
 *     type="string",
 *     description="The datetime as a human readable string",
 *     example="1 day ago"
 * ),
 *     @OA\Property(
 *     property="isPast",
 *     type="boolean",
 *     description="Whether the datetime is in the past",
 *     example="true"
 * ),
 *     @OA\Property(
 *     property="asUnix",
 *     type="integer",
 *     description="The datetime as a unix timestamp",
 *     example="1609459200"
 * )
 * )
 */
class DatetimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'asDatetime' => $this->resource?->format('Y-m-d H:i:s'),
            'forHumans' => $this->resource?->diffForHumans(),
            'isPast' => $this->resource?->isPast(),
            'asUnix' => $this->resource?->unix(),
        ];
    }
}
