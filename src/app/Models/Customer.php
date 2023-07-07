<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;

class Customer extends User
{
    use HasFactory, HasUuids, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isOwenerOf(Model $model)
    {
        if(!array_key_exists('customer_id',$model->attributes)){
            return false;
        }

        return $this->id == $model->customer_id;
    }
}
