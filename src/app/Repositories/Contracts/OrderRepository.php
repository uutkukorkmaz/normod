<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderRepository extends RepositoryInterface
{

    public function onlyPaid();

    public function getTotalAmount(Order $order): int;

    public function getOrdersByCustomerId(string $customer_id): LengthAwarePaginator;
}
