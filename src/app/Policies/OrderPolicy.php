<?php

namespace App\Policies;

use App\Enums\Statuses\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Auth\Access\Response;


class OrderPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(Customer $customer, Order $order): Response
    {
        return $customer->isOwenerOf($order)
            ? Response::allow()
            : Response::deny('You do not own this order.');
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(Customer $customer, Order $order): Response
    {
        return $customer->isOwenerOf($order) && in_array($order->status, [
                OrderStatus::PAYMENT_PENDING,
                OrderStatus::INVOICED
            ])
            ? Response::allow()
            : Response::deny('You do not own this order.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Customer $customer, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Customer $customer, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Customer $customer, Order $order): bool
    {
        return false;
    }
}
