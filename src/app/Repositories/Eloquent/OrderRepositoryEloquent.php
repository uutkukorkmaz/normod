<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\Statuses\OrderStatus;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepository;
use Prettus\Repository\Eloquent\BaseRepository;

final class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{

    public function model()
    {
        return Order::class;
    }

    public function onlyPaid()
    {
        return $this->where('status', '!=', OrderStatus::PAYMENT_PENDING)->get();
    }


    public function getTotalAmount(Order $order): int
    {
        return $order->items()
                ->select(['unit_amount','quantity'])
                ->get()
                ->map(fn($item) => intval($item->unit_amount->getAmount()) * $item->quantity)->sum();
    }
}
