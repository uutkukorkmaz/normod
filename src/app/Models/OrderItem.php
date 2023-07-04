<?php

namespace App\Models;

use App\Enums\Statuses\OrderStatus;
use App\Utils\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uutkukorkmaz\LaravelStatuses\Concerns\HasStatus;

class OrderItem extends Model
{
    use HasStatus;
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'pack_id',
        'unit_amount',
        'quantity',
        'currency',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'unit_amount' => Currency::class
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function pack(){
        return $this->belongsTo(Pack::class);
    }


}
