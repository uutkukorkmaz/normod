<?php

namespace App\Models;

use App\Enums\Statuses\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Uutkukorkmaz\LaravelStatuses\Concerns\HasStatus;

class Order extends Model
{
    use HasStatus;
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'shipping_address_id',
        'billing_address_id',
        'invoice_number',
    ];

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public static function boot()
    {
        parent::boot();

        /**
         * DEVELOPER'S NOTE:
         * After the order is invoiced, the invoice number must be obtained from the ERP.
         * This is just for the demonstration.
         */
        self::creating(function ($model) {
            $model->invoice_number = $model->createDemoInvoiceNumber();
        });

        self::updating(function ($model) {
            $model->invoice_number = $model->createDemoInvoiceNumber();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function packs(){
        return $this->hasMany(Pack::class);
    }

    private function createDemoInvoiceNumber()
    {
        if ($this->status == OrderStatus::PAYMENT_PENDING) {
            return null;
        }
        return implode('-', [config('order.invoice_prefix'), strtoupper(uniqid())]);
    }
}
