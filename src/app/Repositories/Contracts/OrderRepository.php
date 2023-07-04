<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderRepository extends RepositoryInterface
{

    public function onlyPaid();

    public function getTotalAmount(Order $order): int;
}
