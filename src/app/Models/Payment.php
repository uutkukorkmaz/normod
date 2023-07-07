<?php

namespace App\Models;

use App\Concerns\BelongsToOrder;
use App\Enums\PaymentMethod;
use App\Enums\Statuses\PaymentStatus;
use App\Utils\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uutkukorkmaz\LaravelStatuses\Concerns\HasStatus;

class Payment extends Model
{
    use BelongsToOrder;
    use HasStatus;
    use HasFactory;

    protected $fillable = [
        'method',
        'total_amount',
        'currency',
    ];

    protected $casts = [
        'status' => PaymentStatus::class,
        'method' => PaymentMethod::class,
        'total_amount' => Currency::class
    ];
}
