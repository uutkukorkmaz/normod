<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'address_line_one',
        'address_line_two',
        'city',
        'state',
        'zip_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
