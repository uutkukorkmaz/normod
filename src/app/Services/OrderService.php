<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepository;
use App\Utils\Currency;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\MissingValue;

class OrderService
{

    public function __construct(protected OrderRepository $orderRepository)
    {
    }

    public function getTotalAmount(Order $order)
    {
        return $this->orderRepository->getTotalAmount($order);
    }

    public function getTotalAmountForResource(Order $order)
    {
        $dominantCurrency = $order->items->countBy('currency')->flip()->first();

        return $order->items->map(function ($item) use ($dominantCurrency) {
            $paidAmount = $item->unit_amount->getAmount() * $item->quantity;
            $currency = Currency::make($item->currency, $paidAmount);
            if ($item->currency != $dominantCurrency) {
                $currency = $currency->convert($dominantCurrency);
            }

            return [
                'amount' => $currency->getAmount(),
                'currency' => $currency->getShortName()
            ];
        })->groupBy('currency')
            ->map(fn($rows) => (int)$rows->pluck('amount')->sum())
            ->map(fn($amount, $currency) => Currency::make($currency, $amount))
            ->first();
    }

    public function getOrdersForCustomer(Authenticatable $user)
    {
        return $this->orderRepository->with([
            'items' => [
                'product',
                'pack'
            ],
            'payments',
        ])->getOrdersByCustomerId($user->getAuthIdentifier());
    }

    public function getEstimatedShippingDate(Order $order): MissingValue|Carbon
    {
        // I would like you to see the problem here
        collect(['packs.carrier', 'items.product'])
            ->each(function ($relation) use (&$order) {
                if (!$order->relationLoaded($relation)) {
                    $order->load($relation);
                }
            });

        if (!$order->packs->count()) {
            return new MissingValue();
        }

        $shippingCompanyBuffer = $order->packs->pluck('carrier.delivery_buffer')->max();
        $productionBuffer = $order->items->pluck('product.production_buffer')->max();

        // should be $order->confirmed_at->modify($sumOfBuffers.' day')
        return $order->created_at->modify(
            sprintf('+%d days', $shippingCompanyBuffer + $productionBuffer + config('order.shipping_buffer'))
        );
    }

    public function getOrderDetails(Order $order)
    {
        // I would like you to see the problem here
        collect(['packs.carrier', 'packs.items', 'items.product','shippingAddress','billingAddress'])
            ->each(function ($relation) use (&$order) {
                if (!$order->relationLoaded($relation)) {
                    $order->load($relation);
                }
            });

        return $order;
    }


}
