<?php

namespace App\Models;

use App\Concerns\BelongsToOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uutkukorkmaz\LaravelStatuses\Concerns\HasStatus;

class Pack extends Model
{
    use BelongsToOrder;
    use HasStatus;
    use HasFactory;

    protected $fillable = [
        'carrier_id'
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
