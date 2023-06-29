<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'cost',
        'currency',
        'production_buffer',
    ];

    protected $casts = [
        'price' => \App\Utils\Currency::class,
        'cost' => \App\Utils\Currency::class,
    ];
}
