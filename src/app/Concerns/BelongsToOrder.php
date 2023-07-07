<?php

namespace App\Concerns;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrder
{

    public function initializeBelongsToOrder(): void
    {
        if (!in_array('order_id', $this->fillable)) {
            $this->fillable[] = 'order_id';
        }
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
